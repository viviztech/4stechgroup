<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
if ($pdo === null) {
    admin_flash('error', 'Database unreachable.');
    header('Location: ' . admin_url('products.php'));
    exit;
}

/** "Heading :: Body" per line -> [['heading'=>..,'body'=>..], ...] */
function parse_pair_lines(string $raw, string $keyA, string $keyB): array
{
    $out = [];
    foreach (preg_split('/\R/', trim($raw)) ?: [] as $line) {
        $line = trim($line);
        if ($line === '' || !str_contains($line, '::')) {
            continue;
        }
        [$a, $b] = array_map('trim', explode('::', $line, 2));
        if ($a === '') {
            continue;
        }
        $out[] = [$keyA => $a, $keyB => $b];
    }
    return $out;
}

function pair_lines_to_text(array $pairs, string $keyA, string $keyB): string
{
    $lines = [];
    foreach ($pairs as $pair) {
        $lines[] = ($pair[$keyA] ?? '') . ' :: ' . ($pair[$keyB] ?? '');
    }
    return implode("\n", $lines);
}

function list_lines(string $raw): array
{
    return array_values(array_filter(array_map('trim', preg_split('/\R/', trim($raw)) ?: []), static fn ($v) => $v !== ''));
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : null);
$row = [
    'id' => null, 'slug' => '', 'name' => '', 'short_name' => '', 'meta_title' => '', 'meta_description' => '',
    'primary_keyword' => '', 'keywords_json' => '[]', 'intro' => '', 'sections_json' => '[]',
    'applications_json' => '[]', 'related_products_json' => '[]', 'related_industries_json' => '[]',
    'faqs_json' => '[]', 'image_path' => null, 'display_order' => 0,
];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if ($found === false) {
        admin_flash('error', 'Product not found.');
        header('Location: ' . admin_url('products.php'));
        exit;
    }
    $row = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    $slug = strtolower(trim((string) ($_POST['slug'] ?? '')));
    $slug = trim(preg_replace('/[^a-z0-9-]+/', '-', $slug) ?? '', '-');
    $name = trim((string) ($_POST['name'] ?? ''));
    $shortName = trim((string) ($_POST['short_name'] ?? ''));
    $metaTitle = trim((string) ($_POST['meta_title'] ?? ''));
    $metaDescription = trim((string) ($_POST['meta_description'] ?? ''));
    $primaryKeyword = trim((string) ($_POST['primary_keyword'] ?? ''));
    $keywords = list_lines((string) ($_POST['keywords'] ?? ''));
    $intro = trim((string) ($_POST['intro'] ?? ''));
    $sections = parse_pair_lines((string) ($_POST['sections'] ?? ''), 'heading', 'body');
    $applications = list_lines((string) ($_POST['applications'] ?? ''));
    $relatedProducts = list_lines((string) ($_POST['related_products'] ?? ''));
    $relatedIndustries = list_lines((string) ($_POST['related_industries'] ?? ''));
    $faqs = parse_pair_lines((string) ($_POST['faqs'] ?? ''), 'q', 'a');
    $displayOrder = (int) ($_POST['display_order'] ?? 0);

    if ($slug === '') $errors[] = 'Slug is required (letters, numbers and hyphens only).';
    if ($name === '') $errors[] = 'Name is required.';

    if ($errors === []) {
        $dupe = $pdo->prepare('SELECT id FROM products WHERE slug = ? AND id != ?');
        $dupe->execute([$slug, $id ?? 0]);
        if ($dupe->fetch() !== false) {
            $errors[] = 'That slug is already used by another product.';
        }
    }

    $imagePath = $row['image_path'] ?? null;
    if ($errors === []) {
        try {
            $uploaded = admin_handle_image_upload('image', 'products');
            if ($uploaded !== null) {
                $imagePath = $uploaded;
            }
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
        }
    }

    if ($errors === []) {
        $params = [
            $slug, $name, $shortName !== '' ? $shortName : $name, $metaTitle, $metaDescription, $primaryKeyword,
            json_encode($keywords, JSON_UNESCAPED_UNICODE), $intro,
            json_encode($sections, JSON_UNESCAPED_UNICODE), json_encode($applications, JSON_UNESCAPED_UNICODE),
            json_encode($relatedProducts, JSON_UNESCAPED_UNICODE), json_encode($relatedIndustries, JSON_UNESCAPED_UNICODE),
            json_encode($faqs, JSON_UNESCAPED_UNICODE), $imagePath, $displayOrder,
        ];

        if ($id) {
            $stmt = $pdo->prepare(
                'UPDATE products SET slug=?, name=?, short_name=?, meta_title=?, meta_description=?, primary_keyword=?, keywords_json=?, intro=?, sections_json=?, applications_json=?, related_products_json=?, related_industries_json=?, faqs_json=?, image_path=?, display_order=? WHERE id=?'
            );
            $stmt->execute([...$params, $id]);
            admin_flash('success', 'Product updated.');
        } else {
            $stmt = $pdo->prepare(
                'INSERT INTO products (slug, name, short_name, meta_title, meta_description, primary_keyword, keywords_json, intro, sections_json, applications_json, related_products_json, related_industries_json, faqs_json, image_path, display_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
            );
            $stmt->execute($params);
            admin_flash('success', 'Product added.');
        }
        header('Location: ' . admin_url('products.php'));
        exit;
    }

    $row = array_merge($row, [
        'slug' => $slug, 'name' => $name, 'short_name' => $shortName, 'meta_title' => $metaTitle,
        'meta_description' => $metaDescription, 'primary_keyword' => $primaryKeyword,
        'keywords_json' => json_encode($keywords), 'intro' => $intro, 'sections_json' => json_encode($sections),
        'applications_json' => json_encode($applications), 'related_products_json' => json_encode($relatedProducts),
        'related_industries_json' => json_encode($relatedIndustries), 'faqs_json' => json_encode($faqs),
        'image_path' => $imagePath, 'display_order' => $displayOrder,
    ]);
}

