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
            return Response::success('Get all data successfully', BarangResource::collection($barang), 200);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

    public function show(int $id): JsonResponse
    {
        try {
            $barang = $this->barang_service->getDetailBarang($id);
            return Response::success('Get data successfully', new BarangResource($barang), 200);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'barang_nama' => 'required|string',
            'barang_harga' => 'required|numeric',
            'satuan_id' => 'required|exists:tbl_satuan,satuan_id',
            'jenisbarang_id' => 'required|exists:tbl_jenisbarang,jenisbarang_id',
            'klasifikasi_barang' => 'required|in:sekali_pakai,berulang'
        ]);

        try {
            $barang = $this->barang_service->createBarang($request->all());
            return Response::success('Barang created successfully', new BarangResource($barang), 201);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $request->validate([
            'barang_nama' => 'sometimes|string',
            'barang_harga' => 'sometimes|numeric',
            'satuan_id' => 'sometimes|exists:tbl_satuan,satuan_id',
            'jenisbarang_id' => 'sometimes|exists:tbl_jenisbarang,jenisbarang_id',
            'klasifikasi_barang' => 'sometimes|in:sekali_pakai,berulang'
        ]);

        try {
            $barang = $this->barang_service->updateBarang($request->all(), $id);
            return Response::success('Barang updated successfully', new BarangResource($barang), 200);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->barang_service->deleteBarang($id);
            return Response::success('Barang deleted successfully', null, 200);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

    public function getBarcode(int $id): JsonResponse
    {
        try {
            $barcode = $this->barang_service->generateBarangBarcode($id);
            return Response::success('Barcode generated successfully', $barcode, 200);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }

    public function downloadBarcode(int $id)
    {
        try {
            return $this->barang_service->downloadBarangBarcode($id);
        } catch (\Throwable $th) {
            return Response::error('Internal server error', $th->getMessage(), 500);
        }
    }
}