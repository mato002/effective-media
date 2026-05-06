<form method="POST" action="{{ $action }}" enctype="multipart/form-data" class="max-w-3xl space-y-4 rounded-lg border border-slate-200 bg-white p-6">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Title</label>
        <input type="text" name="title" value="{{ old('title', $service?->title) }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Summary</label>
        <textarea name="summary" rows="4" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">{{ old('summary', $service?->summary) }}</textarea>
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Icon hint</label>
        <input type="text" name="icon" value="{{ old('icon', $service?->icon) }}" placeholder="Emoji or glyph key" maxlength="50" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
    </div>
    <div>
        <label class="mb-1 block text-sm font-medium text-slate-700">Featured image</label>
        <input type="file" name="image" accept="image/*" class="w-full text-sm">
        @if ($service && $service->image_path)
            <p class="mt-1 text-xs text-slate-500">File stored · replace by uploading anew.</p>
        @endif
    </div>
    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">Sort order</label>
            <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $service?->sort_order ?? 0) }}" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm">
        </div>
        <div class="mt-7 space-y-2">
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $service?->is_active ?? true))>
                Active
            </label>
            <label class="flex items-center gap-2 text-sm text-slate-700">
                <input type="hidden" name="is_visible_public" value="0">
                <input type="checkbox" name="is_visible_public" value="1" @checked(old('is_visible_public', $service?->is_visible_public ?? true))>
                Visible on public site
            </label>
        </div>
    </div>
    <div class="flex gap-3">
        <button class="rounded-md bg-slate-900 px-4 py-2 text-sm font-semibold text-white">Save</button>
        @if ($service)
            <button form="delete-service" class="rounded-md border border-rose-300 px-4 py-2 text-sm font-semibold text-rose-700">Delete</button>
        @endif
    </div>
</form>

@if ($service)
    <form id="delete-service" method="POST" action="{{ route('admin.cms.services.destroy', $service) }}">
        @csrf
        @method('DELETE')
    </form>
@endif
