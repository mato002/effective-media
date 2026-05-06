<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.website', static function (\Illuminate\Contracts\View\View $view): void {
            $profileContact = config('effective_media_profile.contacts');
            if (! is_array($profileContact)) {
                $profileContact = [];
            }

            $socialLinks = array_filter(config('effective_media_profile.social', []));

            $phonesList = $profileContact['phones'] ?? [];
            $primaryRaw = is_array($phonesList) && isset($phonesList[0]) ? (string) $phonesList[0] : '0725646642';
            $primaryPhoneDigits = preg_replace('/\D+/', '', $primaryRaw);
            if (str_starts_with($primaryPhoneDigits, '0')) {
                $primaryPhoneDigits = '254'.substr($primaryPhoneDigits, 1);
            } elseif ($primaryPhoneDigits !== '' && ! str_starts_with($primaryPhoneDigits, '254')) {
                $primaryPhoneDigits = '254'.$primaryPhoneDigits;
            }
            $telHref = $primaryPhoneDigits !== '' ? 'tel:+'.$primaryPhoneDigits : 'tel:+254725646642';

            $view->with([
                'profileContact' => $profileContact,
                'socialLinks' => $socialLinks,
                'telHref' => $telHref,
            ]);
        });
    }
}
