<?php

declare(strict_types=1);

$products = data('products');
$industries = data('industries');
$markets = data('markets');
$countries = data('countries');
$portfolio = data('portfolio');
$stats = config('stats');
$faqs = data('faqs');
$homeFaqs = array_slice($faqs['Products'], 0, 6);

render_header([
    'title' => '4S Tech Group | Engineering Products Supplier UAE, India & Africa',
    'description' => config('default_meta_description'),
    'canonical' => '/',
    'schemas' => [Seo::faqPage($homeFaqs)],
]);
?>

<section class="relative overflow-hidden bg-[#2A2A2D]">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:py-24">
        <p class="text-sm font-semibold uppercase tracking-widest text-[#E14A4F]">Three companies · UAE & India · One group</p>
        <h1 class="mt-4 max-w-3xl font-display text-4xl font-bold text-white sm:text-5xl">A-to-Z Engineering Procurement. India &middot; Singapore &middot; GCC &middot; Africa.</h1>
        <p class="mt-6 max-w-2xl text-lg text-slate-300">One-stop supply of 16 engineering product and service lines — from container houses and GRP water tanks to flanges, pumps, valves and cold storage — for industrial construction, marine, energy, oil &amp; gas, food and agricultural industries.</p>
        <div class="mt-8 flex flex-wrap gap-4">
            <a href="<?= e(url('/request-quote')) ?>" class="inline-flex items-center justify-center rounded-md bg-[#B61F24] px-6 py-3 font-semibold text-white transition hover:bg-[#8F1A1E]">Request a Quote</a>
            <a href="<?= e(url('/products')) ?>" class="inline-flex items-center justify-center rounded-md border border-white/30 px-6 py-3 font-semibold text-white transition hover:bg-white/10">Explore Products</a>
        </div>

        <dl class="mt-14 grid grid-cols-2 gap-6 border-t border-white/10 pt-10 sm:grid-cols-4">
            <?php foreach ($stats as $stat): ?>
                <div>
                    <dt class="sr-only"><?= e($stat['label']) ?></dt>
                    <dd class="font-display text-3xl font-bold text-white sm:text-4xl"><?= e($stat['value']) ?></dd>
                    <p class="mt-1 text-sm text-slate-400"><?= e($stat['label']) ?></p>
                </div>
            <?php endforeach; ?>
        </dl>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <p class="text-sm font-semibold uppercase tracking-wider text-[#B61F24]">4S Tech Group</p>
            <h2 class="mt-2 font-display text-2xl font-bold text-[#2A2A2D] sm:text-3xl">The right company for each requirement</h2>
        </div>
        <a href="<?= e(url('/companies')) ?>" class="text-sm font-semibold text-[#B61F24]">Meet all group companies &rarr;</a>
    </div>
    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
        <?php foreach (config('entities') as $entity): ?>
            <a href="<?= e(url('/companies/' . $entity['slug'])) ?>" class="group rounded-lg border border-slate-200 p-6 transition hover:-translate-y-1 hover:border-[#B61F24] hover:shadow-lg">
                <p class="text-xs font-semibold uppercase tracking-wider text-[#B61F24]"><?= e($entity['locality']) ?></p>
                <h3 class="mt-2 font-display text-lg font-bold text-[#2A2A2D]"><?= e($entity['legal_name']) ?></h3>
                <p class="mt-3 text-sm text-slate-600"><?= e($entity['focus']) ?></p>
            </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <p class="text-center text-sm font-semibold uppercase tracking-wide text-slate-400">Serving Industries Including</p>
        <div class="mt-4 flex flex-wrap items-center justify-center gap-x-8 gap-y-2 text-sm font-medium text-slate-500">
            <?php foreach (array_slice($industries, 0, 8) as $industry): ?>
                <span><?= e($industry['name']) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="flex flex-wrap items-end justify-between gap-4">
        <div>
            <h2 class="font-display text-2xl font-bold text-[#2A2A2D] sm:text-3xl">What We Supply</h2>
            <p class="mt-2 max-w-2xl text-slate-600">16 product and service lines covering structural, electrical, mechanical and general procurement needs.</p>
        </div>
        <a href="<?= e(url('/products')) ?>" class="text-sm font-semibold text-[#B61F24]">View all products &rarr;</a>
    </div>
    <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <?php $count = 0; foreach ($products as $slug => $product): if ($count++ >= 6) break; ?>
            <?php render_product_card($slug, $product); ?>
        <?php endforeach; ?>
    </div>
</section>

<section class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <h2 class="font-display text-2xl font-bold text-[#2A2A2D] sm:text-3xl">Global Reach</h2>
        <p class="mt-2 max-w-2xl text-slate-600">Supplying from India and the UAE into three regions — a single procurement relationship across South Asia, the GCC and Africa.</p>

        <div class="mt-8 grid grid-cols-1 gap-6 sm:grid-cols-3">
            <a href="<?= e(url('/markets/india')) ?>" class="rounded-lg border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">
                <h3 class="font-display text-lg font-semibold text-[#2A2A2D]"><?= flag_emoji('IN') ?> India</h3>
                <p class="mt-2 text-sm text-slate-600">Manufacturing and sourcing base for SMC/GRP products and general industrial supply.</p>
            </a>
            <a href="<?= e(url('/markets')) ?>" class="rounded-lg border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">
                <h3 class="font-display text-lg font-semibold text-[#2A2A2D]">🕌 GCC — 6 Countries</h3>
                <p class="mt-2 text-sm text-slate-600">UAE, Oman, Bahrain, Kuwait and Qatar — served through our UAE companies in Dubai and Ajman.</p>
            </a>
            <a href="<?= e(url('/markets/africa')) ?>" class="rounded-lg border border-slate-200 bg-white p-6 transition hover:-translate-y-1 hover:shadow-lg">
                <h3 class="font-display text-lg font-semibold text-[#2A2A2D]">🌍 Africa — 40+ Countries</h3>
                <p class="mt-2 text-sm text-slate-600">West, East, Southern and North Africa, including Nigeria, Kenya, Ghana and South Africa.</p>
            </a>
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <h2 class="text-center font-display text-xl font-semibold text-slate-500">Trusted By</h2>
    <div class="mt-8 grid grid-cols-2 items-center justify-items-center gap-8 sm:grid-cols-4">
        <?php foreach ($portfolio['clients'] as $client): ?>
            <div class="flex h-24 w-full items-center justify-center rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
                <img src="<?= e($client['logo']) ?>" alt="<?= e($client['name']) ?> logo" loading="lazy" decoding="async" class="max-h-16 max-w-full object-contain">
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="border-t border-slate-200 bg-slate-50">
    <div class="mx-auto max-w-4xl px-4 py-16 sm:px-6 lg:px-8">
        <h2 class="font-display text-2xl font-bold text-[#2A2A2D] sm:text-3xl">Common Questions</h2>
        <div class="mt-6">
            <?php render_faq_accordion($homeFaqs, 'home-faq'); ?>
        </div>
        <a href="<?= e(url('/faq')) ?>" class="mt-6 inline-block text-sm font-semibold text-[#B61F24]">View all FAQs &rarr;</a>
    </div>
</section>

<?php render_cta_banner(); ?>

<?php render_footer(); ?>
