@extends('layouts.website')

@section('title', 'Request Quote | Effective Media')

@section('content')
    <section class="em-angled py-16 lg:py-20">
        <div class="em-container">
            <x-ui.section-heading label="Request Quote" title="Get a Custom Outdoor Advertising Quotation" description="Share your campaign details and our team will prepare a location-based proposal." light="true" />
        </div>
    </section>

    <section class="em-container py-14 pb-20">
        <form method="POST" action="{{ route('quote.store') }}" class="em-card em-card-accent mx-auto grid max-w-4xl gap-4 p-6">
            @csrf
            <input type="hidden" name="source" value="website_quote_form">
            <div class="grid gap-4 sm:grid-cols-2">
                <input name="full_name" value="{{ old('full_name') }}" type="text" required placeholder="Full name" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="company_name" value="{{ old('company_name') }}" type="text" placeholder="Company name" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="phone" value="{{ old('phone') }}" type="text" required placeholder="Phone" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="email" value="{{ old('email') }}" type="email" required placeholder="Email" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="county" value="{{ old('county', $prefill['county'] ?? '') }}" type="text" placeholder="County" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="location" value="{{ old('location', $prefill['location'] ?? '') }}" type="text" placeholder="Town / location of interest" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="industry" value="{{ old('industry', $prefill['industry'] ?? '') }}" type="text" placeholder="Industry" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="campaign_objective" value="{{ old('campaign_objective', $prefill['campaign_objective'] ?? '') }}" type="text" placeholder="Campaign objective" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="target_audience" value="{{ old('target_audience', $prefill['target_audience'] ?? '') }}" type="text" placeholder="Target audience" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="media_type" value="{{ old('media_type', $prefill['media_type'] ?? '') }}" type="text" placeholder="Media type" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="campaign_duration" value="{{ old('campaign_duration', $prefill['duration'] ?? '') }}" type="text" placeholder="Campaign duration" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="budget_range" value="{{ old('budget_range', $prefill['budget_range'] ?? $prefill['estimate'] ?? '') }}" type="text" placeholder="Budget range" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm">
                <input name="campaign_slug" value="{{ old('campaign_slug', $prefill['campaign'] ?? '') }}" type="text" placeholder="Campaign reference (optional)" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm sm:col-span-2">
                <textarea name="message" rows="5" placeholder="Tell us more about your campaign goals" class="rounded-md border border-[#d7bca7] px-3 py-2 text-sm sm:col-span-2">{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="em-btn-primary w-fit" data-track-event="quote_submitted">Submit Quote Request</button>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.emTrackEvent) {
                window.emTrackEvent('quote_started', {
                    query: Object.fromEntries(new URLSearchParams(window.location.search).entries()),
                });
            }
        });
    </script>
@endsection
