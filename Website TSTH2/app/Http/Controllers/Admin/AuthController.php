<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Login user",
     *     operationId="login",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username","password"},
     *             @OA\Property(property="username", type="string", example="admin"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Login berhasil"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="user_id", type="integer", example=1),
     *                     @OA\Property(property="user_nama", type="string", example="admin"),
     *                     @OA\Property(property="user_nmlengkap", type="string", example="Administrator"),
     *                     @OA\Property(property="role", type="string", example="superadmin")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $credentials = $request->only('username', 'password');
            
            // Attempt authentication with custom username field
            if (!$token = auth()->attempt(['user_nama' => $credentials['username'], 'password' => $credentials['password']])) {
                Log::warning('Login failed for username: ' . $credentials['username']);
                return response()->json([
                    'status' => false,
                    'message' => 'Username atau password salah'
                ], 401);
            }

            $user = auth()->user();
            Log::info('User logged in', ['user_id' => $user->user_id]);

            return $this->respondWithToken($token, $user);

        } catch (JWTException $e) {
            Log::error('JWT Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Tidak bisa membuat token'
            ], 500);
        }
    }

    /**
     * Format token response
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'status' => true,
            'message' => 'Login berhasil',
            'data' => [
                'token' => $token,
                'user' => [
                    'user_id' => $user->user_id,
                    'user_nama' => $user->user_nama,
                    'user_nmlengkap' => $user->user_nmlengkap,
                    'user_email' => $user->user_email,
                    'role' => $user->roles->first()->name ?? null,
                    'permissions' => $user->getPermissionsViaRoles()->pluck('name')
                ]
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="Logout user",
     *     operationId="logout",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout successful"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function logout()
    {
        try {
            $user = auth()->user();
            auth()->logout();
            
            Log::info('User logged out', ['user_id' => $user->user_id]);
            
            return response()->json([
                'status' => true,
                'message' => 'Logout berhasil'
            ]);

        } catch (JWTException $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Gagal logout'
            ], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/me",
     *     tags={"Authentication"},
     *     summary="Get current user data",
     *     operationId="me",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error"
     *     )
     * )
     */
    public function me()
    {
        try {
            $user = auth()->user();
            
            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'User tidak ditemukan'
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'user' => [
                        'user_id' => $user->user_id,
                        'user_nama' => $user->user_nama,
                        'user_nmlengkap' => $user->user_nmlengkap,
                        'user_email' => $user->user_email,
                        'user_foto' => $user->user_foto,
                        'role' => $user->roles->first()->name ?? null,
                        'permissions' => $user->getPermissionsViaRoles()->pluck('name')
                    ]
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Get user error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     tags={"Authentication"},
     *     summary="Refresh JWT token",
     *     operationId="refreshToken",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     )
     * )
     */
    public function refresh()
    {
        try {
            $newToken = auth()->refresh();
            
            return response()->json([
                'status' => true,
                'data' => [
                    'token' => $newToken
                ]
            ]);
            
        } catch (JWTException $e) {
            Log::error('Refresh token error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Token tidak valid'
            ], 401);
        }
    }
}