<?php

declare(strict_types=1);

/**
 * /llms.txt — a clean-markdown summary for AI assistants and answer
 * engines, built from the same data files as the rest of the site so
 * it can never drift from what the pages actually say.
 */

$entities = config('entities');
$products = data('products');
$industries = data('industries');

header('Content-Type: text/plain; charset=UTF-8');

echo '# ' . config('site_name') . "\n\n";
echo "> " . config('default_meta_description') . "\n\n";

echo "## Company\n\n";
echo "4S Tech Engineering (India) and Foures Tech Trading FZE LLC (UAE) are one group operating under two legal entities. ";
echo "They are an international one-stop, A-to-Z procurement and supply company for engineering products, serving industrial construction, ";
echo "marine and shipping, energy, petrochemical, oil & gas, food and agricultural industries.\n\n";

foreach ($entities as $entity) {
    echo '- **' . $entity['legal_name'] . '** (' . $entity['country'] . '): ' . $entity['address_line'] . ' — ' . $entity['phone'] . ' — ' . $entity['email'] . "\n";
}

echo "\n## Markets Served\n\n";
echo "India, United Arab Emirates, Sultanate of Oman, Kingdom of Bahrain, Kuwait, Qatar, and 40+ African countries ";
echo "across West, East, Southern and North Africa (including Nigeria, Kenya, Ghana, South Africa, Tanzania, Ethiopia, Morocco, Tunisia, Algeria, Senegal, Ivory Coast, Mozambique, Uganda, Zambia).\n\n";

echo "## Industries Served\n\n";
foreach ($industries as $industry) {
    echo '- ' . $industry['name'] . "\n";
}

echo "\n## Products & Service Lines (19)\n\n";
foreach ($products as $slug => $product) {
    echo '- **' . $product['name'] . '**: ' . $product['intro'] . ' (' . url('/products/' . $slug) . ")\n";
}

echo "\n## Key Pages\n\n";
echo '- Products: ' . url('/products') . "\n";
echo '- Industries: ' . url('/industries') . "\n";
echo '- Global Reach: ' . url('/markets') . "\n";
echo '- About: ' . url('/about') . "\n";
echo '- FAQ: ' . url('/faq') . "\n";
echo '- Contact: ' . url('/contact') . "\n";
echo '- Request a Quote: ' . url('/request-quote') . "\n";
