@extends('layouts.admin')

@section('title', 'Homepage CMS | Effective Media')
@section('header', 'Homepage CMS')

@section('content')
    <form method="POST" action="{{ route('admin.cms.homepage.update') }}" class="max-w-4xl space-y-4 rounded-lg border border-slate-200 bg-white p-6">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Hero badge</label>
            <input type="text" name="hero_badge" value="{{ old('hero_badge', $setting?->hero_badge ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Hero title</label>
            <input type="text" name="hero_title" value="{{ old('hero_title', $setting?->hero_title ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
        </div>
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Hero description</label>
            <textarea name="hero_description" rows="4" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">{{ old('hero_description', $setting?->hero_description ?? '') }}</textarea>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Primary CTA text</label>
                <input type="text" name="primary_cta_text" value="{{ old('primary_cta_text', $setting?->primary_cta_text ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Primary CTA link</label>
                <input type="text" name="primary_cta_link" value="{{ old('primary_cta_link', $setting?->primary_cta_link ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Secondary CTA text</label>
                <input type="text" name="secondary_cta_text" value="{{ old('secondary_cta_text', $setting?->secondary_cta_text ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
            </div>
            <div>
                <label class="mb-1 block text-sm font-medium text-slate-700">Secondary CTA link</label>
                <input type="text" name="secondary_cta_link" value="{{ old('secondary_cta_link', $setting?->secondary_cta_link ?? '') }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
            </div>
        </div>
        <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Save homepage content</button>
    </form>
@endsection
