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

        $statusCode = 200;
        $response = [
            'success' => $result['success'],
            'message' => $result['message']
        ];

        // Only add error info if it exists
        if (isset($result['error'])) {
            $response['error'] = $result['error'];
            $statusCode = $result['error'] === 'NOT_FOUND' ? 404 : ($result['error'] === 'IN_USE' ? 409 : 500);
        }

        // Add error type if it exists
        if (isset($result['error_type'])) {
            $response['error_code'] = $result['error_type'];
        }

        return response()->json($response, $statusCode);
    }
}
