<?php

namespace App\Services;

use App\Http\Resources\SatuanResource;
use Illuminate\Support\Facades\Log;

class SatuanService
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function getAll($search = null, $perPage = 10)
    {
        try {
            $params = [
                'search' => $search,
                'per_page' => $perPage
            ];
            
            $response = $this->authService->get('/satuans', $params);
            
            if (!$response['success']) {
                Log::error('Failed to get satuan data', ['response' => $response]);
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Failed to get satuan data',
                    'errors' => $response['errors'] ?? null
                ];
            }

            return [
                'success' => true,
                'data' => SatuanResource::collection($response['data']),
                'meta' => $response['meta'] ?? null
            ];

        } catch (\Exception $e) {
            Log::error('Get satuan error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil data satuan'
            ];
        }
    }

    public function create(array $data)
    {
        try {
            $response = $this->authService->post('/satuans', $data);
            
            if (!$response['success']) {
                Log::error('Failed to create satuan', ['response' => $response, 'input' => $data]);
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Gagal membuat satuan baru',
                    'errors' => $response['errors'] ?? null
                ];
            }

            return [
                'success' => true,
                'data' => new SatuanResource($response['data']),
                'message' => 'Satuan berhasil dibuat'
            ];

        } catch (\Exception $e) {
            Log::error('Create satuan error: ' . $e->getMessage(), ['input' => $data]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat membuat satuan baru'
            ];
        }
    }

    public function getById($id)
    {
        try {
            $response = $this->authService->get("/satuans/{$id}");
            
            if (!$response['success']) {
                Log::warning('Satuan not found', ['id' => $id, 'response' => $response]);
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Data satuan tidak ditemukan'
                ];
            }

            return [
                'success' => true,
                'data' => new SatuanResource($response['data'])
            ];

        } catch (\Exception $e) {
            Log::error('Get satuan detail error: ' . $e->getMessage(), ['id' => $id]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengambil detail satuan'
            ];
        }
    }

    public function update($id, array $data)
    {
        try {
            $response = $this->authService->put("/satuans/{$id}", $data);
            
            if (!$response['success']) {
                Log::error('Failed to update satuan', ['id' => $id, 'response' => $response]);
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Gagal memperbarui satuan',
                    'errors' => $response['errors'] ?? null
                ];
            }

            return [
                'success' => true,
                'data' => new SatuanResource($response['data']),
                'message' => 'Satuan berhasil diperbarui'
            ];

        } catch (\Exception $e) {
            Log::error('Update satuan error: ' . $e->getMessage(), ['id' => $id, 'input' => $data]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui satuan'
            ];
        }
    }

    public function delete($id)
    {
        try {
            $response = $this->authService->delete("/satuans/{$id}");
            
            if (!$response['success']) {
                Log::error('Failed to delete satuan', ['id' => $id, 'response' => $response]);
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Gagal menghapus satuan'
                ];
            }

            return [
                'success' => true,
                'message' => 'Satuan berhasil dihapus'
            ];

        } catch (\Exception $e) {
            Log::error('Delete satuan error: ' . $e->getMessage(), ['id' => $id]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus satuan'
            ];
        }
    }

    public function search($query)
    {
        try {
            $response = $this->authService->get("/satuans/search/{$query}");
            
            if (!$response['success']) {
                Log::error('Failed to search satuan', ['query' => $query, 'response' => $response]);
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Gagal melakukan pencarian satuan'
                ];
            }

            return [
                'success' => true,
                'data' => SatuanResource::collection($response['data'])
            ];

        } catch (\Exception $e) {
            Log::error('Search satuan error: ' . $e->getMessage(), ['query' => $query]);
            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat melakukan pencarian satuan'
            ];
        }
    }
}