<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use App\Models\Admin\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Storage;

class LoginController extends BaseController
{
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|integer|exists:tbl_role,role_id', // Ubah 'id' jadi 'role_id'
                'user_nama' => 'required|string|max:255',
                'user_nmlengkap' => 'required|string|max:255',
                'user_email' => 'required|email|unique:tbl_user,user_email',
                'user_password' => 'required|min:6',
                'c_password' => 'required|same:user_password',
            ]);
            
    
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }
    
            $input = $request->all();
            $input['user_password'] = bcrypt($input['user_password']);
    
            if ($request->hasFile('user_foto')) {
                $file = $request->file('user_foto');
                $filePath = $file->store('uploads/users', 'public'); // Simpan foto ke storage
                $input['user_foto'] = $filePath;
            }
    
            $user = UserModel::create($input);
    
            return $this->sendResponse(['user' => $user], 'User registered successfully.', 201);
        } catch (Exception $e) {
            return $this->sendError('Server Error.', ['error' => $e->getMessage()], 500);
        }
    }
    

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        try {
            $credentials = [
                'user_email' => $request->user_email,
                'password' => $request->user_password,
            ];

            if (!Auth::attempt($credentials)) {
                return $this->sendError('Login Failed.', ['error' => 'Invalid email or password'], 401);
            }

            $user = Auth::user();
            $token = auth()->attempt($credentials);

            if (!$token) {
                return $this->sendError('Token Generation Failed.', ['error' => 'Could not create token'], 500);
            }

            return $this->sendResponse([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => [
                    'role_id' => $user->role_id,
                    'user_nama' => $user->user_nama,
                    'user_nmlengkap' => $user->user_nmlengkap,
                    'user_email' => $user->user_email,
                    'user_foto' => asset($user->user_foto), // Menampilkan URL lengkap foto
                ],
            ], 'User logged in successfully.', 200);
        } catch (Exception $e) {
            return $this->sendError('Server Error.', ['error' => $e->getMessage()], 500);
        }
    }
}
