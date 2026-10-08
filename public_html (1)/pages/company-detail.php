<?php

declare(strict_types=1);

$entities = config('entities');
$slug = $params['slug'] ?? '';
$entity = $entities[$slug] ?? null;
if ($entity === null) {
    http_response_code(404);
    require __DIR__ . '/not-found.php';
    return;
}

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Group Companies', 'url' => url('/companies')],
    ['name' => $entity['legal_name'], 'url' => url('/companies/' . $slug)],
];
render_header([
    'title' => $entity['legal_name'] . ' | 4S Tech Group',
    'description' => $entity['description'],
    'canonical' => '/companies/' . $slug,
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<article>
    <section class="bg-slate-50">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-5 lg:px-8 lg:py-20">
            <div class="lg:col-span-3">
                <p class="text-sm font-semibold uppercase tracking-widest text-[#C2410C]"><?= e($entity['locality']) ?> · <?= e($entity['country']) ?></p>
                <h1 class="mt-3 font-display text-3xl font-bold text-[#082A5E] sm:text-5xl"><?= e($entity['legal_name']) ?></h1>
                <p class="mt-5 text-xl font-medium text-slate-700"><?= e($entity['focus']) ?></p>
                <p class="mt-5 max-w-3xl text-lg leading-8 text-slate-600"><?= e($entity['description']) ?></p>
            </div>
            <address class="not-italic rounded-lg border border-slate-200 bg-white p-6 shadow-sm lg:col-span-2">
                <p class="font-display font-semibold text-[#082A5E]">Contact this company</p>
                <p class="mt-4 text-sm leading-6 text-slate-600"><?= e($entity['address_line']) ?></p>
                <p class="mt-3"><a class="font-medium hover:underline" href="<?= e($entity['phone_href']) ?>"><?= e($entity['phone']) ?></a></p>
                <?php if (!empty($entity['phone_secondary'])): ?><p><a class="font-medium hover:underline" href="tel:<?= e(preg_replace('/\D+/', '', $entity['phone_secondary'])) ?>"><?= e($entity['phone_secondary']) ?></a></p><?php endif; ?>
                <p class="mt-1"><a class="font-medium text-[#C2410C] hover:underline" href="mailto:<?= e($entity['email']) ?>"><?= e($entity['email']) ?></a></p>
                <a href="<?= e($entity['whatsapp_href']) ?>" target="_blank" rel="noopener" class="mt-5 inline-flex rounded-md bg-[#25D366] px-4 py-2 text-sm font-semibold text-white">WhatsApp this office</a>
            </address>
        </div>
    </section>

    <section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
        <h2 class="font-display text-2xl font-bold text-[#082A5E]">Primary activities</h2>
        <ul class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($entity['services'] as $service): ?>
                <li class="border-l-4 border-[#C2410C] bg-slate-50 px-5 py-4 font-medium text-slate-700"><?= e($service) ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="mt-10 flex flex-wrap gap-4">
            <a href="<?= e(url('/request-quote')) ?>" class="rounded-md bg-[#C2410C] px-6 py-3 font-semibold text-white">Request a quote</a>
            <a href="<?= e(url('/products')) ?>" class="rounded-md border border-slate-300 px-6 py-3 font-semibold text-[#082A5E]">Explore products</a>
        </div>
    </section>
</article>

<?php render_footer(); ?>
