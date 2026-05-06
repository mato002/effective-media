@php
    $route = request()->route()?->getName() ?? '';
    $isCms = str_starts_with($route, 'admin.cms');
    $isQuotes = str_starts_with($route, 'admin.quotes');
    $isDownloads = str_starts_with($route, 'admin.profile-downloads');
@endphp

<div class="flex h-full flex-col border-r border-white/10 bg-[#161212]/95 backdrop-blur-xl dark:border-white/5 dark:bg-[#0c0a0a]/98">
    <div class="border-b border-white/10 px-4 py-5 dark:border-white/5">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl outline-none ring-offset-2 ring-offset-[#161212] focus-visible:ring-2 focus-visible:ring-[#f04a2a]">
            <img src="{{ route('brand-asset.view', ['filename' => 'logo.jpg']) }}" alt="" class="h-11 w-11 rounded-xl border border-[#ecdac8]/25 object-cover shadow-lg">
            <div class="min-w-0">
                <p class="truncate text-sm font-black uppercase tracking-[0.14em] text-white">Effective Media</p>
                <p class="truncate text-[11px] font-semibold text-[#f7b396]">Operations Portal</p>
            </div>
        </a>
        <div class="mt-4 rounded-xl border border-white/10 bg-gradient-to-br from-white/10 to-transparent px-3 py-2.5">
            <p class="truncate text-xs font-semibold text-white">{{ auth()->user()?->name }}</p>
            <p class="truncate text-[10px] text-[#c9bfb7]">{{ auth()->user()?->roles?->pluck('name')->join(' · ') ?: 'Administrator' }}</p>
        </div>
    </div>

    <nav class="flex-1 space-y-4 overflow-y-auto px-3 py-4 pb-6">
        @can('admin.dashboard.view')
            <details class="admin-nav-group" open>
                <summary class="admin-nav-summary">Dashboard</summary>
                <div class="admin-nav-items">
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ $route === 'admin.dashboard' ? 'is-active' : '' }}">
                        <x-admin.nav-icon name="dashboard"/>
                        Command center
                    </a>
                </div>
            </details>
        @endcan

        @if ($isCms || auth()->user()?->can('cms.homepage.manage') || auth()->user()?->can('cms.services.manage') || auth()->user()?->can('cms.portfolio.manage') || auth()->user()?->can('cms.testimonials.manage') || auth()->user()?->can('cms.statistics.manage'))
            <details class="admin-nav-group" {{ $isCms ? 'open' : '' }}>
                <summary class="admin-nav-summary">Website CMS</summary>
                <div class="admin-nav-items">
                    @can('cms.homepage.manage')
                        <a href="{{ route('admin.cms.homepage.edit') }}" class="admin-nav-link {{ $route === 'admin.cms.homepage.edit' ? 'is-active' : '' }}">
                            <x-admin.nav-icon name="homepage"/>
                            Homepage
                        </a>
                    @endcan
                    @can('cms.services.manage')
                        <a href="{{ route('admin.cms.services.index') }}" class="admin-nav-link {{ str_starts_with($route, 'admin.cms.services') ? 'is-active' : '' }}">
                            <x-admin.nav-icon name="services"/>
                            Services
                        </a>
                    @endcan
                    @can('cms.portfolio.manage')
                        <a href="{{ route('admin.cms.portfolio.index') }}" class="admin-nav-link {{ str_starts_with($route, 'admin.cms.portfolio') ? 'is-active' : '' }}">
                            <x-admin.nav-icon name="portfolio"/>
                            Portfolio
                        </a>
                    @endcan
                    @can('cms.testimonials.manage')
                        <a href="{{ route('admin.cms.testimonials.index') }}" class="admin-nav-link {{ str_starts_with($route, 'admin.cms.testimonials') ? 'is-active' : '' }}">
                            <x-admin.nav-icon name="testimonials"/>
                            Testimonials
                        </a>
                    @endcan
                    @can('cms.statistics.manage')
                        <a href="{{ route('admin.cms.statistics.index') }}" class="admin-nav-link {{ str_starts_with($route, 'admin.cms.statistics') ? 'is-active' : '' }}">
                            <x-admin.nav-icon name="statistics"/>
                            Statistics
                        </a>
                    @endcan
                </div>
            </details>
        @endif

        @can('quotes.manage')
            <details class="admin-nav-group" {{ $isQuotes ? 'open' : '' }}>
                <summary class="admin-nav-summary">Campaign operations</summary>
                <div class="admin-nav-items">
                    <a href="{{ route('admin.quotes.index') }}" class="admin-nav-link {{ str_starts_with($route, 'admin.quotes') && $route !== 'admin.quotes.export' ? 'is-active' : '' }}">
                        <x-admin.nav-icon name="quotes"/>
                        Quote pipeline
                    </a>
                    <a href="{{ route('admin.quotes.export') }}" class="admin-nav-link {{ $route === 'admin.quotes.export' ? 'is-active' : '' }}">
                        <x-admin.nav-icon name="export"/>
                        Export quotes
                    </a>
                    @can('cms.portfolio.manage')
                        <a href="{{ route('admin.cms.portfolio.create') }}" class="admin-nav-link {{ $route === 'admin.cms.portfolio.create' ? 'is-active' : '' }}">
                            <x-admin.nav-icon name="portfolio"/>
                            Add campaign asset
                        </a>
                    @endcan
                </div>
            </details>
        @endcan

        @if (auth()->user()?->can('quotes.manage') || auth()->user()?->can('documents.manage'))
            <details class="admin-nav-group" {{ ($isQuotes || $isDownloads) ? 'open' : '' }}>
                <summary class="admin-nav-summary">Client & sales</summary>
                <div class="admin-nav-items">
                    @can('quotes.manage')
                        <a href="{{ route('admin.quotes.index') }}" class="admin-nav-link {{ str_starts_with($route, 'admin.quotes') && $route !== 'admin.quotes.export' ? 'is-active' : '' }}">
                            <x-admin.nav-icon name="clients"/>
                            Sales leads
                        </a>
                    @endcan
                    @can('documents.manage')
                        <a href="{{ route('admin.profile-downloads.index') }}" class="admin-nav-link {{ str_starts_with($route, 'admin.profile-downloads') && $route !== 'admin.profile-downloads.export' ? 'is-active' : '' }}">
                            <x-admin.nav-icon name="download"/>
                            Profile captures
                        </a>
                    @endcan
                </div>
            </details>

            @if (auth()->user()?->can('documents.manage') || auth()->user()?->can('quotes.manage'))
                <details class="admin-nav-group" {{ in_array($route, ['admin.profile-downloads.export', 'admin.quotes.export'], true) ? 'open' : '' }}>
                    <summary class="admin-nav-summary">Documents</summary>
                    <div class="admin-nav-items">
                        @can('documents.manage')
                            <a href="{{ route('admin.profile-downloads.export') }}" class="admin-nav-link {{ $route === 'admin.profile-downloads.export' ? 'is-active' : '' }}">
                                <x-admin.nav-icon name="export"/>
                                Export profile leads
                            </a>
                        @endcan
                        @can('quotes.manage')
                            <a href="{{ route('admin.quotes.export') }}" class="admin-nav-link {{ $route === 'admin.quotes.export' ? 'is-active' : '' }}">
                                <x-admin.nav-icon name="export"/>
                                Export quote leads
                            </a>
                        @endcan
                    </div>
                </details>
            @endif
        @endif

        <details class="admin-nav-group" {{ str_starts_with($route, 'profile.') ? 'open' : '' }}>
            <summary class="admin-nav-summary">Settings</summary>
            <div class="admin-nav-items">
                <a href="{{ route('profile.edit') }}" class="admin-nav-link {{ str_starts_with($route, 'profile.') ? 'is-active' : '' }}">
                    <x-admin.nav-icon name="settings"/>
                    Profile & password
                </a>
                <a href="{{ route('home') }}" class="admin-nav-link" target="_blank" rel="noopener noreferrer">
                    <x-admin.nav-icon name="globe"/>
                    Public website
                </a>
            </div>
        </details>
    </nav>

    <div class="border-t border-white/10 p-4 text-[10px] leading-relaxed text-[#92857c] dark:border-white/5">
        Internal operations · Authorized users only.
    </div>
</div>
