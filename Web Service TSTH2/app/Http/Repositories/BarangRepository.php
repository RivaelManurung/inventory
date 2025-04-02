<?php
namespace App\Http\Repositories;

use App\Models\Barang;

class BarangRepository
{
    public function getAll()
    {
        return Barang::all();
    }

    public function getById(int $id)
    {
        return Barang::findOrFail($id);
    }

    public function getAllWithRelations(array $relations = [])
    {
        return Barang::with($relations)->get();
    }

    public function getByIdWithRelations(int $id, array $relations = [])
    {
        return Barang::with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Barang::create($data);
    }

    public function update(array $data, int $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->update($data);
        return $barang;
    }

    public function delete(int $id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();
        return $barang;
    }
}