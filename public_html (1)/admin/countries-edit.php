<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
if ($pdo === null) {
    admin_flash('error', 'Database unreachable.');
    header('Location: ' . admin_url('countries.php'));
    exit;
}

$africaRegions = [
    'west_central' => 'West & Central Africa',
    'east' => 'East Africa',
    'southern' => 'Southern Africa',
    'north' => 'North Africa',
];

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : null);
$row = ['id' => null, 'name' => '', 'iso2' => '', 'region_group' => 'africa', 'region_key' => 'west_central', 'region_label' => $africaRegions['west_central'], 'market_slug' => '', 'display_order' => 0];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM countries WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if ($found === false) {
        admin_flash('error', 'Country not found.');
        header('Location: ' . admin_url('countries.php'));
        exit;
    }
    $row = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    $name = trim((string) ($_POST['name'] ?? ''));
    $iso2 = strtoupper(trim((string) ($_POST['iso2'] ?? '')));
    $regionGroup = (string) ($_POST['region_group'] ?? 'africa');
    $regionKey = trim((string) ($_POST['region_key'] ?? ''));
    $marketSlug = trim((string) ($_POST['market_slug'] ?? ''));
    $displayOrder = (int) ($_POST['display_order'] ?? 0);

    if ($name === '') $errors[] = 'Country name is required.';
    if (!in_array($regionGroup, ['gcc', 'south_asia', 'africa'], true)) $errors[] = 'Invalid region.';
    $regionLabel = null;
    if ($regionGroup === 'africa') {
        if (!isset($africaRegions[$regionKey])) {
            $errors[] = 'Select a valid Africa sub-region.';
        } else {
            $regionLabel = $africaRegions[$regionKey];
        }
    } else {
        $regionKey = null;
    }

    if ($errors === []) {
        $params = [$name, $iso2 !== '' ? $iso2 : null, $regionGroup, $regionKey, $regionLabel, $marketSlug !== '' ? $marketSlug : null, $displayOrder];
        if ($id) {
            $stmt = $pdo->prepare('UPDATE countries SET name=?, iso2=?, region_group=?, region_key=?, region_label=?, market_slug=?, display_order=? WHERE id=?');
            $stmt->execute([...$params, $id]);
            admin_flash('success', 'Country updated.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO countries (name, iso2, region_group, region_key, region_label, market_slug, display_order) VALUES (?,?,?,?,?,?,?)');
            $stmt->execute($params);
            admin_flash('success', 'Country added.');
        }
        header('Location: ' . admin_url('countries.php'));
        exit;
    }

    $row = array_merge($row, ['name' => $name, 'iso2' => $iso2, 'region_group' => $regionGroup, 'region_key' => $regionKey, 'market_slug' => $marketSlug, 'display_order' => $displayOrder]);
}

$pageTitle = $id ? 'Edit Country' : 'Add Country';
$active = 'countries';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <?php foreach ($errors as $err): ?><div class="admin-flash error"><?= e($err) ?></div><?php endforeach; ?>

    <form method="post" class="admin-form">
        <?= Csrf::field() ?>
        <?php if ($id): ?><input type="hidden" name="id" value="<?= (int) $id ?>"><?php endif; ?>

        <div class="row">
            <div><label>Country name</label><input type="text" name="name" value="<?= e($row['name']) ?>" required></div>
            <div><label>ISO2 code</label><input type="text" name="iso2" maxlength="2" value="<?= e($row['iso2'] ?? '') ?>" placeholder="e.g. NG"></div>
        </div>

        <label>Region</label>
        <select name="region_group" id="region_group" onchange="document.getElementById('africa-fields').style.display = this.value==='africa' ? 'block' : 'none'; document.getElementById('market-slug-field').style.display = this.value!=='africa' ? 'block' : 'none';">
            <option value="gcc" <?= $row['region_group'] === 'gcc' ? 'selected' : '' ?>>GCC</option>
            <option value="south_asia" <?= $row['region_group'] === 'south_asia' ? 'selected' : '' ?>>South Asia</option>
            <option value="africa" <?= $row['region_group'] === 'africa' ? 'selected' : '' ?>>Africa</option>
        </select>

        <div id="africa-fields" style="display: <?= $row['region_group'] === 'africa' ? 'block' : 'none' ?>">
            <label>Africa sub-region</label>
            <select name="region_key">
                <?php foreach ($africaRegions as $key => $label): ?>
                    <option value="<?= e($key) ?>" <?= ($row['region_key'] ?? '') === $key ? 'selected' : '' ?>><?= e($label) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div id="market-slug-field" style="display: <?= $row['region_group'] !== 'africa' ? 'block' : 'none' ?>">
            <label>Market page slug (optional)</label>
            <input type="text" name="market_slug" value="<?= e($row['market_slug'] ?? '') ?>" placeholder="e.g. uae">
            <p class="field-hint">If set, links to /markets/{slug} on the Global Reach page.</p>
        </div>

        <label>Display order</label>
        <input type="number" name="display_order" value="<?= (int) $row['display_order'] ?>" style="max-width:140px">

        <div style="margin-top:22px; display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="countries.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
