<?php

declare(strict_types=1);

/**
 * Small, framework-free helper functions shared by every template and
 * page. Kept in one file deliberately — there is no autoloaded
 * "Helpers" class because none of these need state.
 */

/** Central output-escaping helper. Every dynamic value printed into
 * HTML must pass through this. */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function config(?string $key = null, mixed $default = null): mixed
{
    static $config = null;
    if ($config === null) {
        $config = require dirname(__DIR__) . '/config/config.php';
    }
    if ($key === null) {
        return $config;
    }
    // Group companies are admin-editable (see admin/company.php). Prefer
    // the admin database copy when one exists; otherwise fall through to the
    // static config below exactly as before.
    if ($key === 'entities' && class_exists('Repository')) {
        $dbEntities = Repository::fetch('entities');
        if ($dbEntities !== null) {
            return $dbEntities;
        }
    }
    // A small set of site-wide text fields are editable from admin/settings.php.
    if (in_array($key, ['tagline', 'default_meta_description'], true) && class_exists('Repository')) {
        $value = Repository::setting($key);
        if ($value !== null && $value !== '') {
            return $value;
        }
    }
    if ($key === 'stats' && class_exists('Repository')) {
        $statsJson = Repository::setting('stats_json');
        if ($statsJson !== null && $statsJson !== '') {
            $decoded = json_decode($statsJson, true);
            if (is_array($decoded) && $decoded !== []) {
                return $decoded;
            }
        }
    }
    $segments = explode('.', $key);
    $value = $config;
    foreach ($segments as $segment) {
        if (!is_array($value) || !array_key_exists($segment, $value)) {
            return $default;
        }
        $value = $value[$segment];
    }
    return $value;
}

/** Build a root-relative URL so internal navigation stays on the current host. */
function url(string $path = '/'): string
{
    return '/' . ltrim($path, '/');
}

/** Build an absolute URL for metadata and machine-readable documents. */
function absolute_url(string $path = '/'): string
{
    $baseUrl = rtrim((string) config('base_url'), '/');
    $configuredHost = strtolower((string) parse_url($baseUrl, PHP_URL_HOST));
    $requestHost = strtolower((string) parse_url('//' . ($_SERVER['HTTP_HOST'] ?? ''), PHP_URL_HOST));
    $loopbackHosts = ['localhost', '127.0.0.1', '::1'];

    if (in_array($configuredHost, $loopbackHosts, true) && !in_array($requestHost, $loopbackHosts, true)) {
        $baseUrl = 'https://4stechgroup.com';
    }

    return $baseUrl . url($path);
}

/** Cache-busted asset URL for anything under the web root's /assets. */
function asset(string $path): string
{
    $path = '/assets/' . ltrim($path, '/');
    $file = PUBLIC_PATH . $path;
    $version = is_file($file) ? filemtime($file) : null;
    return $path . ($version ? '?v=' . $version : '');
}

/** All webp images found for a product slug, newest-safe natural sort. */
function product_images(string $slug): array
{
    $dir = PUBLIC_PATH . '/assets/images/products/' . $slug;
    if (!is_dir($dir)) {
        return [];
    }
    $files = glob($dir . '/*.webp') ?: [];
    natsort($files);
    $images = [];
    foreach (array_values($files) as $file) {
        $dims = @getimagesize($file);
        $images[] = [
            'src' => '/assets/images/products/' . $slug . '/' . basename($file),
            'width' => $dims[0] ?? 1200,
            'height' => $dims[1] ?? 800,
        ];
    }
    return $images;
}

/** Regional-indicator flag emoji built from an ISO 3166-1 alpha-2 code. */
function flag_emoji(string $iso2): string
{
    $iso2 = strtoupper($iso2);
    if (strlen($iso2) !== 2) {
        return '';
    }
    $flag = '';
    foreach (str_split($iso2) as $letter) {
        $flag .= html_entity_decode('&#' . (127397 + ord($letter)) . ';', ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
    return $flag;
}

function old(string $field, string $default = ''): string
{
    return e($_SESSION['old_input'][$field] ?? $default);
}

function form_errors(): array
{
    return $_SESSION['form_errors'] ?? [];
}

function field_error(string $field): ?string
{
    return $_SESSION['form_errors'][$field] ?? null;
}

function flash_get(string $key): ?string
{
    $value = $_SESSION[$key] ?? null;
    unset($_SESSION[$key]);
    return $value;
}

function clear_old_input(): void
{
    unset($_SESSION['old_input'], $_SESSION['form_errors']);
}

/** Truncate a string to a maximum length on a word boundary, for meta descriptions. */
function truncate(string $text, int $max = 155): string
{
    $text = trim(preg_replace('/\s+/', ' ', $text) ?? $text);
    $length = function_exists('mb_strlen')
        ? mb_strlen($text, 'UTF-8')
        : iconv_strlen($text, 'UTF-8');
    if ($length === false || $length <= $max) {
        return $text;
    }
    $truncated = function_exists('mb_substr')
        ? mb_substr($text, 0, $max - 1, 'UTF-8')
        : iconv_substr($text, 0, $max - 1, 'UTF-8');
    if ($truncated === false) {
        return $text;
    }
    $lastSpace = function_exists('mb_strrpos')
        ? mb_strrpos($truncated, ' ', 0, 'UTF-8')
        : iconv_strrpos($truncated, ' ', 'UTF-8');
    if ($lastSpace !== false) {
        $truncated = function_exists('mb_substr')
            ? mb_substr($truncated, 0, $lastSpace, 'UTF-8')
            : iconv_substr($truncated, 0, $lastSpace, 'UTF-8');
        if ($truncated === false) {
            return $text;
        }
    }
    return rtrim($truncated, ' ,.') . '…';
}

/** Render a Markdown-lite paragraph list ("\n\n" separated) as escaped <p> tags. */
function paragraphs(string $text): string
{
    $blocks = preg_split('/\n{2,}|\n/', trim($text)) ?: [];
    $html = '';
    foreach ($blocks as $block) {
        $block = trim($block);
        if ($block === '') {
            continue;
        }
        $html .= '<p>' . e($block) . "</p>\n";
    }
    return $html;
}

/**
 * Content lookup with an admin-database-first, static-file-fallback strategy for
 * the names the admin panel manages (products, industries, countries,
 * team). Every other $name (markets, portfolio, faqs) is untouched and
 * always reads straight from /data as before.
 */
function data(string $name): array
{
    static $cache = [];
    if (isset($cache[$name])) {
        return $cache[$name];
    }

    if (in_array($name, ['products', 'industries', 'countries', 'team'], true) && class_exists('Repository')) {
        $dbResult = Repository::fetch($name);
        if ($dbResult !== null) {
            return $cache[$name] = $dbResult;
        }
    }

    $file = dirname(__DIR__) . '/data/' . $name . '.php';
    return $cache[$name] = (is_file($file) ? require $file : []);
}

/** Active team members for the About page team section — DB-first, /data/team.php fallback. */
function team_members_data(): array
{
    return data('team');
}
