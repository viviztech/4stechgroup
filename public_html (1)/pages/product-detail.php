<?php

declare(strict_types=1);

/** @var array<string, string> $params */

$products = data('products');
$slug = $params['slug'] ?? '';

if (!isset($products[$slug])) {
    http_response_code(404);
    require __DIR__ . '/not-found.php';
    return;
}

$product = $products[$slug];
$images = product_images($slug);
$pageUrl = url('/products/' . $slug);

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Products', 'url' => url('/products')],
    ['name' => $product['short_name'], 'url' => $pageUrl],
];

render_header([
    'title' => $product['meta_title'],
    'description' => $product['meta_description'],
    'canonical' => '/products/' . $slug,
    'og_type' => 'product',
    'og_image' => $images[0]['src'] ?? '/assets/images/og/default.webp',
    'schemas' => [
        Seo::product($product, $slug, $pageUrl),
        Seo::breadcrumbs($breadcrumbItems),
        Seo::faqPage($product['faqs']),
    ],
]);
render_breadcrumbs($breadcrumbItems);
?>

<article>
    <section class="bg-slate-50">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 lg:grid-cols-2 lg:items-start lg:px-8 lg:py-16">
            <div>
                <p class="text-sm font-semibold uppercase tracking-wide text-[#C2410C]">Product / Service Line</p>
                <h1 class="mt-2 font-display text-3xl font-bold text-[#082A5E] sm:text-4xl"><?= e($product['name']) ?></h1>
                <p class="mt-4 text-lg text-slate-600"><?= e($product['intro']) ?></p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a href="<?= e(url('/request-quote')) ?>" class="inline-flex items-center justify-center rounded-md bg-[#C2410C] px-6 py-3 font-semibold text-white transition hover:bg-[#9A3412]">Request a Quote</a>
                    <a href="<?= e(url('/contact')) ?>" class="inline-flex items-center justify-center rounded-md border border-slate-300 px-6 py-3 font-semibold text-[#082A5E] transition hover:bg-white">Talk to Us</a>
                </div>
            </div>
            <div>
                <?php if ($images !== []): ?>
                    <?php $galleryImages = array_slice($images, 0, 4); $isSingle = count($galleryImages) === 1; ?>
                    <div class="grid grid-cols-2 gap-3">
                        <?php foreach ($galleryImages as $index => $image): ?>
                            <img
                                src="<?= e(asset('images/products/' . $slug . '/' . basename($image['src']))) ?>"
                                alt="<?= e($product['short_name'] . ' — ' . config('site_name_short') . ' supply reference ' . ($index + 1))?>"
                                width="<?= (int) $image['width'] ?>"
                                height="<?= (int) $image['height'] ?>"
                                loading="<?= $index === 0 ? 'eager' : 'lazy' ?>"
                                style="max-height:260px;padding:14px"
                                class="<?= $isSingle ? 'col-span-2 aspect-video' : 'aspect-square' ?> w-full rounded-lg border border-slate-200 bg-white object-contain"
                            >
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="flex aspect-video w-full items-center justify-center rounded-lg border border-dashed border-slate-300 bg-white text-center text-slate-400">
                        <span><!-- TODO: add product photography --><?= e($product['short_name']) ?><br><span class="text-sm">Photography coming soon</span></span>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
        <?php foreach ($product['sections'] as $section): ?>
            <div class="mb-10">
                <h2 class="font-display text-2xl font-bold text-[#082A5E]"><?= e($section['heading']) ?></h2>
                <div class="prose-slate mt-3 space-y-3 text-slate-600"><?= paragraphs($section['body']) ?></div>
            </div>
        <?php endforeach; ?>

        <div class="mb-10 rounded-lg border border-slate-200 bg-slate-50 p-6">
            <h2 class="font-display text-xl font-bold text-[#082A5E]">Typical Applications</h2>
            <ul class="mt-4 grid grid-cols-1 gap-x-6 gap-y-2 sm:grid-cols-2">
                <?php foreach ($product['applications'] as $application): ?>
                    <li class="flex items-start gap-2 text-slate-600">
                        <span aria-hidden="true" class="mt-1 text-[#C2410C]">&#10003;</span>
                        <span><?= e($application) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php if (!empty($product['related_industries'])): ?>
            <?php $industries = data('industries'); ?>
            <div class="mb-4">
                <h2 class="font-display text-xl font-bold text-[#082A5E]">Supplied To These Industries</h2>
                <div class="mt-4 flex flex-wrap gap-2">
                    <?php foreach ($product['related_industries'] as $industrySlug): ?>
                        <?php if (isset($industries[$industrySlug])): ?>
                            <a href="<?= e(url('/industries/' . $industrySlug)) ?>" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-medium text-slate-700 transition hover:border-[#082A5E] hover:text-[#082A5E]"><?= e($industries[$industrySlug]['name']) ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </section>

    <?php if (!empty($product['related_products'])): ?>
        <section class="bg-slate-50">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <h2 class="font-display text-2xl font-bold text-[#082A5E]">Related Products</h2>
                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    <?php foreach ($product['related_products'] as $relatedSlug): ?>
                        <?php if (isset($products[$relatedSlug])): ?>
                            <?php render_product_card($relatedSlug, $products[$relatedSlug]); ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <?php render_cta_banner(); ?>

    <?php if (!empty($product['faqs'])): ?>
        <section class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <h2 class="font-display text-2xl font-bold text-[#082A5E]">Frequently Asked Questions</h2>
            <div class="mt-6">
                <?php render_faq_accordion($product['faqs'], 'product-faq'); ?>
            </div>
        </section>
    <?php endif; ?>
</article>

<?php render_footer(); ?>
