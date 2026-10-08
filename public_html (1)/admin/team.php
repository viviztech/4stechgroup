<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

$pdo = AdminDatabase::connection();
$members = $pdo !== null
    ? $pdo->query('SELECT * FROM team_members ORDER BY display_order ASC, id ASC')->fetchAll()
    : [];

$pageTitle = 'Team Members';
$active = 'team';
require __DIR__ . '/includes/layout-start.php';
?>

<div class="admin-actions-bar">
    <p class="hint" style="margin:0">Shown in the Team section on the About page, in display-order.</p>
    <a href="team-edit.php" class="btn btn-primary">+ Add team member</a>
</div>

<div class="admin-card">
    <?php if ($pdo === null): ?>
        <div class="admin-flash error">Database unreachable.</div>
    <?php elseif ($members === []): ?>
        <p class="hint">No team members yet. Run <code>php bin/seed.php</code> to import the Managing Director and Projects Manager, or add one above.</p>
    <?php else: ?>
        <table class="admin-table">
            <thead><tr><th></th><th>Name</th><th>Designation</th><th>Order</th><th>Status</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($members as $m): ?>
                <tr>
                    <td><?php if (!empty($m['photo_path'])): ?><img class="thumb" src="<?= e(url($m['photo_path'])) ?>" alt=""><?php else: ?>&mdash;<?php endif; ?></td>
                    <td><strong><?= e($m['name']) ?></strong></td>
                    <td><?= e($m['designation']) ?></td>
                    <td><?= (int) $m['display_order'] ?></td>
                    <td><?= $m['is_active'] ? '<span class="badge">Visible</span>' : '<span class="badge" style="background:#F1F5F9;color:#64748B">Hidden</span>' ?></td>
                    <td class="actions">
                        <a class="btn btn-secondary btn-sm" href="team-edit.php?id=<?= (int) $m['id'] ?>">Edit</a>
                        <form method="post" action="team-delete.php" style="display:inline" onsubmit="return confirm('Delete this team member?');">
                            <?= Csrf::field() ?>
                            <input type="hidden" name="id" value="<?= (int) $m['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php require __DIR__ . '/includes/layout-end.php'; ?>
