<?php

declare(strict_types=1);

/**
 * Dev-only router for PHP's built-in server (`php -S host:port
 * public/router.php`). Production uses .htaccess (Apache) or the
 * nginx sample in /nginx.conf.sample — this file is never invoked
 * there.
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/');

// Mirror .htaccess's protections, which only apply on the production
// Apache host — the PHP built-in server used here for local dev has no
// equivalent unless we add it, so without this, source code, .env
// secrets and the SQLite database would all be directly downloadable
// from a local `php -S` run.
if (preg_match('#^/(config|data|src|templates|pages|vendor|storage|bin|sql|admin/includes)(/|$)#', $uri) === 1) {
    http_response_code(403);
    return true;
}
if (preg_match('#\.(sqlite|sqlite-journal|env)$#i', $uri) === 1) {
    http_response_code(403);
    return true;
}

if ($uri !== '/' && is_file(__DIR__ . $uri)) {
    return false;
}

// Mimic Apache's "DirectoryIndex index.php" (set in .htaccess) for real
// subdirectories that have their own entry point — e.g. /admin and
// /admin/ should resolve to admin/index.php locally the same way they
// do on the production Apache host, instead of falling through to the
// site router and 404ing.
$dirCandidate = rtrim(__DIR__ . $uri, '/');
if ($uri !== '/' && is_dir($dirCandidate) && is_file($dirCandidate . '/index.php')) {
    require $dirCandidate . '/index.php';
    return;
}

if ($uri === '/favicon.ico') {
    header('Content-Type: image/png');
    readfile(__DIR__ . '/assets/images/4s-tech-logo.png');
    return;
}

require __DIR__ . '/index.php';
