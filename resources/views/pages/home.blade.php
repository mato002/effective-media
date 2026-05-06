@extends('layouts.website')

@section('title', 'Effective Media | Outdoor Advertising Infrastructure')

@section('content')
    @php
        $heroSlides = [
            asset('profile-gallery/profile-page-2.jpg'),
            asset('profile-gallery/profile-page-3.jpg'),
            asset('profile-gallery/profile-page-5.jpg'),
        ];
        $reach = collect($profileContent['reach'] ?? []);
        $countiesCovered = max($reach->pluck('county')->filter()->unique()->count(), 7);
        $townsCovered = max(count($profileContent['coverage_towns'] ?? []), 18);
        $polesCovered = max((int) $reach->sum('poles'), 730);
        $clientsCount = max((int) $testimonials->count(), 50);
        $coveragePoints = collect($profileContent['coverage_map_points'] ?? [])->values();
        $mapFocus = $coveragePoints->first() ?? ['town' => 'Nakuru', 'county' => 'Nakuru', 'media_type' => 'Street Light Ads'];
        $trustedBrands = ['KFC', 'Dr Mattress', 'KenJap', 'Wasili', 'Domaine', 'Ole Ken', 'EABL', 'Safaricom'];
        $mediaTypes = [
            ['title' => 'Street Light Ads', 'description' => 'Sequential pole placements across urban traffic corridors for repetitive brand recall.', 'image' => asset('profile-gallery/profile-page-2.jpg')],
            ['title' => 'Billboards', 'description' => 'Large-format static and illuminated billboards for highways, CBD entries, and major junctions.', 'image' => asset('profile-gallery/profile-page-3.jpg')],
            ['title' => 'Pavement Ads', 'description' => 'High-frequency roadside messages around retail zones, bus stops, and shopping districts.', 'image' => asset('profile-gallery/profile-page-5.jpg')],
            ['title' => 'Office Branding', 'description' => 'Corporate spaces and branch branding systems aligned to your campaign identity.', 'image' => asset('profile-gallery/profile-page-2.jpg')],
            ['title' => 'Activations', 'description' => 'Road shows and field activations that convert foot traffic into real customer interaction.', 'image' => asset('profile-gallery/profile-page-3.jpg')],
            ['title' => 'Roll-Up Banners', 'description' => 'Portable campaign units for events, retail entrances, and targeted touch points.', 'image' => asset('profile-gallery/profile-page-5.jpg')],
        ];
        $whyBlocks = [
            ['title' => 'Strategic Placement', 'desc' => 'High-traffic urban corridors and commuter routes.'],
            ['title' => 'Fast Deployment', 'desc' => 'Rapid installation, maintenance, and campaign turnaround.'],
            ['title' => 'Repetitive Visibility', 'desc' => 'Street-light sequencing improves ad recall and frequency.'],
            ['title' => 'Affordable Reach', 'desc' => 'Cost-effective exposure compared to traditional formats.'],
        ];
    @endphp

    <style>
        .em-reveal { opacity: 0; transform: translateY(24px); transition: opacity .7s ease, transform .7s ease; }
        .em-reveal.in { opacity: 1; transform: translateY(0); }
        .em-float { animation: emFloat 6s ease-in-out infinite; }
        .em-float:nth-child(2n) { animation-delay: .6s; }
        .em-float:nth-child(3n) { animation-delay: 1.2s; }
        .em-marquee { animation: emMarquee 20s linear infinite; }
        .em-marquee:hover { animation-play-state: paused; }
        .em-parallax { will-change: transform; }
        .em-night-glow::after {
            content: "";
            position: absolute;
            inset: auto -10% -20% -10%;
            height: 45%;
            background: radial-gradient(circle, rgba(255,184,84,0.26) 0%, rgba(255,184,84,0.03) 55%, rgba(255,184,84,0) 72%);
            pointer-events: none;
        }
        @keyframes emFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes emMarquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        @media (max-width: 640px) {
            .em-tight-section { padding-top: 3.5rem; padding-bottom: 3.5rem; }
            .em-compact-text { font-size: 0.95rem; line-height: 1.55; }
        }
    </style>

    <section class="relative isolate min-h-[88vh] overflow-hidden bg-[#0f0b0b] text-white lg:min-h-[95vh]">
        <div class="absolute inset-0" data-hero-slider>
            @foreach ($heroSlides as $index => $slide)
                <div class="absolute inset-0 bg-cover bg-center transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-hero-slide style="background-image: url('{{ $slide }}');"></div>
            @endforeach
        </div>
        <div class="absolute inset-0 em-parallax bg-[linear-gradient(120deg,rgba(22,13,13,0.94),rgba(92,21,20,0.84)_35%,rgba(139,30,26,0.68)_66%,rgba(12,12,12,0.68))]" data-parallax="-0.08"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_85%_22%,rgba(255,148,70,0.22),transparent_40%)]"></div>
        <div class="em-container relative z-10 flex min-h-[88vh] flex-col justify-center py-12 sm:py-14 lg:min-h-[95vh] lg:py-20">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div class="em-reveal text-center lg:text-left">
                    <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#f6bd95]">A Media Network Across Kenya</p>
                    <h1 class="mt-4 text-3xl font-black leading-tight sm:text-5xl lg:text-6xl">Your Brand. Seen Across Kenya.</h1>
                    <p class="em-compact-text mt-5 max-w-xl text-[#f4dacb] sm:text-base">Strategic outdoor advertising infrastructure across highways, CBDs, transport corridors and urban centers.</p>
                    <div class="mt-8 flex flex-wrap justify-center gap-3 lg:justify-start">
                        <a href="{{ route('smart-campaign-planner') }}" class="em-btn-primary">Plan Campaign</a>
                        <a href="#coverage-map" class="em-btn-secondary border-white/45 bg-white/10 text-white hover:bg-white/20">Explore Coverage</a>
                        <button type="button" class="em-btn-secondary border-white/45 bg-white/10 text-white hover:bg-white/20" data-open-download-modal>Download Profile</button>
                    </div>
                </div>
                <div class="relative em-reveal">
                    <div class="grid grid-cols-2 gap-4">
                        <img src="{{ asset('profile-gallery/profile-page-5.jpg') }}" alt="Roadside billboard installation" class="em-parallax h-44 w-full rounded-2xl border border-white/20 object-cover shadow-2xl sm:h-52 lg:h-60" data-parallax="-0.12">
                        <img src="{{ asset('profile-gallery/profile-page-3.jpg') }}" alt="Highway campaign visibility" class="em-night-glow em-parallax relative mt-8 h-44 w-full rounded-2xl border border-white/20 object-cover shadow-2xl sm:h-52 lg:h-60" data-parallax="-0.16">
                        <img src="{{ asset('profile-gallery/profile-page-2.jpg') }}" alt="Urban street light ads" class="em-parallax -mt-4 h-48 w-full rounded-2xl border border-white/20 object-cover shadow-2xl sm:h-56 lg:h-64" data-parallax="-0.14">
                        <img src="{{ asset('profile-gallery/profile-page-5.jpg') }}" alt="Illuminated night exposure" class="em-parallax h-48 w-full rounded-2xl border border-white/20 object-cover shadow-2xl sm:h-56 lg:h-64" data-parallax="-0.1">
                    </div>
                    <div class="pointer-events-none absolute -left-5 top-8 rounded-xl border border-white/25 bg-white/15 px-4 py-3 backdrop-blur em-float">
                        <p class="text-xs uppercase tracking-[0.16em] text-[#f6c49e]">Coverage</p>
                        <p class="text-xl font-black"><span data-counter="730">0</span>+</p>
                    </div>
                </div>
            </div>
            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div class="em-float rounded-xl border border-white/25 bg-white/15 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-[0.16em] text-[#f8c8a8]">Poles</p>
                    <p class="mt-1 text-2xl font-black"><span data-counter="{{ $polesCovered }}">0</span>+</p>
                </div>
                <div class="em-float rounded-xl border border-white/25 bg-white/15 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-[0.16em] text-[#f8c8a8]">Towns</p>
                    <p class="mt-1 text-2xl font-black"><span data-counter="{{ $townsCovered }}">0</span>+</p>
                </div>
                <div class="em-float rounded-xl border border-white/25 bg-white/15 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-[0.16em] text-[#f8c8a8]">Counties</p>
                    <p class="mt-1 text-2xl font-black"><span data-counter="{{ $countiesCovered }}">0</span>+</p>
                </div>
                <div class="em-float rounded-xl border border-white/25 bg-white/15 p-4 backdrop-blur">
                    <p class="text-xs uppercase tracking-[0.16em] text-[#f8c8a8]">Clients</p>
                    <p class="mt-1 text-2xl font-black"><span data-counter="{{ $clientsCount }}">0</span>+</p>
                </div>
            </div>
        </div>
    </section>

    <section class="overflow-hidden bg-[#1a1010] py-8 text-white sm:py-10">
        <div class="em-container">
            <p class="mb-5 text-center text-xs font-semibold uppercase tracking-[0.24em] text-[#f5b98f]">Trusted By Brands</p>
            <div class="relative overflow-hidden">
                <div class="em-marquee flex w-[200%] gap-4">
                    @foreach (array_merge($trustedBrands, $trustedBrands) as $brand)
                        <div class="flex min-w-[11rem] items-center justify-center rounded-xl border border-white/15 bg-white/10 px-6 py-3 text-sm font-semibold tracking-wide">
                            {{ $brand }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="coverage-map" class="em-tight-section bg-[#f8f3ee] py-16 sm:py-20">
        <div class="em-container grid gap-6 lg:grid-cols-2">
            <div class="em-card em-reveal p-6 sm:p-8">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Coverage Network</p>
                <h2 class="mt-2 text-2xl font-black text-[#221211] sm:text-3xl">Interactive Kenya Coverage Map</h2>
                <div class="mt-6 rounded-2xl border border-[#ecdac8] bg-[radial-gradient(circle_at_30%_20%,#fff,#f4e5d8_70%)] p-4 sm:p-6">
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        @foreach ($coveragePoints->take(10) as $point)
                            <button type="button" class="rounded-md border border-[#e6d0be] bg-white px-3 py-2 text-left font-semibold text-[#5c1514] transition hover:-translate-y-0.5 hover:shadow" data-map-point="{{ $point['town'] ?? 'Town' }}" data-map-county="{{ $point['county'] ?? 'County' }}" data-map-type="{{ $point['media_type'] ?? 'Street Light Ads' }}">
                                {{ $point['town'] ?? 'Coverage Point' }}
                            </button>
                        @endforeach
                        @if ($coveragePoints->isEmpty())
                            <div class="col-span-2 rounded-md border border-dashed border-[#d8b69f] bg-white/70 p-4 text-sm text-[#6e5c54]">Coverage points will be displayed here from CMS data.</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="em-card em-reveal p-6 sm:p-8">
                <div class="hidden lg:block">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Campaign Insight</p>
                    <h3 class="mt-2 text-3xl font-black text-[#1e1010]" data-map-town>{{ $mapFocus['town'] ?? 'Nakuru' }} Coverage</h3>
                    <div class="mt-5 space-y-3 text-sm text-[#4e3e38]">
                        <p><span class="font-semibold text-[#171717]">{{ $polesCovered }}</span> poles available across strategic visibility points.</p>
                        <p data-map-type-copy>{{ $mapFocus['media_type'] ?? 'Street Light Ads' }} inventory optimized for highway and CBD targeting.</p>
                        <p>High commuter traffic and repetitive exposure for stronger market recall.</p>
                        <p>County focus: <span class="font-semibold text-[#171717]" data-map-county>{{ $mapFocus['county'] ?? 'Nakuru' }}</span>.</p>
                    </div>
                </div>
                <details class="rounded-xl border border-[#ecd7c6] bg-[#fff9f4] p-4 lg:hidden" open>
                    <summary class="cursor-pointer text-sm font-semibold text-[#8b1e1a]">Campaign Insight Panel</summary>
                    <h3 class="mt-4 text-2xl font-black text-[#1e1010]" data-map-town>{{ $mapFocus['town'] ?? 'Nakuru' }} Coverage</h3>
                    <div class="mt-4 space-y-3 text-sm text-[#4e3e38]">
                        <p><span class="font-semibold text-[#171717]">{{ $polesCovered }}</span> poles available across strategic visibility points.</p>
                        <p data-map-type-copy>{{ $mapFocus['media_type'] ?? 'Street Light Ads' }} inventory optimized for highway and CBD targeting.</p>
                        <p>High commuter traffic and repetitive exposure for stronger market recall.</p>
                        <p>County focus: <span class="font-semibold text-[#171717]" data-map-county>{{ $mapFocus['county'] ?? 'Nakuru' }}</span>.</p>
                    </div>
                </details>
                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('quote') }}" class="em-btn-primary">Request Quote</a>
                    <a href="{{ route('smart-campaign-planner') }}" class="em-btn-secondary">Plan Campaign</a>
                </div>
            </div>
        </div>
    </section>

    <section class="em-tight-section bg-white py-16 sm:py-20">
        <div class="em-container space-y-10">
            <div class="em-reveal max-w-3xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Media Types</p>
                <h2 class="mt-2 text-3xl font-black text-[#1f1111] sm:text-4xl">Infrastructure Designed For Visibility</h2>
            </div>
            @foreach ($mediaTypes as $index => $type)
                <div class="em-reveal grid items-center gap-6 {{ $index % 2 === 0 ? 'lg:grid-cols-[1.2fr_1fr]' : 'lg:grid-cols-[1fr_1.2fr]' }}">
                    @if ($index % 2 === 0)
                        <img src="{{ $type['image'] }}" alt="{{ $type['title'] }}" class="em-parallax h-72 w-full rounded-2xl object-cover shadow-lg" data-parallax="-0.08">
                    @endif
                    <div class="rounded-2xl border border-[#ecd9c7] bg-[#fffaf5] p-6 sm:p-8">
                        <p class="text-xs font-semibold uppercase tracking-[0.16em] text-[#8b1e1a]">0{{ $index + 1 }}</p>
                        <h3 class="mt-2 text-2xl font-black text-[#201211]">{{ $type['title'] }}</h3>
                        <p class="mt-3 text-sm leading-7 text-[#55453f]">{{ $type['description'] }}</p>
                        <a href="{{ route('quote', ['media_type' => $type['title']]) }}" class="mt-5 inline-flex text-sm font-semibold text-[#8b1e1a]">Launch {{ $type['title'] }} Campaign</a>
                    </div>
                    @if ($index % 2 !== 0)
                        <img src="{{ $type['image'] }}" alt="{{ $type['title'] }}" class="em-parallax h-72 w-full rounded-2xl object-cover shadow-lg" data-parallax="-0.08">
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <section class="em-tight-section bg-[#130f0f] py-16 text-white sm:py-20">
        <div class="em-container">
            <div class="em-reveal mb-8 max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#f1b18c]">Campaign Showcase</p>
                <h2 class="mt-2 text-3xl font-black sm:text-4xl">Real Field Execution Across Kenya</h2>
            </div>
            <div class="-mx-4 flex snap-x snap-mandatory gap-4 overflow-x-auto px-4 pb-2 sm:mx-0 sm:grid sm:overflow-visible sm:px-0 sm:pb-0 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($featured_portfolio->take(6) as $item)
                    <article class="group em-reveal min-w-[84%] snap-center overflow-hidden rounded-xl border border-white/15 bg-white/5 sm:min-w-0">
                        <img src="{{ $item->image_url ?? asset('profile-gallery/profile-page-3.jpg') }}" alt="{{ $item->title }}" class="h-56 w-full object-cover transition duration-500 group-hover:scale-110">
                        <div class="space-y-2 p-4">
                            <p class="text-base font-semibold">{{ $item->title }}</p>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <span class="rounded-full bg-white/15 px-2 py-1">{{ $item->campaign_location ?: 'Kenya' }}</span>
                                <span class="rounded-full bg-white/15 px-2 py-1">{{ $item->campaign_type ?: 'Outdoor Media' }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    @for ($i = 0; $i < 6; $i++)
                        <article class="group em-reveal min-w-[84%] snap-center overflow-hidden rounded-xl border border-white/15 bg-white/5 sm:min-w-0">
                            <img src="{{ $heroSlides[$i % count($heroSlides)] }}" alt="Campaign showcase placeholder" class="h-56 w-full object-cover transition duration-500 group-hover:scale-110">
                            <div class="space-y-2 p-4">
                                <p class="text-base font-semibold">Campaign Zone {{ $i + 1 }}</p>
                                <div class="flex flex-wrap gap-2 text-xs">
                                    <span class="rounded-full bg-white/15 px-2 py-1">Nakuru</span>
                                    <span class="rounded-full bg-white/15 px-2 py-1">Street Light Ads</span>
                                </div>
                            </div>
                        </article>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    <section class="em-tight-section bg-[#faf5f0] py-16 sm:py-20">
        <div class="em-container">
            <div class="em-reveal mb-8 max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Why Effective Media</p>
                <h2 class="mt-2 text-3xl font-black text-[#1f1111] sm:text-4xl">Built For Dominant Market Visibility</h2>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($whyBlocks as $block)
                    <article class="em-reveal rounded-2xl border border-[#ead7c5] bg-white p-6 shadow-sm">
                        <div class="mb-3 h-10 w-10 rounded-lg bg-[#8b1e1a] text-center text-2xl leading-10 text-white">+</div>
                        <h3 class="text-lg font-bold text-[#241514]">{{ $block['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-[#5f4f48]">{{ $block['desc'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="em-tight-section bg-[#120d0e] py-16 text-white sm:py-20">
        <div class="em-container">
            <div class="em-reveal rounded-2xl border border-white/10 bg-white/5 p-6 backdrop-blur sm:p-8">
                <p class="text-xs font-semibold uppercase tracking-[0.22em] text-[#f2b48c]">Smart Campaign Planner</p>
                <h2 class="mt-2 text-3xl font-black sm:text-4xl">Build Campaign Recommendations Instantly</h2>
                <form action="{{ route('quote') }}" method="GET" class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <select name="industry" class="em-hero-select rounded-lg border border-white/20 bg-white/10 px-3 py-3 text-sm text-white">
                        <option value="" selected class="em-hero-placeholder">Select Industry</option>
                        <option>Retail</option><option>FMCG</option><option>Real Estate</option><option>Finance</option>
                    </select>
                    <select name="county" class="em-hero-select rounded-lg border border-white/20 bg-white/10 px-3 py-3 text-sm text-white">
                        <option value="" selected class="em-hero-placeholder">Select Location</option>
                        @foreach ($reach->pluck('county')->filter()->unique()->take(8) as $county)
                            <option>{{ $county }}</option>
                        @endforeach
                    </select>
                    <select name="media_type" class="em-hero-select rounded-lg border border-white/20 bg-white/10 px-3 py-3 text-sm text-white">
                        <option value="" selected class="em-hero-placeholder">Select Media Type</option>
                        @foreach ($mediaTypes as $type)
                            <option>{{ $type['title'] }}</option>
                        @endforeach
                    </select>
                    <select name="budget_range" class="em-hero-select rounded-lg border border-white/20 bg-white/10 px-3 py-3 text-sm text-white">
                        <option value="" selected class="em-hero-placeholder">Select Budget</option>
                        <option>KES 100K - 300K</option><option>KES 300K - 750K</option><option>KES 750K+</option>
                    </select>
                    <button class="em-btn-primary w-full sm:col-span-2 lg:col-span-4" type="submit">Get Recommended Locations</button>
                </form>
            </div>
        </div>
    </section>

    <section class="em-tight-section bg-white py-16 sm:py-20">
        <div class="em-container">
            <div class="em-reveal mb-8 max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Rates Preview</p>
                <h2 class="mt-2 text-3xl font-black text-[#1f1111] sm:text-4xl">Estimate Campaign Costs Fast</h2>
            </div>
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                <article class="em-reveal rounded-2xl border border-[#ead8c8] p-6">
                    <p class="text-xs uppercase tracking-[0.16em] text-[#8b1e1a]">Starter</p>
                    <p class="mt-2 text-3xl font-black text-[#211312]">KES 120K</p>
                    <p class="mt-2 text-sm text-[#5d4d46]">Street light placements for local market reach.</p>
                    <a href="{{ route('quote', ['budget_range' => 'KES 100K - 300K']) }}" class="em-btn-secondary mt-4 w-full justify-center sm:w-auto">Get Estimate</a>
                </article>
                <article class="em-reveal rounded-2xl border border-[#ead8c8] bg-[#fff6ef] p-6">
                    <p class="text-xs uppercase tracking-[0.16em] text-[#8b1e1a]">Growth</p>
                    <p class="mt-2 text-3xl font-black text-[#211312]">KES 450K</p>
                    <p class="mt-2 text-sm text-[#5d4d46]">Multi-town deployment with CBD + highway impact.</p>
                    <a href="{{ route('quote', ['budget_range' => 'KES 300K - 750K']) }}" class="em-btn-primary mt-4 w-full justify-center sm:w-auto">Plan Package</a>
                </article>
                <article class="em-reveal rounded-2xl border border-[#ead8c8] p-6">
                    <p class="text-xs uppercase tracking-[0.16em] text-[#8b1e1a]">Dominance</p>
                    <p class="mt-2 text-3xl font-black text-[#211312]">KES 900K+</p>
                    <p class="mt-2 text-sm text-[#5d4d46]">National coverage and premium visibility corridors.</p>
                    <a href="{{ route('contact-us') }}" class="em-btn-secondary mt-4 w-full justify-center sm:w-auto">Talk to Sales</a>
                </article>
            </div>
        </div>
    </section>

    <section class="em-tight-section bg-[#f9f0e6] py-16 sm:py-20">
        <div class="em-container">
            <div class="em-reveal mb-8 max-w-2xl">
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Company Profile</p>
                <h2 class="mt-2 text-3xl font-black text-[#1f1111] sm:text-4xl">Download Capability Documents</h2>
            </div>
            <div class="grid gap-4 lg:grid-cols-2">
                @forelse ($companyProfiles->take(4) as $profile)
                    <article class="em-reveal flex flex-col items-start gap-4 rounded-2xl border border-[#e7d3c0] bg-white p-4 shadow-sm sm:flex-row sm:items-center">
                        <div class="h-24 w-20 shrink-0 rounded-lg bg-[linear-gradient(160deg,#8b1e1a,#dc6337)] p-3 text-xs font-semibold text-white">PDF</div>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-base font-bold text-[#201211]">{{ $profile['name'] }}</p>
                            <div class="mt-2 flex flex-wrap gap-2 text-xs">
                                <span class="rounded-full bg-[#f6e5d8] px-2 py-1 text-[#8b1e1a]">Company Profile</span>
                                <span class="rounded-full bg-[#f6e5d8] px-2 py-1 text-[#8b1e1a]">{{ rand(120, 900) }} downloads</span>
                            </div>
                        </div>
                        <a href="{{ $profile['url'] }}" target="_blank" rel="noopener noreferrer" class="em-btn-primary w-full justify-center sm:w-auto">Download</a>
                    </article>
                @empty
                    <x-ui.empty-state class="lg:col-span-2" title="Company documents coming soon" message="Profile documents will appear here when uploaded to project storage.">
                        <x-ui.brand-button href="{{ route('contact-us') }}">Request Profile by Email</x-ui.brand-button>
                    </x-ui.empty-state>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-[#5c1514] py-12 text-white sm:py-14">
        <div class="em-container em-reveal flex flex-col items-start justify-between gap-6 lg:flex-row lg:items-center">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.24em] text-[#f7bb95]">Campaign Ready</p>
                <h2 class="mt-2 text-3xl font-black sm:text-4xl">Ready To Dominate Your Market Visibility?</h2>
            </div>
            <div class="flex w-full flex-wrap gap-3 lg:w-auto">
                <a href="{{ route('quote') }}" class="em-btn-primary w-full justify-center bg-[#f04a2a] hover:bg-[#ff6f4d] sm:w-auto">Get Quotation</a>
                <a href="{{ route('contact-us') }}" class="em-btn-secondary w-full justify-center border-white/40 bg-white/10 text-white hover:bg-white/20 sm:w-auto">Contact Sales</a>
                <a href="{{ route('smart-campaign-planner') }}" class="em-btn-secondary w-full justify-center border-white/40 bg-white/10 text-white hover:bg-white/20 sm:w-auto">Plan Campaign</a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slides = Array.from(document.querySelectorAll('[data-hero-slide]'));
            if (slides.length > 1) {
                let index = 0;
                setInterval(() => {
                    slides[index].classList.remove('opacity-100');
                    slides[index].classList.add('opacity-0');
                    index = (index + 1) % slides.length;
                    slides[index].classList.remove('opacity-0');
                    slides[index].classList.add('opacity-100');
                }, 4500);
            }

            const observer = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in');
                    }
                });
            }, { threshold: 0.15 });
            document.querySelectorAll('.em-reveal').forEach((element) => observer.observe(element));

            document.querySelectorAll('[data-counter]').forEach((counter) => {
                const target = Number(counter.getAttribute('data-counter') || 0);
                const duration = 1300;
                const start = performance.now();
                const animate = (time) => {
                    const progress = Math.min((time - start) / duration, 1);
                    counter.textContent = Math.floor(progress * target).toString();
                    if (progress < 1) requestAnimationFrame(animate);
                };
                requestAnimationFrame(animate);
            });

            const mapTown = document.querySelector('[data-map-town]');
            const mapCounty = document.querySelector('[data-map-county]');
            const mapTypeCopy = document.querySelector('[data-map-type-copy]');
            document.querySelectorAll('[data-map-point]').forEach((button) => {
                button.addEventListener('click', () => {
                    const town = button.getAttribute('data-map-point');
                    const county = button.getAttribute('data-map-county');
                    const type = button.getAttribute('data-map-type');
                    if (mapTown) mapTown.textContent = `${town} Coverage`;
                    if (mapCounty) mapCounty.textContent = county || 'Kenya';
                    if (mapTypeCopy) mapTypeCopy.textContent = `${type || 'Street Light Ads'} inventory optimized for highway and CBD targeting.`;
                });
            });

            const parallaxItems = document.querySelectorAll('.em-parallax[data-parallax]');
            const onScroll = () => {
                const y = window.scrollY;
                parallaxItems.forEach((item) => {
                    const speed = Number(item.getAttribute('data-parallax'));
                    item.style.transform = `translate3d(0, ${y * speed}px, 0)`;
                });
            };
            onScroll();
            window.addEventListener('scroll', onScroll, { passive: true });
        });
    </script>
@endsection
