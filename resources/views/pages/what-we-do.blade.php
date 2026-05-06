@extends('layouts.website')

@section('title', 'What We Do | Effective Media')

@section('content')
    @php
        $streetLightBenefits = $profileContent['street_light_box']['benefits'] ?? [];
        $streetLightProcess = $profileContent['street_light_box']['process'] ?? [];
        $streetLightExplanation = $profileContent['street_light_box']['explanation'] ?? 'Street Light Box Advertising keeps your brand visible across daily commuter routes with high-frequency, location-driven exposure.';

        $serviceDetails = $profileContent['service_details'] ?? [];
        $serviceData = [
            [
                'name' => 'Street Light Advertising',
                'slug' => 'street-light-advertising',
                'headline' => 'Own Daily Commuter Attention',
                'description' => $serviceDetails['Street Light Advertising']['description'] ?? 'Dominant corridor-level media infrastructure built for repetitive visibility, day and night.',
                'example' => 'FMCG commuter dominance campaign across Nakuru and Nairobi corridors.',
                'industries' => 'FMCG, Financial Services, Telecom, Education',
                'impact' => 'High frequency, city-wide recall, route ownership',
                'image' => !empty($serviceDetails['Street Light Advertising']['image']) ? asset('profile-gallery/' . $serviceDetails['Street Light Advertising']['image']) : 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'name' => 'Billboards',
                'slug' => 'billboards',
                'headline' => 'Massive Roadside Dominance',
                'description' => $serviceDetails['Billboards']['description'] ?? 'Large format placements engineered for high-speed road visibility and landmark-level impact.',
                'example' => 'Retail launch near highway interchanges with 24/7 prime frontage.',
                'industries' => 'Real Estate, Retail, Automotive',
                'impact' => 'Instant scale, landmark branding, broad awareness',
                'image' => !empty($serviceDetails['Billboards']['image']) ? asset('profile-gallery/' . $serviceDetails['Billboards']['image']) : 'https://images.unsplash.com/photo-1494522358652-f30e61a60313?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'name' => 'Pavement Ads',
                'slug' => 'pavement-ads',
                'headline' => 'Close-Range Urban Impressions',
                'description' => $serviceDetails['Pavement Ads']['description'] ?? 'Ground-level media that captures attention in dense pedestrian and mixed traffic zones.',
                'example' => 'Weekend retail footfall push around CBD shopping belts.',
                'industries' => 'Retail, Hospitality, Events',
                'impact' => 'Street-level engagement, tactical bursts, local targeting',
                'image' => !empty($serviceDetails['Pavement Ads']['image']) ? asset('profile-gallery/' . $serviceDetails['Pavement Ads']['image']) : 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'name' => 'Office Branding',
                'slug' => 'office-branding',
                'headline' => 'Transform Physical Workspaces',
                'description' => $serviceDetails['Office Branding']['description'] ?? 'Interior and exterior branding systems that elevate customer confidence and workplace identity.',
                'example' => 'Corporate branch refresh program with wayfinding and branded touchpoints.',
                'industries' => 'Banking, Healthcare, Education',
                'impact' => 'Professional image, trust uplift, consistent brand environment',
                'image' => !empty($serviceDetails['Office Branding']['image']) ? asset('profile-gallery/' . $serviceDetails['Office Branding']['image']) : 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'name' => 'Activations & Roadshows',
                'slug' => 'activations-roadshows',
                'headline' => 'Brand Movement That People Remember',
                'description' => $serviceDetails['Activations & Roadshows']['description'] ?? 'On-ground campaign execution that combines visibility, interaction, and conversion momentum.',
                'example' => 'County-by-county product sampling with coordinated route support media.',
                'industries' => 'Beverages, Consumer Goods, Fintech',
                'impact' => 'Live engagement, immediate responses, demand acceleration',
                'image' => !empty($serviceDetails['Activations & Roadshows']['image']) ? asset('profile-gallery/' . $serviceDetails['Activations & Roadshows']['image']) : 'https://images.unsplash.com/photo-1472653431158-6364773b2a56?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'name' => 'Roll-up Banners',
                'slug' => 'roll-up-banners',
                'headline' => 'Portable Campaign Precision',
                'description' => $serviceDetails['Roll-up Banners']['description'] ?? 'Quick-deploy assets for events, launches, and retail points that need clear messaging fast.',
                'example' => 'Trade fair support units with consistent message visibility across booths.',
                'industries' => 'SMEs, Conferences, NGOs',
                'impact' => 'Fast deployment, low-cost support media, campaign consistency',
                'image' => !empty($serviceDetails['Roll-up Banners']['image']) ? asset('profile-gallery/' . $serviceDetails['Roll-up Banners']['image']) : 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=1600&q=80',
            ],
        ];

        $deploymentCounties = [
            ['name' => 'Nakuru', 'poles' => '210+', 'traffic' => '620K daily', 'focus' => 'Street Lights + Billboards'],
            ['name' => 'Nairobi', 'poles' => '145+', 'traffic' => '1.2M daily', 'focus' => 'Street Lights + Activations'],
            ['name' => 'Kiambu', 'poles' => '72+', 'traffic' => '360K daily', 'focus' => 'Street Lights + Pavement'],
            ['name' => 'Uasin Gishu', 'poles' => '68+', 'traffic' => '240K daily', 'focus' => 'Billboards + Roadshows'],
            ['name' => 'Kisumu', 'poles' => '56+', 'traffic' => '210K daily', 'focus' => 'Street Lights + Office Branding'],
            ['name' => 'Narok', 'poles' => '43+', 'traffic' => '170K daily', 'focus' => 'Road Corridors + Activations'],
        ];

        $campaignExamples = [
            ['client' => 'QSR Brand', 'location' => 'Nakuru CBD', 'format' => 'Street Light Ads', 'units' => '30 poles', 'duration' => '3 months', 'exposure' => 'Approx. 1.6M impressions'],
            ['client' => 'Fintech Launch', 'location' => 'Nairobi - Thika Road', 'format' => 'Street Light + Billboard Mix', 'units' => '48 units', 'duration' => '8 weeks', 'exposure' => 'Approx. 2.3M impressions'],
            ['client' => 'Education Intake Drive', 'location' => 'Eldoret Urban Belt', 'format' => 'Pavement + Street Light', 'units' => '26 units', 'duration' => '6 weeks', 'exposure' => 'Approx. 740K impressions'],
        ];
    @endphp

    <section class="relative min-h-[88vh] overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1519501025264-65ba15a82390?auto=format&fit=crop&w=2200&q=80');"></div>
        <div class="absolute inset-0 bg-[linear-gradient(118deg,rgba(10,10,10,0.86),rgba(92,21,20,0.78),rgba(10,10,10,0.72))]"></div>
        <div class="em-container relative flex min-h-[88vh] items-center py-20 lg:py-28">
            <div class="max-w-3xl space-y-7 text-white">
                <p class="inline-flex rounded-full border border-white/35 px-4 py-1 text-[11px] font-semibold uppercase tracking-[0.25em] text-[#f7d5c0]">Outdoor Media Infrastructure</p>
                <h1 class="text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">Visibility Built Into Everyday Movement</h1>
                <p class="max-w-2xl text-base leading-8 text-[#f3e2d9] sm:text-lg">We do not just place ads. We engineer repeated brand exposure across highways, CBD corridors, and urban traffic streams where attention compounds daily.</p>
                <div class="flex flex-wrap gap-3">
                    <a href="#coverage" class="inline-flex rounded-md bg-white px-5 py-3 text-sm font-bold text-[#5c1514]">Explore Coverage</a>
                    <a href="{{ route('smart-campaign-planner') }}" class="inline-flex rounded-md border border-white/50 px-5 py-3 text-sm font-bold text-white">Plan Campaign</a>
                    <a href="{{ route('quote') }}" class="inline-flex rounded-md bg-[#8b1e1a] px-5 py-3 text-sm font-bold text-white" data-track-event="quote_started">Request Quotation</a>
                </div>
            </div>
        </div>
    </section>

    <section id="street-light-box" class="bg-[#0f0f10] py-16 text-white lg:py-24">
        <div class="em-container grid items-center gap-10 lg:grid-cols-[1.4fr_1fr]">
            <div class="space-y-4">
                <p class="text-xs font-semibold uppercase tracking-[0.23em] text-[#f3b392]">Signature Service</p>
                <h2 class="text-3xl font-black leading-tight sm:text-4xl lg:text-5xl">Street Light Box Advertising Dominates Commuter Memory</h2>
                <p class="text-sm leading-7 text-[#d7d7d7] sm:text-base">{{ $streetLightExplanation }}</p>
                <div class="grid gap-4 pt-3 sm:grid-cols-3">
                    <div>
                        <p class="text-3xl font-black text-[#f7c1a2]">730+</p>
                        <p class="text-xs uppercase tracking-[0.14em] text-[#c8c8c8]">Installed Poles</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-[#f7c1a2]">12-16h</p>
                        <p class="text-xs uppercase tracking-[0.14em] text-[#c8c8c8]">Average Daily Visibility</p>
                    </div>
                    <div>
                        <p class="text-3xl font-black text-[#f7c1a2]">7+</p>
                        <p class="text-xs uppercase tracking-[0.14em] text-[#c8c8c8]">Counties Covered</p>
                    </div>
                </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl border border-white/10 bg-white/5 p-4">
                <img src="https://images.unsplash.com/photo-1470225620780-dba8ba36b745?auto=format&fit=crop&w=1600&q=80" alt="Night street light outdoor advertising infrastructure" class="h-[320px] w-full rounded-xl object-cover">
                <div class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                    <div>
                        <p class="font-semibold text-[#f6b695]">Why It Works</p>
                        <p class="text-[#d7d7d7]">Repetitive route exposure creates stronger brand recall than one-time impressions.</p>
                    </div>
                    <div>
                        <p class="font-semibold text-[#f6b695]">Best For</p>
                        <p class="text-[#d7d7d7]">FMCG launches, financial awareness, telecom promotions, event traffic capture.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="billboards" class="bg-[#f4ece4] py-16 lg:py-24">
        <div class="em-container grid gap-10 lg:grid-cols-[240px_1fr]">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Interactive Service Explorer</p>
                <h2 class="mt-3 text-3xl font-black text-[#381c1b]">Media Types Built Around Campaign Goals</h2>
                <p class="mt-3 text-sm leading-7 text-[#5b4440]">Choose a service to see campaign fit, impact profile, and use-case context.</p>
                <div class="mt-6 grid gap-2" data-service-tabs>
                    @foreach ($serviceData as $index => $service)
                        <button type="button" class="service-tab rounded-md border border-[#d7b9a5] px-4 py-2.5 text-left text-sm font-semibold text-[#5c1514] transition hover:bg-[#f3ddd0] {{ $index === 0 ? 'is-active bg-[#5c1514] text-white border-[#5c1514]' : '' }}" data-service-index="{{ $index }}">
                            {{ $service['name'] }}
                        </button>
                    @endforeach
                </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl border border-[#d8bba5] bg-white shadow-[0_20px_60px_rgba(58,22,20,0.08)]">
                <div id="pavement-ads" class="absolute -top-24"></div>
                <div id="office-branding" class="absolute -top-20"></div>
                <div id="rollup-banners" class="absolute -top-16"></div>
                <div id="activations" class="absolute -top-12"></div>
                <div id="roadshows" class="absolute -top-8"></div>
                <div class="grid lg:grid-cols-2">
                    <img src="{{ $serviceData[0]['image'] }}" alt="{{ $serviceData[0]['name'] }} campaign visual" class="h-72 w-full object-cover lg:h-full" data-service-image>
                    <div class="p-6 lg:p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#8b1e1a]" data-service-name>{{ $serviceData[0]['name'] }}</p>
                        <h3 class="mt-2 text-2xl font-black text-[#2c1716]" data-service-headline>{{ $serviceData[0]['headline'] }}</h3>
                        <p class="mt-4 text-sm leading-7 text-[#554341]" data-service-description>{{ $serviceData[0]['description'] }}</p>
                        <div class="mt-5 space-y-3 text-sm">
                            <p><span class="font-semibold text-[#5c1514]">Campaign Example:</span> <span data-service-example>{{ $serviceData[0]['example'] }}</span></p>
                            <p><span class="font-semibold text-[#5c1514]">Ideal Industries:</span> <span data-service-industries>{{ $serviceData[0]['industries'] }}</span></p>
                            <p><span class="font-semibold text-[#5c1514]">Outcome Profile:</span> <span data-service-impact>{{ $serviceData[0]['impact'] }}</span></p>
                        </div>
                        <div class="mt-6 flex flex-wrap gap-3">
                            <a href="{{ route('quote') }}" class="inline-flex rounded-md bg-[#8b1e1a] px-4 py-2.5 text-xs font-bold text-white">Request Pricing</a>
                            <a href="{{ route('smart-campaign-planner') }}" class="inline-flex rounded-md border border-[#8b1e1a]/40 px-4 py-2.5 text-xs font-bold text-[#5c1514]">Get Recommendation</a>
                            <a href="{{ route('services.show', ['serviceSlug' => $serviceData[0]['slug']]) }}" class="inline-flex rounded-md border border-[#8b1e1a]/40 px-4 py-2.5 text-xs font-bold text-[#5c1514]" data-service-page-link>View Service Page</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-16 lg:py-24">
        <div class="em-container">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Campaign Outcomes</p>
                <h2 class="mt-3 text-3xl font-black text-[#2f1a19] sm:text-4xl">From Site Booking to Measurable Visibility</h2>
                <p class="mt-3 text-sm leading-7 text-[#5c4540]">Every media plan maps to audience movement, corridor intensity, and campaign intent. These are typical deployment structures.</p>
            </div>
            <div class="mt-8 grid gap-6 lg:grid-cols-3">
                @foreach ($campaignExamples as $example)
                    <article class="reveal-up border-t-4 border-[#8b1e1a] bg-[#faf4ef] p-5 shadow-[0_18px_40px_rgba(92,21,20,0.08)] transition hover:-translate-y-1">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8b1e1a]">{{ $example['client'] }}</p>
                        <p class="mt-1 text-lg font-black text-[#2b1716]">{{ $example['location'] }}</p>
                        <div class="mt-4 space-y-2 text-sm text-[#4f3e3b]">
                            <p><span class="font-semibold text-[#5c1514]">Format:</span> {{ $example['format'] }}</p>
                            <p><span class="font-semibold text-[#5c1514]">Units:</span> {{ $example['units'] }}</p>
                            <p><span class="font-semibold text-[#5c1514]">Duration:</span> {{ $example['duration'] }}</p>
                            <p><span class="font-semibold text-[#5c1514]">Estimated Exposure:</span> {{ $example['exposure'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section id="coverage" class="bg-[#101012] py-16 text-white lg:py-24">
        <div class="em-container grid gap-8 lg:grid-cols-[1fr_1.2fr]">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#f0b596]">Geographic Deployment</p>
                <h2 class="mt-3 text-3xl font-black">Where We Operate and What Works There</h2>
                <p class="mt-3 text-sm leading-7 text-[#d8d8d8]">Select a county to preview placement density, estimated traffic flow, and recommended media mix.</p>
                <div class="mt-6 flex flex-wrap gap-2" data-county-tabs>
                    @foreach ($deploymentCounties as $index => $county)
                        <button type="button" class="county-tab rounded-full border border-white/25 px-4 py-2 text-xs font-semibold transition hover:bg-white/10 {{ $index === 0 ? 'is-active bg-white text-[#4a1b1a]' : 'text-white' }}" data-county-index="{{ $index }}">
                            {{ $county['name'] }}
                        </button>
                    @endforeach
                </div>
                <div class="mt-6 rounded-xl border border-white/15 bg-white/5 p-4">
                    <p class="text-xs uppercase tracking-[0.14em] text-[#f2bf9f]" data-county-name>{{ $deploymentCounties[0]['name'] }}</p>
                    <div class="mt-3 grid gap-2 text-sm text-[#e8e8e8]">
                        <p><span class="font-semibold text-white">Pole Density:</span> <span data-county-poles>{{ $deploymentCounties[0]['poles'] }}</span></p>
                        <p><span class="font-semibold text-white">Estimated Traffic:</span> <span data-county-traffic>{{ $deploymentCounties[0]['traffic'] }}</span></p>
                        <p><span class="font-semibold text-white">Recommended Mix:</span> <span data-county-focus>{{ $deploymentCounties[0]['focus'] }}</span></p>
                    </div>
                    <a href="{{ route('quote') }}" class="mt-4 inline-flex rounded-md bg-[#8b1e1a] px-4 py-2 text-xs font-bold text-white">Request Site List</a>
                </div>
            </div>
            <div class="relative overflow-hidden rounded-2xl border border-white/15">
                <img src="https://images.unsplash.com/photo-1473447198193-f208bcafacd3?auto=format&fit=crop&w=1800&q=80" alt="Kenya urban highway visibility network" class="h-full min-h-[320px] w-full object-cover opacity-75">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_25%_20%,rgba(238,147,110,0.35),transparent_40%),radial-gradient(circle_at_75%_70%,rgba(255,255,255,0.25),transparent_42%)]"></div>
                <div class="absolute bottom-4 left-4 right-4 rounded-lg border border-white/20 bg-black/40 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-[0.14em] text-[#f8cdb5]">Deployment Heat Zones</p>
                    <p class="mt-1 text-sm text-[#f2f2f2]">High-intensity commuter corridors receive clustered street light placements for repeated visual contact.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#f6eee6] py-16 lg:py-24">
        <div class="em-container grid gap-10 lg:grid-cols-2">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Why Outdoor Works</p>
                <h2 class="mt-3 text-3xl font-black text-[#2e1918]">Physical Presence Creates Unavoidable Recall</h2>
                <div class="mt-6 grid gap-4">
                    <div class="border-l-4 border-[#8b1e1a] bg-white px-4 py-3 text-sm text-[#4c3a36]">Commuter repetition drives memory over time, not just one impression.</div>
                    <div class="border-l-4 border-[#8b1e1a] bg-white px-4 py-3 text-sm text-[#4c3a36]">Outdoor media dominates geography and supports local market ownership.</div>
                    <div class="border-l-4 border-[#8b1e1a] bg-white px-4 py-3 text-sm text-[#4c3a36]">Large-format visibility amplifies trust and enterprise-level brand perception.</div>
                </div>
            </div>
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Campaign Workflow</p>
                <h3 class="mt-3 text-2xl font-black text-[#2e1918]">Execution From Planning to Reporting</h3>
                <ol class="mt-6 space-y-3">
                    @foreach ($streetLightProcess as $index => $step)
                        <li class="reveal-up flex items-start gap-3 border-b border-[#e7d0bf] pb-3 text-sm text-[#4e3c39]">
                            <span class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-[#5c1514] text-xs font-bold text-white">{{ $index + 1 }}</span>
                            <span>{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>

    <section id="promotions" class="bg-[linear-gradient(125deg,#130f15,#4b1a1b,#130f15)] py-16 text-white lg:py-24">
        <div class="em-container grid items-center gap-8 lg:grid-cols-[1fr_auto]">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#f2c5ac]">Smart Campaign Planner</p>
                <h2 class="mt-3 text-3xl font-black sm:text-4xl">Build a Data-Led Outdoor Plan in Minutes</h2>
                <p class="mt-3 max-w-2xl text-sm leading-7 text-[#e8d8cf]">Select industry, town, media type, and budget range, then receive recommended locations aligned to traffic behavior and campaign goals.</p>
            </div>
            <a href="{{ route('smart-campaign-planner') }}" class="inline-flex rounded-md bg-white px-6 py-3 text-sm font-black text-[#5c1514]">Get Recommended Locations</a>
        </div>
    </section>

    <section class="bg-white py-16 lg:py-24">
        <div class="em-container">
            <div class="max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Capability Decks</p>
                <h2 class="mt-3 text-3xl font-black text-[#2f1a19] sm:text-4xl">Download Profiles, Coverage Decks and Rate Support</h2>
            </div>
            <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @forelse ($companyProfiles as $profile)
                    <x-ui.document-card :title="$profile['name']" :url="$profile['url']" category="Service Profile" :date="'Published ' . now()->format('M Y')" />
                @empty
                    <x-ui.empty-state class="sm:col-span-2 xl:col-span-3" title="No service profiles yet" message="Service profile documents will appear here once uploaded.">
                        <x-ui.brand-button href="{{ route('contact-us') }}">Request Service Profile</x-ui.brand-button>
                    </x-ui.empty-state>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-[#5c1514] py-16 text-white">
        <div class="em-container text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#f2c3ab]">Final Call to Action</p>
            <h2 class="mx-auto mt-3 max-w-3xl text-3xl font-black sm:text-4xl">Ready to Put Your Brand on Kenya's Roads?</h2>
            <p class="mx-auto mt-4 max-w-2xl text-sm leading-7 text-[#f5ddd0]">Launch a visibility strategy built for movement, repetition, and measurable audience reach.</p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                <a href="{{ route('smart-campaign-planner') }}" class="inline-flex rounded-md bg-white px-5 py-3 text-sm font-bold text-[#5c1514]">Plan Campaign</a>
                <a href="{{ route('quote') }}" class="inline-flex rounded-md border border-white/40 px-5 py-3 text-sm font-bold text-white">Get Quote</a>
                <a href="{{ route('contact-us') }}" class="inline-flex rounded-md border border-white/40 px-5 py-3 text-sm font-bold text-white">Talk to Sales</a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const serviceData = @json($serviceData);
            const countyData = @json($deploymentCounties);

            const serviceTabs = Array.from(document.querySelectorAll('.service-tab'));
            const serviceName = document.querySelector('[data-service-name]');
            const serviceHeadline = document.querySelector('[data-service-headline]');
            const serviceDescription = document.querySelector('[data-service-description]');
            const serviceExample = document.querySelector('[data-service-example]');
            const serviceIndustries = document.querySelector('[data-service-industries]');
            const serviceImpact = document.querySelector('[data-service-impact]');
            const serviceImage = document.querySelector('[data-service-image]');
            const servicePageLink = document.querySelector('[data-service-page-link]');

            const setActiveService = (index) => {
                const data = serviceData[index];
                if (!data || !serviceName || !serviceHeadline || !serviceDescription || !serviceExample || !serviceIndustries || !serviceImpact || !serviceImage) return;
                serviceName.textContent = data.name;
                serviceHeadline.textContent = data.headline;
                serviceDescription.textContent = data.description;
                serviceExample.textContent = data.example;
                serviceIndustries.textContent = data.industries;
                serviceImpact.textContent = data.impact;
                serviceImage.src = data.image;
                serviceImage.alt = data.name + ' campaign visual';
                if (servicePageLink && data.slug) {
                    servicePageLink.href = '/services/' + data.slug;
                }
            };

            serviceTabs.forEach((tab) => {
                tab.addEventListener('click', () => {
                    const index = Number(tab.dataset.serviceIndex || 0);
                    setActiveService(index);
                    serviceTabs.forEach((item) => item.classList.remove('is-active', 'bg-[#5c1514]', 'text-white', 'border-[#5c1514]'));
                    tab.classList.add('is-active', 'bg-[#5c1514]', 'text-white', 'border-[#5c1514]');
                });
            });

            const hashToIndex = {
                '#billboards': 1,
                '#pavement-ads': 2,
                '#office-branding': 3,
                '#activations': 4,
                '#roadshows': 4,
                '#rollup-banners': 5,
                '#promotions': 4,
            };
            const hashIndex = hashToIndex[window.location.hash];
            if (typeof hashIndex === 'number') {
                setActiveService(hashIndex);
                const targetTab = serviceTabs[hashIndex];
                if (targetTab) {
                    serviceTabs.forEach((item) => item.classList.remove('is-active', 'bg-[#5c1514]', 'text-white', 'border-[#5c1514]'));
                    targetTab.classList.add('is-active', 'bg-[#5c1514]', 'text-white', 'border-[#5c1514]');
                }
            }

            const countyTabs = Array.from(document.querySelectorAll('.county-tab'));
            const countyName = document.querySelector('[data-county-name]');
            const countyPoles = document.querySelector('[data-county-poles]');
            const countyTraffic = document.querySelector('[data-county-traffic]');
            const countyFocus = document.querySelector('[data-county-focus]');

            const setCounty = (index) => {
                const data = countyData[index];
                if (!data || !countyName || !countyPoles || !countyTraffic || !countyFocus) return;
                countyName.textContent = data.name;
                countyPoles.textContent = data.poles;
                countyTraffic.textContent = data.traffic;
                countyFocus.textContent = data.focus;
            };

            countyTabs.forEach((tab) => {
                tab.addEventListener('click', () => {
                    const index = Number(tab.dataset.countyIndex || 0);
                    setCounty(index);
                    countyTabs.forEach((item) => item.classList.remove('is-active', 'bg-white', 'text-[#4a1b1a]'));
                    tab.classList.add('is-active', 'bg-white', 'text-[#4a1b1a]');
                });
            });

            const revealItems = document.querySelectorAll('.reveal-up');
            if ('IntersectionObserver' in window && revealItems.length > 0) {
                revealItems.forEach((item) => {
                    item.style.opacity = '0';
                    item.style.transform = 'translateY(24px)';
                    item.style.transition = 'all 500ms ease';
                });
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) return;
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    });
                }, { threshold: 0.2 });
                revealItems.forEach((item) => observer.observe(item));
            }
        });
    </script>
@endsection
