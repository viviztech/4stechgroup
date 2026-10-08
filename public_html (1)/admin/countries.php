<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
$rows = $pdo !== null
    ? $pdo->query('SELECT * FROM countries ORDER BY region_group ASC, region_key ASC, display_order ASC, name ASC')->fetchAll()
    : [];

$groups = ['gcc' => [], 'south_asia' => [], 'africa' => []];
foreach ($rows as $r) {
    $groups[$r['region_group']][] = $r;
}
$groupLabels = ['gcc' => 'GCC', 'south_asia' => 'South Asia', 'africa' => 'Africa'];

$pageTitle = 'Countries';
$active = 'countries';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-actions-bar">
    <p class="hint" style="margin:0">Powers the "40+ countries served" listing and the Global Reach pages.</p>
    <a href="countries-edit.php" class="btn btn-primary">+ Add country</a>
</div>

<?php if ($pdo === null): ?>
    <div class="admin-card"><div class="admin-flash error">Database unreachable.</div></div>
<?php elseif ($rows === []): ?>
    <div class="admin-card"><p class="hint">No countries yet. Run <code>php bin/seed.php</code> to import the existing country list, or add one above.</p></div>
<?php else: ?>
    <?php foreach ($groups as $groupKey => $groupRows): ?>
        <?php if ($groupRows === []) continue; ?>
        <div class="admin-card">
            <h2><?= e($groupLabels[$groupKey]) ?> <span class="hint" style="font-weight:400">(<?= count($groupRows) ?>)</span></h2>
            <table class="admin-table">
                <thead><tr><th>Country</th><th>ISO2</th><th>Africa region</th><th>Order</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($groupRows as $r): ?>
                    <tr>
                        <td><?= e($r['name']) ?></td>
                        <td><?= e($r['iso2'] ?? '') ?></td>
                        <td><?= e($r['region_label'] ?? '') ?></td>
                        <td><?= (int) $r['display_order'] ?></td>
                        <td class="actions">
                            <a class="btn btn-secondary btn-sm" href="countries-edit.php?id=<?= (int) $r['id'] ?>">Edit</a>
                            <form method="post" action="countries-delete.php" style="display:inline" onsubmit="return confirm('Delete this country?');">
                                <?= Csrf::field() ?>
                                <input type="hidden" name="id" value="<?= (int) $r['id'] ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
