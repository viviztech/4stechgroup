<?php

declare(strict_types=1);

/**
 * Opens the admin HTML shell + sidebar. Call after AdminAuth::requireLogin().
 * $pageTitle: string shown in <title> and the top bar.
 * $active: nav key to highlight — one of dashboard|company-info|company|team|
 * products|industries|countries|contact-details|enquiries|seo-settings|settings.
 */
$pageTitle = $pageTitle ?? 'Admin';
$active = $active ?? '';
$navItems = [
    'dashboard' => ['Dashboard', 'index.php'],
    'company-info' => ['Company Information', 'company-info.php'],
    'company' => ['Group Companies', 'company.php'],
    'team' => ['Team Members', 'team.php'],
    'products' => ['Products', 'products.php'],
    'industries' => ['Industries', 'industries.php'],
    'countries' => ['Countries', 'countries.php'],
    'contact-details' => ['Contact Details', 'contact-details.php'],
    'enquiries' => ['Enquiries', 'enquiries.php'],
    'seo-settings' => ['SEO Settings', 'seo-settings.php'],
    'settings' => ['Settings', 'settings.php'],
];
$flash = admin_flash_get();
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($pageTitle) ?> · Admin · <?= e(config('site_name_short')) ?></title>
    <link rel="icon" href="<?= e(asset('images/4s-tech-logo.png')) ?>" type="image/png">
    <link rel="stylesheet" href="assets/admin.css">
</head>
<body class="admin">
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="brand">
            <img src="<?= e(asset('images/4s-tech-logo.png')) ?>" alt="<?= e(config('site_name_short')) ?>" class="brand-logo">
            <small>Admin Panel</small>
        </div>
        <nav class="admin-nav">
            <?php foreach ($navItems as $key => [$label, $href]): ?>
                <a href="<?= e($href) ?>" class="<?= $active === $key ? 'active' : '' ?>"><?= e($label) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="logout-form">
            <form method="post" action="logout.php">
                <?= Csrf::field() ?>
                <button type="submit" class="logout-btn">Log out</button>
            </form>
        </div>
    </aside>
    <main class="admin-main">
        <div class="admin-topbar">
            <h1><?= e($pageTitle) ?></h1>
            <div class="who">Signed in as <strong><?= e(AdminAuth::user()['username'] ?? '') ?></strong> · <a href="<?= e(url('/')) ?>" target="_blank" style="color:inherit">View site &rarr;</a></div>
        </div>
        <?php if ($flash !== null): ?>
            <div class="admin-flash <?= e($flash['type']) ?>"><?= e($flash['message']) ?></div>
        <?php endif; ?>
