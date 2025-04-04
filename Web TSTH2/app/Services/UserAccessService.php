<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Http\Constant\ApiConstant;

class UserAccessService
{
    private $api_url;

    public function __construct()
    {
        $this->api_url = ApiConstant::BASE_URL;
    }

    public function getAccessibleRoutes($userId = null)
    {
        try {
            $token = Session::get('jwt_token');
            $url = "{$this->api_url}/access-control/user/{$userId}/accessible-routes";

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get($url);

            if ($response->failed()) {
                return collect();
            }

            $result = $response->json();
            return collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
        } catch (\Throwable $th) {
            Log::error('Failed to get accessible routes: ' . $th->getMessage());
            return collect();
        }
    }

    public function assignRole(int $userId, string $role)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/access-control/assign-role", [
                'user_id' => $userId,
                'role' => $role
            ]);

            if ($response->failed()) {
                return (object) [];
            }

            $result = $response->json();
            return (object) ($result['data'] ?? []);
        } catch (\Throwable $th) {
            Log::error('Failed to assign role: ' . $th->getMessage());
            return (object) [];
        }
    }

    public function getFullAccessInfo($userId = null)
    {
        try {
            $token = Session::get('jwt_token');
            $url = "{$this->api_url}/access-control/user/{$userId}/full-access-info";

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get($url);

            if ($response->failed()) {
                return (object) [
                    'users' => collect(),
                    'all_roles' => collect(),
                    'all_permissions' => collect()
                ];
            }

            $result = $response->json();

            // Ensure proper data structure for both web and API
            return (object) [
                'users' => collect($result['data']['users'] ?? [])->map(function ($item) {
                    return (object) [
                        'id' => $item['id'] ?? $item['user_id'] ?? null,
                        'name' => $item['name'] ?? $item['user_nama'] ?? null,
                        'email' => $item['email'] ?? $item['user_email'] ?? null,
                        'roles' => $item['roles'] ?? [$item['role'] ?? null]
                    ];
                }),
                'all_roles' => collect($result['data']['all_roles'] ?? []),
                'all_permissions' => collect($result['data']['all_permissions'] ?? [])
            ];
        } catch (\Throwable $th) {
            Log::error('Failed to get full access info: ' . $th->getMessage());
            return (object) [
                'users' => collect(),
                'all_roles' => collect(),
                'all_permissions' => collect()
            ];
        }
    }

    public function givePermission(int $userId, string $permission)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/access-control/give-permission", [
                'user_id' => $userId,
                'permission' => $permission
            ]);

            if ($response->failed()) {
                return (object) [];
            }

            $result = $response->json();
            return (object) ($result['data'] ?? []);
        } catch (\Throwable $th) {
            Log::error('Failed to give permission: ' . $th->getMessage());
            return (object) [];
        }
    }

    public function getUserPermissions($userId = null)
    {
        try {
            $token = Session::get('jwt_token');
            $url = "{$this->api_url}/access-control/user/{$userId}/permissions";

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get($url);

            if ($response->failed()) {
                return collect();
            }

            $result = $response->json();
            return collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
        } catch (\Throwable $th) {
            Log::error('Failed to get user permissions: ' . $th->getMessage());
            return collect();
        }
    }

    public function removeRole(int $userId, string $role)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/access-control/remove-role", [
                'user_id' => $userId,
                'role' => $role
            ]);

            if ($response->failed()) {
                return (object) [];
            }

            $result = $response->json();
            return (object) ($result['data'] ?? []);
        } catch (\Throwable $th) {
            Log::error('Failed to remove role: ' . $th->getMessage());
            return (object) [];
        }
    }

    public function revokePermission(int $userId, string $permission)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/access-control/revoke-permission", [
                'user_id' => $userId,
                'permission' => $permission
            ]);

            if ($response->failed()) {
                return (object) [];
            }

            $result = $response->json();
            return (object) ($result['data'] ?? []);
        } catch (\Throwable $th) {
            Log::error('Failed to revoke permission: ' . $th->getMessage());
            return (object) [];
        }
    }

    public function getAllUsers()
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/access-control/users");

            if ($response->failed()) {
                return collect();
            }

            $result = $response->json();
            return collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
        } catch (\Throwable $th) {
            Log::error('Failed to get users: ' . $th->getMessage());
            return collect();
        }
    }
}
