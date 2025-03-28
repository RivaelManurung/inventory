<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserAccessController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'role:superadmin'])->except([
            'getUserPermissions',
            'getAccessibleRoutes',
            'getFullAccessInfo'
        ]);
    }
    

    // ==================== USER PERMISSIONS ====================
    public function getUserPermissions($userId = null)
    {
        $user = $userId ? UserModel::find($userId) : Auth::guard('api')->user();
        
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $this->getUserData($user),
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'roles' => $user->getRoleNames()
            ]
        ]);
    }

    public function givePermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:model_has_roles,user_id',
            'permission' => 'required|exists:permissions,name'
        ]);

        $user = UserModel::find($request->user_id);
        $user->givePermissionTo($request->permission);

        return response()->json([
            'status' => true,
            'message' => 'Permission granted successfully',
            'data' => $this->getUserPermissions($user->user_id)->original
        ]);
    }

    public function revokePermission(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user_models,user_id',
            'permission' => 'required|exists:permissions,name'
        ]);

        $user = UserModel::find($request->user_id);
        $user->revokePermissionTo($request->permission);

        return response()->json([
            'status' => true,
            'message' => 'Permission revoked successfully',
            'data' => $this->getUserPermissions($user->user_id)->original
        ]);
    }

    // ==================== ROLES MANAGEMENT ====================
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user_models,user_id',
            'role' => 'required|exists:roles,name'
        ]);

        $user = UserModel::find($request->user_id);
        $user->assignRole($request->role);

        return response()->json([
            'status' => true,
            'message' => 'Role assigned successfully',
            'data' => $this->getUserPermissions($user->user_id)->original
        ]);
    }

    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user_models,user_id',
            'role' => 'required|exists:roles,name'
        ]);

        $user = UserModel::find($request->user_id);
        $user->removeRole($request->role);

        return response()->json([
            'status' => true,
            'message' => 'Role removed successfully',
            'data' => $this->getUserPermissions($user->user_id)->original
        ]);
    }

    // ==================== ROUTE ACCESS ====================
    public function getAccessibleRoutes($userId = null)
    {
        $user = $userId ? UserModel::find($userId) : Auth::guard('api')->user();
        
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $accessibleRoutes = $this->checkRouteAccess($user);

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $this->getUserData($user),
                'accessible_routes' => $accessibleRoutes
            ]
        ]);
    }

    public function getFullAccessInfo($userId = null)
    {
        $user = $userId ? UserModel::find($userId) : Auth::guard('api')->user();
        
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found'
            ], 404);
        }

        $accessibleRoutes = $this->checkRouteAccess($user);

        return response()->json([
            'status' => true,
            'data' => [
                'user' => $this->getUserData($user),
                'roles' => $user->getRoleNames(),
                'permissions' => $user->getAllPermissions()->pluck('name'),
                'accessible_routes' => $accessibleRoutes,
                'all_permissions' => Permission::all()->pluck('name'),
                'all_roles' => Role::all()->pluck('name')
            ]
        ]);
    }

    // ==================== HELPER METHODS ====================
    protected function checkRouteAccess($user)
    {
        $accessibleRoutes = [];
        $allRoutes = Route::getRoutes();

        foreach ($allRoutes as $route) {
            $middleware = $route->gatherMiddleware();
            
            foreach ($middleware as $m) {
                if ($this->checkPermissionInMiddleware($m, $user)) {
                    $accessibleRoutes[] = [
                        'method' => implode('|', $route->methods()),
                        'uri' => $route->uri(),
                        'name' => $route->getName(),
                        'action' => $route->getActionName()
                    ];
                    break;
                }
            }
        }

        return $accessibleRoutes;
    }

    protected function checkPermissionInMiddleware($middleware, $user)
    {
        if (is_array($middleware)) {
            foreach ($middleware as $m) {
                if ($this->checkPermissionInMiddleware($m, $user)) {
                    return true;
                }
            }
            return false;
        }

        $patterns = [
            '/^permission:(.*)$/',
            '/^can:(.*)$/',
            '/^.*\\\PermissionMiddleware:(.*)$/'
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $middleware, $matches)) {
                return $user->can(trim($matches[1]));
            }
        }

        return false;
    }

    protected function getUserData($user)
    {
        return [
            'id' => $user->user_id,
            'name' => $user->user_nama,
            'email' => $user->user_email,
            'has_permissions' => $user->permissions->isNotEmpty(),
            'has_roles' => $user->roles->isNotEmpty()
        ];
    }
}