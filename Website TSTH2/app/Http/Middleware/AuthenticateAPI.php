<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthenticateAPI
{
    public function handle(Request $request, Closure $next)
    {
        $token = session('api_token');
        
        if (!$token) {
            return redirect()->route('login');
        }

        // Verifikasi token ke API
        $response = Http::withToken($token)
                      ->get(url('/api/auth/me'));

        if (!$response->successful()) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}