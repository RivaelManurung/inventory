<?php
namespace App\Services;

use App\Http\Constant\ApiConstant;
use App\Http\Constant\TokenConstant;
use App\Http\Resources\SatuanResource;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class SatuanService
{
    private $api_url;
    private $token;

    public function __construct(TokenConstant $token)
    {
        $this->api_url = ApiConstant::BASE_URL;
    }

    public function get_all_satuan()
    {
        try {
            $token = Session::get(key: 'jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get("{$this->api_url}/satuan");

            $result = $response->json();
            if ($response->failed()) {
                return collect();
            }
            $collection = collect($result['data'])->map(function ($item) {
                return (object) $item;
            });
            return SatuanResource::collection($collection);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function create_satuan(string $nama, string $keterangan = null)
    {
        try {
            $token = Session::get(key: 'jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->post("{$this->api_url}/satuan/create", [
                'nama' => $nama,
                'keterangan' => $keterangan
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new SatuanResource($result);

        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function update_satuan(int $id, string $nama, string $keterangan = null)
    {
        try {
            $token = Session::get(key: 'jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->put("{$this->api_url}/satuan/{$id}/edit", [
                'nama' => $nama,
                'keterangan' => $keterangan
            ]);

            $result = $response->json();

            if ($response->failed()) {
                throw new \Exception($result['message']);
            }

            return new SatuanResource($result);
        } catch (\Throwable $th) {
            throw new \Exception($th->getMessage());
        }
    }

    public function delete_satuan(int $id)
    {
        try {
            $token = Session::get(key: 'jwt_token');
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->delete("{$this->api_url}/satuan/{$id}/delete");

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