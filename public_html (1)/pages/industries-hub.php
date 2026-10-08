<?php

declare(strict_types=1);

$industries = data('industries');

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Industries', 'url' => url('/industries')],
];

render_header([
    'title' => 'Industries We Serve | Oil & Gas, Marine, Construction & More | 4S Tech',
    'description' => '12 industries supplied — oil & gas, shipyards & marine, food processing, construction, steel plants, power & energy and more — across the UAE, GCC and Africa.',
    'canonical' => '/industries',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<section class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="font-display text-3xl font-bold text-[#082A5E] sm:text-4xl">Industries We Serve</h1>
        <p class="mt-4 max-w-3xl text-lg text-slate-600">From oil & gas plants to food industries, shipyards to steel mills — we supply engineering products matched to the material, certification and delivery requirements of each sector we work in.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($industries as $slug => $industry): ?>
            <a href="<?= e(url('/industries/' . $slug)) ?>" class="group flex flex-col rounded-lg border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">
                <h2 class="font-display text-lg font-semibold text-[#082A5E] group-hover:text-[#C2410C]"><?= e($industry['name']) ?></h2>
                <p class="mt-2 line-clamp-3 flex-1 text-sm text-slate-600"><?= e(truncate($industry['intro'], 160)) ?></p>
                <span class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-[#C2410C]">View industry <span aria-hidden="true">&rarr;</span></span>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<?php render_cta_banner(); ?>

<?php render_footer(); ?>
