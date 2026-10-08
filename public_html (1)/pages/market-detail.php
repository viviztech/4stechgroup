<?php

declare(strict_types=1);

/** @var array<string, string> $params */

$markets = data('markets');
$slug = $params['slug'] ?? '';

if ($slug === 'africa' || !isset($markets[$slug])) {
    http_response_code(404);
    require __DIR__ . '/not-found.php';
    return;
}

$market = $markets[$slug];

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Global Reach', 'url' => url('/markets')],
    ['name' => $market['name'], 'url' => url('/markets/' . $slug)],
];

render_header([
    'title' => $market['meta_title'],
    'description' => $market['meta_description'],
    'canonical' => '/markets/' . $slug,
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<article>
    <section class="bg-slate-50">
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-[#C2410C]"><?= e($market['region']) ?> Market</p>
            <h1 class="mt-2 font-display text-3xl font-bold text-[#082A5E] sm:text-4xl">Engineering Products Supplier in <?= e($market['name']) ?></h1>
            <p class="mt-6 text-lg text-slate-600"><?= e($market['intro']) ?></p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="prose-slate space-y-4 text-slate-600"><?= paragraphs($market['body']) ?></div>
    </section>

    <?php render_cta_banner('Sourcing for a project in ' . $market['name'] . '?', 'Tell us your product, quantity and site location — we\'ll quote within 24 hours.'); ?>
</article>

<?php render_footer(); ?>
