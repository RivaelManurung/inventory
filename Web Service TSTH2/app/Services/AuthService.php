<?php

namespace App\Services;

use App\Http\Repositories\UserRepository;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected $user_repository;

    public function __construct(UserRepository $userRepository)
    {
        $this->user_repository = $userRepository;
    }

    public function login(array $credentials): array
    {
        $token = JWTAuth::attempt([
            'user_nama' => $credentials['username'],
            'password' => $credentials['password']
        ]);

        if (!$token) {
            throw new \Exception('Login failed', 401);
        }

        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => config('jwt.ttl') * 60,
            'user' => $this->formatUserData(Auth::user()) // Pastikan key-nya 'user'
        ];
    }

    public function logout(): void
    {
        try {
            $user = Auth::user();
            JWTAuth::invalidate(JWTAuth::getToken());
            Log::info('User logged out', ['user_id' => $user->user_id]);
        } catch (JWTException $e) {
            Log::error('Logout error: ' . $e->getMessage());
            throw new \Exception('Gagal logout', 500);
        }
    }

    public function getAuthenticatedUser(): array
    {
        $user = Auth::user();

        if (!$user) {
            throw new \Exception('User tidak ditemukan', 404);
        }

        return array_merge(
            $this->formatUserData($user),
            ['token' => JWTAuth::getToken()->get()]
        );
    }

    public function refreshToken(): array
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            return [
                'access_token' => $newToken,
                'token_type' => 'bearer',
                'expires_in' => config('jwt.ttl') * 60
            ];
        } catch (JWTException $e) {
            Log::error('Refresh token error: ' . $e->getMessage());
            throw new \Exception('Token tidak valid', 401);
        }
    }

    protected function formatUserData($user): array
    {
        return [
            'user_id' => $user->user_id,
            'user_nama' => $user->user_nama,
            'user_nmlengkap' => $user->user_nmlengkap,
            'user_email' => $user->user_email,
            'user_foto' => $user->user_foto,
            'role' => $user->roles->first()->name ?? null,
            'permissions' => $user->getPermissionsViaRoles()->pluck('name')
        ];
    }
}
