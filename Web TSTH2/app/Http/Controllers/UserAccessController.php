<?php

namespace App\Http\Controllers;

use App\Services\UserAccessService;
use Illuminate\Http\Request;

class UserAccessController extends Controller
{
    protected $userAccessService;

    public function __construct(UserAccessService $userAccessService)
    {
        $this->userAccessService = $userAccessService;
    }

    /**
     * Display the user access management page
     */
    public function index()
    {
        $accessData = $this->userAccessService->getFullAccessInfo();

        // Debug the data being sent to the view
        logger()->debug('Data sent to view:', [
            'users_count' => $accessData->users->count(),
            'roles_count' => $accessData->all_roles->count(),
            'permissions_count' => $accessData->all_permissions->count()
        ]);

        return view('Admin.Role.index', [
            'users' => $accessData->users,
            'all_roles' => $accessData->all_roles,
            'all_permissions' => $accessData->all_permissions
        ]);
    }

    /**
     * Get all users (admin only)
     */
    public function getAllUsers()
    {
        $result = $this->userAccessService->getAllUsers();
        return response()->json($result);
    }

    /**
     * Get user permissions
     */
    public function getUserPermissions($userId = null)
    {
        $result = $this->userAccessService->getUserPermissions($userId);
        return response()->json($result);
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'role' => 'required|string|exists:roles,name'
        ]);

        $result = $this->userAccessService->assignRole(
            $validated['user_id'],
            $validated['role']
        );

        return back()->with('success', 'Role assigned successfully');
    }

    /**
     * Remove role from user
     */
    public function removeRole(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'role' => 'required|string|exists:roles,name'
        ]);

        $result = $this->userAccessService->removeRole(
            $validated['user_id'],
            $validated['role']
        );

        return back()->with('success', 'Role removed successfully');
    }

    /**
     * Give permission to user
     */
    public function givePermission(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'permission' => 'required|string|exists:permissions,name'
        ]);

        $result = $this->userAccessService->givePermission(
            $validated['user_id'],
            $validated['permission']
        );

        return back()->with('success', 'Permission granted successfully');
    }

    /**
     * Revoke permission from user
     */
    public function revokePermission(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'permission' => 'required|string|exists:permissions,name'
        ]);

        $result = $this->userAccessService->revokePermission(
            $validated['user_id'],
            $validated['permission']
        );

        return back()->with('success', 'Permission revoked successfully');
    }

    /**
     * Get accessible routes for user (for API)
     */
    public function getAccessibleRoutes($userId = null)
    {
        $routes = $this->userAccessService->getAccessibleRoutes($userId);
        return response()->json($routes);
    }
}
