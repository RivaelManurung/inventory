<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cookie;
use App\Services\AuthService;

class JwtAuth
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    // JwtAuth.php
    public function handle($request, Closure $next)
    {
        $token = session('jwt_token') ;

        if (!$token) {
            return redirect()->route('login')->with('error', 'Silakan login');
        }
        return $next($request);
    }
}
