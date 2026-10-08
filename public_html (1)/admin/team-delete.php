<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();
    $pdo = AdminDatabase::connection();
    $id = (int) ($_POST['id'] ?? 0);
    if ($pdo !== null && $id > 0) {
        $stmt = $pdo->prepare('DELETE FROM team_members WHERE id = ?');
        $stmt->execute([$id]);
        admin_flash('success', 'Team member deleted.');
    }
}

header('Location: ' . admin_url('team.php'));
exit;
