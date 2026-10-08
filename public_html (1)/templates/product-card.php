<?php

declare(strict_types=1);

function render_product_card(string $slug, array $product): void
{
    $images = product_images($slug);
    $image = $images[0] ?? null;
    ?>
    <a href="<?= e(url('/products/' . $slug)) ?>" class="group flex flex-col overflow-hidden rounded-lg border border-slate-200 bg-white transition hover:-translate-y-1 hover:shadow-lg">
        <div class="aspect-[4/3] w-full overflow-hidden bg-slate-100">
            <?php if ($image !== null): ?>
                <img
                    src="<?= e(asset('images/products/' . $slug . '/' . basename($image['src']))) ?>"
                    alt="<?= e($product['short_name'] . ' supplied by ' . config('site_name_short')) ?>"
                    width="<?= (int) $image['width'] ?>"
                    height="<?= (int) $image['height'] ?>"
                    loading="lazy"
                    class="h-full w-full object-cover transition duration-300 group-hover:scale-105"
                >
            <?php else: ?>
                <div class="flex h-full w-full items-center justify-center bg-gradient-to-br from-[#082A5E] to-slate-700 text-center text-sm text-white/70">
                    <span><?= e($product['short_name']) ?><br><span class="text-xs">Photo coming soon</span></span>
                </div>
            <?php endif; ?>
        </div>
        <div class="flex flex-1 flex-col gap-2 p-5">
            <h3 class="font-display text-lg font-semibold text-[#082A5E] group-hover:text-[#C2410C]"><?= e($product['short_name']) ?></h3>
            <p class="line-clamp-3 flex-1 text-sm text-slate-600"><?= e($product['intro']) ?></p>
            <span class="mt-2 inline-flex items-center gap-1 text-sm font-semibold text-[#C2410C]">View product <span aria-hidden="true">&rarr;</span></span>
        </div>
    </a>
    <?php
}
