<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class WebAuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function showLoginForm()
    {
        return view('Admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $authResult = $this->authService->login($credentials);
        // dd($authResult);

        Log::info('User logged in', ['user' => $authResult ?? null]);

        // return response()->json($authResult);
        return redirect('/dashboard');
    }

    // WebAuthController.php
    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'username' => 'required',
    //         'password' => 'required'
    //     ]);

    //     $authResult = $this->authService->login($credentials);

    //     if (!$authResult['success']) {
    //         return back()->withErrors(['message' => $authResult['message']]);
    //     }

    //     // Debug before redirect
    //     \Log::debug('Login successful', [
    //         'has_token' => !empty($authResult['token']),
    //         'token' => $authResult['token'],
    //         'expires_in' => $authResult['expires_in'] ?? 1440
    //     ]);

    //     // Set cookie JWT and redirect
    //     return redirect()->route('dashboard')
    //         ->withCookie(cookie(
    //             'jwt_token', 
    //             $authResult['token'], 
    //             $authResult['expires_in'] ?? 1440, // minutes
    //             null, // path
    //             null, // domain
    //             false, // secure
    //             true, // httpOnly
    //             false, // raw
    //             'Strict' // sameSite
    //         ))
    //         ->with('success', 'Login successful');
    // }

    public function dashboard(Request $request)
    {
        $user = $this->authService->getAuthenticatedUser();
        return view('Admin.Dashboard.dashboard', compact('user'));
    }



    public function logout(Request $request)
{
    try {
        $token = session('jwt_token');
        
        if (!$token) {
            return redirect('/login')->with('error', 'No active session found');
        }

        $logoutResult = $this->authService->logout($token);
        
        if ($logoutResult) {
            $request->session()->forget('jwt_token');
            return redirect('/login')->with('success', 'Logged out successfully');
        }

        return redirect('/login')->with('error', 'Failed to logout');
    } catch (\Exception $e) {
        return redirect('/login')->with('error', 'Error during logout');
    }
}

    public function getCurrentUser(Request $request)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json([
                'success' => false,
                'message' => 'Not authenticated'
            ], 401);
        }

        $user = $this->authService->getAuthenticatedUser($token);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user data'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user['user_id'] ?? $user['id'] ?? null,
                'username' => $user['user_nama'] ?? $user['username'] ?? null,
                'fullname' => $user['user_nmlengkap'] ?? $user['fullname'] ?? null,
                'email' => $user['user_email'] ?? $user['email'] ?? null,
                'role' => $user['role'] ?? null,
                'permissions' => $user['permissions'] ?? []
            ],
            'login_duration' => isset($user['last_login'])
                ? now()->diffInMinutes($user['last_login']) . ' minutes'
                : 'Unknown'
        ]);
    }
}
