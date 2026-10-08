<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
$companies = $pdo !== null
    ? $pdo->query('SELECT id, slug, legal_name, phone, phone_secondary, whatsapp, email, address_line FROM company_info ORDER BY display_order ASC, id ASC')->fetchAll()
    : [];

$pageTitle = 'Contact Details';
$active = 'contact-details';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <h2>Contact details per company</h2>
    <p class="hint">Phone, WhatsApp, email and address shown on the Contact page and in the footer, for each group company. This is the same underlying data as Group Companies — edit here for a quick contact-only view, or use Group Companies for the full profile.</p>

    <?php if ($pdo === null): ?>
        <div class="admin-flash error">Database unreachable.</div>
    <?php elseif ($companies === []): ?>
        <p class="hint">No companies found yet. Run <code>php bin/seed.php</code> to import the existing company data first.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead><tr><th>Company</th><th>Phone</th><th>WhatsApp</th><th>Email</th><th>Address</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($companies as $c): ?>
                <tr>
                    <td><strong><?= e($c['legal_name']) ?></strong></td>
                    <td><?= e($c['phone']) ?><?= !empty($c['phone_secondary']) ? '<br>' . e($c['phone_secondary']) : '' ?></td>
                    <td><?= e($c['whatsapp']) ?></td>
                    <td><?= e($c['email']) ?></td>
                    <td><?= e($c['address_line']) ?></td>
                    <td class="actions"><a class="btn btn-secondary btn-sm" href="contact-details-edit.php?id=<?= (int) $c['id'] ?>">Edit</a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
