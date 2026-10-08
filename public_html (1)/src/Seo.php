<?php

declare(strict_types=1);

/**
 * Schema.org JSON-LD builders. Every function returns a plain array;
 * templates/schema.php is responsible for json_encode-ing and
 * printing them inside <script type="application/ld+json"> tags.
 */
final class Seo
{
    public static function organization(): array
    {
        $entities = config('entities');

        $subOrganizations = [];
        foreach ($entities as $entity) {
            $subOrganizations[] = [
                '@type' => 'Organization',
                'name' => $entity['legal_name'],
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => $entity['address_line'],
                    'addressLocality' => $entity['locality'],
                    'addressRegion' => $entity['region'],
                    'postalCode' => $entity['postal_code'],
                    'addressCountry' => $entity['country_code'],
                ],
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'contactType' => 'sales',
                    'telephone' => $entity['phone'],
                    'email' => $entity['email'],
                    'availableLanguage' => ['en'],
                ],
            ];
        }

        $countries = data('countries');
        $areaServed = ['India', 'United Arab Emirates', 'Oman', 'Bahrain', 'Kuwait', 'Qatar'];
        foreach ($countries['africa'] as $region) {
            foreach ($region['countries'] as $country) {
                $areaServed[] = $country['name'];
            }
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            '@id' => url('/#organization'),
            'name' => config('site_name'),
            'url' => url('/'),
            'logo' => url('/assets/images/4s-tech-logo.png'),
            'description' => config('default_meta_description'),
            'areaServed' => array_values(array_unique($areaServed)),
            'subOrganization' => $subOrganizations,
            'sameAs' => array_values(array_filter([config('social.linkedin')])),
        ];
    }

    public static function website(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            '@id' => url('/#website'),
            'url' => url('/'),
            'name' => config('site_name'),
            'publisher' => ['@id' => url('/#organization')],
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => 'EntryPoint',
                    'urlTemplate' => url('/faq') . '?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /** @param array<int, array{name: string, url: string}> $items */
    public static function breadcrumbs(array $items): array
    {
        $listItems = [];
        foreach ($items as $index => $item) {
            $listItems[] = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['name'],
                'item' => $item['url'],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => $listItems,
        ];
    }

    /** @param array<int, array{q: string, a: string}> $faqs */
    public static function faqPage(array $faqs): array
    {
        $entities = [];
        foreach ($faqs as $faq) {
            $entities[] = [
                '@type' => 'Question',
                'name' => $faq['q'],
                'acceptedAnswer' => [
                    '@type' => 'Answer',
                    'text' => $faq['a'],
                ],
            ];
        }

        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => $entities,
        ];
    }

    public static function product(array $product, string $slug, string $pageUrl): array
    {
        $images = product_images($slug);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product['name'],
            'description' => $product['intro'],
            'url' => $pageUrl,
            'image' => array_map(static fn (array $image): string => url($image['src']), $images),
            'brand' => [
                '@type' => 'Brand',
                'name' => config('site_name_short'),
            ],
            'category' => $product['short_name'] ?? $product['name'],
        ];
    }
}
