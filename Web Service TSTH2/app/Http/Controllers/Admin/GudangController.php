<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\GudangResource;
use App\Response\Response;
use App\Services\GudangService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    protected $gudang_service;

    public function __construct(GudangService $gudangService)
    {
        $this->gudang_service = $gudangService;
    }

    public function index(): JsonResponse
    {
        try {
            $gudang = $this->gudang_service->getAllGudang();
            return Response::success('Daftar gudang berhasil diperoleh', GudangResource::collection($gudang), 200);
        } catch (\Throwable $th) {
            return Response::error('Gagal mengambil data gudang', $th->getMessage(), 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'gudang_nama' => 'required|string|max:255|unique:tbl_gudang,gudang_nama',
            'gudang_deskripsi' => 'nullable|string'
        ]);

        try {
            $gudang = $this->gudang_service->createGudang($request->all());
            return Response::success('Gudang berhasil dibuat', new GudangResource($gudang), 201);
        } catch (\Throwable $th) {
            return Response::error('Gagal membuat gudang', $th->getMessage(), 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $gudang = $this->gudang_service->getDetailGudang($id);
            return Response::success('Detail gudang berhasil diperoleh', new GudangResource($gudang), 200);
        } catch (\Throwable $th) {
            return Response::error('Gagal mengambil detail gudang', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'gudang_nama' => 'sometimes|string|max:255|unique:tbl_gudang,gudang_nama,' . $id . ',gudang_id',
            'gudang_deskripsi' => 'nullable|string'
        ]);

        try {
            $gudang = $this->gudang_service->updateGudang($request->all(), $id);
            return Response::success('Gudang berhasil diperbarui', new GudangResource($gudang),200);
        } catch (\Throwable $th) {
            return Response::error('Gagal memperbarui gudang', $th->getMessage(), 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->gudang_service->deleteGudang($id);
            return Response::success('Gudang berhasil dihapus', null, 200);
        } catch (\Throwable $th) {
            return Response::error('Gagal menghapus gudang', $th->getMessage(), 500);
        }
    }
}
