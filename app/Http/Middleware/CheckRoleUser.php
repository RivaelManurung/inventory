<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRoleUser
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $menu, $type)
    {
        $user = Auth::user(); // Get the authenticated user using Spatie's Auth

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Using Spatie's roles system
        $role = $user->getRoleNames()->first(); // Assuming the user has one role

        // Default permission check
        $getMenu = 1; // Default access granted

        if ($type == 'othermenu') {
            $getMenu = $user->hasPermissionTo($menu) ? 1 : 0;
        } else if ($type == 'menu') {
            // Here, use a logic to check if the user has access to a particular menu
            $getMenu = $user->hasPermissionTo($menu) ? 1 : 0;
        } else if ($type == 'submenu') {
            // Similarly, check for submenu access
            $getMenu = $user->hasPermissionTo($menu) ? 1 : 0;
        }

        // If no permission granted, return Forbidden
        if ($getMenu == 0) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return $next($request);
    }
}
