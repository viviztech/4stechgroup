<?php

declare(strict_types=1);

/**
 * Visible breadcrumb trail. The matching BreadcrumbList schema is
 * built separately (see Seo::breadcrumbs) from the same $items array
 * so the two never drift apart.
 *
 * @param array<int, array{name: string, url: string}> $items
 */
function render_breadcrumbs(array $items): void
{
    if (count($items) < 2) {
        return;
    }
    ?>
    <nav aria-label="Breadcrumb" class="border-b border-slate-200 bg-slate-50">
        <ol class="mx-auto flex max-w-7xl flex-wrap items-center gap-1 px-4 py-3 text-sm text-slate-500 sm:px-6 lg:px-8">
            <?php foreach ($items as $index => $item): ?>
                <?php $isLast = $index === array_key_last($items); ?>
                <li class="flex items-center gap-1">
                    <?php if ($index > 0): ?><span aria-hidden="true" class="mx-1 text-slate-300">/</span><?php endif; ?>
                    <?php if ($isLast): ?>
                        <span class="font-medium text-slate-700" aria-current="page"><?= e($item['name']) ?></span>
                    <?php else: ?>
                        <a href="<?= e($item['url']) ?>" class="hover:text-[#082A5E]"><?= e($item['name']) ?></a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ol>
    </nav>
    <?php
}
