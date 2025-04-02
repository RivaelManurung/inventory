<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, ...$permissions): Response
    {
        $userPermissions = Session::get('permissions', []);
        $userRoles = Session::get('roles', []);

        // Superadmin bypass
        if (in_array('superadmin', $userRoles)) {
            return $next($request);
        }

        // If no permissions required, continue
        if (empty($permissions)) {
            return $next($request);
        }

        // Check if user has any of the required permissions
        foreach ($permissions as $permission) {
            if (in_array($permission, $userPermissions)) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized action.');
    }
}