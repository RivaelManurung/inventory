<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Session::get('user');
        $permissions = Session::get('permissions', []);

        if (!in_array('dashboard.view', $permissions)) {
            abort(403, 'Unauthorized access to dashboard');
        }

        return view('Admin.Dashboard.dashboard', [
            'user' => $user,
            'permissions' => $permissions
        ]);
    }
}
