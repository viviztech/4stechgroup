<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
if ($pdo === null) {
    admin_flash('error', 'Database unreachable.');
    header('Location: ' . admin_url('company.php'));
    exit;
}

$slug = trim((string) ($_GET['slug'] ?? $_POST['slug'] ?? ''));
$stmt = $pdo->prepare('SELECT * FROM company_info WHERE slug = ?');
$stmt->execute([$slug]);
$company = $stmt->fetch();

if ($company === false) {
    admin_flash('error', 'Company not found.');
    header('Location: ' . admin_url('company.php'));
    exit;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    $legalName = trim((string) ($_POST['legal_name'] ?? ''));
    $shortName = trim((string) ($_POST['short_name'] ?? ''));
    $country = trim((string) ($_POST['country'] ?? ''));
    $countryCode = strtoupper(trim((string) ($_POST['country_code'] ?? '')));
    $addressLine = trim((string) ($_POST['address_line'] ?? ''));
    $locality = trim((string) ($_POST['locality'] ?? ''));
    $region = trim((string) ($_POST['region'] ?? ''));
    $postalCode = trim((string) ($_POST['postal_code'] ?? ''));
    $phone = trim((string) ($_POST['phone'] ?? ''));
    $phoneSecondary = trim((string) ($_POST['phone_secondary'] ?? ''));
    $whatsapp = trim((string) ($_POST['whatsapp'] ?? ''));
    $email = trim((string) ($_POST['email'] ?? ''));
    $focus = trim((string) ($_POST['focus'] ?? ''));
    $description = trim((string) ($_POST['description'] ?? ''));
    $servicesRaw = trim((string) ($_POST['services'] ?? ''));

    if ($legalName === '') $errors[] = 'Legal name is required.';
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email address is not valid.';

    if ($errors === []) {
        $services = array_values(array_filter(array_map('trim', explode("\n", $servicesRaw)), static fn ($v) => $v !== ''));

        $update = $pdo->prepare(
            'UPDATE company_info SET legal_name=?, short_name=?, country=?, country_code=?, address_line=?, locality=?, region=?, postal_code=?, phone=?, phone_secondary=?, whatsapp=?, email=?, focus=?, description=?, services_json=? WHERE slug=?'
        );
        $update->execute([
            $legalName, $shortName, $country, $countryCode, $addressLine, $locality, $region, $postalCode,
            $phone, $phoneSecondary !== '' ? $phoneSecondary : null, $whatsapp, $email, $focus, $description,
            json_encode($services, JSON_UNESCAPED_UNICODE), $slug,
        ]);

        admin_flash('success', 'Company details saved.');
        header('Location: ' . admin_url('company-edit.php?slug=' . urlencode($slug)));
        exit;
    }

    $company = array_merge($company, [
        'legal_name' => $legalName, 'short_name' => $shortName, 'country' => $country, 'country_code' => $countryCode,
        'address_line' => $addressLine, 'locality' => $locality, 'region' => $region, 'postal_code' => $postalCode,
        'phone' => $phone, 'phone_secondary' => $phoneSecondary, 'whatsapp' => $whatsapp, 'email' => $email,
        'focus' => $focus, 'description' => $description, 'services_json' => json_encode(array_filter(array_map('trim', explode("\n", $servicesRaw)))),
    ]);
}

$servicesText = implode("\n", json_decode((string) $company['services_json'], true) ?: []);

$pageTitle = 'Edit: ' . $company['legal_name'];
$active = 'company';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <?php foreach ($errors as $err): ?><div class="admin-flash error"><?= e($err) ?></div><?php endforeach; ?>

    <form method="post" class="admin-form">
        <?= Csrf::field() ?>
        <input type="hidden" name="slug" value="<?= e($slug) ?>">

        <div class="row">
            <div><label>Legal name</label><input type="text" name="legal_name" value="<?= e($company['legal_name']) ?>" required></div>
            <div><label>Short name</label><input type="text" name="short_name" value="<?= e($company['short_name']) ?>"></div>
        </div>

        <div class="row-3">
            <div><label>Country</label><input type="text" name="country" value="<?= e($company['country']) ?>"></div>
            <div><label>Country code (ISO2)</label><input type="text" name="country_code" maxlength="2" value="<?= e($company['country_code']) ?>"></div>
            <div><label>Postal code</label><input type="text" name="postal_code" value="<?= e($company['postal_code'] ?? '') ?>"></div>
        </div>

        <label>Address line</label>
        <input type="text" name="address_line" value="<?= e($company['address_line']) ?>">

        <div class="row">
            <div><label>Locality (city)</label><input type="text" name="locality" value="<?= e($company['locality']) ?>"></div>
            <div><label>Region / state</label><input type="text" name="region" value="<?= e($company['region']) ?>"></div>
        </div>

        <div class="row-3">
            <div><label>Phone</label><input type="tel" name="phone" value="<?= e($company['phone']) ?>"></div>
            <div><label>Secondary phone (optional)</label><input type="tel" name="phone_secondary" value="<?= e($company['phone_secondary'] ?? '') ?>"></div>
            <div><label>WhatsApp number</label><input type="tel" name="whatsapp" value="<?= e($company['whatsapp']) ?>"></div>
        </div>

        <label>Email</label>
        <input type="email" name="email" value="<?= e($company['email']) ?>">

        <label>Focus (short tagline)</label>
        <input type="text" name="focus" value="<?= e($company['focus'] ?? '') ?>">

        <label>Description / overview</label>
        <textarea name="description" rows="4"><?= e($company['description'] ?? '') ?></textarea>
        <p class="field-hint">Shown on the About and Group Companies pages.</p>

        <label>Services (one per line)</label>
        <textarea name="services" rows="5"><?= e($servicesText) ?></textarea>
        <p class="field-hint">Shown as the service list on the Company Detail page.</p>

        <div style="margin-top:22px; display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="company.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
