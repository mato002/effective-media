@extends('layouts.website')

@section('title', 'Who We Are | Effective Media')

@section('content')
    @php
        $reach = collect($profileContent['reach'] ?? []);
        $counties = $reach->pluck('county')->unique()->count();
        $locations = $reach->count();
        $poles = $reach->sum('poles');
        $firstCompanyProfile = $companyProfiles->first();
    @endphp

    <section id="overview" class="relative overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=2000&q=80');"></div>
        <div class="absolute inset-0 bg-[linear-gradient(115deg,rgba(92,21,20,0.9),rgba(92,21,20,0.75),rgba(23,23,23,0.72))]"></div>
        <div class="em-container relative py-20 lg:py-24">
            <x-ui.section-heading
                label="Corporate Profile"
                title="Building Brand Visibility Across Kenya"
                description="Effective Media delivers practical outdoor advertising solutions through strategically positioned street light boxes, billboards, branding infrastructure, and high-visibility campaign execution across multiple counties in Kenya."
                light="true"
                class="max-w-4xl"
            />
            <div class="mt-8 grid gap-4 sm:grid-cols-3">
                <x-ui.stats-card label="Since" value="2006" />
                <x-ui.stats-card label="Counties Covered" :value="$counties" suffix="+" />
                <x-ui.stats-card label="High Traffic Locations" :value="$locations" suffix="+" />
            </div>
        </div>
    </section>

    <section id="mission-vision" class="em-container py-16 lg:py-20">
        <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="em-card overflow-hidden"><img src="{{ asset('profile-gallery/profile-page-2.jpg') }}" alt="Street light installations" class="h-44 w-full object-cover"></div>
                <div class="em-card overflow-hidden"><img src="{{ asset('profile-gallery/profile-page-3.jpg') }}" alt="Billboard and road branding" class="h-44 w-full object-cover"></div>
                <div class="em-card overflow-hidden sm:col-span-2"><img src="{{ asset('profile-gallery/profile-page-6.jpg') }}" alt="Field branding operations" class="h-52 w-full object-cover"></div>
            </div>
            <div>
                <x-ui.section-heading label="Company Story" title="From Local Branding to Regional Visibility" :description="$profileContent['about']['company'] ?? ''" />
                <div class="mt-6 space-y-4">
                    @foreach (($profileContent['about']['story_timeline'] ?? []) as $entry)
                        <div class="em-card em-card-accent p-4">
                            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">{{ $entry['period'] }}</p>
                            <h3 class="mt-1 text-base font-bold text-[#171717]">{{ $entry['title'] }}</h3>
                            <p class="mt-1 text-sm text-[#4f4f4f]">{{ $entry['detail'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="coverage" class="em-pattern py-16">
        <div class="em-container">
            <x-ui.section-heading label="Coverage & Reach" title="Infrastructure Reach Across Counties" description="Outdoor media impact is driven by reach. Effective Media operates across high-traffic corridors with measurable site presence." />
            <div class="mt-8 grid gap-4 md:grid-cols-4">
                <x-ui.stats-card label="Counties" :value="$counties" suffix="+" />
                <x-ui.stats-card label="Media Locations" :value="$locations" suffix="+" />
                <x-ui.stats-card label="Active Poles" :value="$poles" suffix="+" />
                <x-ui.stats-card label="Coverage Towns" :value="count($profileContent['coverage_towns'] ?? [])" suffix="+" />
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($reach->groupBy('county')->take(8) as $county => $rows)
                    <div class="em-card em-card-accent p-4">
                        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">{{ $county }}</p>
                        <p class="mt-2 text-2xl font-bold text-[#171717]">{{ $rows->sum('poles') }}+</p>
                        <p class="text-sm text-[#5a5a5a]">{{ $rows->count() }} sites</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section id="why-effective-media" class="em-container scroll-mt-28 py-16">
        <x-ui.section-heading label="Why Effective Media" title="Why Brands Choose Effective Media" description="Built for trust, capacity, and operational confidence." />
        <div class="mt-8 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach (($profileContent['why_choose_us'] ?? []) as $point)
                <div class="em-card em-card-accent p-5">
                    <h3 class="text-base font-bold text-[#5c1514]">{{ $point['title'] }}</h3>
                    <p class="mt-2 text-sm text-[#4f4f4f]">{{ $point['detail'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="em-container pb-16">
        <x-ui.section-heading label="Services Snapshot" title="Media and Branding Solutions" description="Multi-format campaign support for local and national brands." />
        <div class="mt-8 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (($profileContent['services'] ?? []) as $service)
                <x-ui.service-card :title="$service" description="Campaign-ready planning, deployment, and maintenance support." :link="route('contact-us')" />
            @endforeach
        </div>
    </section>

    <section class="em-pattern py-16">
        <div class="em-container grid gap-8 lg:grid-cols-2">
            <div>
                <x-ui.section-heading label="Industries Served" title="Trusted Across Key Sectors" description="Campaign support for diverse sectors that depend on visibility and market presence." />
                <div class="mt-6 flex flex-wrap gap-3">
                    @foreach (($profileContent['industries'] ?? []) as $industry)
                        <span class="rounded-full bg-white px-4 py-2 text-sm font-semibold text-[#5c1514] shadow-sm">{{ $industry }}</span>
                    @endforeach
                </div>
            </div>
            <div id="clients">
                <x-ui.section-heading label="Featured Clients" title="Brands We Have Worked With" />
                <div class="mt-6 grid gap-3 sm:grid-cols-2">
                    @foreach (($profileContent['clients'] ?? []) as $client)
                        <div class="em-card em-card-accent p-4 text-center text-sm font-bold text-[#5c1514]">{{ $client }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section id="leadership-operations" class="em-container scroll-mt-28 py-16">
        <x-ui.section-heading label="How We Execute Campaigns" title="Operational Process" />
        <div class="mt-8 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach ([
                'Identify Locations',
                'Campaign Planning',
                'Artwork Approval',
                'Installation',
                'Monitoring & Maintenance',
                'Campaign Reporting'
            ] as $index => $step)
                <div class="em-card em-card-accent p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Step {{ $index + 1 }}</p>
                    <h3 class="mt-2 text-base font-bold text-[#171717]">{{ $step }}</h3>
                </div>
            @endforeach
        </div>
    </section>

    <section class="em-container pb-16">
        <x-ui.section-heading label="Operational Commitment" title="Our Professional Standards" />
        <div class="mt-8 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
            @foreach (($profileContent['operational_commitments'] ?? []) as $item)
                <div class="em-card em-card-accent p-5">
                    <p class="text-sm font-semibold text-[#4f4f4f]">{{ $item }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="em-container pb-16">
        <x-ui.section-heading label="Field Work Gallery" title="Real Outdoor Installation Footprint" description="Real visuals from profile documents showing site-level implementation." />
        <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (['profile-page-2.jpg', 'profile-page-3.jpg', 'profile-page-4.jpg', 'profile-page-5.jpg', 'profile-page-6.jpg', 'profile-page-7.jpg', 'profile-page-8.jpg'] as $image)
                <div class="em-card overflow-hidden">
                    <img src="{{ asset('profile-gallery/' . $image) }}" alt="Effective Media field work" class="h-44 w-full object-cover">
                </div>
            @endforeach
        </div>
    </section>

    <section class="em-pattern py-16">
        <div class="em-container grid gap-6 lg:grid-cols-[1.3fr,1fr] lg:items-center">
            <div>
                <x-ui.section-heading label="Future Outlook" title="Beyond Traditional Outdoor Advertising" description="Effective Media is advancing toward smart campaign planning, county-based targeting, and media intelligence workflows that improve visibility decisions." />
            </div>
            <div class="em-card em-card-accent p-6">
                <p class="text-sm leading-7 text-[#4f4f4f]">Future roadmap includes smarter location recommendation models, GIS-ready coverage planning, and integrated campaign performance workflows.</p>
            </div>
        </div>
    </section>

    <section class="em-angled py-14">
        <div class="em-container text-center">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">Ready To Increase Your Brand Visibility?</h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-[#f7d4c1]">Plan your next campaign with a proven outdoor media infrastructure team.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <x-ui.brand-button href="{{ route('smart-campaign-planner') }}">Plan Your Campaign</x-ui.brand-button>
                <x-ui.brand-button href="{{ route('contact-us') }}" variant="secondary">Request Quotation</x-ui.brand-button>
                @if (!empty($firstCompanyProfile['url']))
                    <a href="{{ $firstCompanyProfile['url'] }}" class="rounded-md bg-[#f04a2a] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#8b1e1a]">Download Company Profile</a>
                @endif
            </div>
        </div>
    </section>
@endsection
