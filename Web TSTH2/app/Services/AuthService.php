<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Http\Constant\ApiConstant;

class AuthService
{
    /**
     * Login user dan simpan token
     */
    public function login(array $credentials)
    {
        try {
            $response = Http::timeout(10) // Reduced timeout from 30s to 10s
            ->post(ApiConstant::BASE_URL . '/login', [
                'username' => $credentials['username'],
                'password' => $credentials['password']
            ]);

            $data = $response->json();

            if ($response->successful() && ($data['status'] ?? false)) {
                // Simpan data penting di session
                Session::put([
                    'jwt_token' => $data['data']['token'],
                    'user' => $data['data']['user'],
                    'logged_in' => true
                ]);

                // Set cookie untuk browser
                Cookie::queue(
                    'jwt_token',
                    $data['data']['token'],
                    60 * 24 * 7, // 7 hari
                    null,
                    null,
                    false,
                    true // HttpOnly
                );

                return ['status' => true, 'data' => $data['data']];
            }

            return [
                'status' => false,
                'message' => $data['message'] ?? 'Login failed',
                'http_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Terjadi kesalahan sistem',
                'http_code' => 500
            ];
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        try {
            $token = Session::get('jwt_token');
            
            $response = Http::withToken($token)
                ->post(ApiConstant::BASE_URL . '/api/auth/logout');

            // Hapus session
            Session::forget(['jwt_token', 'user', 'logged_in']);

            return [
                'status' => $response->successful(),
                'message' => $response->successful() 
                    ? 'Logout berhasil' 
                    : ($response->json()['message'] ?? 'Logout gagal')
            ];

        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Terjadi kesalahan sistem'
            ];
        }
    }

    /**
     * Dapatkan data user yang sedang login
     */
    public function getAuthenticatedUser()
    {
        try {
            $token = Session::get('jwt_token');
            
            if (!$token) {
                return [
                    'status' => false,
                    'message' => 'Not authenticated',
                    'http_code' => 401
                ];
            }

            $response = Http::withToken($token)
                ->get(ApiConstant::BASE_URL . '/api/auth/me');

            if ($response->successful()) {
                return [
                    'status' => true,
                    'user' => $response->json()['data']['user']
                ];
            }

            return [
                'status' => false,
                'message' => $response->json()['message'] ?? 'Failed to get user data',
                'http_code' => $response->status()
            ];

        } catch (\Exception $e) {
            Log::error('Get user error: ' . $e->getMessage());
            return [
                'status' => false,
                'message' => 'Terjadi kesalahan sistem',
                'http_code' => 500
            ];
        }
    }
}