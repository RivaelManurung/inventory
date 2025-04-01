<?php

namespace App\Services;

use App\Http\Constant\ApiConstant;
use App\Http\Resources\JenisBarangResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

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
            if (!$token) {
                throw new \Exception('Token tidak tersedia, silakan login kembali');
            }

            // Generate slug from nama
            $slug = Str::slug($nama);

            $requestData = [
                'jenisbarang_nama' => $nama,
                'jenisbarang_slug' => $slug,  // Add slug to request
                'jenisbarang_ket' => $keterangan
            ];

            Log::debug('Create Request Data:', $requestData);

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
                'Content-Type' => 'application/json',
                'Accept' => 'application/json'
            ])->post("{$this->api_url}/jenis-barang", $requestData);

            $responseData = $response->json();

            if ($response->status() === 422) {
                $errorMessages = [];
                if (isset($responseData['errors'])) {
                    foreach ($responseData['errors'] as $field => $messages) {
                        $errorMessages[] = "$field: " . implode(', ', (array)$messages);
                    }
                }
                throw new \Exception(implode(' | ', $errorMessages));
            }

            if ($response->failed()) {
                throw new \Exception($responseData['message'] ?? 'Gagal menambahkan jenis barang');
            }

            return $responseData;
        } catch (\Throwable $th) {
            Log::error('Create Error: ' . $th->getMessage());
            throw new \Exception('Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function update_jenis_barang(int $id, string $nama, string $keterangan = null)
    {
        try {
            $token = Session::get('jwt_token');
            if (!$token) {
                throw new \Exception('Token tidak tersedia, silakan login kembali');
            }

            $requestData = [
                'jenisbarang_nama' => $nama,
                'jenisbarang_ket' => $keterangan
            ];

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/jenis-barang/{$id}", $requestData);

            Log::debug('Update Response:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->failed()) {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? $response->body() ?? 'Gagal memperbarui jenis barang';
                throw new \Exception($errorMessage);
            }

            return new JenisBarangResource($response->json());
        } catch (\Throwable $th) {
            Log::error('Update Error: ' . $th->getMessage());
            throw new \Exception('Terjadi kesalahan: ' . $th->getMessage());
        }
    }

    public function delete_jenis_barang(int $id)
    {
        try {
            $token = Session::get('jwt_token');
            if (!$token) {
                throw new \Exception('Token tidak tersedia, silakan login kembali');
            }

            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/jenis-barang/{$id}"); // Changed from '/delete' to standard REST

            Log::debug('Delete Response:', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->failed()) {
                $errorData = $response->json();
                $errorMessage = $errorData['message'] ?? $response->body() ?? 'Gagal menghapus jenis barang';
                throw new \Exception($errorMessage);
            }

            return $response->json();
        } catch (\Throwable $th) {
            Log::error('Delete Error: ' . $th->getMessage());
            throw new \Exception('Terjadi kesalahan: ' . $th->getMessage());
        }
    }
}
