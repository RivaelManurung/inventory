<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;

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
            'password' => 'required|string|min:6'
        ]);

        $result = $this->authService->login($credentials);

        if ($result['status']) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard')
                ->with('success', 'Login berhasil');
        }

        return back()
            ->withInput()
            ->withErrors([
                'message' => $result['message'] ?? 'Login gagal'
            ]);
    }

    public function logout(Request $request)
    {
        $result = $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')
            ->with('status', $result['message']);
    }
}