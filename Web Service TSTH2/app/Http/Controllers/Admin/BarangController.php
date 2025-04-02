<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\BarangResource;
use App\Response\Response;
use App\Services\BarangService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    protected $barang_service;

    public function __construct(BarangService $barangService)
    {
        $this->barang_service = $barangService;
    }

    public function index(): JsonResponse
    {
        try {
            $barang = $this->barang_service->getAllBarang();
            return Response::success('Data barang berhasil diambil', BarangResource::collection($barang), 200);
        } catch (\Throwable $th) {
            return Response::error('Gagal mengambil data barang', $th->getMessage(), 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $barang = $this->barang_service->getDetailBarang($id);
            return Response::success('Detail barang', new BarangResource($barang), 200);
        } catch (\Throwable $th) {
            $status = $th->getMessage() === 'Barang not found' ? 404 : 500;
            return Response::error('Barang tidak ditemukan', $th->getMessage(), $status);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'barang_nama' => 'required|string|max:255',
            'barang_harga' => 'required|numeric|min:0',
            'satuan_id' => 'required|exists:tbl_satuan,satuan_id',
            'jenisbarang_id' => 'required|exists:tbl_jenisbarang,jenisbarang_id',
            'klasifikasi_barang' => 'required|in:sekali_pakai,berulang',
            'user_id' => 'sometimes|exists:users,id'
        ]);

        try {
            $barang = $this->barang_service->createBarang($validated);
            return Response::success('Barang berhasil dibuat', new BarangResource($barang), 201);
        } catch (\Throwable $th) {
            return Response::error('Gagal membuat barang', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'barang_nama' => 'sometimes|string|max:255',
            'barang_harga' => 'sometimes|numeric|min:0',
            'satuan_id' => 'sometimes|exists:tbl_satuan,satuan_id',
            'jenisbarang_id' => 'sometimes|exists:tbl_jenisbarang,jenisbarang_id',
            'klasifikasi_barang' => 'sometimes|in:sekali_pakai,berulang',
            'user_id' => 'sometimes|exists:users,id'
        ]);

        try {
            $barang = $this->barang_service->updateBarang($validated, $id);
            return Response::success('Barang berhasil diupdate', new BarangResource($barang), 200);
        } catch (\Throwable $th) {
            return Response::error('Gagal mengupdate barang', $th->getMessage(), 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->barang_service->deleteBarang($id);
            return Response::success('Barang berhasil dihapus', null, 200);
        } catch (\Throwable $th) {
            return Response::error('Gagal menghapus barang', $th->getMessage(), 500);
        }
    }

    public function getBarcodeCode(int $id): JsonResponse
    {
        try {
            $barang = $this->barang_service->getDetailBarang($id);
            return Response::success('Kode barcode', [
                'barang_id' => $barang->barang_id,
                'barang_kode' => $barang->barang_kode
            ], 200);
        } catch (\Throwable $th) {
            $status = $th->getMessage() === 'Barang not found' ? 404 : 500;
            return Response::error('Gagal mengambil kode barcode', $th->getMessage(), $status);
        }
    }
}