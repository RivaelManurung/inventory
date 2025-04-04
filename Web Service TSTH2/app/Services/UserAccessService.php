<?php

namespace App\Services;

use App\Http\Repositories\UserRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

class UserAccessService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserPermissions($userId = null)
    {
        return $this->handleUserOperation($userId, function ($user) {
            $permissions = $this->userRepository->getUserPermissions($user);
            return [
                'user' => $this->getUserData($user),
                'permissions' => $permissions['permissions'],
                'roles' => $permissions['roles']
            ];
        }, 'Failed to get user permissions');
    }

    public function manageRole($userId, $roleName, $action)
    {
        return $this->handleUserOperation($userId, function ($user) use ($roleName, $action) {
            $method = $action === 'assign' ? 'assignRole' : 'removeRole';
            $this->userRepository->$method($user, $roleName);

            return [
                'message' => "Role {$action}ed successfully",
                'data' => $this->getUserPermissions($user->id)
            ];
        }, "Failed to {$action} role");
    }

    public function managePermission($userId, $permissionName, $action)
    {
        return $this->handleUserOperation($userId, function ($user) use ($permissionName, $action) {
            $method = $action === 'give' ? 'givePermission' : 'revokePermission';
            $this->userRepository->$method($user, $permissionName);

            return [
                'message' => "Permission {$action}n successfully",
                'data' => $this->getUserPermissions($user->id)
            ];
        }, "Failed to {$action} permission");
    }

    public function getAccessibleRoutes($userId = null)
    {
        return $this->handleUserOperation($userId, function ($user) {
            return [
                'user' => $this->getUserData($user),
                'accessible_routes' => $this->checkRouteAccess($user)
            ];
        }, 'Failed to get accessible routes');
    }

    public function getFullAccessInfo($userId = null)
    {
        return $this->handleUserOperation($userId, function ($user) {
            $permissions = $this->userRepository->getUserPermissions($user);
            return [
                'user' => $this->getUserData($user),
                'roles' => $permissions['roles'],
                'permissions' => $permissions['permissions'],
                'accessible_routes' => $this->checkRouteAccess($user),
                'all_permissions' => $this->userRepository->getAllPermissions(),
                'all_roles' => $this->userRepository->getAllRoles()
            ];
        }, 'Failed to get full access info');
    }

    protected function handleUserOperation($userId, callable $callback, $errorMessage)
    {
        try {
            $user = $userId
                ? $this->userRepository->findUser($userId)
                : $this->userRepository->getAuthenticatedUser();

            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'User not found',
                    'status' => 404
                ];
            }

            $result = $callback($user);

            return array_merge(['success' => true], $result);
        } catch (\Exception $e) {
            Log::error($errorMessage . ': ' . $e->getMessage());
            return [
                'success' => false,
                'message' => $errorMessage,
                'status' => 500
            ];
        }
    }

    protected function checkRouteAccess($user)
    {
        $accessibleRoutes = [];
        $allRoutes = Route::getRoutes();

        foreach ($allRoutes as $route) {
            foreach ($route->gatherMiddleware() as $middleware) {
                if ($this->checkPermissionInMiddleware($middleware, $user)) {
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
            'id' => $user->user_id ?? $user->id,
            'name' => $user->user_nama ?? $user->name,
            'email' => $user->user_email ?? $user->email,
            'full_name' => $user->user_nmlengkap ?? null,
            'photo' => $user->user_foto ?? null,
            'has_permissions' => $user->permissions->isNotEmpty(),
            'has_roles' => $user->roles->isNotEmpty(),
            'roles' => $user->roles->pluck('name'),
            'permissions' => $user->getAllPermissions()->pluck('name')
        ];
    }
    public function getAllUsers()
    {
        try {
            $users = $this->userRepository->getAllUsersWithRoles();

            return [
                'success' => true,
                'data' => $users->map(function ($user) {
                    return $this->getUserData($user);
                })
            ];
        } catch (\Exception $e) {
            Log::error('Failed to get all users: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Failed to get users list',
                'status' => 500
            ];
        }
    }
}
