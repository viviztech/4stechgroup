<?php

declare(strict_types=1);

define('PUBLIC_PATH', __DIR__);
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/src/helpers.php';
require __DIR__ . '/src/AdminDatabase.php';

$db = AdminDatabase::connection();
if (!$db instanceof PDO) {
    throw new RuntimeException('Admin database connection unavailable.');
}
if ((int) $db->query("SELECT COUNT(*) FROM products WHERE slug = 'moulds'")->fetchColumn() !== 0) {
    throw new RuntimeException('The product record was expected to be absent at this stage.');
}

$industries = $db->query(
    "SELECT id, slug, related_products_json FROM industries " .
    "WHERE related_products_json LIKE '%\"moulds\"%' ORDER BY id"
)->fetchAll();
$slugs = array_column($industries, 'slug');
sort($slugs);
if ($slugs !== ['electronics', 'packaging']) {
    throw new RuntimeException('Unexpected industry references: ' . json_encode($slugs));
}

$backupDir = dirname(__DIR__) . '/.deploy-backups/mould-removal-20260921-0525';
if (!is_dir($backupDir) && !mkdir($backupDir, 0700, true) && !is_dir($backupDir)) {
    throw new RuntimeException('Could not create backup directory.');
}
$backupPath = $backupDir . '/database-affected-rows.json';
$backup = json_encode(
    ['product_count' => (int) $db->query('SELECT COUNT(*) FROM products')->fetchColumn(), 'industries' => $industries],
    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
);
if ($backup === false || file_put_contents($backupPath, $backup . PHP_EOL) === false) {
    throw new RuntimeException('Could not write database backup.');
}
chmod($backupPath, 0600);

$db->beginTransaction();
try {
    $update = $db->prepare('UPDATE industries SET related_products_json = ? WHERE id = ?');
    foreach ($industries as $industry) {
        $related = json_decode((string) $industry['related_products_json'], true, 512, JSON_THROW_ON_ERROR);
        $filtered = array_values(array_filter($related, static fn ($slug): bool => $slug !== 'moulds'));
        if (count($related) - count($filtered) !== 1) {
            throw new RuntimeException('Expected one reference in industry ' . $industry['slug']);
        }
        $update->execute([json_encode($filtered, JSON_UNESCAPED_SLASHES), $industry['id']]);
    }
    $db->commit();
} catch (Throwable $error) {
    $db->rollBack();
    throw $error;
}

$result = [
    'product_count' => (int) $db->query('SELECT COUNT(*) FROM products')->fetchColumn(),
    'remaining_moulds' => (int) $db->query("SELECT COUNT(*) FROM products WHERE slug = 'moulds'")->fetchColumn(),
    'updated_industries' => count($industries),
    'remaining_industry_references' => (int) $db->query(
        "SELECT COUNT(*) FROM industries WHERE related_products_json LIKE '%\"moulds\"%'"
    )->fetchColumn(),
];
if ($result !== [
    'product_count' => 24,
    'remaining_moulds' => 0,
    'updated_industries' => 2,
    'remaining_industry_references' => 0,
]) {
    throw new RuntimeException('Verification failed: ' . json_encode($result));
}
echo json_encode($result, JSON_UNESCAPED_SLASHES), PHP_EOL;
