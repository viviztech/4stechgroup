<?php

declare(strict_types=1);

/**
 * Prints one <script type="application/ld+json"> block per schema
 * array. Called from templates/header.php with the sitewide
 * Organization/WebSite graph plus whatever page-specific schemas
 * (Product, FAQPage, BreadcrumbList) the current page supplied.
 *
 * @param array<int, array<string, mixed>> $schemas
 */
function render_schema(array $schemas): void
{
    foreach ($schemas as $schema) {
        if ($schema === []) {
            continue;
        }
        echo '<script type="application/ld+json">'
            . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            . "</script>\n";
    }
}
