<?php

declare(strict_types=1);

/**
 * One-time (idempotent) import: copies the site's existing static
 * content (config/config.php's entities + data/*.php) into the admin
 * database (storage/admin.sqlite) so the admin panel has a starting
 * dataset to edit, and creates a first admin login if none exists yet.
 *
 * Run from the project root: php bin/seed.php
 *
 * Safe to re-run — any table that already has rows is left alone and
 * reported as "already has N rows, skipped" rather than duplicated.
 */

if (PHP_SAPI !== 'cli') {
    http_response_code(403);
    exit('This script may only be run from the command line.');
}

define('PUBLIC_PATH', __DIR__ . '/..');
require PUBLIC_PATH . '/src/helpers.php';
require PUBLIC_PATH . '/src/AdminDatabase.php';

$pdo = AdminDatabase::connection();
if ($pdo === null) {
    fwrite(STDERR, "Could not open the admin database (storage/admin.sqlite). Check that the storage/ directory is writable.\n");
    exit(1);
}

echo "Connected to the admin database. Schema created/verified.\n\n";

function table_count(PDO $pdo, string $table): int
{
    return (int) $pdo->query('SELECT COUNT(*) FROM ' . $table)->fetchColumn();
}

// --- Admin user -------------------------------------------------------
// ADMIN_USERNAME / ADMIN_PASSWORD in .env let you choose the first login
// instead of getting a random one; both are optional.
if (table_count($pdo, 'admin_users') === 0) {
    $envUsername = trim((string) config('admin_seed_username', ''));
    $envPassword = (string) config('admin_seed_password', '');
    $username = $envUsername !== '' ? $envUsername : 'admin';
    $password = $envPassword !== '' ? $envPassword : bin2hex(random_bytes(6));
    $stmt = $pdo->prepare('INSERT INTO admin_users (username, password_hash) VALUES (?, ?)');
    $stmt->execute([$username, password_hash($password, PASSWORD_DEFAULT)]);
    echo "Created admin login:\n  username: {$username}\n  password: {$password}\n  (shown once — change it after first login; there is no 'change password' screen yet, so update it directly in the admin_users table if needed)\n\n";
} else {
    echo "admin_users already has " . table_count($pdo, 'admin_users') . " row(s), skipped.\n\n";
}

// --- Company info (from config/config.php entities) --------------------
if (table_count($pdo, 'company_info') === 0) {
    $config = require PUBLIC_PATH . '/config/config.php';
    $stmt = $pdo->prepare(
        'INSERT INTO company_info (slug, legal_name, short_name, country, country_code, address_line, locality, region, postal_code, phone, phone_secondary, whatsapp, email, focus, description, services_json, display_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
    );
    $order = 0;
    foreach ($config['entities'] as $entity) {
        $order++;
        $stmt->execute([
            $entity['slug'], $entity['legal_name'], $entity['short_name'], $entity['country'], $entity['country_code'],
            $entity['address_line'], $entity['locality'], $entity['region'], $entity['postal_code'] ?? null,
            $entity['phone'], $entity['phone_secondary'] ?? null, $entity['whatsapp'], $entity['email'],
            $entity['focus'] ?? '', $entity['description'] ?? '', json_encode($entity['services'] ?? [], JSON_UNESCAPED_UNICODE), $order,
        ]);
    }
    echo 'Seeded company_info: ' . count($config['entities']) . " companies.\n";
} else {
    echo 'company_info already has ' . table_count($pdo, 'company_info') . " row(s), skipped.\n";
}

// --- Team members --------------------------------------------------------
if (table_count($pdo, 'team_members') === 0) {
    $team = require PUBLIC_PATH . '/data/team.php';
    $stmt = $pdo->prepare('INSERT INTO team_members (name, designation, photo_path, display_order, is_active) VALUES (?,?,?,?,1)');
    foreach ($team as $member) {
        $stmt->execute([$member['name'], $member['designation'], $member['photo_path'] ?? null, $member['display_order'] ?? 0]);
    }
    echo 'Seeded team_members: ' . count($team) . " member(s).\n";
} else {
    echo 'team_members already has ' . table_count($pdo, 'team_members') . " row(s), skipped.\n";
}

// --- Industries ------------------------------------------------------------
if (table_count($pdo, 'industries') === 0) {
    $industries = require PUBLIC_PATH . '/data/industries.php';
    $stmt = $pdo->prepare('INSERT INTO industries (slug, name, meta_title, meta_description, intro, related_products_json, display_order) VALUES (?,?,?,?,?,?,?)');
    $order = 0;
    foreach ($industries as $slug => $industry) {
        $order++;
        $stmt->execute([
            $slug, $industry['name'], $industry['meta_title'] ?? '', $industry['meta_description'] ?? '',
            $industry['intro'] ?? '', json_encode($industry['related_products'] ?? [], JSON_UNESCAPED_UNICODE), $order,
        ]);
    }
    echo 'Seeded industries: ' . count($industries) . " industries.\n";
} else {
    echo 'industries already has ' . table_count($pdo, 'industries') . " row(s), skipped.\n";
}

