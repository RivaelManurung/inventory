<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class UserAccessService
{
    private $api_url;

    public function __construct()
    {
        $this->api_url = config('app.api_url');
    }

    /**
     * Get user permissions
     */
    public function getUserPermissions($userId = null): array
    {
        try {
            $token = Session::get('jwt_token');
            $url = $userId 
                ? "{$this->api_url}/user/permissions/{$userId}"
                : "{$this->api_url}/user/permissions";

            $response = Http::withToken($token)->get($url);

            if ($response->failed()) {
                throw new \Exception($response->json()['message'] ?? 'Failed to fetch permissions');
            }

            return $response->json()['data'] ?? [];
            
        } catch (\Exception $e) {
            Log::error('UserAccessService - getUserPermissions: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Assign permission to user
     */
    public function givePermission(int $userId, string $permission): array
    {
        try {
            $response = Http::withToken(Session::get('jwt_token'))
                ->post("{$this->api_url}/user/give-permission", [
                    'user_id' => $userId,
                    'permission' => $permission
                ]);

            if ($response->failed()) {
                throw new \Exception($response->json()['message'] ?? 'Failed to assign permission');
            }

            return $response->json()['data'] ?? [];
            
        } catch (\Exception $e) {
            Log::error('UserAccessService - givePermission: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Revoke permission from user
     */
    public function revokePermission(int $userId, string $permission): array
    {
        try {
            $response = Http::withToken(Session::get('jwt_token'))
                ->post("{$this->api_url}/user/revoke-permission", [
                    'user_id' => $userId,
                    'permission' => $permission
                ]);

            if ($response->failed()) {
                throw new \Exception($response->json()['message'] ?? 'Failed to revoke permission');
            }

            return $response->json()['data'] ?? [];
            
        } catch (\Exception $e) {
            Log::error('UserAccessService - revokePermission: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Assign role to user
     */
    public function assignRole(int $userId, string $role): array
    {
        try {
            $response = Http::withToken(Session::get('jwt_token'))
                ->post("{$this->api_url}/user/assign-role", [
                    'user_id' => $userId,
                    'role' => $role
                ]);

            if ($response->failed()) {
                throw new \Exception($response->json()['message'] ?? 'Failed to assign role');
            }

            return $response->json()['data'] ?? [];
            
        } catch (\Exception $e) {
            Log::error('UserAccessService - assignRole: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove role from user
     */
    public function removeRole(int $userId, string $role): array
    {
        try {
            $response = Http::withToken(Session::get('jwt_token'))
                ->post("{$this->api_url}/user/remove-role", [
                    'user_id' => $userId,
                    'role' => $role
                ]);

            if ($response->failed()) {
                throw new \Exception($response->json()['message'] ?? 'Failed to remove role');
            }

            return $response->json()['data'] ?? [];
            
        } catch (\Exception $e) {
            Log::error('UserAccessService - removeRole: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get accessible routes for user
     */
    public function getAccessibleRoutes($userId = null): array
    {
        try {
            $token = Session::get('jwt_token');
            $url = $userId 
                ? "{$this->api_url}/user/accessible-routes/{$userId}"
                : "{$this->api_url}/user/accessible-routes";

            $response = Http::withToken($token)->get($url);

            if ($response->failed()) {
                throw new \Exception($response->json()['message'] ?? 'Failed to fetch accessible routes');
            }

            return $response->json()['data'] ?? [];
            
        } catch (\Exception $e) {
            Log::error('UserAccessService - getAccessibleRoutes: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get full access information
     */
    public function getFullAccessInfo($userId = null): array
    {
        try {
            $token = Session::get('jwt_token');
            $url = $userId 
                ? "{$this->api_url}/user/full-access-info/{$userId}"
                : "{$this->api_url}/user/full-access-info";

            $response = Http::withToken($token)->get($url);

            if ($response->failed()) {
                throw new \Exception($response->json()['message'] ?? 'Failed to fetch access info');
            }

            return $response->json()['data'] ?? [];
            
        } catch (\Exception $e) {
            Log::error('UserAccessService - getFullAccessInfo: ' . $e->getMessage());
            throw $e;
        }
    }
}