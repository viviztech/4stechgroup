<?php

declare(strict_types=1);

/**
 * Market/region pages: /markets/{slug}. Six priority country pages
 * plus a dedicated Africa page (data/countries.php supplies the
 * West/East/Southern/North breakdown used on that page).
 */

return [
    'uae' => [
        'name' => 'United Arab Emirates',
        'region' => 'GCC',
        'meta_title' => 'Engineering Products Supplier in UAE | 4S Tech Group',
        'meta_description' => 'Foures Tech Trading FZE LLC supplies engineering products, industrial materials and construction equipment across Dubai, Abu Dhabi, Sharjah and the wider UAE.',
        'intro' => "The UAE is home to Foures Tech Trading FZE LLC, our free-zone entity and the operational base for GCC and Africa-bound shipments. We supply engineering products across Dubai, Abu Dhabi and Sharjah to construction, oil & gas, marine and industrial clients, drawing on the full 19-line product range from container houses and GRP water tanks to flanges, pumps, valves and electrical enclosures.",
        'body' => "Our UAE operation is positioned specifically to serve as a regional sourcing and re-export base — goods sourced through Foures Tech Trading FZE LLC move on to GCC and African destinations as well as serving the domestic UAE construction and industrial market directly. Dubai and Abu Dhabi's oil & gas, marine and construction sectors draw most heavily on our flanges & fittings, motors/pumps/valves and GRP enclosure lines, while UAE-based construction and infrastructure projects use our container house, prefabricated building and building materials lines.\n\nBeing UAE-based also means faster quotation turnaround and site visits for local clients, alongside the export documentation and freight-forwarding relationships that let us move consolidated shipments on to Oman, Bahrain, Kuwait, Qatar and African ports efficiently.",
        'keywords' => ['industrial equipment supplier UAE', 'engineering products trading company Dubai', 'industrial materials supplier Abu Dhabi Sharjah'],
    ],

    'india' => [
        'name' => 'India',
        'region' => 'South Asia',
        'meta_title' => 'Engineering Products Supplier in India | 4S Tech Engineering',
        'meta_description' => '4S Tech Engineering supplies and manufactures engineering products from India, serving domestic industrial clients and exporting to the GCC and 40+ African countries.',
        'intro' => '4S Tech Engineering is our India entity — the engineering, manufacturing and sourcing base behind the group. From India we manufacture SMC/GRP products, design and build compression and injection moulding tools, and source the full range of industrial materials and equipment we export to the GCC and Africa.',
        'body' => "India's manufacturing base gives us direct control over quality and lead time for our SMC/GRP product lines — water tanks, electrical enclosures, chequered plates and moulding tooling — rather than relying on third-party trading stock for these categories. We also serve India's own domestic industrial market, supplying construction, steel, food processing and power sector clients across the country.\n\nFrom an export standpoint, India is a natural sourcing hub for the GCC and African markets we serve: competitive manufacturing cost, established sea-freight routes to Gulf and African ports, and engineering capability across the composite, structural steel and electrical product categories that make up most of our 19-line catalogue.",
        'keywords' => ['engineering products supplier India', 'SMC GRP manufacturer India', 'industrial procurement company India'],
    ],

    'oman' => [
        'name' => 'Sultanate of Oman',
        'region' => 'GCC',
        'meta_title' => 'Engineering Products Supplier in Oman | 4S Tech Group',
        'meta_description' => 'Industrial equipment, GRP water tanks, flanges, fittings and site infrastructure supplied to construction, oil & gas and marine projects across Oman.',
        'intro' => "Oman's oil & gas, marine and construction sectors are supplied from our UAE base, giving Omani clients access to the same 19-line product range — piping materials, GRP tanks and enclosures, container houses and building materials — with consolidated shipping from Dubai into Omani ports.",
        'body' => "Oman's port and industrial infrastructure — including Sohar, Duqm and Salalah — supports both direct project delivery and onward distribution, and we coordinate shipments to match Omani project schedules whether the order is a single piping material package or a full site infrastructure package for a new industrial or marine facility.",
        'keywords' => ['industrial equipment supplier Oman', 'engineering products supplier Muscat Sohar Duqm'],
    ],

    'qatar' => [
        'name' => 'Qatar',
        'region' => 'GCC',
        'meta_title' => 'Engineering Products Supplier in Qatar | 4S Tech Group',
        'meta_description' => 'Industrial equipment, electrical enclosures, pumps, valves and construction materials supplied to projects across Qatar from our UAE and India supply base.',
        'intro' => 'Qatar\'s construction, energy and industrial projects are served from our UAE operation, supplying the full range of engineering products — from GRP electrical enclosures and water tanks to structural steel materials and site infrastructure — with consolidated shipping into Qatari ports.',
        'body' => "Qatar's continued infrastructure and energy-sector investment keeps demand strong for the categories we specialise in — weatherproof electrical enclosures, piping materials, and site/building infrastructure — and we work with contractors and industrial clients to schedule delivery against Qatari project construction programmes.",
        'keywords' => ['industrial equipment supplier Qatar', 'engineering products supplier Doha'],
    ],

    'kuwait' => [
        'name' => 'Kuwait',
        'region' => 'GCC',
        'meta_title' => 'Engineering Products Supplier in Kuwait | 4S Tech Group',
        'meta_description' => 'Oil & gas piping materials, industrial pumps and valves, GRP enclosures and construction materials supplied to projects across Kuwait.',
        'intro' => "Kuwait's oil & gas sector is a core market for our flanges & fittings, motors/pumps/valves and GRP enclosure lines, supplied from our UAE base with the material certification and documentation Kuwaiti oil & gas procurement requires.",
        'body' => "Beyond oil & gas, we supply Kuwaiti construction and industrial clients across our building materials, container house and electrical/plumbing lines, coordinating shipments from our UAE and India supply base into Kuwaiti ports against project schedules.",
        'keywords' => ['industrial equipment supplier Kuwait', 'oil and gas materials supplier Kuwait'],
    ],

    'bahrain' => [
        'name' => 'Kingdom of Bahrain',
        'region' => 'GCC',
        'meta_title' => 'Engineering Products Supplier in Bahrain | 4S Tech Group',
        'meta_description' => 'Industrial equipment, GRP water tanks, electrical enclosures and construction materials supplied to projects across the Kingdom of Bahrain.',
        'intro' => 'Bahrain\'s construction, industrial and marine sectors are supplied from our UAE base with the same 19-line product range available across the wider GCC — piping materials, GRP tanks and enclosures, and site infrastructure.',
        'body' => "We coordinate shipments into Bahrain to match project schedules, whether supplying a single product category or a consolidated multi-category order for a construction, industrial or marine facility project.",
        'keywords' => ['industrial equipment supplier Bahrain', 'engineering products supplier Manama'],
    ],

    'africa' => [
        'name' => 'Africa',
        'region' => 'Africa',
        'meta_title' => 'Industrial Equipment Supplier for Africa | 4S Tech Group',
        'meta_description' => 'Engineering products export to Nigeria, Kenya, Ghana, South Africa and 40+ African countries — container houses, GRP tanks, cold storage and construction materials.',
        'intro' => 'We export engineering products to 40+ African countries across West, East, Southern and North Africa, supplying construction, agricultural, oil & gas and food processing projects with container houses, GRP water tanks, cold storage, structural steel materials and general industrial supplies.',
        'body' => "Africa is a core strategic market for our one-stop procurement model. Infrastructure, agricultural and industrial projects across the continent frequently face the same constraint: local availability of specialised engineering products is limited, and importing from multiple separate suppliers adds cost and delay that a consolidated procurement relationship removes. We address this directly — sourcing, quality-checking and consolidating shipments across our full 19-line catalogue into fewer, better-coordinated deliveries to West, East, Southern and North African ports and inland destinations.\n\nOur cold storage, silo and tank, and container house/prefabricated building lines are particularly active across African agricultural and construction projects, supporting produce cold-chain infrastructure, bulk storage and fast-mobilised site facilities. Flanges, fittings, pumps and valves support oil & gas and industrial projects across markets including Nigeria and Angola, while our building materials and electrical/plumbing lines serve general construction demand across the continent.\n\nWe manage export documentation, customs paperwork and destination-country compliance requirements as part of every African shipment, and coordinate phased delivery for multi-country or multi-site programmes run by contractors, NGOs and government-backed development projects.",
        'keywords' => ['industrial equipment supplier for Africa', 'engineering products export to Nigeria', 'engineering products export to Kenya', 'engineering products export to Ghana', 'industrial materials supplier East Africa West Africa'],
    ],
];
