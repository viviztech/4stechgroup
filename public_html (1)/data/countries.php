<?php

declare(strict_types=1);

/**
 * Country data for the /markets/africa regional breakdown and the
 * sitewide "40+ countries served" listings. Flags are rendered from
 * the ISO 3166-1 alpha-2 code via flag_emoji() in src/helpers.php —
 * no flag image assets required.
 */

return [
    'gcc' => [
        ['name' => 'United Arab Emirates', 'iso2' => 'AE', 'market_slug' => 'uae'],
        ['name' => 'Sultanate of Oman', 'iso2' => 'OM', 'market_slug' => 'oman'],
        ['name' => 'Kingdom of Bahrain', 'iso2' => 'BH', 'market_slug' => 'bahrain'],
        ['name' => 'Kuwait', 'iso2' => 'KW', 'market_slug' => 'kuwait'],
        ['name' => 'Qatar', 'iso2' => 'QA', 'market_slug' => 'qatar'],
    ],
    'south_asia' => [
        ['name' => 'India', 'iso2' => 'IN', 'market_slug' => 'india'],
    ],
    'africa' => [
        'west_central' => [
            'label' => 'West & Central Africa',
            'countries' => [
                ['name' => 'Nigeria', 'iso2' => 'NG'],
                ['name' => 'Ghana', 'iso2' => 'GH'],
                ['name' => 'Senegal', 'iso2' => 'SN'],
                ['name' => 'Ivory Coast', 'iso2' => 'CI'],
                ['name' => 'Benin', 'iso2' => 'BJ'],
                ['name' => 'Gambia', 'iso2' => 'GM'],
                ['name' => 'Liberia', 'iso2' => 'LR'],
                ['name' => 'Mali', 'iso2' => 'ML'],
                ['name' => 'Mauritania', 'iso2' => 'MR'],
                ['name' => 'Niger', 'iso2' => 'NE'],
                ['name' => 'Togo', 'iso2' => 'TG'],
                ['name' => 'Congo', 'iso2' => 'CD'],
                ['name' => 'Republic of the Congo', 'iso2' => 'CG'],
                ['name' => 'Angola', 'iso2' => 'AO'],
            ],
        ],
        'east' => [
            'label' => 'East Africa',
            'countries' => [
                ['name' => 'Kenya', 'iso2' => 'KE'],
                ['name' => 'Tanzania', 'iso2' => 'TZ'],
                ['name' => 'Uganda', 'iso2' => 'UG'],
                ['name' => 'Ethiopia', 'iso2' => 'ET'],
                ['name' => 'Rwanda', 'iso2' => 'RW'],
                ['name' => 'Burundi', 'iso2' => 'BI'],
                ['name' => 'Djibouti', 'iso2' => 'DJ'],
                ['name' => 'Somalia', 'iso2' => 'SO'],
                ['name' => 'Somali Land', 'iso2' => 'SO'],
                ['name' => 'South Sudan', 'iso2' => 'SS'],
                ['name' => 'Seychelles', 'iso2' => 'SC'],
                ['name' => 'Madagascar', 'iso2' => 'MG'],
                ['name' => 'Mauritius', 'iso2' => 'MU'],
            ],
        ],
        'southern' => [
            'label' => 'Southern Africa',
            'countries' => [
                ['name' => 'South Africa', 'iso2' => 'ZA'],
                ['name' => 'Zambia', 'iso2' => 'ZM'],
                ['name' => 'Malawi', 'iso2' => 'MW'],
                ['name' => 'Mozambique', 'iso2' => 'MZ'],
                ['name' => 'Namibia', 'iso2' => 'NA'],
            ],
        ],
        'north' => [
            'label' => 'North Africa',
            'countries' => [
                ['name' => 'Morocco', 'iso2' => 'MA'],
                ['name' => 'Tunisia', 'iso2' => 'TN'],
                ['name' => 'Algeria', 'iso2' => 'DZ'],
                ['name' => 'Sudan', 'iso2' => 'SD'],
            ],
        ],
    ],
];
