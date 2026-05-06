@extends('layouts.admin')

@section('title', 'Portfolio CMS | Effective Media')
@section('header', 'Portfolio CMS')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.cms.portfolio.create') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Add portfolio item</a>
    </div>
    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Location</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr class="border-t border-slate-200">
                        <td class="px-4 py-3">{{ $item->title }}</td>
                        <td class="px-4 py-3">{{ $item->campaign_location }}</td>
                        <td class="px-4 py-3">{{ $item->is_published ? 'Published' : 'Draft' }}</td>
                        <td class="px-4 py-3 text-right"><a href="{{ route('admin.cms.portfolio.edit', $item) }}" class="underline">Edit</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
