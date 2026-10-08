<?php

declare(strict_types=1);

/**
 * Opens the HTML document, prints all <head> SEO/AEO/GEO tags, and
 * renders the sticky header/nav plus floating WhatsApp button. Every
 * page calls this once before its own content, and render_footer()
 * once after.
 *
 * $meta keys: title, description, canonical (site-relative path),
 * og_type, og_image (site-relative path), robots, schemas (array of
 * extra JSON-LD blocks beyond the sitewide Organization/WebSite).
 */
function render_header(array $meta): void
{
    $canonicalPath = $meta['canonical'] ?? '/';

    // Per-page SEO title/description can be overridden from admin/seo-settings.php.
    // A page keeps its own hardcoded title/description below until an override
    // for its exact path is saved — this never changes anything on its own.
    $seoOverride = class_exists('Repository') ? Repository::seoOverride($canonicalPath) : null;

    $title = $seoOverride['meta_title'] ?? $meta['title'] ?? config('site_name');
    $description = truncate($seoOverride['meta_description'] ?? $meta['description'] ?? config('default_meta_description'));
    $canonical = url($canonicalPath);
    $ogImage = url($meta['og_image'] ?? '/assets/images/og/default.webp');
    $ogType = $meta['og_type'] ?? 'website';
    $robots = $meta['robots'] ?? 'index, follow';
    $schemas = array_merge([Seo::organization(), Seo::website()], $meta['schemas'] ?? []);

    $entities = config('entities');
    $productLinks = data('products');
    $industryLinks = data('industries');
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#001D62">
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <meta name="robots" content="<?= e($robots) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="en" href="<?= e($canonical) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e($canonical) ?>">

    <meta property="og:site_name" content="<?= e(config('site_name')) ?>">
    <meta property="og:type" content="<?= e($ogType) ?>">
    <meta property="og:title" content="<?= e($title) ?>">
    <meta property="og:description" content="<?= e($description) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($title) ?>">
    <meta name="twitter:description" content="<?= e($description) ?>">
    <meta name="twitter:image" content="<?= e($ogImage) ?>">

    <link rel="icon" href="<?= e(asset('images/4s-tech-logo.png')) ?>" type="image/png" sizes="any">
    <link rel="apple-touch-icon" href="<?= e(asset('images/4s-tech-logo.png')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/app.css')) ?>">
    <link rel="stylesheet" href="<?= e(asset('css/theme.css')) ?>">
    <link rel="preconnect" href="https://unpkg.com">

    <?php render_schema($schemas); ?>
</head>
<body class="min-h-screen bg-white font-body text-slate-800 antialiased" x-data="{ mobileNavOpen: false }">

<a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-50 focus:rounded focus:bg-white focus:px-4 focus:py-2 focus:shadow">Skip to content</a>

<header class="sticky top-0 z-40 border-b border-white/10 bg-[#082A5E] text-white shadow-sm">
    <div class="mx-auto flex h-16 max-w-7xl items-center justify-between gap-4 px-4 sm:h-20 sm:px-6 lg:px-8">
        <a href="<?= e(url('/')) ?>" class="flex h-full shrink-0 items-center py-1" aria-label="<?= e(config('site_name_short')) ?> home">
            <img src="<?= e(asset('images/4s-tech-logo.png')) ?>" alt="<?= e(config('site_name_short')) ?>" width="1420" height="1140" class="h-full w-auto rounded-lg object-contain">
        </a>

        <nav aria-label="Primary" class="hidden items-center gap-6 text-sm font-medium text-slate-300 lg:flex">
            <a href="<?= e(url('/products')) ?>" class="transition hover:text-[#FB923C]">Products</a>
            <a href="<?= e(url('/companies')) ?>" class="transition hover:text-[#FB923C]">Group Companies</a>
            <a href="<?= e(url('/industries')) ?>" class="transition hover:text-[#FB923C]">Industries</a>
            <a href="<?= e(url('/markets')) ?>" class="transition hover:text-[#FB923C]">Global Reach</a>
            <a href="<?= e(url('/portfolio')) ?>" class="transition hover:text-[#FB923C]">Portfolio</a>
            <a href="<?= e(url('/about')) ?>" class="transition hover:text-[#FB923C]">About</a>
            <a href="<?= e(url('/faq')) ?>" class="transition hover:text-[#FB923C]">FAQ</a>
            <a href="<?= e(url('/contact')) ?>" class="transition hover:text-[#FB923C]">Contact</a>
        </nav>

        <div class="flex items-center gap-3">
            <a href="<?= e(url('/request-quote')) ?>" class="hidden rounded-md bg-[#C2410C] px-4 py-2 text-sm font-semibold text-white transition hover:bg-[#9A3412] sm:inline-flex">Request Quote</a>
            <button
                type="button"
                @click="mobileNavOpen = !mobileNavOpen"
                :aria-expanded="mobileNavOpen.toString()"
                aria-controls="mobile-nav"
                class="inline-flex h-10 w-10 items-center justify-center rounded border border-white/10 text-white lg:hidden"
            >
                <span class="sr-only">Toggle menu</span>
                <span aria-hidden="true">&#9776;</span>
            </button>
        </div>
    </div>

    <nav
        id="mobile-nav"
        x-show="mobileNavOpen"
        x-cloak
        aria-label="Mobile"
        class="border-t border-white/10 bg-[#082A5E] px-4 py-4 lg:hidden"
    >
        <div class="flex flex-col gap-3 text-sm font-medium text-slate-300">
            <a href="<?= e(url('/products')) ?>" class="hover:text-[#FB923C]">Products</a>
            <a href="<?= e(url('/companies')) ?>" class="hover:text-[#FB923C]">Group Companies</a>
            <a href="<?= e(url('/industries')) ?>" class="hover:text-[#FB923C]">Industries</a>
            <a href="<?= e(url('/markets')) ?>" class="hover:text-[#FB923C]">Global Reach</a>
            <a href="<?= e(url('/portfolio')) ?>" class="hover:text-[#FB923C]">Portfolio</a>
            <a href="<?= e(url('/about')) ?>" class="hover:text-[#FB923C]">About</a>
            <a href="<?= e(url('/faq')) ?>" class="hover:text-[#FB923C]">FAQ</a>
            <a href="<?= e(url('/contact')) ?>" class="hover:text-[#FB923C]">Contact</a>
            <a href="<?= e(url('/request-quote')) ?>" class="mt-2 inline-flex justify-center rounded-md bg-[#C2410C] px-4 py-2 font-semibold text-white">Request Quote</a>
        </div>
    </nav>
</header>

<main id="main-content">
    <?php
}
