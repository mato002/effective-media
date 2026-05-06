@props([
    'title',
    'url',
    'category' => 'Company Profile',
    'date' => null,
])

<article {{ $attributes->class(['em-card overflow-hidden']) }}>
    <div class="h-2 w-full bg-[#8b1e1a]"></div>
    <div class="p-5">
        <div class="mb-4 h-36 overflow-hidden rounded-lg border border-[#ecdac8] bg-[#faf4ec]">
            <object data="{{ $url }}#toolbar=0" type="application/pdf" class="h-full w-full">
                <div class="flex h-full items-center justify-center text-sm text-[#8b1e1a]">PDF preview</div>
            </object>
        </div>
        <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8b1e1a]">{{ $category }}</p>
        <h3 class="mt-2 truncate text-base font-bold text-[#171717]">{{ $title }}</h3>
        <p class="mt-1 text-xs text-[#666]">{{ $date ?: 'Latest release' }}</p>
        <div class="mt-4 flex gap-2">
            <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="em-btn-secondary flex-1 px-3 py-2 text-xs">Preview</a>
            <button
                type="button"
                class="flex-1 rounded-md bg-[#f04a2a] px-3 py-2 text-center text-xs font-semibold text-white transition hover:bg-[#8b1e1a]"
                data-download-trigger
                data-download-url="{{ $url }}"
                data-download-title="{{ $title }}"
                data-track-event="profile_download"
            >
                Download Profile
            </button>
        </div>
    </div>
</article>
