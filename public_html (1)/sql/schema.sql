-- 4S Tech Group — Admin Panel database schema (SQLite)
--
-- This is a reference copy of the schema that src/AdminDatabase.php
-- already creates automatically (CREATE TABLE IF NOT EXISTS) the first
-- time it connects. You do NOT need to run this file by hand — running
-- `php bin/seed.php` once is enough, and it is safe to re-run.
--
-- Lives at storage/admin.sqlite — a SEPARATE file from the site's
-- original storage/app.sqlite, which continues to hold the `enquiries`
-- table (Contact + Request Quote form submissions) untouched.
--
-- Why SQLite instead of MySQL: this project can run on either — the
-- data-access layer (src/Repository.php, and every admin/*.php file)
-- only ever calls AdminDatabase::connection(): ?PDO and uses portable
-- SQL, so swapping in a MySQL-backed AdminDatabase class later (e.g. on
-- a production host with real MySQL credentials) is a contained,
-- single-file change. SQLite was used for local development because it
-- needs no server or credentials — just a writable storage/ folder.

-- Admin login accounts.
CREATE TABLE IF NOT EXISTS admin_users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    last_login_at TEXT NULL
);

-- Group companies (legal entities): "Group Companies" + "Contact Details" modules.
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
);

-- Team Members module.
CREATE TABLE IF NOT EXISTS team_members (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    designation TEXT NOT NULL,
    photo_path TEXT NULL,
    display_order INTEGER NOT NULL DEFAULT 0,
    is_active INTEGER NOT NULL DEFAULT 1,
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- Industries Served module.
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
);

-- Products & Services module.
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
);

-- Countries/Markets Served module.
CREATE TABLE IF NOT EXISTS countries (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    iso2 TEXT NULL,
    region_group TEXT NOT NULL,      -- 'gcc' | 'south_asia' | 'africa'
    region_key TEXT NULL,            -- africa sub-region key, e.g. 'west_central'
    region_label TEXT NULL,          -- africa sub-region display label
    market_slug TEXT NULL,           -- links to /markets/{slug} when set
    display_order INTEGER NOT NULL DEFAULT 0,
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- Website Settings + Company Information module (key/value).
-- Known keys used by the site: tagline, default_meta_description,
-- stats_json, about_hero_intro, about_mission_para1, about_mission_para2.
CREATE TABLE IF NOT EXISTS site_settings (
    setting_key TEXT NOT NULL PRIMARY KEY,
    setting_value TEXT NULL,
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- SEO Settings module: per-page title/meta description overrides.
-- A page uses its own built-in SEO text until a row exists here for its path.
CREATE TABLE IF NOT EXISTS seo_overrides (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    path TEXT NOT NULL UNIQUE,       -- e.g. '/', '/about', '/products/flanges-fittings'
    meta_title TEXT NULL,
    meta_description TEXT NULL,
    created_at TEXT NOT NULL DEFAULT (datetime('now')),
    updated_at TEXT NOT NULL DEFAULT (datetime('now'))
);

-- NOTE: Website Enquiries (Contact + Request Quote form submissions) are
-- NOT part of this database. They remain in the site's original database
-- at storage/app.sqlite, table `enquiries`, exactly as before:
--
--   CREATE TABLE enquiries (
--       id INTEGER PRIMARY KEY AUTOINCREMENT,
--       type TEXT NOT NULL DEFAULT 'contact',
--       name TEXT NOT NULL,
--       company TEXT,
--       email TEXT NOT NULL,
--       phone TEXT,
--       country TEXT,
--       product_category TEXT,
--       quantity TEXT,
--       message TEXT,
--       attachment_path TEXT,
--       ip_address TEXT,
--       created_at TEXT NOT NULL DEFAULT (datetime('now'))
--   );
--
-- admin/enquiries.php reads/deletes from this existing table via
-- src/Database.php — no changes were made to it or to the public
-- Contact/Request Quote forms that write to it.
