@extends('layouts.admin')

@section('title', 'Quote Requests | Admin')
@section('header', 'Quote Requests')

@section('content')
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.quotes.export') }}" class="rounded border border-slate-300 bg-white px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">Export CSV</a>
    </div>

    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-600">
                <tr>
                    <th class="px-4 py-3 font-semibold">Lead</th>
                    <th class="px-4 py-3 font-semibold">Contact</th>
                    <th class="px-4 py-3 font-semibold">Campaign</th>
                    <th class="px-4 py-3 font-semibold">Source</th>
                    <th class="px-4 py-3 font-semibold">Received</th>
                    <th class="px-4 py-3 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($quotes as $quote)
                    <tr class="border-t border-slate-100">
                        <td class="px-4 py-3">
                            <p class="font-semibold text-slate-900">{{ $quote->full_name }}</p>
                            <p class="text-xs text-slate-500">{{ $quote->company_name ?: 'No company provided' }}</p>
                        </td>
                        <td class="px-4 py-3 text-slate-700">
                            <p>{{ $quote->phone }}</p>
                            <p class="text-xs">{{ $quote->email }}</p>
                        </td>
                        <td class="px-4 py-3 text-slate-700">
                            <p>{{ $quote->location ?: ($quote->county ?: 'N/A') }}</p>
                            <p class="text-xs text-slate-500">{{ $quote->media_type ?: 'General enquiry' }}</p>
                        </td>
                        <td class="px-4 py-3 text-slate-700">{{ $quote->source }}</td>
                        <td class="px-4 py-3 text-slate-700">{{ $quote->created_at?->diffForHumans() }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.quotes.show', $quote) }}" class="rounded border border-slate-300 px-2 py-1 text-xs font-semibold text-slate-700 hover:bg-slate-50">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-10 text-center text-sm text-slate-500">No quote requests received yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $quotes->links() }}
    </div>
@endsection
