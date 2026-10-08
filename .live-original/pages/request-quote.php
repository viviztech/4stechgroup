<?php

declare(strict_types=1);

$products = data('products');
$allowedExtensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png'];

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
    if (trim($_POST['website'] ?? '') !== '') {
        header('Location: ' . url('/request-quote?sent=1'));
        exit;
    }

    $errors = [];

    if (!Csrf::verify($_POST['csrf_token'] ?? null)) {
        $errors['csrf_token'] = 'Your session expired — please submit the form again.';
    }

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $company = trim($_POST['company'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $productCategory = trim($_POST['product_category'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');
    $destinationCountry = trim($_POST['destination_country'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name === '') {
        $errors['name'] = 'Please enter your name.';
    }
    if ($email === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Please enter a valid email address.';
    }
    if ($productCategory === '' || !isset($products[$productCategory])) {
        $errors['product_category'] = 'Please select a product category.';
    }
    if ($destinationCountry === '') {
        $errors['destination_country'] = 'Please enter a destination country.';
    }

    $attachmentPath = null;
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] !== UPLOAD_ERR_NO_FILE) {
        $file = $_FILES['attachment'];
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $errors['attachment'] = 'The file could not be uploaded — please try again.';
        } elseif ($file['size'] > (int) config('max_upload_bytes')) {
            $errors['attachment'] = 'The file is larger than 5 MB.';
        } else {
            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            if (!in_array($extension, $allowedExtensions, true)) {
                $errors['attachment'] = 'Allowed file types: PDF, Word, Excel, JPG, PNG.';
            } else {
                $uploadsDir = (string) config('uploads_path');
                if (!is_dir($uploadsDir)) {
                    mkdir($uploadsDir, 0755, true);
                }
                $safeName = bin2hex(random_bytes(16)) . '.' . $extension;
                $destination = $uploadsDir . '/' . $safeName;
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $attachmentPath = config('uploads_url') . '/' . $safeName;
                } else {
                    $errors['attachment'] = 'The file could not be saved — please try again.';
                }
            }
        }
    }

    if ($errors === []) {
        $enquiry = [
            'type' => 'rfq',
            'name' => $name,
            'company' => $company,
            'email' => $email,
            'phone' => $phone,
            'country' => $destinationCountry,
            'product_category' => $products[$productCategory]['name'],
            'quantity' => $quantity,
            'message' => $message,
            'attachment_path' => $attachmentPath,
            'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
        ];

        $stmt = Database::connection()->prepare(
            'INSERT INTO enquiries (type, name, company, email, phone, country, product_category, quantity, message, attachment_path, ip_address)
             VALUES (:type, :name, :company, :email, :phone, :country, :product_category, :quantity, :message, :attachment_path, :ip_address)'
        );
        $stmt->execute($enquiry);

        Mailer::sendEnquiryNotification($enquiry);

        clear_old_input();
        header('Location: ' . url('/request-quote?sent=1'));
        exit;
    }

    $_SESSION['form_errors'] = $errors;
    $_SESSION['old_input'] = $_POST;
    header('Location: ' . url('/request-quote'));
    exit;
}

$sent = isset($_GET['sent']);

$breadcrumbItems = [
    ['name' => 'Home', 'url' => url('/')],
    ['name' => 'Request a Quote', 'url' => url('/request-quote')],
];

render_header([
    'title' => 'Request a Quote | 4S Tech Group',
    'description' => 'Request a quote for any of our 22 engineering product and service lines — select category, quantity and destination country, and attach a BOQ or spec sheet.',
    'canonical' => '/request-quote',
    'schemas' => [Seo::breadcrumbs($breadcrumbItems)],
]);
render_breadcrumbs($breadcrumbItems);
?>

