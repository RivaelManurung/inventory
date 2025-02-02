<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AksesModel;
use App\Models\Admin\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Exception;

class LoginController extends Controller
{
    /**
     * Login dengan JWT
     */
    public function login(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'user' => 'required|string',
                'pwd' => 'required|string|min:6',
            ]);

            // Cek apakah user ada di database
            $user = UserModel::where('user_nama', $request->user)->first();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan!'
                ], 404);
            }

            // Cek apakah password cocok
            if (!Hash::check($request->pwd, $user->user_password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password salah!'
                ], 401);
            }

            // Autentikasi menggunakan JWT
            $credentials = [
                'user_nama' => $request->user,
                'password' => $request->pwd,
            ];

            if (!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User atau password tidak cocok!'
                ], 401);
            }

            // Ambil role user
            $role = AksesModel::where('role_id', $user->role_id)->get();

            return $this->respondWithToken($token, $user, $role);

        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal!',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan di server!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Logout dan hapus token
     */
    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'status' => 'success',
                'message' => 'Logout berhasil!'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal logout!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Ambil data pengguna yang sedang login
     */
    public function me()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User tidak ditemukan!'
                ], 404);
            }
            return response()->json($user);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Perbarui token JWT
     */
    public function refresh()
    {
        try {
            return $this->respondWithToken(Auth::refresh(), Auth::user());
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui token!',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Struktur respons JWT
     */
    protected function respondWithToken($token, $user, $role = null)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => $user,
            'role' => $role
        ]);
    }
}
