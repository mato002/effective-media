<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use App\Models\ProfileDownloadRequest;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Services\Cms\HomepageContentService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Outdoor media services showcased on the website.
     *
     * @var array<int, string>
     */
    private array $defaultServices = [
        'Billboards',
        'Digital Screens',
        'Street Pole Advertising',
        'Vehicle Branding',
        'Airport Branding',
        'Petrol Station Branding',
        'Retail Branding',
        '3D Signage',
        'LED Signage',
        'Wall Branding',
        'Bus Shelter Advertising',
    ];

    public function __construct(
        private readonly HomepageContentService $homepageContentService
    ) {}

    public function home(): View
    {
        $payload = $this->homepageContentService->getHomepagePayload();
        $companyProfiles = $this->getCompanyProfiles();
        $profileContent = config('effective_media_profile');

        $services = $payload['services']->isNotEmpty() ? $payload['services'] : collect(
            array_map(static fn (string $service): array => ['title' => $service], $this->defaultServices)
        );

        return view('pages.home', [
            ...$payload,
            'services' => $services,
            'companyProfiles' => $companyProfiles,
            'profileContent' => $profileContent,
        ]);
    }

    public function whoWeAre(): View
    {
        return view('pages.who-we-are', [
            'profileContent' => config('effective_media_profile'),
            'companyProfiles' => $this->getCompanyProfiles(),
        ]);
    }

    public function whatWeDo(): View
    {
        $services = Service::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        return view('pages.what-we-do', [
            'services' => $services->isNotEmpty()
                ? $services
                : collect(array_map(static fn (string $service): array => ['title' => $service], $this->defaultServices)),
            'companyProfiles' => $this->getCompanyProfiles(),
            'profileContent' => config('effective_media_profile'),
        ]);
    }

    public function serviceShowcase(string $serviceSlug): View
    {
        $profileContent = config('effective_media_profile');
        $serviceDetails = $profileContent['service_details'] ?? [];

        $serviceLibrary = [
            'street-light-advertising' => [
                'title' => 'Street Light Advertising',
                'kicker' => 'Signature Media Infrastructure',
                'headline' => 'Command Everyday Visibility Across Commuter Corridors',
                'description' => Arr::get($serviceDetails, 'Street Light Advertising.description', 'Street Light Box campaigns deliver repeated, route-level brand exposure where people move daily.'),
                'hero_image' => Arr::get($serviceDetails, 'Street Light Advertising.image') ? asset('profile-gallery/' . Arr::get($serviceDetails, 'Street Light Advertising.image')) : 'https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=1800&q=80',
                'metrics' => [
                    ['label' => 'Installed Poles', 'value' => '730+'],
                    ['label' => 'Counties', 'value' => '7+'],
                    ['label' => 'Daily Visibility Window', 'value' => '12-16h'],
                ],
                'use_cases' => ['Product launches', 'Brand recall campaigns', 'Commuter route targeting'],
                'industries' => ['FMCG', 'Telecom', 'Financial Services', 'Education'],
                'campaign_example' => 'Commuter-focused FMCG campaign: 30 poles across Nakuru CBD for 3 months.',
            ],
            'billboards' => [
                'title' => 'Billboards',
                'kicker' => 'Large Format Dominance',
                'headline' => 'Scale Awareness at Highway and Landmark Speed',
                'description' => Arr::get($serviceDetails, 'Billboards.description', 'Billboards establish strong top-of-mind awareness by owning high-traffic road frontage and strategic urban points.'),
                'hero_image' => Arr::get($serviceDetails, 'Billboards.image') ? asset('profile-gallery/' . Arr::get($serviceDetails, 'Billboards.image')) : 'https://images.unsplash.com/photo-1494522358652-f30e61a60313?auto=format&fit=crop&w=1800&q=80',
                'metrics' => [
                    ['label' => 'Highway Nodes', 'value' => '40+'],
                    ['label' => 'Urban Anchors', 'value' => '20+'],
                    ['label' => 'Visibility Range', 'value' => 'Long Distance'],
                ],
                'use_cases' => ['City launch domination', 'Route takeovers', 'Brand authority building'],
                'industries' => ['Real Estate', 'Retail', 'Automotive', 'Insurance'],
                'campaign_example' => 'Retail expansion blitz around interchanges with 24/7 visibility impact.',
            ],
            'pavement-ads' => [
                'title' => 'Pavement Ads',
                'kicker' => 'Street-Level Visibility',
                'headline' => 'Capture Pedestrian and Mixed Traffic Attention',
                'description' => Arr::get($serviceDetails, 'Pavement Ads.description', 'Pavement advertising brings brands closer to daily urban activity and point-of-decision movement.'),
                'hero_image' => Arr::get($serviceDetails, 'Pavement Ads.image') ? asset('profile-gallery/' . Arr::get($serviceDetails, 'Pavement Ads.image')) : 'https://images.unsplash.com/photo-1512496015851-a90fb38ba796?auto=format&fit=crop&w=1800&q=80',
                'metrics' => [
                    ['label' => 'CBD Zones', 'value' => '18+'],
                    ['label' => 'Pedestrian Reach', 'value' => 'High'],
                    ['label' => 'Deployment Speed', 'value' => 'Fast'],
                ],
                'use_cases' => ['Weekend offers', 'Retail footfall', 'Event support'],
                'industries' => ['Retail', 'Hospitality', 'Events', 'SMEs'],
                'campaign_example' => 'CBD weekend retail campaign driving in-store footfall and offer recall.',
            ],
            'office-branding' => [
                'title' => 'Office Branding',
                'kicker' => 'Built Environment Identity',
                'headline' => 'Turn Workspaces Into Brand Trust Signals',
                'description' => Arr::get($serviceDetails, 'Office Branding.description', 'Office branding aligns space, message, and customer confidence through coherent visual systems.'),
                'hero_image' => Arr::get($serviceDetails, 'Office Branding.image') ? asset('profile-gallery/' . Arr::get($serviceDetails, 'Office Branding.image')) : 'https://images.unsplash.com/photo-1497366811353-6870744d04b2?auto=format&fit=crop&w=1800&q=80',
                'metrics' => [
                    ['label' => 'Branch Rollouts', 'value' => '50+'],
                    ['label' => 'Execution Scope', 'value' => 'Interior + Exterior'],
                    ['label' => 'Brand Consistency', 'value' => 'High'],
                ],
                'use_cases' => ['Branch refresh', 'Wayfinding systems', 'Experience upgrades'],
                'industries' => ['Banking', 'Healthcare', 'Education', 'Corporate'],
                'campaign_example' => 'Multi-branch identity refresh with standardized customer touchpoints.',
            ],
            'activations-roadshows' => [
                'title' => 'Activations & Roadshows',
                'kicker' => 'On-Ground Campaign Execution',
                'headline' => 'Create Momentum Through Live Brand Interaction',
                'description' => Arr::get($serviceDetails, 'Activations & Roadshows.description', 'Roadshows and activations combine movement, audience interaction, and conversion opportunities in real-world environments.'),
                'hero_image' => Arr::get($serviceDetails, 'Activations & Roadshows.image') ? asset('profile-gallery/' . Arr::get($serviceDetails, 'Activations & Roadshows.image')) : 'https://images.unsplash.com/photo-1472653431158-6364773b2a56?auto=format&fit=crop&w=1800&q=80',
                'metrics' => [
                    ['label' => 'Counties Activated', 'value' => '12+'],
                    ['label' => 'Audience Engagement', 'value' => 'Live'],
                    ['label' => 'Campaign Lift', 'value' => 'Fast'],
                ],
                'use_cases' => ['Sampling tours', 'Launch caravans', 'Awareness road drives'],
                'industries' => ['Beverages', 'Consumer Goods', 'Fintech', 'Telecom'],
                'campaign_example' => 'Regional sampling circuit with route support media and lead capture.',
            ],
            'roll-up-banners' => [
                'title' => 'Roll-up Banners',
                'kicker' => 'Portable Support Media',
                'headline' => 'Deploy Campaign Messaging Anywhere, Fast',
                'description' => Arr::get($serviceDetails, 'Roll-up Banners.description', 'Roll-up systems support launches, events, and field teams with clean, portable brand visibility.'),
                'hero_image' => Arr::get($serviceDetails, 'Roll-up Banners.image') ? asset('profile-gallery/' . Arr::get($serviceDetails, 'Roll-up Banners.image')) : 'https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=1800&q=80',
                'metrics' => [
                    ['label' => 'Deployment Time', 'value' => 'Minutes'],
                    ['label' => 'Event Utility', 'value' => 'High'],
                    ['label' => 'Cost Efficiency', 'value' => 'Strong'],
                ],
                'use_cases' => ['Trade fairs', 'POS support', 'Corporate events'],
                'industries' => ['SMEs', 'NGOs', 'Events', 'Corporate'],
                'campaign_example' => 'Trade expo support kit ensuring consistent booth-level visibility.',
            ],
        ];

        abort_unless(array_key_exists($serviceSlug, $serviceLibrary), 404);

        return view('pages.service-showcase', [
            'service' => $serviceLibrary[$serviceSlug],
            'serviceSlug' => $serviceSlug,
            'profileContent' => $profileContent,
        ]);
    }

    public function portfolio(): View
    {
        return view('pages.portfolio', [
            'items' => PortfolioItem::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderByDesc('id')
                ->limit(9)
                ->get(),
            'companyProfiles' => $this->getCompanyProfiles(),
            'profileContent' => config('effective_media_profile'),
        ]);
    }

    public function campaignPlanner(): View
    {
        return view('pages.smart-campaign-planner', [
            'profileContent' => config('effective_media_profile'),
        ]);
    }

    public function contactUs(): View
    {
        return view('pages.contact-us', [
            'profileContent' => config('effective_media_profile'),
        ]);
    }

    public function quote(Request $request): View
    {
        return view('pages.quote', [
            'profileContent' => config('effective_media_profile'),
            'prefill' => $request->only([
                'location',
                'county',
                'industry',
                'campaign_objective',
                'target_audience',
                'budget_range',
                'duration',
                'media_type',
                'campaign',
                'poles',
                'printing',
                'estimate',
            ]),
        ]);
    }

    public function storeQuote(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'county' => ['nullable', 'string', 'max:255'],
            'industry' => ['nullable', 'string', 'max:255'],
            'campaign_objective' => ['nullable', 'string', 'max:255'],
            'target_audience' => ['nullable', 'string', 'max:255'],
            'media_type' => ['nullable', 'string', 'max:255'],
            'campaign_duration' => ['nullable', 'string', 'max:255'],
            'budget_range' => ['nullable', 'string', 'max:255'],
            'campaign_slug' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'source' => ['nullable', 'string', 'max:100'],
        ]);

        if (Schema::hasTable('quote_requests')) {
            QuoteRequest::query()->create([
                ...$validated,
                'source' => $validated['source'] ?? 'website_quote_form',
            ]);
        }

        $adminEmail = config('effective_media_profile.contacts.email') ?: config('mail.from.address');
        if (is_string($adminEmail) && $adminEmail !== '') {
            Mail::raw(
                "New quote request from {$validated['full_name']} ({$validated['email']}, {$validated['phone']}). Location: " . ($validated['location'] ?? 'N/A') . ", Media: " . ($validated['media_type'] ?? 'N/A') . ", Budget: " . ($validated['budget_range'] ?? 'N/A'),
                static function ($message) use ($adminEmail): void {
                    $message->to($adminEmail)->subject('New Quote Request - Effective Media');
                }
            );
        }

        return redirect()->route('quote.success');
    }

    public function quoteSuccess(): View
    {
        return view('pages.quote-success');
    }

    public function faqs(): View
    {
        return view('pages.faqs', [
            'profileContent' => config('effective_media_profile'),
        ]);
    }

    public function viewCompanyProfile(string $filename): BinaryFileResponse
    {
        $resolvedPath = $this->resolveCompanyProfilePathByFilename($filename);

        abort_unless($resolvedPath !== null, 404);

        return response()->file($resolvedPath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . basename($resolvedPath) . '"',
        ]);
    }

    public function downloadCompanyProfile(string $filename): BinaryFileResponse
    {
        $resolvedPath = $this->resolveCompanyProfilePathByFilename($filename);

        abort_unless($resolvedPath !== null, 404);

        return response()->download($resolvedPath, basename($resolvedPath), [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function captureProfileDownload(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'filename' => ['required', 'string', 'max:255'],
        ]);

        if (Schema::hasTable('profile_download_requests')) {
            ProfileDownloadRequest::query()->create([
                ...$validated,
                'source' => 'profile_download',
            ]);
        }

        return redirect()->route('company-profile.download', [
            'filename' => $validated['filename'],
        ]);
    }

    public function townLanding(string $town, string $type): View
    {
        $profileContent = config('effective_media_profile');
        $normalizedTown = Str::title(str_replace('-', ' ', $town));
        $points = collect($profileContent['coverage_map_points'] ?? []);
        $reach = collect($profileContent['reach'] ?? []);

        $townPoints = $points->filter(
            static fn (array $point): bool => strcasecmp($point['town'] ?? '', $normalizedTown) === 0
        );

        $county = $townPoints->first()['county'] ?? ($reach->first()['county'] ?? 'Kenya');
        $mediaTypes = $townPoints->pluck('media_type')->unique()->values();
        $townPoles = $reach
            ->filter(static fn (array $row): bool => str_contains(
                strtolower(($row['site'] ?? '') . ' ' . ($row['county'] ?? '')),
                strtolower($normalizedTown)
            ))
            ->sum('poles');

        $titlePrefix = match ($type) {
            'street-light-ads' => 'Street Light Advertising in',
            'billboard-advertising' => 'Billboard Advertising in',
            default => 'Advertise in',
        };

        return view('pages.town-landing', [
            'town' => $normalizedTown,
            'county' => $county,
            'mediaTypes' => $mediaTypes->isNotEmpty() ? $mediaTypes : collect(['Street Light Ads', 'Billboards']),
            'townPoles' => $townPoles > 0 ? $townPoles : 20,
            'benefits' => $profileContent['why_choose_us'] ?? [],
            'titlePrefix' => $titlePrefix,
        ]);
    }

    public function viewBrandAsset(string $filename): BinaryFileResponse
    {
        $resolvedPath = $this->resolveBrandAssetPath($filename);

        abort_unless($resolvedPath !== null, 404);

        return response()->file($resolvedPath);
    }

    /**
     * Collect company profile PDFs from common project folders.
     *
     * @return Collection<int, array{name:string,url:string,path:string}>
     */
    private function getCompanyProfiles(): Collection
    {
        $rootLevelProfiles = collect(File::files(base_path()))
            ->filter(static fn (\SplFileInfo $file): bool => strtolower($file->getExtension()) === 'pdf');

        $directories = collect([
            public_path(),
            public_path('company-profiles'),
            public_path('profiles'),
            storage_path('app/public'),
            storage_path('app/public/company-profiles'),
        ])->filter(static fn (string $directory): bool => File::isDirectory($directory));

        $profiles = $rootLevelProfiles->map(fn (\SplFileInfo $file): array => $this->transformProfileFile($file));

        foreach ($directories as $directory) {
            $profiles = $profiles->merge(
                collect(File::allFiles($directory))
                    ->filter(static fn (\SplFileInfo $file): bool => strtolower($file->getExtension()) === 'pdf')
                    ->map(fn (\SplFileInfo $file): array => $this->transformProfileFile($file))
            );
        }

        return $profiles
            ->filter(static fn (array $profile): bool => $profile['url'] !== '#')
            ->unique('path')
            ->values();
    }

    /**
     * @return array{name:string,url:string,path:string}
     */
    private function transformProfileFile(\SplFileInfo $file): array
    {
        $absolutePath = $file->getRealPath() ?: $file->getPathname();
        $normalizedPath = str_replace('\\', '/', $absolutePath);
        $publicPathPrefix = str_replace('\\', '/', public_path());
        $storagePublicPathPrefix = str_replace('\\', '/', storage_path('app/public'));
        $isPublicFile = str_starts_with($normalizedPath, $publicPathPrefix);
        $isStoragePublicFile = str_starts_with($normalizedPath, $storagePublicPathPrefix);
        $relativePublicPath = ltrim(str_replace($publicPathPrefix, '', $normalizedPath), '/');
        $relativeStoragePath = ltrim(str_replace($storagePublicPathPrefix, '', $normalizedPath), '/');

        return [
            'name' => Str::of(pathinfo($file->getFilename(), PATHINFO_FILENAME))->replace(['-', '_'], ' ')->title()->toString(),
            'path' => $absolutePath,
            'url' => $isPublicFile
                ? asset($relativePublicPath)
                : ($isStoragePublicFile
                    ? asset('storage/' . $relativeStoragePath)
                    : route('company-profile.view', ['filename' => $file->getFilename()])),
        ];
    }

    private function resolveCompanyProfilePathByFilename(string $filename): ?string
    {
        $safeFilename = basename($filename);

        if ($safeFilename === '' || strtolower(pathinfo($safeFilename, PATHINFO_EXTENSION)) !== 'pdf') {
            return null;
        }

        $candidateDirectories = [
            base_path(),
            public_path(),
            public_path('company-profiles'),
            public_path('profiles'),
            storage_path('app/public'),
            storage_path('app/public/company-profiles'),
        ];

        foreach ($candidateDirectories as $directory) {
            if (! File::isDirectory($directory)) {
                continue;
            }

            $candidatePath = $directory . DIRECTORY_SEPARATOR . $safeFilename;

            if (File::exists($candidatePath)) {
                return $candidatePath;
            }
        }

        return null;
    }

    private function resolveBrandAssetPath(string $filename): ?string
    {
        $safeFilename = basename($filename);
        $extension = strtolower(pathinfo($safeFilename, PATHINFO_EXTENSION));
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg'];

        if ($safeFilename === '' || ! in_array($extension, $allowedExtensions, true)) {
            return null;
        }

        $candidateDirectories = [
            base_path(),
            public_path(),
            public_path('images'),
            public_path('assets'),
            storage_path('app/public'),
            storage_path('app/public/images'),
        ];

        foreach ($candidateDirectories as $directory) {
            if (! File::isDirectory($directory)) {
                continue;
            }

            $candidatePath = $directory . DIRECTORY_SEPARATOR . $safeFilename;

            if (File::exists($candidatePath)) {
                return $candidatePath;
            }
        }

        return null;
    }
}
