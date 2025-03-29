<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cookie;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

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
    // Di AuthController.php
    public function showLoginForm()
    {
        return view('Admin.auth.login');
    }

    // public function webLogin(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'username' => 'required|string',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if ($validator->fails()) {
    //         return redirect()->back()
    //             ->withErrors($validator)
    //             ->withInput();
    //     }

    //     try {
    //         $credentials = $request->only('username', 'password');

    //         // Authenticate menggunakan JWT
    //         if (!$token = auth()->attempt([
    //             'user_nama' => $credentials['username'],
    //             'password' => $credentials['password']
    //         ])) {
    //             throw new \Exception('Invalid credentials');
    //         }

    //         // Simpan token di session dan cookie
    //         $request->session()->put('jwt_token', $token);

    //         return redirect()->route('dashboard')
    //             ->withCookie(cookie(
    //                 'jwt_token',
    //                 $token,
    //                 60 * 24 * 7,  // 7 hari
    //                 null,
    //                 null,
    //                 false,
    //                 true      // HttpOnly
    //             ));
    //     } catch (\Exception $e) {
    //         return back()->with('error', 'Login failed: ' . $e->getMessage());
    //     }
    // }

    // public function webLogout(Request $request)
    // {
    //     try {
    //         $token = $request->session()->get('jwt_token');

    //         if ($token) {
    //             // Invalidate token JWT
    //             auth()->logout();

    //             // Hapus semua data session
    //             $request->session()->invalidate();
    //             $request->session()->regenerateToken();
    //         }

    //         // Hapus cookie
    //         $response = redirect('/login')
    //             ->withCookie(Cookie::forget('jwt_token'));

    //         // Handle JSON response for API
    //         if ($request->wantsJson()) {
    //             return response()->json([
    //                 'status' => true,
    //                 'message' => 'Logout berhasil'
    //             ]);
    //         }

    //         // Handle web response
    //         return $response->with('success', 'Anda telah logout');
    //     } catch (\Exception $e) {
    //         if ($request->wantsJson()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Gagal logout'
    //             ], 500);
    //         }
    //         return redirect()->back()->with('error', 'Logout gagal');
    //     }
    // }
}
