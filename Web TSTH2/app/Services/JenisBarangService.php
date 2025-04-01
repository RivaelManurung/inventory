<?php

namespace App\Services;

use App\Http\Constant\ApiConstant;
use App\Http\Resources\JenisBarangResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class JenisBarangService
{
    private $api_url;

    public function __construct()
    {
        $this->api_url = ApiConstant::BASE_URL;
    }

    public function get_all_jenis_barang()
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/jenis-barang");

            $result = $response->json();
            
            if ($response->failed()) {
                return collect();
            }
            
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            
            return JenisBarangResource::collection($collection);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_jenis_barang(string $nama, string $keterangan = null)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/jenis-barang/create", [
                'jenisbarang_nama' => $nama,
                'jenisbarang_ket' => $keterangan
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new JenisBarangResource($result);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_jenis_barang(int $id, string $nama, string $keterangan = null)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/jenis-barang/{$id}/edit", [
                'jenisbarang_nama' => $nama,
                'jenisbarang_ket' => $keterangan
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new JenisBarangResource($result);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_jenis_barang(int $id)
    {
        try {
            $token = Session::get('jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/jenis-barang/{$id}/delete");

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return $result;
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }
}