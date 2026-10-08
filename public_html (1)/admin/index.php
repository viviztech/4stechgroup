<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
$counts = ['company_info' => 0, 'team_members' => 0, 'industries' => 0, 'products' => 0, 'countries' => 0];
if ($pdo !== null) {
    foreach (array_keys($counts) as $table) {
        $counts[$table] = (int) $pdo->query('SELECT COUNT(*) FROM ' . $table)->fetchColumn();
    }
}

$enquiryCount = (int) Database::connection()->query('SELECT COUNT(*) FROM enquiries')->fetchColumn();
$recentEnquiries = Database::connection()
    ->query('SELECT id, type, name, email, created_at FROM enquiries ORDER BY created_at DESC LIMIT 5')
    ->fetchAll();

$pageTitle = 'Dashboard';
$active = 'dashboard';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-grid">
    <div class="admin-stat"><div class="n"><?= $counts['products'] ?></div><div class="l">Products</div></div>
    <div class="admin-stat"><div class="n"><?= $counts['industries'] ?></div><div class="l">Industries</div></div>
    <div class="admin-stat"><div class="n"><?= $counts['countries'] ?></div><div class="l">Countries</div></div>
    <div class="admin-stat"><div class="n"><?= $counts['team_members'] ?></div><div class="l">Team members</div></div>
    <div class="admin-stat"><div class="n"><?= $counts['company_info'] ?></div><div class="l">Group companies</div></div>
    <div class="admin-stat"><div class="n"><?= $enquiryCount ?></div><div class="l">Enquiries</div></div>
</div>

<div class="admin-card">
    <h2>Welcome</h2>
    <p class="hint">Use the menu on the left to manage the content shown on the public website. Changes save immediately and appear on the live site right away — there is no separate "publish" step.</p>
    <?php if ($pdo === null): ?>
        <div class="admin-flash error">The admin database is currently unreachable — content edits cannot be saved until this is resolved. The public website is unaffected; it will keep using its existing content.</div>
    <?php elseif (array_sum($counts) === 0): ?>
        <div class="admin-flash error">No content has been imported into the admin database yet. Run <code>php bin/seed.php</code> from the project root once to copy the website's existing content in, then refresh this page.</div>
    <?php endif; ?>
</div>

<div class="admin-card">
    <h2>Recent enquiries</h2>
    <p class="hint">The latest 5 submissions from the public Contact and Request Quote forms.</p>
    <?php if ($recentEnquiries === []): ?>
        <p class="hint">No enquiries yet.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead><tr><th>Date</th><th>Type</th><th>Name</th><th>Email</th></tr></thead>
            <tbody>
            <?php foreach ($recentEnquiries as $enq): ?>
                <tr>
                    <td><?= e($enq['created_at']) ?></td>
                    <td><span class="badge"><?= e($enq['type']) ?></span></td>
                    <td><?= e($enq['name']) ?></td>
                    <td><?= e($enq['email']) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <div style="margin-top:14px"><a href="enquiries.php" class="btn btn-secondary btn-sm">View all enquiries &rarr;</a></div>
    <?php endif; ?>
</div>

<div class="admin-card">
    <h2>Quick links</h2>
    <div class="admin-grid" style="margin-bottom:0">
        <a href="company-info.php" class="btn btn-secondary">Company Information</a>
        <a href="company.php" class="btn btn-secondary">Group Companies</a>
        <a href="team.php" class="btn btn-secondary">Team Members</a>
        <a href="products.php" class="btn btn-secondary">Products</a>
        <a href="industries.php" class="btn btn-secondary">Industries</a>
        <a href="countries.php" class="btn btn-secondary">Countries</a>
        <a href="contact-details.php" class="btn btn-secondary">Contact Details</a>
        <a href="seo-settings.php" class="btn btn-secondary">SEO Settings</a>
        <a href="settings.php" class="btn btn-secondary">Settings</a>
    </div>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
