@extends('layouts.admin')

@section('title', 'Quote Detail | Admin')
@section('header', 'Quote Request Detail')

@section('content')
    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Lead</h2>
            <div class="mt-3 space-y-2 text-sm text-slate-700">
                <p><span class="font-semibold text-slate-900">Name:</span> {{ $quote->full_name }}</p>
                <p><span class="font-semibold text-slate-900">Company:</span> {{ $quote->company_name ?: 'N/A' }}</p>
                <p><span class="font-semibold text-slate-900">Phone:</span> {{ $quote->phone }}</p>
                <p><span class="font-semibold text-slate-900">Email:</span> {{ $quote->email }}</p>
            </div>
        </div>

        <div class="rounded-lg border border-slate-200 bg-white p-5">
            <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Campaign Details</h2>
            <div class="mt-3 space-y-2 text-sm text-slate-700">
                <p><span class="font-semibold text-slate-900">County:</span> {{ $quote->county ?: 'N/A' }}</p>
                <p><span class="font-semibold text-slate-900">Location:</span> {{ $quote->location ?: 'N/A' }}</p>
                <p><span class="font-semibold text-slate-900">Media Type:</span> {{ $quote->media_type ?: 'N/A' }}</p>
                <p><span class="font-semibold text-slate-900">Duration:</span> {{ $quote->campaign_duration ?: 'N/A' }}</p>
                <p><span class="font-semibold text-slate-900">Budget:</span> {{ $quote->budget_range ?: 'N/A' }}</p>
                <p><span class="font-semibold text-slate-900">Source:</span> {{ $quote->source }}</p>
                <p><span class="font-semibold text-slate-900">Received:</span> {{ $quote->created_at?->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>

    <div class="mt-4 rounded-lg border border-slate-200 bg-white p-5">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-500">Message</h2>
        <p class="mt-3 whitespace-pre-line text-sm text-slate-700">{{ $quote->message ?: 'No message provided.' }}</p>
    </div>

    <div class="mt-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.quotes.index') }}" class="rounded border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Back to quotes</a>
        <form method="POST" action="{{ route('admin.quotes.destroy', $quote) }}" onsubmit="return confirm('Delete this quote request?');">
            @csrf
            @method('DELETE')
            <button class="rounded border border-rose-300 px-3 py-2 text-xs font-semibold text-rose-700 hover:bg-rose-50">Delete quote</button>
        </form>
    </div>
@endsection
