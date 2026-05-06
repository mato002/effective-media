<?php

namespace App\Http\Controllers\Admin\Cms;

use App\Http\Controllers\Controller;
use App\Models\HomepageSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomepageController extends Controller
{
    public function edit(): View
    {
        return view('admin.cms.homepage.edit', [
            'setting' => HomepageSetting::query()->first(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'hero_badge' => ['required', 'string', 'max:255'],
            'hero_title' => ['required', 'string', 'max:255'],
            'hero_description' => ['nullable', 'string'],
            'primary_cta_text' => ['required', 'string', 'max:255'],
            'primary_cta_link' => ['required', 'string', 'max:255'],
            'secondary_cta_text' => ['required', 'string', 'max:255'],
            'secondary_cta_link' => ['required', 'string', 'max:255'],
        ]);

        $setting = HomepageSetting::query()->first();

        if ($setting instanceof HomepageSetting) {
            $setting->update($validated);
        } else {
            HomepageSetting::query()->create($validated);
        }

        return back()->with('status', 'Homepage content updated successfully.');
    }
}
