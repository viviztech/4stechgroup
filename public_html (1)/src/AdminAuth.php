<?php

declare(strict_types=1);

/**
 * Session-based admin authentication. Session state lives under its
 * own array key ($_SESSION['admin']) so it never collides with the
 * public site's session usage (old_input, form_errors, csrf token).
 */
final class AdminAuth
{
    public static function attempt(string $username, string $password): bool
    {
        $pdo = AdminDatabase::connection();
        if ($pdo === null) {
            return false;
        }

        $stmt = $pdo->prepare('SELECT id, username, password_hash FROM admin_users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user === false || !password_verify($password, $user['password_hash'])) {
            usleep(300_000); // constant-ish delay to blunt username enumeration / brute force
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['admin'] = [
            'id' => (int) $user['id'],
            'username' => $user['username'],
        ];

        $update = $pdo->prepare('UPDATE admin_users SET last_login_at = ' . AdminDatabase::now() . ' WHERE id = ?');
        $update->execute([$user['id']]);

        return true;
    }

    public static function check(): bool
    {
        return isset($_SESSION['admin']['id']);
    }

    public static function user(): ?array
    {
        return $_SESSION['admin'] ?? null;
    }

    public static function logout(): void
    {
        unset($_SESSION['admin']);
        session_regenerate_id(true);
    }

    /** Call at the top of every protected admin page. */
    public static function requireLogin(): void
    {
        if (!self::check()) {
            header('Location: ' . url('/admin/login.php'));
            exit;
        }
    }
}
