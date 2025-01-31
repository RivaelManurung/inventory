<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\AksesModel;
use App\Models\Admin\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Login dengan JWT
     */
    public function login(Request $request)
    {
        $request->validate([
            'user' => 'required',
            'pwd' => 'required',
        ]);

        $credentials = [
            'user_nama' => $request->user,
            'password' => $request->pwd, 
        ];

        if (!$token = Auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'User atau password tidak cocok!'
            ], 401);
        }

        $user = Auth()->user();
        $role = AksesModel::where('role_id', $user->role_id)->get();

        return $this->respondWithToken($token, $user, $role);
    }

    /**
     * Logout dan hapus token
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout berhasil!'
        ], 200);
    }

    /**
     * Ambil data pengguna yang sedang login
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Perbarui token JWT
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh(), auth()->user());
    }

    /**
     * Struktur respons JWT
     */
    protected function respondWithToken($token, $user, $role = null)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user,
            'role' => $role
        ]);
    }
}
// <?php
  
// namespace App\Http\Controllers;
  
// use App\Http\Controllers\Controller;
// use App\Models\User;
// use Validator;
  
  
// class AuthController extends Controller
// {
 
//     /**
//      * Register a User.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function register() {
//         $validator = Validator::make(request()->all(), [
//             'name' => 'required',
//             'email' => 'required|email|unique:users',
//             'password' => 'required|confirmed|min:8',
//         ]);
  
//         if($validator->fails()){
//             return response()->json($validator->errors()->toJson(), 400);
//         }
  
//         $user = new User;
//         $user->name = request()->name;
//         $user->email = request()->email;
//         $user->password = bcrypt(request()->password);
//         $user->save();
  
//         return response()->json($user, 201);
//     }
  
  
//     /**
//      * Get a JWT via given credentials.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function login()
//     {
//         $credentials = request(['email', 'password']);
  
//         if (! $token = auth()->attempt($credentials)) {
//             return response()->json(['error' => 'Unauthorized'], 401);
//         }
  
//         return $this->respondWithToken($token);
//     }
  
//     /**
//      * Get the authenticated User.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function me()
//     {
//         return response()->json(auth()->user());
//     }
  
//     /**
//      * Log the user out (Invalidate the token).
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function logout()
//     {
//         auth()->logout();
  
//         return response()->json(['message' => 'Successfully logged out']);
//     }
  
//     /**
//      * Refresh a token.
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function refresh()
//     {
//         return $this->respondWithToken(auth()->refresh());
//     }
  
//     /**
//      * Get the token array structure.
//      *
//      * @param  string $token
//      *
//      * @return \Illuminate\Http\JsonResponse
//      */
//     protected function respondWithToken($token)
//     {
//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'bearer',
//             'expires_in' => auth()->factory()->getTTL() * 60
//         ]);
//     }
// }
