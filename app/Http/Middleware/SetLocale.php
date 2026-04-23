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
        // Get locale from multiple sources: session, query string, cookie, or default
        $locale = session('locale')
            ?? $request->query('locale')
            ?? $request->cookie('locale')
            ?? config('app.locale');

        // Validate locale is supported
        $supportedLocales = config('app.supported_locales', ['en', 'fr', 'ar']);
        if (!in_array($locale, $supportedLocales)) {
            $locale = config('app.locale');
        }

        // Set the locale
        app()->setLocale($locale);
        session()->put('locale', $locale);

        return $next($request);
    }
}
