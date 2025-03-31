<?php

namespace App\Http\Repositories;

use App\Models\JenisBarang;
use Illuminate\Pagination\LengthAwarePaginator;

class JenisBarangRepository
{
    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = JenisBarang::query();

        if ($search) {
            $query->where('nama', 'like', '%'.$search.'%')
                  ->orWhere('keterangan', 'like', '%'.$search.'%');
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?JenisBarang
    {
        return JenisBarang::find($id);
    }

    public function create(array $data): JenisBarang
    {
        return JenisBarang::create($data);
    }

    public function update(JenisBarang $jenisBarang, array $data): bool
    {
        return $jenisBarang->update($data);
    }

    public function delete(JenisBarang $jenisBarang): bool
    {
        return $jenisBarang->delete();
    }

    public function isUsed(JenisBarang $jenisBarang): bool
    {
        return $jenisBarang->barangs()->exists();
    }
}