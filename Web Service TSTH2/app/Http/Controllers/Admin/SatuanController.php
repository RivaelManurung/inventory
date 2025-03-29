<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $satuans = Satuan::query()
            ->when($search, function($query) use ($search) {
                $query->where('satuan_nama', 'like', '%'.$search.'%')
                      ->orWhere('satuan_slug', 'like', '%'.$search.'%');
            })
            ->orderBy('satuan_nama')
            ->paginate(10);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => true,
                'data' => $satuans
            ]);
        }

        return view('admin.satuan.index', compact('satuans', 'search'));
    }

    public function show($id)
    {
        $satuan = Satuan::find($id);

        if (!$satuan) {
            return response()->json([
                'status' => false,
                'message' => 'Satuan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $satuan
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'satuan_nama' => 'required|string|unique:tbl_satuan',
            'satuan_slug' => 'required|string|unique:tbl_satuan',
            'satuan_keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $satuan = Satuan::create([
            'satuan_nama' => $request->satuan_nama,
            'satuan_slug' => $request->satuan_slug,
            'satuan_keterangan' => $request->satuan_keterangan,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Satuan berhasil ditambahkan',
                'data' => $satuan
            ], 201);
        }

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $satuan = Satuan::find($id);

        if (!$satuan) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Satuan tidak ditemukan'
                ], 404);
            }
            
            return redirect()->back()
                ->with('error', 'Satuan tidak ditemukan');
        }

        $validator = Validator::make($request->all(), [
            'satuan_nama' => 'required|string|unique:tbl_satuan,satuan_nama,'.$id.',satuan_id',
            'satuan_slug' => 'required|string|unique:tbl_satuan,satuan_slug,'.$id.',satuan_id',
            'satuan_keterangan' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $satuan->update([
            'satuan_nama' => $request->satuan_nama,
            'satuan_slug' => $request->satuan_slug,
            'satuan_keterangan' => $request->satuan_keterangan,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Satuan berhasil diperbarui',
                'data' => $satuan
            ]);
        }

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $satuan = Satuan::find($id);

        if (!$satuan) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Satuan tidak ditemukan'
                ], 404);
            }
            
            return redirect()->back()
                ->with('error', 'Satuan tidak ditemukan');
        }

        // Cek apakah satuan digunakan di barang
        if ($satuan->barangs()->count() > 0) {
            if (request()->wantsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Satuan tidak dapat dihapus karena sudah digunakan'
                ], 422);
            }
            
            return redirect()->back()
                ->with('error', 'Satuan tidak dapat dihapus karena sudah digunakan');
        }

        $satuan->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'status' => true,
                'message' => 'Satuan berhasil dihapus'
            ]);
        }

        return redirect()->route('satuan.index')
            ->with('success', 'Satuan berhasil dihapus');
    }
}