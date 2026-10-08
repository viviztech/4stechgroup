<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();

$defaults = [
    'about_hero_intro' => '4S Tech Group operates through three legal entities: Foures Tech Technical Services LLC in Dubai, Foures Tech Trading FZE LLC in Ajman, and 4S Tech Engineering in Chennai. Together, the companies provide on-site technical services, engineering, product supply and A-to-Z procurement for industrial construction, marine and shipping, energy, petrochemical, oil & gas, food and agricultural industries across India, the GCC and Africa.',
    'about_mission_para1' => 'We exist to remove the friction from industrial procurement for clients building and operating across India, the Gulf and Africa. Rather than a single-category supplier, we source, quality-check and export across 24 product and service lines — from container houses and prefabricated buildings to GRP water tanks, electrical enclosures, flanges, pumps and valves, cold storage, and general building materials — so a project team can consolidate more of its procurement scope through one relationship instead of managing dozens of separate vendors.',
    'about_mission_para2' => 'We are leaders in serving oil & gas plants, food industries, paper mills, airports, shipyards, chemical plants, steel plants & mills, electrical & electronics industries, computer peripherals, packing industries, agricultural industries and all construction industries.',
];

$values = [];
foreach ($defaults as $key => $default) {
    $values[$key] = Repository::setting($key) ?? $default;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    if ($pdo === null) {
        $errors[] = 'Database unreachable — changes were not saved.';
    } else {
        foreach (array_keys($defaults) as $key) {
            $values[$key] = trim((string) ($_POST[$key] ?? ''));
        }

        foreach ($values as $key => $value) {
            admin_upsert_setting($pdo, $key, $value);
        }

        admin_flash('success', 'Company information saved.');
        header('Location: ' . admin_url('company-info.php'));
        exit;
    }
}

$pageTitle = 'Company Information';
$active = 'company-info';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <h2>About page copy</h2>
    <p class="hint">Edits the hero paragraph and mission text shown on the public About page. Leaving a field empty is not recommended — the About page will show it blank.</p>

    <?php foreach ($errors as $err): ?><div class="admin-flash error"><?= e($err) ?></div><?php endforeach; ?>

    <form method="post" class="admin-form">
        <?= Csrf::field() ?>

        <label>Hero introduction paragraph</label>
        <textarea name="about_hero_intro" rows="4"><?= e($values['about_hero_intro']) ?></textarea>
        <p class="field-hint">Shown directly under the "About 4S Tech Group" heading.</p>

        <label>Mission — paragraph 1</label>
        <textarea name="about_mission_para1" rows="4"><?= e($values['about_mission_para1']) ?></textarea>

        <label>Mission — paragraph 2</label>
        <textarea name="about_mission_para2" rows="3"><?= e($values['about_mission_para2']) ?></textarea>

        <div style="margin-top:22px;">
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
