<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Http\Constant\ApiConstant;

class AuthService
{
    public function login(array $credentials)
    {
        try {
            $response = Http::post(ApiConstant::BASE_URL . '/auth/login', $credentials);
            $data = $response->json();

            if ($response->failed()) {
                Log::error('Login failed', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return ($data);
            }

            session(['jwt_token' => $data['token']]);

            return $data;
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Cannot connect to authentication server'
            ];
        }
    }

    public function getAuthenticatedUser()
    {
        try {
            $token = session('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get(ApiConstant::BASE_URL . '/auth/me');


            $data = $response->json();
            $user = new UserResource((object) $data['data']);

            // $user = UserRource::collection($user)
            // if ($response->failed()) {
            // return collect();
            // }

            return $user;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function logout($token)
{
    try {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->post(ApiConstant::BASE_URL . '/auth/logout');

        if ($response->successful()) {
            return true;
        }
        return false;
    } catch (\Exception $e) {
        Log::error('Logout exception', ['error' => $e->getMessage()]);
        return false;
    }
}

    protected function handleFailedLogin($response)
    {
        $status = $response->status();
        $data = $response->json();

        $message = match ($status) {
            401 => 'Username atau password salah',
            422 => $data['message'] ?? 'Data tidak valid',
            500 => 'Server error',
            default => 'Login gagal'
        };

        return [
            'success' => false,
            'message' => $message,
            'status_code' => $status
        ];
    }
}
