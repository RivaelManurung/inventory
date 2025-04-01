<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\JenisBarangResource;
use App\Services\JenisBarangService;
use Illuminate\Http\Request;

class JenisBarangController extends Controller
{
    protected $service;

    public function __construct(JenisBarangService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $response = $this->service->getAll();
        
        if (!$response['success']) {
            return response()->json($response, 500);
        }

        return response()->json([
            'success' => true,
            'data' => $response['data'],
        ]);
    }

    public function show($id)
    {
        $response = $this->service->getById($id);
        
        if (!$response['success']) {
            return response()->json($response, 404);
        }

        return response()->json($response);
    }

    public function store(Request $request)
    {
        $response = $this->service->create($request->all());
        
        if (!$response['success']) {
            return response()->json($response, $response['errors'] ? 422 : 500);
        }

        return response()->json($response, 201);
    }

    public function update(Request $request, $id)
    {
        $response = $this->service->update($id, $request->all());
        
        if (!$response['success']) {
            $status = isset($response['errors']) ? 422 : 
                     ($response['message'] === 'Jenis barang tidak ditemukan' ? 404 : 500);
            return response()->json($response, $status);
        }

        return response()->json($response);
    }

    public function destroy($id)
    {
        $response = $this->service->delete($id);
        
        if (!$response['success']) {
            $status = $response['message'] === 'Jenis barang tidak ditemukan' ? 404 : 500;
            return response()->json($response, $status);
        }

        return response()->json($response);
    }
}