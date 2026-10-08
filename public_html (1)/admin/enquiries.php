<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

// Enquiries live in the site's existing SQLite database (storage/app.sqlite),
// populated by the public Contact and Request Quote forms. This is a
// read(+delete) view only — nothing about that table or those forms changes.
$rows = Database::connection()
    ->query('SELECT * FROM enquiries ORDER BY created_at DESC LIMIT 200')
    ->fetchAll();

$pageTitle = 'Enquiries';
$active = 'enquiries';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <h2>Website enquiries</h2>
    <p class="hint">Submissions from the public Contact and Request Quote forms, most recent first (showing up to 200).</p>

    <?php if ($rows === []): ?>
        <p class="hint">No enquiries yet.</p>
    <?php else: ?>
        <div style="overflow-x:auto">
        <table class="admin-table">
            <thead><tr><th>Date</th><th>Type</th><th>Name</th><th>Company</th><th>Email</th><th>Phone</th><th>Country</th><th>Message</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($rows as $r): ?>
                <tr>
                    <td><?= e($r['created_at']) ?></td>
                    <td><span class="badge"><?= e($r['type']) ?></span></td>
                    <td><?= e($r['name']) ?></td>
                    <td><?= e($r['company'] ?? '') ?></td>
                    <td><a href="mailto:<?= e($r['email']) ?>"><?= e($r['email']) ?></a></td>
                    <td><?= e($r['phone'] ?? '') ?></td>
                    <td><?= e($r['country'] ?? '') ?></td>
                    <td style="max-width:280px; white-space:pre-wrap;"><?= e(mb_strimwidth((string) $r['message'], 0, 200, '…')) ?></td>
                    <td class="actions">
                        <form method="post" action="enquiries-delete.php" style="display:inline" onsubmit="return confirm('Delete this enquiry?');">
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
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
