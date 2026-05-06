@extends('layouts.website')

@section('title', 'Smart Campaign Planner | Effective Media')

@section('content')
    @include('components.em-leaflet-loader-inline')
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=1400&q=72');"></div>
        <div class="absolute inset-0 bg-[linear-gradient(115deg,rgba(92,21,20,0.9),rgba(92,21,20,0.75),rgba(23,23,23,0.66))]"></div>
        <div class="em-container relative py-16 lg:py-20">
            <x-ui.section-heading label="Smart Campaign Planner" title="Plan Your Campaign by Location" description="Use location, audience, and media type inputs to build focused, high-visibility campaign recommendations." light="true" />
            <div class="mt-6 inline-flex rounded-full bg-[#f4e3c4] px-4 py-2 text-xs font-semibold uppercase tracking-wide text-[#5c1514]">Live Geographic Media Intelligence Map</div>
        </div>
    </section>

    <section class="em-container py-14">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach (['Select County/Town', 'Set Audience & Objective', 'Choose Budget & Duration', 'Get Smart Recommendation'] as $step)
                <div class="em-card em-card-accent p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Planner Step</p>
                    <h3 class="mt-2 text-lg font-bold text-[#171717]">{{ $step }}</h3>
                </div>
            @endforeach
        </div>
    </section>

    <section id="location" class="em-container pb-20">
        @php
            $towns = collect($profileContent['coverage_map_points'] ?? [])->pluck('town')->unique()->sort()->values();
            $counties = collect($profileContent['coverage_map_points'] ?? [])->pluck('county')->unique()->sort()->values();
            $industries = collect($profileContent['industries'] ?? [])->values();
            $mapPoints = collect($profileContent['coverage_map_points'] ?? [])->values();
        @endphp
        <div class="grid gap-6 lg:grid-cols-[1.1fr,0.9fr]">
            <div id="calculator" class="em-card p-6">
                <h2 class="text-xl font-bold text-[#5c1514]">Interactive Campaign Planner</h2>
                <form class="mt-4 grid gap-4" id="planner-form">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <select class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm" name="county" data-county-select>
                            <option value="">Select county</option>
                            @foreach ($counties as $county)
                                <option value="{{ $county }}" @selected(request('county') === $county)>{{ $county }}</option>
                            @endforeach
                        </select>
                        <select class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm disabled:bg-[#f5f1ec] disabled:text-[#8b7d73]" name="location" data-town-select disabled>
                            <option value="">Select town</option>
                            @foreach ($towns as $town)
                                <option value="{{ $town }}" @selected(request('location') === $town)>{{ $town }}</option>
                            @endforeach
                        </select>
                    </div>
                    <p class="text-xs text-[#7f6d62]" data-town-help>Select a county first to load mapped towns.</p>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <select class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm" name="industry">
                            <option value="">Select industry</option>
                            @foreach ($industries as $industry)
                                <option value="{{ $industry }}">{{ $industry }}</option>
                            @endforeach
                        </select>
                        <select class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm" name="campaign_objective">
                            <option value="">Campaign objective</option>
                            <option value="Brand Awareness">Brand Awareness</option>
                            <option value="Product Launch">Product Launch</option>
                            <option value="Lead Generation">Lead Generation</option>
                            <option value="Store Traffic">Store Traffic</option>
                        </select>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <select class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm" name="target_audience">
                            <option value="">Target audience</option>
                            <option value="Commuters">Commuters</option>
                            <option value="Urban Families">Urban Families</option>
                            <option value="Business Owners">Business Owners</option>
                            <option value="Youth">Youth</option>
                        </select>
                        <select class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm" name="budget_range">
                            <option value="">Budget range</option>
                            <option value="KES 100,000 - 300,000">KES 100,000 - 300,000</option>
                            <option value="KES 300,000 - 700,000">KES 300,000 - 700,000</option>
                            <option value="KES 700,000+">KES 700,000+</option>
                        </select>
                    </div>
                    <div class="grid gap-4 sm:grid-cols-2">
                        <select class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm" name="campaign_duration">
                            <option value="">Campaign duration</option>
                            <option value="1 Month">1 Month</option>
                            <option value="3 Months">3 Months</option>
                            <option value="6 Months+">6 Months+</option>
                        </select>
                        <select class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm" name="media_type">
                            <option value="">Preferred media type</option>
                            <option value="Street Light Ads">Street Light Ads</option>
                            <option value="Billboards">Billboards</option>
                            <option value="Pavement Ads">Pavement Ads</option>
                            <option value="Office Branding">Office Branding</option>
                        </select>
                    </div>
                    <button class="em-btn-primary w-fit" type="submit" data-track-event="campaign_planner_used">Get Recommendation</button>
                </form>
                <div class="mt-6 rounded-lg border border-[#e2cdb9] bg-white p-3">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">Map Explorer</p>
                    <div id="planner-map" class="h-80 w-full rounded-md"></div>
                </div>
            </div>
            <div id="recommendation" class="space-y-4">
                <div class="em-card em-card-accent p-5">
                    <h3 class="text-lg font-bold text-[#5c1514]">Suggested Locations</h3>
                    <p class="mt-2 text-sm text-[#545454]" data-result-locations>Nakuru CBD, Kenyatta Avenue, Total Interchange</p>
                    <p class="mt-2 text-xs text-[#7a645a]" data-result-map-note>Select any marker on the map for town-specific recommendations.</p>
                </div>
                <div class="em-card em-card-accent p-5">
                    <h3 class="text-lg font-bold text-[#5c1514]">Suggested Media Type</h3>
                    <p class="mt-2 text-sm text-[#545454]" data-result-media>Street Light Ads</p>
                </div>
                <div class="em-card em-card-accent p-5">
                    <h3 class="text-lg font-bold text-[#5c1514]">Estimated Cost Range</h3>
                    <p class="mt-2 text-sm text-[#545454]" data-result-cost>KES 300,000 - 700,000</p>
                </div>
                <div class="em-card em-card-accent p-5">
                    <h3 class="text-lg font-bold text-[#5c1514]">Why this fits</h3>
                    <p class="mt-2 text-sm text-[#545454]" data-result-why>This mix favors high-traffic commuter routes and repetitive visibility to maximize recall for awareness and lead generation.</p>
                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('quote') }}" class="em-btn-primary" id="planner-generate-quote">Generate Quotation</a>
                        <a href="https://wa.me/254725646642?text=Hi%20Effective%20Media%2C%20I%20am%20interested%20in%20outdoor%20advertising.%20Please%20share%20available%20sites%20and%20rates." class="em-btn-secondary" target="_blank" rel="noopener noreferrer" data-track-event="whatsapp_clicked">Talk to Sales on WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.getElementById('planner-form');
            const quoteLink = document.getElementById('planner-generate-quote');
            const mapEl = document.getElementById('planner-map');
            if (!form || !quoteLink) return;

            const countySelect = form.querySelector('[name="county"]');
            const locationSelect = form.querySelector('[name="location"]');
            const mediaTypeSelect = form.querySelector('[name="media_type"]');
            const townHelp = form.querySelector('[data-town-help]');
            const mapPoints = @json($mapPoints);

            const syncTownOptions = (county, preferredTown = '') => {
                if (!locationSelect) return;
                locationSelect.disabled = !county;
                const current = preferredTown || locationSelect.value;
                const filteredTowns = county
                    ? mapPoints.filter((point) => point.county === county).map((point) => point.town)
                    : mapPoints.map((point) => point.town);
                const uniqueTowns = [...new Set(filteredTowns)].sort((a, b) => a.localeCompare(b));

                locationSelect.innerHTML = '<option value="">Select town</option>';
                uniqueTowns.forEach((town) => {
                    const option = document.createElement('option');
                    option.value = town;
                    option.textContent = town;
                    locationSelect.appendChild(option);
                });

                if (current && uniqueTowns.includes(current)) {
                    locationSelect.value = current;
                } else if (uniqueTowns.length > 0) {
                    locationSelect.value = uniqueTowns[0];
                } else {
                    locationSelect.value = '';
                }

                if (townHelp) {
                    if (!county) {
                        townHelp.textContent = 'Select a county first to load mapped towns.';
                        townHelp.classList.remove('text-[#b42318]');
                        townHelp.classList.add('text-[#7f6d62]');
                    } else if (uniqueTowns.length === 0) {
                        townHelp.textContent = `No mapped towns yet for ${county}.`;
                        townHelp.classList.remove('text-[#7f6d62]');
                        townHelp.classList.add('text-[#b42318]');
                    } else {
                        townHelp.textContent = `${uniqueTowns.length} mapped town(s) available in ${county}.`;
                        townHelp.classList.remove('text-[#b42318]');
                        townHelp.classList.add('text-[#7f6d62]');
                    }
                }
            };

            form.addEventListener('submit', (event) => {
                event.preventDefault();
                const data = new FormData(form);
                const location = data.get('location') || '';
                const county = data.get('county') || 'Nakuru';
                const mediaType = data.get('media_type') || 'Street Light Ads';
                const budgetRange = data.get('budget_range') || 'KES 300,000 - 700,000';
                const objective = data.get('campaign_objective') || 'Brand Awareness';
                const matchingPoints = mapPoints.filter((point) => point.county === county);
                const fallbackTown = matchingPoints[0]?.town || 'Nakuru';
                const selectedTown = location || fallbackTown;

                document.querySelector('[data-result-locations]').textContent = `${selectedTown} CBD, ${county} Highway Corridor, High-Traffic Junctions`;
                document.querySelector('[data-result-media]').textContent = mediaType;
                document.querySelector('[data-result-cost]').textContent = budgetRange;
                document.querySelector('[data-result-why]').textContent = `Recommended for ${objective} with strong repetitive visibility and commuter reach in ${county}.`;
                quoteLink.href = `{{ route('quote') }}?location=${encodeURIComponent(selectedTown)}&county=${encodeURIComponent(county)}&media_type=${encodeURIComponent(mediaType)}&budget_range=${encodeURIComponent(budgetRange)}&campaign_objective=${encodeURIComponent(objective)}`;

                if (window.emTrackEvent) {
                    window.emTrackEvent('campaign_planner_used', Object.fromEntries(data.entries()));
                }
            });

            syncTownOptions(countySelect?.value || '', locationSelect?.value || '');

            const initPlannerMap = () => {
                if (!mapEl || !mapPoints.length) return;

                const map = L.map(mapEl).setView([-0.7, 37.2], 6);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                }).addTo(map);

                const bounds = [];
                const townMarkerMap = new Map();
                mapPoints.forEach((point) => {
                    const marker = L.circleMarker([point.lat, point.lng], {
                        radius: 7,
                        color: '#5C1514',
                        weight: 2,
                        fillColor: '#F04A2A',
                        fillOpacity: 0.9,
                    }).addTo(map);
                    marker.bindPopup(`<strong>${point.town}</strong><br>${point.county}<br>${point.media_type}`);
                    marker.on('click', () => {
                        if (countySelect) countySelect.value = point.county;
                        if (locationSelect) locationSelect.value = point.town;
                        if (mediaTypeSelect) mediaTypeSelect.value = point.media_type;
                        syncTownOptions(point.county, point.town);
                        form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                    });
                    bounds.push([point.lat, point.lng]);
                    townMarkerMap.set(`${point.county}::${point.town}`, marker);
                });

                map.fitBounds(bounds, { padding: [24, 24] });

                countySelect?.addEventListener('change', () => {
                    const selectedCounty = countySelect.value;
                    syncTownOptions(selectedCounty);

                    if (!selectedCounty) {
                        map.fitBounds(bounds, { padding: [24, 24] });
                        return;
                    }

                    const countyPoints = mapPoints.filter((point) => point.county === selectedCounty);
                    if (countyPoints.length) {
                        map.fitBounds(countyPoints.map((point) => [point.lat, point.lng]), { padding: [24, 24], maxZoom: 10 });
                    }
                });

                locationSelect?.addEventListener('change', () => {
                    const key = `${countySelect?.value || ''}::${locationSelect.value}`;
                    const marker = townMarkerMap.get(key);
                    if (marker) {
                        marker.openPopup();
                        map.setView(marker.getLatLng(), 11);
                    }
                });
            };

            if (mapEl && typeof window.emLoadLeaflet === 'function') {
                const start = () =>
                    window
                        .emLoadLeaflet({ withMarkerCluster: false })
                        .then(() => requestAnimationFrame(initPlannerMap))
                        .catch((err) => console.warn('Planner map failed to load', err));

                if ('IntersectionObserver' in window) {
                    const io = new IntersectionObserver(
                        (entries) => {
                            entries.forEach((entry) => {
                                if (!entry.isIntersecting) return;
                                io.disconnect();
                                start();
                            });
                        },
                        { rootMargin: '200px 0px', threshold: 0.02 },
                    );
                    io.observe(mapEl);
                } else {
                    start();
                }
            }
        });
    </script>
@endsection
