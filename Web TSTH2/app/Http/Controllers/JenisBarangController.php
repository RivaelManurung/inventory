<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\JenisBarangService;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    private $auth_service, $jenis_barang_service;

    public function __construct(AuthService $auth_service, JenisBarangService $jenis_barang_service)
    {
        $this->auth_service = $auth_service;
        $this->jenis_barang_service = $jenis_barang_service;
    }

    public function index()
    {
        try {
            $data = $this->auth_service->getAuthenticatedUser();
            $jenisBarangs = $this->jenis_barang_service->get_all_jenis_barang();
            return view('admin.jenisbarang.index', compact('data', 'jenisBarangs'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data jenis barang');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'jenisbarang_nama' => 'required|string',
            'jenisbarang_ket' => 'nullable|string'
        ]);
        
        try {
            $result = $this->jenis_barang_service->create_jenis_barang(
                $request->jenisbarang_nama, 
                $request->jenisbarang_ket
            );
            return redirect()->back()->with('success', 'Jenis barang berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan jenis barang: ' . $th->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'jenisbarang_nama' => 'required|string',
            'jenisbarang_ket' => 'nullable|string'
        ]);
        
        try {
            $result = $this->jenis_barang_service->update_jenis_barang(
                $id, 
                $request->jenisbarang_nama, 
                $request->jenisbarang_ket
            );
            return redirect()->back()->with('success', 'Jenis barang berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memperbarui jenis barang: ' . $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $result = $this->jenis_barang_service->delete_jenis_barang($id);
            return redirect()->back()->with('success', 'Jenis barang berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus jenis barang: ' . $th->getMessage());
        }
    }
}