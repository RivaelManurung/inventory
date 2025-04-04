<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JwtAuth
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $token = Session::get('jwt_token');

        // 1. Check if token exists
        if (!$token) {
            return $this->redirectToLogin('Silakan login terlebih dahulu');
        }

        // 2. Validate token structure (basic check)
        if (!$this->isValidTokenStructure($token)) {
            Session::forget('jwt_token');
            return $this->redirectToLogin('Token tidak valid');
        }

        // 3. Verify token by making API request to /auth/me
        try {
            $user = $this->authService->getAuthenticatedUser();
            
            if (!$user) {
                Session::forget('jwt_token');
                return $this->redirectToLogin('Sesi telah berakhir, silakan login kembali');
            }
            
        } catch (\Exception $e) {
            Session::forget('jwt_token');
            return $this->redirectToLogin('Terjadi kesalahan validasi token');
        }

        // Token is valid, proceed with request
        return $next($request);
    }

    /**
     * Redirect to login with error message
     */
    private function redirectToLogin(string $message): Response
    {
        // Clear any existing token
        Session::forget('jwt_token');
        
        return redirect()
            ->route('login')
            ->with('error', $message)
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0'
            ]);
    }

    /**
     * Basic token structure validation
     */
    private function isValidTokenStructure(?string $token): bool
    {
        if (!is_string($token)) {
            return false;
        }

        $parts = explode('.', $token);
        return count($parts) === 3;
    }
}