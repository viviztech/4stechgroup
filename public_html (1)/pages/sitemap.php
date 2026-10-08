<?php

declare(strict_types=1);

/** Dynamically generated XML sitemap — always in sync with the route/data files, nothing to hand-maintain. */

$products = data('products');
$industries = data('industries');
$markets = data('markets');
$entities = config('entities');

$urls = [
    ['loc' => '/', 'priority' => '1.0'],
    ['loc' => '/about', 'priority' => '0.8'],
    ['loc' => '/companies', 'priority' => '0.9'],
    ['loc' => '/products', 'priority' => '0.9'],
    ['loc' => '/industries', 'priority' => '0.8'],
    ['loc' => '/markets', 'priority' => '0.8'],
    ['loc' => '/markets/africa', 'priority' => '0.7'],
    ['loc' => '/portfolio', 'priority' => '0.6'],
    ['loc' => '/faq', 'priority' => '0.7'],
    ['loc' => '/contact', 'priority' => '0.6'],
    ['loc' => '/request-quote', 'priority' => '0.7'],
];

foreach (array_keys($entities) as $slug) {
    $urls[] = ['loc' => '/companies/' . $slug, 'priority' => '0.8'];
}

foreach (array_keys($products) as $slug) {
    $urls[] = ['loc' => '/products/' . $slug, 'priority' => '0.8'];
}
foreach (array_keys($industries) as $slug) {
    $urls[] = ['loc' => '/industries/' . $slug, 'priority' => '0.7'];
}
foreach (array_keys($markets) as $slug) {
    if ($slug === 'africa') {
        continue;
    }
    $urls[] = ['loc' => '/markets/' . $slug, 'priority' => '0.7'];
}

header('Content-Type: application/xml; charset=UTF-8');

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $entry) {
    echo "  <url>\n";
    echo '    <loc>' . e(url($entry['loc'])) . "</loc>\n";
    echo '    <priority>' . e($entry['priority']) . "</priority>\n";
    echo "  </url>\n";
}
echo '</urlset>';
