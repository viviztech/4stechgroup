<?php

declare(strict_types=1);

/**
 * Read-side data access for admin-managed content (company info, team
 * members, industries, products, countries, settings). Every method
 * returns null — never an exception, never an empty-but-"found" array —
 * when the admin database is unreachable or the relevant table has no rows yet, so
 * data()/config() in helpers.php can fall back to the static /data
 * files without the public site ever breaking.
 *
 * Admin CRUD screens (see /admin) talk to AdminDatabase::connection()
 * directly for writes — this class is deliberately read-only.
 */
final class Repository
{
    public static function entities(): ?array
    {
        $pdo = AdminDatabase::connection();
        if ($pdo === null) {
            return null;
        }
        $rows = $pdo->query('SELECT * FROM company_info ORDER BY display_order ASC, id ASC')->fetchAll();
        if ($rows === [] || $rows === false) {
            return null;
        }

        $entities = [];
        foreach ($rows as $row) {
            $phoneDigits = preg_replace('/\D+/', '', (string) $row['phone']) ?? '';
            $whatsappDigits = preg_replace('/\D+/', '', (string) $row['whatsapp']) ?? '';
            $entities[$row['slug']] = [
                'slug' => $row['slug'],
                'legal_name' => $row['legal_name'],
                'short_name' => $row['short_name'],
                'country' => $row['country'],
                'country_code' => $row['country_code'],
                'address_line' => $row['address_line'],
                'locality' => $row['locality'],
                'region' => $row['region'],
                'postal_code' => $row['postal_code'] ?? '',
                'phone' => $row['phone'],
                'phone_secondary' => $row['phone_secondary'] ?? null,
                'phone_href' => 'tel:+' . ltrim($phoneDigits, '+'),
                'whatsapp' => $row['whatsapp'],
                'whatsapp_href' => 'https://wa.me/' . ltrim($whatsappDigits, '+'),
                'email' => $row['email'],
                'focus' => $row['focus'] ?? '',
                'description' => $row['description'] ?? '',
                'services' => self::decodeJson($row['services_json']),
            ];
        }

        return $entities;
    }

    public static function products(): ?array
    {
        $pdo = AdminDatabase::connection();
        if ($pdo === null) {
            return null;
        }
        $rows = $pdo->query('SELECT * FROM products ORDER BY display_order ASC, id ASC')->fetchAll();
        if ($rows === [] || $rows === false) {
            return null;
        }

        $products = [];
        foreach ($rows as $row) {
            $products[$row['slug']] = [
                'name' => $row['name'],
                'short_name' => $row['short_name'],
                'meta_title' => $row['meta_title'] ?? '',
                'meta_description' => $row['meta_description'] ?? '',
                'primary_keyword' => $row['primary_keyword'] ?? '',
                'keywords' => self::decodeJson($row['keywords_json']),
                'intro' => $row['intro'] ?? '',
                'sections' => self::decodeJson($row['sections_json']),
                'applications' => self::decodeJson($row['applications_json']),
                'related_products' => self::decodeJson($row['related_products_json']),
                'related_industries' => self::decodeJson($row['related_industries_json']),
                'faqs' => self::decodeJson($row['faqs_json']),
                'image_path' => $row['image_path'] ?? null,
            ];
        }

        return $products;
    }

    public static function industries(): ?array
    {
        $pdo = AdminDatabase::connection();
        if ($pdo === null) {
            return null;
        }
        $rows = $pdo->query('SELECT * FROM industries ORDER BY display_order ASC, id ASC')->fetchAll();
        if ($rows === [] || $rows === false) {
            return null;
        }

        $industries = [];
        foreach ($rows as $row) {
            $industries[$row['slug']] = [
                'name' => $row['name'],
                'meta_title' => $row['meta_title'] ?? '',
                'meta_description' => $row['meta_description'] ?? '',
                'intro' => $row['intro'] ?? '',
                'related_products' => self::decodeJson($row['related_products_json']),
            ];
        }

        return $industries;
    }

    public static function countries(): ?array
    {
        $pdo = AdminDatabase::connection();
        if ($pdo === null) {
            return null;
        }
        $rows = $pdo->query('SELECT * FROM countries ORDER BY region_group ASC, region_key ASC, display_order ASC, name ASC')->fetchAll();
        if ($rows === [] || $rows === false) {
            return null;
        }

        $countries = ['gcc' => [], 'south_asia' => [], 'africa' => []];
        foreach ($rows as $row) {
            $entry = ['name' => $row['name'], 'iso2' => $row['iso2'] ?? ''];
            if ($row['region_group'] === 'gcc' || $row['region_group'] === 'south_asia') {
                $entry['market_slug'] = $row['market_slug'] ?? '';
                $countries[$row['region_group']][] = $entry;
                continue;
            }
            if ($row['region_group'] === 'africa') {
                $key = $row['region_key'] ?: 'other';
                if (!isset($countries['africa'][$key])) {
                    $countries['africa'][$key] = ['label' => $row['region_label'] ?: $key, 'countries' => []];
                }
                $countries['africa'][$key]['countries'][] = $entry;
            }
        }

        return $countries;
    }

    /** @return array<int, array{id:int,name:string,designation:string,photo_path:?string}>|null */
    public static function teamMembers(): ?array
    {
        $pdo = AdminDatabase::connection();
        if ($pdo === null) {
            return null;
        }
        $rows = $pdo->query('SELECT id, name, designation, photo_path, display_order FROM team_members WHERE is_active = 1 ORDER BY display_order ASC, id ASC')->fetchAll();
        if ($rows === [] || $rows === false) {
            return null;
        }

        return array_map(static fn (array $row): array => [
            'id' => (int) $row['id'],
            'name' => $row['name'],
            'designation' => $row['designation'],
            'photo_path' => $row['photo_path'] ?: null,
            'display_order' => (int) $row['display_order'],
        ], $rows);
    }

    public static function setting(string $key, ?string $default = null): ?string
    {
        $pdo = AdminDatabase::connection();
        if ($pdo === null) {
            return $default;
        }
        $stmt = $pdo->prepare('SELECT setting_value FROM site_settings WHERE setting_key = ?');
        $stmt->execute([$key]);
        $value = $stmt->fetchColumn();

        return $value === false ? $default : (string) $value;
    }

    /** @return array{meta_title:?string,meta_description:?string}|null */
    public static function seoOverride(string $path): ?array
    {
        $pdo = AdminDatabase::connection();
        if ($pdo === null) {
            return null;
        }
        $stmt = $pdo->prepare('SELECT meta_title, meta_description FROM seo_overrides WHERE path = ? LIMIT 1');
        $stmt->execute(['/' . ltrim($path, '/')]);
        $row = $stmt->fetch();
        if ($row === false) {
            return null;
        }
        if (($row['meta_title'] ?? '') === '' && ($row['meta_description'] ?? '') === '') {
            return null;
        }

        return ['meta_title' => $row['meta_title'] ?: null, 'meta_description' => $row['meta_description'] ?: null];
    }

    /** Dispatch used by data()'s DB-first lookup in helpers.php. */
    public static function fetch(string $name): ?array
    {
        return match ($name) {
            'products' => self::products(),
            'industries' => self::industries(),
            'countries' => self::countries(),
            'team' => self::teamMembers(),
            'entities' => self::entities(),
            default => null,
        };
    }

    private static function decodeJson(?string $json): array
    {
        if ($json === null || $json === '') {
            return [];
        }
        $decoded = json_decode($json, true);
        return is_array($decoded) ? $decoded : [];
    }
}
