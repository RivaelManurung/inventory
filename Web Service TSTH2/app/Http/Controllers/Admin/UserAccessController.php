<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserAccessService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserAccessController extends Controller
{
    protected $userAccessService;

    public function __construct(UserAccessService $userAccessService)
    {
        $this->userAccessService = $userAccessService;
        $this->middleware(['auth:api', 'role:superadmin'])->except([
            'getUserPermissions',
            'getAccessibleRoutes',
            'getFullAccessInfo'
        ]);
    }

    public function getAllUsers(): JsonResponse
    {
        $result = $this->userAccessService->getAllUsers();
        return $this->jsonResponse($result);
    }
    public function getUserPermissions($userId = null): JsonResponse
    {
        $result = $this->userAccessService->getUserPermissions($userId);
        return $this->jsonResponse($result);
    }

    public function givePermission(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|exists:permissions,name'
        ]);

        $result = $this->userAccessService->managePermission(
            $request->user_id,
            $request->permission,
            'give'
        );

        return $this->jsonResponse($result);
    }

    public function revokePermission(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'permission' => 'required|exists:permissions,name'
        ]);

        $result = $this->userAccessService->managePermission(
            $request->user_id,
            $request->permission,
            'revoke'
        );

        return $this->jsonResponse($result);
    }

    public function assignRole(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name'
        ]);

        $result = $this->userAccessService->manageRole(
            $request->user_id,
            $request->role,
            'assign'
        );

        return $this->jsonResponse($result);
    }

    public function removeRole(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name'
        ]);

        $result = $this->userAccessService->manageRole(
            $request->user_id,
            $request->role,
            'remove'
        );

        return $this->jsonResponse($result);
    }

    public function getAccessibleRoutes($userId = null): JsonResponse
    {
        $result = $this->userAccessService->getAccessibleRoutes($userId);
        return $this->jsonResponse($result);
    }

    public function getFullAccessInfo($userId = null): JsonResponse
    {
        $result = $this->userAccessService->getFullAccessInfo($userId);
        return $this->jsonResponse($result);
    }

    protected function jsonResponse(array $result): JsonResponse
    {
        $status = $result['success'] ? 200 : ($result['status'] ?? 400);
        return response()->json($result, $status);
    }
}
