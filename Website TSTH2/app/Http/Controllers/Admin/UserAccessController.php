<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class UserAccessController extends Controller
{
    public function getUserPermissions()
    {
        $user = Auth::guard('api')->user();
        
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        // Add more detailed debug information
        Log::debug('User Permission Data', [
            'user_id' => $user->user_id,
            'roles' => $user->roles->pluck('name'),
            'direct_permissions' => $user->permissions->pluck('name'),
            'all_permissions' => $user->getAllPermissions()->pluck('name'),
            'permissions_via_roles' => $user->getPermissionsViaRoles()->pluck('name')
        ]);

        return response()->json([
            'status' => true,
            'data' => [
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'roles' => $user->getRoleNames()
            ]
        ]);
    }

    public function getAccessibleRoutes()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $allRoutes = Route::getRoutes();
        $accessibleRoutes = [];

        foreach ($allRoutes as $route) {
            $middleware = $route->gatherMiddleware();
            
            Log::debug('Route Check', [
                'uri' => $route->uri(),
                'name' => $route->getName(),
                'methods' => $route->methods(),
                'middleware' => $middleware
            ]);
            
            foreach ($middleware as $m) {
                $this->checkMiddleware($m, $user, $route, $accessibleRoutes);
            }
        }

        return response()->json([
            'status' => true,
            'data' => [
                'routes' => $accessibleRoutes
            ]
        ]);
    }

    protected function checkMiddleware($middleware, $user, $route, &$accessibleRoutes)
    {
        // Handle array middleware (for Laravel 11+)
        if (is_array($middleware)) {
            foreach ($middleware as $m) {
                $this->checkMiddleware($m, $user, $route, $accessibleRoutes);
            }
            return;
        }

        // Check for permission strings
        $patterns = [
            '/^permission:(.*)$/',
            '/^can:(.*)$/',
            '/^.*\\\PermissionMiddleware:(.*)$/'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $middleware, $matches)) {
                $permission = trim($matches[1]);
                
                Log::debug('Permission Check', [
                    'route' => $route->uri(),
                    'permission' => $permission,
                    'has_permission' => $user->can($permission)
                ]);
                
                if ($user->can($permission)) {
                    $accessibleRoutes[] = [
                        'method' => implode('|', $route->methods()),
                        'uri' => $route->uri(),
                        'name' => $route->getName(),
                        'permission' => $permission
                    ];
                    return;
                }
            }
        }
    }

    public function getFullAccessInfo()
    {
        $user = Auth::guard('api')->user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $allRoutes = Route::getRoutes();
        $accessibleRoutes = [];

        foreach ($allRoutes as $route) {
            $middleware = $route->gatherMiddleware();
            
            foreach ($middleware as $m) {
                $this->checkMiddleware($m, $user, $route, $accessibleRoutes);
            }
        }

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $this->getUserData($user),
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'accessible_routes' => $accessibleRoutes,
                'route_count' => count($accessibleRoutes) // Added for debugging
            ]
        ]);
    }

    protected function getUserData($user)
    {
        return [
            'id' => $user->user_id,
            'name' => $user->user_nama,
            'email' => $user->user_email,
            'has_any_permissions' => $user->permissions->isNotEmpty(),
            'has_any_roles' => $user->roles->isNotEmpty()
        ];
    }
}