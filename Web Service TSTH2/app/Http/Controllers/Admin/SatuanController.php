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

    public function index()
    {
        $result = $this->satuanService->getAllSatuans();

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'error' => $result['error'] ?? null
            ], 500);
        }

        return response()->json([
            'success' => true,
            'data' => SatuanResource::collection($result['data']),
            'message' => $result['message']
        ]);
    }
    public function store(Request $request)
    {
        $result = $this->satuanService->createSatuan($request->all());

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'error' => $result['error'] ?? null
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => new SatuanResource($result['data']),
            'message' => $result['message']
        ], 201);
    }

    public function show($id)
    {
        $result = $this->satuanService->getSatuanById($id);

        if (!$result['success']) {
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new SatuanResource($result['data']),
            'message' => $result['message']
        ]);
    }

    public function update(Request $request, $id)
    {
        $result = $this->satuanService->updateSatuan($id, $request->all());

        if (!$result['success']) {
            $statusCode = $result['message'] === 'Satuan tidak ditemukan' ? 404 : 422;
            return response()->json([
                'success' => false,
                'message' => $result['message'],
                'error' => $result['error'] ?? null
            ], $statusCode);
        }

        return response()->json([
            'success' => true,
            'data' => new SatuanResource($result['data']),
            'message' => $result['message']
        ]);
    }

    public function destroy($id)
    {
        $result = $this->satuanService->deleteSatuan($id);

        $statusCode = 500;
        if ($result['error'] === 'NOT_FOUND') {
            $statusCode = 404;
        } elseif ($result['error'] === 'IN_USE') {
            $statusCode = 409; // Conflict
        } elseif ($result['success']) {
            $statusCode = 200;
        }

        return response()->json([
            'success' => $result['success'],
            'message' => $result['message'],
            'error' => $result['error'] ?? null,
            'error_code' => $result['error_type'] ?? null
        ], $statusCode);
    }
}
