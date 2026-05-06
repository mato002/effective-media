<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        return view('admin.cms.services.index', [
            'services' => Service::query()->orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.cms.services.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->baseRules($request);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cms-services', 'public');
        }

        Service::query()->create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.Str::lower(Str::random(6)),
            'summary' => $validated['summary'] ?? null,
            'image_path' => $imagePath,
            'icon' => $validated['icon'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'is_visible_public' => (bool) ($validated['is_visible_public'] ?? true),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.cms.services.index')->with('status', 'Service created.');
    }

    public function edit(Service $service): View
    {
        return view('admin.cms.services.edit', [
            'service' => $service,
        ]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $this->baseRules($request);

        $data = [
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']).'-'.$service->id,
            'summary' => $validated['summary'] ?? null,
            'icon' => $validated['icon'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? false),
            'is_visible_public' => (bool) ($validated['is_visible_public'] ?? false),
            'sort_order' => $validated['sort_order'] ?? 0,
        ];

        if ($request->hasFile('image')) {
            if ($service->image_path) {
                Storage::disk('public')->delete($service->image_path);
            }
            $data['image_path'] = $request->file('image')->store('cms-services', 'public');
        }

        $service->update($data);

        return redirect()->route('admin.cms.services.index')->with('status', 'Service updated.');
    }

    public function destroy(Service $service): RedirectResponse
    {
        if ($service->image_path) {
            Storage::disk('public')->delete($service->image_path);
        }
        $service->delete();

        return redirect()->route('admin.cms.services.index')->with('status', 'Service deleted.');
    }

    public function reorder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'orders' => ['required', 'array'],
            'orders.*' => ['integer', 'min:0'],
        ]);

        foreach (array_keys($validated['orders']) as $id) {
            if (! Service::query()->whereKey($id)->exists()) {
                abort(422, 'Invalid service id in order payload.');
            }
        }

        foreach ($validated['orders'] as $id => $sortOrder) {
            Service::query()->whereKey($id)->update(['sort_order' => $sortOrder]);
        }

        return redirect()->route('admin.cms.services.index')->with('status', 'Order saved.');
    }

    /**
     * @return array<string, mixed>
     */
    private function baseRules(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'summary' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'is_active' => ['nullable', 'boolean'],
            'is_visible_public' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'max:6144'],
        ]);
    }
}
