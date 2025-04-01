<?php

namespace App\Services;

use App\Http\Constant\ApiConstant;
use App\Http\Resources\SatuanResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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
            ])->delete("{$this->api_url}/satuan/{$id}");

            if ($response->failed()) {
                $result = $response->json();
                throw new \Exception($result['message'] ?? 'Failed to delete satuan');
            }

            return true;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}
