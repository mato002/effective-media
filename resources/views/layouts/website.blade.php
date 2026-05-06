<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <link rel="preconnect" href="https://unpkg.com" crossorigin>
    <link rel="dns-prefetch" href="//unpkg.com">
    <link rel="dns-prefetch" href="//tile.openstreetmap.org">
    <title>@yield('title', 'Effective Media')</title>
    <meta name="description" content="@yield('meta_description', 'Modern outdoor advertising and branding infrastructure for Kenya and East Africa.')">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="pb-14 antialiased lg:pb-0">
    <style>
        :root {
            --em-header-offset: 126px;
            --em-header-scroll-offset: 126px;
        }
        html {
            scroll-padding-top: var(--em-header-offset);
        }
        section[id], div[id], article[id] {
            scroll-margin-top: calc(var(--em-header-offset) + 12px);
        }
    </style>
    <header class="fixed inset-x-0 top-0 z-50" data-site-header>
        <div class="max-h-[52px] overflow-hidden border-b border-[#c9b8a1] bg-[#5c1514] text-[#fef3e8] transition-all duration-300" data-top-contact-bar>
            <div class="em-container flex items-center justify-between gap-3 py-2 text-xs sm:text-sm">
                <div class="hidden items-center gap-5 sm:flex">
                    <a href="tel:{{ preg_replace('/\s+/', '', ($profileContact['phones'][0] ?? '')) }}" class="font-medium hover:text-[#ffd9c8]">Call: {{ ($profileContact['phones'][0] ?? '') }}</a>
                    <a href="mailto:{{ $profileContact['email'] ?? '' }}" class="font-medium hover:text-[#ffd9c8]">Email: {{ $profileContact['email'] ?? '' }}</a>
                    <a href="{{ route('contact') }}#location" class="font-medium hover:text-[#ffd9c8]">Location: {{ $profileContact['office'] ?? 'Nakuru, Kenya' }}</a>
                </div>
                <div class="flex w-full items-center justify-between gap-2 sm:hidden">
                    <span class="font-medium">Effective Media Contact</span>
                    <a href="{{ route('contact') }}#details" class="rounded-md border border-white/35 px-2.5 py-1 text-[11px] font-semibold uppercase tracking-wide text-white">Contacts</a>
                </div>
                <a href="https://wa.me/254725646642?text=Hi%20Effective%20Media%2C%20I%20need%20a%20campaign%20quote." target="_blank" rel="noopener noreferrer" class="hidden rounded-md border border-white/30 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white sm:inline-flex">WhatsApp Sales</a>
            </div>
        </div>
        <div class="border-b border-[#ecdac8] bg-white/95 backdrop-blur transition-all duration-300" data-main-navbar>
            <div class="em-container flex items-center justify-between py-3 lg:py-4">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ route('brand-asset.view', ['filename' => 'logo.jpg']) }}" alt="Effective Media logo" class="h-12 w-12 rounded-md border border-[#e7d9cb] object-cover">
                    <span class="text-base font-bold tracking-wide text-[#5c1514] sm:text-lg">Effective Media</span>
                </a>

                <nav class="hidden items-center gap-6 lg:flex" data-desktop-nav>
                    <a href="{{ route('home') }}" class="em-nav-link {{ request()->routeIs('home') ? 'em-nav-link-active' : '' }}">Home</a>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('who-we-are') ? 'em-nav-link-active' : '' }}" aria-expanded="false">
                            Who We Are
                            <span aria-hidden="true">▾</span>
                        </button>
                        <div class="em-dropdown-menu" role="menu">
                            <a href="{{ route('who-we-are') }}#overview" class="em-dropdown-link" role="menuitem">Company Overview</a>
                            <a href="{{ route('who-we-are') }}#mission-vision" class="em-dropdown-link" role="menuitem">Mission & Vision</a>
                            <a href="{{ route('portfolio') }}#coverage" class="em-dropdown-link" role="menuitem">Coverage & Reach</a>
                            <a href="{{ route('who-we-are') }}#clients" class="em-dropdown-link" role="menuitem">Clients</a>
                            <a href="{{ route('portfolio') }}#documents" class="em-dropdown-link" role="menuitem">Download Profile</a>
                        </div>
                    </div>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('what-we-do') ? 'em-nav-link-active' : '' }}" aria-expanded="false">
                            What We Do
                            <span aria-hidden="true">▾</span>
                        </button>
                        <div class="em-dropdown-menu" role="menu">
                            <a href="{{ route('what-we-do') }}#street-light-box" class="em-dropdown-link" role="menuitem">Street Light Box Advertising</a>
                            <a href="{{ route('what-we-do') }}#billboards" class="em-dropdown-link" role="menuitem">Billboards</a>
                            <a href="{{ route('what-we-do') }}#pavement-ads" class="em-dropdown-link" role="menuitem">Pavement Ads</a>
                            <a href="{{ route('what-we-do') }}#office-branding" class="em-dropdown-link" role="menuitem">Office Branding</a>
                            <a href="{{ route('what-we-do') }}#rollup-banners" class="em-dropdown-link" role="menuitem">Roll-up Banners & Tear Drops</a>
                            <a href="{{ route('what-we-do') }}#activations" class="em-dropdown-link" role="menuitem">Product Launches & Activations</a>
                            <a href="{{ route('what-we-do') }}#roadshows" class="em-dropdown-link" role="menuitem">Road Shows & Merchandising</a>
                            <a href="{{ route('what-we-do') }}#promotions" class="em-dropdown-link" role="menuitem">Advertising & Promotions</a>
                        </div>
                    </div>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('portfolio') ? 'em-nav-link-active' : '' }}" aria-expanded="false">
                            Portfolio
                            <span aria-hidden="true">▾</span>
                        </button>
                        <div class="em-dropdown-menu" role="menu">
                            <a href="{{ route('portfolio') }}#gallery" class="em-dropdown-link" role="menuitem">Campaign Gallery</a>
                            <a href="{{ route('portfolio', ['filter' => 'street-light-ads']) }}#gallery" class="em-dropdown-link" role="menuitem">Street Light Ads</a>
                            <a href="{{ route('portfolio', ['filter' => 'billboards']) }}#gallery" class="em-dropdown-link" role="menuitem">Billboards</a>
                            <a href="{{ route('portfolio', ['filter' => 'office-branding']) }}#gallery" class="em-dropdown-link" role="menuitem">Office Branding</a>
                            <a href="{{ route('portfolio', ['filter' => 'pavement-ads']) }}#gallery" class="em-dropdown-link" role="menuitem">Pavement Ads</a>
                            <a href="{{ route('portfolio', ['filter' => 'activations']) }}#gallery" class="em-dropdown-link" role="menuitem">Activations</a>
                            <a href="{{ route('portfolio') }}#clients" class="em-dropdown-link" role="menuitem">Client Work</a>
                        </div>
                    </div>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('smart-campaign-planner') ? 'em-nav-link-active' : '' }}" aria-expanded="false">
                            Smart Campaign Planner
                            <span aria-hidden="true">▾</span>
                        </button>
                        <div class="em-dropdown-menu" role="menu">
                            <a href="{{ route('smart-campaign-planner') }}#location" class="em-dropdown-link" role="menuitem">Plan by Location</a>
                            <a href="{{ route('portfolio') }}#coverage" class="em-dropdown-link" role="menuitem">Explore Coverage Map</a>
                            <a href="{{ route('smart-campaign-planner') }}#calculator" class="em-dropdown-link" role="menuitem">Estimate Campaign Cost</a>
                            <a href="{{ route('smart-campaign-planner') }}#recommendation" class="em-dropdown-link" role="menuitem">Request Recommendation</a>
                            <a href="{{ route('quote') }}" class="em-dropdown-link" role="menuitem">Generate Quote</a>
                        </div>
                    </div>
                    <a href="{{ route('faqs') }}" class="em-nav-link {{ request()->routeIs('faqs') ? 'em-nav-link-active' : '' }}">FAQs</a>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('contact-us') || request()->routeIs('contact') ? 'em-nav-link-active' : '' }}" aria-expanded="false">
                            Contact Us
                            <span aria-hidden="true">▾</span>
                        </button>
                        <div class="em-dropdown-menu" role="menu">
                            <a href="{{ route('contact') }}#details" class="em-dropdown-link" role="menuitem">Contact Details</a>
                            <a href="{{ route('quote') }}" class="em-dropdown-link" role="menuitem">Request Quote</a>
                            <a href="https://wa.me/254725646642?text=Hi%20Effective%20Media%2C%20I%20am%20interested%20in%20outdoor%20advertising.%20Please%20share%20available%20sites%20and%20rates." target="_blank" rel="noopener noreferrer" class="em-dropdown-link" role="menuitem">WhatsApp Sales</a>
                            <a href="{{ route('contact') }}#form" class="em-dropdown-link" role="menuitem">Send Enquiry</a>
                            <a href="{{ route('contact') }}#location" class="em-dropdown-link" role="menuitem">Office Location</a>
                        </div>
                    </div>
                </nav>

                <div class="flex items-center gap-2">
                    <a href="{{ route('quote') }}" class="em-btn-primary hidden lg:inline-flex" data-track-event="quote_started">Get a Quote</a>
                    <a href="{{ route('quote') }}" class="rounded-md bg-[#8b1e1a] px-3 py-2 text-xs font-semibold text-white lg:hidden" data-track-event="quote_started">Quote</a>
                    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-[#d8bba6] text-[#5c1514] lg:hidden" data-mobile-menu-toggle aria-expanded="false" aria-controls="mobile-site-menu">
                        <span class="sr-only">Toggle menu</span>
                        ☰
                    </button>
                </div>
            </div>
            <div id="mobile-site-menu" class="hidden border-t border-[#ecdac8] bg-white px-4 py-4 lg:hidden" data-mobile-menu>
                <nav class="grid max-h-[calc(100vh-140px)] gap-1 overflow-y-auto pr-1 text-sm font-semibold text-[#3b2525]">
                    <a href="{{ route('home') }}" class="rounded-md px-3 py-2 hover:bg-[#f7eee7]">Home</a>
                    <details class="rounded-md border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">Who We Are</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 text-sm">
                            <a href="{{ route('who-we-are') }}#overview" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Company Overview</a>
                            <a href="{{ route('who-we-are') }}#mission-vision" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Mission & Vision</a>
                            <a href="{{ route('portfolio') }}#coverage" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Coverage & Reach</a>
                            <a href="{{ route('who-we-are') }}#clients" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Clients</a>
                            <a href="{{ route('portfolio') }}#documents" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Download Profile</a>
                        </div>
                    </details>
                    <details class="rounded-md border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">What We Do</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 text-sm">
                            <a href="{{ route('what-we-do') }}#street-light-box" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Street Light Box Advertising</a>
                            <a href="{{ route('what-we-do') }}#billboards" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Billboards</a>
                            <a href="{{ route('what-we-do') }}#pavement-ads" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Pavement Ads</a>
                            <a href="{{ route('what-we-do') }}#office-branding" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Office Branding</a>
                            <a href="{{ route('what-we-do') }}#rollup-banners" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Roll-up Banners & Tear Drops</a>
                            <a href="{{ route('what-we-do') }}#activations" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Product Launches & Activations</a>
                            <a href="{{ route('what-we-do') }}#roadshows" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Road Shows & Merchandising</a>
                            <a href="{{ route('what-we-do') }}#promotions" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Advertising & Promotions</a>
                        </div>
                    </details>
                    <details class="rounded-md border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">Portfolio</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 text-sm">
                            <a href="{{ route('portfolio') }}#gallery" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Campaign Gallery</a>
                            <a href="{{ route('portfolio', ['filter' => 'street-light-ads']) }}#gallery" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Street Light Ads</a>
                            <a href="{{ route('portfolio', ['filter' => 'billboards']) }}#gallery" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Billboards</a>
                            <a href="{{ route('portfolio', ['filter' => 'office-branding']) }}#gallery" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Office Branding</a>
                            <a href="{{ route('portfolio', ['filter' => 'pavement-ads']) }}#gallery" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Pavement Ads</a>
                            <a href="{{ route('portfolio', ['filter' => 'activations']) }}#gallery" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Activations</a>
                            <a href="{{ route('portfolio') }}#clients" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Client Work</a>
                        </div>
                    </details>
                    <details class="rounded-md border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">Smart Campaign Planner</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 text-sm">
                            <a href="{{ route('smart-campaign-planner') }}#location" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Plan by Location</a>
                            <a href="{{ route('portfolio') }}#coverage" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Explore Coverage Map</a>
                            <a href="{{ route('smart-campaign-planner') }}#calculator" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Estimate Campaign Cost</a>
                            <a href="{{ route('smart-campaign-planner') }}#recommendation" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Request Recommendation</a>
                            <a href="{{ route('quote') }}" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Generate Quote</a>
                        </div>
                    </details>
                    <a href="{{ route('faqs') }}" class="rounded-md px-3 py-2 hover:bg-[#f7eee7]">FAQs</a>
                    <details class="rounded-md border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">Contact Us</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 text-sm">
                            <a href="{{ route('contact') }}#details" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Contact Details</a>
                            <a href="{{ route('quote') }}" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Request Quote</a>
                            <a href="https://wa.me/254725646642?text=Hi%20Effective%20Media%2C%20I%20am%20interested%20in%20outdoor%20advertising.%20Please%20share%20available%20sites%20and%20rates." target="_blank" rel="noopener noreferrer" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">WhatsApp Sales</a>
                            <a href="{{ route('contact') }}#form" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Send Enquiry</a>
                            <a href="{{ route('contact') }}#location" class="rounded-md px-2 py-1.5 hover:bg-[#f7eee7]">Office Location</a>
                        </div>
                    </details>
                </nav>
            </div>
        </div>
        <div class="em-pattern h-2"></div>
    </header>

    <main class="min-h-screen pt-[var(--em-header-offset)]">
        @yield('content')
    </main>

    <section class="relative border-t-[3px] border-[#f04a2a] bg-gradient-to-br from-[#5c1514] via-[#541311] to-[#4a1210] text-white" aria-label="Contact call to action">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#f8c4a8]/50 to-transparent"></div>
        <div class="em-container flex flex-col gap-4 py-5 sm:flex-row sm:items-center sm:justify-between sm:gap-8 sm:py-6">
            <h2 class="max-w-xl text-lg font-bold leading-snug text-white sm:text-xl">Ready to put your brand on Kenya&rsquo;s roads?</h2>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('quote') }}" class="em-btn-primary min-h-[44px] min-w-[9rem] justify-center" data-track-event="quote_started">Get a Quote</a>
                <a href="{{ route('smart-campaign-planner') }}" class="inline-flex min-h-[44px] min-w-[9rem] items-center justify-center rounded-md border border-white/55 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white backdrop-blur transition hover:border-[#f04a2a] hover:bg-white/20">Plan Campaign</a>
            </div>
        </div>
    </section>

    <footer data-site-footer class="relative mt-0 overflow-hidden bg-[#5c1514] text-[#fef8f3]">
        <div class="pointer-events-none absolute inset-x-0 top-0 h-px bg-gradient-to-r from-transparent via-[#f04a2a] to-transparent"></div>

        <div class="em-container py-8 md:py-9 lg:py-10">
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 xl:gap-10">
                <div class="sm:col-span-2 xl:col-span-1">
                    <div class="flex items-center gap-2.5">
                        <img src="{{ route('brand-asset.view', ['filename' => 'logo.jpg']) }}" alt="Effective Media logo" class="h-9 w-9 rounded-md border border-white/25 object-cover" width="36" height="36">
                        <span class="text-base font-bold tracking-wide text-white">Effective Media</span>
                    </div>
                    <p class="mt-3 max-w-xs text-xs leading-relaxed text-[#e8d4c4]/85">Outdoor advertising infrastructure across highways, CBDs and urban corridors in Kenya.</p>
                    <ul class="mt-4 space-y-1.5 text-xs font-medium text-white/95">
                        <li>
                            <button type="button" class="group inline-flex items-center gap-1.5 text-left transition hover:text-[#f04a2a]" data-open-download-modal>
                                <span class="text-[#d4a574]" aria-hidden="true">→</span> Download Company Profile
                            </button>
                        </li>
                        <li>
                            <a href="{{ route('quote') }}" class="group inline-flex items-center gap-1.5 transition hover:text-[#f04a2a]" data-track-event="quote_started">
                                <span class="text-[#d4a574]" aria-hidden="true">→</span> Request Quotation
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('portfolio') }}#coverage" class="group inline-flex items-center gap-1.5 transition hover:text-[#f04a2a]">
                                <span class="text-[#d4a574]" aria-hidden="true">→</span> Explore Coverage Map
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#d4a574]">Quick Links</h3>
                    <ul class="mt-3 space-y-1.5 text-sm text-[#e8d4c4]/95">
                        <li><a href="{{ route('home') }}" class="transition hover:text-white">Home</a></li>
                        <li><a href="{{ route('who-we-are') }}" class="transition hover:text-white">Who We Are</a></li>
                        <li><a href="{{ route('what-we-do') }}" class="transition hover:text-white">What We Do</a></li>
                        <li><a href="{{ route('portfolio') }}" class="transition hover:text-white">Portfolio</a></li>
                        <li><a href="{{ route('faqs') }}" class="transition hover:text-white">FAQs</a></li>
                        <li><a href="{{ route('contact') }}" class="transition hover:text-white">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#d4a574]">Coverage</h3>
                    <p class="mt-3 text-xs leading-relaxed text-[#e8d4c4]/80">Key markets include Nakuru, Nairobi, Kiambu, Eldoret, Kisumu, Naivasha and expanding corridors.</p>
                    <p class="mt-2 text-xs font-semibold text-white/90">7+ counties · 18+ towns · 730+ poles</p>
                </div>

                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#d4a574]">Services</h3>
                    <ul class="mt-3 space-y-1.5 text-sm text-[#e8d4c4]/95">
                        <li><a href="{{ route('what-we-do') }}#street-light-box" class="transition hover:text-white">Street Light Advertising</a></li>
                        <li><a href="{{ route('what-we-do') }}#billboards" class="transition hover:text-white">Billboards</a></li>
                        <li><a href="{{ route('what-we-do') }}#pavement-ads" class="transition hover:text-white">Pavement Branding</a></li>
                        <li><a href="{{ route('what-we-do') }}#activations" class="transition hover:text-white">Activations</a></li>
                        <li><a href="{{ route('what-we-do') }}#office-branding" class="transition hover:text-white">Office Branding</a></li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#d4a574]">Contact</h3>
                    <div class="mt-3 space-y-1.5 text-sm text-[#e8d4c4]/95">
                        @foreach (($profileContact['phones'] ?? []) as $phone)
                            @php
                                $digits = preg_replace('/\D+/', '', (string) $phone);
                                if (str_starts_with($digits, '0')) {
                                    $digits = '254'.substr($digits, 1);
                                } elseif ($digits !== '' && ! str_starts_with($digits, '254')) {
                                    $digits = '254'.$digits;
                                }
                                $phoneHref = $digits !== '' ? 'tel:+'.$digits : $telHref;
                            @endphp
                            <a href="{{ $phoneHref }}" class="block transition hover:text-white">{{ $phone }}</a>
                        @endforeach
                        <a href="mailto:{{ $profileContact['email'] ?? '' }}" class="block transition hover:text-white">{{ $profileContact['email'] ?? '' }}</a>
                        <a href="{{ route('contact') }}#location" class="block text-xs leading-snug text-[#e8d4c4]/75 transition hover:text-white">{{ $profileContact['office'] ?? 'Nakuru, Kenya' }}</a>
                    </div>
                    @if (! empty($socialLinks))
                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            @if (! empty($socialLinks['facebook']))
                                <a href="{{ $socialLinks['facebook'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-white/20 text-white transition hover:border-[#f04a2a] hover:bg-white/10" aria-label="Facebook">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M22 12a10 10 0 1 0-11.5 9.95v-7.05H7.9V12h2.6V9.8c0-2.57 1.55-4 3.9-4 1.13 0 2.32.2 2.32.2v2.55h-1.3c-1.29 0-1.7.8-1.7 1.62V12h2.9l-.46 2.9h-2.44v7.05A10 10 0 0 0 22 12Z"/></svg>
                                </a>
                            @endif
                            @if (! empty($socialLinks['instagram']))
                                <a href="{{ $socialLinks['instagram'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-white/20 text-white transition hover:border-[#f04a2a] hover:bg-white/10" aria-label="Instagram">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M8 3h8a5 5 0 0 1 5 5v8a5 5 0 0 1-5 5H8a5 5 0 0 1-5-5V8a5 5 0 0 1 5-5Zm0 2a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h8a3 3 0 0 0 3-3V8a3 3 0 0 0-3-3H8Zm4 2.75A4.25 4.25 0 1 1 8.75 12 4.25 4.25 0 0 1 12 7.75Zm0 2A2.25 2.25 0 1 0 14.25 12 2.25 2.25 0 0 0 12 9.75Zm5.5-2.65a1 1 0 1 1-1 1 1 1 0 0 1 1-1Z"/></svg>
                                </a>
                            @endif
                            @if (! empty($socialLinks['linkedin']))
                                <a href="{{ $socialLinks['linkedin'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-white/20 text-white transition hover:border-[#f04a2a] hover:bg-white/10" aria-label="LinkedIn">
                                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M4.98 3.5C4.98 4.88 3.86 6 2.5 6S0 4.88 0 3.5 1.12 1 2.5 1s2.48 1.12 2.48 2.5ZM.5 8.5h4V23h-4V8.5Zm7.5 0h3.8v2h.05c.53-1 1.82-2.05 3.75-2.05 4 0 4.74 2.63 4.74 6.05V23h-4.2v-8.4c0-2-.04-4.57-2.78-4.57-2.78 0-3.2 2.18-3.2 4.42V23H8V8.5Z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 py-2 text-center text-[11px] leading-tight text-[#d9c4b0]/85">
            &copy; {{ now()->year }} Effective Media. All rights reserved.
        </div>
    </footer>

    <div
        data-em-desktop-fab
        class="fixed right-4 z-40 hidden flex-col gap-2 transition-[bottom,opacity] duration-200 md:flex"
        style="bottom: 1.25rem;"
    >
        <a href="https://wa.me/254725646642?text=Hi%20Effective%20Media%2C%20I%20need%20a%20campaign%20quote." target="_blank" rel="noopener noreferrer" class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#25D366] text-white shadow-lg ring-1 ring-black/10 transition hover:brightness-95" data-track-event="whatsapp_clicked" aria-label="WhatsApp">
            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 0-8.94 14.5L2 22l5.63-1.47A10 10 0 1 0 12 2Zm0 18a8 8 0 0 1-4.09-1.12l-.29-.17-3.35.88.89-3.26-.19-.31A8 8 0 1 1 12 20Zm4.59-5.47c-.25-.12-1.47-.73-1.7-.81s-.39-.12-.56.12-.65.81-.8.98-.29.19-.54.06a10.78 10.78 0 0 1-3.17-1.95 11.87 11.87 0 0 1-2.2-2.73c-.23-.39.02-.6.17-.79s.39-.45.56-.68.06-.39-.02-.55-.56-1.36-.77-1.86-.39-.42-.56-.43h-.47a.9.9 0 0 0-.66.31c-.23.25-.86.84-.86 2.05s.88 2.38 1 2.55 1.7 2.6 4.11 3.65a14 14 0 0 0 1.9.79 4.6 4.6 0 0 0 2.12.13c.65-.09 2-.82 2.28-1.61s.28-1.48.19-1.62-.29-.2-.54-.32Z"/></svg>
        </a>
        <a href="{{ route('quote') }}" class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#8b1e1a] text-white shadow-lg ring-1 ring-black/10 transition hover:bg-[#f04a2a]" data-track-event="quote_started" aria-label="Request quote">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h4m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </a>
        <a href="{{ $telHref ?? 'tel:+254725646642' }}" class="inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#1f1f1f] text-white shadow-lg ring-1 ring-white/15 transition hover:bg-black/80" data-track-event="phone_clicked" aria-label="Call">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h1.28a2 2 0 011.89 1.34l1.1 3.29a2 2 0 01-.45 2.05l-1.3 1.3a16 16 0 006.59 6.59l1.32-1.32a2 2 0 012.05-.45l3.29 1.1A2 2 0 0121 18.72V20a2 2 0 01-2 2h-.25C9.07 21 3 14.93 3 6.25V6a2 2 0 012-2z"/></svg>
        </a>
    </div>

    <div class="fixed bottom-0 left-0 right-0 z-40 grid h-14 grid-cols-3 items-stretch border-t border-[#d9bca8] bg-white/95 shadow-[0_-4px_24px_rgba(0,0,0,0.08)] backdrop-blur supports-[backdrop-filter]:bg-white/90 lg:hidden" data-em-mobile-bar>
        <a href="https://wa.me/254725646642?text=Hi%20Effective%20Media%2C%20I%20am%20interested%20in%20outdoor%20advertising.%20Please%20share%20available%20sites%20and%20rates." target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center gap-0.5 text-[#5c1514] transition active:bg-[#f7eee7]" data-track-event="whatsapp_clicked">
            <svg class="h-6 w-6 text-[#128C7E]" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.94 14.5L2 22l5.63-1.47A10 10 0 1 0 12 2Zm0 18a8 8 0 0 1-4.09-1.12l-.29-.17-3.35.88.89-3.26-.19-.31A8 8 0 1 1 12 20Zm4.59-5.47c-.25-.12-1.47-.73-1.7-.81s-.39-.12-.56.12-.65.81-.8.98-.29.19-.54.06a10.78 10.78 0 0 1-3.17-1.95 11.87 11.87 0 0 1-2.2-2.73c-.23-.39.02-.6.17-.79s.39-.45.56-.68.06-.39-.02-.55-.56-1.36-.77-1.86-.39-.42-.56-.43h-.47a.9.9 0 0 0-.66.31c-.23.25-.86.84-.86 2.05s.88 2.38 1 2.55 1.7 2.6 4.11 3.65a14 14 0 0 0 1.9.79 4.6 4.6 0 0 0 2.12.13c.65-.09 2-.82 2.28-1.61s.28-1.48.19-1.62-.29-.2-.54-.32Z"/></svg>
            <span class="text-[10px] font-semibold uppercase tracking-wide">WhatsApp</span>
        </a>
        <a href="{{ route('quote') }}" class="flex flex-col items-center justify-center gap-0.5 bg-[#8b1e1a] text-white transition active:bg-[#7a1a17]" data-track-event="quote_started">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h4m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            <span class="text-[10px] font-semibold uppercase tracking-wide">Quote</span>
        </a>
        <a href="{{ $telHref ?? 'tel:+254725646642' }}" class="flex flex-col items-center justify-center gap-0.5 text-[#5c1514] transition active:bg-[#f7eee7]" data-track-event="phone_clicked">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h1.28a2 2 0 011.89 1.34l1.1 3.29a2 2 0 01-.45 2.05l-1.3 1.3a16 16 0 006.59 6.59l1.32-1.32a2 2 0 012.05-.45l3.29 1.1A2 2 0 0121 18.72V20a2 2 0 01-2 2h-.25C9.07 21 3 14.93 3 6.25V6a2 2 0 012-2z"/></svg>
            <span class="text-[10px] font-semibold uppercase tracking-wide">Call</span>
        </a>
    </div>

    <div class="fixed inset-0 z-[60] hidden items-center justify-center bg-black/50 p-4" data-download-modal>
        <div class="w-full max-w-md rounded-lg bg-white p-5">
            <div class="mb-3 flex items-center justify-between">
                <h3 class="text-lg font-bold text-[#5c1514]">Download Company Profile</h3>
                <button type="button" class="text-sm font-semibold text-[#8b1e1a]" data-close-download-modal>Close</button>
            </div>
            <form method="POST" action="{{ route('company-profile.capture-download') }}" class="grid gap-3" data-download-form>
                @csrf
                <input type="hidden" name="filename" value="" data-download-filename>
                <input type="text" name="full_name" required placeholder="Full name" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input type="text" name="company_name" placeholder="Company name" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input type="text" name="phone" required placeholder="Phone" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input type="email" name="email" required placeholder="Email" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <button class="em-btn-primary w-fit" type="submit" data-track-event="profile_download">Continue Download</button>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const siteHeader = document.querySelector('[data-site-header]');
            const topBar = document.querySelector('[data-top-contact-bar]');
            const mainNavbar = document.querySelector('[data-main-navbar]');
            const updateHeaderOffsets = () => {
                if (!siteHeader) return;
                const offset = Math.ceil(siteHeader.getBoundingClientRect().height);
                document.documentElement.style.setProperty('--em-header-offset', `${offset}px`);
            };
            const updateStickyState = () => {
                if (!siteHeader || !topBar || !mainNavbar) return;
                const isScrolled = window.scrollY > 18;
                siteHeader.classList.toggle('shadow-[0_14px_35px_-28px_rgba(10,10,10,0.7)]', isScrolled);
                topBar.classList.toggle('!-translate-y-full', isScrolled);
                topBar.classList.toggle('!opacity-0', isScrolled);
                topBar.classList.toggle('!pointer-events-none', isScrolled);
                topBar.classList.toggle('max-h-0', isScrolled);
                topBar.classList.toggle('max-h-[52px]', !isScrolled);
                mainNavbar.classList.toggle('bg-white', isScrolled);
                mainNavbar.classList.toggle('shadow-[0_10px_25px_-18px_rgba(0,0,0,0.45)]', isScrolled);
                updateHeaderOffsets();
            };

            const menuButton = document.querySelector('[data-mobile-menu-toggle]');
            const mobileMenu = document.querySelector('[data-mobile-menu]');
            if (menuButton && mobileMenu) {
                const closeMobileMenu = () => {
                    mobileMenu.classList.add('hidden');
                    menuButton.setAttribute('aria-expanded', 'false');
                    document.body.classList.remove('overflow-hidden');
                };
                menuButton.addEventListener('click', () => {
                    const isOpen = !mobileMenu.classList.contains('hidden');
                    mobileMenu.classList.toggle('hidden');
                    menuButton.setAttribute('aria-expanded', String(!isOpen));
                    document.body.classList.toggle('overflow-hidden', isOpen === false);
                });
                document.querySelectorAll('[data-mobile-menu] a').forEach((anchor) => {
                    anchor.addEventListener('click', closeMobileMenu);
                });
            }

            const mobileAccordions = Array.from(document.querySelectorAll('[data-mobile-accordion]'));
            mobileAccordions.forEach((accordion) => {
                accordion.addEventListener('toggle', () => {
                    if (!accordion.open) return;
                    mobileAccordions.forEach((other) => {
                        if (other !== accordion) other.open = false;
                    });
                });
            });

            const dropdowns = Array.from(document.querySelectorAll('[data-dropdown]'));
            const closeDropdown = (dropdown) => {
                dropdown.classList.remove('is-open');
                dropdown.querySelector('button')?.setAttribute('aria-expanded', 'false');
            };
            const openDropdown = (dropdown) => {
                dropdowns.forEach((item) => {
                    if (item !== dropdown) closeDropdown(item);
                });
                dropdown.classList.add('is-open');
                dropdown.querySelector('button')?.setAttribute('aria-expanded', 'true');
            };
            dropdowns.forEach((dropdown) => {
                const trigger = dropdown.querySelector('button');
                let closeTimeout = null;
                trigger?.addEventListener('click', (event) => {
                    event.preventDefault();
                    if (dropdown.classList.contains('is-open')) {
                        closeDropdown(dropdown);
                    } else {
                        openDropdown(dropdown);
                    }
                });
                dropdown.addEventListener('mouseenter', () => {
                    if (closeTimeout) window.clearTimeout(closeTimeout);
                    openDropdown(dropdown);
                });
                dropdown.addEventListener('mouseleave', () => {
                    closeTimeout = window.setTimeout(() => closeDropdown(dropdown), 180);
                });
                dropdown.addEventListener('focusin', () => openDropdown(dropdown));
                dropdown.addEventListener('focusout', () => {
                    closeTimeout = window.setTimeout(() => {
                        if (!dropdown.contains(document.activeElement)) closeDropdown(dropdown);
                    }, 150);
                });
            });
            document.addEventListener('click', (event) => {
                if (!(event.target instanceof Element)) return;
                if (!event.target.closest('[data-dropdown]')) {
                    dropdowns.forEach((dropdown) => closeDropdown(dropdown));
                }
            });

            const setActiveNavByHash = () => {
                const path = window.location.pathname;
                const hash = window.location.hash;
                const dropdownLinks = Array.from(document.querySelectorAll('.em-dropdown-link'));
                dropdownLinks.forEach((link) => link.classList.remove('em-nav-link-active'));
                if (!hash) return;
                dropdownLinks.forEach((link) => {
                    if (!(link instanceof HTMLAnchorElement)) return;
                    const url = new URL(link.href, window.location.origin);
                    const samePath = url.pathname === path;
                    const hashMatch = url.hash === hash;
                    if (samePath && hashMatch) {
                        link.classList.add('em-nav-link-active');
                        const parent = link.closest('[data-dropdown]');
                        parent?.querySelector('.em-nav-link')?.classList.add('em-nav-link-active');
                    }
                });
            };

            const modal = document.querySelector('[data-download-modal]');
            const openButtons = document.querySelectorAll('[data-open-download-modal]');
            const closeButton = document.querySelector('[data-close-download-modal]');
            if (modal) {
                openButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        modal.classList.remove('hidden');
                        modal.classList.add('flex');
                    });
                });
                closeButton?.addEventListener('click', () => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                });
                modal.addEventListener('click', (event) => {
                    if (event.target === modal) {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                });
            }

            // Speed up page transitions by prefetching likely next pages.
            const prefetched = new Set();
            const maxPrefetch = 12;
            let prefetchCount = 0;
            const sameOriginLinks = Array.from(document.querySelectorAll('a[href]'))
                .filter((anchor) => {
                    const href = anchor.getAttribute('href') || '';
                    if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:')) return false;
                    try {
                        const url = new URL(href, window.location.origin);
                        return url.origin === window.location.origin && url.pathname !== window.location.pathname;
                    } catch {
                        return false;
                    }
                });

            const prefetch = (href) => {
                if (prefetchCount >= maxPrefetch || prefetched.has(href)) return;
                prefetched.add(href);
                prefetchCount += 1;
                const link = document.createElement('link');
                link.rel = 'prefetch';
                link.as = 'document';
                link.href = href;
                document.head.appendChild(link);
            };

            sameOriginLinks.forEach((anchor) => {
                const href = anchor.href;
                const trigger = () => prefetch(href);
                anchor.addEventListener('mouseenter', trigger, { passive: true, once: true });
                anchor.addEventListener('touchstart', trigger, { passive: true, once: true });
                anchor.addEventListener('focus', trigger, { passive: true, once: true });
            });

            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach((entry) => {
                        if (!entry.isIntersecting) return;
                        const anchor = entry.target;
                        if (anchor instanceof HTMLAnchorElement) prefetch(anchor.href);
                        observer.unobserve(anchor);
                    });
                }, { rootMargin: '150px' });

                sameOriginLinks.slice(0, 20).forEach((anchor) => observer.observe(anchor));
            }

            const siteFooter = document.querySelector('[data-site-footer]');
            const desktopFab = document.querySelector('[data-em-desktop-fab]');
            const mobileQuickBar = document.querySelector('[data-em-mobile-bar]');
            const updateQuickActionsDock = () => {
                if (!siteFooter) return;
                const rect = siteFooter.getBoundingClientRect();
                const vh = window.innerHeight;
                let overlap = Math.max(0, vh - rect.top);
                overlap = Math.min(overlap, 200);
                const base = 20;
                if (desktopFab instanceof HTMLElement) {
                    desktopFab.style.bottom = `${base + overlap}px`;
                    desktopFab.style.opacity = overlap > 8 ? '0.92' : '1';
                }
                if (mobileQuickBar instanceof HTMLElement) {
                    mobileQuickBar.style.bottom = `${overlap}px`;
                }
            };

            updateStickyState();
            updateHeaderOffsets();
            setActiveNavByHash();
            updateQuickActionsDock();
            window.addEventListener('scroll', updateStickyState, { passive: true });
            window.addEventListener('scroll', updateQuickActionsDock, { passive: true });
            window.addEventListener('resize', updateHeaderOffsets);
            window.addEventListener('resize', updateQuickActionsDock);
            window.addEventListener('hashchange', setActiveNavByHash);
        });
    </script>
</body>
</html>
