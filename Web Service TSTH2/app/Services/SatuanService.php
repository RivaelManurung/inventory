<?php

namespace App\Services;

use App\Http\Repositories\SatuanRepository;
use App\Models\Satuan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class SatuanService
{
    protected $satuanRepository;

    public function __construct(SatuanRepository $satuanRepository)
    {
        $this->satuanRepository = $satuanRepository;
    }

    public function getAllSatuans(array $params = [])
    {
        try {
            $search = $params['search'] ?? null;
            $perPage = $params['per_page'] ?? 10;

            $satuans = $this->satuanRepository->getAll($search, $perPage);

            return [
                'success' => true,
                'data' => $satuans,
                'message' => 'Data satuan berhasil diambil'
            ];

        } catch (Exception $e) {
            Log::error('Error getting satuan data: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gagal mengambil data satuan',
                'error' => $e->getMessage()
            ];
        }
    }

    public function getSatuanById($id)
    {
        try {
            $satuan = $this->satuanRepository->findById($id);

            if (!$satuan) {
                return [
                    'success' => false,
                    'message' => 'Satuan tidak ditemukan'
                ];
            }

            return [
                'success' => true,
                'data' => $satuan,
                'message' => 'Data satuan berhasil diambil'
            ];

        } catch (Exception $e) {
            Log::error('Error getting satuan by ID: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gagal mengambil data satuan',
                'error' => $e->getMessage()
            ];
        }
    }

    public function createSatuan(array $data)
    {
        DB::beginTransaction();
        try {
            $satuan = $this->satuanRepository->create($data);

            DB::commit();
            return [
                'success' => true,
                'data' => $satuan,
                'message' => 'Satuan berhasil ditambahkan'
            ];

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error creating satuan: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gagal menambahkan satuan',
                'error' => $e->getMessage()
            ];
        }
    }

    public function updateSatuan($id, array $data)
    {
        DB::beginTransaction();
        try {
            $satuan = $this->satuanRepository->findById($id);

            if (!$satuan) {
                return [
                    'success' => false,
                    'message' => 'Satuan tidak ditemukan'
                ];
            }

            $updatedSatuan = $this->satuanRepository->update($satuan, $data);

            DB::commit();
            return [
                'success' => true,
                'data' => $updatedSatuan,
                'message' => 'Satuan berhasil diperbarui'
            ];

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error updating satuan: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gagal memperbarui satuan',
                'error' => $e->getMessage()
            ];
        }
    }

    public function deleteSatuan($id)
    {
        DB::beginTransaction();
        try {
            $satuan = $this->satuanRepository->findById($id);

            if (!$satuan) {
                return [
                    'success' => false,
                    'message' => 'Satuan tidak ditemukan'
                ];
            }

            // Check if satuan is used in barang
            if ($this->satuanRepository->isUsedInBarang($satuan)) {
                return [
                    'success' => false,
                    'message' => 'Satuan tidak dapat dihapus karena sudah digunakan pada data barang'
                ];
            }

            $this->satuanRepository->delete($satuan);

            DB::commit();
            return [
                'success' => true,
                'message' => 'Satuan berhasil dihapus'
            ];

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Error deleting satuan: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Gagal menghapus satuan',
                'error' => $e->getMessage()
            ];
        }
    }
}