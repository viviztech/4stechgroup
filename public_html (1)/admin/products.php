<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
$rows = $pdo !== null
    ? $pdo->query('SELECT * FROM products ORDER BY display_order ASC, id ASC')->fetchAll()
    : [];

$pageTitle = 'Products';
$active = 'products';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-actions-bar">
    <p class="hint" style="margin:0">Powers the /products hub and each /products/{slug} detail page.</p>
    <a href="products-edit.php" class="btn btn-primary">+ Add product</a>
</div>

<div class="admin-card">
    <?php if ($pdo === null): ?>
        <div class="admin-flash error">Database unreachable.</div>
    <?php elseif ($rows === []): ?>
        <p class="hint">No products yet. Run <code>php bin/seed.php</code> to import the existing product/service lines, or add one above.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead><tr><th></th><th>Name</th><th>Slug</th><th>Order</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?php if (!empty($r['image_path'])): ?><img class="thumb" src="<?= e(url($r['image_path'])) ?>" alt=""><?php else: ?>&mdash;<?php endif; ?></td>
                    <td><strong><?= e($r['name']) ?></strong></td>
                    <td><code><?= e($r['slug']) ?></code></td>
                    <td><?= (int) $r['display_order'] ?></td>
                    <td class="actions">
                        <a class="btn btn-secondary btn-sm" href="products-edit.php?id=<?= (int) $r['id'] ?>">Edit</a>
                        <form method="post" action="products-delete.php" style="display:inline" onsubmit="return confirm('Delete this product?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
