<?php
namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Services\SatuanService;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    private $auth_service, $satuan_service;

    public function __construct(AuthService $auth_service, SatuanService $satuan_service)
    {
        $this->auth_service = $auth_service;
        $this->satuan_service = $satuan_service;
    }

    public function index()
    {
        try {
            $data = $this->auth_service->getAuthenticatedUser();
            $satuans = $this->satuan_service->get_all_satuan();
            return view('Admin.Satuan.index', compact('data', 'satuans'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat data satuan');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);
        
        try {
            $this->satuan_service->create_satuan($request->nama, $request->keterangan);
            return redirect()->back()->with('success', 'Satuan berhasil ditambahkan');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menambahkan satuan: ' . $th->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'nama' => 'required|string',
            'keterangan' => 'nullable|string'
        ]);
        
        try {
            $this->satuan_service->update_satuan($id, $request->nama, $request->keterangan);
            return redirect()->back()->with('success', 'Satuan berhasil diperbarui');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal memperbarui satuan: ' . $th->getMessage());
        }
    }

    public function delete(int $id)
    {
        try {
            $this->satuan_service->delete_satuan($id);
            return redirect()->back()->with('success', 'Satuan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Gagal menghapus satuan: ' . $th->getMessage());
        }
    }
}