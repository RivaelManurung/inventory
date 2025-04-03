<?php

namespace App\Services;

use App\Http\Constant\ApiConstant;
use App\Http\Resources\SatuanResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class SatuanService
{
    private $api_url;

    public function __construct()
    {
        $this->api_url = ApiConstant::BASE_URL;
    }

    public function get_all_satuan()
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/satuan");

            if ($response->failed()) {
                return collect();
            }

            $result = $response->json();
            return collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_satuan(string $nama, string $keterangan = null)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/satuan", [
                'satuan_nama' => $nama,
                'satuan_keterangan' => $keterangan
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to create satuan');
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_satuan(int $id, string $nama, string $keterangan = null)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/satuan/{$id}", [
                'satuan_nama' => $nama,
                'satuan_keterangan' => $keterangan
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to update satuan');
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_satuan(int $id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Accept' => 'application/json',
            ])->delete("{$this->api_url}/satuan/{$id}");

            // More detailed response handling
            if ($response->failed()) {
                $error = $response->json();
                Log::error('Delete Satuan Failed', [
                    'id' => $id,
                    'status' => $response->status(),
                    'error' => $error
                ]);
                throw new \Exception($error['message'] ?? 'Failed to delete satuan');
            }

            $result = $response->json();

            // Verify the deletion was actually successful
            if (!isset($result['success']) || $result['success'] !== true) {
                throw new \Exception($result['message'] ?? 'Deletion not confirmed by API');
            }

            return true;
        } catch (\Throwable $th) {
            Log::error('Delete Satuan Error', [
                'id' => $id,
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ]);
            throw $th;
        }
    }
}
