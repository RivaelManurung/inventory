<?php
namespace App\Http\Repositories;

use App\Models\Gudang;

class GudangRepository
{
    public function getAll()
    {
        return Gudang::orderBy('gudang_nama')->get();
    }

    public function getById(int $id)
    {
        return Gudang::findOrFail($id);
    }

    public function create(array $data)
    {
        return Gudang::create([
            'gudang_nama' => $data['gudang_nama'],
            'gudang_slug' => $data['gudang_slug'],
            'gudang_deskripsi' => $data['gudang_deskripsi'] ?? null
        ]);
    }

    public function update(array $data, int $id)
    {
        $gudang = Gudang::findOrFail($id);
        $updateData = [
            'gudang_nama' => $data['gudang_nama'] ?? $gudang->gudang_nama,
            'gudang_slug' => $data['gudang_slug'] ?? $gudang->gudang_slug,
            'gudang_deskripsi' => $data['gudang_deskripsi'] ?? $gudang->gudang_deskripsi
        ];
        
        $gudang->update($updateData);
        return $gudang;
    }

    public function delete(int $id)
    {
        $gudang = Gudang::findOrFail($id);
        $gudang->delete();
        return $gudang;
    }
}