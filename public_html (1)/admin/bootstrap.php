<?php

declare(strict_types=1);

/**
 * Shared bootstrap for every /admin/*.php entry point. Mirrors the
 * public site's index.php bootstrap (same PUBLIC_PATH / flattened-vs-
 * split layout detection) so admin pages share the exact same config,
 * helpers and Repository the public pages use — just with admin database writes
 * and an auth guard added on top.
 */

session_start();

if (!defined('PUBLIC_PATH')) {
    define('PUBLIC_PATH', dirname(__DIR__));
}
$root = is_file(dirname(PUBLIC_PATH) . '/vendor/autoload.php') ? dirname(PUBLIC_PATH) : PUBLIC_PATH;

require $root . '/vendor/autoload.php';
require $root . '/src/helpers.php';
require $root . '/src/Database.php';
require $root . '/src/AdminDatabase.php';
require $root . '/src/Repository.php';
require $root . '/src/Csrf.php';
require $root . '/src/AdminAuth.php';

if (config('debug')) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

/** Escape + shorthand used throughout the admin views. */
function admin_url(string $path = ''): string
{
    return url('/admin/' . ltrim($path, '/'));
}

/** Flash a one-shot admin notice (success/error) via the session. */
function admin_flash(string $type, string $message): void
{
    $_SESSION['admin_flash'] = ['type' => $type, 'message' => $message];
}

/** Insert-or-update a site_settings row, portable across SQLite and MySQL. */
function admin_upsert_setting(PDO $pdo, string $key, ?string $value): void
{
    $check = $pdo->prepare('SELECT 1 FROM site_settings WHERE setting_key = ?');
    $check->execute([$key]);
    if ($check->fetchColumn() !== false) {
        $update = $pdo->prepare('UPDATE site_settings SET setting_value = ? WHERE setting_key = ?');
        $update->execute([$value, $key]);
        return;
    }
    $insert = $pdo->prepare('INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)');
    $insert->execute([$key, $value]);
}

function admin_flash_get(): ?array
{
    $flash = $_SESSION['admin_flash'] ?? null;
    unset($_SESSION['admin_flash']);
    return $flash;
}

/** Validate the POSTed csrf_token or abort with a 400. Call at the top of every POST handler. */
function admin_verify_csrf(): void
{
    if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
        http_response_code(400);
        exit('Invalid or expired form submission. Please go back and try again.');
    }
}

/**
 * Validate and move an uploaded image into /uploads/admin/{subdir}.
 * Returns the site-relative path to store in the DB, or null if no
 * file was uploaded. Throws a RuntimeException on an invalid file.
 */
function admin_handle_image_upload(string $fieldName, string $subdir): ?string
{
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }
    $file = $_FILES[$fieldName];
    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed (error code ' . $file['error'] . ').');
    }
    if ($file['size'] > (int) config('max_upload_bytes')) {
        throw new RuntimeException('File is too large.');
    }

    $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp'];
    $mime = mime_content_type($file['tmp_name']);
    if ($mime === false || !isset($allowed[$mime])) {
        throw new RuntimeException('Only JPG, PNG or WEBP images are allowed.');
    }

    $dir = rtrim((string) config('admin_uploads_path'), '/') . '/' . trim($subdir, '/');
    if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
        throw new RuntimeException('Could not create upload directory.');
    }

    $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
    $destination = $dir . '/' . $filename;
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Could not save uploaded file.');
    }

    return rtrim((string) config('admin_uploads_url'), '/') . '/' . trim($subdir, '/') . '/' . $filename;
}
