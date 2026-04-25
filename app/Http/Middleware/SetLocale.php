<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Use session locale first and default to English when missing.
        $locale = session('locale', config('app.locale', 'en'));

        // Ensure selected locale is supported.
        $supportedLocales = config('app.supported_locales', ['en', 'fr', 'ar']);
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale', 'en');
        }

        app()->setLocale($locale);
        session()->put('locale', $locale);

        return $next($request);
    }
}
