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
            'barang_nama' => 'required|string',
            'barang_kode' => 'required|string|unique:tbl_barang',
            'barang_harga' => 'required|numeric',
            'satuan_id' => 'required|exists:tbl_satuan,satuan_id',
            'jenisbarang_id' => 'required|exists:tbl_jenis_barang,jenisbarang_id'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }
    
        $data = $request->only([
            'jenisbarang_id',
            'satuan_id',
            'barang_kode',
            'barang_nama',
            'barang_harga'
        ]);
        
        $data['barang_slug'] = Str::slug($request->barang_nama);
        $data['user_id'] = auth()->id();
    
        $barang = Barang::create($data);
    
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