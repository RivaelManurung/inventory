<?php

namespace App\Services;

use App\Http\Repositories\JenisBarangRepository;
use App\Http\Resources\JenisBarangResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class JenisBarangService
{
    protected $repository;

    public function __construct(JenisBarangRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        try {
            $data = $this->repository->getAll();

            return [
                'success' => true,
                'data' => JenisBarangResource::collection($data),
                
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal mengambil data jenis barang',
                'error' => $e->getMessage()
            ];
        }
    }

    public function getById(int $id): array
    {
        try {
            $jenisBarang = $this->repository->findById($id);

            if (!$jenisBarang) {
                return [
                    'success' => false,
                    'message' => 'Jenis barang tidak ditemukan'
                ];
            }

            return [
                'success' => true,
                'data' => new JenisBarangResource($jenisBarang)
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal mengambil data jenis barang',
                'error' => $e->getMessage()
            ];
        }
    }

    public function create(array $data): array
    {
        try {
            $validator = Validator::make($data, [
                'jenisbarang_nama' => 'required|string|unique:tbl_jenisbarang,jenisbarang_nama',
                'jenisbarang_ket' => 'nullable|string'
            ]);
            

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $jenisBarang = $this->repository->create($data);

            return [
                'success' => true,
                'data' => new JenisBarangResource($jenisBarang),
                'message' => 'Jenis barang berhasil ditambahkan'
            ];
        } catch (ValidationException $e) {
            return [
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Validasi gagal'
            ];
        } catch (ValidationException $e) {
            return [
                'success' => false,
                'errors' => $e->validator->errors()->toArray(), // Ambil error dengan cara yang benar
                'message' => 'Validasi gagal'
            ];
        }
        
    }

    public function update(int $id, array $data): array
    {
        try {
            $jenisBarang = $this->repository->findById($id);

            if (!$jenisBarang) {
                return [
                    'success' => false,
                    'message' => 'Jenis barang tidak ditemukan'
                ];
            }

            $validator = Validator::make($data, [
                'nama' => 'sometimes|string|unique:tbl_jenisbarang,jenisbarang_nama,' . $id . ',jenisbarang_id',
                'keterangan' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $this->repository->update($jenisBarang, $data);

            return [
                'success' => true,
                'data' => new JenisBarangResource($jenisBarang->fresh()),
                'message' => 'Jenis barang berhasil diperbarui'
            ];
        } catch (ValidationException $e) {
            return [
                'success' => false,
                'errors' => $e->errors(),
                'message' => 'Validasi gagal'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal memperbarui jenis barang',
                'error' => $e->getMessage()
            ];
        }
    }

    public function delete(int $id): array
    {
        try {
            $jenisBarang = $this->repository->findById($id);

            if (!$jenisBarang) {
                return [
                    'success' => false,
                    'message' => 'Jenis barang tidak ditemukan'
                ];
            }

            if ($this->repository->isUsed($jenisBarang)) {
                return [
                    'success' => false,
                    'message' => 'Jenis barang tidak dapat dihapus karena sedang digunakan'
                ];
            }

            $this->repository->delete($jenisBarang);

            return [
                'success' => true,
                'message' => 'Jenis barang berhasil dihapus'
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal menghapus jenis barang',
                'error' => $e->getMessage()
            ];
        }
    }
}
