<?php

declare(strict_types=1);

/**
 * All product/service line content lives here. Each entry drives the
 * /products/{slug} page: intro (snippet-extraction target), three
 * benefit sections, applications, cross-links, and an FAQ block.
 * Images are discovered at render time from
 * /public/assets/images/products/{slug}/ — see product_images() in
 * src/helpers.php. Categories with no photo set yet render a
 * placeholder and are flagged with a TODO below.
 */

return [
    'container-houses' => [
        'name' => 'Container Houses & Fiberglass Modular Buildings',
        'short_name' => 'Container Houses & Modular Buildings',
        'meta_title' => 'Container House & Fiberglass Modular Building Supplier UAE',
        'meta_description' => 'Container houses, portable cabins and fiberglass modular buildings for classrooms, offices, clinics and site offices — supplied across the UAE, GCC and Africa.',
        'primary_keyword' => 'container house supplier UAE',
        'keywords' => ['fiberglass modular buildings', 'portable cabin supplier', 'prefab site office', 'modular classroom', 'porta cabin Dubai'],
        'intro' => 'A container house is a factory-built steel or fiberglass modular unit used as a classroom, office, clinic or temporary site facility. We supply container houses and fiberglass modular buildings to construction, education and healthcare projects across the UAE, GCC and 40+ African countries.',
        'sections' => [
            [
                'heading' => 'Build Specification & Materials',
                'body' => "Our container houses are built on a welded steel chassis with insulated fiberglass or sandwich-panel wall cladding, giving a unit that resists corrosion, UV degradation and the temperature swings typical of Gulf and African sites. Standard units are supplied with electrical wiring, window and door openings, and floor insulation as a baseline; specification can be upgraded to include air conditioning provision, fire-rated partitions and washroom pods for clinic or site-office use. Units are dimensioned to standard 20 ft and 40 ft footprints for ease of flat-rack or open-top container shipping, and can be furnished as single rooms or joined into multi-bay layouts for larger classroom blocks or labour accommodation. Every unit leaving our supply chain is built to withstand repeated relocation and re-installation, which matters for clients who redeploy the same stock across successive project phases rather than buying new for each site.",
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Container houses are specified wherever a project needs habitable or working space faster than conventional construction allows. Construction contractors use them as site offices, security cabins and labour welfare facilities from day one of mobilisation. Education authorities and NGOs use fiberglass modular classrooms to expand school capacity in Africa without waiting on masonry builds. Healthcare operators specify insulated, easy-to-clean modular clinics for rural and remote-site medical posts. Oil & gas and mining operators rely on the same product line for camp accommodation and technical offices on remote concessions, while shipyards and ports use them as dockside administrative cabins. Because the unit ships and installs as one piece, it suits any client working to a compressed programme where a masonry structure is not practical.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'We coordinate manufacture, containerised shipping, customs documentation and last-mile delivery for container houses moving from our India and UAE supply base into the GCC and West, East, Southern and North African markets. Orders are quoted against your floor plan, quantity and destination port, with typical production lead times confirmed at quotation stage and consolidated shipping offered for multi-unit school or camp projects. We handle the export paperwork end to end — commercial invoice, packing list, certificate of origin and any destination-specific compliance documents — so site teams in Lagos, Nairobi, Accra or Dar es Salaam receive units ready to position and connect, not a stack of unresolved import queries.',
            ],
        ],
        'applications' => ['Site offices & security cabins', 'Modular classrooms', 'Rural & remote-site clinics', 'Labour accommodation camps', 'Oil & gas field offices', 'NGO & relief housing'],
        'related_products' => ['prefabricated-buildings', 'sandwich-single-skin-sheets', 'electrical-enclosures', 'building-materials'],
        'related_industries' => ['construction', 'oil-and-gas', 'agriculture'],
        'faqs' => [
            ['q' => 'What is the difference between a container house and a prefabricated building?', 'a' => 'A container house is built around a fixed steel chassis sized for container shipping, so it arrives as one complete, movable unit. A prefabricated building is assembled on site from separate sandwich-panel or steel-frame components, giving more flexibility on final footprint but a longer on-site erection time.'],
            ['q' => 'How long do fiberglass modular buildings last?', 'a' => 'A well-specified fiberglass modular building typically gives 15–20+ years of service life, and considerably longer with periodic recoating, because the fiberglass skin does not rust and resists the UV and salt-air exposure common across Gulf and coastal African sites.'],
            ['q' => 'Can container houses be joined into larger buildings?', 'a' => 'Yes. Units are designed with matching connection points so multiple cabins can be joined side-by-side or stacked to form larger classroom blocks, office suites or camp facilities, while still shipping and relocating as individual modules if required.'],
            ['q' => 'What is the lead time for delivery to Africa or the GCC?', 'a' => 'Lead time depends on unit specification and order quantity; we confirm a firm production and shipping schedule at quotation stage and can offer consolidated shipping for multi-unit school, clinic or camp orders to reduce per-unit freight cost.'],
            ['q' => 'Do you supply container houses with electrical fit-out included?', 'a' => 'Standard units ship with internal wiring, distribution points and door/window openings pre-fitted. Air conditioning provision, washroom pods and fire-rated partitioning can be added as options depending on the intended use of the unit.'],
        ],
    ],

    'prefabricated-buildings' => [
        'name' => 'Prefabricated Buildings',
        'short_name' => 'Prefabricated Buildings',
        'meta_title' => 'Prefabricated Building Supplier UAE | Sandwich Panel Structures',
        'meta_description' => 'Sandwich panel and single-skin aluminium/GI sheet prefabricated buildings for warehouses, offices and industrial structures — designed and exported across the GCC and Africa.',
        'primary_keyword' => 'prefabricated building supplier UAE',
        'keywords' => ['sandwich panel buildings', 'GI sheet prefab structures', 'prefab warehouse', 'steel prefab buildings'],
        'intro' => 'A prefabricated building is a steel-framed structure clad in sandwich panel or single-skin aluminium/GI sheet, engineered off-site and erected fast on location. We design, supply and export prefabricated buildings for warehouses, workshops and office blocks across the UAE, GCC and African construction markets.',
        'sections' => [
            [
                'heading' => 'Structural System & Cladding Options',
                'body' => "Our prefabricated buildings use a hot-rolled or cold-formed steel portal frame designed to the project's span, wind and roof-load requirements, clad with either insulated sandwich panels (PU or PIR core, typically 40–100 mm) or single-skin aluminium/GI profiled sheets over a lighter secondary structure. Sandwich panel construction gives better thermal performance and is specified for offices, labour accommodation and cold-adjacent buildings, while single-skin GI cladding suits warehouses, workshops and open-sided industrial sheds where cost per square metre is the priority. Roof and wall systems are matched with compatible flashings, gutters and ventilation louvres, and structures can be specified with mezzanine floors, roller shutter openings and crane-gantry provision where the end use requires it.",
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Prefabricated buildings are the default choice wherever an industrial or commercial client needs large covered floor area on a fixed programme. Steel plants and mills use them for stores, workshops and ancillary buildings around a main production line. Food processing and packaging operators specify insulated sandwich-panel structures for production halls that need a cleanable, thermally stable envelope. Logistics and distribution operators use single-skin GI-clad warehouses for cost-efficient covered storage, and oil & gas contractors specify the same system for laydown-yard workshops and equipment stores. Construction contractors also use prefabricated buildings as their own site facilities during the main build.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Structural steel and cladding are fabricated and packed for containerised or break-bulk export from our India and UAE supply base, with erection drawings and a bolted-connection design intended for local site labour to assemble without specialist plant. We quote against your architectural or structural drawing (or can develop one from a brief) and provide a bill of materials broken down by shipment, which is particularly relevant on multi-country African projects where partial shipments and phased site mobilisation are common. Site supervision support can be arranged for first-time erection teams.',
            ],
        ],
        'applications' => ['Industrial warehouses & workshops', 'Steel plant ancillary buildings', 'Food & beverage production halls', 'Logistics & distribution centres', 'Site offices & stores', 'Labour accommodation blocks'],
        'related_products' => ['container-houses', 'mezzanine-cage-ladders', 'sandwich-single-skin-sheets', 'building-materials', 'electrical-enclosures', 'light-poles'],
        'related_industries' => ['steel-plants', 'construction', 'food-processing'],
        'faqs' => [
            ['q' => 'Which is better: container house or prefabricated building?', 'a' => 'A container house suits smaller, quickly relocated units like offices, clinics and classrooms because it ships as one complete module. A prefabricated building suits larger, permanent or semi-permanent structures such as warehouses and production halls, where the floor area needed exceeds what a single container module can offer.'],
            ['q' => 'What is the difference between sandwich panel and single-skin cladding?', 'a' => 'Sandwich panels have an insulating PU or PIR core between two metal skins, giving thermal and acoustic performance suited to occupied or climate-sensitive buildings. Single-skin aluminium/GI sheet is a single profiled metal layer with no insulation core, offering a lower-cost envelope for warehouses and sheds where thermal control is not critical.'],
            ['q' => 'Can prefabricated buildings be designed for high wind or seismic zones?', 'a' => 'Yes. The portal frame and connection design are engineered to the specific wind speed, snow/seismic and occupancy loading of the destination site, so structures supplied to coastal UAE locations or higher-wind African regions are designed to the relevant local loading, not a single generic specification.'],
            ['q' => 'What is the typical lead time for a prefabricated warehouse?', 'a' => 'Lead time depends on structure size, cladding specification and order backlog at the time of order; we confirm a fabrication and shipping schedule once drawings are approved, and can phase shipments for large or multi-building projects.'],
            ['q' => 'Do you provide erection support on site?', 'a' => 'Structures are supplied with erection drawings for a bolted assembly that local site labour can complete, and we can arrange supervisory support for teams erecting our structures for the first time, particularly on larger multi-bay buildings.'],
        ],
    ],

    'electrical-enclosures' => [
        'name' => 'SMC/GRP Weatherproof Electrical Enclosures',
        'short_name' => 'Electrical Enclosures',
        'meta_title' => 'SMC/GRP Weatherproof Electrical Enclosure Supplier UAE',
        'meta_description' => 'IP65-rated SMC/GRP electrical enclosures, feeder pillars and junction boxes for outdoor and corrosive environments — supplied across the UAE, GCC and Africa.',
        'primary_keyword' => 'SMC GRP electrical enclosure supplier',
        'keywords' => ['weatherproof electrical enclosure', 'GRP feeder pillar', 'fiberglass junction box', 'IP65 enclosure UAE'],
        'intro' => 'An SMC/GRP electrical enclosure is a moulded fiberglass housing that protects switchgear, meters and control equipment from moisture, UV and corrosive atmospheres. We supply weatherproof enclosures, feeder pillars and junction boxes rated up to IP65 for outdoor and industrial sites across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Material, Ratings & Construction',
                'body' => 'Enclosures are moulded from Sheet Moulding Compound (SMC) or hand-laid GRP, materials chosen because they are naturally non-conductive, corrosion-proof and stable across the wide temperature range seen on Gulf and African outdoor installations. Standard construction achieves IP65 protection against dust and water jets, with gasketed lids, UV-stabilised resin to prevent surface chalking, and moulded-in mounting points for busbars, DIN rail and cable glands. Enclosures are supplied as flat-wall junction boxes, deeper equipment cabinets, and free-standing feeder pillars for street-level electrical distribution, in sizes from small instrumentation boxes to multi-compartment switchgear housings. Because the material itself does not rust, enclosures hold their rating over years of coastal or high-humidity exposure without the recurring repainting a mild-steel enclosure needs.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Weatherproof enclosures are specified wherever electrical or instrumentation equipment sits outdoors or in a corrosive process area. Oil & gas and petrochemical plants use SMC/GRP enclosures for junction boxes and local control panels in areas exposed to salt air, hydrocarbons or wash-down. Power and energy utilities specify GRP feeder pillars for street and substation-level distribution because they do not need cathodic protection or repainting cycles. Water treatment plants, food processing sites and marine/shipyard facilities all favour fiberglass enclosures over painted steel for the same corrosion-resistance reason, and airports use them for runway and apron-edge lighting control cabinets.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Enclosures are supplied to IP rating and dimensional drawing, with custom cut-outs, gland plates and internal panel-building available before shipment. We export in palletised or crated form to protect gaskets and hinges in transit, and can supply enclosures pre-fitted with customer-specified busbars, breakers or metering as a panel-build service. Bulk orders for utility or telecom rollouts across multiple African countries are quoted with a phased delivery schedule matched to site readiness.',
            ],
        ],
        'applications' => ['Outdoor switchgear & feeder pillars', 'Instrumentation junction boxes', 'Substation control cabinets', 'Street & apron lighting control', 'Marine & offshore electrical housings', 'Water treatment plant control panels'],
        'related_products' => ['grp-water-tanks', 'motors-pumps-valves', 'light-poles', 'flanges-fittings'],
        'related_industries' => ['power-energy', 'oil-and-gas', 'shipyards-marine'],
        'faqs' => [
            ['q' => 'What does IP65 rating mean for an electrical enclosure?', 'a' => 'IP65 means the enclosure is fully dust-tight and protected against low-pressure water jets from any direction. It is the standard rating specified for outdoor electrical and instrumentation housings across Gulf and African sites exposed to dust storms, rain and wash-down cleaning.'],
            ['q' => 'Why choose GRP/SMC over a painted steel enclosure?', 'a' => 'GRP and SMC enclosures do not rust and are unaffected by salt air, humidity or most industrial chemicals, so they hold their protective rating for the life of the installation without the repainting or cathodic protection a steel enclosure requires in the same environment.'],
            ['q' => 'Can enclosures be customised with specific cut-outs and busbars?', 'a' => 'Yes. We supply enclosures moulded or drilled to a customer dimensional drawing, and can fit gland plates, busbars, DIN rail and breakers before shipment as a panel-build service, so the enclosure arrives ready for final termination on site.'],
            ['q' => 'What sizes of GRP enclosure are available?', 'a' => 'Sizes range from small single-instrument junction boxes to large multi-compartment, free-standing feeder pillars for street-level electrical distribution; enclosures are quoted against the equipment schedule and space envelope you provide.'],
            ['q' => 'Do GRP enclosures need UV stabilisation for outdoor use?', 'a' => 'Yes, and ours are supplied with UV-stabilised resin as standard, which prevents the surface chalking and gradual embrittlement that untreated fiberglass can suffer under sustained direct sun exposure typical of Gulf and African climates.'],
        ],
    ],

    'grp-water-tanks' => [
        'name' => 'SMC/GRP Panel Type Water Tanks',
        'short_name' => 'GRP Panel Water Tanks',
        'meta_title' => 'SMC/GRP Panel Water Tank Supplier in UAE & Africa | 4S Tech',
        'meta_description' => 'Externally stiffened SMC/GRP panel water tanks — sectional, hot-pressed and modular — supplied for drinking water, fire and process storage across the GCC and Africa.',
        'primary_keyword' => 'SMC GRP panel water tank supplier UAE',
        'keywords' => ['GRP water tank Dubai', 'fiberglass water tank supplier', 'FRP panel tank', 'sectional water tank', 'hot pressed GRP panels', 'externally stiffened panel tank'],
        'intro' => 'An SMC/GRP panel water tank is a sectional storage tank built from hot-pressed, externally stiffened fiberglass panels bolted together on site. We supply panel tanks for drinking water, fire reserve and process storage to construction, food and oil & gas projects across the UAE, GCC and 40+ African countries.',
        'sections' => [
            [
                'heading' => 'Panel Specification & Materials',
                'body' => 'Each panel is hot-press moulded from Sheet Moulding Compound (SMC), a glass-fibre-reinforced polyester that is dense, non-porous and resistant to algae growth and chemical attack, unlike hand-laid GRP which relies on a resin-rich surface coat for the same protection. Panels are externally stiffened with moulded-in ribs, which lets the tank carry hydrostatic load without an internal steel frame — a genuine advantage for potable water storage because there is no steel to corrode inside the tank. Standard panel sizes bolt together with EPDM gasket seals to build tanks from a few cubic metres up to several thousand, in single or multi-compartment configurations, and can be finished food-grade for drinking water or fire-rated for hydrant reserve duty. Roof, ladder, manhole, level gauge and overflow fittings are supplied as part of the standard package.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Panel tanks are the standard storage solution wherever a site needs large-volume water storage without pouring an in-situ concrete or steel tank. Construction projects use them for site drinking water and fire-fighting reserve from an early mobilisation stage. Food processing plants specify food-grade panel tanks for wash-water and process storage because the smooth panel interior resists bacterial growth. Oil & gas and petrochemical sites use panel tanks for fire-water reserve and utility water, and hotels, hospitals, airports and residential developments across the GCC and Africa use them as rooftop or ground-level domestic water storage. Agricultural and irrigation projects also specify panel tanks for bulk water buffering.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Panels are flat-packed for efficient container loading, which keeps freight cost per cubic metre of finished storage low compared with shipping a pre-built steel tank. We quote against required capacity, available footprint and water duty (potable, fire or process) and supply an assembly drawing and fitting schedule so local site labour can erect the tank without specialist plant. This flat-pack format is a particular advantage for African markets where large finished tanks are impractical to import, and we can phase panel shipments to match multi-tank rollout programmes.',
            ],
        ],
        'applications' => ['Potable & drinking water storage', 'Fire-fighting reserve tanks', 'Process & utility water storage', 'Rooftop residential/hotel tanks', 'Irrigation water buffering', 'Construction site water supply'],
        'related_products' => ['electrical-enclosures', 'silos-tanks', 'motors-pumps-valves'],
        'related_industries' => ['construction', 'food-processing', 'oil-and-gas'],
        'faqs' => [
            ['q' => 'What is the difference between GRP and FRP water tanks?', 'a' => 'GRP (glass-reinforced plastic) and FRP (fibre-reinforced plastic) refer to the same underlying composite material — glass fibre set in a resin matrix. In practice "GRP tank" usually describes a hot-pressed panel tank built from dense SMC panels, while "FRP tank" is sometimes used for hand-laid, single-piece moulded tanks; the specification and quality depend on the manufacturing process, not the name.'],
            ['q' => 'What is an SMC panel water tank?', 'a' => 'An SMC panel water tank is built from Sheet Moulding Compound panels — a glass-fibre-reinforced polyester that is hot-press moulded to a dense, non-porous finish — bolted together with gasket seals to form a sectional tank in the capacity a site requires.'],
            ['q' => 'How long do GRP panel water tanks last?', 'a' => 'A correctly installed and maintained GRP panel tank typically gives 20–30 years of service life, since the panels do not corrode or degrade under water immersion; panel gaskets are the usual maintenance item and are designed to be individually replaceable.'],
            ['q' => 'What is a hot-pressed vs cold-pressed GRP panel?', 'a' => 'Hot-pressed panels are moulded under heat and pressure, producing a denser, more consistent panel with better long-term structural and hygienic performance. Cold-pressed panels cure without heat, generally at a lower cost but with more variability in thickness and surface quality — we supply hot-pressed panels as standard.'],
            ['q' => 'Can panel tanks be made food-grade for drinking water?', 'a' => 'Yes. Panels can be supplied with a food-grade internal gel coat suitable for potable water storage, and we can provide the relevant material compliance documentation for projects that require it.'],
            ['q' => 'What sizes of panel water tank can be supplied?', 'a' => 'Panel tanks are modular, so capacity is built up from standard panel sizes — from a few cubic metres for a villa or site cabin up to several thousand cubic metres for industrial or municipal storage, in single or multi-compartment layouts.'],
        ],
    ],

    'flanges-fittings' => [
        'name' => 'Flanges & Fittings',
        'short_name' => 'Flanges & Fittings',
        'meta_title' => 'Flanges & Fittings Supplier UAE | Oil & Gas Pipe Fittings',
        'meta_description' => 'ANSI, DIN and BS flanges, forged fittings and PVF supply for oil & gas, petrochemical and industrial piping projects across the UAE, GCC and Africa.',
        'primary_keyword' => 'flanges and fittings supplier UAE',
        'keywords' => ['pipe fittings supplier oil and gas', 'forged flanges', 'ANSI flanges Dubai', 'PVF supplier'],
        'intro' => 'Flanges and fittings connect and terminate pipework across oil & gas, petrochemical and industrial piping systems. We supply ANSI, DIN and BS forged flanges, elbows, tees and reducers — full PVF (pipes, valves, fittings) support — to construction and process projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Standards, Materials & Range',
                'body' => 'We supply flanges to ANSI B16.5, DIN and BS standards in weld-neck, slip-on, blind, socket-weld and threaded configurations, forged from carbon steel, stainless steel (304/316) and low-temperature/alloy grades as the process duty requires. The fittings range covers elbows, tees, reducers, caps and couplings in seamless and welded construction across the pressure classes commonly specified on oil & gas and industrial piping — 150# through 2500#. All material is sourced against mill test certificates, and batches can be supplied with third-party inspection (positive material identification, hydrostatic testing) where the project specification calls for it, which matters on oil & gas and petrochemical piping where traceability is a contractual requirement, not an option.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Flanges and fittings are a core commodity on every process and utility piping system we supply into. Oil & gas and petrochemical plants specify them for process, utility and fire-water piping under strict material-certification requirements. Steel plants and paper mills use them across cooling water, steam and process-fluid piping. Power and energy projects specify high-pressure fittings for boiler and turbine-adjacent piping, and water treatment and food processing plants use stainless fittings where hygiene or corrosion resistance is the deciding factor. Shipyards and marine fabricators draw on the same catalogue for onboard and dockside piping systems.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'We hold and source stock against project piping schedules and consolidate mixed flange, fitting and valve orders into a single shipment, which reduces freight overhead compared with sourcing each item separately. Orders are supplied with mill test certificates and, where required, third-party inspection reports, and we handle export documentation for shipments into GCC and African destination ports. For EPC contractors running multi-country African projects, we can phase deliveries against a piping material take-off and construction schedule.',
            ],
        ],
        'applications' => ['Process & utility piping', 'Fire-water piping systems', 'Steam & boiler piping', 'Cooling water systems', 'Marine & dockside piping', 'Water & wastewater piping'],
        'related_products' => ['motors-pumps-valves', 'silos-tanks', 'anchor-bolts', 'electrical-enclosures'],
        'related_industries' => ['oil-and-gas', 'chemical-plants', 'shipyards-marine'],
        'faqs' => [
            ['q' => 'What flange standards do you supply?', 'a' => 'We supply flanges to ANSI B16.5, DIN and BS standards across pressure classes from 150# to 2500#, in weld-neck, slip-on, blind, socket-weld and threaded types, machined from carbon steel, stainless steel and alloy material grades as specified.'],
            ['q' => 'Can flanges and fittings be supplied with mill test certificates?', 'a' => 'Yes. Material is sourced against mill test certificates as standard, and we can arrange third-party inspection, positive material identification and hydrostatic testing where the project specification or client procurement standard requires independent verification.'],
            ['q' => 'Do you supply matching valves with flanges and fittings?', 'a' => 'Yes — flanges, fittings and valves are typically quoted together against a single piping material take-off, so a project receives a consolidated PVF package rather than sourcing each item from a different supplier.'],
            ['q' => 'What is the lead time for flanges and fittings to GCC or Africa?', 'a' => 'Lead time depends on size, pressure class and material grade; common stock sizes ship faster than large-diameter or exotic-alloy items, and we confirm a firm schedule once the full piping material list is reviewed.'],
            ['q' => 'Can you supply flanges in stainless steel for food or water applications?', 'a' => 'Yes, 304 and 316 stainless steel flanges and fittings are available for food processing, water treatment and other hygienic or corrosion-sensitive applications where carbon steel is not suitable.'],
        ],
    ],

    'motors-pumps-valves' => [
        'name' => 'Motors, Pumps & Valves',
        'short_name' => 'Motors, Pumps & Valves',
        'meta_title' => 'Industrial Pumps, Valves & Motors Supplier UAE',
        'meta_description' => 'Centrifugal pumps, gate/ball/globe valves and industrial electric motors for oil & gas, water and process industries — supplied across the UAE, GCC and Africa.',
        'primary_keyword' => 'industrial pumps and valves supplier UAE',
        'keywords' => ['electric motor supplier', 'centrifugal pump supplier', 'gate valve supplier oil and gas'],
        'intro' => 'Motors, pumps and valves move and control fluid and mechanical power across industrial process systems. We supply centrifugal and positive-displacement pumps, gate, ball, globe and check valves, and industrial electric motors to oil & gas, water and manufacturing projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Range & Technical Specification',
                'body' => 'Our pump range covers centrifugal, submersible and positive-displacement types across flow and head duties from small utility transfer to process-scale duty, in cast iron, stainless steel and duplex construction depending on the fluid handled. Valves are supplied in gate, globe, ball, butterfly and check configurations, in manual, gear-operated and actuated versions, sized and pressure-rated to match the flange and piping specification of the project. Electric motors are supplied across standard IE efficiency classes, in TEFC and explosion-proof (Ex-rated) enclosures for hazardous-area duty on oil & gas and petrochemical sites, sized to the driven load and site voltage/frequency. All items are selected against duty point (flow, head, pressure, torque) rather than sold as a generic catalogue match, so equipment is right-sized for the application.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'This is one of the widest-application categories we supply. Oil & gas and petrochemical plants specify Ex-rated motors, actuated valves and process pumps for hazardous-area duty. Water treatment plants and municipal utilities use centrifugal and submersible pumps for transfer and distribution duty, paired with gate and check valves for isolation and non-return protection. Food processing plants specify stainless pumps and hygienic valves for process-fluid handling. Steel plants and paper mills use heavy-duty motors and pumps across cooling and process water circuits, and agricultural/irrigation projects rely on the same pump range for bulk water movement.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'We quote motors, pumps and valves against the duty schedule (flow/head/pressure/power, hazardous-area classification if applicable) and consolidate multi-item orders into a single shipment with the accompanying technical datasheets and test certificates. Where a project needs Ex-certification valid for the destination country, we source equipment carrying the relevant certification before shipment rather than after, which avoids delays at customs or commissioning stage on GCC and African oil & gas projects.',
            ],
        ],
        'applications' => ['Process fluid transfer', 'Hazardous-area (Ex-rated) motor duty', 'Water & wastewater pumping', 'Irrigation & agricultural pumping', 'Isolation & control valving', 'Cooling & utility water circuits'],
        'related_products' => ['flanges-fittings', 'electrical-enclosures', 'grp-water-tanks', 'silos-tanks'],
        'related_industries' => ['oil-and-gas', 'agriculture', 'power-energy'],
        'faqs' => [
            ['q' => 'What types of pumps do you supply?', 'a' => 'We supply centrifugal, submersible and positive-displacement pumps across cast iron, stainless steel and duplex construction, sized to the specific flow and head duty of the application rather than sold as a fixed catalogue range.'],
            ['q' => 'Do you supply Ex-rated (explosion-proof) motors for oil & gas sites?', 'a' => 'Yes, TEFC and Ex-rated motors are available for hazardous-area duty on oil & gas and petrochemical sites, supplied with the certification relevant to the destination country and the specific hazardous-area zone classification.'],
            ['q' => 'What valve types are available?', 'a' => 'Gate, globe, ball, butterfly and check valves are supplied in manual, gear-operated and actuated versions, sized and pressure-rated to match the project piping specification and flange standard.'],
            ['q' => 'Can motors, pumps and valves be supplied with test certificates?', 'a' => 'Yes, equipment is supplied with manufacturer technical datasheets and test certification, and third-party witnessed testing can be arranged where the project specification requires independent verification before shipment.'],
            ['q' => 'How are pumps and motors sized for a project?', 'a' => 'Equipment is selected against the actual duty point — flow rate, head or pressure, driven load and site power supply — provided in your enquiry, so the pump or motor supplied matches the real operating condition rather than a generic nameplate rating.'],
        ],
    ],

    'chequered-plates' => [
        'name' => 'SMC Chequered Plates',
        'short_name' => 'SMC Chequered Plates',
        'meta_title' => 'SMC Chequered Plate Supplier UAE | Custom Sizes',
        'meta_description' => 'Anti-slip SMC chequered plates in customised sizes for walkways, platforms and flooring — supplied to industrial and construction projects across the GCC and Africa.',
        'primary_keyword' => 'SMC chequered plate supplier',
        'keywords' => ['perforated sheet supplier UAE', 'custom size perforated metal sheet'],
        'intro' => 'An SMC chequered plate is a moulded fiberglass panel with a raised anti-slip surface pattern, used for walkways, platforms and flooring in wet or corrosive industrial areas. We supply SMC chequered plates in customised sizes to construction and industrial projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Material & Custom Sizing',
                'body' => 'Chequered plates are compression-moulded from Sheet Moulding Compound, giving a panel that is corrosion-proof, non-conductive and provides consistent slip resistance even when wet — properties a steel chequered plate cannot match without ongoing maintenance. Because the plates are moulded rather than pressed from stock steel sheet, thickness, panel dimensions and load rating can be specified to the actual walkway or platform span rather than limited to standard steel sheet sizes, and panels can be supplied with matching edge trims and fixing brackets for a bolted, gasketed installation. This makes SMC chequered plate a practical retrofit for existing steel platforms being upgraded for corrosion resistance, as well as new-build gratings and flooring.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Chequered plate flooring is specified wherever personnel need safe footing on a wet, oily or chemically exposed walkway. Oil & gas and petrochemical plants use it for platform and stairway flooring in process areas exposed to hydrocarbons and wash-down. Food processing plants specify it for wet-area walkways where hygiene and corrosion resistance both matter. Water treatment plants, marine/shipyard facilities and paper mills use SMC chequered plate for the same reason — a flooring surface that stays slip-resistant without repainting or replacement on a corrosion-driven maintenance cycle.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Plates are manufactured to the panel size, thickness and load rating specified in your enquiry and packed flat for efficient container loading. We supply matched quantities for full platform or walkway retrofits, with fixing hardware included, and can phase delivery for multi-area plant upgrade projects across GCC and African industrial sites.',
            ],
        ],
        'applications' => ['Platform & walkway flooring', 'Stairway treads', 'Process-area anti-slip surfaces', 'Marine deck & dockside flooring', 'Wet-area industrial flooring'],
        'related_products' => ['perforated-sheets', 'electrical-enclosures', 'anchor-bolts', 'building-materials'],
        'related_industries' => ['oil-and-gas', 'shipyards-marine', 'food-processing'],
        'faqs' => [
            ['q' => 'What is SMC chequered plate used for?', 'a' => 'SMC chequered plate is used as anti-slip flooring for walkways, platforms and stairways in industrial areas exposed to moisture, oil or chemicals, where a corrosion-proof, non-conductive surface is preferred over painted steel.'],
            ['q' => 'Can chequered plates be made in custom sizes?', 'a' => 'Yes, panels are moulded or cut to the dimensions, thickness and load rating specified for your platform or walkway, rather than limited to standard steel sheet sizes.'],
            ['q' => 'Is SMC chequered plate slip-resistant when wet?', 'a' => 'Yes, the raised chequered pattern is moulded into the panel surface and retains its anti-slip texture in wet, oily or chemically exposed conditions without the surface wear a painted steel plate experiences over time.'],
            ['q' => 'What is the minimum order quantity for custom chequered plates?', 'a' => 'MOQ depends on panel size and thickness; smaller platform retrofits and larger multi-area plant orders are both accommodated, and we confirm minimum order quantity and lead time at the quotation stage against your specification.'],
        ],
    ],

    'perforated-sheets' => [
        'name' => 'Perforated Sheets',
        'short_name' => 'Perforated Sheets',
        'meta_title' => 'Perforated Sheet Supplier UAE | Custom Sizes & Hole Patterns',
        'meta_description' => 'Perforated metal sheets in customised sizes and hole patterns for filtration, ventilation and architectural applications — supplied across the UAE, GCC and Africa.',
        'primary_keyword' => 'perforated sheet supplier UAE',
        'keywords' => ['custom size perforated metal sheet', 'perforated sheet Dubai'],
        'intro' => 'A perforated sheet is a metal panel punched with a regular hole pattern, used for filtration, ventilation, screening and architectural cladding. We supply perforated sheets in customised sizes, materials and hole patterns to industrial and construction projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Materials, Patterns & Sizing',
                'body' => "Perforated sheets are supplied in mild steel, galvanised steel, stainless steel and aluminium, punched with round, square, slotted or decorative hole patterns at the open-area percentage the application requires — higher open area for ventilation and filtration duty, lower open area where structural strength or screening is the priority. Sheets are cut and punched to the project's dimensional and pattern drawing rather than restricted to a fixed stock range, which matters for architectural facade panels and custom equipment screens where hole pattern is part of the design intent as well as the function. Edge margins, mounting hole positions and finish (mill, galvanised or powder-coated) are specified against the end use.",
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Perforated sheet is used across a wide functional range. Industrial plants specify it for equipment guarding, ventilation louvres and filtration screens. Food and agricultural processing facilities use perforated stainless sheet for grading, drying and sieving equipment. Construction and architectural projects specify perforated aluminium or steel panels for facade cladding, sunscreens and balustrade infill. Steel plants and paper mills use heavier-gauge perforated sheet for machine guarding and walkway screening, and packaging industries use it for ventilated equipment enclosures.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Sheets are cut and punched to your drawing and packed flat for container shipping, with quantities matched to project take-off for facade or plant-wide screening orders. We supply to material and finish specification with the relevant test or compliance documentation where required, and can coordinate phased delivery for large architectural or industrial screening packages across GCC and African sites.',
            ],
        ],
        'applications' => ['Facade & architectural cladding', 'Equipment guarding & ventilation', 'Filtration & sieving screens', 'Balustrade & sunscreen infill', 'Machine guarding panels'],
        'related_products' => ['chequered-plates', 'building-materials', 'anchor-bolts', 'electrical-enclosures'],
        'related_industries' => ['construction', 'agriculture', 'steel-plants'],
        'faqs' => [
            ['q' => 'MOQ for SMC chequered plates and perforated sheets in custom sizes?', 'a' => 'Minimum order quantity depends on the specific size, gauge and hole pattern ordered; we confirm MOQ and lead time once your drawing or specification is reviewed, and both small retrofit orders and large project quantities are accommodated.'],
            ['q' => 'What hole patterns are available on perforated sheets?', 'a' => 'Round, square, slotted and decorative hole patterns are available at a range of open-area percentages, and sheets can be punched to a custom pattern drawing for architectural or specialist filtration applications.'],
            ['q' => 'Can perforated sheets be supplied in stainless steel?', 'a' => 'Yes, mild steel, galvanised steel, stainless steel and aluminium are all available, with stainless typically specified for food, hygienic or corrosion-exposed applications.'],
            ['q' => 'Can perforated sheets be finished with powder coating?', 'a' => 'Yes, sheets can be supplied mill-finish, galvanised or powder-coated to a specified colour, which is common for architectural facade and screening applications.'],
        ],
    ],

    'moulds' => [
        'name' => 'Compression & Injection Moulding Moulds',
        'short_name' => 'Moulds (Compression & Injection)',
        'meta_title' => 'Compression & Injection Moulding Mould Manufacturer',
        'meta_description' => 'Design and manufacture of compression and injection moulding moulds/dies for SMC, DMC and plastics industries — supplied from India and the UAE.',
        'primary_keyword' => 'compression moulding mould manufacturer',
        'keywords' => ['injection moulding mould design', 'SMC mould manufacturer India'],
        'intro' => 'A compression or injection mould is the tooling used to shape SMC, DMC or plastic raw material into a finished part under heat and pressure. We design and manufacture compression and injection moulds for the moulding industry, supplied from our India engineering base to clients across the GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Design & Manufacturing Process',
                'body' => "Mould design starts from the customer's part drawing or physical sample, from which we develop the tool design accounting for material shrinkage, parting line, venting and ejection system before cutting steel. Tools are machined from tool steel grades selected for the expected production volume and material (SMC/DMC compression tools see high clamping pressure and abrasive glass-fibre-filled material, so tool steel and hardening specification are chosen accordingly). We manufacture both compression moulds for SMC/DMC panel and component production and injection moulds for thermoplastic parts, with trial-shot sampling and dimensional inspection against the part drawing before the tool is released for production use.",
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Mould tooling underpins production for any client manufacturing SMC, DMC or plastic-moulded components — including our own SMC panel, enclosure and chequered-plate production. Electrical enclosure and water tank panel manufacturers need compression tooling for their panel geometry. Automotive and appliance component manufacturers need injection tooling for plastic parts. Packaging industries use injection moulds for container and closure production, and agricultural equipment manufacturers use moulded composite components produced from custom compression tooling.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Tools are designed and built at our India facility and shipped as finished, trial-sampled tooling ready for installation on the customer press. We work from a customer part drawing, sample part or 3D model, and can supply first-article sample parts alongside the tool for customer approval before the tool ships. This service supports clients across the GCC and Africa who are localising SMC or plastic component production rather than importing finished parts.',
            ],
        ],
        'applications' => ['SMC/DMC compression tooling', 'Plastic injection tooling', 'Component & panel tool design', 'First-article sampling', 'Tool refurbishment & modification'],
        'related_products' => ['grp-water-tanks', 'electrical-enclosures', 'chequered-plates'],
        'related_industries' => ['construction', 'packaging', 'electronics'],
        'faqs' => [
            ['q' => 'What is the difference between compression and injection moulding?', 'a' => 'Compression moulding presses a pre-measured charge of material (typically SMC or DMC) into a heated, closed mould under pressure — suited to glass-fibre-reinforced composite parts. Injection moulding forces molten thermoplastic into a closed mould cavity — suited to high-volume plastic component production. The two processes need differently designed tooling.'],
            ['q' => 'What information do you need to design a mould?', 'a' => 'A part drawing, 3D model or physical sample is the starting point; we then develop a tool design covering parting line, venting, ejection and shrinkage allowance before manufacturing begins, confirming the design with you before cutting steel.'],
            ['q' => 'Do you supply trial-sample parts before the tool ships?', 'a' => 'Yes, tools are trial-shot and sample parts are checked against the part drawing before the tool is released, and first-article samples can be sent for customer approval prior to shipment.'],
            ['q' => 'Can you refurbish or modify an existing mould?', 'a' => 'Yes, mould refurbishment, re-texturing and dimensional modification are available for existing tooling, which is often more cost-effective than a full new tool when the part geometry only needs minor revision.'],
        ],
    ],

    'building-materials' => [
        'name' => 'Building Materials',
        'short_name' => 'Building Materials',
        'meta_title' => 'Building Materials Supplier UAE | Bulk Construction Supply',
        'meta_description' => 'All kinds of building materials sourced and supplied in bulk for construction projects across the UAE, GCC and Africa — one-stop procurement from a single supplier.',
        'primary_keyword' => 'building materials supplier UAE',
        'keywords' => ['construction materials supplier Dubai', 'bulk building material export Africa', 'building materials supplier Nigeria Kenya Ghana'],
        'intro' => 'We source and supply all kinds of building materials — cement-based products, steel, roofing, insulation, finishing materials and general construction consumables — as a single, consolidated procurement line for contractors and developers across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Scope of Supply',
                'body' => 'Our building materials line covers the general construction bill of materials a project needs beyond its specialist steel or M&E packages: cement and cement products, structural and reinforcement steel, roofing sheets and accessories, insulation, blockwork and finishing materials, waterproofing systems, and general site consumables. Rather than a fixed catalogue, we source against a project\'s bill of quantities, consolidating multiple material categories from vetted manufacturers into a single procurement and shipping process. This one-stop approach is specifically useful for contractors working on remote African or GCC sites who would otherwise need to manage a separate supplier relationship, minimum order and shipping schedule for every material category.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Construction contractors use this service across the full range of build types — residential, commercial, industrial and infrastructure. Steel plants, food processing facilities and other industrial clients use it for ancillary building and civil works that sit alongside their main process installation. Government and NGO-funded projects across Africa use consolidated material procurement to simplify site logistics on projects where import routes and local material availability are constrained.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'We work from a bill of quantities or material schedule, source and consolidate the required materials, and manage export documentation and shipping to the destination port or site. Consolidated shipping across multiple material categories reduces per-shipment freight and customs handling overhead compared with sourcing each category separately, which is a meaningful saving on multi-container African project deliveries.',
            ],
        ],
        'applications' => ['Cement & concrete products', 'Structural & reinforcement steel', 'Roofing & waterproofing systems', 'Insulation & finishing materials', 'General site consumables'],
        'related_products' => ['prefabricated-buildings', 'container-houses', 'anchor-bolts', 'electrical-plumbing'],
        'related_industries' => ['construction', 'steel-plants', 'agriculture'],
        'faqs' => [
            ['q' => 'What is one-stop procurement in industrial supply?', 'a' => 'One-stop procurement means sourcing multiple material and equipment categories for a project through a single supplier who consolidates purchasing, quality checking, export documentation and shipping — rather than the client managing separate relationships, minimum orders and freight schedules with each individual manufacturer.'],
            ['q' => 'Can you supply against a full bill of quantities?', 'a' => 'Yes, we source and quote against a project bill of quantities or material schedule, consolidating multiple building material categories into a coordinated procurement and shipping plan.'],
            ['q' => 'How do you handle building material shipments to African countries?', 'a' => 'Materials are consolidated where possible into fewer, larger shipments to reduce freight and customs handling cost, with export documentation prepared for the destination country and delivery scheduled against the project\'s site mobilisation programme.'],
            ['q' => 'Do you supply building materials for industrial as well as residential projects?', 'a' => 'Yes, the service covers residential, commercial, industrial and infrastructure projects, including ancillary civil and building works for industrial clients such as steel plants and food processing facilities.'],
        ],
    ],

    'electrical-plumbing' => [
        'name' => 'Electrical & Plumbing Items',
        'short_name' => 'Electrical & Plumbing Items',
        'meta_title' => 'Electrical & Plumbing Items Supplier UAE',
        'meta_description' => 'Cables, switchgear, lighting, pipes and plumbing fittings supplied in bulk for construction and industrial projects across the UAE, GCC and Africa.',
        'primary_keyword' => 'electrical and plumbing items supplier UAE',
        'keywords' => ['electrical items supplier Dubai', 'plumbing fittings supplier UAE', 'MEP materials supplier Africa'],
        'intro' => 'Electrical and plumbing items are the cables, switchgear, lighting, pipework and fittings that make up a building\'s MEP installation. We supply electrical and plumbing materials in bulk to construction and industrial projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Scope of Supply',
                'body' => 'The electrical range covers cables and wiring accessories, distribution boards, switchgear, lighting fixtures and general low-voltage installation materials. The plumbing range covers pipes and fittings in PVC, CPVC, GI and PPR, valves, sanitary fixtures and general plumbing hardware. Both ranges are sourced against a project\'s MEP schedule and quality standard — voltage rating and cable standard for electrical items, pressure rating and material compatibility for plumbing items — rather than supplied as a generic hardware-store range, which matters when the specification is tied to a project\'s electrical or plumbing design.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Construction contractors use this line across residential, commercial and industrial MEP fit-out. Container house, prefabricated building and cold store projects we supply also draw on this range for their internal electrical and plumbing fit-out, giving clients the option to procure the structure and its services from one source. Food processing and industrial facilities use the plumbing range for process and utility water distribution, and the electrical range for general facility power and lighting outside the process-critical instrumentation covered by our enclosures line.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Items are sourced and consolidated against your MEP material schedule, with quantities and specifications confirmed before shipment to avoid mismatched voltage, standard or fitting-size issues on arrival. We support phased delivery aligned to a project\'s fit-out sequence — first-fix electrical and plumbing materials ahead of second-fix and finishing items — for both single-site and multi-country African project rollouts.',
            ],
        ],
        'applications' => ['Cables & low-voltage accessories', 'Distribution boards & switchgear', 'Lighting fixtures', 'Pipes & pipe fittings (PVC/CPVC/GI/PPR)', 'Sanitary fixtures & plumbing hardware'],
        'related_products' => ['electronics', 'computer-peripherals', 'container-houses', 'building-materials', 'anchor-bolts'],
        'related_industries' => ['construction', 'food-processing', 'power-energy'],
        'faqs' => [
            ['q' => 'Can electrical and plumbing items be supplied to match a project MEP schedule?', 'a' => 'Yes, we source items against the voltage rating, cable standard, pipe material and pressure rating specified in a project\'s MEP schedule, rather than supplying a generic hardware range, so materials arrive matched to the design.'],
            ['q' => 'Do you supply electrical fit-out for container houses and prefab buildings?', 'a' => 'Yes, clients ordering container houses, prefabricated buildings or cold store units from us can also source the internal electrical and plumbing fit-out materials from this range, consolidating structure and services procurement.'],
            ['q' => 'What plumbing pipe materials are available?', 'a' => 'PVC, CPVC, GI and PPR pipe and fittings are supplied, selected against the fluid, pressure and temperature duty of the application.'],
            ['q' => 'Can electrical and plumbing materials be phased for a multi-stage project?', 'a' => 'Yes, delivery can be phased to match a project\'s fit-out sequence, with first-fix materials scheduled ahead of second-fix and finishing items.'],
        ],
    ],

    'electronics' => [
        'name' => 'Electronics',
        'short_name' => 'Electronics',
        'meta_title' => 'Electronics Supplier UAE | Industrial Control Components',
        'meta_description' => 'Industrial electronics and control components sourced and supplied for industrial sites across the UAE, GCC and Africa.',
        'primary_keyword' => 'electronics supplier UAE',
        'keywords' => ['industrial electronics supplier Africa', 'control components supplier'],
        'intro' => 'We supply electronics and industrial control components, including instrumentation and control parts, for industrial and construction clients across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Scope of Supply',
                'body' => 'The range covers industrial electronic and control components — sensors, control relays, indicator instruments and general instrumentation parts — for process and utility systems.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Oil & gas, steel and process plants use industrial electronics and control components as part of instrumentation and control system upgrades or new installations. Airports and shipyards use these components across operational functions.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Items are sourced and quality-checked against your specification list, consolidated for shipment, and supplied with the relevant technical datasheets for industrial control components. We coordinate delivery to match control-room and project schedules across GCC and African locations.',
            ],
        ],
        'applications' => ['Industrial sensors & control relays', 'Indicator & instrumentation components'],
        'related_products' => ['electrical-plumbing', 'electrical-enclosures', 'container-houses', 'motors-pumps-valves'],
        'related_industries' => ['electronics', 'oil-and-gas', 'airports'],
        'faqs' => [
            ['q' => 'Can electronics be supplied with technical datasheets?', 'a' => 'Yes, industrial control and instrumentation components are supplied with the relevant manufacturer technical datasheets so engineering teams can verify compatibility before installation.'],
        ],
    ],

    'computer-peripherals' => [
        'name' => 'Computer Peripherals',
        'short_name' => 'Computer Peripherals',
        'meta_title' => 'Computer Peripherals Supplier UAE | Office IT Equipment',
        'meta_description' => 'Computer peripherals and office IT equipment sourced and supplied for offices and industrial sites across the UAE, GCC and Africa.',
        'primary_keyword' => 'computer peripherals supplier UAE',
        'keywords' => ['computer peripherals supplier Dubai', 'office IT equipment supplier'],
        'intro' => 'We supply general computer peripherals and office IT equipment for site offices, control rooms and administrative facilities across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Scope of Supply',
                'body' => 'The range covers general computer peripherals and office IT equipment for site offices, control rooms and administrative facilities.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Construction and project site offices use computer peripherals for site administration, while airports and shipyards use them across operational and administrative functions. This line pairs naturally with our container house and prefabricated building supply for clients fitting out a new site office or control room from scratch.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Items are sourced and quality-checked against your specification list, consolidated for shipment, and coordinated to match site-office or control-room fit-out schedules across GCC and African project locations.',
            ],
        ],
        'applications' => ['Site office & control room IT equipment', 'General computer peripherals'],
        'related_products' => ['electrical-plumbing', 'electrical-enclosures', 'container-houses', 'motors-pumps-valves'],
        'related_industries' => ['electronics', 'oil-and-gas', 'airports'],
        'faqs' => [
            ['q' => 'Do you supply office IT peripherals?', 'a' => 'Yes, general computer peripherals are supplied for site offices, control rooms and administrative facilities.'],
            ['q' => 'Can this be combined with a container house or site office order?', 'a' => 'Yes, this range is commonly ordered alongside container houses or prefabricated buildings for clients fitting out a new site office or control room, so structure, electrical fit-out and IT equipment can be coordinated as one project.'],
        ],
    ],

    'anchor-bolts' => [
        'name' => 'Anchor & Connection Bolts',
        'short_name' => 'Anchor & Connection Bolts',
        'meta_title' => 'Anchor Bolt Supplier UAE | Foundation & Connection Bolts',
        'meta_description' => 'Anchor bolts, foundation bolts and structural connection fasteners supplied for steel and industrial construction projects across the UAE, GCC and Africa.',
        'primary_keyword' => 'anchor bolt supplier UAE',
        'keywords' => ['connection bolts', 'foundation bolts', 'fasteners supplier'],
        'intro' => 'Anchor and connection bolts fix structural steel, machinery and equipment to concrete foundations and connect structural members to each other. We supply foundation bolts and general structural fasteners for steel and industrial construction projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Range & Material Grades',
                'body' => 'The range covers cast-in foundation (L-type and J-type) anchor bolts for structural steel base plates and machinery foundations, post-installed mechanical and chemical anchors for retrofit fixing, and general structural connection bolts (high-strength friction grip and standard grades) for steelwork assembly. Bolts are supplied in the material grade and finish — galvanised, black or stainless — the application and environment require, sized and threaded to match the base plate or connection drawing. Foundation bolt sets are supplied with matching nuts, washers and, where specified, templates for accurate placement before concrete pour.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Anchor bolts are a foundational item — literally — on every steel-framed structure we supply into. Prefabricated buildings, container houses, light poles and silo/tank installations all need foundation bolts matched to the base plate design. Steel plants and industrial facilities use post-installed anchors for machinery and equipment fixing during upgrades or new installation. Construction contractors specify general connection bolts across structural steelwork on every project type we serve.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Bolts are supplied against the structural drawing or base plate schedule, matched in grade and size to the connection design, and consolidated with other structural steel items where a project is sourcing its full steelwork package from us. We supply foundation bolt sets ahead of a project\'s concrete pour schedule so placement templates and bolts are on site in time, which matters on fast-tracked GCC and African construction programmes.',
            ],
        ],
        'applications' => ['Structural steel foundation bolts', 'Machinery & equipment anchoring', 'Post-installed retrofit anchors', 'Light pole & tank foundation bolts', 'General structural connection fasteners'],
        'related_products' => ['prefabricated-buildings', 'light-poles', 'silos-tanks', 'building-materials'],
        'related_industries' => ['construction', 'steel-plants', 'power-energy'],
        'faqs' => [
            ['q' => 'What is the difference between anchor bolts and connection bolts?', 'a' => 'Anchor (foundation) bolts fix a structure or machinery base plate into a concrete foundation, typically cast in before or grouted after pour. Connection bolts join structural steel members to each other above foundation level. Both are structural fasteners but serve different points in the connection chain.'],
            ['q' => 'Can foundation bolts be supplied with placement templates?', 'a' => 'Yes, foundation bolt sets can be supplied with placement templates to ensure accurate bolt positioning before concrete pour, which reduces the risk of misaligned base plates on site.'],
            ['q' => 'What material grades are available for anchor bolts?', 'a' => 'Standard and high-strength structural grades are available in galvanised, black or stainless finish, selected against the load, environment and corrosion exposure of the installation.'],
            ['q' => 'Can anchor bolts be supplied as part of a full steel structure order?', 'a' => 'Yes, foundation and connection bolts are commonly consolidated with structural steel, prefabricated building or light pole orders so the full connection package arrives matched and on the same delivery schedule.'],
        ],
    ],

    'silos-tanks' => [
        'name' => 'Silos & Tanks',
        'short_name' => 'Silos & Tanks',
        'meta_title' => 'Industrial Silos & Storage Tanks Supplier UAE',
        'meta_description' => 'Steel silos and storage tanks for bulk solids, fuel and process liquids — designed and supplied for industrial and agricultural projects across the GCC and Africa.',
        'primary_keyword' => 'industrial silos and storage tanks supplier',
        'keywords' => ['steel silo supplier', 'storage tank supplier UAE'],
        'intro' => 'Silos and storage tanks provide bulk storage for solids, fuel and process liquids in agricultural, industrial and oil & gas facilities. We design and supply steel silos and storage tanks to projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Design & Construction',
                'body' => 'Silos are designed for the specific bulk material stored — grain, cement, feed or industrial powders — with hopper angle, discharge system and structural loading calculated for that material\'s flow characteristics and bulk density. Storage tanks are supplied for fuel, water and process liquids in vertical or horizontal configurations, welded steel or bolted-panel construction depending on capacity and site erection constraints, with internal or external coating specified for the stored fluid\'s corrosivity. Both product lines are supplied with the ancillary fittings — ladders, platforms, level instrumentation, vents and discharge/fill connections — needed for a complete, commissionable installation, not just the empty vessel.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Agricultural operations use silos for grain and feed storage across farming and processing facilities. Cement and building material producers use silos for bulk powder storage. Oil & gas and fuel distribution operators specify fuel storage tanks to relevant safety and containment standards. Food processing plants use tanks for bulk liquid ingredient storage, and steel plants and paper mills use process liquid tanks across their utility and process systems.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Larger silos and tanks are supplied in bolted-panel or sectional form to allow container shipping and site erection without heavy lifting plant, while smaller units can be shop-fabricated and shipped complete. We quote against stored material/fluid, required capacity and site constraints, and supply erection drawings and ancillary fittings as part of the package for both single-unit and multi-tank agricultural or industrial projects across Africa and the GCC.',
            ],
        ],
        'applications' => ['Grain & feed storage silos', 'Cement & bulk powder silos', 'Fuel storage tanks', 'Process liquid storage tanks', 'Water storage tanks'],
        'related_products' => ['grp-water-tanks', 'flanges-fittings', 'motors-pumps-valves', 'anchor-bolts'],
        'related_industries' => ['agriculture', 'oil-and-gas', 'food-processing'],
        'faqs' => [
            ['q' => 'What is the difference between a silo and a storage tank?', 'a' => 'A silo stores dry bulk solids (grain, cement, feed) and is designed around the material\'s flow and discharge characteristics. A storage tank stores liquids or fuel and is designed around fluid pressure, containment and corrosion resistance. Both are bulk storage vessels but engineered for different stored materials.'],
            ['q' => 'Can silos and tanks be supplied for erection without heavy lifting equipment?', 'a' => 'Yes, larger units can be supplied in bolted-panel or sectional form for container shipping and site assembly with standard site equipment, while smaller units are shop-fabricated and shipped complete.'],
            ['q' => 'What capacity range of silos and tanks can be supplied?', 'a' => 'Capacity is engineered to project requirement, from smaller farm or site-level units up to large industrial or municipal-scale silos and tanks; we quote against the stored material, required capacity and site footprint.'],
            ['q' => 'Are silos and tanks supplied with instrumentation and fittings?', 'a' => 'Yes, ladders, platforms, level instrumentation, vents and discharge/fill connections are included as part of a complete, commissionable installation package rather than supplied as an empty vessel only.'],
        ],
    ],

    'packing-items' => [
        'name' => 'Packing Items',
        'short_name' => 'Packing Items',
        'meta_title' => 'Industrial Packing Items Supplier UAE',
        'meta_description' => 'Industrial packing, packaging and export-crating materials supplied in bulk for manufacturing, food and export projects across the UAE, GCC and Africa.',
        'primary_keyword' => 'industrial packing items supplier UAE',
        'keywords' => ['packaging materials supplier Dubai', 'export crating materials Africa'],
        'intro' => 'Packing items cover the packaging, crating and export-protection materials industrial and manufacturing operations need for their own products and shipments. We supply industrial packing materials in bulk to manufacturing, food and export-oriented clients across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Scope of Supply',
                'body' => 'The range covers export crating and palletising materials, strapping and wrapping consumables, protective packaging (foam, corrugated, void-fill) and general industrial packaging supplies used by manufacturing and processing operations to prepare their own goods for storage or export shipment. Materials are sourced to the durability and protection level a client\'s product and shipping route require — heavier export crating for overseas sea-freight shipments, lighter packaging for regional distribution — and supplied in bulk to match ongoing production or shipping volumes rather than one-off orders.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Manufacturing and processing operations across steel, food and packaging industries use this range to package their own finished goods for domestic distribution or export. Export-oriented manufacturers across the GCC and Africa use export-grade crating and strapping for sea-freight shipments where product protection during transit is critical. Food processing plants use food-safe packaging consumables for finished product packing lines.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'We supply packing materials on a scheduled basis matched to a client\'s production or shipping volume, sourcing to the specification (material, strength, food-safety grade) their operation requires. This line is often ordered alongside our other product categories by clients who both receive shipments from us and export their own finished goods, giving a single supplier relationship across inbound and outbound packaging needs.',
            ],
        ],
        'applications' => ['Export crating & palletising', 'Strapping & wrapping consumables', 'Protective packaging (foam/corrugated)', 'Food-safe packaging materials'],
        'related_products' => ['building-materials', 'chequered-plates', 'electrical-plumbing', 'perforated-sheets'],
        'related_industries' => ['packaging', 'food-processing', 'steel-plants'],
        'faqs' => [
            ['q' => 'What packing materials do you supply?', 'a' => 'We supply export crating and palletising materials, strapping and wrapping consumables, protective packaging such as foam and corrugated void-fill, and general industrial packaging supplies, sourced to the protection level a client\'s product and shipping route require.'],
            ['q' => 'Can packing materials be supplied on a recurring schedule?', 'a' => 'Yes, packing materials are commonly supplied on a scheduled basis matched to a client\'s ongoing production or shipping volume rather than as one-off orders.'],
            ['q' => 'Do you supply food-safe packaging materials?', 'a' => 'Yes, food-safe packaging consumables are available for food processing clients packing finished products for distribution or export.'],
        ],
    ],

    'light-poles' => [
        'name' => 'Light Poles',
        'short_name' => 'Light Poles',
        'meta_title' => 'Street Light Pole Supplier UAE | Galvanized & Decorative Poles',
        'meta_description' => 'Galvanized steel and decorative light poles for street, area and site lighting — supplied and exported to construction and infrastructure projects across the GCC and Africa.',
        'primary_keyword' => 'street light pole supplier UAE',
        'keywords' => ['galvanized light pole', 'decorative light poles'],
        'intro' => 'A light pole is a galvanized steel or decorative column supporting street, area or facility lighting fixtures. We supply light poles for road, site and public-realm lighting projects across the UAE, GCC and Africa, including solar-ready poles for off-grid installations.',
        'sections' => [
            [
                'heading' => 'Range & Construction',
                'body' => "Poles are supplied in hot-dip galvanized steel as standard, in heights and base-plate designs matched to the fixture load and wind-loading requirement of the site, with octagonal, conical or decorative shaft profiles available for street lighting, area/car-park lighting and architectural public-realm applications. Poles are supplied with matching base plates, foundation bolt sets, access doors and internal cabling ducting, and can be finished powder-coated where a decorative or corporate colour specification applies. Solar-ready poles with mounting brackets for photovoltaic panels and battery compartments are available for off-grid rural road and site lighting projects, a relevant option across African markets with limited grid reach.",
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Infrastructure and municipal projects specify galvanized light poles for street and road lighting. Ports, airports and industrial sites use heavier-duty poles for high-mast area lighting. Construction developments and commercial projects specify decorative poles for car parks and public realm. Off-grid and rural electrification projects across Africa specify solar-ready poles where grid connection is not available or not cost-effective for the lighting load required.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Poles are supplied against a lighting design (pole height, fixture load, wind zone) and shipped with matching foundation bolt sets, sized for efficient container loading given their length. We coordinate quantities and phased delivery for large street-lighting rollout projects, which is common on municipal and rural electrification programmes across multiple African countries.',
            ],
        ],
        'applications' => ['Street & road lighting', 'Car park & area lighting', 'High-mast port & airport lighting', 'Solar off-grid rural lighting', 'Decorative public-realm lighting'],
        'related_products' => ['anchor-bolts', 'electrical-enclosures', 'electrical-plumbing'],
        'related_industries' => ['construction', 'power-energy', 'airports'],
        'faqs' => [
            ['q' => 'What finish do light poles come in?', 'a' => 'Poles are hot-dip galvanized as standard for corrosion protection, and can be additionally powder-coated to a specified decorative or corporate colour for public-realm and commercial applications.'],
            ['q' => 'Are solar-powered light poles available?', 'a' => 'Yes, solar-ready poles with photovoltaic mounting brackets and battery compartments are available for off-grid street and rural lighting, relevant for African projects without reliable grid access at the installation site.'],
            ['q' => 'What heights of light pole can be supplied?', 'a' => 'Pole height is specified against the lighting design and fixture load, ranging from standard street-lighting heights to high-mast poles for port, airport and large area lighting.'],
            ['q' => 'Are foundation bolts included with light pole orders?', 'a' => 'Yes, matching base plates and foundation bolt sets are supplied with pole orders so the foundation and pole installation are engineered as one connected system.'],
        ],
    ],

    'granites-natural-stones' => [
        'name' => 'Granites & Natural Stones',
        'short_name' => 'Granites & Natural Stones',
        'meta_title' => 'Granite & Natural Stone Supplier UAE | Slabs & Tiles',
        'meta_description' => 'Granite, marble and natural stone slabs and tiles in a range of finishes and colours, supplied for flooring, cladding and countertops across the UAE, GCC and Africa.',
        'primary_keyword' => 'granite and natural stone supplier UAE',
        'keywords' => ['natural stone supplier Dubai', 'granite slab supplier', 'marble supplier UAE'],
        'intro' => 'Granites and natural stones are quarried slabs and tiles used for flooring, wall cladding, countertops and architectural finishing. We supply granite, marble and other natural stone in a range of colours, patterns and finishes to construction and interior fit-out projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Range & Finishes',
                'body' => 'Our natural stone range covers granite, marble and other quarried stone in polished, honed and flamed finishes, supplied as slabs for countertops and feature cladding or as cut-to-size tiles for flooring and wall applications. Colour and veining vary by quarry source, and we supply against a sample or specification so a project receives consistent material across its full order rather than mismatched batches. Edge profiling, cut-to-size and thickness are specified to the project\'s architectural drawing.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Natural stone is specified across residential, commercial and hospitality construction for flooring, staircases, wall cladding and kitchen or reception countertops. Developers and contractors use it for lobby and facade feature finishes, and it is a common finishing material on villa, hotel and retail fit-out projects across the UAE, GCC and Africa.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Slabs and tiles are packed in crates for safe transit and supplied against a project\'s area take-off and finish specification, with sample approval available before full order confirmation. We coordinate consolidated shipment for multi-area finishing packages alongside other building material orders.',
            ],
        ],
        'applications' => ['Flooring & staircases', 'Wall & facade cladding', 'Countertops & reception desks', 'Villa & hospitality interiors'],
        'related_products' => ['athangudi-tiles', 'paver-blocks', 'building-materials'],
        'related_industries' => ['construction'],
        'faqs' => [
            ['q' => 'What natural stone finishes are available?', 'a' => 'Polished, honed and flamed finishes are available across our granite and marble range, selected against the intended flooring, cladding or countertop application.'],
            ['q' => 'Can granite and marble be supplied cut-to-size?', 'a' => 'Yes, slabs and tiles are cut, edge-profiled and finished to the dimensions in your architectural drawing rather than supplied only in standard slab sizes.'],
            ['q' => 'Can I get a sample before ordering in bulk?', 'a' => 'Yes, sample approval is available before a full order is confirmed, so colour and finish are agreed ahead of the main shipment.'],
        ],
    ],

    'athangudi-tiles' => [
        'name' => 'Athangudi Traditional Tiles',
        'short_name' => 'Athangudi Traditional Tiles',
        'meta_title' => 'Athangudi Traditional Tile Supplier | Handmade Cement Tiles',
        'meta_description' => 'Handmade Athangudi traditional cement tiles in a range of patterns and colours, supplied for flooring and heritage-style interiors across the UAE, GCC and Africa.',
        'primary_keyword' => 'Athangudi tiles supplier',
        'keywords' => ['Athangudi cement tiles', 'handmade traditional tiles India'],
        'intro' => 'Athangudi tiles are handmade cement tiles, traditionally produced in Tamil Nadu, India, known for their bold patterns and glass-finish surface. We supply Athangudi traditional tiles in a range of colours and patterns for flooring and heritage-style interior projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Craft & Material',
                'body' => 'Each tile is hand-poured using a glass-plate moulding technique that gives the surface its characteristic sheen, with pigment and cement layered into a metal pattern frame before curing — a manufacturing process that produces natural, tile-to-tile colour variation rather than a uniform printed pattern. Tiles are supplied in a range of geometric and floral patterns and colourways sourced from our India production base.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Athangudi tiles are specified for flooring in heritage-style homes, boutique hospitality projects and feature areas within larger residential or commercial developments where a traditional, handcrafted look is part of the design intent.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Tiles are packed and supplied against the area and pattern quantities in your order, with production coordinated from our India base and export handled for delivery into the UAE, GCC and African markets.',
            ],
        ],
        'applications' => ['Heritage-style flooring', 'Boutique hospitality interiors', 'Feature area flooring'],
        'related_products' => ['granites-natural-stones', 'paver-blocks', 'building-materials'],
        'related_industries' => ['construction'],
        'faqs' => [
            ['q' => 'What are Athangudi tiles made from?', 'a' => 'Athangudi tiles are handmade cement tiles produced using a glass-plate moulding technique that layers pigment and cement in a pattern frame before curing, giving each tile a characteristic glass-finish sheen.'],
            ['q' => 'Can Athangudi tiles be supplied in custom patterns?', 'a' => 'Tiles are supplied from our existing range of traditional geometric and floral patterns and colourways produced at our India base; we confirm available patterns and lead time at enquiry stage.'],
        ],
    ],

    'paver-blocks' => [
        'name' => 'Paver Blocks',
        'short_name' => 'Paver Blocks',
        'meta_title' => 'Paver Block Supplier UAE | Interlocking Concrete Pavers',
        'meta_description' => 'Interlocking concrete paver blocks in a range of shapes and colours, supplied for driveways, walkways and landscaping projects across the UAE, GCC and Africa.',
        'primary_keyword' => 'paver block supplier UAE',
        'keywords' => ['interlocking pavers Dubai', 'concrete paver blocks supplier'],
        'intro' => 'Paver blocks are interlocking concrete units used to pave driveways, walkways, car parks and landscaped areas. We supply paver blocks in a range of shapes, thicknesses and colours to construction and landscaping projects across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Range & Specification',
                'body' => 'Paver blocks are supplied in interlocking, rectangular and hexagonal profiles, in standard and coloured concrete finishes, with thickness specified against the expected traffic load — lighter units for pedestrian walkways and landscaping, thicker high-strength units for vehicle driveways and car parks. Matching kerbs, edge restraints and hollow/solid concrete blocks are available alongside the main paver range.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Paver blocks are used across construction and landscaping projects for driveways, walkways, car parks, plazas and external hardscaping on residential, commercial and infrastructure developments across the UAE, GCC and Africa.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Blocks are supplied in bulk against your area take-off, shape and colour specification, and can be consolidated with other building material orders for a single project shipment and delivery schedule.',
            ],
        ],
        'applications' => ['Driveways & car parks', 'Walkways & plazas', 'Landscaping & hardscaping', 'Kerbs & edge restraints'],
        'related_products' => ['granites-natural-stones', 'building-materials', 'chequered-plates'],
        'related_industries' => ['construction'],
        'faqs' => [
            ['q' => 'What paver block shapes are available?', 'a' => 'Interlocking, rectangular and hexagonal profiles are available, along with matching kerbs and edge restraints, supplied in standard or coloured concrete finish.'],
            ['q' => 'What thickness of paver block is used for driveways vs walkways?', 'a' => 'Thicker, higher-strength units are specified for vehicle driveways and car parks, while lighter units are sufficient for pedestrian walkways and landscaping; we confirm the correct thickness against your expected traffic load.'],
        ],
    ],

    'hdpe-vibrating-screen-plates' => [
        'name' => 'HDPE Vibrating Screen Plates',
        'short_name' => 'HDPE Vibrating Screen Plates',
        'meta_title' => 'HDPE Vibrating Screen Plate Supplier | Customized Size',
        'meta_description' => 'HDPE vibrating screen plates in customized sizes for grading and screening equipment, supplied to paper mills, agricultural and processing plants across the GCC and Africa.',
        'primary_keyword' => 'HDPE vibrating screen plate supplier',
        'keywords' => ['vibrating screen plate custom size', 'HDPE screen deck supplier'],
        'intro' => 'An HDPE vibrating screen plate is a moulded polyethylene deck panel used on vibrating screen equipment to grade and separate bulk material by size. We supply HDPE vibrating screen plates in customized sizes to paper mills, agricultural and processing plants across the GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Material & Custom Sizing',
                'body' => 'Screen plates are moulded from high-density polyethylene, a material chosen for its abrasion resistance, low noise operation and resistance to corrosion compared with metal screen decks, which matters on continuously running vibrating screen equipment. Aperture size, panel dimensions and mounting profile are manufactured to match the specific screen deck and separation requirement of your equipment rather than supplied as a fixed stock size.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Vibrating screen plates are used on process and grading screens across paper mills, agricultural grain and feed processing, and general bulk material handling plants where material needs to be separated or graded by particle size as part of the production process.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Plates are manufactured to the aperture pattern, panel size and mounting specification of your existing screen deck, and supplied as matched sets for full deck replacement or as individual replacement panels for ongoing maintenance.',
            ],
        ],
        'applications' => ['Vibrating screen deck replacement', 'Grain & feed grading screens', 'Paper mill process screening', 'Bulk material separation'],
        'related_products' => ['perforated-sheets', 'chequered-plates', 'silos-tanks'],
        'related_industries' => ['paper-mills', 'agriculture', 'steel-plants'],
        'faqs' => [
            ['q' => 'Why use HDPE instead of a metal screen plate?', 'a' => 'HDPE screen plates resist abrasion and corrosion and run quieter than metal decks, giving longer service life on continuously running vibrating screen equipment without the rust-driven replacement cycle a steel screen deck needs.'],
            ['q' => 'Can screen plates be made to match my existing screen deck?', 'a' => 'Yes, plates are manufactured to the aperture pattern, panel size and mounting profile of your existing equipment so replacement panels fit without modification.'],
        ],
    ],

    'paper-core-end-plugs' => [
        'name' => 'Paper Core End Plug',
        'short_name' => 'Paper Core End Plug',
        'meta_title' => 'Paper Core End Plug Supplier | Roll Core Protection',
        'meta_description' => 'Paper core end plugs supplied for roll handling to paper mills and packaging industries across the GCC and Africa.',
        'primary_keyword' => 'paper core end plug supplier',
        'keywords' => ['paper core end plug', 'roll core protection'],
        'intro' => 'A paper core end plug is a moulded plastic cap fitted into the ends of paper and film roll cores to protect the core and support safe handling and stacking. We supply paper core end plugs to paper mills and packaging industries across the GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Range & Specification',
                'body' => 'End plugs are supplied in the core diameter and profile required for your roll product — paper, film or laminate cores — moulded from durable plastic to withstand repeated handling, stacking and transit loads.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Paper mills and converters use end plugs on finished paper and film roll production for safe stacking, transit protection and core reinforcement. Packaging industries producing wound roll products use the same core-protection components for their own finished goods.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'End plugs are supplied in bulk quantities matched to your production volume and core specification, sourced from our India supply base and consolidated with other packaging or paper mill material orders where relevant.',
            ],
        ],
        'applications' => ['Paper & film roll core protection', 'Stacking & transit protection'],
        'related_products' => ['hdpe-vibrating-screen-plates', 'packing-items', 'perforated-sheets'],
        'related_industries' => ['paper-mills', 'packaging'],
        'faqs' => [
            ['q' => 'What sizes of paper core end plug are available?', 'a' => 'End plugs are supplied to the core diameter and profile of your roll product, whether paper, film or laminate cores; we confirm sizing against your specification at enquiry stage.'],
        ],
    ],

    'spares' => [
        'name' => 'Spares',
        'short_name' => 'Spares',
        'meta_title' => 'Paper Mill Spares Supplier | Industrial Replacement Parts',
        'meta_description' => 'General paper mill spares supplied for process equipment and maintenance requirements across the GCC and Africa.',
        'primary_keyword' => 'paper mill spares supplier',
        'keywords' => ['paper mill maintenance spares', 'paper machinery spares'],
        'intro' => 'We supply general spares to paper mills and packaging industries across the GCC and Africa, sourced against equipment specifications for ongoing maintenance and replacement requirements.',
        'sections' => [
            [
                'heading' => 'Range & Specification',
                'body' => 'The range includes paper mill equipment spares such as rolls, guides, screen plates, impellers, bearing housings, doctor blades, pulleys, dryer components, conveyors, vacuum equipment and related replacement parts.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Paper mills and packaging facilities use these spares for ongoing process-equipment maintenance and replacement requirements.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Spares are sourced against your equipment specification and consolidated with other paper mill or packaging material orders where relevant.',
            ],
        ],
        'applications' => ['Paper mill process equipment', 'Maintenance replacement parts', 'Conveyor & roll-handling equipment'],
        'related_products' => ['hdpe-vibrating-screen-plates', 'packing-items', 'perforated-sheets'],
        'related_industries' => ['paper-mills', 'packaging'],
        'faqs' => [
            ['q' => 'Can spares be sourced against an equipment specification?', 'a' => 'Yes, general paper mill spares are sourced against your equipment specification for ongoing maintenance and replacement needs.'],
        ],
    ],

    'mezzanine-cage-ladders' => [
        'name' => 'Mezzanine Floors with Handrails & Cage Ladders',
        'short_name' => 'Mezzanine & Cage Ladders',
        'meta_title' => 'Mezzanine Floor & Cage Ladder Supplier UAE',
        'meta_description' => 'Mezzanine floors with handrails and fixed cage, dock and access ladders — supplied and installed for warehouses and industrial facilities across the UAE, GCC and Africa.',
        'primary_keyword' => 'mezzanine floor supplier UAE',
        'keywords' => ['cage ladder supplier', 'mezzanine floor with handrails', 'industrial access ladder UAE'],
        'intro' => 'A mezzanine floor is a raised steel platform that adds usable working or storage area within an existing building height, fitted with handrails and stairs for safe access. We supply mezzanine floors, handrail systems, and fixed cage, dock and access ladders to warehouses and industrial facilities across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Structural System & Access',
                'body' => 'Mezzanine platforms are built on a bolted steel frame sized to the intended floor loading — light storage, pallet racking or personnel access — with a flooring deck, perimeter handrails and a stair or ladder access point engineered as part of the same structural package. Handrail systems are supplied to standard safety heights with mid-rail and toe-board options, and stairs are fitted with non-slip treads matching the platform\'s duty rating. Alongside mezzanine structures, we supply fixed vertical access and cage ladders — cage-guarded ladders for roof and tank access, dock ladders, and walk-through ladders — engineered to relevant fall-protection standards for permanent industrial access points.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Mezzanine floors are specified wherever a warehouse or production facility needs additional floor area without extending the building footprint — storage mezzanines above racking, office or break-room mezzanines within a warehouse shell, and production mezzanines for lighter secondary processes. Cage and access ladders are supplied alongside storage tanks, silos, roof access points and elevated platforms across steel plants, food processing facilities and general industrial sites wherever permanent, code-compliant vertical access is required.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Mezzanine structures and ladder systems are supplied against your building layout and loading requirement, packed for container shipping and supplied with erection drawings for on-site assembly by local labour. We coordinate mezzanine and ladder orders alongside our prefabricated building and container house supply for clients fitting out a new facility in a single delivery programme.',
            ],
        ],
        'applications' => ['Warehouse storage mezzanines', 'Office/break-room mezzanine floors', 'Roof & tank cage ladder access', 'Dock and walk-through ladders', 'Elevated platform access'],
        'related_products' => ['prefabricated-buildings', 'container-houses', 'sandwich-single-skin-sheets', 'anchor-bolts'],
        'related_industries' => ['construction', 'steel-plants'],
        'faqs' => [
            ['q' => 'What is a cage ladder used for?', 'a' => 'A cage ladder is a fixed vertical ladder enclosed in a protective steel cage or hoop guard, used for permanent access to roofs, tanks, silos and elevated platforms where fall protection is required for the climber.'],
            ['q' => 'Can mezzanine floors be designed for racking or heavy storage loads?', 'a' => 'Yes, the platform frame and decking are sized to the specific floor loading you specify, from light document storage to pallet racking or equipment loads.'],
            ['q' => 'Are handrails included with mezzanine floor orders?', 'a' => 'Yes, perimeter handrail systems to standard safety heights are supplied as part of the mezzanine package, along with stair or ladder access matched to the platform.'],
        ],
    ],

    'sandwich-single-skin-sheets' => [
        'name' => 'Sandwich & Single-Skin Aluminum/GI Sheets',
        'short_name' => 'Sandwich & Single-Skin Sheets',
        'meta_title' => 'Sandwich Panel & Single-Skin GI Sheet Supplier UAE',
        'meta_description' => 'PU and rock wool sandwich panels and single-skin aluminium/GI roofing and wall sheets — supplied for industrial buildings across the UAE, GCC and Africa.',
        'primary_keyword' => 'sandwich panel sheet supplier UAE',
        'keywords' => ['PU sandwich panel', 'rock wool sandwich panel', 'single skin GI sheet', 'aluminium roofing sheet UAE'],
        'intro' => 'Sandwich and single-skin sheets are the roofing and wall cladding profiles used across prefabricated and industrial buildings. We supply PU and rock wool insulated sandwich panels and single-skin aluminium/GI profiled sheets in a range of colours across the UAE, GCC and Africa.',
        'sections' => [
            [
                'heading' => 'Panel Types & Construction',
                'body' => 'Sandwich panels are supplied with a PU (polyurethane) or rock wool insulating core between two profiled metal skins — PU panels for standard thermal insulation, rock wool panels where fire-rated insulation is specified. Single-skin aluminium/GI sheets are a single profiled metal layer without an insulation core, supplied in a range of colours and rib profiles for roofing and wall cladding where cost per square metre rather than thermal performance is the priority. Both are supplied cut to length with matching flashings, gutters and fixing accessories.',
            ],
            [
                'heading' => 'Applications Across Industries',
                'body' => 'Sandwich panels are specified for insulated roofing and wall cladding on warehouses, cold-adjacent buildings, labour accommodation and office structures where thermal performance matters. Single-skin GI sheets are the standard choice for open industrial sheds, workshop roofing and general warehouse cladding where the building does not need to be thermally controlled. Both product lines are supplied as the cladding package for our prefabricated buildings and container house structures.',
            ],
            [
                'heading' => 'Export & Supply Capability to GCC & Africa',
                'body' => 'Sheets and panels are cut to your roof/wall layout and packed for container shipping, supplied with a fixing and flashing schedule for on-site installation. We coordinate sandwich panel and single-skin sheet orders alongside our prefabricated building and structural steel supply so a project receives a matched structure-and-cladding package in one delivery programme.',
            ],
        ],
        'applications' => ['Insulated roofing & wall cladding', 'Cold-adjacent building envelopes', 'Warehouse & workshop roofing', 'Labour accommodation cladding'],
        'related_products' => ['prefabricated-buildings', 'container-houses', 'mezzanine-cage-ladders', 'building-materials'],
        'related_industries' => ['construction', 'steel-plants'],
        'faqs' => [
            ['q' => 'What is the difference between PU and rock wool sandwich panels?', 'a' => 'PU (polyurethane) core panels give strong general-purpose thermal insulation, while rock wool core panels are specified where fire-rated insulation performance is required by the project specification, at a higher cost than PU.'],
            ['q' => 'When should single-skin sheet be used instead of a sandwich panel?', 'a' => 'Single-skin aluminium/GI sheet suits open sheds, workshops and warehouses where thermal control is not required, offering a lower-cost envelope than an insulated sandwich panel.'],
            ['q' => 'What colours are available for roofing sheets?', 'a' => 'Sandwich panels and single-skin sheets are both supplied in a range of standard colour finishes; we confirm the available colour range and any custom colour options at quotation stage.'],
        ],
    ],
];
