<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
if ($pdo === null) {
    admin_flash('error', 'Database unreachable.');
    header('Location: ' . admin_url('seo-settings.php'));
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : null);
$row = ['id' => null, 'path' => '', 'meta_title' => '', 'meta_description' => ''];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM seo_overrides WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if ($found === false) {
        admin_flash('error', 'Override not found.');
        header('Location: ' . admin_url('seo-settings.php'));
        exit;
    }
    $row = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    $path = trim((string) ($_POST['path'] ?? ''));
    $path = '/' . ltrim($path, '/');
    $metaTitle = trim((string) ($_POST['meta_title'] ?? ''));
    $metaDescription = trim((string) ($_POST['meta_description'] ?? ''));

    if ($path === '/' && trim((string) ($_POST['path'] ?? '')) === '') {
        $errors[] = 'Page path is required, e.g. /about or /products/flanges-fittings.';
    }
    if ($metaTitle === '' && $metaDescription === '') {
        $errors[] = 'Enter at least a meta title or a meta description.';
    }

    if ($errors === []) {
        $dupe = $pdo->prepare('SELECT id FROM seo_overrides WHERE path = ? AND id != ?');
        $dupe->execute([$path, $id ?? 0]);
        if ($dupe->fetch() !== false) {
            $errors[] = 'An override for that path already exists.';
        }
    }

    if ($errors === []) {
        if ($id) {
            $stmt = $pdo->prepare('UPDATE seo_overrides SET path=?, meta_title=?, meta_description=? WHERE id=?');
            $stmt->execute([$path, $metaTitle ?: null, $metaDescription ?: null, $id]);
            admin_flash('success', 'SEO override updated.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO seo_overrides (path, meta_title, meta_description) VALUES (?,?,?)');
            $stmt->execute([$path, $metaTitle ?: null, $metaDescription ?: null]);
            admin_flash('success', 'SEO override added.');
        }
        header('Location: ' . admin_url('seo-settings.php'));
        exit;
    }

    $row = array_merge($row, ['path' => $path, 'meta_title' => $metaTitle, 'meta_description' => $metaDescription]);
}

$pageTitle = $id ? 'Edit SEO Override' : 'Add SEO Override';
$active = 'seo-settings';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <?php foreach ($errors as $err): ?><div class="admin-flash error"><?= e($err) ?></div><?php endforeach; ?>

    <form method="post" class="admin-form">
        <?= Csrf::field() ?>
        <?php if ($id): ?><input type="hidden" name="id" value="<?= (int) $id ?>"><?php endif; ?>

        <label>Page path</label>
        <input type="text" name="path" value="<?= e($row['path']) ?>" required placeholder="/about or /products/flanges-fittings">
        <p class="field-hint">Must match the page's URL exactly, e.g. <code>/</code> for the homepage, <code>/products/flanges-fittings</code> for a product page.</p>

        <label>Meta title (optional)</label>
        <input type="text" name="meta_title" value="<?= e($row['meta_title'] ?? '') ?>">

        <label>Meta description (optional)</label>
        <textarea name="meta_description" rows="3"><?= e($row['meta_description'] ?? '') ?></textarea>

        <div style="margin-top:22px; display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="seo-settings.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
