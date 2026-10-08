<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
$rows = $pdo !== null
    ? $pdo->query('SELECT * FROM industries ORDER BY display_order ASC, id ASC')->fetchAll()
    : [];

$pageTitle = 'Industries';
$active = 'industries';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-actions-bar">
    <p class="hint" style="margin:0">Powers the /industries hub and each /industries/{slug} detail page.</p>
    <a href="industries-edit.php" class="btn btn-primary">+ Add industry</a>
</div>

<div class="admin-card">
    <?php if ($pdo === null): ?>
        <div class="admin-flash error">Database unreachable.</div>
    <?php elseif ($rows === []): ?>
        <p class="hint">No industries yet. Run <code>php bin/seed.php</code> to import the existing 12 industries, or add one above.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead><tr><th>Name</th><th>Slug</th><th>Order</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><strong><?= e($r['name']) ?></strong></td>
                    <td><code><?= e($r['slug']) ?></code></td>
                    <td><?= (int) $r['display_order'] ?></td>
                    <td class="actions">
                        <a class="btn btn-secondary btn-sm" href="industries-edit.php?id=<?= (int) $r['id'] ?>">Edit</a>
                        <form method="post" action="industries-delete.php" style="display:inline" onsubmit="return confirm('Delete this industry?');">
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
