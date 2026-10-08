<?php

declare(strict_types=1);

/** @var array<string, string> $params */

$industries = data('industries');
$slug = $params['slug'] ?? '';

if (!isset($industries[$slug])) {
    http_response_code(404);
    require __DIR__ . '/not-found.php';
    return;
}

$industry = $industries[$slug];
$products = data('products');

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Industries', 'url' => url('/industries')],
    ['name' => $industry['name'], 'url' => url('/industries/' . $slug)],
];

render_header([
    'title' => $industry['meta_title'],
    'description' => $industry['meta_description'],
    'canonical' => '/industries/' . $slug,
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<article>
    <section class="bg-slate-50">
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-[#C2410C]">Industry</p>
            <h1 class="mt-2 font-display text-3xl font-bold text-[#082A5E] sm:text-4xl">Engineering Products for <?= e($industry['name']) ?></h1>
            <div class="prose-slate mt-6 space-y-4 text-lg text-slate-600"><?= paragraphs($industry['intro']) ?></div>
        </div>
    </section>

    <?php if (!empty($industry['related_products'])): ?>
        <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <h2 class="font-display text-2xl font-bold text-[#082A5E]">What We Supply to <?= e($industry['name']) ?></h2>
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                <?php foreach ($industry['related_products'] as $productSlug): ?>
                    <?php if (isset($products[$productSlug])): ?>
                        <?php render_product_card($productSlug, $products[$productSlug]); ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php render_cta_banner('Sourcing for a ' . $industry['name'] . ' project?', 'Send us your specification and destination — we\'ll quote within 24 hours.'); ?>
</article>

<?php render_footer(); ?>
