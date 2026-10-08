<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

if (AdminAuth::check()) {
    header('Location: ' . admin_url('index.php'));
    exit;
}

$error = null;
$dbAvailable = AdminDatabase::isAvailable();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
        $error = 'Your session expired. Please try again.';
    } elseif (!$dbAvailable) {
        $error = 'The admin database is not reachable. Check that the storage/ directory is writable.';
    } else {
        $username = trim((string) ($_POST['username'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');
        if ($username === '' || $password === '') {
            $error = 'Enter both username and password.';
        } elseif (AdminAuth::attempt($username, $password)) {
            header('Location: ' . admin_url('index.php'));
            exit;
        } else {
            $error = 'Incorrect username or password.';
        }
    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login · <?= e(config('site_name_short')) ?></title>
    <link rel="icon" href="<?= e(asset('images/4s-tech-logo.png')) ?>" type="image/png">
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="admin">
<div class="login-wrap">
    <div class="login-card">
        <img src="<?= e(asset('images/4s-tech-logo.png')) ?>" alt="<?= e(config('site_name_short')) ?>" class="login-logo">
        <h1>Admin</h1>
        <p class="sub">Sign in to manage site content.</p>

        <?php if (!$dbAvailable): ?>
            <div class="admin-flash error">The admin database is not reachable. Check that the storage/ directory is writable, then run <code>php bin/seed.php</code> once to create the schema and an admin account.</div>
        <?php elseif ($error !== null): ?>
            <div class="admin-flash error"><?= e($error) ?></div>
        <?php endif; ?>

        <form method="post" class="admin-form">
            <?= Csrf::field() ?>
            <label for="username">Username</label>
            <input type="text" id="username" name="username" autocomplete="username" required autofocus>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" autocomplete="current-password" required>

            <button type="submit" class="btn btn-primary" style="width:100%;margin-top:20px;">Log in</button>
        </form>
    </div>
</div>
</body>
</html>
