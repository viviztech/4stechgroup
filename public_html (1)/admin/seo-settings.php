<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
$rows = $pdo !== null
    ? $pdo->query('SELECT * FROM seo_overrides ORDER BY path ASC')->fetchAll()
    : [];

$pageTitle = 'SEO Settings';
$active = 'seo-settings';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-actions-bar">
    <p class="hint" style="margin:0">Overrides the title/meta description for a specific page path. A page keeps its original SEO text until you add an override for its path here.</p>
    <a href="seo-settings-edit.php" class="btn btn-primary">+ Add override</a>
</div>

<div class="admin-card">
    <?php if ($pdo === null): ?>
        <div class="admin-flash error">Database unreachable.</div>
    <?php elseif ($rows === []): ?>
        <p class="hint">No SEO overrides yet — every page is using its original built-in title and meta description.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead><tr><th>Path</th><th>Meta title</th><th>Meta description</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><code><?= e($r['path']) ?></code></td>
                    <td><?= e($r['meta_title'] ?? '') ?></td>
                    <td><?= e(mb_strimwidth((string) ($r['meta_description'] ?? ''), 0, 90, '…')) ?></td>
                    <td class="actions">
                        <a class="btn btn-secondary btn-sm" href="seo-settings-edit.php?id=<?= (int) $r['id'] ?>">Edit</a>
                        <form method="post" action="seo-settings-delete.php" style="display:inline" onsubmit="return confirm('Remove this override? The page will go back to its original title/description.');">
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
