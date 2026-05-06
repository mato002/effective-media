<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-dns-prefetch-control" content="on">
    <link rel="dns-prefetch" href="//tile.openstreetmap.org">
    <title>@yield('title', ($portalWebsite['meta_title'] ?? '') !== '' ? $portalWebsite['meta_title'] : ($portalBrandName ?? 'Effective Media'))</title>
    <meta name="description" content="@yield('meta_description', $portalMetaDescription !== '' ? $portalMetaDescription : 'Modern outdoor advertising and branding infrastructure for Kenya and East Africa.')">
    @if ($portalMetaKeywords !== '')
        <meta name="keywords" content="{{ $portalMetaKeywords }}">
    @endif
    @if ($portalOgImage !== '')
        <meta property="og:image" content="{{ $portalOgImage }}">
    @endif
    @if (! empty($portalFaviconHref))
        <link rel="icon" href="{{ $portalFaviconHref }}">
    @endif
    @if (! empty($portalWebsite['analytics_ga4_id'] ?? ''))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $portalWebsite['analytics_ga4_id'] }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', @json($portalWebsite['analytics_ga4_id']));
        </script>
    @endif
    @if (! empty($portalWebsite['analytics_gtm_id'] ?? ''))
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','{{ $portalWebsite['analytics_gtm_id'] }}');</script>
    @endif
    @if ($portalMetaPixelId !== '')
        <script>!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,document,'script','https://connect.facebook.net/en_US/fbevents.js');fbq('init','{{ $portalMetaPixelId }}');fbq('track','PageView');</script>
        <noscript><img height="1" width="1" alt="" src="https://www.facebook.com/tr?id={{ $portalMetaPixelId }}&ev=PageView&noscript=1" /></noscript>
    @endif
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php($emStickyNav = (bool) ($portalWebsite['sticky_navbar'] ?? true))
@php($emFabOn = (bool) ($portalWebsite['floating_action_buttons'] ?? true))
<body class="antialiased {{ $emFabOn ? 'pb-14 lg:pb-0' : '' }}">
    <div id="em-nav-progress" class="pointer-events-none fixed left-0 top-0 z-[100] h-[2px] w-0 bg-gradient-to-r from-[#5c1514] via-[#f04a2a] to-[#8b1e1a] shadow-sm transition-[width] duration-200 ease-out" aria-hidden="true"></div>
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
        body.em-nav-loading #em-nav-progress {
            width: 88%;
        }
        body.em-nav-done #em-nav-progress {
            width: 100%;
            opacity: 0;
            transition: width 0.25s ease-out, opacity 0.35s ease 0.1s;
        }
    </style>
    <header class="{{ $emStickyNav ? 'fixed' : 'relative' }} inset-x-0 top-0 z-50" data-site-header>
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
                <a href="{{ $whatsappHrefQuote }}" target="_blank" rel="noopener noreferrer" class="hidden rounded-md border border-white/30 px-3 py-1 text-[11px] font-semibold uppercase tracking-wide text-white sm:inline-flex">WhatsApp Sales</a>
            </div>
        </div>
        <div class="border-b border-[#ecdac8] bg-white/95 backdrop-blur transition-all duration-300" data-main-navbar>
            <div class="em-container flex items-center justify-between py-3 transition-[padding] duration-300 lg:py-4" data-navbar-row>
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ $brandLogoSrc }}" alt="{{ $portalBrandName }} logo" data-site-logo class="h-12 w-12 rounded-md border border-[#e7d9cb] object-cover transition-[width,height] duration-300">
                    <span class="text-base font-bold tracking-wide text-[#5c1514] transition-[font-size] duration-300 sm:text-lg" data-site-wordmark>{{ $portalBrandName }}</span>
                </a>

                <nav class="hidden items-center gap-5 xl:gap-6 lg:flex" data-desktop-nav>
                    <a href="{{ route('home') }}" class="em-nav-link {{ request()->routeIs('home') ? 'em-nav-link-active' : '' }}">Home</a>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('who-we-are') ? 'em-nav-link-active' : '' }}" aria-expanded="false" aria-haspopup="true">
                            Who We Are
                            <span aria-hidden="true" class="text-[10px] opacity-70">▾</span>
                        </button>
                        <div class="em-dropdown-menu em-mega-dropdown" role="menu">
                            <div class="grid gap-4 p-4 sm:grid-cols-2">
                                <div class="space-y-1">
                                    <p class="em-mega-heading">Company</p>
                                    <a href="{{ route('who-we-are') }}#overview" class="em-dropdown-link" role="menuitem">Company Overview</a>
                                    <a href="{{ route('who-we-are') }}#mission-vision" class="em-dropdown-link" role="menuitem">Mission &amp; Vision</a>
                                    <a href="{{ route('who-we-are') }}#coverage" class="em-dropdown-link" role="menuitem">Coverage Network</a>
                                </div>
                                <div class="space-y-1">
                                    <p class="em-mega-heading">Trust</p>
                                    <a href="{{ route('who-we-are') }}#why-effective-media" class="em-dropdown-link" role="menuitem">Why Effective Media</a>
                                    <a href="{{ route('who-we-are') }}#leadership-operations" class="em-dropdown-link" role="menuitem">Leadership / Operations</a>
                                    <a href="{{ route('home') }}#coverage-map" class="em-dropdown-link" role="menuitem">Live Coverage Map</a>
                                    <button type="button" class="em-dropdown-link w-full text-left" data-open-download-modal role="menuitem">Download Company Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('what-we-do') ? 'em-nav-link-active' : '' }}" aria-expanded="false" aria-haspopup="true">
                            What We Do
                            <span aria-hidden="true" class="text-[10px] opacity-70">▾</span>
                        </button>
                        <div class="em-dropdown-menu em-mega-dropdown" role="menu">
                            <div class="grid gap-3 p-4 sm:grid-cols-2">
                                <a href="{{ route('what-we-do') }}#street-light-box" class="em-dropdown-link" role="menuitem">Street Light Advertising</a>
                                <a href="{{ route('what-we-do') }}#billboards" class="em-dropdown-link" role="menuitem">Billboard Campaigns</a>
                                <a href="{{ route('what-we-do') }}#pavement-ads" class="em-dropdown-link" role="menuitem">Pavement Branding</a>
                                <a href="{{ route('what-we-do') }}#office-branding" class="em-dropdown-link" role="menuitem">Office Branding</a>
                                <a href="{{ route('what-we-do') }}#activations" class="em-dropdown-link" role="menuitem">Activations &amp; Roadshows</a>
                                <a href="{{ route('smart-campaign-planner') }}" class="em-dropdown-link" role="menuitem">Campaign Planning</a>
                            </div>
                        </div>
                    </div>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('portfolio') ? 'em-nav-link-active' : '' }}" aria-expanded="false" aria-haspopup="true">
                            Portfolio
                            <span aria-hidden="true" class="text-[10px] opacity-70">▾</span>
                        </button>
                        <div class="em-dropdown-menu em-mega-dropdown" role="menu">
                            <div class="grid gap-3 p-4 sm:grid-cols-2">
                                <a href="{{ route('portfolio') }}#gallery" class="em-dropdown-link" role="menuitem">Campaign Gallery</a>
                                <a href="{{ route('portfolio') }}#coverage" class="em-dropdown-link" role="menuitem">Coverage Locations</a>
                                <a href="{{ route('portfolio') }}#coverage" class="em-dropdown-link" role="menuitem">County Reach</a>
                                <a href="{{ route('portfolio') }}#gallery" class="em-dropdown-link" role="menuitem">Case Studies</a>
                                <a href="{{ route('portfolio', ['filter' => 'activations']) }}#gallery" class="em-dropdown-link" role="menuitem">Brand Activations</a>
                                <a href="{{ route('what-we-do') }}#street-light-box" class="em-dropdown-link" role="menuitem">Media Formats</a>
                            </div>
                        </div>
                    </div>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('smart-campaign-planner') ? 'em-nav-link-active' : '' }}" aria-expanded="false" aria-haspopup="true">
                            Smart Campaign Planner
                            <span aria-hidden="true" class="text-[10px] opacity-70">▾</span>
                        </button>
                        <div class="em-dropdown-menu em-mega-dropdown" role="menu">
                            <div class="grid gap-3 p-4 sm:grid-cols-2">
                                <a href="{{ route('smart-campaign-planner') }}#location" class="em-dropdown-link" role="menuitem">Plan By County</a>
                                <a href="{{ route('smart-campaign-planner') }}#calculator" class="em-dropdown-link" role="menuitem">Plan By Budget</a>
                                <a href="{{ route('smart-campaign-planner') }}#calculator" class="em-dropdown-link" role="menuitem">Visibility Calculator</a>
                                <a href="{{ route('smart-campaign-planner') }}#calculator" class="em-dropdown-link" role="menuitem">Campaign Duration</a>
                                <a href="{{ route('smart-campaign-planner') }}#recommendation" class="em-dropdown-link" role="menuitem">Reach Estimator</a>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('faqs') }}" class="em-nav-link {{ request()->routeIs('faqs') ? 'em-nav-link-active' : '' }}">FAQs</a>
                    <div class="relative" data-dropdown>
                        <button type="button" class="em-nav-link inline-flex items-center gap-1 {{ request()->routeIs('contact-us') || request()->routeIs('contact') ? 'em-nav-link-active' : '' }}" aria-expanded="false" aria-haspopup="true">
                            Contact Us
                            <span aria-hidden="true" class="text-[10px] opacity-70">▾</span>
                        </button>
                        <div class="em-dropdown-menu em-mega-dropdown" role="menu">
                            <div class="grid gap-3 p-4 sm:grid-cols-2">
                                <a href="{{ route('quote') }}" class="em-dropdown-link" role="menuitem">Request Quote</a>
                                <a href="{{ $whatsappHrefQuote }}" target="_blank" rel="noopener noreferrer" class="em-dropdown-link" role="menuitem">WhatsApp</a>
                                <a href="{{ route('contact') }}#location" class="em-dropdown-link" role="menuitem">Office Locations</a>
                                <a href="{{ route('contact') }}#details" class="em-dropdown-link" role="menuitem">Email Contacts</a>
                                <a href="{{ route('contact') }}#form" class="em-dropdown-link" role="menuitem">Send enquiry</a>
                            </div>
                        </div>
                    </div>
                </nav>

                <div class="flex items-center gap-2">
                    <a href="{{ route('quote') }}" class="em-btn-primary hidden lg:inline-flex" data-track-event="quote_started">Get a Quote</a>
                    <a href="{{ route('quote') }}" class="rounded-md bg-[#8b1e1a] px-3 py-2 text-xs font-semibold text-white lg:hidden" data-track-event="quote_started">Quote</a>
                    <button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-md border border-[#d8bba6] text-[#5c1514] transition hover:bg-[#f7eee7] lg:hidden" data-mobile-menu-toggle aria-expanded="false" aria-controls="em-mobile-drawer">
                        <span class="sr-only">Open menu</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
                    </button>
                </div>
            </div>
        </div>
        <div class="em-pattern h-2"></div>
    </header>

    <div id="em-mobile-drawer" class="em-mobile-drawer" hidden data-mobile-drawer>
        <button type="button" class="absolute inset-0 bg-black/45 backdrop-blur-[1px]" data-mobile-drawer-backdrop aria-label="Close menu"></button>
        <div class="em-mobile-drawer-panel" data-mobile-drawer-panel>
            <div class="flex items-center justify-between border-b border-[#ecdac8] px-4 py-3">
                <span class="text-sm font-black uppercase tracking-wide text-[#5c1514]">Menu</span>
                <button type="button" class="rounded-md border border-[#d8bba6] px-2 py-1 text-xs font-semibold text-[#5c1514]" data-mobile-menu-close>Close</button>
            </div>
            <nav class="flex-1 overflow-y-auto px-3 py-4 text-sm font-semibold text-[#3b2525]" aria-label="Mobile">
                <div class="space-y-1.5">
                    <a href="{{ route('home') }}" class="block min-h-[44px] rounded-lg px-3 py-2.5 hover:bg-[#f7eee7]">Home</a>
                    <details class="rounded-lg border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="min-h-[44px] cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">Who We Are</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 font-medium">
                            <a href="{{ route('who-we-are') }}#overview" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Company Overview</a>
                            <a href="{{ route('who-we-are') }}#mission-vision" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Mission &amp; Vision</a>
                            <a href="{{ route('who-we-are') }}#coverage" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Coverage Network</a>
                            <a href="{{ route('who-we-are') }}#why-effective-media" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Why Effective Media</a>
                            <a href="{{ route('who-we-are') }}#leadership-operations" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Leadership / Operations</a>
                            <a href="{{ route('home') }}#coverage-map" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Live Coverage Map</a>
                            <button type="button" class="w-full min-h-[40px] rounded-md px-2 py-2 text-left hover:bg-[#f7eee7]" data-open-download-modal>Download Company Profile</button>
                        </div>
                    </details>
                    <details class="rounded-lg border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="min-h-[44px] cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">What We Do</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 font-medium">
                            <a href="{{ route('what-we-do') }}#street-light-box" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Street Light Advertising</a>
                            <a href="{{ route('what-we-do') }}#billboards" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Billboard Campaigns</a>
                            <a href="{{ route('what-we-do') }}#pavement-ads" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Pavement Branding</a>
                            <a href="{{ route('what-we-do') }}#office-branding" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Office Branding</a>
                            <a href="{{ route('what-we-do') }}#activations" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Activations &amp; Roadshows</a>
                            <a href="{{ route('smart-campaign-planner') }}" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Campaign Planning</a>
                        </div>
                    </details>
                    <details class="rounded-lg border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="min-h-[44px] cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">Portfolio</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 font-medium">
                            <a href="{{ route('portfolio') }}#gallery" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Campaign Gallery</a>
                            <a href="{{ route('portfolio') }}#coverage" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Coverage Locations</a>
                            <a href="{{ route('portfolio', ['filter' => 'activations']) }}#gallery" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Brand Activations</a>
                            <a href="{{ route('what-we-do') }}#street-light-box" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Media Formats</a>
                        </div>
                    </details>
                    <details class="rounded-lg border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="min-h-[44px] cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">Smart Campaign Planner</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 font-medium">
                            <a href="{{ route('smart-campaign-planner') }}#location" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Plan By County</a>
                            <a href="{{ route('smart-campaign-planner') }}#calculator" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Plan By Budget</a>
                            <a href="{{ route('smart-campaign-planner') }}#calculator" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Visibility Calculator</a>
                            <a href="{{ route('smart-campaign-planner') }}#recommendation" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Reach Estimator</a>
                        </div>
                    </details>
                    <a href="{{ route('faqs') }}" class="block min-h-[44px] rounded-lg px-3 py-2.5 hover:bg-[#f7eee7]">FAQs</a>
                    <details class="rounded-lg border border-[#ecdac8]" data-mobile-accordion>
                        <summary class="min-h-[44px] cursor-pointer list-none px-3 py-2.5 text-[#5c1514]">Contact Us</summary>
                        <div class="grid gap-1 border-t border-[#ecdac8] p-2 font-medium">
                            <a href="{{ route('quote') }}" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Request Quote</a>
                            <a href="{{ $whatsappHrefQuote }}" target="_blank" rel="noopener noreferrer" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">WhatsApp</a>
                            <a href="{{ route('contact') }}#location" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Office Locations</a>
                            <a href="{{ route('contact') }}#details" class="min-h-[40px] rounded-md px-2 py-2 hover:bg-[#f7eee7]">Email Contacts</a>
                        </div>
                    </details>
                    <a href="{{ route('quote') }}" class="mt-2 flex min-h-[48px] items-center justify-center rounded-xl bg-[#8b1e1a] px-4 py-3 text-sm font-bold text-white" data-track-event="quote_started">Get a Quote</a>
                </div>
            </nav>
        </div>
    </div>

    <main class="min-h-screen {{ $emStickyNav ? 'pt-[var(--em-header-offset)]' : '' }}">
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
                        <img src="{{ $brandLogoSrc }}" alt="{{ $portalBrandName }} logo" class="h-9 w-9 rounded-md border border-white/25 object-cover" width="36" height="36">
                        <span class="text-base font-bold tracking-wide text-white">{{ $portalBrandName }}</span>
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
                            <a
                                href="{{ (function () use ($phone, $telHref) {
                                    $digits = preg_replace('/\D+/', '', (string) $phone);
                                    if (str_starts_with($digits, '0')) {
                                        $digits = '254'.substr($digits, 1);
                                    } elseif ($digits !== '' && ! str_starts_with($digits, '254')) {
                                        $digits = '254'.$digits;
                                    }

                                    return $digits !== '' ? 'tel:+'.$digits : ($telHref ?? 'tel:+254725646642');
                                })() }}"
                                class="block transition hover:text-white"
                            >{{ $phone }}</a>
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

        <div class="border-t border-white/15 bg-[linear-gradient(90deg,#4a1614,#351210)]">
            <div class="em-container grid gap-8 py-10 lg:grid-cols-3 lg:items-start">
                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#d4a574]">Coverage snapshot</h3>
                    <p class="mt-3 text-sm text-[#ead5c8]/90">Nationwide commuter corridors · {{ $portalBrandName }}</p>
                    <a href="{{ route('home') }}#coverage-map" class="mt-4 inline-flex text-sm font-semibold text-[#f7cba8] underline-offset-4 transition hover:text-white hover:underline">Open live coverage map</a>
                </div>
                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#d4a574]">Office &amp; hours</h3>
                    <p class="mt-3 text-sm leading-relaxed text-[#ead5c8]/90">{{ $profileContact['office'] ?? 'Nakuru, Kenya' }}</p>
                    <p class="mt-2 text-xs text-[#d9c4b0]/80">Mon–Fri · 8:30am – 5:30pm (EAT)</p>
                    <a href="https://www.openstreetmap.org/search?query={{ urlencode($profileContact['office'] ?? 'Nakuru Kenya') }}" target="_blank" rel="noopener noreferrer" class="mt-3 inline-flex text-sm font-semibold text-[#f7cba8] underline-offset-4 transition hover:text-white hover:underline">Mini map preview (OpenStreetMap)</a>
                </div>
                <div>
                    <h3 class="text-[11px] font-semibold uppercase tracking-[0.22em] text-[#d4a574]">Stay briefed</h3>
                    <p class="mt-3 text-sm text-[#ead5c8]/90">Newsletter and media intelligence requests route through our contact desk.</p>
                    <a href="{{ route('contact') }}#form" class="mt-4 inline-flex min-h-[44px] items-center justify-center rounded-lg bg-[#f04a2a] px-5 py-2.5 text-sm font-bold text-white transition hover:bg-[#ff6f4d]">Request newsletter / updates</a>
                </div>
            </div>
        </div>

        <div class="border-t border-white/10 px-4 py-3 text-center text-[11px] text-[#d9c4b0]/90 sm:flex sm:items-center sm:justify-center sm:gap-4">
            <span>&copy; {{ now()->year }} Effective Media. All rights reserved.</span>
            <span class="hidden sm:inline" aria-hidden="true">·</span>
            <a href="{{ route('contact') }}#location" class="transition hover:text-white">Legal &amp; privacy</a>
        </div>
    </footer>

    @if ($emFabOn)
    <div
        data-em-desktop-fab
        class="fixed right-3 z-40 hidden flex-col gap-1.5 transition-[bottom,opacity] duration-200 md:flex lg:right-6"
        style="bottom: 1.75rem;"
    >
        <a href="{{ $whatsappHrefQuote }}" target="_blank" rel="noopener noreferrer" title="WhatsApp sales" class="fab-nudge inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#25D366] text-white shadow-md ring-1 ring-black/10 transition hover:-translate-y-0.5 hover:shadow-lg hover:brightness-105" data-track-event="whatsapp_clicked" aria-label="WhatsApp">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 0-8.94 14.5L2 22l5.63-1.47A10 10 0 1 0 12 2Zm0 18a8 8 0 0 1-4.09-1.12l-.29-.17-3.35.88.89-3.26-.19-.31A8 8 0 1 1 12 20Zm4.59-5.47c-.25-.12-1.47-.73-1.7-.81s-.39-.12-.56.12-.65.81-.8.98-.29.19-.54.06a10.78 10.78 0 0 1-3.17-1.95 11.87 11.87 0 0 1-2.2-2.73c-.23-.39.02-.6.17-.79s.39-.45.56-.68.06-.39-.02-.55-.56-1.36-.77-1.86-.39-.42-.56-.43h-.47a.9.9 0 0 0-.66.31c-.23.25-.86.84-.86 2.05s.88 2.38 1 2.55 1.7 2.6 4.11 3.65a14 14 0 0 0 1.9.79 4.6 4.6 0 0 0 2.12.13c.65-.09 2-.82 2.28-1.61s.28-1.48.19-1.62-.29-.2-.54-.32Z"/></svg>
        </a>
        <a href="{{ route('quote') }}" title="Request a quote" class="fab-nudge inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#8b1e1a] text-white shadow-md ring-1 ring-black/10 transition hover:-translate-y-0.5 hover:bg-[#f04a2a] hover:shadow-[0_0_20px_rgba(240,74,42,0.45)]" data-track-event="quote_started" aria-label="Request quote">
            <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h4m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </a>
        <a href="{{ $telHref ?? 'tel:+254725646642' }}" title="Call sales" class="fab-nudge inline-flex h-10 w-10 items-center justify-center rounded-full bg-[#1f1f1f] text-white shadow-md ring-1 ring-white/15 transition hover:-translate-y-0.5 hover:bg-black/80 hover:shadow-lg" data-track-event="phone_clicked" aria-label="Call">
            <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h1.28a2 2 0 011.89 1.34l1.1 3.29a2 2 0 01-.45 2.05l-1.3 1.3a16 16 0 006.59 6.59l1.32-1.32a2 2 0 012.05-.45l3.29 1.1A2 2 0 0121 18.72V20a2 2 0 01-2 2h-.25C9.07 21 3 14.93 3 6.25V6a2 2 0 012-2z"/></svg>
        </a>
    </div>

    <div class="fixed bottom-0 left-0 right-0 z-40 grid h-14 grid-cols-3 items-stretch border-t border-[#d9bca8] bg-white/95 shadow-[0_-4px_24px_rgba(0,0,0,0.08)] backdrop-blur supports-[backdrop-filter]:bg-white/90 lg:hidden" data-em-mobile-bar>
        <a href="{{ $whatsappHrefExplore }}" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center justify-center gap-0.5 text-[#5c1514] transition active:bg-[#f7eee7]" data-track-event="whatsapp_clicked">
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
    @endif

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
            window.addEventListener('pageshow', () => {
                document.body.classList.remove('em-nav-loading', 'em-nav-done');
            });

            let lastSameLinkNavAt = { href: '', t: 0 };
            document.addEventListener(
                'click',
                (event) => {
                    const anchor = event.target.closest('a[href]');
                    if (
                        !(anchor instanceof HTMLAnchorElement)
                        || event.defaultPrevented
                        || event.metaKey
                        || event.ctrlKey
                        || event.shiftKey
                        || event.altKey
                        || anchor.target === '_blank'
                        || anchor.hasAttribute('download')
                    ) {
                        return;
                    }

                    let hrefAttr = anchor.getAttribute('href') || '';
                    if (
                        hrefAttr === ''
                        || hrefAttr.startsWith('#')
                        || hrefAttr.startsWith('javascript:')
                        || hrefAttr.startsWith('mailto:')
                        || hrefAttr.startsWith('tel:')
                    ) {
                        return;
                    }

                    let docUrl = null;

                    try {
                        docUrl = new URL(hrefAttr, window.location.href);
                    } catch {
                        return;
                    }

                    if (docUrl.origin !== window.location.origin) return;
                    const sameExact =
                        docUrl.pathname === window.location.pathname && docUrl.search === window.location.search;
                    if (sameExact && docUrl.hash) return;

                    const nowMs = typeof performance !== 'undefined' ? performance.now() : Date.now();

                    if (
                        docUrl.pathname + docUrl.search === window.location.pathname + window.location.search
                        && lastSameLinkNavAt.href === docUrl.href
                        && nowMs - lastSameLinkNavAt.t < 400
                    ) {
                        event.preventDefault();

                        return;
                    }

                    lastSameLinkNavAt = { href: docUrl.href, t: nowMs };

                    document.body.classList.remove('em-nav-done');
                    document.body.classList.add('em-nav-loading');
                    window.setTimeout(() => {
                        if (!document.body.classList.contains('em-nav-loading')) return;
                        document.body.classList.replace('em-nav-loading', 'em-nav-done');
                    }, 8000);
                },
                true,
            );

            const siteHeader = document.querySelector('[data-site-header]');
            const topBar = document.querySelector('[data-top-contact-bar]');
            const mainNavbar = document.querySelector('[data-main-navbar]');
            const updateHeaderOffsets = () => {
                if (!siteHeader) return;
                const offset = Math.ceil(siteHeader.getBoundingClientRect().height);
                document.documentElement.style.setProperty('--em-header-offset', `${offset}px`);
            };
            const navRow = document.querySelector('[data-navbar-row]');
            const logo = document.querySelector('[data-site-logo]');

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
                mainNavbar.classList.toggle('is-compact-nav', isScrolled);
                mainNavbar.classList.toggle('shadow-[0_18px_40px_-26px_rgba(25,13,13,0.28)]', isScrolled);

                navRow?.classList.toggle('py-2', isScrolled);
                navRow?.classList.toggle('lg:py-3', isScrolled);
                navRow?.classList.toggle('py-3', !isScrolled);
                navRow?.classList.toggle('lg:py-4', !isScrolled);

                logo?.classList.toggle('h-12', !isScrolled);
                logo?.classList.toggle('w-12', !isScrolled);
                logo?.classList.toggle('h-10', isScrolled);
                logo?.classList.toggle('w-10', isScrolled);

                updateHeaderOffsets();
            };

            const menuButton = document.querySelector('[data-mobile-menu-toggle]');
            const mobileDrawer = document.querySelector('[data-mobile-drawer]');
            const mobileBackdrop = document.querySelector('[data-mobile-drawer-backdrop]');
            const mobileCloseBtns = document.querySelectorAll('[data-mobile-menu-close]');

            const closeMobileDrawer = () => {
                if (!mobileDrawer) return;
                mobileDrawer.classList.remove('is-open');
                menuButton?.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('overflow-hidden');
                window.setTimeout(() => {
                    if (!mobileDrawer.classList.contains('is-open')) mobileDrawer.setAttribute('hidden', '');
                }, 280);
            };

            const openMobileDrawer = () => {
                if (!mobileDrawer) return;
                mobileDrawer.removeAttribute('hidden');
                menuButton?.setAttribute('aria-expanded', 'true');
                document.body.classList.add('overflow-hidden');
                window.requestAnimationFrame(() => mobileDrawer.classList.add('is-open'));
            };

            if (menuButton && mobileDrawer) {
                menuButton.addEventListener('click', () => {
                    const isOpen = mobileDrawer.classList.contains('is-open');
                    if (isOpen) closeMobileDrawer();
                    else openMobileDrawer();
                });
                mobileBackdrop?.addEventListener('click', closeMobileDrawer);
                mobileCloseBtns.forEach((btn) => btn.addEventListener('click', closeMobileDrawer));
                mobileDrawer.querySelectorAll('a').forEach((anchor) => {
                    anchor.addEventListener('click', closeMobileDrawer);
                });
                mobileDrawer.querySelectorAll('button[data-open-download-modal]').forEach((btn) => {
                    btn.addEventListener('click', closeMobileDrawer);
                });
                document.addEventListener('keydown', (event) => {
                    if (event.key === 'Escape') closeMobileDrawer();
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

            // Lightweight prefetch — avoid competing with the active navigation on slow networks.
            const prefetched = new Set();
            const maxPrefetch = 6;
            let prefetchCount = 0;

            let saveDataPreferred = false;
            let connMedium = '';

            try {
                const nc = navigator.connection;
                saveDataPreferred = Boolean(nc?.saveData);
                connMedium = nc?.effectiveType ? String(nc.effectiveType) : '';
            } catch {
                saveDataPreferred = false;
            }

            const shouldSkipPrefetch =
                saveDataPreferred || connMedium === 'slow-2g' || connMedium === '2g';

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
                if (shouldSkipPrefetch || prefetchCount >= maxPrefetch || prefetched.has(href)) return;
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

            const siteFooter = document.querySelector('[data-site-footer]');
            const desktopFab = document.querySelector('[data-em-desktop-fab]');
            const mobileQuickBar = document.querySelector('[data-em-mobile-bar]');
            const updateQuickActionsDock = () => {
                if (!siteFooter) return;
                const rect = siteFooter.getBoundingClientRect();
                const vh = window.innerHeight;
                let overlap = Math.max(0, vh - rect.top);
                overlap = Math.min(overlap, 200);
                const base = 28;
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
