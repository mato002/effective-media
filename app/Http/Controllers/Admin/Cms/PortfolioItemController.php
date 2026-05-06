<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PortfolioItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.cms.portfolio.index', [
            'items' => PortfolioItem::query()->orderBy('sort_order')->orderByDesc('id')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('admin.cms.portfolio.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'campaign_location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        PortfolioItem::query()->create([
            ...$validated,
            'featured' => (bool) ($validated['featured'] ?? false),
            'is_published' => (bool) ($validated['is_published'] ?? false),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.cms.portfolio.index')->with('status', 'Portfolio item created.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(PortfolioItem $portfolio): View
    {
        return view('admin.cms.portfolio.edit', [
            'item' => $portfolio,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PortfolioItem $portfolio): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'client_name' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'campaign_location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'featured' => ['nullable', 'boolean'],
            'is_published' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);

        $portfolio->update([
            ...$validated,
            'featured' => (bool) ($validated['featured'] ?? false),
            'is_published' => (bool) ($validated['is_published'] ?? false),
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.cms.portfolio.index')->with('status', 'Portfolio item updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PortfolioItem $portfolio): RedirectResponse
    {
        $portfolio->delete();

        return redirect()->route('admin.cms.portfolio.index')->with('status', 'Portfolio item deleted.');
    }
}
