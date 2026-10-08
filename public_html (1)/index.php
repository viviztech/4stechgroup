<?php

declare(strict_types=1);

/**
 * Single front controller. Everything not matched to a real file by
 * the web server (see .htaccess / nginx sample) is routed through
 * here.
 */

session_start();

// PUBLIC_PATH is always this file's own directory — the one thing the
// web server guarantees regardless of layout. App code (vendor/, src/,
// config/, etc.) normally lives one level above it as siblings of
// public/, but on hosts where we can only reach the web root (an FTP
// account jailed to public_html, for example) everything is flattened
// in here instead. Detect which layout we're in rather than hardcoding
// one — the app code itself never needs to know or care.
define('PUBLIC_PATH', __DIR__);
$root = is_file(dirname(PUBLIC_PATH) . '/vendor/autoload.php') ? dirname(PUBLIC_PATH) : PUBLIC_PATH;

require $root . '/vendor/autoload.php';
require $root . '/src/helpers.php';
require $root . '/src/Database.php';
require $root . '/src/AdminDatabase.php';
require $root . '/src/Repository.php';
require $root . '/src/Csrf.php';
require $root . '/src/Mailer.php';
require $root . '/src/Seo.php';
require $root . '/src/Router.php';
require $root . '/templates/schema.php';
require $root . '/templates/breadcrumbs.php';
require $root . '/templates/faq-accordion.php';
require $root . '/templates/product-card.php';
require $root . '/templates/cta-banner.php';
require $root . '/templates/header.php';
require $root . '/templates/footer.php';

if (config('debug')) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}

$router = new Router();

// --- 301 redirects from the previous site's URL structure ---
$router->redirectPrefix('/services', '/products');
$router->redirectPrefix('/countries', '/markets');

// --- Machine-readable / crawler routes ---
$router->get('/sitemap.xml', 'sitemap');
$router->get('/robots.txt', 'robots');
$router->get('/llms.txt', 'llms');

// --- Core pages ---
$router->get('/', 'home');
$router->get('/about', 'about');
$router->get('/companies', 'companies');
$router->get('/companies/{slug}', 'company-detail');
$router->get('/portfolio', 'portfolio');
$router->get('/faq', 'faq');
$router->any('/contact', 'contact');
$router->any('/request-quote', 'request-quote');

// --- Products ---
$router->get('/products', 'products-hub');
$router->get('/products/{slug}', 'product-detail');

// --- Industries ---
$router->get('/industries', 'industries-hub');
$router->get('/industries/{slug}', 'industry-detail');

// --- Markets ---
$router->get('/markets', 'markets-hub');
$router->get('/markets/africa', 'market-africa');
$router->get('/markets/{slug}', 'market-detail');

$router->dispatch($_SERVER['REQUEST_METHOD'] ?? 'GET', $_SERVER['REQUEST_URI'] ?? '/');
