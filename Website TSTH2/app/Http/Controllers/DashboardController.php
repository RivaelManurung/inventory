<?php

namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;

use App\Services\AuthService;

class DashboardController extends Controller
{
    public function index(AuthService $authService)
    {
        $userData = $authService->getAuthenticatedUser();
        
        if (!$userData['status']) {
            return redirect()->route('login')->with('error', $userData['message']);
        }

        return view('dashboard', [
            'user' => $userData['user']
        ]);
    }
}