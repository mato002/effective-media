@extends('layouts.admin')

@section('title', 'Who We Are CMS | Effective Media Ops')
@section('header', 'Who We Are')

@section('content')
    @include('admin.partials.page-header', [
        'title' => 'Who we are page',
        'description' => 'Body copy and meta for the public page (slug: who-we-are).',
        'breadcrumb' => 'Website CMS · Who We Are',
    ])

    <form method="POST" action="{{ route('admin.cms.pages.who-we-are.update') }}" class="space-y-5 rounded-lg border border-slate-200 bg-white p-6 text-sm dark:border-white/10 dark:bg-white/5">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="block text-xs font-semibold uppercase text-slate-500 dark:text-[#cbbfb6]">Title</label>
            <input id="title" name="title" value="{{ old('title', $page->title) }}" required class="mt-1 w-full rounded border border-slate-300 px-3 py-2 dark:border-white/20 dark:bg-transparent dark:text-white">
            @error('title')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="meta_description" class="block text-xs font-semibold uppercase text-slate-500 dark:text-[#cbbfb6]">Meta description</label>
            <input id="meta_description" name="meta_description" value="{{ old('meta_description', $page->meta_description) }}" maxlength="500" class="mt-1 w-full rounded border border-slate-300 px-3 py-2 dark:border-white/20 dark:bg-transparent dark:text-white">
            @error('meta_description')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="body" class="block text-xs font-semibold uppercase text-slate-500 dark:text-[#cbbfb6]">Body (HTML allowed)</label>
            <textarea id="body" name="body" rows="18" class="mt-1 w-full rounded border border-slate-300 px-3 py-2 font-mono text-xs dark:border-white/20 dark:bg-transparent dark:text-white">{{ old('body', $page->body) }}</textarea>
            @error('body')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>

        <div class="flex flex-wrap gap-2">
            <button type="submit" class="rounded-md bg-[#8b1e1a] px-4 py-2 text-sm font-semibold text-white hover:bg-[#f04a2a]">Save page</button>
            <a href="{{ route('who-we-are') }}" target="_blank" rel="noopener" class="rounded-md border border-slate-300 px-4 py-2 text-sm font-semibold dark:border-white/20 dark:text-white">View live page</a>
        </div>
    </form>
@endsection
