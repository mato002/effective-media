<?php

namespace App\Services\Cms;

use App\Models\HomepageSetting;
use App\Models\PortfolioItem;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;
use Throwable;

class HomepageContentService
{
    /** Stored as plain arrays; do not reuse keys for serialized Eloquent collections. */
    public const HOMEPAGE_PAYLOAD_CACHE_KEY = 'cms_homepage_payload_v3';

    /**
     * Get the homepage content payload with sensible defaults.
     *
     * @return array<string, mixed>
     */
    public function getHomepagePayload(): array
    {
        /** @var array{hero: array<string, mixed>, services: array<int, array<string, mixed>>, statistics: array<int, array<string, mixed>>, testimonials: array<int, array<string, mixed>>, featured_portfolio: array<int, array<string, mixed>>} $stored */
        $stored = Cache::remember(self::HOMEPAGE_PAYLOAD_CACHE_KEY, now()->addMinutes(3), function (): array {
            return $this->buildPersistablePayload();
        });

        return $this->hydratePayloadFromCache($stored);
    }

    /**
     * Persist only plain arrays/primitives — never serialize Eloquent collections (breaks across requests / PHP 8.4).
     *
     * @return array{hero: array<string, mixed>, services: array<int, array<string, mixed>>, statistics: array<int, array<string, mixed>>, testimonials: array<int, array<string, mixed>>, featured_portfolio: array<int, array<string, mixed>>}
     */
    private function buildPersistablePayload(): array
    {
        $payload = $this->resolveHomepagePayload();

        return [
            'hero' => $payload['hero'],
            'services' => $payload['services']->map->getAttributes()->values()->all(),
            'statistics' => $payload['statistics']->map->getAttributes()->values()->all(),
            'testimonials' => $payload['testimonials']->map->getAttributes()->values()->all(),
            'featured_portfolio' => $payload['featured_portfolio']->map->getAttributes()->values()->all(),
        ];
    }

    /**
     * @param  array{hero: array<string, mixed>, services: array<int, array<string, mixed>>, statistics: array<int, array<string, mixed>>, testimonials: array<int, array<string, mixed>>, featured_portfolio: array<int, array<string, mixed>>}  $stored
     * @return array<string, mixed>
     */
    private function hydratePayloadFromCache(array $stored): array
    {
        return [
            'hero' => $stored['hero'],
            'services' => Service::hydrate($stored['services'] ?? []),
            'statistics' => Statistic::hydrate($stored['statistics'] ?? []),
            'testimonials' => Testimonial::hydrate($stored['testimonials'] ?? []),
            'featured_portfolio' => PortfolioItem::hydrate($stored['featured_portfolio'] ?? []),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function resolveHomepagePayload(): array
    {
        $defaultHeroDescription = 'Effective Media combines premium billboard placement, digital screens, and a modern planning backend into one clean ecosystem for brands that need impact.';
        $hero = [
            'badge' => 'Outdoor Media Platform',
            'title' => 'Intelligent Outdoor Advertising, Built for Scale',
            'description' => $defaultHeroDescription,
            'primary_cta_text' => 'Plan a Campaign',
            'primary_cta_link' => '/smart-campaign-planner',
            'secondary_cta_text' => 'Talk to Sales',
            'secondary_cta_link' => '/contact-us',
        ];

        try {
            $homepageSetting = HomepageSetting::query()->first();

            if ($homepageSetting instanceof HomepageSetting) {
                $hero = [
                    'badge' => $homepageSetting->hero_badge,
                    'title' => $homepageSetting->hero_title,
                    'description' => $homepageSetting->hero_description ?: $defaultHeroDescription,
                    'primary_cta_text' => $homepageSetting->primary_cta_text,
                    'primary_cta_link' => $homepageSetting->primary_cta_link,
                    'secondary_cta_text' => $homepageSetting->secondary_cta_text,
                    'secondary_cta_link' => $homepageSetting->secondary_cta_link,
                ];
            }

            $services = Service::query()
                ->select(['id', 'title', 'slug', 'summary', 'sort_order', 'is_active'])
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get();

            $statistics = Statistic::query()
                ->select(['id', 'label', 'value', 'suffix', 'sort_order', 'is_published', 'updated_at'])
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            $testimonials = Testimonial::query()
                ->where('is_published', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->get();

            $featuredPortfolio = PortfolioItem::query()
                ->select([
                    'id',
                    'title',
                    'client_name',
                    'category',
                    'campaign_location',
                    'description',
                    'image_path',
                    'featured',
                    'is_published',
                    'sort_order',
                ])
                ->where('is_published', true)
                ->where('featured', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit(12)
                ->get();
        } catch (Throwable) {
            // Keep the landing page available even if DB driver/config is unavailable.
            $services = collect();
            $statistics = collect();
            $testimonials = collect();
            $featuredPortfolio = collect();
        }

        return [
            'hero' => $hero,
            'services' => $services,
            'statistics' => $statistics,
            'testimonials' => $testimonials,
            'featured_portfolio' => $featuredPortfolio,
        ];
    }
}
