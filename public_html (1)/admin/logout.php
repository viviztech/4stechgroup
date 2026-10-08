<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && Csrf::verify($_POST['csrf_token'] ?? null)) {
    AdminAuth::logout();
}

header('Location: ' . admin_url('login.php'));
exit;
