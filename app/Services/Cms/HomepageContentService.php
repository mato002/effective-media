<?php

namespace App\Services\Cms;

use App\Models\HomepageSetting;
use App\Models\PortfolioItem;
use App\Models\Service;
use App\Models\Statistic;
use App\Models\Testimonial;
use Throwable;

class HomepageContentService
{
    /**
     * Get the homepage content payload with sensible defaults.
     *
     * @return array<string, mixed>
     */
    public function getHomepagePayload(): array
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
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->orderBy('title')
                ->get();

            $statistics = Statistic::query()
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
                ->where('is_published', true)
                ->where('featured', true)
                ->orderBy('sort_order')
                ->orderBy('id')
                ->limit(3)
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
