@extends('layouts.website')

@section('title', 'Contact Us | Effective Media')

@section('content')
    <link
        rel="stylesheet"
        href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
        crossorigin=""
    >

    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=2000&q=80');"></div>
        <div class="absolute inset-0 bg-[linear-gradient(115deg,rgba(92,21,20,0.9),rgba(92,21,20,0.75),rgba(23,23,23,0.66))]"></div>
        <div class="em-container relative py-16 lg:py-20">
            <x-ui.section-heading label="Contact Us" title="Let's Plan Your Next Outdoor Campaign" description="Share your campaign brief and we will recommend strategic locations, media formats, and execution timelines." light="true" />
        </div>
    </section>

    <section id="details" class="em-container py-14">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-ui.contact-card label="Phone" :value="implode(' / ', $profileContent['contacts']['phones'] ?? [])" />
            <x-ui.contact-card label="Email" :value="$profileContent['contacts']['email'] ?? ''" />
            <x-ui.contact-card label="Location" :value="$profileContent['contacts']['office'] ?? 'Nakuru, Kenya'" />
            <x-ui.contact-card label="Working Hours" value="Mon - Sat, 8:00am - 6:00pm" />
        </div>
    </section>

    <section class="em-container pb-16 lg:pb-20">
        <div class="grid gap-6 lg:grid-cols-[1.1fr,0.9fr]">
            <form id="form" method="GET" action="{{ route('quote') }}" class="em-card em-card-accent p-6">
                <h2 class="text-xl font-bold text-[#5c1514]">Enquiry Form</h2>
                <div class="mt-5 grid gap-4">
                    <input type="text" name="full_name" placeholder="Full name" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm focus:border-[#8b1e1a] focus:outline-none">
                    <input type="email" name="email" placeholder="Email address" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm focus:border-[#8b1e1a] focus:outline-none">
                    <input type="text" name="company_name" placeholder="Company name" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm focus:border-[#8b1e1a] focus:outline-none">
                    <textarea rows="5" name="message" placeholder="Campaign brief" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm focus:border-[#8b1e1a] focus:outline-none"></textarea>
                    <button type="submit" class="em-btn-primary w-fit" data-track-event="quote_started">Continue to Quote Form</button>
                </div>
            </form>

            <div class="em-card em-card-accent p-6">
                <h2 class="text-xl font-bold text-[#5c1514]">Office Details</h2>
                <div class="mt-5 space-y-3 text-sm text-[#505050]">
                    <p><span class="font-semibold text-[#8b1e1a]">Company:</span> Effective Media</p>
                    <p><span class="font-semibold text-[#8b1e1a]">Address:</span> {{ $profileContent['contacts']['office'] ?? 'Nakuru, Kenya' }}</p>
                    <p><span class="font-semibold text-[#8b1e1a]">Email:</span> {{ $profileContent['contacts']['email'] ?? '' }}</p>
                    <p><span class="font-semibold text-[#8b1e1a]">Phone:</span> {{ implode(' / ', $profileContent['contacts']['phones'] ?? []) }}</p>
                    <p><span class="font-semibold text-[#8b1e1a]">Website:</span> {{ $profileContent['contacts']['website'] ?? '' }}</p>
                </div>
            </div>
        </div>
    </section>

    <section id="location" class="em-container pb-20">
        <div class="em-card em-card-accent p-6">
            <h2 class="text-xl font-bold text-[#5c1514]">Find Us on Map</h2>
            <p class="mt-2 text-sm text-[#555]">Interactive office location map powered by Leaflet and OpenStreetMap.</p>
            <div id="office-map" class="mt-4 h-96 w-full rounded-lg border border-[#d8bdaa]"></div>
        </div>
    </section>

    <script
        src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""
    ></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const mapElement = document.getElementById('office-map');

            if (!mapElement || typeof L === 'undefined') {
                return;
            }

            const officeCoords = [-1.286389, 36.817223];
            const map = L.map(mapElement).setView(officeCoords, 13);

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            }).addTo(map);

            L.marker(officeCoords)
                .addTo(map)
                .bindPopup('<strong>Effective Media</strong><br>Nairobi, Kenya')
                .openPopup();
        });
    </script>
@endsection
