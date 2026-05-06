@props([
    'title',
    'client' => null,
    'location' => null,
    'mediaType' => null,
    'description' => null,
    'image' => null,
    'campaignSlug' => null,
])

<article {{ $attributes->class(['em-card em-card-accent group overflow-hidden transition hover:-translate-y-1']) }}>
    <div class="h-52 overflow-hidden bg-[#f6ece3]">
        @if ($image)
            <img src="{{ $image }}" alt="{{ $title }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
        @else
            <div class="em-angled flex h-full items-center justify-center px-6 text-center text-sm font-semibold text-white">Effective Media Campaign</div>
        @endif
    </div>
    <div class="p-5">
        <div class="mb-3 flex flex-wrap gap-2 text-xs font-semibold uppercase tracking-wide">
            @if ($mediaType)
                <span class="rounded-full bg-[#8b1e1a] px-3 py-1 text-white">{{ $mediaType }}</span>
            @endif
            @if ($location)
                <span class="rounded-full bg-[#f4e3c4] px-3 py-1 text-[#5c1514]">{{ $location }}</span>
            @endif
        </div>
        <h3 class="text-lg font-bold text-[#171717]">{{ $title }}</h3>
        @if ($client)
            <p class="mt-1 text-sm font-medium text-[#8b1e1a]">{{ $client }}</p>
        @endif
        <p class="mt-2 text-sm leading-7 text-[#515151]">{{ $description }}</p>
        <div class="mt-4 flex flex-wrap gap-2">
            <button type="button" class="em-btn-secondary px-3 py-2 text-xs">View Details</button>
            <a
                href="{{ route('quote', ['campaign' => $campaignSlug, 'location' => $location, 'media_type' => $mediaType]) }}"
                class="rounded-md bg-[#f04a2a] px-3 py-2 text-xs font-semibold text-white transition hover:bg-[#8b1e1a]"
                data-track-event="portfolio_campaign_clicked"
            >
                Run Similar Campaign
            </a>
        </div>
    </div>
</article>
