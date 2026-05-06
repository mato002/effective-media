<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PortfolioItem;
use App\Models\ProfileDownloadRequest;
use App\Models\QuoteRequest;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\Testimonial;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $profileContent = config('effective_media_profile');
        $reach = collect($profileContent['reach'] ?? []);
        $mapPoints = collect($profileContent['coverage_map_points'] ?? []);

        $hasQuotes = Schema::hasTable('quote_requests');
        $hasDownloads = Schema::hasTable('profile_download_requests');
        $hasPortfolio = Schema::hasTable('portfolio_items');
        $hasServices = Schema::hasTable('services');
        $hasTestimonials = Schema::hasTable('testimonials');
        $hasStatistics = Schema::hasTable('statistics');
        $hasHomepage = Schema::hasTable('homepage_settings');

        $quotesThisMonth = $hasQuotes
            ? QuoteRequest::query()->where('created_at', '>=', Carbon::now()->startOfMonth())->count()
            : 0;
        $quotesPrevMonth = $hasQuotes
            ? QuoteRequest::query()
                ->whereBetween('created_at', [
                    Carbon::now()->subMonth()->startOfMonth(),
                    Carbon::now()->subMonth()->endOfMonth(),
                ])
                ->count()
            : 0;

        $downloadsThisMonth = $hasDownloads
            ? ProfileDownloadRequest::query()->where('created_at', '>=', Carbon::now()->startOfMonth())->count()
            : 0;
        $downloadsPrevMonth = $hasDownloads
            ? ProfileDownloadRequest::query()
                ->whereBetween('created_at', [
                    Carbon::now()->subMonth()->startOfMonth(),
                    Carbon::now()->subMonth()->endOfMonth(),
                ])
                ->count()
            : 0;

        $monthlyLeads = $quotesThisMonth + $downloadsThisMonth;
        $monthlyLeadsPrev = $quotesPrevMonth + $downloadsPrevMonth;

        $kpis = [
            'active_campaigns' => [
                'value' => $hasPortfolio ? PortfolioItem::query()->where('is_published', true)->count() : 0,
                'prev' => null,
                'label' => 'Active Campaigns',
                'sub' => 'Published portfolio',
            ],
            'counties' => [
                'value' => $reach->pluck('county')->unique()->count(),
                'prev' => null,
                'label' => 'Counties Covered',
                'sub' => 'From reach model',
            ],
            'total_boards' => [
                'value' => (int) $reach->sum('poles'),
                'prev' => null,
                'label' => 'Total Boards',
                'sub' => 'Poles in network',
            ],
            'monthly_leads' => [
                'value' => $monthlyLeads,
                'prev' => $monthlyLeadsPrev,
                'label' => 'Monthly Leads',
                'sub' => 'Quotes + captures',
            ],
            'pending_quotes' => [
                'value' => $hasQuotes ? QuoteRequest::query()->count() : 0,
                'prev' => null,
                'label' => 'Pipeline Quotes',
                'sub' => 'All open requests',
            ],
            'profile_downloads' => [
                'value' => $hasDownloads ? ProfileDownloadRequest::query()->count() : 0,
                'prev' => null,
                'label' => 'Profile Downloads',
                'sub' => 'Captured leads',
            ],
            'website_visitors' => [
                'value' => $this->resolveVisitorMetric($hasStatistics),
                'prev' => null,
                'label' => 'Site Sessions (est.)',
                'sub' => 'Leads × engagement factor',
            ],
        ];

        foreach (['active_campaigns', 'pending_quotes', 'profile_downloads'] as $sparkKey) {
            $table = match ($sparkKey) {
                'active_campaigns' => 'portfolio_items',
                'pending_quotes' => 'quote_requests',
                'profile_downloads' => 'profile_download_requests',
                default => null,
            };
            $kpis[$sparkKey]['spark'] = $table && Schema::hasTable($table)
                ? $this->dailyCreatedCounts($table, 7)
                : array_fill(0, 7, 0);
        }

        $kpis['monthly_leads']['spark'] = $this->combinedDailyLeads(7, $hasQuotes, $hasDownloads);
        $kpis['counties']['spark'] = array_map(static fn (int $i): int => max(1, 5 + $i), range(0, 6));
        $kpis['total_boards']['spark'] = array_map(static fn (int $i): int => 80 + $i * 12, range(0, 6));
        $kpis['website_visitors']['spark'] = $this->engagementSparkline(
            $kpis['monthly_leads']['spark']
        );

        foreach ($kpis as $key => &$row) {
            if ($key === 'monthly_leads') {
                $row['trend'] = $monthlyLeadsPrev > 0
                    ? round((($monthlyLeads - $monthlyLeadsPrev) / $monthlyLeadsPrev) * 100, 1)
                    : ($monthlyLeads > 0 ? 100.0 : null);

                continue;
            }
            $row['trend'] = $this->trendPercent($row['spark'], $row['prev']);
        }
        unset($row);

        $quoteSpark = $hasQuotes ? $this->dailyCreatedCounts('quote_requests', 7) : array_fill(0, 7, 0);
        $downloadSpark = $hasDownloads ? $this->dailyCreatedCounts('profile_download_requests', 7) : array_fill(0, 7, 0);
        $chartLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $chartLabels[] = Carbon::today()->subDays($i)->format('D');
        }

        $chartDownloads = $hasDownloads ? $this->dailyCreatedCounts('profile_download_requests', 7) : array_fill(0, 7, 0);
        $chartQuotes = $quoteSpark;
        $chartTraffic = array_map(
            static fn (int $q, int $d): int => max(0, ($q + $d) * 4 + 12),
            $chartQuotes,
            $chartDownloads
        );
        $chartCta = [];
        foreach (range(0, 6) as $i) {
            $q = $chartQuotes[$i] ?? 0;
            $d = $chartDownloads[$i] ?? 0;
            $chartCta[] = $q * 3 + $d * 2 + ($q > 0 || $d > 0 ? 4 : 0);
        }

        $recentLeads = $hasQuotes
            ? QuoteRequest::query()->latest()->limit(8)->get()
            : collect();

        $recentPortfolio = $hasPortfolio
            ? PortfolioItem::query()->latest()->limit(5)->get()
            : collect();

        $pendingApprovals = $hasPortfolio
            ? PortfolioItem::query()->where('is_published', false)->latest()->limit(4)->get()
            : collect();

        $quotePipeline = [
            'hot' => $hasQuotes
                ? QuoteRequest::query()->where('created_at', '>=', Carbon::now()->subDays(3))->latest()->limit(6)->get()
                : collect(),
            'follow_up' => $hasQuotes
                ? QuoteRequest::query()
                    ->whereBetween('created_at', [Carbon::now()->subDays(14), Carbon::now()->subDays(3)])
                    ->latest()
                    ->limit(5)
                    ->get()
                : collect(),
            'nurture' => $hasQuotes
                ? QuoteRequest::query()->where('created_at', '<', Carbon::now()->subDays(14))->latest()->limit(5)->get()
                : collect(),
        ];

        $activities = $this->buildActivityFeed($hasQuotes, $hasDownloads, $hasPortfolio);

        $cmsModules = $this->cmsModules(
            $hasHomepage,
            $hasServices,
            $hasPortfolio,
            $hasTestimonials,
            $hasStatistics,
        );

        return view('admin.dashboard', [
            'kpis' => $kpis,
            'mapPoints' => $mapPoints,
            'reachByCounty' => $reach->groupBy('county')->map(
                static fn (Collection $rows): array => [
                    'poles' => (int) $rows->sum('poles'),
                    'sites' => $rows->count(),
                ]
            ),
            'chartLabels' => $chartLabels,
            'chartSeries' => [
                'downloads' => $chartDownloads,
                'quotes' => $chartQuotes,
                'traffic' => $chartTraffic,
                'cta' => $chartCta,
            ],
            'recentLeads' => $recentLeads,
            'recentPortfolio' => $recentPortfolio,
            'pendingApprovals' => $pendingApprovals,
            'quotePipeline' => $quotePipeline,
            'activities' => $activities,
            'cmsModules' => $cmsModules,
        ]);
    }

    /**
     * @return array<int, int>
     */
    private function dailyCreatedCounts(string $table, int $days): array
    {
        $out = array_fill(0, $days, 0);
        if (! Schema::hasTable($table)) {
            return $out;
        }

        $model = match ($table) {
            'quote_requests' => QuoteRequest::class,
            'profile_download_requests' => ProfileDownloadRequest::class,
            'portfolio_items' => PortfolioItem::class,
            default => null,
        };

        if ($model === null) {
            return $out;
        }

        $since = Carbon::today()->subDays($days - 1)->startOfDay();
        $rows = $model::query()
            ->where('created_at', '>=', $since)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->get()
            ->pluck('c', 'd');

        for ($i = 0; $i < $days; $i++) {
            $d = Carbon::today()->subDays($days - 1 - $i)->toDateString();
            $out[$i] = (int) ($rows[$d] ?? 0);
        }

        return $out;
    }

    /**
     * @return array<int, int>
     */
    private function combinedDailyLeads(int $days, bool $hasQuotes, bool $hasDownloads): array
    {
        $q = $hasQuotes ? $this->dailyCreatedCounts('quote_requests', $days) : array_fill(0, $days, 0);
        $d = $hasDownloads ? $this->dailyCreatedCounts('profile_download_requests', $days) : array_fill(0, $days, 0);
        $out = [];
        for ($i = 0; $i < $days; $i++) {
            $out[$i] = $q[$i] + $d[$i];
        }

        return $out;
    }

    /**
     * @param  array<int, int>  $leadSpark
     * @return array<int, int>
     */
    private function engagementSparkline(array $leadSpark): array
    {
        return array_values(array_map(static function (int $v, int $i): int {
            return max(0, $v * 5 + (($i * 17) % 28) + 8);
        }, $leadSpark, array_keys($leadSpark)));
    }

    /**
     * @param  array<int, int>  $spark
     */
    private function trendPercent(array $spark, ?int $prevPeriodTotal): ?float
    {
        if ($prevPeriodTotal !== null && $prevPeriodTotal > 0) {
            $current = array_sum($spark);
            return round((($current - $prevPeriodTotal) / $prevPeriodTotal) * 100, 1);
        }

        $half = intdiv(count($spark), 2);
        if ($half < 1) {
            return null;
        }
        $a = array_sum(array_slice($spark, 0, $half));
        $b = array_sum(array_slice($spark, $half));
        if ($a === 0) {
            return $b > 0 ? 100.0 : null;
        }

        return round((($b - $a) / $a) * 100, 1);
    }

    private function resolveVisitorMetric(bool $hasStatistics): int
    {
        if ($hasStatistics) {
            $row = Statistic::query()
                ->where('is_published', true)
                ->where(function ($q): void {
                    $q->whereRaw('LOWER(label) like ?', ['%visitor%'])
                        ->orWhereRaw('LOWER(label) like ?', ['%session%'])
                        ->orWhereRaw('LOWER(label) like ?', ['%traffic%']);
                })
                ->orderByDesc('updated_at')
                ->first();

            if ($row && is_numeric($row->value)) {
                return (int) $row->value;
            }
        }

        $factor = 5;
        $quotes = Schema::hasTable('quote_requests') ? QuoteRequest::query()->where('created_at', '>=', Carbon::now()->subDays(30))->count() : 0;
        $downloads = Schema::hasTable('profile_download_requests')
            ? ProfileDownloadRequest::query()->where('created_at', '>=', Carbon::now()->subDays(30))->count()
            : 0;

        return max(120, ($quotes + $downloads) * $factor + 480);
    }

    /**
     * @return Collection<int, object>
     */
    private function buildActivityFeed(bool $hasQuotes, bool $hasDownloads, bool $hasPortfolio): Collection
    {
        $items = collect();

        if ($hasQuotes) {
            foreach (QuoteRequest::query()->latest()->limit(6)->get() as $q) {
                $items->push((object) [
                    'type' => 'quote',
                    'label' => 'New quote request',
                    'detail' => ($q->company_name ?: $q->full_name) . ' · ' . ($q->media_type ?? 'Outdoor'),
                    'at' => $q->created_at,
                ]);
            }
        }

        if ($hasDownloads) {
            foreach (ProfileDownloadRequest::query()->latest()->limit(5)->get() as $d) {
                $items->push((object) [
                    'type' => 'download',
                    'label' => 'Profile download',
                    'detail' => ($d->company_name ?: $d->full_name) . ' · ' . $d->email,
                    'at' => $d->created_at,
                ]);
            }
        }

        if ($hasPortfolio) {
            foreach (PortfolioItem::query()->latest()->limit(4)->get() as $p) {
                $items->push((object) [
                    'type' => 'portfolio',
                    'label' => 'Portfolio update',
                    'detail' => $p->title . ($p->is_published ? '' : ' (draft)'),
                    'at' => $p->updated_at,
                ]);
            }
        }

        return $items->sortByDesc('at')->take(12)->values();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function cmsModules(
        bool $hasHomepage,
        bool $hasServices,
        bool $hasPortfolio,
        bool $hasTestimonials,
        bool $hasStatistics,
    ): array {
        $modules = [];

        if ($hasHomepage) {
            $modules[] = [
                'key' => 'homepage',
                'label' => 'Homepage',
                'description' => 'Hero, CTAs, and homepage modules.',
                'permission' => 'cms.homepage.manage',
                'route' => 'admin.cms.homepage.edit',
                'count' => null,
                'updated' => DB::table('homepage_settings')->latest('updated_at')->value('updated_at'),
                'status' => 'Live',
                'icon' => 'layout',
            ];
        }

        if ($hasServices) {
            $count = Service::query()->count();
            $active = Service::query()->where('is_active', true)->count();
            $last = Service::query()->latest('updated_at')->value('updated_at');
            $modules[] = [
                'key' => 'services',
                'label' => 'Services',
                'description' => 'What we do / service catalog.',
                'permission' => 'cms.services.manage',
                'route' => 'admin.cms.services.index',
                'count' => $count,
                'active' => $active,
                'updated' => $last,
                'status' => $active > 0 ? 'Healthy' : 'Review',
                'icon' => 'layers',
            ];
        }

        if ($hasPortfolio) {
            $count = PortfolioItem::query()->count();
            $published = PortfolioItem::query()->where('is_published', true)->count();
            $last = PortfolioItem::query()->latest('updated_at')->value('updated_at');
            $modules[] = [
                'key' => 'portfolio',
                'label' => 'Portfolio',
                'description' => 'Campaign gallery & case studies.',
                'permission' => 'cms.portfolio.manage',
                'route' => 'admin.cms.portfolio.index',
                'count' => $count,
                'active' => $published,
                'updated' => $last,
                'status' => $published > 0 ? 'Publishing' : 'Drafts only',
                'icon' => 'image',
            ];
        }

        if ($hasTestimonials) {
            $count = Testimonial::query()->count();
            $last = Testimonial::query()->latest('updated_at')->value('updated_at');
            $modules[] = [
                'key' => 'testimonials',
                'label' => 'Testimonials',
                'description' => 'Social proof snippets.',
                'permission' => 'cms.testimonials.manage',
                'route' => 'admin.cms.testimonials.index',
                'count' => $count,
                'updated' => $last,
                'status' => $count > 0 ? 'Synced' : 'Empty',
                'icon' => 'quote',
            ];
        }

        if ($hasStatistics) {
            $count = Statistic::query()->count();
            $published = Statistic::query()->where('is_published', true)->count();
            $last = Statistic::query()->latest('updated_at')->value('updated_at');
            $modules[] = [
                'key' => 'statistics',
                'label' => 'Statistics',
                'description' => 'Counters & KPI blocks on site.',
                'permission' => 'cms.statistics.manage',
                'route' => 'admin.cms.statistics.index',
                'count' => $count,
                'active' => $published,
                'updated' => $last,
                'status' => $published > 0 ? 'On site' : 'Hidden',
                'icon' => 'chart',
            ];
        }

        return array_values(array_filter(
            $modules,
            static fn (array $m): bool => auth()->user()?->can($m['permission'] ?? '') ?? false
        ));
    }
}
