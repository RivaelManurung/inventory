<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\SatuanResource;
use App\Services\SatuanService;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    protected $satuanService;

    public function __construct(SatuanService $satuanService)
    {
        $this->satuanService = $satuanService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $response = $this->satuanService->getAll($search, $perPage);

        if ($request->wantsJson()) {
            return response()->json($response);
        }

        $satuans = $response['data'] ?? [];
        
        return view('admin.satuan.index', [
            'satuans' => $satuans,
            'search' => $search,
            'pagination' => $satuans['meta'] ?? null
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'satuan_nama' => 'required|string',
            'satuan_slug' => 'required|string',
            'satuan_keterangan' => 'nullable|string',
        ]);

        $response = $this->satuanService->create($data);

        if ($request->wantsJson()) {
            return response()->json($response);
        }

        if ($response['success']) {
            return redirect()->route('satuan.index')
                ->with('success', 'Satuan berhasil ditambahkan');
        }

        return back()->withErrors($response['errors'] ?? ['message' => $response['message'] ?? 'Gagal menambahkan satuan']);
    }

    public function show($id, Request $request)
    {
        $response = $this->satuanService->getById($id);

        if ($request->wantsJson()) {
            return response()->json($response);
        }

        if (!$response['success']) {
            if ($request->ajax()) {
                return response()->json($response, 404);
            }
            abort(404);
        }

        return view('admin.satuan.show', [
            'satuan' => new SatuanResource((object)$response['data'])
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'satuan_nama' => 'required|string',
            'satuan_slug' => 'required|string',
            'satuan_keterangan' => 'nullable|string',
        ]);

        $response = $this->satuanService->update($id, $data);

        if ($request->wantsJson()) {
            return response()->json($response);
        }

        if ($response['success']) {
            return redirect()->route('satuan.index')
                ->with('success', 'Satuan berhasil diperbarui');
        }

        return back()->withErrors($response['errors'] ?? ['message' => $response['message'] ?? 'Gagal memperbarui satuan']);
    }

    public function destroy($id, Request $request)
    {
        $response = $this->satuanService->delete($id);

        if ($request->wantsJson()) {
            return response()->json($response);
        }

        if ($response['success']) {
            return redirect()->route('satuan.index')
                ->with('success', 'Satuan berhasil dihapus');
        }

        return back()->withErrors(['message' => $response['message'] ?? 'Gagal menghapus satuan']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $response = $this->satuanService->search($query);

        return response()->json($response);
    }
}