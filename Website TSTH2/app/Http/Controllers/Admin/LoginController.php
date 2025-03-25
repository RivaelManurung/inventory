<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BaseController as BaseController;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class LoginController extends BaseController
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'role_name' => 'required|string|exists:roles,name',
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
            $input['user_password'] = Hash::make($input['user_password']);
    
            if ($request->hasFile('user_foto')) {
                $file = $request->file('user_foto');
                $filePath = $file->store('uploads/users', 'public');
                $input['user_foto'] = $filePath;
            }
    
            $user = UserModel::create($input);
            $role = Role::findByName($request->role_name);
            $user->assignRole($role);
    
            return $this->sendResponse([
                'user' => [
                    'user_nama' => $user->user_nama,
                    'user_nmlengkap' => $user->user_nmlengkap,
                    'user_email' => $user->user_email,
                    'user_foto' => $user->user_foto ? asset('storage/' . $user->user_foto) : null,
                    'role' => $role->name,
                    'updated_at' => $user->updated_at,
                    'created_at' => $user->created_at,
                    'user_id' => $user->user_id
                ]
            ], 'User registered successfully.', 201);
        } catch (Exception $e) {
            \Log::error('Registration Error: ' . $e->getMessage());
            return $this->sendError('Server Error.', ['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'user_email' => 'required|email',
                'user_password' => 'required|string',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors(), 422);
            }

            $user = UserModel::where('user_email', $request->user_email)->first();

            if (!$user || !Hash::check($request->user_password, $user->user_password)) {
                return $this->sendError('Login Failed.', ['error' => 'Invalid email or password'], 401);
            }

            $token = JWTAuth::fromUser($user);
            $userRole = $user->getRoleNames()->first();

            return $this->sendResponse([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth('api')->factory()->getTTL() * 60,
                'user' => [
                    'user_nama' => $user->user_nama,
                    'user_nmlengkap' => $user->user_nmlengkap,
                    'user_email' => $user->user_email,
                    'user_foto' => $user->user_foto ? asset('storage/' . $user->user_foto) : null,
                    'role' => $userRole,
                ],
            ], 'User logged in successfully.', 200);
        } catch (JWTException $e) {
            return $this->sendError('Could not create token.', ['error' => $e->getMessage()], 500);
        }
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return $this->sendResponse([], 'Successfully logged out.', 200);
        } catch (JWTException $e) {
            return $this->sendError('Logout Failed.', ['error' => $e->getMessage()], 500);
        }
    }
}
