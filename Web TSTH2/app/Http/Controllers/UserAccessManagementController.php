<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserAccessService;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserAccessManagementController extends Controller
{
    private $userAccessService;
    private $authService;

    public function __construct(
        UserAccessService $userAccessService,
        AuthService $authService
    ) {
        $this->userAccessService = $userAccessService;
        $this->authService = $authService;
    }

    /**
     * Display user access management dashboard
     */
    public function index()
    {
        try {
            $currentUser = $this->authService->getAuthenticatedUser();
            $accessInfo = $this->userAccessService->getFullAccessInfo();
            
            return view('Admin.Role.index', [
                'currentUser' => $currentUser,
                'accessInfo' => $accessInfo
            ]);
            
        } catch (\Exception $e) {
            report($e);
            return redirect()
                ->back()
                ->with('error', 'Failed to load access management: ' . $e->getMessage());
        }
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'role' => 'required|string|exists:roles,name'
            ]);

            $result = $this->userAccessService->assignRole(
                $validated['user_id'],
                $validated['role']
            );
            
            return redirect()
                ->back()
                ->with('success', 'Role assigned successfully')
                ->with('data', $result);
                
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            report($e);
            return redirect()
                ->back()
                ->with('error', 'Failed to assign role: ' . $e->getMessage());
        }
    }

    /**
     * Remove role from user
     */
    public function removeRole(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'role' => 'required|string|exists:roles,name'
            ]);

            $result = $this->userAccessService->removeRole(
                $validated['user_id'],
                $validated['role']
            );
            
            return redirect()
                ->back()
                ->with('success', 'Role removed successfully')
                ->with('data', $result);
                
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            report($e);
            return redirect()
                ->back()
                ->with('error', 'Failed to remove role: ' . $e->getMessage());
        }
    }

    /**
     * Grant permission to user
     */
    public function givePermission(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'permission' => 'required|string|exists:permissions,name'
            ]);

            $result = $this->userAccessService->givePermission(
                $validated['user_id'],
                $validated['permission']
            );
            
            return redirect()
                ->back()
                ->with('success', 'Permission granted successfully')
                ->with('data', $result);
                
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            report($e);
            return redirect()
                ->back()
                ->with('error', 'Failed to grant permission: ' . $e->getMessage());
        }
    }

    /**
     * Revoke permission from user
     */
    public function revokePermission(Request $request)
    {
        try {
            $validated = $request->validate([
                'user_id' => 'required|integer|exists:users,id',
                'permission' => 'required|string|exists:permissions,name'
            ]);

            $result = $this->userAccessService->revokePermission(
                $validated['user_id'],
                $validated['permission']
            );
            
            return redirect()
                ->back()
                ->with('success', 'Permission revoked successfully')
                ->with('data', $result);
                
        } catch (ValidationException $e) {
            return redirect()
                ->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            report($e);
            return redirect()
                ->back()
                ->with('error', 'Failed to revoke permission: ' . $e->getMessage());
        }
    }

    /**
     * Get user permissions (API)
     */
    public function getUserPermissions($userId = null): JsonResponse
    {
        try {
            $permissions = $this->userAccessService->getUserPermissions($userId);
            
            return response()->json([
                'success' => true,
                'data' => $permissions
            ]);
            
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to get user permissions',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get accessible routes for user (API)
     */
    public function getAccessibleRoutes($userId = null): JsonResponse
    {
        try {
            $routes = $this->userAccessService->getAccessibleRoutes($userId);
            
            return response()->json([
                'success' => true,
                'data' => $routes
            ]);
            
        } catch (\Exception $e) {
            report($e);
            return response()->json([
                'success' => false,
                'message' => 'Failed to get accessible routes',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}