<?php
namespace App\Services;

use App\Http\Repositories\GudangRepository;
use Illuminate\Support\Str;

class GudangService
{
    protected $gudang_repository;

    public function __construct(GudangRepository $gudangRepository)
    {
        $this->gudang_repository = $gudangRepository;
    }

    public function getAllGudang()
    {
        return $this->gudang_repository->getAll();
    }

    public function getDetailGudang(int $id)
    {
        return $this->gudang_repository->getById($id);
    }

    public function createGudang(array $data)
    {
        $data['gudang_slug'] = Str::slug($data['gudang_nama']);
        return $this->gudang_repository->create($data);
    }

    public function updateGudang(array $data, int $id)
    {
        if (isset($data['gudang_nama'])) {
            $data['gudang_slug'] = Str::slug($data['gudang_nama']);
        }
        return $this->gudang_repository->update($data, $id);
    }

    public function deleteGudang(int $id)
    {
        return $this->gudang_repository->delete($id);
    }
}