<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
if ($pdo === null) {
    admin_flash('error', 'Database unreachable.');
    header('Location: ' . admin_url('industries.php'));
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : null);
$row = ['id' => null, 'slug' => '', 'name' => '', 'meta_title' => '', 'meta_description' => '', 'intro' => '', 'related_products_json' => '[]', 'display_order' => 0];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM industries WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if ($found === false) {
        admin_flash('error', 'Industry not found.');
        header('Location: ' . admin_url('industries.php'));
        exit;
    }
    $row = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    $slug = strtolower(trim((string) ($_POST['slug'] ?? '')));
    $slug = preg_replace('/[^a-z0-9-]+/', '-', $slug) ?? '';
    $slug = trim($slug, '-');
    $name = trim((string) ($_POST['name'] ?? ''));
    $metaTitle = trim((string) ($_POST['meta_title'] ?? ''));
    $metaDescription = trim((string) ($_POST['meta_description'] ?? ''));
    $intro = trim((string) ($_POST['intro'] ?? ''));
    $relatedRaw = trim((string) ($_POST['related_products'] ?? ''));
    $displayOrder = (int) ($_POST['display_order'] ?? 0);

    if ($slug === '') $errors[] = 'Slug is required (letters, numbers and hyphens only).';
    if ($name === '') $errors[] = 'Name is required.';

    if ($errors === []) {
        $dupe = $pdo->prepare('SELECT id FROM industries WHERE slug = ? AND id != ?');
        $dupe->execute([$slug, $id ?? 0]);
        if ($dupe->fetch() !== false) {
            $errors[] = 'That slug is already used by another industry.';
        }
    }

    if ($errors === []) {
        $related = array_values(array_filter(array_map('trim', explode("\n", $relatedRaw)), static fn ($v) => $v !== ''));
        $relatedJson = json_encode($related, JSON_UNESCAPED_UNICODE);

        if ($id) {
            $stmt = $pdo->prepare('UPDATE industries SET slug=?, name=?, meta_title=?, meta_description=?, intro=?, related_products_json=?, display_order=? WHERE id=?');
            $stmt->execute([$slug, $name, $metaTitle, $metaDescription, $intro, $relatedJson, $displayOrder, $id]);
            admin_flash('success', 'Industry updated.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO industries (slug, name, meta_title, meta_description, intro, related_products_json, display_order) VALUES (?,?,?,?,?,?,?)');
            $stmt->execute([$slug, $name, $metaTitle, $metaDescription, $intro, $relatedJson, $displayOrder]);
            admin_flash('success', 'Industry added.');
        }
        header('Location: ' . admin_url('industries.php'));
        exit;
    }

    $row = array_merge($row, [
        'slug' => $slug, 'name' => $name, 'meta_title' => $metaTitle, 'meta_description' => $metaDescription,
        'intro' => $intro, 'display_order' => $displayOrder,
        'related_products_json' => json_encode(array_filter(array_map('trim', explode("\n", $relatedRaw)))),
    ]);
}

$relatedText = implode("\n", json_decode((string) $row['related_products_json'], true) ?: []);

$pageTitle = $id ? 'Edit Industry' : 'Add Industry';
$active = 'industries';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <?php foreach ($errors as $err): ?><div class="admin-flash error"><?= e($err) ?></div><?php endforeach; ?>

    <form method="post" class="admin-form">
        <?= Csrf::field() ?>
        <?php if ($id): ?><input type="hidden" name="id" value="<?= (int) $id ?>"><?php endif; ?>

        <div class="row">
            <div><label>Name</label><input type="text" name="name" value="<?= e($row['name']) ?>" required></div>
            <div><label>Slug (URL path)</label><input type="text" name="slug" value="<?= e($row['slug']) ?>" required placeholder="e.g. oil-and-gas"></div>
        </div>

        <label>Meta title</label>
        <input type="text" name="meta_title" value="<?= e($row['meta_title'] ?? '') ?>">

        <label>Meta description</label>
        <textarea name="meta_description" rows="2"><?= e($row['meta_description'] ?? '') ?></textarea>

        <label>Overview / intro</label>
        <textarea name="intro" rows="8"><?= e($row['intro'] ?? '') ?></textarea>

        <label>Related product slugs (one per line)</label>
        <textarea name="related_products" rows="4"><?= e($relatedText) ?></textarea>
        <p class="field-hint">Use the slugs shown on the Products page, e.g. <code>flanges-fittings</code>, <code>grp-water-tanks</code>.</p>

        <label>Display order</label>
        <input type="number" name="display_order" value="<?= (int) $row['display_order'] ?>" style="max-width:140px">

        <div style="margin-top:22px; display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="industries.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