<section class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
    <h1 class="font-display text-3xl font-bold text-[#2A2A2D] sm:text-4xl">Request a Quote</h1>
    <p class="mt-4 text-lg text-slate-600">Tell us what you need and where it's going. We aim to return a quotation within 24 hours.</p>

    <?php if ($sent): ?>
        <div role="status" class="mt-6 rounded-md border border-green-200 bg-green-50 p-4 text-green-800">Thank you — your quote request has been received. We'll respond within 24 hours.</div>
    <?php endif; ?>

    <?php if (field_error('csrf_token')): ?>
        <div role="alert" class="mt-4 rounded-md border border-red-200 bg-red-50 p-4 text-red-800"><?= e((string) field_error('csrf_token')) ?></div>
    <?php endif; ?>

    <form method="post" action="<?= e(url('/request-quote')) ?>" enctype="multipart/form-data" class="mt-8 space-y-5" novalidate>
        <?= Csrf::field() ?>
        <div class="hidden" aria-hidden="true">
            <label for="website">Leave this field empty</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="name" class="block text-sm font-medium text-slate-700">Full name *</label>
                <input type="text" id="name" name="name" required value="<?= old('name') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#2A2A2D] focus:outline-none focus:ring-1 focus:ring-[#2A2A2D]">
                <?php if (field_error('name')): ?><p class="mt-1 text-sm text-red-600"><?= e((string) field_error('name')) ?></p><?php endif; ?>
            </div>
            <div>
                <label for="company" class="block text-sm font-medium text-slate-700">Company</label>
                <input type="text" id="company" name="company" value="<?= old('company') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#2A2A2D] focus:outline-none focus:ring-1 focus:ring-[#2A2A2D]">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-slate-700">Email *</label>
                <input type="email" id="email" name="email" required value="<?= old('email') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#2A2A2D] focus:outline-none focus:ring-1 focus:ring-[#2A2A2D]">
                <?php if (field_error('email')): ?><p class="mt-1 text-sm text-red-600"><?= e((string) field_error('email')) ?></p><?php endif; ?>
            </div>
            <div>
                <label for="phone" class="block text-sm font-medium text-slate-700">Phone</label>
                <input type="tel" id="phone" name="phone" value="<?= old('phone') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#2A2A2D] focus:outline-none focus:ring-1 focus:ring-[#2A2A2D]">
            </div>
        </div>

        <div>
            <label for="product_category" class="block text-sm font-medium text-slate-700">Product category *</label>
            <select id="product_category" name="product_category" required class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#2A2A2D] focus:outline-none focus:ring-1 focus:ring-[#2A2A2D]">
                <option value="">Select a product category&hellip;</option>
                <?php foreach ($products as $slug => $product): ?>
                    <option value="<?= e($slug) ?>" <?= old('product_category') === $slug ? 'selected' : '' ?>><?= e($product['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (field_error('product_category')): ?><p class="mt-1 text-sm text-red-600"><?= e((string) field_error('product_category')) ?></p><?php endif; ?>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
            <div>
                <label for="quantity" class="block text-sm font-medium text-slate-700">Quantity</label>
                <input type="text" id="quantity" name="quantity" placeholder="e.g. 500 units / 20ft container" value="<?= old('quantity') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#2A2A2D] focus:outline-none focus:ring-1 focus:ring-[#2A2A2D]">
            </div>
            <div>
                <label for="destination_country" class="block text-sm font-medium text-slate-700">Destination country *</label>
                <input type="text" id="destination_country" name="destination_country" required value="<?= old('destination_country') ?>" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#2A2A2D] focus:outline-none focus:ring-1 focus:ring-[#2A2A2D]">
                <?php if (field_error('destination_country')): ?><p class="mt-1 text-sm text-red-600"><?= e((string) field_error('destination_country')) ?></p><?php endif; ?>
            </div>
        </div>

        <div>
            <label for="attachment" class="block text-sm font-medium text-slate-700">BOQ / specification sheet (optional)</label>
            <input type="file" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
            <p class="mt-1 text-xs text-slate-500">PDF, Word, Excel, JPG or PNG — max 5 MB.</p>
            <?php if (field_error('attachment')): ?><p class="mt-1 text-sm text-red-600"><?= e((string) field_error('attachment')) ?></p><?php endif; ?>
        </div>

        <div>
            <label for="message" class="block text-sm font-medium text-slate-700">Additional details</label>
            <textarea id="message" name="message" rows="4" class="mt-1 w-full rounded-md border border-slate-300 px-3 py-2 focus:border-[#2A2A2D] focus:outline-none focus:ring-1 focus:ring-[#2A2A2D]"><?= old('message') ?></textarea>
        </div>

        <button type="submit" class="inline-flex items-center justify-center rounded-md bg-[#B61F24] px-6 py-3 font-semibold text-white transition hover:bg-[#8F1A1E]">Submit Quote Request</button>
    </form>
</section>

<?php render_footer(); ?>
