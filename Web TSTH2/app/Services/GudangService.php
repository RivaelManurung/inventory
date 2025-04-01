<?php

namespace App\Services;

use App\Http\Constant\ApiConstant;
use App\Http\Resources\GudangResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class GudangService
{
    private $api_url;

    public function __construct()
    {
        $this->api_url = ApiConstant::BASE_URL;
    }

    public function get_all_gudang()
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/gudang");

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

    public function create_gudang(string $nama, string $deskripsi = null)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/gudang", [
                'gudang_nama' => $nama,
                'gudang_deskripsi' => $deskripsi
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to create gudang');
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_gudang(int $id, string $nama, string $deskripsi = null)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/gudang/{$id}", [
                'gudang_nama' => $nama,
                'gudang_deskripsi' => $deskripsi
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message'] ?? 'Failed to update gudang');
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_gudang(int $id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/gudang/{$id}");

            if ($response->failed()) {
                $result = $response->json();
                throw new \Exception($result['message'] ?? 'Failed to delete gudang');
            }

            return true;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}