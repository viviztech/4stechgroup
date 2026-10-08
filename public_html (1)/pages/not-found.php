<?php

declare(strict_types=1);

$products = data('products');
$popular = array_slice($products, 0, 6, true);

render_header([
    'title' => 'Page Not Found | 4S Tech Group',
    'description' => 'The page you were looking for could not be found. Search our products or browse popular categories below.',
    'canonical' => '/404',
    'robots' => 'noindex, follow',
]);
?>

<section class="mx-auto max-w-3xl px-4 py-20 text-center sm:px-6 lg:px-8">
    <p class="font-display text-6xl font-bold text-[#082A5E]">404</p>
    <h1 class="mt-4 font-display text-2xl font-bold text-[#082A5E]">Page Not Found</h1>
    <p class="mt-3 text-slate-600">The page you're looking for may have moved or no longer exists. Try one of the links below, or head back to the homepage.</p>

    <form method="get" action="<?= e(url('/faq')) ?>" class="mx-auto mt-8 flex max-w-md gap-2">
        <label for="search" class="sr-only">Search</label>
        <input type="search" id="search" name="q" placeholder="Search products or FAQs&hellip;" class="w-full rounded-md border border-slate-300 px-4 py-2 focus:border-[#082A5E] focus:outline-none focus:ring-1 focus:ring-[#082A5E]">
        <button type="submit" class="rounded-md bg-[#082A5E] px-5 py-2 font-semibold text-white">Search</button>
    </form>

    <div class="mt-12 text-left">
        <h2 class="font-display text-lg font-semibold text-[#082A5E]">Popular Products</h2>
        <ul class="mt-4 grid grid-cols-1 gap-x-8 gap-y-2 sm:grid-cols-2">
            <?php foreach ($popular as $slug => $product): ?>
                <li><a href="<?= e(url('/products/' . $slug)) ?>" class="text-[#082A5E] hover:underline"><?= e($product['short_name']) ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <a href="<?= e(url('/')) ?>" class="mt-10 inline-flex items-center justify-center rounded-md bg-[#C2410C] px-6 py-3 font-semibold text-white transition hover:bg-[#9A3412]">Back to Homepage</a>
</section>

<?php render_footer(); ?>