$keywordsText = implode("\n", json_decode((string) $row['keywords_json'], true) ?: []);
$sectionsText = pair_lines_to_text(json_decode((string) $row['sections_json'], true) ?: [], 'heading', 'body');
$applicationsText = implode("\n", json_decode((string) $row['applications_json'], true) ?: []);
$relatedProductsText = implode("\n", json_decode((string) $row['related_products_json'], true) ?: []);
$relatedIndustriesText = implode("\n", json_decode((string) $row['related_industries_json'], true) ?: []);
$faqsText = pair_lines_to_text(json_decode((string) $row['faqs_json'], true) ?: [], 'q', 'a');

$pageTitle = $id ? 'Edit Product' : 'Add Product';
$active = 'products';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <?php foreach ($errors as $err): ?><div class="admin-flash error"><?= e($err) ?></div><?php endforeach; ?>

    <form method="post" class="admin-form" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <?php if ($id): ?><input type="hidden" name="id" value="<?= (int) $id ?>"><?php endif; ?>

        <div class="row">
            <div><label>Name</label><input type="text" name="name" value="<?= e($row['name']) ?>" required></div>
            <div><label>Slug (URL path)</label><input type="text" name="slug" value="<?= e($row['slug']) ?>" required placeholder="e.g. flanges-fittings"></div>
        </div>
        <label>Short name (used in menus / footer; defaults to Name)</label>
        <input type="text" name="short_name" value="<?= e($row['short_name'] ?? '') ?>">

        <label>Meta title</label>
        <input type="text" name="meta_title" value="<?= e($row['meta_title'] ?? '') ?>">
        <label>Meta description</label>
        <textarea name="meta_description" rows="2"><?= e($row['meta_description'] ?? '') ?></textarea>
        <div class="row">
            <div><label>Primary keyword</label><input type="text" name="primary_keyword" value="<?= e($row['primary_keyword'] ?? '') ?>"></div>
            <div><label>Keywords (one per line)</label><textarea name="keywords" rows="2"><?= e($keywordsText) ?></textarea></div>
        </div>

        <label>Intro</label>
        <textarea name="intro" rows="3"><?= e($row['intro'] ?? '') ?></textarea>

        <label>Sections</label>
        <textarea name="sections" rows="8"><?= e($sectionsText) ?></textarea>
        <p class="field-hint">One section per line, formatted as <code>Heading :: Body text</code>.</p>

        <label>Applications (one per line)</label>
        <textarea name="applications" rows="4"><?= e($applicationsText) ?></textarea>

        <div class="row">
            <div><label>Related product slugs (one per line)</label><textarea name="related_products" rows="4"><?= e($relatedProductsText) ?></textarea></div>
            <div><label>Related industry slugs (one per line)</label><textarea name="related_industries" rows="4"><?= e($relatedIndustriesText) ?></textarea></div>
        </div>

        <label>FAQs</label>
        <textarea name="faqs" rows="6"><?= e($faqsText) ?></textarea>
        <p class="field-hint">One FAQ per line, formatted as <code>Question :: Answer</code>.</p>

        <?php if (!empty($row['image_path'])): ?>
            <label>Current image</label>
            <img class="thumb" style="width:96px;height:96px;" src="<?= e(url($row['image_path'])) ?>" alt="">
        <?php endif; ?>
        <label>Product image (optional)</label>
        <input type="file" name="image" accept="image/jpeg,image/png,image/webp">
        <p class="field-hint">JPG, PNG or WEBP, up to 5&nbsp;MB. Leave empty to keep the current image.</p>

        <label>Display order</label>
        <input type="number" name="display_order" value="<?= (int) $row['display_order'] ?>" style="max-width:140px">

        <div style="margin-top:22px; display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="products.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
