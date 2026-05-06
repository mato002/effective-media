<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\CmsPage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CmsPageController extends Controller
{
    public function editWhoWeAre(): View
    {
        $page = CmsPage::query()->firstOrCreate(
            ['slug' => 'who-we-are'],
            [
                'title' => 'Who We Are',
                'body' => '',
                'meta_description' => null,
            ]
        );

        return view('admin.cms.pages.who-we-are', ['page' => $page]);
    }

    public function updateWhoWeAre(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string', 'max:500'],
        ]);

        $page = CmsPage::query()->updateOrCreate(
            ['slug' => 'who-we-are'],
            [
                'title' => $validated['title'],
                'body' => $validated['body'] ?? '',
                'meta_description' => $validated['meta_description'] ?? null,
            ]
        );

        return redirect()->route('admin.cms.pages.who-we-are.edit')->with('status', 'Who We Are page saved.');
    }
}
