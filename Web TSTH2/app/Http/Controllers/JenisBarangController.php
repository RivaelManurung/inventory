<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\JenisBarangService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class JenisBarangController extends Controller
{
    protected $jenisBarangService;

    public function __construct(JenisBarangService $jenisBarangService)
    {
        $this->jenisBarangService = $jenisBarangService;
    }

    public function index(Request $request)
    {
        try {
            if ($request->ajax()) {
                $response = $this->jenisBarangService->getAll($request->search, $request->per_page);
                
                if (!$response['success']) {
                    return response()->json([
                        'success' => false,
                        'message' => $response['message']
                    ], 400);
                }
    
                // Ensure data is properly formatted
                $data = collect($response['data'])->map(function ($item) {
                    return (object)[
                        'id' => $item->id ?? null,
                        'nama' => $item->nama ?? null,
                        'slug' => $item->slug ?? null,
                        'keterangan' => $item->keterangan ?? null,
                        'created_at' => $item->created_at ?? null,
                        'updated_at' => $item->updated_at ?? null
                    ];
                });
    
                return response()->json([
                    'success' => true,
                    'html' => view('admin.jenisbarang.partials.table', [
                        'jenisBarangs' => (object)[
                            'data' => $data,
                            'current_page' => $response['meta']['current_page'] ?? 1,
                            'per_page' => $request->per_page ?? 10,
                            'total' => $response['meta']['total'] ?? count($data),
                            'links' => $this->formatPaginationLinks($response['meta']['links'] ?? [])
                        ]
                    ])->render(),
                    'pagination' => view('admin.jenisbarang.partials.pagination', [
                        'jenisBarangs' => (object)[
                            'data' => $data,
                            'current_page' => $response['meta']['current_page'] ?? 1,
                            'per_page' => $request->per_page ?? 10,
                            'total' => $response['meta']['total'] ?? count($data),
                            'links' => $this->formatPaginationLinks($response['meta']['links'] ?? [])
                        ]
                    ])->render()
                ]);
            }
    
            // Initial load
            $response = $this->jenisBarangService->getAll('', 10);
            
            if (!$response['success']) {
                throw new \Exception($response['message']);
            }
    
            $data = collect($response['data'])->map(function ($item) {
                return (object)[
                    'jenis_barang_id' => $item->jenis_barang_id ?? null,
                    'nama' => $item->nama ?? null,
                    'slug' => $item->slug ?? null,
                    'keterangan' => $item->keterangan ?? null,
                    'created_at' => $item->created_at ?? null,
                    'updated_at' => $item->updated_at ?? null
                ];
            });
    
            return view('admin.jenisbarang.index', [
                'jenisBarangs' => (object)[
                    'data' => $data,
                    'current_page' => 1,
                    'per_page' => 10,
                    'total' => $response['meta']['total'] ?? count($data),
                    'links' => $this->formatPaginationLinks($response['meta']['links'] ?? [])
                ]
            ]);
    
        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in index: ' . $e->getMessage());
            return $this->handleError($e, $request);
        }
    }
    
    private function formatPaginationLinks($links)
    {
        return collect($links)->map(function ($link) {
            return (object)[
                'url' => $link['url'] ?? null,
                'label' => $link['label'] ?? '',
                'active' => $link['active'] ?? false
            ];
        });
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:jenis_barang,slug',
                'keterangan' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $response = $this->jenisBarangService->create($validator->validated());

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in store: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $response = $this->jenisBarangService->getById($id);

            if (!$response['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $response['message']
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $response['data']
            ]);
        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in show: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:jenis_barang,slug,' . $id,
                'keterangan' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $response = $this->jenisBarangService->update($id, $validator->validated());

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in update: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $response = $this->jenisBarangService->delete($id);

            return response()->json($response);
        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in destroy: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }
    }

    protected function handleError(\Exception $e, Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }

        return back()->with('error', 'Terjadi kesalahan server');
    }
}
