<?php

declare(strict_types=1);

function render_footer(): void
{
    $entities = config('entities');
    $products = data('products');
    $industries = data('industries');
    $year = date('Y');
    ?>
</main>

<footer class="border-t border-slate-200 bg-[#082A5E] text-slate-300">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-5">
            <div class="lg:col-span-2">
                <div class="flex items-center">
                    <img src="<?= e(asset('images/4s-tech-logo.png')) ?>" alt="<?= e(config('site_name_short')) ?>" width="1420" height="1140" class="h-20 w-auto" style="border-radius:8px; background:#fff; padding:4px 8px;">
                </div>
                <p class="mt-4 max-w-sm text-sm text-slate-400"><?= e(config('default_meta_description')) ?></p>

                <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <?php foreach ($entities as $entity): ?>
                        <address class="not-italic text-sm text-slate-400">
                            <p class="font-semibold text-white"><?= e($entity['legal_name']) ?></p>
                            <p class="mt-1"><?= e($entity['address_line']) ?></p>
                            <p class="mt-1"><a href="<?= e($entity['phone_href']) ?>" class="hover:text-white"><?= e($entity['phone']) ?></a></p>
                            <?php if (!empty($entity['phone_secondary'])): ?><p><a href="tel:<?= e(preg_replace('/\D+/', '', $entity['phone_secondary'])) ?>" class="hover:text-white"><?= e($entity['phone_secondary']) ?></a></p><?php endif; ?>
                            <p><a href="mailto:<?= e($entity['email']) ?>" class="hover:text-white"><?= e($entity['email']) ?></a></p>
                        </address>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white">Products</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <?php $count = 0; foreach ($products as $slug => $product): if ($count++ >= 8) break; ?>
                        <li><a href="<?= e(url('/products/' . $slug)) ?>" class="hover:text-white"><?= e($product['short_name']) ?></a></li>
                    <?php endforeach; ?>
                    <li><a href="<?= e(url('/products')) ?>" class="font-semibold text-[#C2410C]">View all products &rarr;</a></li>
                </ul>
            </div>

            <div>
                <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white">Industries</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <?php foreach ($industries as $slug => $industry): ?>
                        <li><a href="<?= e(url('/industries/' . $slug)) ?>" class="hover:text-white"><?= e($industry['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div>
                <h3 class="font-display text-sm font-semibold uppercase tracking-wide text-white">Company</h3>
                <ul class="mt-4 space-y-2 text-sm">
                    <li><a href="<?= e(url('/about')) ?>" class="hover:text-white">About Us</a></li>
                    <li><a href="<?= e(url('/companies')) ?>" class="hover:text-white">Group Companies</a></li>
                    <li><a href="<?= e(url('/portfolio')) ?>" class="hover:text-white">Portfolio</a></li>
                    <li><a href="<?= e(url('/markets')) ?>" class="hover:text-white">Global Reach</a></li>
                    <li><a href="<?= e(url('/faq')) ?>" class="hover:text-white">FAQ</a></li>
                    <li><a href="<?= e(url('/contact')) ?>" class="hover:text-white">Contact</a></li>
                    <li><a href="<?= e(url('/request-quote')) ?>" class="hover:text-white">Request a Quote</a></li>
                </ul>
            </div>
        </div>

        <div class="mt-10 flex flex-col items-start justify-between gap-4 border-t border-white/10 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center">
            <p>&copy; <?= (int) $year ?> <?= e(config('site_name')) ?>. All rights reserved.</p>
            <p><?= implode(' &middot; ', array_map(static fn (array $e): string => e($e['legal_name']) . ' (' . e($e['country']) . ')', $entities)) ?></p>
        </div>
    </div>
</footer>

<div class="fixed bottom-5 right-5 z-40 flex flex-col items-end gap-3">
    <?php foreach ($entities as $key => $entity): ?>
        <a
            href="<?= e($entity['whatsapp_href']) ?>"
            target="_blank"
            rel="noopener"
            aria-label="Chat on WhatsApp with our <?= e($entity['country']) ?> office"
            class="flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] text-lg text-white shadow-lg transition hover:brightness-95 sm:h-auto sm:w-auto sm:gap-2 sm:rounded-full sm:px-4 sm:py-3 sm:text-sm sm:font-semibold"
        >
            <span aria-hidden="true">&#9742;</span>
            <span class="hidden sm:inline"><?= e($entity['country']) ?> WhatsApp</span>
        </a>
    <?php endforeach; ?>
</div>

<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
    <?php
}
