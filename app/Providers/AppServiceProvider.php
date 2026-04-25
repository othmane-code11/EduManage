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
        View::composer('*', function ($view) {
            $supportedLocales = config('app.supported_locales', ['en', 'fr', 'ar']);
            $labels = [
                'en' => 'English',
                'fr' => 'Francais',
                'ar' => 'العربية',
            ];
            $flags = [
                'en' => '🇬🇧',
                'fr' => '🇫🇷',
                'ar' => '🇲🇦',
            ];
            $currentLocale = app()->getLocale();

            $localeOptions = collect($supportedLocales)->map(function ($locale) use ($labels, $flags) {
                return [
                    'code' => $locale,
                    'label' => $labels[$locale] ?? strtoupper($locale),
                    'flag' => $flags[$locale] ?? '🌐',
                ];
            })->values()->all();

            $view->with('localeOptions', $localeOptions)
                ->with('currentLocale', $currentLocale)
                ->with('isRtl', $currentLocale === 'ar');
        });
    }
}
