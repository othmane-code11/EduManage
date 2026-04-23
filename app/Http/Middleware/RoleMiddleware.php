<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect()->route("login");
        }

        if (!empty($roles) && !in_array(Auth::user()->role, $roles, true)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}