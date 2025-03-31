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
        $result = $this->satuanService->getAllSatuans([
            'search' => $request->input('search'),
            'per_page' => $request->input('per_page', 10)
        ]);

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
            'meta' => [
                'current_page' => $result['data']->currentPage(),
                'from' => $result['data']->firstItem(),
                'to' => $result['data']->lastItem(),
                'total' => $result['data']->total(),
                'last_page' => $result['data']->lastPage(),
                'per_page' => $result['data']->perPage(),
            ],
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

        if (!$result['success']) {
            $statusCode = $result['message'] === 'Satuan tidak ditemukan' ? 404 : 422;
            return response()->json([
                'success' => false,
                'message' => $result['message']
            ], $statusCode);
        }

        return response()->json([
            'success' => true,
            'message' => $result['message']
        ]);
    }
}