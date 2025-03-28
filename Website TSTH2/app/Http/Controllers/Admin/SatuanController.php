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
        $satuan = Satuan::all();
        return response()->json([
            'status' => true,
            'data' => $satuan
        ]);
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
            'nama' => 'required|string|unique:satuan',
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $satuan = Satuan::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Satuan berhasil ditambahkan',
            'data' => $satuan
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $satuan = Satuan::find($id);
        
        if (!$satuan) {
            return response()->json([
                'status' => false,
                'message' => 'Satuan tidak ditemukan'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'sometimes|string|unique:satuan,nama,'.$id,
            'keterangan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $satuan->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Satuan berhasil diperbarui',
            'data' => $satuan
        ]);
    }

    public function destroy($id)
    {
        $satuan = Satuan::find($id);
        
        if (!$satuan) {
            return response()->json([
                'status' => false,
                'message' => 'Satuan tidak ditemukan'
            ], 404);
        }

        $satuan->delete();

        return response()->json([
            'status' => true,
            'message' => 'Satuan berhasil dihapus'
        ]);
    }
}