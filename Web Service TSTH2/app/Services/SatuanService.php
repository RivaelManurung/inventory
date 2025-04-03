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
            $satuans = $this->satuanRepository->getAll();

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
            // Generate slug from satuan_nama
            $data['satuan_slug'] = \Illuminate\Support\Str::slug($data['satuan_nama']);

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
            // Coba approach pertama
            $satuan = $this->satuanRepository->findById($id);
            
            if (!$satuan) {
                return [
                    'success' => false,
                    'message' => 'Satuan tidak ditemukan',
                    'error' => 'NOT_FOUND'
                ];
            }
            return [
                'success' => true,
                'message' => 'Satuan berhasil dihapus'
            ];
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Delete Satuan Error', [
                'id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'message' => 'Gagal menghapus satuan: ' . $e->getMessage(),
                'error' => $e->getMessage(),
                'error_type' => get_class($e)
            ];
        }
    }
}
