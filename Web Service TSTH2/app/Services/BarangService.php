<?php

namespace App\Services;

use App\Http\Repositories\BarangRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Milon\Barcode\DNS1D;

class BarangService
{
    protected $barang_repository;

    public function __construct(BarangRepository $barangRepository)
    {
        $this->barang_repository = $barangRepository;
    }

    public function getAllBarang()
    {
        try {
            // Specify only the relationships that exist
            $barangs = $this->barang_repository->getAllWithRelations(['satuan', 'jenisBarang', 'user']);

            if ($barangs->isEmpty()) {
                throw new \Exception('No barang data available');
            }

            return $barangs;
        } catch (\Throwable $th) {
            throw new \Exception('Failed to get barang data: ' . $th->getMessage());
        }
    }

    public function getDetailBarang(int $id)
    {
        try {
            // Specify only the relationships that exist
            $barang = $this->barang_repository->getByIdWithRelations($id, ['satuan', 'jenisBarang', 'user']);

            if (!$barang) {
                throw new \Exception('Barang not found');
            }

            return $barang;
        } catch (\Throwable $th) {
            throw new \Exception('Failed to get barang detail: ' . $th->getMessage());
        }
    }

    public function createBarang(array $data)
    {
        try {
            $data['barang_kode'] = 'BRG-' . str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
            $data['barang_slug'] = Str::slug($data['barang_nama']);
            $data['user_id'] = $data['user_id'] ?? Auth::id();

            // Remove created_by if it's causing issues
            unset($data['created_by']);

            return $this->barang_repository->create($data);
        } catch (\Throwable $th) {
            throw new \Exception('Failed to create barang: ' . $th->getMessage());
        }
    }

    public function updateBarang(array $data, int $id)
    {
        try {
            if (isset($data['barang_nama'])) {
                $data['barang_slug'] = Str::slug($data['barang_nama']);
            }

            // Remove updated_by if it's causing issues
            unset($data['updated_by']);

            return $this->barang_repository->update($data, $id);
        } catch (\Throwable $th) {
            throw new \Exception('Failed to update barang: ' . $th->getMessage());
        }
    }

    public function deleteBarang(int $id)
    {
        try {
            return $this->barang_repository->delete($id);
        } catch (\Throwable $th) {
            throw new \Exception('Failed to delete barang: ' . $th->getMessage());
        }
    }

    public function generateBarcodeForDownload(string $barang_kode)
    {
        try {
            $dns = new DNS1D();
            return [
                'image' => $dns->getBarcodePNG($barang_kode, 'C128'),
                'barang_kode' => $barang_kode
            ];
        } catch (\Throwable $th) {
            throw new \Exception('Failed to generate barcode: ' . $th->getMessage());
        }
    }
}
