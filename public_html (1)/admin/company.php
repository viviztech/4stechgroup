<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
$companies = $pdo !== null
    ? $pdo->query('SELECT * FROM company_info ORDER BY display_order ASC, id ASC')->fetchAll()
    : [];

$pageTitle = 'Company Information';
$active = 'company';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <h2>Group companies</h2>
    <p class="hint">Edit the introduction, overview and contact details shown for each company on the About, Group Companies and Company Detail pages.</p>

    <?php if ($pdo === null): ?>
        <div class="admin-flash error">Database unreachable.</div>
    <?php elseif ($companies === []): ?>
        <div class="admin-flash error">No companies found yet. Run <code>php bin/seed.php</code> to import the existing company data first.</div>
    <?php else: ?>
        <table class="admin-table">
            <thead><tr><th>Legal name</th><th>Country</th><th>Focus</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($companies as $c): ?>
                <tr>
                    <td><strong><?= e($c['legal_name']) ?></strong><br><span style="color:var(--muted)"><?= e($c['short_name']) ?></span></td>
                    <td><?= e($c['country']) ?></td>
                    <td><?= e($c['focus']) ?></td>
                    <td class="actions"><a class="btn btn-secondary btn-sm" href="company-edit.php?slug=<?= urlencode($c['slug']) ?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
