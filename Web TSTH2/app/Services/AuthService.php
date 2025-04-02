<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Http\Constant\ApiConstant;

class AuthService
{
    public function login(array $credentials)
    {
        try {
            $response = Http::timeout(30)
                ->retry(3, 100)
                ->post(ApiConstant::BASE_URL . '/auth/login', $credentials);

            $data = $response->json();

            if ($response->failed()) {
                Log::error('Login failed', [
                    'status' => $response->status(),
                    'response' => $data
                ]);
                return $this->handleFailedLogin($response);
            }

            return [
                'success' => true,
                'token' => $data['token'],
                'expires_in' => $data['expires_in'] ?? 1440,
                'data' => $data['data'] ?? []
            ];
        } catch (\Exception $e) {
            Log::error('Login exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Cannot connect to authentication server',
                'exception' => $e->getMessage()
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

            if ($response->failed()) {
                Log::error('Failed to fetch user', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return null;
            }

            $data = $response->json();
            return new UserResource((object) $data['data']);
        } catch (\Exception $e) {
            Log::error('Fetch user exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function logout($token)
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post(ApiConstant::BASE_URL . '/auth/logout');

            return $response->successful();
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
            401 => 'Invalid credentials',
            422 => $data['message'] ?? 'Validation error',
            500 => 'Internal server error',
            default => 'Login failed'
        };

        return [
            'success' => false,
            'message' => $message,
            'status' => $status,
            'errors' => $data['errors'] ?? null
        ];
    }
}