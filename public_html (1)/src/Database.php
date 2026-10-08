<?php

declare(strict_types=1);

final class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $path = (string) config('database_path');
        $isNew = !is_file($path);

        $pdo = new PDO('sqlite:' . $path);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('PRAGMA foreign_keys = ON');

        if ($isNew) {
            self::migrate($pdo);
        }

        self::$connection = $pdo;

        return $pdo;
    }

    private static function migrate(PDO $pdo): void
    {
        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS enquiries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                type TEXT NOT NULL DEFAULT 'contact',
                name TEXT NOT NULL,
                company TEXT,
                email TEXT NOT NULL,
                phone TEXT,
                country TEXT,
                product_category TEXT,
                quantity TEXT,
                message TEXT,
                attachment_path TEXT,
                ip_address TEXT,
                created_at TEXT NOT NULL DEFAULT (datetime('now'))
            )
        SQL);
    }
}
