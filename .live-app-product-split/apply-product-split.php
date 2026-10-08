<?php

declare(strict_types=1);

define('PUBLIC_PATH', '/home/u684481206/domains/lightsalmon-armadillo-357533.hostingersite.com/public_html');
require PUBLIC_PATH . '/src/helpers.php';
require PUBLIC_PATH . '/src/AdminDatabase.php';

$pdo = AdminDatabase::connection();
if (!$pdo instanceof PDO) {
    throw new RuntimeException('Production admin database is unavailable.');
}

$definitions = require __DIR__ . '/staging/public_html/data/products.php';
$imagePaths = [
    'electronics' => '/assets/images/products/electronics/01.webp',
    'computer-peripherals' => '/assets/images/products/computer-peripherals/01.webp',
    'paper-core-end-plugs' => '/assets/images/products/paper-core-end-plugs/01.webp',
    'spares' => '/assets/images/products/spares/01.webp',
];

function encoded(array $value): string
{
    return (string) json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
}

function productValues(array $product, string $imagePath, int $displayOrder): array
{
    return [
        $product['name'],
        $product['short_name'],
        $product['meta_title'] ?? '',
        $product['meta_description'] ?? '',
        $product['primary_keyword'] ?? '',
        encoded($product['keywords'] ?? []),
        $product['intro'] ?? '',
        encoded($product['sections'] ?? []),
        encoded($product['applications'] ?? []),
        encoded($product['related_products'] ?? []),
        encoded($product['related_industries'] ?? []),
        encoded($product['faqs'] ?? []),
        $imagePath,
        $displayOrder,
    ];
}

$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare('SELECT slug, name FROM products WHERE slug IN (?, ?, ?, ?) ORDER BY slug');
    $stmt->execute(['electronics', 'computer-peripherals', 'paper-core-end-plugs', 'spares']);
    $existingBySlug = [];
    foreach ($stmt->fetchAll() as $row) {
        $existingBySlug[$row['slug']] = $row['name'];
    }
    if (($existingBySlug['electronics'] ?? null) !== 'Electronics & Computer Peripherals'
        || ($existingBySlug['paper-core-end-plugs'] ?? null) !== 'Paper Core End Plugs & Spares'
        || isset($existingBySlug['computer-peripherals'])
        || isset($existingBySlug['spares'])) {
        throw new RuntimeException('Production products are not in the expected pre-split state.');
    }

    $pdo->exec('UPDATE products SET display_order = display_order + 1 WHERE display_order > 13');
    $pdo->exec('UPDATE products SET display_order = display_order + 1 WHERE display_order > 25');

    $update = $pdo->prepare(
        'UPDATE products SET name = ?, short_name = ?, meta_title = ?, meta_description = ?, primary_keyword = ?, keywords_json = ?, intro = ?, sections_json = ?, applications_json = ?, related_products_json = ?, related_industries_json = ?, faqs_json = ?, image_path = ?, display_order = ? WHERE slug = ?'
    );
    foreach (['electronics' => 13, 'paper-core-end-plugs' => 25] as $slug => $order) {
        $update->execute([...productValues($definitions[$slug], $imagePaths[$slug], $order), $slug]);
    }

    $insert = $pdo->prepare(
        'INSERT INTO products (slug, name, short_name, meta_title, meta_description, primary_keyword, keywords_json, intro, sections_json, applications_json, related_products_json, related_industries_json, faqs_json, image_path, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)'
    );
    foreach (['computer-peripherals' => 14, 'spares' => 26] as $slug => $order) {
        $insert->execute([$slug, ...productValues($definitions[$slug], $imagePaths[$slug], $order)]);
    }

    $updatedRelationships = 0;
    foreach (['products', 'industries'] as $table) {
        $rows = $pdo->query('SELECT id, related_products_json FROM ' . $table)->fetchAll();
        $updateRelations = $pdo->prepare('UPDATE ' . $table . ' SET related_products_json = ? WHERE id = ?');
        foreach ($rows as $row) {
            $items = json_decode((string) $row['related_products_json'], true);
            if (!is_array($items)) {
                continue;
            }
            $expanded = [];
            foreach ($items as $item) {
                $expanded[] = $item;
                if ($item === 'electronics' && !in_array('computer-peripherals', $items, true)) {
                    $expanded[] = 'computer-peripherals';
                }
                if ($item === 'paper-core-end-plugs' && !in_array('spares', $items, true)) {
                    $expanded[] = 'spares';
                }
            }
            if ($expanded !== $items) {
                $updateRelations->execute([encoded($expanded), $row['id']]);
                $updatedRelationships++;
            }
        }
    }
    if ($updatedRelationships !== 5) {
        throw new RuntimeException('Expected five relationship rows; got ' . $updatedRelationships . '.');
    }

    $setting = $pdo->prepare('UPDATE site_settings SET setting_value = REPLACE(setting_value, ?, ?) WHERE setting_key = ?');
    $setting->execute(['22 product and service lines', '24 product and service lines', 'about_mission_para1']);

    $pdo->commit();
    echo json_encode([
        'product_count' => (int) $pdo->query('SELECT COUNT(*) FROM products')->fetchColumn(),
        'relationship_rows_updated' => $updatedRelationships,
        'count_setting_rows_updated' => $setting->rowCount(),
    ], JSON_PRETTY_PRINT) . PHP_EOL;
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    throw $exception;
}
