<?php

declare(strict_types=1);

$markets = data('markets');
$countries = data('countries');
$market = $markets['africa'];

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Global Reach', 'url' => url('/markets')],
    ['name' => 'Africa', 'url' => url('/markets/africa')],
];

render_header([
    'title' => $market['meta_title'],
    'description' => $market['meta_description'],
    'canonical' => '/markets/africa',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<article>
    <section class="bg-slate-50">
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <p class="text-sm font-semibold uppercase tracking-wide text-[#C2410C]">Africa</p>
            <h1 class="mt-2 font-display text-3xl font-bold text-[#082A5E] sm:text-4xl">Industrial Equipment Supplier for Africa</h1>
            <p class="mt-6 text-lg text-slate-600"><?= e($market['intro']) ?></p>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="prose-slate space-y-4 text-slate-600"><?= paragraphs($market['body']) ?></div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h2 class="font-display text-2xl font-bold text-[#082A5E]">40+ Countries Served, By Region</h2>
        <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <?php foreach ($countries['africa'] as $region): ?>
                <div class="rounded-lg border border-slate-200 p-5">
                    <h3 class="font-display font-semibold text-[#082A5E]"><?= e($region['label']) ?></h3>
                    <ul class="mt-3 space-y-1 text-sm text-slate-600">
                        <?php foreach ($region['countries'] as $country): ?>
                            <li><?= flag_emoji($country['iso2']) ?> <?= e($country['name']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="mt-4 text-xs text-slate-400">Country groupings are geographic and used for shipping/logistics planning purposes.</p>
    </section>

    <?php render_cta_banner('Exporting to Africa?', 'Tell us your product, quantity and destination country — we\'ll quote within 24 hours.'); ?>
</article>

<?php render_footer(); ?>
