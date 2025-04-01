<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\BarangService;
use App\Services\JenisBarangService;
use App\Services\SatuanService;
use Illuminate\Http\Request;
use Milon\Barcode\DNS1D;

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
            $jbs = $this->jenis_barang_service->get_all_jenis_barang();

            // Debug the barang data structure
            // dd($barangs->first());

            return view('admin.barang.index', compact('data', 'barangs', 'satuans', 'jbs'));
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

    public function generateBarangBarcode(string $code)
    {
        try {
            $dns = new DNS1D();
            return [
                'image_png' => $dns->getBarcodePNG($code, 'C128'),
                'image_svg' => $dns->getBarcodeSVG($code, 'C128'),
                'code' => $code
            ];
        } catch (\Exception $e) {
            throw new \Exception('Gagal generate barcode: ' . $e->getMessage());
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
    public function showBarcode($id)
    {
        try {
            $barang = $this->barang_service->getDetailBarang($id);
            $barcode = $this->barang_service->generateBarangBarcode($barang->barang_kode);
            return view('admin.barang.barcode', compact('barang', 'barcode'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menampilkan barcode: ' . $th->getMessage());
        }
    }
}
