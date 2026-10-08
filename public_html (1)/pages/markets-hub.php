<?php

declare(strict_types=1);

$markets = data('markets');
$countries = data('countries');
$stats = config('stats');

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Global Reach', 'url' => url('/markets')],
];

render_header([
    'title' => 'Global Reach | India, GCC & 40+ African Countries | 4S Tech Group',
    'description' => 'We supply engineering products to India, the UAE, Oman, Bahrain, Kuwait, Qatar and 40+ African countries across West, East, Southern and North Africa.',
    'canonical' => '/markets',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<section class="bg-slate-50">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="font-display text-3xl font-bold text-[#082A5E] sm:text-4xl">Global Reach</h1>
        <p class="mt-4 max-w-3xl text-lg text-slate-600">4S Tech Engineering (India) and Foures Tech Trading FZE LLC (UAE) supply engineering products across South Asia, the GCC and 40+ African countries — a single procurement relationship across three regions.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8" x-data="{ region: 'india' }">
    <div class="flex flex-wrap gap-2" role="tablist" aria-label="Region">
        <button type="button" role="tab" :aria-selected="(region === 'india').toString()" @click="region = 'india'" :class="region === 'india' ? 'bg-[#082A5E] text-white' : 'bg-slate-100 text-slate-700'" class="rounded-full px-5 py-2 text-sm font-semibold">India</button>
        <button type="button" role="tab" :aria-selected="(region === 'gcc').toString()" @click="region = 'gcc'" :class="region === 'gcc' ? 'bg-[#082A5E] text-white' : 'bg-slate-100 text-slate-700'" class="rounded-full px-5 py-2 text-sm font-semibold">GCC</button>
        <button type="button" role="tab" :aria-selected="(region === 'africa').toString()" @click="region = 'africa'" :class="region === 'africa' ? 'bg-[#082A5E] text-white' : 'bg-slate-100 text-slate-700'" class="rounded-full px-5 py-2 text-sm font-semibold">Africa</button>
    </div>

    <div class="mt-8" x-show="region === 'india'">
        <a href="<?= e(url('/markets/india')) ?>" class="block max-w-xl rounded-lg border border-slate-200 p-6 transition hover:shadow-lg">
            <h2 class="font-display text-xl font-semibold text-[#082A5E]"><?= flag_emoji('IN') ?> India</h2>
            <p class="mt-2 text-slate-600"><?= e(truncate($markets['india']['intro'], 180)) ?></p>
            <span class="mt-3 inline-block text-sm font-semibold text-[#C2410C]">Learn more &rarr;</span>
        </a>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3" x-show="region === 'gcc'" x-cloak>
        <?php foreach ($countries['gcc'] as $country): ?>
            <?php $market = $markets[$country['market_slug']] ?? null; ?>
            <?php if ($market !== null): ?>
                <a href="<?= e(url('/markets/' . $country['market_slug'])) ?>" class="rounded-lg border border-slate-200 p-5 transition hover:shadow-lg">
                    <h3 class="font-display font-semibold text-[#082A5E]"><?= flag_emoji($country['iso2']) ?> <?= e($country['name']) ?></h3>
                    <span class="mt-2 inline-block text-sm font-semibold text-[#C2410C]">View market &rarr;</span>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <div class="mt-8" x-show="region === 'africa'" x-cloak>
        <a href="<?= e(url('/markets/africa')) ?>" class="block rounded-lg border border-slate-200 p-6 transition hover:shadow-lg">
            <h2 class="font-display text-xl font-semibold text-[#082A5E]">🌍 Africa — 40+ Countries</h2>
            <p class="mt-2 max-w-2xl text-slate-600"><?= e(truncate($markets['africa']['intro'], 220)) ?></p>
            <span class="mt-3 inline-block text-sm font-semibold text-[#C2410C]">Explore West / East / Southern / North Africa &rarr;</span>
        </a>
    </div>
</section>

<?php render_cta_banner(); ?>

<?php render_footer(); ?>
