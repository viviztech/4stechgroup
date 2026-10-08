<?php

declare(strict_types=1);

$faqGroups = data('faqs');
$allFaqs = array_merge(...array_values($faqGroups));

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'FAQ', 'url' => url('/faq')],
];

render_header([
    'title' => 'FAQ | Products, Shipping, Certifications & Ordering | 4S Tech',
    'description' => 'Answers on GRP water tanks, container houses, export & shipping to Africa/GCC, certifications and how to request a quote from 4S Tech Group.',
    'canonical' => '/faq',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems), Seo::faqPage($allFaqs)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<section class="bg-slate-50">
    <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <h1 class="font-display text-3xl font-bold text-[#082A5E] sm:text-4xl">Frequently Asked Questions</h1>
        <p class="mt-4 text-lg text-slate-600">Common questions from procurement teams on our products, export process, certifications and how to order — grouped by topic.</p>
    </div>
</section>

<section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
    <?php $index = 0; foreach ($faqGroups as $groupName => $faqs): ?>
        <div class="mb-12">
            <h2 class="font-display text-2xl font-bold text-[#082A5E]"><?= e($groupName) ?></h2>
            <div class="mt-4">
                <?php render_faq_accordion($faqs, 'faq-' . preg_replace('/[^a-z0-9]+/', '-', strtolower($groupName))); ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<?php render_cta_banner('Still have a question?', 'Reach out directly — our team replies to procurement enquiries within one business day.'); ?>

<?php render_footer(); ?>
