<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
if ($pdo === null) {
    admin_flash('error', 'Database unreachable.');
    header('Location: ' . admin_url('team.php'));
    exit;
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : (isset($_POST['id']) ? (int) $_POST['id'] : null);
$member = ['id' => null, 'name' => '', 'designation' => '', 'photo_path' => null, 'display_order' => 0, 'is_active' => 1];

if ($id) {
    $stmt = $pdo->prepare('SELECT * FROM team_members WHERE id = ?');
    $stmt->execute([$id]);
    $found = $stmt->fetch();
    if ($found === false) {
        admin_flash('error', 'Team member not found.');
        header('Location: ' . admin_url('team.php'));
        exit;
    }
    $member = $found;
}

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();

    $name = trim((string) ($_POST['name'] ?? ''));
    $designation = trim((string) ($_POST['designation'] ?? ''));
    $displayOrder = (int) ($_POST['display_order'] ?? 0);
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    if ($name === '') $errors[] = 'Name is required.';
    if ($designation === '') $errors[] = 'Designation is required.';

    $photoPath = $member['photo_path'] ?? null;
    if ($errors === []) {
        try {
            $uploaded = admin_handle_image_upload('photo', 'team');
            if ($uploaded !== null) {
                $photoPath = $uploaded;
            }
        } catch (RuntimeException $e) {
            $errors[] = $e->getMessage();
        }
    }

    if ($errors === []) {
        if ($id) {
            $stmt = $pdo->prepare('UPDATE team_members SET name=?, designation=?, photo_path=?, display_order=?, is_active=? WHERE id=?');
            $stmt->execute([$name, $designation, $photoPath, $displayOrder, $isActive, $id]);
            admin_flash('success', 'Team member updated.');
        } else {
            $stmt = $pdo->prepare('INSERT INTO team_members (name, designation, photo_path, display_order, is_active) VALUES (?,?,?,?,?)');
            $stmt->execute([$name, $designation, $photoPath, $displayOrder, $isActive]);
            admin_flash('success', 'Team member added.');
        }
        header('Location: ' . admin_url('team.php'));
        exit;
    }

    $member = array_merge($member, ['name' => $name, 'designation' => $designation, 'photo_path' => $photoPath, 'display_order' => $displayOrder, 'is_active' => $isActive]);
}

$pageTitle = $id ? 'Edit Team Member' : 'Add Team Member';
$active = 'team';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-card">
    <?php foreach ($errors as $err): ?><div class="admin-flash error"><?= e($err) ?></div><?php endforeach; ?>

    <form method="post" class="admin-form" enctype="multipart/form-data">
        <?= Csrf::field() ?>
        <?php if ($id): ?><input type="hidden" name="id" value="<?= (int) $id ?>"><?php endif; ?>

        <div class="row">
            <div><label>Name</label><input type="text" name="name" value="<?= e($member['name']) ?>" required placeholder="e.g. Mr. Asupathi Shanmugasundaram"></div>
            <div><label>Designation</label><input type="text" name="designation" value="<?= e($member['designation']) ?>" required placeholder="e.g. Managing Director"></div>
        </div>

        <?php if (!empty($member['photo_path'])): ?>
            <label>Current photo</label>
            <img class="thumb" style="width:72px;height:72px;" src="<?= e(url($member['photo_path'])) ?>" alt="">
        <?php endif; ?>
        <label>Photo (optional)</label>
        <input type="file" name="photo" accept="image/jpeg,image/png,image/webp">
        <p class="field-hint">JPG, PNG or WEBP, up to 5&nbsp;MB. Leave empty to keep the current photo, or upload one to replace it. No photo is shown if none is provided.</p>

        <div class="row">
            <div><label>Display order</label><input type="number" name="display_order" value="<?= (int) $member['display_order'] ?>"></div>
            <div>
                <label>Visibility</label>
                <label style="font-weight:400; display:flex; align-items:center; gap:8px; margin-top:10px;">
                    <input type="checkbox" name="is_active" value="1" style="width:auto" <?= $member['is_active'] ? 'checked' : '' ?>> Show on public website
                </label>
            </div>
        </div>

        <div style="margin-top:22px; display:flex; gap:10px;">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="team.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
