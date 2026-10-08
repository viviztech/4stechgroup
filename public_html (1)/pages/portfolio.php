<?php

declare(strict_types=1);

$portfolio = data('portfolio');

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Portfolio', 'url' => url('/portfolio')],
];

render_header([
    'title' => 'Project Portfolio | 4S Tech Group',
    'description' => 'Selected project case studies from 4S Tech Engineering and Foures Tech Trading — cold storage, curtain walling, steel structures and industrial control systems.',
    'canonical' => '/portfolio',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<section class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="font-display text-3xl font-bold text-[#082A5E] sm:text-4xl">Project Portfolio</h1>
        <p class="mt-4 max-w-3xl text-lg text-slate-600">Selected technical-services work across cold storage, industrial construction, building systems, civil engineering and steel facilities.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php foreach ($portfolio['projects'] as $project): ?>
            <article class="group overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm transition hover:-translate-y-1 hover:shadow-lg">
                <div class="grid aspect-[4/3] overflow-hidden bg-slate-100 <?= count($project['images']) > 1 ? 'grid-cols-2 gap-px' : '' ?>">
                    <?php foreach ($project['images'] as $index => $image): ?>
                        <a href="<?= e($image) ?>" target="_blank" rel="noopener" class="block min-h-0 overflow-hidden" aria-label="View <?= e($project['title']) ?> photo <?= $index + 1 ?> full size">
                            <img src="<?= e($image) ?>" alt="<?= e($project['title']) ?><?= count($project['images']) > 1 ? ' — view ' . ($index + 1) : '' ?>" loading="lazy" decoding="async" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="p-5">
                    <h2 class="font-display text-lg font-semibold text-[#082A5E]"><?= e($project['service']) ?></h2>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="border-t border-slate-200 bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h2 class="text-center font-display text-xl font-semibold text-slate-500">Trusted By</h2>
        <div class="mt-8 grid grid-cols-2 items-center justify-items-center gap-8 sm:grid-cols-4">
            <?php foreach ($portfolio['clients'] as $client): ?>
                <div class="flex h-28 w-full items-center justify-center rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                    <img src="<?= e($client['logo']) ?>" alt="<?= e($client['name']) ?> logo" loading="lazy" decoding="async" class="max-h-20 max-w-full object-contain">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php render_cta_banner(); ?>

<?php render_footer(); ?>
