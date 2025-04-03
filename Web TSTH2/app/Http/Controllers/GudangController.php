<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\GudangService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GudangController extends Controller
{
    private $auth_service, $gudang_service;

    public function __construct(AuthService $auth_service, GudangService $gudang_service)
    {
        $this->auth_service = $auth_service;
        $this->gudang_service = $gudang_service;
    }

    public function index()
    {
        try {
            $data = $this->auth_service->getAuthenticatedUser();
            $gudangs = $this->gudang_service->get_all_gudang();
            return view('Admin.Gudang.index', compact('data', 'gudangs'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data gudang');
        }
    }

    public function create(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            $this->gudang_service->create_gudang(
                $request->input('nama'),
                $request->input('deskripsi')
            );
            return redirect()->route('gudang.index')
                ->with('success', 'Gudang berhasil ditambahkan');
        } catch (\Throwable $th) {
            Log::error('GudangController store error: ' . $th->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan gudang: ' . $th->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'deskripsi' => 'nullable|string'
        ]);

        try {
            $this->gudang_service->update_gudang($id, $request->nama, $request->deskripsi);
            return redirect()->back()->with('success', 'Gudang berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memperbarui gudang: ' . $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $this->gudang_service->delete_gudang($id);
            return redirect()->back()->with('success', 'Gudang berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus gudang: ' . $th->getMessage());
        }
    }
}
