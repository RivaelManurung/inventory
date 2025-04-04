<?php

namespace App\Http\Repositories;

use App\Models\UserModel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRepository
{
    protected $userModel;
    protected $role;
    protected $permission;

    public function __construct(
        UserModel $userModel,
        Role $role = null,
        Permission $permission = null
    ) {
        $this->userModel = $userModel;
        $this->role = $role ?? new Role();
        $this->permission = $permission ?? new Permission();
    }

    /**
     * Find user by username
     */
    public function findByUsername(string $username)
    {
        return $this->userModel->where('user_nama', $username)->first();
    }

    /**
     * Get user with roles and permissions
     */
    public function getUserWithRolesPermissions(int $userId)
    {
        return $this->userModel->with(['roles.permissions'])
            ->findOrFail($userId);
    }

    /**
     * Find user by ID
     */
    public function findUser(int $userId)
    {
        return $this->userModel->find($userId);
    }

    /**
     * Get authenticated user
     */
    public function getAuthenticatedUser()
    {
        return auth('api')->user();
    }

    /**
     * Get all users with their roles and permissions
     */
    public function getAllUsers()
    {
        return $this->userModel->with(['roles', 'permissions'])->get();
    }

    /**
     * Assign role to user
     */
    public function assignRole($user, string $roleName)
    {
        return $user->assignRole($roleName);
    }

    /**
     * Remove role from user
     */
    public function removeRole($user, string $roleName)
    {
        return $user->removeRole($roleName);
    }

    /**
     * Grant permission to user
     */
    public function givePermission($user, string $permissionName)
    {
        return $user->givePermissionTo($permissionName);
    }

    /**
     * Revoke permission from user
     */
    public function revokePermission($user, string $permissionName)
    {
        return $user->revokePermissionTo($permissionName);
    }

    /**
     * Get user permissions and roles
     */
    public function getUserPermissions($user)
    {
        return [
            'permissions' => $user->getAllPermissions()->pluck('name'),
            'roles' => $user->getRoleNames()
        ];
    }

    /**
     * Get all available permissions
     */
    public function getAllPermissions()
    {
        return $this->permission->all()->pluck('name');
    }

    /**
     * Get all available roles
     */
    public function getAllRoles()
    {
        return $this->role->all()->pluck('name');
    }

    /**
     * Get basic user data
     */
    public function getUserData($user)
    {
        return [
            'id' => $user->user_id,
            'name' => $user->user_nama,
            'email' => $user->user_email,
            'has_permissions' => $user->permissions->isNotEmpty(),
            'has_roles' => $user->roles->isNotEmpty()
        ];
    }
    public function getAllUsersWithRoles()
    {
        return UserModel::with(['roles', 'permissions'])->get();
    }
}
