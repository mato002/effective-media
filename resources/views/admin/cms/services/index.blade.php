@extends('layouts.admin')

@section('title', 'Services CMS | Effective Media')
@section('header', 'Services CMS')

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.cms.services.create') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Add service</a>
    </div>
    <div class="overflow-hidden rounded-lg border border-slate-200 bg-white">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 text-slate-600">
                <tr>
                    <th class="px-4 py-3">Title</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Order</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($services as $service)
                    <tr class="border-t border-slate-200">
                        <td class="px-4 py-3">{{ $service->title }}</td>
                        <td class="px-4 py-3">{{ $service->is_active ? 'Active' : 'Hidden' }}</td>
                        <td class="px-4 py-3">{{ $service->sort_order }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.cms.services.edit', $service) }}" class="text-slate-700 underline">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
