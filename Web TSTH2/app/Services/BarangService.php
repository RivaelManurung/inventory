<?php

namespace App\Services;

use App\Http\Constant\ApiConstant;
use App\Http\Resources\BarangResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class BarangService
{
    private $api_url;

    public function __construct()
    {
        $this->api_url = ApiConstant::BASE_URL;
    }

    public function getAllBarang()
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/barang");

            $result = $response->json();
            
            if ($response->failed()) {
                return collect();
            }
            
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            
            return BarangResource::collection($collection);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function getDetailBarang(int $id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/barang/{$id}");

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return (object) $result['data'];
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function createBarang(array $data)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/barang", [
                'barang_nama' => $data['barang_nama'],
                'barang_harga' => $data['barang_harga'],
                'satuan_id' => $data['satuan_id'],
                'jenisbarang_id' => $data['jenisbarang_id'],
                'klasifikasi_barang' => $data['klasifikasi_barang']
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return (object) $result['data'];
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function updateBarang(array $data, int $id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/barang/{$id}", [
                'barang_nama' => $data['barang_nama'] ?? null,
                'barang_harga' => $data['barang_harga'] ?? null,
                'satuan_id' => $data['satuan_id'] ?? null,
                'jenisbarang_id' => $data['jenisbarang_id'] ?? null,
                'klasifikasi_barang' => $data['klasifikasi_barang'] ?? null
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return (object) $result['data'];
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function deleteBarang(int $id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/barang/{$id}");

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function generateBarangBarcode(int $id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/barang/{$id}/barcode");

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result['data'];
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function downloadBarangBarcode(int $id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/barang/{$id}/download-barcode");

            if ($response->failed()) {
                $result = $response->json();
                throw new \Exception($result['message']);
            }

            return $response;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}