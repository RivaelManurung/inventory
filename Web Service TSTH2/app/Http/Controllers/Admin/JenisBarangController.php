<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JenisBarangController extends Controller
{
    public function index()
    {
        $jenisBarang = JenisBarang::all();
        return response()->json([
            'status' => true,
            'data' => $jenisBarang
        ]);
    }

    public function show($id)
    {
        $jenisBarang = JenisBarang::find($id);
        
        if (!$jenisBarang) {
            return response()->json([
                'status' => false,
                'message' => 'Jenis barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $jenisBarang
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|unique:jenis_barang',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $jenisBarang = JenisBarang::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Jenis barang berhasil ditambahkan',
            'data' => $jenisBarang
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $jenisBarang = JenisBarang::find($id);
        
        if (!$jenisBarang) {
            return response()->json([
                'status' => false,
                'message' => 'Jenis barang tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|string|unique:jenis_barang,nama,'.$id,
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $jenisBarang->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Jenis barang berhasil diperbarui',
            'data' => $jenisBarang
        ]);
    }

    public function destroy($id)
    {
        $jenisBarang = JenisBarang::find($id);
        
        if (!$jenisBarang) {
            return response()->json([
                'status' => false,
                'message' => 'Jenis barang tidak ditemukan'
            ], 404);
        }

        $jenisBarang->delete();

        return response()->json([
            'status' => true,
            'message' => 'Jenis barang berhasil dihapus'
        ]);
    }
}