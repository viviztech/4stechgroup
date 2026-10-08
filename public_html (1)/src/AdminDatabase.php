<?php

declare(strict_types=1);

/**
 * Connection for the admin panel's content database (company info, team,
 * industries, products, countries, settings, SEO overrides).
 *
 * Separate from Database.php (storage/app.sqlite, contact/quote
 * enquiries), so nothing here ever touches that table or the public
 * contact form.
 *
 * Supports two backends, chosen by DB_CONNECTION in .env:
 *  - 'sqlite' (default): storage/admin.sqlite, no server or credentials
 *    needed — used for local development.
 *  - 'mysql': uses the connection details in config('mysql') — used in
 *    production once real hosting credentials exist.
 *
 * connection() returns null instead of throwing when unavailable, so
 * callers (see Repository.php) can fall back to the static /data files.
 * Every caller only ever uses AdminDatabase::connection(): ?PDO, plus
 * driver()/now() below for the handful of call sites that need
 * dialect-specific SQL (upserts, timestamps).
 */
final class AdminDatabase
{
    private static ?PDO $connection = null;
    private static bool $attempted = false;
    private static bool $migrated = false;

    public static function connection(): ?PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }
        if (self::$attempted) {
            return null;
        }
        self::$attempted = true;

        $pdo = self::isMysql() ? self::connectMysql() : self::connectSqlite();
        if ($pdo === null) {
            return null;
        }

        self::$connection = $pdo;
        self::migrate($pdo);

        return $pdo;
    }

    /** True once a working connection has been established this request. */
    public static function isAvailable(): bool
    {
        return self::connection() instanceof PDO;
    }

    /** 'mysql' or 'sqlite' — for the few call sites that need dialect-specific SQL. */
    public static function driver(): string
    {
        return self::isMysql() ? 'mysql' : 'sqlite';
    }

    /** Current-timestamp SQL expression for the active driver. */
    public static function now(): string
    {
        return self::isMysql() ? 'NOW()' : "datetime('now')";
    }

    private static function isMysql(): bool
    {
        return config('db_connection') === 'mysql';
    }

    private static function connectSqlite(): ?PDO
    {
        $path = (string) config('admin_database_path');
        $dir = dirname($path);
        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            return null;
        }

        try {
            $pdo = new PDO('sqlite:' . $path, null, null, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
            $pdo->exec('PRAGMA foreign_keys = ON');

            return $pdo;
        } catch (PDOException) {
            return null;
        }
    }

    private static function connectMysql(): ?PDO
    {
        $cfg = config('mysql');
        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=utf8mb4',
            $cfg['host'],
            $cfg['port'],
            $cfg['database']
        );

        try {
            return new PDO($dsn, $cfg['username'], $cfg['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException) {
            return null;
        }
    }

    private static function migrate(PDO $pdo): void
    {
        if (self::$migrated) {
            return;
        }
        self::$migrated = true;

        self::isMysql() ? self::migrateMysql($pdo) : self::migrateSqlite($pdo);
    }

    private static function migrateSqlite(PDO $pdo): void
    {
        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS admin_users (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                username TEXT NOT NULL UNIQUE,
                password_hash TEXT NOT NULL,
                created_at TEXT NOT NULL DEFAULT (datetime('now')),
                last_login_at TEXT NULL
            )
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS company_info (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                slug TEXT NOT NULL UNIQUE,
                legal_name TEXT NOT NULL,
                short_name TEXT NOT NULL,
                country TEXT NOT NULL,
                country_code TEXT NOT NULL,
                address_line TEXT NOT NULL,
                locality TEXT NOT NULL,
                region TEXT NOT NULL,
                postal_code TEXT NULL,
                phone TEXT NOT NULL,
                phone_secondary TEXT NULL,
                whatsapp TEXT NOT NULL,
                email TEXT NOT NULL,
                focus TEXT NULL,
                description TEXT NULL,
                services_json TEXT NULL,
                display_order INTEGER NOT NULL DEFAULT 0,
                created_at TEXT NOT NULL DEFAULT (datetime('now')),
                updated_at TEXT NOT NULL DEFAULT (datetime('now'))
            )
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS team_members (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                designation TEXT NOT NULL,
                photo_path TEXT NULL,
                display_order INTEGER NOT NULL DEFAULT 0,
                is_active INTEGER NOT NULL DEFAULT 1,
                created_at TEXT NOT NULL DEFAULT (datetime('now')),
                updated_at TEXT NOT NULL DEFAULT (datetime('now'))
            )
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS industries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                slug TEXT NOT NULL UNIQUE,
                name TEXT NOT NULL,
                meta_title TEXT NULL,
                meta_description TEXT NULL,
                intro TEXT NULL,
                related_products_json TEXT NULL,
                display_order INTEGER NOT NULL DEFAULT 0,
                created_at TEXT NOT NULL DEFAULT (datetime('now')),
                updated_at TEXT NOT NULL DEFAULT (datetime('now'))
            )
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS products (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                slug TEXT NOT NULL UNIQUE,
                name TEXT NOT NULL,
                short_name TEXT NOT NULL,
                meta_title TEXT NULL,
                meta_description TEXT NULL,
                primary_keyword TEXT NULL,
                keywords_json TEXT NULL,
                intro TEXT NULL,
                sections_json TEXT NULL,
                applications_json TEXT NULL,
                related_products_json TEXT NULL,
                related_industries_json TEXT NULL,
                faqs_json TEXT NULL,
                image_path TEXT NULL,
                display_order INTEGER NOT NULL DEFAULT 0,
                created_at TEXT NOT NULL DEFAULT (datetime('now')),
                updated_at TEXT NOT NULL DEFAULT (datetime('now'))
            )
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS countries (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL,
                iso2 TEXT NULL,
                region_group TEXT NOT NULL,
                region_key TEXT NULL,
                region_label TEXT NULL,
                market_slug TEXT NULL,
                display_order INTEGER NOT NULL DEFAULT 0,
                created_at TEXT NOT NULL DEFAULT (datetime('now')),
                updated_at TEXT NOT NULL DEFAULT (datetime('now'))
            )
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS site_settings (
                setting_key TEXT NOT NULL PRIMARY KEY,
                setting_value TEXT NULL,
                updated_at TEXT NOT NULL DEFAULT (datetime('now'))
            )
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS seo_overrides (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                path TEXT NOT NULL UNIQUE,
                meta_title TEXT NULL,
                meta_description TEXT NULL,
                created_at TEXT NOT NULL DEFAULT (datetime('now')),
                updated_at TEXT NOT NULL DEFAULT (datetime('now'))
            )
        SQL);
    }

    private static function migrateMysql(PDO $pdo): void
    {
        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS admin_users (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(100) NOT NULL UNIQUE,
                password_hash VARCHAR(255) NOT NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                last_login_at DATETIME NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS company_info (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                slug VARCHAR(100) NOT NULL UNIQUE,
                legal_name VARCHAR(255) NOT NULL,
                short_name VARCHAR(255) NOT NULL,
                country VARCHAR(100) NOT NULL,
                country_code VARCHAR(5) NOT NULL,
                address_line VARCHAR(500) NOT NULL,
                locality VARCHAR(100) NOT NULL,
                region VARCHAR(100) NOT NULL,
                postal_code VARCHAR(20) NULL,
                phone VARCHAR(50) NOT NULL,
                phone_secondary VARCHAR(50) NULL,
                whatsapp VARCHAR(50) NOT NULL,
                email VARCHAR(150) NOT NULL,
                focus VARCHAR(500) NULL,
                description TEXT NULL,
                services_json TEXT NULL,
                display_order INT NOT NULL DEFAULT 0,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS team_members (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                designation VARCHAR(255) NOT NULL,
                photo_path VARCHAR(500) NULL,
                display_order INT NOT NULL DEFAULT 0,
                is_active TINYINT(1) NOT NULL DEFAULT 1,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS industries (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                slug VARCHAR(150) NOT NULL UNIQUE,
                name VARCHAR(255) NOT NULL,
                meta_title VARCHAR(255) NULL,
                meta_description VARCHAR(500) NULL,
                intro TEXT NULL,
                related_products_json TEXT NULL,
                display_order INT NOT NULL DEFAULT 0,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS products (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                slug VARCHAR(150) NOT NULL UNIQUE,
                name VARCHAR(255) NOT NULL,
                short_name VARCHAR(255) NOT NULL,
                meta_title VARCHAR(255) NULL,
                meta_description VARCHAR(500) NULL,
                primary_keyword VARCHAR(255) NULL,
                keywords_json TEXT NULL,
                intro TEXT NULL,
                sections_json TEXT NULL,
                applications_json TEXT NULL,
                related_products_json TEXT NULL,
                related_industries_json TEXT NULL,
                faqs_json TEXT NULL,
                image_path VARCHAR(500) NULL,
                display_order INT NOT NULL DEFAULT 0,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS countries (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(150) NOT NULL,
                iso2 VARCHAR(5) NULL,
                region_group VARCHAR(50) NOT NULL,
                region_key VARCHAR(50) NULL,
                region_label VARCHAR(100) NULL,
                market_slug VARCHAR(100) NULL,
                display_order INT NOT NULL DEFAULT 0,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS site_settings (
                setting_key VARCHAR(100) NOT NULL PRIMARY KEY,
                setting_value TEXT NULL,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);

        $pdo->exec(<<<SQL
            CREATE TABLE IF NOT EXISTS seo_overrides (
                id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                path VARCHAR(255) NOT NULL UNIQUE,
                meta_title VARCHAR(255) NULL,
                meta_description VARCHAR(500) NULL,
                created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
        SQL);
    }
}
