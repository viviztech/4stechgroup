<?php

declare(strict_types=1);

/**
 * Alpine-powered accordion. FAQ content is always in the static HTML
 * (fully crawlable) — Alpine only toggles visibility, it never
 * fetches or renders the questions/answers client-side.
 *
 * @param array<int, array{q: string, a: string}> $faqs
 */
function render_faq_accordion(array $faqs, string $idPrefix = 'faq'): void
{
    if ($faqs === []) {
        return;
    }
    ?>
    <div class="divide-y divide-slate-200 border-y border-slate-200">
        <?php foreach ($faqs as $index => $faq): ?>
            <div x-data="{ open: <?= $index === 0 ? 'true' : 'false' ?> }" class="py-4">
                <button
                    type="button"
                    @click="open = !open"
                    :aria-expanded="open.toString()"
                    aria-controls="<?= e($idPrefix) ?>-<?= (int) $index ?>"
                    class="flex w-full items-start justify-between gap-4 text-left"
                >
                    <span class="font-semibold text-[#082A5E]"><?= e($faq['q']) ?></span>
                    <span class="mt-1 shrink-0 text-slate-400" x-text="open ? '−' : '+'" aria-hidden="true"></span>
                </button>
                <div
                    id="<?= e($idPrefix) ?>-<?= (int) $index ?>"
                    x-show="open"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    class="mt-2 pr-8 text-slate-600"
                >
                    <p><?= e($faq['a']) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}
