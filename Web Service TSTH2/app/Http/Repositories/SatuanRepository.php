<?php

namespace App\Http\Repositories;

use App\Models\Satuan;
use Illuminate\Pagination\LengthAwarePaginator;

class SatuanRepository
{
    public function getAll(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = Satuan::query();

        if ($search) {
            $query->where('satuan_nama', 'like', '%'.$search.'%')
                  ->orWhere('satuan_slug', 'like', '%'.$search.'%');
        }

        return $query->paginate($perPage);
    }

    public function findById(int $id): ?Satuan
    {
        return Satuan::find($id);
    }

    public function create(array $data): Satuan
    {
        return Satuan::create($data);
    }

    public function update(Satuan $satuan, array $data): Satuan
    {
        $satuan->update($data);
        return $satuan->fresh();
    }

    public function delete(Satuan $satuan): bool
    {
        return $satuan->delete();
    }

    public function isUsedInBarang(Satuan $satuan): bool
    {
        return $satuan->barangs()->exists();
    }
}