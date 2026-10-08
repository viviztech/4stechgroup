<?php

declare(strict_types=1);

$entities = config('entities');
$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Group Companies', 'url' => url('/companies')],
];

render_header([
    'title' => 'Our Group Companies | Dubai, Ajman & Chennai | 4S Tech Group',
    'description' => 'Meet the three 4S Tech Group companies providing technical services, engineering products and procurement from Dubai, Ajman and Chennai.',
    'canonical' => '/companies',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<section class="bg-[#082A5E] text-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8 lg:py-20">
        <p class="text-sm font-semibold uppercase tracking-widest text-[#FB923C]">One group · Three companies · Two countries</p>
        <h1 class="mt-4 max-w-3xl font-display text-4xl font-bold sm:text-5xl">Local companies. One engineering network.</h1>
        <p class="mt-5 max-w-3xl text-lg text-slate-300">Choose the company that matches your location and requirement. Technical service projects are handled from Dubai, UAE trading and exports from Ajman, and engineering and sourcing from Chennai, India.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
        <?php foreach ($entities as $entity): ?>
            <article class="flex flex-col rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#C2410C]"><?= e($entity['locality']) ?> · <?= e($entity['country']) ?></p>
                <h2 class="mt-3 font-display text-xl font-bold text-[#082A5E]"><?= e($entity['legal_name']) ?></h2>
                <p class="mt-2 font-medium text-slate-700"><?= e($entity['focus']) ?></p>
                <p class="mt-4 flex-1 text-sm leading-6 text-slate-600"><?= e($entity['description']) ?></p>
                <a href="<?= e(url('/companies/' . $entity['slug'])) ?>" class="mt-6 inline-flex items-center font-semibold text-[#C2410C]">View company details &rarr;</a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<?php render_cta_banner('Not sure which company to contact?', 'Send one enquiry and our group team will route it to the right office.'); ?>
<?php render_footer(); ?>
