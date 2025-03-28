<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Satuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SatuanController extends Controller
{
    public function index()
    {
        $satuan = Satuan::query()
            ->when(request('search'), function($query) {
                $query->where('nama', 'like', '%'.request('search').'%')
                      ->orWhere('kode', 'like', '%'.request('search').'%');
            })
            ->paginate(10);

        if (request()->wantsJson()) {
            return response()->json([
                'status' => true,
                'data' => $satuan
            ]);
        }

        return view('Admin.Satuan.index', compact('satuan'));
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
            'kode' => 'required|string|unique:satuan',
            'nama' => 'required|string|unique:satuan',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:Aktif,Nonaktif'
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

        $satuan = Satuan::create($request->all());

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
            'kode' => 'sometimes|string|unique:satuan,kode,'.$id,
            'nama' => 'sometimes|string|unique:satuan,nama,'.$id,
            'deskripsi' => 'nullable|string',
            'status' => 'sometimes|in:Aktif,Nonaktif'
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

        $satuan->update($request->all());

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