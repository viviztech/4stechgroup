<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
$staticConfig = require dirname(__DIR__) . '/config/config.php';

$homeHeroHeadline = Repository::setting('home_hero_headline') ?: 'A-to-Z Engineering Procurement. India · Singapore · GCC · Africa.';
$tagline = Repository::setting('tagline') ?: $staticConfig['tagline'];
$metaDescription = Repository::setting('default_meta_description') ?: $staticConfig['default_meta_description'];
$statsJson = Repository::setting('stats_json');
$stats = $statsJson ? (json_decode($statsJson, true) ?: []) : $staticConfig['stats'];
while (count($stats) < 4) {
    $stats[] = ['value' => '', 'label' => ''];
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    if ($pdo === null) {
        $errors[] = 'Database unreachable — settings were not saved.';
    } else {
        $homeHeroHeadline = trim((string) ($_POST['home_hero_headline'] ?? ''));
        $tagline = trim((string) ($_POST['tagline'] ?? ''));
        $metaDescription = trim((string) ($_POST['default_meta_description'] ?? ''));
        $statValues = $_POST['stat_value'] ?? [];
        $statLabels = $_POST['stat_label'] ?? [];
        $stats = [];
        foreach (array_keys($statValues) as $i) {
            $v = trim((string) $statValues[$i]);
            $l = trim((string) ($statLabels[$i] ?? ''));
            if ($v !== '' || $l !== '') {
                $stats[] = ['value' => $v, 'label' => $l];
            }
        }

        admin_upsert_setting($pdo, 'home_hero_headline', $homeHeroHeadline);
        admin_upsert_setting($pdo, 'tagline', $tagline);
        admin_upsert_setting($pdo, 'default_meta_description', $metaDescription);
        admin_upsert_setting($pdo, 'stats_json', json_encode($stats, JSON_UNESCAPED_UNICODE));

        admin_flash('success', 'Settings saved.');
        header('Location: ' . admin_url('settings.php'));
        exit;
    }
}

$pageTitle = 'Settings';
$active = 'settings';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <h2>Site-wide text</h2>
    <p class="hint">These fields appear across multiple pages of the public website (hero tagline, default SEO description, and the stat counters shown on the About page).</p>

    <?php foreach ($errors as $err): ?><div class="admin-flash error"><?= e($err) ?></div><?php endforeach; ?>

    <form method="post" class="admin-form">
        <?= Csrf::field() ?>

        <label>Homepage headline</label>
        <input type="text" name="home_hero_headline" value="<?= e($homeHeroHeadline) ?>">
        <p class="field-hint">The large heading on the homepage banner (under "Three companies · UAE & India · One group").</p>

        <label>Tagline</label>
        <input type="text" name="tagline" value="<?= e($tagline) ?>">

        <label>Default meta description</label>
        <textarea name="default_meta_description" rows="3"><?= e($metaDescription) ?></textarea>
        <p class="field-hint">Used as the fallback SEO description on pages that don't set their own.</p>

        <label>Stat counters (About page)</label>
        <?php foreach ($stats as $i => $stat): ?>
            <div class="row" style="margin-top:8px">
                <div><input type="text" name="stat_value[]" value="<?= e($stat['value'] ?? '') ?>" placeholder="Value, e.g. 40+"></div>
                <div><input type="text" name="stat_label[]" value="<?= e($stat['label'] ?? '') ?>" placeholder="Label, e.g. Countries Served"></div>
            </div>
        <?php endforeach; ?>

        <div style="margin-top:22px;">
            <button type="submit" class="btn btn-primary">Save settings</button>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
