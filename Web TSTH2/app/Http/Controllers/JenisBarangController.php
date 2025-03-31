<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\JenisBarangResource;
use App\Services\JenisBarangService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        $search = $request->input('search', '');
        $perPage = $request->input('per_page', 10);

        $response = $this->jenisBarangService->getAll($search, $perPage);
        
        $jenisBarangs = new \Illuminate\Pagination\LengthAwarePaginator(
            $response['data'],
            $response['meta']['total'] ?? 0,
            $response['meta']['per_page'] ?? 10,
            $response['meta']['current_page'] ?? 1,
            ['path' => url()->current(), 'query' => $request->query()]
        );

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'html' => view('admin.jenisbarang.partials.table', compact('jenisBarangs'))->render(),
                'pagination' => view('admin.jenisbarang.partials.pagination', compact('jenisBarangs'))->render()
            ]);
        }

        return view('admin.jenisbarang.index', compact('jenisBarangs', 'search'));

    } catch (\Exception $e) {
        Log::error('JenisBarangController - Error in index: ' . $e->getMessage());
        
        if ($request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server'
            ], 500);
        }

        return back()->with('error', 'Terjadi kesalahan server');
    }
}

    public function getUpdates(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'last_update' => 'nullable|date',
                'search' => 'nullable|string',
                'per_page' => 'nullable|integer|min:1|max:100'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();
            $response = $this->jenisBarangService->getUpdates(
                $validated['last_update'] ?? null,
                $validated['search'] ?? '',
                $validated['per_page'] ?? 10
            );

            return $this->jsonResponse($response);

        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in getUpdates: ' . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Server error',
                'error' => $e->getMessage()
            ], 500);
        }
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
                return $this->handleValidationError($validator, $request);
            }

            $response = $this->jenisBarangService->create($validator->validated());

            if ($request->wantsJson()) {
                return $this->jsonResponse($response);
            }

            if ($response['success']) {
                return redirect()->route('jenis-barang.index')
                    ->with('success', $response['message'] ?? 'Jenis barang berhasil ditambahkan');
            }

            return back()->withErrors($response['errors'] ?? ['message' => $response['message'] ?? 'Gagal menambahkan jenis barang']);

        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in store: ' . $e->getMessage());
            return $this->handleError($e, $request);
        }
    }

    public function show($id, Request $request)
    {
        try {
            $response = $this->jenisBarangService->getById($id);

            if ($request->wantsJson()) {
                return $this->jsonResponse($response);
            }

            if (!$response['success']) {
                return $this->handleNotFound($response['message'], $request);
            }

            return view('admin.jenis-barang.show', [
                'jenisBarang' => new JenisBarangResource((object)$response['data'])
            ]);

        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in show: ' . $e->getMessage());
            return $this->handleError($e, $request);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:jenis_barang,slug,'.$id,
                'keterangan' => 'nullable|string|max:500'
            ]);

            if ($validator->fails()) {
                return $this->handleValidationError($validator, $request);
            }

            $response = $this->jenisBarangService->update($id, $validator->validated());

            if ($request->wantsJson()) {
                return $this->jsonResponse($response);
            }

            if ($response['success']) {
                return redirect()->route('jenis-barang.index')
                    ->with('success', $response['message'] ?? 'Jenis barang berhasil diperbarui');
            }

            return back()->withErrors($response['errors'] ?? ['message' => $response['message'] ?? 'Gagal memperbarui jenis barang']);

        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in update: ' . $e->getMessage());
            return $this->handleError($e, $request);
        }
    }

    public function destroy($id, Request $request)
    {
        try {
            $response = $this->jenisBarangService->delete($id);

            if ($request->wantsJson()) {
                return $this->jsonResponse($response);
            }

            if ($response['success']) {
                return redirect()->route('jenis-barang.index')
                    ->with('success', $response['message'] ?? 'Jenis barang berhasil dihapus');
            }

            return back()->withErrors(['message' => $response['message'] ?? 'Gagal menghapus jenis barang']);

        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in destroy: ' . $e->getMessage());
            return $this->handleError($e, $request);
        }
    }

    public function search(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'query' => 'required|string|min:2'
            ]);

            if ($validator->fails()) {
                return $this->jsonResponse([
                    'success' => false,
                    'message' => 'Validation error',
                    'errors' => $validator->errors()
                ], 422);
            }

            $response = $this->jenisBarangService->search($validator->validated()['query']);
            return $this->jsonResponse($response);

        } catch (\Exception $e) {
            Log::error('JenisBarangController - Error in search: ' . $e->getMessage());
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Server error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper methods
     */
    protected function jsonResponse(array $data, int $status = 200)
    {
        return response()->json($data, $status);
    }

    protected function handleError(\Exception $e, Request $request)
    {
        $message = 'Terjadi kesalahan server';
        $status = 500;

        if ($request->wantsJson()) {
            return $this->jsonResponse([
                'success' => false,
                'message' => $message,
                'error' => config('app.debug') ? $e->getMessage() : null
            ], $status);
        }

        return back()->with('error', $message);
    }

    protected function handleNotFound(string $message, Request $request)
    {
        if ($request->wantsJson()) {
            return $this->jsonResponse([
                'success' => false,
                'message' => $message
            ], 404);
        }

        abort(404, $message);
    }

    protected function handleValidationError(\Illuminate\Validation\Validator $validator, Request $request)
    {
        if ($request->wantsJson()) {
            return $this->jsonResponse([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        return back()->withErrors($validator)->withInput();
    }
}