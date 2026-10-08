<?php

declare(strict_types=1);

function render_cta_banner(
    string $heading = 'Get a quotation within 24 hours',
    string $subheading = 'Tell us your product, quantity and destination — our team will price and confirm lead time fast.'
): void {
    ?>
    <section class="bg-[#082A5E]">
        <div class="mx-auto flex max-w-7xl flex-col items-start justify-between gap-6 px-4 py-12 sm:px-6 lg:flex-row lg:items-center lg:px-8">
            <div>
                <h2 class="font-display text-2xl font-bold text-white sm:text-3xl"><?= e($heading) ?></h2>
                <p class="mt-2 max-w-xl text-slate-300"><?= e($subheading) ?></p>
            </div>
            <div class="flex shrink-0 flex-col gap-3 sm:flex-row">
                <a href="<?= e(url('/request-quote')) ?>" class="inline-flex items-center justify-center rounded-md bg-[#C2410C] px-6 py-3 font-semibold text-white transition hover:bg-[#9A3412]">Request a Quote</a>
                <a href="<?= e(url('/contact')) ?>" class="inline-flex items-center justify-center rounded-md border border-white/30 px-6 py-3 font-semibold text-white transition hover:bg-white/10">Contact Us</a>
            </div>
        </div>
    </section>
    <?php
}
