<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';
AdminAuth::requireLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    admin_verify_csrf();
    $id = (int) ($_POST['id'] ?? 0);
    if ($id > 0) {
        $stmt = Database::connection()->prepare('DELETE FROM enquiries WHERE id = ?');
        $stmt->execute([$id]);
        admin_flash('success', 'Enquiry deleted.');
    }
}

header('Location: ' . admin_url('enquiries.php'));
exit;
