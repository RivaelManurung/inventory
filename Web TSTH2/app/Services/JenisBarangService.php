<?php

namespace App\Services;

use App\Http\Resources\JenisBarangResource;
use App\Http\Constant\ApiConstant;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class JenisBarangService
{
    public function getAll($search = '', $perPage = 10)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->get(ApiConstant::BASE_URL . '/jenis-barang',  [
                    'search' => $search,
                    'per_page' => $perPage
                ]);

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to get jenis barang list', [
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal mengambil data jenis barang'
                ];
            }

            // Convert each array item to an object before passing to JenisBarangResource
            $data = collect($responseData['data'])->map(function ($item) {
                return (object)$item;
            });

            return [
                'success' => true,
                'data' => JenisBarangResource::collection($data),
                'meta' => $responseData['meta'] ?? null
            ];
        } catch (\Exception $e) {
            Log::error('Get jenis barang list error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data jenis barang'
            ];
        }
    }

    public function getUpdates($lastUpdate = null, $search = null, $perPage = 10)
{
    try {
        $token = Session::get('jwt_token');
        $response = Http::withToken($token)
            ->withoutRedirecting()
            ->get(ApiConstant::BASE_URL . '/jenis-barang/updates', [
                'last_update' => $lastUpdate,
                'search' => $search,
                'per_page' => $perPage
            ]);

        $responseData = $response->json();

        if (!$response->successful() || !($responseData['success'] ?? false)) {
            Log::error('Failed to get jenis barang updates', [
                'status' => $response->status(),
                'response' => $responseData
            ]);
            return [
                'success' => false,
                'message' => $responseData['message'] ?? 'Gagal mengambil update jenis barang'
            ];
        }

        return [
            'success' => true,
            'data' => JenisBarangResource::collection($responseData['data']),
            'meta' => $responseData['meta'] ?? null,
            'last_update' => now()->toDateTimeString()
        ];
    } catch (\Exception $e) {
        Log::error('Get jenis barang updates error: ' . $e->getMessage());
        return [
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengambil update jenis barang'
        ];
    }
}

    public function create(array $data)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->post(ApiConstant::BASE_URL . '/jenis-barang', $data);

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to create jenis barang', [
                    'status' => $response->status(),
                    'response' => $responseData,
                    'input' => $data
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal membuat jenis barang baru',
                    'errors' => $responseData['errors'] ?? null
                ];
            }

            return [
                'success' => true,
                'data' => new JenisBarangResource($responseData['data']),
                'message' => 'Jenis barang berhasil dibuat'
            ];
        } catch (\Exception $e) {
            Log::error('Create jenis barang error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat jenis barang baru'
            ];
        }
    }

    public function getById($id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->get(ApiConstant::BASE_URL . "/jenis-barang/{$id}");

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Jenis barang not found', [
                    'id' => $id,
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Data jenis barang tidak ditemukan'
                ];
            }

            return [
                'success' => true,
                'data' => new JenisBarangResource($responseData['data'])
            ];
        } catch (\Exception $e) {
            Log::error('Get jenis barang detail error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil detail jenis barang'
            ];
        }
    }

    public function update($id, array $data)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->put(ApiConstant::BASE_URL . "/jenis-barang/{$id}", $data);

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to update jenis barang', [
                    'id' => $id,
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal memperbarui jenis barang',
                    'errors' => $responseData['errors'] ?? null
                ];
            }

            return [
                'success' => true,
                'data' => new JenisBarangResource($responseData['data']),
                'message' => 'Jenis barang berhasil diperbarui'
            ];
        } catch (\Exception $e) {
            Log::error('Update jenis barang error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui jenis barang'
            ];
        }
    }

    public function delete($id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->delete(ApiConstant::BASE_URL . "/jenis-barang/{$id}");

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to delete jenis barang', [
                    'id' => $id,
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal menghapus jenis barang'
                ];
            }

            return [
                'success' => true,
                'message' => 'Jenis barang berhasil dihapus'
            ];
        } catch (\Exception $e) {
            Log::error('Delete jenis barang error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus jenis barang'
            ];
        }
    }

    public function search($query)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withToken($token)
                ->withoutRedirecting()
                ->get(ApiConstant::BASE_URL . "/jenis-barang/search", [
                    'query' => $query
                ]);

            $responseData = $response->json();

            if (!$response->successful() || !($responseData['success'] ?? false)) {
                Log::error('Failed to search jenis barang', [
                    'query' => $query,
                    'status' => $response->status(),
                    'response' => $responseData
                ]);
                return [
                    'success' => false,
                    'message' => $responseData['message'] ?? 'Gagal melakukan pencarian jenis barang'
                ];
            }

            return [
                'success' => true,
                'data' => JenisBarangResource::collection($responseData['data'])
            ];
        } catch (\Exception $e) {
            Log::error('Search jenis barang error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan pencarian jenis barang'
            ];
        }
    }
}