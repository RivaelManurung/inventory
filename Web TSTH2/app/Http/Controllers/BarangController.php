<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\BarangService;
use App\Services\JenisBarangService;
use App\Services\SatuanService;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    private $auth_service, $barang_service, $jenis_barang_service, $satuan_service;

    public function __construct(
        AuthService $auth_service,
        BarangService $barang_service,
        JenisBarangService $jenis_barang_service,
        SatuanService $satuan_service
    ) {
        $this->auth_service = $auth_service;
        $this->barang_service = $barang_service;
        $this->jenis_barang_service = $jenis_barang_service;
        $this->satuan_service = $satuan_service;
    }

    public function index()
    {
        try {
            $data = $this->auth_service->getAuthenticatedUser();
            $barangs = $this->barang_service->getAllBarang();
            $satuans = $this->satuan_service->get_all_satuan();
            $jenisBarangs = $this->jenis_barang_service->get_all_jenis_barang();

            // Debug the barang data structure
            // dd($barangs->first());

            return view('admin.barang.index', compact('data', 'barangs', 'satuans', 'jenisBarangs'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data barang: ' . $th->getMessage());
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'barang_nama' => 'required|string',
            'barang_harga' => 'required|numeric',
            'satuan_id' => 'required|exists:tbl_satuan,satuan_id',
            'jenisbarang_id' => 'required|exists:tbl_jenisbarang,jenisbarang_id',
            'klasifikasi_barang' => 'required|in:sekali_pakai,berulang'
        ]);

        try {
            $result = $this->barang_service->createBarang($request->all());
            return redirect()->back()->with('success', 'Barang berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan barang: ' . $th->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'barang_nama' => 'sometimes|string',
            'barang_harga' => 'sometimes|numeric',
            'satuan_id' => 'sometimes|numeric', // Just check type, not existence
            'jenisbarang_id' => 'sometimes|numeric',
            'klasifikasi_barang' => 'sometimes|in:sekali_pakai,berulang'
        ]);

        try {
            $result = $this->barang_service->updateBarang($request->all(), $id);
            return redirect()->back()->with('success', 'Barang berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memperbarui barang: ' . $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->barang_service->deleteBarang($id);
            return redirect()->back()->with('success', 'Barang berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus barang: ' . $th->getMessage());
        }
    }

    public function generateBarcode(int $id)
    {
        try {
            $result = $this->barang_service->generateBarangBarcode($id);
            return redirect()->back()->with('success', 'Barcode berhasil digenerate');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal generate barcode: ' . $th->getMessage());
        }
    }

    public function downloadBarcode(int $id)
    {
        try {
            return $this->barang_service->downloadBarangBarcode($id);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal download barcode: ' . $th->getMessage());
        }
    }
}
