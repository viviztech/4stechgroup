<?php

declare(strict_types=1);

$products = data('products');

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Products', 'url' => url('/products')],
];

render_header([
    'title' => 'Engineering Products & Services | 24 Supply Lines | 4S Tech Group',
    'description' => '24 engineering product and service lines — container houses, GRP tanks, electrical enclosures, flanges, pumps and more — supplied across the UAE, GCC and Africa.',
    'canonical' => '/products',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<section class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="font-display text-3xl font-bold text-[#2A2A2D] sm:text-4xl">Engineering Products & Services</h1>
        <p class="mt-4 max-w-3xl text-lg text-slate-600">24 product and service lines covering structural, electrical, mechanical and general procurement needs for industrial, construction, marine and agricultural projects — sourced and exported from India and the UAE to the GCC and 40+ African countries.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($products as $slug => $product): ?>
            <?php render_product_card($slug, $product); ?>
        <?php endforeach; ?>
    </div>
</section>

<?php render_cta_banner(); ?>

<?php render_footer(); ?>
