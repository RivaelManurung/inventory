<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::all();
        return response()->json([
            'status' => true,
            'data' => $barang
        ]);
    }

    public function show($id)
    {
        $barang = Barang::find($id);
        
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $barang
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'kode' => 'required|string|unique:barang',
            'harga' => 'required|numeric',
            'stok' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $barang = Barang::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil ditambahkan',
            'data' => $barang
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::find($id);
        
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|string',
            'kode' => 'sometimes|string|unique:barang,kode,'.$id,
            'harga' => 'sometimes|numeric',
            'stok' => 'sometimes|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $barang->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil diperbarui',
            'data' => $barang
        ]);
    }

    public function destroy($id)
    {
        $barang = Barang::find($id);
        
        if (!$barang) {
            return response()->json([
                'status' => false,
                'message' => 'Barang tidak ditemukan'
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'status' => true,
            'message' => 'Barang berhasil dihapus'
        ]);
    }
}