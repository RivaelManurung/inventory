<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Response\Response;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $auth_service;

    public function __construct(AuthService $authService)
    {
        $this->auth_service = $authService;
    }

    public function login(LoginRequest $request)
{
    try {
        $result = $this->auth_service->login($request->validated());
        
        return response()->json([
            'success' => true,
            'status_code' => 200,
            'message' => 'Login berhasil',
            'token' => $result['token'],
            'token_type' => $result['token_type'],
            'expires_in' => $result['expires_in'],
            'user' => $result['user'] // Ubah dari 'data' ke 'user'
        ]);
        
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'status_code' => $e->getCode() ?: 500,
            'message' => $e->getMessage()
        ]);
    }
}
    public function logout(): JsonResponse
    {
        try {
            $this->auth_service->logout();
            return Response::success('Logout berhasil', null, 200);
        } catch (\Throwable $th) {
            return Response::error(
                'Gagal logout',
                $th->getMessage(),
                500
            );
        }
    }

    public function me(): JsonResponse
    {
        try {
            $user = $this->auth_service->getAuthenticatedUser();
            return Response::success('Data user', $user, 200);
        } catch (\Throwable $th) {
            return Response::error(
                'Gagal mengambil data user',
                $th->getMessage(),
                500
            );
        }
    }

    public function refresh(): JsonResponse
    {
        try {
            $token = $this->auth_service->refreshToken();
            return Response::success('Token refreshed', ['token' => $token], 200);
        } catch (\Throwable $th) {
            return Response::error(
                'Gagal refresh token',
                $th->getMessage(),
                401
            );
        }
    }
}
