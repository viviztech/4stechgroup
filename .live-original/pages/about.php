<?php

declare(strict_types=1);

$entities = config('entities');
$stats = config('stats');

// Editable from admin/company-info.php. Defaults are the site's original
// copy verbatim, so nothing changes here until an admin edits them.
$aboutHeroText = Repository::setting('about_hero_intro', null) ?? '4S Tech Group operates through three legal entities: Foures Tech Technical Services LLC in Dubai, Foures Tech Trading FZE LLC in Ajman, and 4S Tech Engineering in Chennai. Together, the companies provide on-site technical services, engineering, product supply and A-to-Z procurement for industrial construction, marine and shipping, energy, petrochemical, oil & gas, food and agricultural industries across India, the GCC and Africa.';
$aboutMissionPara1 = Repository::setting('about_mission_para1', null) ?? 'We exist to remove the friction from industrial procurement for clients building and operating across India, the Gulf and Africa. Rather than a single-category supplier, we source, quality-check and export across 22 product and service lines — from container houses and prefabricated buildings to GRP water tanks, electrical enclosures, flanges, pumps and valves, cold storage, and general building materials — so a project team can consolidate more of its procurement scope through one relationship instead of managing dozens of separate vendors.';
$aboutMissionPara2 = Repository::setting('about_mission_para2', null) ?? 'We are leaders in serving oil & gas plants, food industries, paper mills, airports, shipyards, chemical plants, steel plants & mills, electrical & electronics industries, computer peripherals, packing industries, agricultural industries and all construction industries.';

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'About', 'url' => url('/about')],
];

render_header([
    'title' => 'About 4S Tech Group | UAE & India Engineering Companies',
    'description' => 'Three 4S Tech Group companies in Dubai, Ajman and Chennai provide technical services, engineering products, procurement and industrial supply.',
    'canonical' => '/about',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<article>
    <section class="bg-slate-50">
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <h1 class="font-display text-3xl font-bold text-[#2A2A2D] sm:text-4xl">About 4S Tech Group</h1>
            <p class="mt-6 text-lg text-slate-600"><?= e($aboutHeroText) ?></p>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <dl class="grid grid-cols-2 gap-6 border-y border-slate-200 py-8 sm:grid-cols-4">
            <?php foreach ($stats as $stat): ?>
                <div class="text-center">
                    <dt class="sr-only"><?= e($stat['label']) ?></dt>
                    <dd class="font-display text-3xl font-bold text-[#2A2A2D] sm:text-4xl"><?= e($stat['value']) ?></dd>
                    <p class="mt-1 text-sm text-slate-500"><?= e($stat['label']) ?></p>
                </div>
            <?php endforeach; ?>
        </dl>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <h2 class="font-display text-2xl font-bold text-[#2A2A2D]">Our Mission</h2>
        <div class="prose-slate mt-4 space-y-4 text-slate-600">
            <p><?= e($aboutMissionPara1) ?></p>
            <p><?= e($aboutMissionPara2) ?></p>
        </div>

        <h2 class="mt-10 font-display text-2xl font-bold text-[#2A2A2D]">Why Clients Work With Us</h2>
        <div class="mt-4 grid grid-cols-1 gap-6 sm:grid-cols-2">
            <div class="rounded-lg border border-slate-200 p-5">
                <h3 class="font-display font-semibold text-[#2A2A2D]">One-Stop, A-to-Z Procurement</h3>
                <p class="mt-2 text-sm text-slate-600">22 product and service lines sourced, quality-checked and consolidated through a single supplier relationship, reducing the vendor management overhead of multi-category projects.</p>
            </div>
            <div class="rounded-lg border border-slate-200 p-5">
                <h3 class="font-display font-semibold text-[#2A2A2D]">India + UAE Manufacturing & Sourcing Base</h3>
                <p class="mt-2 text-sm text-slate-600">Direct manufacturing of our SMC/GRP product lines from India, paired with a UAE free-zone entity positioned for GCC and African export logistics.</p>
            </div>
            <div class="rounded-lg border border-slate-200 p-5">
                <h3 class="font-display font-semibold text-[#2A2A2D]">Regional Delivery Experience</h3>
                <p class="mt-2 text-sm text-slate-600">Established export documentation, freight and customs coordination for shipments into the GCC and 40+ African countries across West, East, Southern and North Africa.</p>
            </div>
            <div class="rounded-lg border border-slate-200 p-5">
                <h3 class="font-display font-semibold text-[#2A2A2D]">Material Traceability</h3>
                <p class="mt-2 text-sm text-slate-600">Mill test certificates and, where required, third-party inspection on piping and structural materials — documentation standards that meet oil &amp; gas and industrial procurement requirements.</p>
            </div>
        </div>
    </section>

    <section class="bg-slate-50">
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <h2 class="font-display text-2xl font-bold text-[#2A2A2D]">Our Group Companies</h2>
            <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-3">
                <?php foreach ($entities as $entity): ?>
                    <div class="rounded-lg bg-white p-6 shadow-sm">
                        <h3 class="font-display text-lg font-semibold text-[#2A2A2D]"><?= e($entity['legal_name']) ?></h3>
                        <p class="mt-1 text-sm font-medium text-[#B61F24]"><?= e($entity['country']) ?> Entity</p>
                        <p class="mt-3 text-sm text-slate-600"><?= e($entity['address_line']) ?></p>
                        <p class="mt-2 text-sm"><a href="<?= e($entity['phone_href']) ?>" class="text-[#2A2A2D] hover:underline"><?= e($entity['phone']) ?></a></p>
                        <p class="text-sm"><a href="mailto:<?= e($entity['email']) ?>" class="text-[#2A2A2D] hover:underline"><?= e($entity['email']) ?></a></p>
                        <a href="<?= e(url('/companies/' . $entity['slug'])) ?>" class="mt-4 inline-block text-sm font-semibold text-[#B61F24]">Company details &rarr;</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php $team = team_members_data(); ?>
    <?php if ($team !== []): ?>
        <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <h2 class="font-display text-2xl font-bold text-[#2A2A2D]">Our Team Members</h2>
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                <?php foreach ($team as $member): ?>
                    <div class="flex items-center gap-4 rounded-lg border border-slate-200 p-5">
                        <?php if (!empty($member['photo_path'])): ?>
                            <img src="<?= e(url($member['photo_path'])) ?>" alt="<?= e($member['name']) ?>" class="h-16 w-16 shrink-0 rounded-full object-cover">
                        <?php else: ?>
                            <span class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-slate-100 font-display text-xl font-semibold text-[#2A2A2D]" aria-hidden="true"><?= e(mb_substr($member['name'], 0, 1)) ?></span>
                        <?php endif; ?>
                        <div>
                            <p class="font-display font-semibold text-[#2A2A2D]"><?= e($member['name']) ?></p>
                            <p class="mt-1 text-sm font-medium text-[#B61F24]"><?= e($member['designation']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php render_cta_banner('Want to know more about how we work?', 'Get in touch — our team is happy to walk through our sourcing and export process.'); ?>
</article>

<?php render_footer(); ?>
