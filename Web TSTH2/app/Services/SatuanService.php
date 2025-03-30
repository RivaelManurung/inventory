<?php

namespace App\Services;

use App\Http\Resources\SatuanResource;
use App\Http\Constant\ApiConstant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class SatuanService
{
    public function getAll($search = null, $perPage = 10)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->get(ApiConstant::BASE_URL . '/satuan', [
                    'search' => $search,
                    'per_page' => $perPage
                ]);

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to get satuan data', [
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal mengambil data satuan',
                    'errors' => $responseData['errors'] ?? null
                ];
            }

            return [
                'success' => true,
                'data' => SatuanResource::collection($responseData['data']),
                'meta' => $responseData['meta'] ?? null
            ];

        } catch (\Exception $e) {
            Log::error('Get satuan error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data satuan'
            ];
        }
    }

    public function getUpdates($lastUpdate = null, $search = null, $perPage = 10)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->get(ApiConstant::BASE_URL . '/satuan/updates', [
                    'last_update' => $lastUpdate,
                    'search' => $search,
                    'per_page' => $perPage
                ]);

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to get satuan updates', [
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal mengambil update satuan'
                ];
            }

            return [
                'success' => true,
                'data' => SatuanResource::collection($responseData['data']),
                'meta' => $responseData['meta'] ?? null,
                'last_update' => now()->toDateTimeString()
            ];

        } catch (\Exception $e) {
            Log::error('Get satuan updates error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil update satuan'
            ];
        }
    }

    public function create(array $data)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->post(ApiConstant::BASE_URL . '/satuan', $data);

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to create satuan', [
                    'status' => $response->status(),
                    'response' => $responseData,
                    'input' => $data
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal membuat satuan baru',
                    'errors' => $responseData['errors'] ?? null
                ];
            }

            return [
                'success' => true,
                'data' => new SatuanResource($responseData['data']),
                'message' => 'Satuan berhasil dibuat'
            ];

        } catch (\Exception $e) {
            Log::error('Create satuan error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat satuan baru'
            ];
        }
    }

    public function getById($id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->get(ApiConstant::BASE_URL . "/satuan/{$id}");

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Satuan not found', [
                    'id' => $id,
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Data satuan tidak ditemukan'
                ];
            }

            return [
                'success' => true,
                'data' => new SatuanResource($responseData['data'])
            ];

        } catch (\Exception $e) {
            Log::error('Get satuan detail error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil detail satuan'
            ];
        }
    }

    public function update($id, array $data)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->put(ApiConstant::BASE_URL . "/satuan/{$id}", $data);

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to update satuan', [
                    'id' => $id,
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal memperbarui satuan',
                    'errors' => $responseData['errors'] ?? null
                ];
            }

            return [
                'success' => true,
                'data' => new SatuanResource($responseData['data']),
                'message' => 'Satuan berhasil diperbarui'
            ];

        } catch (\Exception $e) {
            Log::error('Update satuan error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui satuan'
            ];
        }
    }

    public function delete($id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->delete(ApiConstant::BASE_URL . "/satuan/{$id}");

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to delete satuan', [
                    'id' => $id,
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal menghapus satuan'
                ];
            }

            return [
                'success' => true,
                'message' => 'Satuan berhasil dihapus'
            ];

        } catch (\Exception $e) {
            Log::error('Delete satuan error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus satuan'
            ];
        }
    }

    public function search($query)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->get(ApiConstant::BASE_URL . "/satuan/search/{$query}");

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to search satuan', [
                    'query' => $query,
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal melakukan pencarian satuan'
                ];
            }

            return [
                'success' => true,
                'data' => SatuanResource::collection($responseData['data'])
            ];

        } catch (\Exception $e) {
            Log::error('Search satuan error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan pencarian satuan'
            ];
        }
    }
}