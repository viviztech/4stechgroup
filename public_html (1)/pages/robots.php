<?php

declare(strict_types=1);

header('Content-Type: text/plain; charset=UTF-8');

echo "User-agent: *\n";
echo "Allow: /\n";
echo "Disallow: /uploads/\n";
echo "\n";
echo 'Sitemap: ' . url('/sitemap.xml') . "\n";
