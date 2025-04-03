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
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data jenis barang: ' . $th->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenisbarang_nama' => 'required|string|max:255',
            'jenisbarang_ket' => 'nullable|string'
        ]);

        try {
            $result = $this->jenis_barang_service->create_jenis_barang(
                $request->jenisbarang_nama,
                $request->jenisbarang_ket
            );
            return redirect()->route('jenis-barang.index')->with('success', 'Jenis barang berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', $th->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'jenisbarang_nama' => 'required|string|max:255',
            'jenisbarang_ket' => 'nullable|string'
        ]);

        try {
            $this->jenis_barang_service->update_jenis_barang(
                $id,
                $validated['jenisbarang_nama'],
                $validated['jenisbarang_ket'] ?? null
            );
            return redirect()->route('jenis-barang.index')->with('success', 'Jenis barang berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->with('error', 'Gagal memperbarui jenis barang: ' . $th->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $this->jenis_barang_service->delete_jenis_barang($id);
            return redirect()->route('jenis-barang.index')->with('success', 'Jenis barang berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus jenis barang: ' . $th->getMessage());
        }
    }
}
