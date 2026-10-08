<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
if ($pdo === null) {
    admin_flash('error', 'Database unreachable.');
    header('Location: ' . admin_url('contact-details.php'));
    exit;
}

$id = (int) ($_GET['id'] ?? $_POST['id'] ?? 0);
$stmt = $pdo->prepare('SELECT * FROM company_info WHERE id = ?');
$stmt->execute([$id]);
$company = $stmt->fetch();

if ($company === false) {
    admin_flash('error', 'Company not found.');
    header('Location: ' . admin_url('contact-details.php'));
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    $phone = trim((string) ($_POST['phone'] ?? ''));
    $phoneSecondary = trim((string) ($_POST['phone_secondary'] ?? ''));
    $whatsapp = trim((string) ($_POST['whatsapp'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $addressLine = trim((string) ($_POST['address_line'] ?? ''));

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Email address is not valid.';
    }

    if ($errors === []) {
        $update = $pdo->prepare('UPDATE company_info SET phone=?, phone_secondary=?, whatsapp=?, email=?, address_line=? WHERE id=?');
        $update->execute([$phone, $phoneSecondary !== '' ? $phoneSecondary : null, $whatsapp, $email, $addressLine, $id]);

        admin_flash('success', 'Contact details saved.');
        header('Location: ' . admin_url('contact-details.php'));
        exit;
    }

    $company = array_merge($company, [
        'phone' => $phone, 'phone_secondary' => $phoneSecondary, 'whatsapp' => $whatsapp,
        'email' => $email, 'address_line' => $addressLine,
    ]);
}

$pageTitle = 'Edit Contact Details: ' . $company['legal_name'];
$active = 'contact-details';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <?php foreach ($errors as $err): ?><div class="admin-flash error"><?= e($err) ?></div><?php endforeach; ?>

    <form method="post" class="admin-form">
        <?= Csrf::field() ?>
        <input type="hidden" name="id" value="<?= (int) $id ?>">

        <div class="row">
            <div><label>Phone</label><input type="tel" name="phone" value="<?= e($company['phone']) ?>"></div>
            <div><label>Secondary phone (optional)</label><input type="tel" name="phone_secondary" value="<?= e($company['phone_secondary'] ?? '') ?>"></div>
        </div>
        <label>WhatsApp number</label>
        <input type="tel" name="whatsapp" value="<?= e($company['whatsapp']) ?>">
        <label>Email</label>
        <input type="email" name="email" value="<?= e($company['email']) ?>">
        <label>Address</label>
        <input type="text" name="address_line" value="<?= e($company['address_line']) ?>">

        <div style="margin-top:22px; display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="contact-details.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
