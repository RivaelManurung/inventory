<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;

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
    
        if (!$authResult['success']) {
            return back()->withErrors(['message' => $authResult['message']]);
        }
    
        // Store initial user data in session
        Session::put([
            'jwt_token' => $authResult['token'],
            'user' => $authResult['data']['user'] ?? []
        ]);
    
        // Fetch complete user data with permissions
        $userData = $this->authService->getAuthenticatedUser();
        if (!$userData) {
            Session::flush();
            return back()->withErrors(['message' => 'Failed to load user data']);
        }
    
        // Update session with complete data
        Session::put([
            'user' => $userData->toArray($request),
            'permissions' => $userData->permissions ?? [],
            'roles' => $userData->roles ?? []
        ]);
    
        // Set secure cookie
        $cookie = cookie(
            'jwt_token',
            $authResult['token'],
            $authResult['expires_in'] ?? 1440,
            null,
            null,
            config('session.secure'),
            true,
            false,
            'Strict'
        );
    
        return redirect()->route('dashboard')
            ->withCookie($cookie)
            ->with('success', 'Login successful');
    }

    public function logout(Request $request)
    {
        try {
            $token = Session::get('jwt_token');
            $logoutResult = $this->authService->logout($token);

            Session::flush();
            $cookie = Cookie::forget('jwt_token');

            return redirect('/login')
                ->withCookie($cookie)
                ->with('success', 'Logged out successfully');
        } catch (\Exception $e) {
            Log::error('Logout error', ['error' => $e->getMessage()]);
            return redirect('/login')->with('error', 'Error during logout');
        }
    }

    public function getCurrentUser(Request $request)
    {
        try {
            $userData = $this->authService->getAuthenticatedUser();
            
            if (!$userData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to get user data'
                ], 401);
            }

            return response()->json([
                'success' => true,
                'user' => $userData->toArray($request)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Server error'
            ], 500);
        }
    }
}