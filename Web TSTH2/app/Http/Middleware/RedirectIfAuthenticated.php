<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next)
    {
        if (Cookie::get('jwt_token')) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}