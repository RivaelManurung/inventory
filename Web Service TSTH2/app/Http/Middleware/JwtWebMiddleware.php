<?php
// app/Http/Middleware/JwtWebMiddleware.php
namespace App\Http\Middleware;


use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use App\Services\AuthService;

class JwtWebMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            // Cek token dari cookie atau session
            $token = $request->cookie('jwt_token') ?? session('jwt_token');
            
            if (!$token) {
                return redirect()->route('login');
            }

            // Validasi token
            $user = JWTAuth::setToken($token)->authenticate();
            
            if (!$user) {
                return redirect()->route('login');
            }

            // Auto-refresh token jika diperlukan
            if (JWTAuth::setToken($token)->getPayload()->get('exp') - time() < 1800) {
                $newToken = JWTAuth::refresh();
                session(['jwt_token' => $newToken]);
                cookie('jwt_token', $newToken, 60*24*1);
            }

            return $next($request);

        } catch (TokenExpiredException $e) {
            try {
                $newToken = JWTAuth::refresh();
                session(['jwt_token' => $newToken]);
                cookie('jwt_token', $newToken, 60*24*1);
                
                return $next($request);
            } catch (JWTException $e) {
                return redirect()->route('login')->with('error', 'Sesi telah berakhir');
            }
        } catch (JWTException $e) {
            return redirect()->route('login')->with('error', 'Autentikasi gagal');
        }
    }
}