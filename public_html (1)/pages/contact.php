<?php

declare(strict_types=1);

$entities = config('entities');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    // Honeypot: real visitors never fill this hidden field in.
    if (trim($_POST['website'] ?? '') !== '') {
        header('Location: ' . url('/contact?sent=1'));
        exit;
    }

    $errors = [];

    if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
        $errors['csrf_token'] = 'Your session expired — please submit the form again.';
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $country = trim($_POST['country'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Please enter your name.';
    }
    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Please enter a valid email address.';
    }
    if ($message === '') {
        $errors['message'] = 'Please enter a message.';
    } elseif ((function_exists('mb_strlen') ? mb_strlen($message, 'UTF-8') : iconv_strlen($message, 'UTF-8')) > 4000) {
        $errors['message'] = 'Message is too long (4000 characters max).';
    }

    if ($errors === []) {
        $enquiry = [
            'type' => 'contact',
            'name' => $name,
            'company' => $company,
            'email' => $email,
            'phone' => $phone,
            'country' => $country,
            'product_category' => null,
            'quantity' => null,
            'message' => $message,
            'attachment_path' => null,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        ];

        $stmt = Database::connection()->prepare(
            'INSERT INTO enquiries (type, name, company, email, phone, country, product_category, quantity, message, attachment_path, ip_address)
             VALUES (:type, :name, :company, :email, :phone, :country, :product_category, :quantity, :message, :attachment_path, :ip_address)'
        );
        $stmt->execute($enquiry);

        Mailer::sendEnquiryNotification($enquiry);

        clear_old_input();
        header('Location: ' . url('/contact?sent=1'));
        exit;
    }

    $_SESSION['form_errors'] = $errors;
    $_SESSION['old_input'] = $_POST;
    header('Location: ' . url('/contact'));
    exit;
}

$sent = isset($_GET['sent']);

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Contact', 'url' => url('/contact')],
];

render_header([
    'title' => 'Contact Us | India & UAE Offices | 4S Tech Group',
    'description' => 'Contact 4S Tech Engineering (India) and Foures Tech Trading FZE LLC (UAE) — engineering products supply enquiries, WhatsApp click-to-chat and office details.',
    'canonical' => '/contact',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<section class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="font-display text-3xl font-bold text-[#082A5E] sm:text-4xl">Contact Us</h1>
    <p class="mt-4 max-w-2xl text-lg text-slate-600">Reach either office directly, or send an enquiry below and our team will respond within one business day.</p>

    <div class="mt-10 grid grid-cols-1 gap-10 lg:grid-cols-5">
        <div class="lg:col-span-2 space-y-6">
            <?php foreach ($entities as $entity): ?>
                <address class="not-italic rounded-lg border border-slate-200 p-6">
                    <h2 class="font-display text-lg font-semibold text-[#082A5E]"><?= e($entity['legal_name']) ?></h2>
                    <p class="mt-1 text-sm text-slate-500"><?= e($entity['country']) ?> Office</p>
                    <p class="mt-3 text-slate-600"><?= e($entity['address_line']) ?></p>
                    <p class="mt-2"><a href="<?= e($entity['phone_href']) ?>" class="text-[#082A5E] hover:underline"><?= e($entity['phone']) ?></a></p>
                    <?php if (!empty($entity['phone_secondary'])): ?><p><a href="tel:<?= e(preg_replace('/\D+/', '', $entity['phone_secondary'])) ?>" class="text-[#082A5E] hover:underline"><?= e($entity['phone_secondary']) ?></a></p><?php endif; ?>
                    <p><a href="mailto:<?= e($entity['email']) ?>" class="text-[#082A5E] hover:underline"><?= e($entity['email']) ?></a></p>
                    <a href="<?= e($entity['whatsapp_href']) ?>" target="_blank" rel="noopener" class="mt-4 inline-flex items-center gap-2 rounded-md bg-[#25D366] px-4 py-2 text-sm font-semibold text-white">WhatsApp <?= e($entity['country']) ?></a>
                </address>
            <?php endforeach; ?>
        </div>

        <div class="lg:col-span-3">
            <?php if ($sent): ?>
                <div role="status" class="rounded-md border border-green-200 bg-green-50 p-4 text-green-800">Thank you — your enquiry has been received. We'll be in touch within one business day.</div>
            <?php endif; ?>

            <?php if (field_error('csrf_token')): ?>
                <div role="alert" class="mt-4 rounded-md border border-red-200 bg-red-50 p-4 text-red-800"><?= e((string) field_error('csrf_token')) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= e(url('/contact')) ?>" class="mt-6 space-y-5" novalidate>
                <?= Csrf::field() ?>
                <div class="hidden" aria-hidden="true">
                    <label for="website">Leave this field empty</label>
                    <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                </div>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-700">Full name *</label>
                        <input type="text" id="name" name="name" required value="<?= old('name') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#082A5E] focus:outline-none focus:ring-1 focus:ring-[#082A5E]">
                        <?php if (field_error('name')): ?><p class="mt-1 text-sm text-red-600"><?= e((string) field_error('name')) ?></p><?php endif; ?>
                    </div>
                    <div>
                        <label for="company" class="block text-sm font-medium text-slate-700">Company</label>
                        <input type="text" id="company" name="company" value="<?= old('company') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#082A5E] focus:outline-none focus:ring-1 focus:ring-[#082A5E]">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700">Email *</label>
                        <input type="email" id="email" name="email" required value="<?= old('email') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#082A5E] focus:outline-none focus:ring-1 focus:ring-[#082A5E]">
                        <?php if (field_error('email')): ?><p class="mt-1 text-sm text-red-600"><?= e((string) field_error('email')) ?></p><?php endif; ?>
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-slate-700">Phone</label>
                        <input type="tel" id="phone" name="phone" value="<?= old('phone') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#082A5E] focus:outline-none focus:ring-1 focus:ring-[#082A5E]">
                    </div>
                    <div class="sm:col-span-2">
                        <label for="country" class="block text-sm font-medium text-slate-700">Country</label>
                        <input type="text" id="country" name="country" value="<?= old('country') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#082A5E] focus:outline-none focus:ring-1 focus:ring-[#082A5E]">
                    </div>
                </div>

                <div>
                    <label for="message" class="block text-sm font-medium text-slate-700">Message *</label>
                    <textarea id="message" name="message" rows="5" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#082A5E] focus:outline-none focus:ring-1 focus:ring-[#082A5E]"><?= old('message') ?></textarea>
                    <?php if (field_error('message')): ?><p class="mt-1 text-sm text-red-600"><?= e((string) field_error('message')) ?></p><?php endif; ?>
                </div>

                <button type="submit" class="inline-flex items-center justify-center rounded-md bg-[#C2410C] px-6 py-3 font-semibold text-white transition hover:bg-[#9A3412]">Send Enquiry</button>
            </form>
        </div>
    </div>
</section>

<?php render_footer(); ?>
