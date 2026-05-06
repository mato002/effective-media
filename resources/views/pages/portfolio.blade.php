@extends('layouts.website')

@section('title', 'Portfolio | Effective Media')

@section('content')
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    >
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.css"
    >
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet.markercluster@1.5.3/dist/MarkerCluster.Default.css"
    >
    @php
        $reachRows = collect($profileContent['reach'] ?? []);
        $mapPoints = collect($profileContent['coverage_map_points'] ?? []);
        $countiesCovered = $reachRows->pluck('county')->unique()->count();
        $totalPoles = $reachRows->sum('poles');
        $keyTowns = $mapPoints->count();
        $countyGroups = $reachRows->groupBy('county');
        $firstCounty = $countyGroups->keys()->first();
    @endphp

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1449824913935-59a10b8d2000?auto=format&fit=crop&w=2000&q=80');"></div>
        <div class="absolute inset-0 bg-[linear-gradient(115deg,rgba(92,21,20,0.9),rgba(92,21,20,0.75),rgba(23,23,23,0.66))]"></div>
        <div class="em-container relative py-16 lg:py-20">
            <x-ui.section-heading label="Portfolio" title="Campaign Execution Gallery" description="Real campaign placements across street lights, billboards, office branding, pavement media, and activations." light="true" />
            <div class="mt-6 flex flex-wrap gap-3" data-portfolio-filters>
                @foreach (['All', 'Street Light Ads', 'Billboards', 'Office Branding', 'Pavement Ads', 'Activations'] as $filter)
                    <button type="button" class="rounded-full border border-white/35 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-wide text-white transition hover:bg-white/20" data-filter="{{ $filter }}">{{ $filter }}</button>
                @endforeach
            </div>
        </div>
    </section>

    <section id="coverage" class="em-pattern py-16">
        <div class="em-container">
            <x-ui.section-heading
                label="Reach / Coverage"
                title="Explore Our Media Coverage"
                description="Strategic street light, pavement and billboard locations across key towns and high-traffic corridors."
            />
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <x-ui.stats-card label="Counties Covered" :value="$countiesCovered" suffix="+" />
                <x-ui.stats-card label="Total Poles" :value="$totalPoles" suffix="+" />
                <x-ui.stats-card label="Key Towns" :value="$keyTowns" suffix="+" />
                <x-ui.stats-card label="Main Media Type" value="Street Light Ads" />
            </div>

            <div class="mt-8 grid gap-6 lg:grid-cols-[1.25fr,0.75fr]">
                <div class="em-card em-card-accent p-4 sm:p-5">
                    <div id="coverage-map" class="h-[420px] w-full rounded-lg border border-[#e2cdb9]"></div>
                </div>
                <div class="em-card em-card-accent p-5" id="coverage-insight-panel">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">County Insight</p>
                    <h3 class="mt-2 text-2xl font-bold text-[#171717]" data-county-name>{{ $firstCounty ?? 'Nakuru' }}</h3>
                    <p class="mt-1 text-sm text-[#575757]">Town: <span class="font-semibold text-[#8b1e1a]" data-town-name>Nakuru</span></p>
                    <p class="mt-1 text-sm text-[#575757]">Total poles: <span class="font-semibold text-[#8b1e1a]" data-county-poles>0</span></p>
                    <p class="mt-1 text-sm text-[#575757]">Media type: <span class="font-semibold text-[#8b1e1a]" data-media-type>Street Light Ads</span></p>
                    <p class="mt-4 text-sm leading-7 text-[#4e4e4e]" data-county-suitability>High commuter visibility and repetitive street-light sequencing for urban brand recall.</p>
                    <div class="mt-4 space-y-2 text-sm" data-county-sites></div>
                    <div class="mt-6 flex flex-wrap gap-2">
                        <a href="{{ route('quote') }}" class="em-btn-primary" data-request-quote>Request Quote</a>
                        <a href="{{ route('smart-campaign-planner') }}" class="em-btn-secondary" data-plan-campaign>Plan Campaign Here</a>
                        <button type="button" class="rounded-md border border-[#d9b69d] bg-white px-4 py-2 text-xs font-semibold uppercase tracking-wide text-[#5c1514]" data-view-sites>View Sites</button>
                    </div>
                </div>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($countyGroups as $county => $rows)
                    <div class="em-card em-card-accent p-5" id="county-card-{{ \Illuminate\Support\Str::slug($county) }}" data-county-card="{{ $county }}">
                        <h3 class="text-lg font-bold text-[#5c1514]">{{ $county }} County</h3>
                        <p class="mt-1 text-sm text-[#5f5f5f]">Total poles: <span class="font-semibold text-[#8b1e1a]">{{ $rows->sum('poles') }}</span></p>
                        <div class="mt-3 flex flex-wrap gap-2">
                            @foreach ($rows->pluck('site')->take(6) as $site)
                                <span class="rounded-full bg-[#f4e3c4] px-3 py-1 text-xs font-semibold text-[#5c1514]">{{ $site }}</span>
                            @endforeach
                        </div>
                        <x-ui.brand-button href="{{ route('quote', ['county' => $county]) }}" class="mt-4">Plan Campaign in {{ $county }}</x-ui.brand-button>
                    </div>
                @endforeach
            </div>

            <details class="mt-8 em-card p-4">
                <summary class="cursor-pointer text-sm font-semibold text-[#8b1e1a]">View Detailed Site Table</summary>
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-[#ecdac8] text-left text-[#5c1514]">
                                <th class="px-3 py-2">County</th>
                                <th class="px-3 py-2">Site</th>
                                <th class="px-3 py-2">Poles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (($profileContent['reach'] ?? []) as $reach)
                                <tr class="border-b border-[#f0e5d8]">
                                    <td class="px-3 py-2">{{ $reach['county'] }}</td>
                                    <td class="px-3 py-2">{{ $reach['site'] }}</td>
                                    <td class="px-3 py-2 font-semibold text-[#8b1e1a]">{{ $reach['poles'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </details>
        </div>
    </section>

    <section id="gallery" class="em-container pb-16 lg:pb-20">
        @if ($items->isNotEmpty())
            <div class="columns-1 gap-5 sm:columns-2 lg:columns-3" data-portfolio-grid>
                @foreach ($items as $item)
                    @php
                        $category = $item->category ?: 'Street Light Ads';
                        $image = $item->image_path ? (str_starts_with($item->image_path, 'http') ? $item->image_path : asset($item->image_path)) : null;
                    @endphp
                    <div class="mb-5 break-inside-avoid" data-category="{{ $category }}">
                        <x-ui.portfolio-card
                            :title="$item->title"
                            :client="$item->client_name ?: 'Effective Media Client'"
                            :location="$item->campaign_location ?: 'Kenya'"
                            :media-type="$category"
                            :description="$item->description ?: 'Campaign case study details and visuals are maintained from the CMS.'"
                            :image="$image"
                            :campaign-slug="\Illuminate\Support\Str::slug($item->title)"
                        />
                    </div>
                @endforeach
            </div>
        @else
            <div class="columns-1 gap-5 sm:columns-2 lg:columns-3" data-portfolio-grid>
                @foreach (($profileContent['portfolio'] ?? []) as $item)
                    <div class="mb-5 break-inside-avoid" data-category="{{ $item['media_type'] }}">
                        <x-ui.portfolio-card
                            :title="$item['title']"
                            :client="$item['client']"
                            :location="$item['location']"
                            :media-type="$item['media_type']"
                            :description="$item['caption']"
                            :image="asset('profile-gallery/' . ($item['image'] ?? 'profile-page-2.jpg'))"
                            :campaign-slug="\Illuminate\Support\Str::slug($item['title'])"
                        />
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                <x-ui.empty-state title="Campaign portfolio items will appear here once published from the CMS." message="Currently showing profile-based sample campaign locations from Effective Media documents.">
                    @auth
                        @can('cms.portfolio.manage')
                            <x-ui.brand-button href="{{ route('admin.cms.portfolio.index') }}">Add Portfolio Item in Admin</x-ui.brand-button>
                        @else
                            <x-ui.brand-button href="{{ route('contact-us') }}">Contact Us for Recent Work</x-ui.brand-button>
                        @endcan
                    @else
                        <x-ui.brand-button href="{{ route('contact-us') }}">Contact Us for Recent Work</x-ui.brand-button>
                    @endauth
                </x-ui.empty-state>
            </div>
        @endif
    </section>

    <section id="documents" class="em-container pb-20">
        <x-ui.section-heading label="Documents" title="Campaign & Company Profile PDFs" description="Brochures, capability profiles, and company media documentation." />
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($companyProfiles as $profile)
                <x-ui.document-card :title="$profile['name']" :url="$profile['url']" category="Company Profile" :date="'Updated ' . now()->format('M Y')" />
            @empty
                <x-ui.empty-state class="sm:col-span-2 lg:col-span-3" title="No profile documents found" message="Upload profile PDFs to show branded document cards here." />
            @endforelse
        </div>
    </section>

    <section id="clients" class="em-container pb-16">
        <x-ui.section-heading label="Rates Calculator" title="Estimate Your Street Light Campaign Package" description="Choose duration, poles, and print option for instant estimate." />
        <div class="mt-8 em-card p-5" data-rate-calculator>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#5c1514]">Duration</label>
                    <select class="w-full rounded-md border border-[#d7bca7] px-3 py-2 text-sm" data-rate-duration>
                        <option value="14000">1 Month (KES 14,000 / pole)</option>
                        <option value="12000">3 Months (KES 12,000 / pole)</option>
                        <option value="10000">6 Months+ (KES 10,000 / pole)</option>
                    </select>
                </div>
                <div>
                    <label class="mb-1 block text-sm font-semibold text-[#5c1514]">Number of poles</label>
                    <input type="number" min="1" value="1" class="w-full rounded-md border border-[#d7bca7] px-3 py-2 text-sm" data-rate-poles>
                </div>
            </div>
            <label class="mt-4 inline-flex items-center gap-2 text-sm text-[#4f4f4f]">
                <input type="checkbox" data-rate-printing>
                Printing included (KES 4,000 per pole)
            </label>
            <div class="mt-4 rounded-md bg-[#f8ede3] p-4">
                <p class="text-sm text-[#5c1514]">Subtotal: <span class="font-bold" data-rate-subtotal>KES 14,000</span></p>
                <p class="text-sm text-[#5c1514]">Estimated total: <span class="font-bold text-[#8b1e1a]" data-rate-total>KES 14,000</span></p>
            </div>
            <a href="{{ route('quote') }}" class="em-btn-primary mt-4 inline-flex" data-get-package>Get This Package</a>
        </div>
    </section>

    <section class="em-angled py-14">
        <div class="em-container text-center">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">Ready to Launch in High-Traffic Locations?</h2>
            <p class="mx-auto mt-3 max-w-2xl text-sm text-[#f7d4c1]">Plan your next campaign with county-level media coverage insights.</p>
            <div class="mt-6 flex flex-wrap justify-center gap-3">
                <x-ui.brand-button href="{{ route('quote') }}" data-track-event="quote_started">Request Quote</x-ui.brand-button>
                <x-ui.brand-button href="{{ route('smart-campaign-planner') }}" variant="secondary">Plan Campaign Here</x-ui.brand-button>
            </div>
        </div>
    </section>

    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""
    ></script>
    <script src="https://unpkg.com/leaflet.markercluster@1.5.3/dist/leaflet.markercluster.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const buttons = Array.from(document.querySelectorAll('[data-filter]'));
            const cards = Array.from(document.querySelectorAll('[data-category]'));

            if (!buttons.length || !cards.length) return;

            const applyFilter = (selectedFilter) => {
                const normalizedSelected = String(selectedFilter || 'All').toLowerCase();
                buttons.forEach((btn) => btn.classList.remove('bg-[#8b1e1a]', 'text-white'));
                buttons.forEach((btn) => {
                    const normalizedLabel = String(btn.dataset.filter || '').toLowerCase().replace(/\s+/g, '-');
                    if (normalizedSelected === 'all' || normalizedSelected === normalizedLabel) {
                        btn.classList.add('bg-[#8b1e1a]', 'text-white');
                    }
                });
                cards.forEach((card) => {
                    const normalizedCard = String(card.dataset.category || '').toLowerCase().replace(/\s+/g, '-');
                    const match = normalizedSelected === 'all' || normalizedSelected === normalizedCard;
                    card.style.display = match ? 'block' : 'none';
                });
            };

            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    applyFilter(button.dataset.filter || 'All');
                });
            });

            const queryFilter = new URLSearchParams(window.location.search).get('filter');
            applyFilter(queryFilter || 'All');

            const mapEl = document.getElementById('coverage-map');
            if (!mapEl || typeof L === 'undefined') return;

            const points = @json($profileContent['coverage_map_points'] ?? []);
            const reachRows = @json($profileContent['reach'] ?? []);
            const countyNameEl = document.querySelector('[data-county-name]');
            const countyPolesEl = document.querySelector('[data-county-poles]');
            const countySitesEl = document.querySelector('[data-county-sites]');
            const countySuitabilityEl = document.querySelector('[data-county-suitability]');
            const townNameEl = document.querySelector('[data-town-name]');
            const mediaTypeEl = document.querySelector('[data-media-type]');
            const requestQuoteBtn = document.querySelector('[data-request-quote]');
            const planCampaignBtn = document.querySelector('[data-plan-campaign]');
            const viewSitesBtn = document.querySelector('[data-view-sites]');

            const map = L.map(mapEl).setView([-0.7, 37.2], 6);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            }).addTo(map);

            const grouped = {};
            reachRows.forEach((row) => {
                if (!grouped[row.county]) grouped[row.county] = { poles: 0, sites: [] };
                grouped[row.county].poles += Number(row.poles || 0);
                grouped[row.county].sites.push(row.site);
            });

            const mediaColorMap = {
                'Street Light Ads': '#8B1E1A',
                'Pavement Ads': '#F04A2A',
                'Billboards': '#A8977A',
            };

            const createIcon = (mediaType) => L.divIcon({
                className: 'em-map-marker',
                html: `<div style="width:16px;height:16px;border-radius:999px;background:${mediaColorMap[mediaType] || '#8B1E1A'};border:2px solid #FFFFFF;box-shadow:0 2px 8px rgba(92,21,20,.45);"></div>`,
                iconSize: [16, 16],
                iconAnchor: [8, 8],
            });

            const clusterGroup = L.markerClusterGroup({
                showCoverageOnHover: false,
                maxClusterRadius: 45,
                iconCreateFunction: (cluster) => {
                    const count = cluster.getChildCount();
                    return L.divIcon({
                        html: `<div style="background:#5C1514;color:#fff;border:2px solid #F04A2A;border-radius:999px;width:36px;height:36px;display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;">${count}</div>`,
                        className: 'em-cluster-icon',
                        iconSize: [36, 36],
                    });
                },
            });

            const updatePanel = (point) => {
                const countyData = grouped[point.county] || { poles: 0, sites: [point.town] };
                countyNameEl.textContent = point.county;
                townNameEl.textContent = point.town;
                countyPolesEl.textContent = countyData.poles;
                mediaTypeEl.textContent = point.media_type;
                countySuitabilityEl.textContent = 'Ideal for repetitive visibility in high-traffic commuter zones, urban corridors, and strategic town entry points.';
                countySitesEl.innerHTML = countyData.sites.slice(0, 8).map((site) => `<div class="rounded-md bg-[#f4e3c4] px-3 py-2 text-xs font-semibold text-[#5c1514]">${site}</div>`).join('');
                requestQuoteBtn.href = `{{ route('quote') }}?location=${encodeURIComponent(point.town)}&county=${encodeURIComponent(point.county)}&media_type=${encodeURIComponent(point.media_type)}`;
                planCampaignBtn.href = `{{ route('smart-campaign-planner') }}?location=${encodeURIComponent(point.town)}&county=${encodeURIComponent(point.county)}`;
                viewSitesBtn.dataset.countyTarget = point.county;
                if (window.emTrackEvent) {
                    window.emTrackEvent('map_location_clicked', { town: point.town, county: point.county, media_type: point.media_type });
                }
            };

            const bounds = [];
            points.forEach((point) => {
                const countyData = grouped[point.county] || { poles: 0 };
                const marker = L.marker([point.lat, point.lng], { icon: createIcon(point.media_type) });
                marker.bindPopup(
                    `<div style="min-width:180px">
                        <p style="font-weight:700;color:#5C1514;margin:0 0 6px">${point.town}</p>
                        <p style="margin:0 0 4px;font-size:12px"><strong>County:</strong> ${point.county}</p>
                        <p style="margin:0 0 4px;font-size:12px"><strong>Poles:</strong> ${countyData.poles || 'N/A'}</p>
                        <p style="margin:0 0 8px;font-size:12px"><strong>Media:</strong> ${point.media_type}</p>
                        <a href="{{ route('quote') }}?location=${encodeURIComponent(point.town)}&county=${encodeURIComponent(point.county)}&media_type=${encodeURIComponent(point.media_type)}" style="display:inline-block;background:#8B1E1A;color:#fff;padding:6px 10px;border-radius:6px;font-size:12px;text-decoration:none">Request Quote</a>
                    </div>`
                );
                marker.on('click', () => updatePanel(point));
                clusterGroup.addLayer(marker);
                bounds.push([point.lat, point.lng]);
            });
            map.addLayer(clusterGroup);
            if (bounds.length) {
                map.fitBounds(bounds, { padding: [24, 24] });
            }

            if (points.length) updatePanel(points[0]);

            const legend = L.control({ position: 'bottomleft' });
            legend.onAdd = function () {
                const div = L.DomUtil.create('div');
                div.style.background = '#fff';
                div.style.padding = '10px 12px';
                div.style.borderRadius = '10px';
                div.style.boxShadow = '0 8px 22px -16px rgba(0,0,0,.45)';
                div.style.fontSize = '12px';
                div.innerHTML = `
                    <div style="font-weight:700;color:#5C1514;margin-bottom:6px;">Media Legend</div>
                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;"><span style="width:10px;height:10px;border-radius:999px;background:#8B1E1A;display:inline-block;"></span> Street Light Ads</div>
                    <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;"><span style="width:10px;height:10px;border-radius:999px;background:#F04A2A;display:inline-block;"></span> Pavement Ads</div>
                    <div style="display:flex;align-items:center;gap:6px;"><span style="width:10px;height:10px;border-radius:999px;background:#A8977A;display:inline-block;"></span> Billboards</div>
                `;
                return div;
            };
            legend.addTo(map);

            viewSitesBtn?.addEventListener('click', () => {
                const targetCounty = viewSitesBtn.dataset.countyTarget;
                const countyCard = document.querySelector(`[data-county-card="${targetCounty}"]`);
                countyCard?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });

            const calculator = document.querySelector('[data-rate-calculator]');
            if (calculator) {
                const durationEl = calculator.querySelector('[data-rate-duration]');
                const polesEl = calculator.querySelector('[data-rate-poles]');
                const printingEl = calculator.querySelector('[data-rate-printing]');
                const subtotalEl = calculator.querySelector('[data-rate-subtotal]');
                const totalEl = calculator.querySelector('[data-rate-total]');
                const packageLink = calculator.querySelector('[data-get-package]');
                const fmt = (value) => `KES ${Number(value).toLocaleString()}`;

                const recalc = () => {
                    const perPole = Number(durationEl.value || 14000);
                    const poles = Math.max(1, Number(polesEl.value || 1));
                    const printingPerPole = printingEl.checked ? 4000 : 0;
                    const subtotal = perPole * poles;
                    const total = subtotal + (printingPerPole * poles);
                    subtotalEl.textContent = fmt(subtotal);
                    totalEl.textContent = fmt(total);
                    packageLink.href = `{{ route('quote') }}?duration=${encodeURIComponent(durationEl.options[durationEl.selectedIndex].text)}&poles=${poles}&printing=${printingEl.checked ? 'Included' : 'Not Included'}&estimate=${total}`;
                    if (window.emTrackEvent) {
                        window.emTrackEvent('rate_calculator_used', { per_pole: perPole, poles, printing: printingEl.checked, total });
                    }
                };

                durationEl.addEventListener('change', recalc);
                polesEl.addEventListener('input', recalc);
                printingEl.addEventListener('change', recalc);
                recalc();
            }
        });
    </script>
@endsection