// --- Products ----------------------------------------------------------------
if (table_count($pdo, 'products') === 0) {
    $products = require PUBLIC_PATH . '/data/products.php';
    $stmt = $pdo->prepare(
        'INSERT INTO products (slug, name, short_name, meta_title, meta_description, primary_keyword, keywords_json, intro, sections_json, applications_json, related_products_json, related_industries_json, faqs_json, image_path, display_order) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)'
    );
    $order = 0;
    foreach ($products as $slug => $product) {
        $order++;
        $stmt->execute([
            $slug, $product['name'], $product['short_name'] ?? $product['name'], $product['meta_title'] ?? '',
            $product['meta_description'] ?? '', $product['primary_keyword'] ?? '',
            json_encode($product['keywords'] ?? [], JSON_UNESCAPED_UNICODE), $product['intro'] ?? '',
            json_encode($product['sections'] ?? [], JSON_UNESCAPED_UNICODE),
            json_encode($product['applications'] ?? [], JSON_UNESCAPED_UNICODE),
            json_encode($product['related_products'] ?? [], JSON_UNESCAPED_UNICODE),
            json_encode($product['related_industries'] ?? [], JSON_UNESCAPED_UNICODE),
            json_encode($product['faqs'] ?? [], JSON_UNESCAPED_UNICODE), null, $order,
        ]);
    }
    echo 'Seeded products: ' . count($products) . " products.\n";
} else {
    echo 'products already has ' . table_count($pdo, 'products') . " row(s), skipped.\n";
}

// --- Countries -----------------------------------------------------------------
if (table_count($pdo, 'countries') === 0) {
    $countries = require PUBLIC_PATH . '/data/countries.php';
    $stmt = $pdo->prepare('INSERT INTO countries (name, iso2, region_group, region_key, region_label, market_slug, display_order) VALUES (?,?,?,?,?,?,?)');
    $total = 0;
    $order = 0;
    foreach (['gcc', 'south_asia'] as $group) {
        foreach ($countries[$group] ?? [] as $country) {
            $order++;
            $stmt->execute([$country['name'], $country['iso2'] ?? null, $group, null, null, $country['market_slug'] ?? null, $order]);
            $total++;
        }
    }
    foreach ($countries['africa'] ?? [] as $regionKey => $region) {
        $order = 0;
        foreach ($region['countries'] ?? [] as $country) {
            $order++;
            $stmt->execute([$country['name'], $country['iso2'] ?? null, 'africa', $regionKey, $region['label'] ?? $regionKey, null, $order]);
            $total++;
        }
    }
    echo "Seeded countries: {$total} countries.\n";
} else {
    echo 'countries already has ' . table_count($pdo, 'countries') . " row(s), skipped.\n";
}

// --- About page copy (Company Information module) ---------------------
// Seeded verbatim from the page's original hardcoded text so nothing
// changes on the public site until an admin edits it in company-info.php.
$aboutDefaults = [
    'about_hero_intro' => '4S Tech Group operates through three legal entities: Foures Tech Technical Services LLC in Dubai, Foures Tech Trading FZE LLC in Ajman, and 4S Tech Engineering in Chennai. Together, the companies provide on-site technical services, engineering, product supply and A-to-Z procurement for industrial construction, marine and shipping, energy, petrochemical, oil & gas, food and agricultural industries across India, the GCC and Africa.',
    'about_mission_para1' => 'We exist to remove the friction from industrial procurement for clients building and operating across India, the Gulf and Africa. Rather than a single-category supplier, we source, quality-check and export across 24 product and service lines — from container houses and prefabricated buildings to GRP water tanks, electrical enclosures, flanges, pumps and valves, cold storage, and general building materials — so a project team can consolidate more of its procurement scope through one relationship instead of managing dozens of separate vendors.',
    'about_mission_para2' => 'We are leaders in serving oil & gas plants, food industries, paper mills, airports, shipyards, chemical plants, steel plants & mills, electrical & electronics industries, computer peripherals, packing industries, agricultural industries and all construction industries.',
    'home_hero_headline' => 'A-to-Z Engineering Procurement. India · Singapore · GCC · Africa.',
];
$checkSetting = $pdo->prepare('SELECT 1 FROM site_settings WHERE setting_key = ?');
$insertSetting = $pdo->prepare('INSERT INTO site_settings (setting_key, setting_value) VALUES (?, ?)');
$seededAbout = 0;
foreach ($aboutDefaults as $key => $value) {
    $checkSetting->execute([$key]);
    if ($checkSetting->fetchColumn() === false) {
        $insertSetting->execute([$key, $value]);
        $seededAbout++;
    }
}
echo $seededAbout > 0 ? "Seeded {$seededAbout} about-page setting(s).\n" : "About-page settings already present, skipped.\n";

echo "\nDone. Log in at /admin/login.php\n";
