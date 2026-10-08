<?php

declare(strict_types=1);

$env = static function (string $key, ?string $default = null): ?string {
    static $loaded = null;
    if ($loaded === null) {
        $loaded = [];
        $envFile = dirname(__DIR__) . '/.env';
        if (is_file($envFile)) {
            foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                $line = trim($line);
                if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
                [$k, $v] = explode('=', $line, 2);
                $loaded[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
            }
        }
    }
    return $loaded[$key] ?? ($_ENV[$key] ?? $default);
};

return [
    'app_env' => $env('APP_ENV', 'production'),
    'debug' => filter_var($env('APP_DEBUG', 'false'), FILTER_VALIDATE_BOOLEAN),
    'base_url' => rtrim($env('BASE_URL', 'https://4stechgroup.com'), '/'),
    'site_name' => '4S Tech Group',
    'site_name_short' => '4S Tech Group',
    'tagline' => 'Engineering services and procurement across India, the GCC and Africa.',
    'default_meta_description' => '4S Tech Group provides technical services, engineering products, procurement and industrial supply through three companies in Dubai, Ajman and Chennai.',

    'entities' => [
        'technical-services-uae' => [
            'slug' => 'technical-services-uae',
            'legal_name' => 'Foures Tech Technical Services LLC',
            'short_name' => 'Technical Services UAE',
            'country' => 'United Arab Emirates', 'country_code' => 'AE',
            'address_line' => 'Dubai, United Arab Emirates',
            'locality' => 'Dubai', 'region' => 'Dubai', 'postal_code' => '',
            'phone' => '+971 58 656 3889', 'phone_href' => 'tel:+971586563889',
            'whatsapp' => '+971 58 656 3889', 'whatsapp_href' => 'https://wa.me/971586563889',
            'email' => 'info@4stechgroup.com',
            'focus' => 'On-site technical services and project execution',
            'description' => 'Technical contracting and project services for industrial construction, marine and shipping, energy, oil and gas, cold stores, GRP/SMC water tanks and solar parking structures.',
            'services' => ['Industrial construction', 'Marine and shipping', 'Energy, petrochemical and oil & gas', 'Cold store works', 'GRP/SMC panel water tanks', 'Solar parking structures'],
        ],
        'trading-uae' => [
            'slug' => 'trading-uae',
            'legal_name' => 'Foures Tech Trading FZE LLC',
            'short_name' => 'Trading UAE',
            'country' => 'United Arab Emirates', 'country_code' => 'AE',
            'address_line' => 'Ajman, United Arab Emirates',
            'locality' => 'Ajman', 'region' => 'Ajman', 'postal_code' => '',
            'phone' => '+971 58 656 3889', 'phone_href' => 'tel:+971586563889',
            'whatsapp' => '+971 58 656 3889', 'whatsapp_href' => 'https://wa.me/971586563889',
            'email' => 'trading@4stechgroup.com',
            'focus' => 'Engineering products, sourcing and international trade',
            'description' => 'UAE trading and export company supplying engineering products and project materials across the GCC and Africa.',
            'services' => ['Engineering product supply', 'Multi-category procurement', 'Vendor consolidation', 'Export and logistics coordination', 'GCC and Africa supply'],
        ],
        'engineering-india' => [
            'slug' => 'engineering-india',
            'legal_name' => '4S Tech Engineering',
            'short_name' => 'Engineering India',
            'country' => 'India', 'country_code' => 'IN',
            'address_line' => 'No. 19A, Chellammal Nagar, Noombal, Chennai - 600 077, Tamil Nadu, India',
            'locality' => 'Chennai', 'region' => 'Tamil Nadu', 'postal_code' => '600077',
            'phone' => '+91 96554 41413', 'phone_secondary' => '+91 95667 11144',
            'phone_href' => 'tel:+919655441413',
            'whatsapp' => '+91 96554 41413', 'whatsapp_href' => 'https://wa.me/919655441413',
            'email' => 'engineering@4stechgroup.com',
            'focus' => 'Engineering, manufacturing and India sourcing',
            'description' => 'Chennai engineering and sourcing company supporting product manufacture, technical coordination and industrial supply in India and international markets.',
            'services' => ['Engineering support', 'Product manufacturing', 'Industrial sourcing', 'Quality coordination', 'India project supply'],
        ],
    ],
    'stats' => [
        ['value' => '3', 'label' => 'Group Companies'],
        ['value' => '40+', 'label' => 'Countries Served'],
        ['value' => '19', 'label' => 'Product & Service Lines'],
        ['value' => '12', 'label' => 'Industries Supplied'],
    ],
    'social' => ['linkedin' => ''],
    'mail' => [
        'host' => $env('SMTP_HOST', 'smtp.example.com'),
        'port' => (int) $env('SMTP_PORT', '587'),
        'username' => $env('SMTP_USERNAME', ''), 'password' => $env('SMTP_PASSWORD', ''),
        'encryption' => $env('SMTP_ENCRYPTION', 'tls'),
        'from_email' => $env('MAIL_FROM_EMAIL', 'no-reply@4stechgroup.com'),
        'from_name' => $env('MAIL_FROM_NAME', '4S Tech Group Website'),
        'to_email' => $env('MAIL_TO_EMAIL', 'info@4stechgroup.com'),
    ],
    'database_path' => dirname(__DIR__) . '/storage/app.sqlite',
    'uploads_path' => dirname(__DIR__) . '/uploads',
    'uploads_url' => '/uploads',
    'max_upload_bytes' => 5 * 1024 * 1024,

    // Admin panel content database (company info, team, industries,
    // products, countries, settings, SEO overrides). Separate from
    // database_path above, which continues to hold contact/quote form
    // enquiries only — see src/AdminDatabase.php. 'sqlite' needs no
    // setup (default, used for local dev); 'mysql' uses the connection
    // details below (set DB_CONNECTION=mysql in .env to switch).
    'db_connection' => $env('DB_CONNECTION', 'sqlite'),
    'admin_database_path' => dirname(__DIR__) . '/storage/admin.sqlite',
    'mysql' => [
        'host' => $env('DB_HOST', '127.0.0.1'),
        'port' => (int) $env('DB_PORT', '3306'),
        'database' => $env('DB_NAME', ''),
        'username' => $env('DB_USER', ''),
        'password' => $env('DB_PASS', ''),
    ],
    // Optional: choose the first admin login instead of a random one when
    // bin/seed.php creates it. Both optional; only read once, at seed time.
    'admin_seed_username' => $env('ADMIN_USERNAME', ''),
    'admin_seed_password' => $env('ADMIN_PASSWORD', ''),
    'admin_uploads_path' => dirname(__DIR__) . '/uploads/admin',
    'admin_uploads_url' => '/uploads/admin',
    'admin_session_name' => '4stech_admin_session',
];
