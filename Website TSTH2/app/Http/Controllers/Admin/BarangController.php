<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{BarangModel, JenisBarangModel, SatuanModel, GudangModel};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str; 


class BarangController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'barang' => BarangModel::with(['jenisBarang', 'satuan', 'gudang'])->get()->map(fn($item) => [
                        'barcodeUrl' => $item->barcode ? asset("storage/barang/barcodes/{$item->barcode}") : null,
                        ...$item->toArray()
                    ]),
                    'jenisbarang' => JenisBarangModel::latest('jenisbarang_id')->get(),
                    'satuan' => SatuanModel::latest('satuan_id')->get(),
                    'gudang' => GudangModel::latest('gudang_id')->get()
                ]
            ]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function getBarang($id)
    {
        return $this->findBarang($id);
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nama' => 'required',
                'kode' => 'required|unique:tbl_barang,barang_kode',
                'jenisbarang' => 'required',
                'satuan' => 'required',
                'gudang' => 'required',
                'harga' => 'required|numeric',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            $data['barang_gambar'] = $request->hasFile('foto') ? $this->uploadImage($request->file('foto')) : 'image.png';
            $data['barang_slug'] = Str::slug($data['nama']);
            $data['barang_stok'] = 0;
            $data['barcode'] = $this->generateQrCode($data['kode']);
            
            return response()->json(['status' => 'success', 'message' => 'Barang created successfully', 'data' => BarangModel::create($data)], 201);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $barang = BarangModel::where('barang_kode', $id)->firstOrFail();
            
            $data = $request->validate([
                'nama' => 'required',
                'kode' => "required|unique:tbl_barang,barang_kode,{$barang->barang_id},barang_id",
                'jenisbarang' => 'required',
                'satuan' => 'required',
                'gudang' => 'required',
                'harga' => 'required|numeric',
                'stok' => 'required|numeric',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            if ($request->hasFile('foto')) {
                Storage::delete("public/barang/{$barang->barang_gambar}");
                $data['barang_gambar'] = $this->uploadImage($request->file('foto'));
            }

            $data['barang_slug'] = str::slug($data['nama']);
            $barang->update($data);

            return response()->json(['status' => 'success', 'message' => 'Barang updated successfully', 'data' => $barang]);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    public function destroy($id)
    {
        try {
            $barang = BarangModel::where('barang_kode', $id)->firstOrFail();
            
            Storage::delete(["public/barang/{$barang->barang_gambar}", "public/barang/barcodes/{$barang->barcode}"]);
            $barang->delete();

            return response()->json(['status' => 'success', 'message' => 'Barang deleted successfully']);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    private function findBarang($id)
    {
        try {
            $barang = BarangModel::with(['jenisBarang', 'satuan', 'gudang'])->where('barang_kode', $id)->first();
            
            return $barang ? response()->json(['status' => 'success', 'data' => $barang]) 
                           : response()->json(['status' => 'error', 'message' => 'Barang not found'], 404);
        } catch (\Exception $e) {
            return $this->errorResponse($e);
        }
    }

    private function uploadImage($image)
    {
        $image->storeAs('public/barang', $image->hashName());
        return $image->hashName();
    }

    private function generateQrCode($kode)
    {
        $path = "public/barang/barcodes/{$kode}.png";
        Storage::put($path, QrCode::format('png')->size(200)->generate($kode));
        return basename($path);
    }

    private function errorResponse($e)
    {
        return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
    }
}

    // public function getStockCalculation(Request $request, $kode)
    // {
    //     try {
    //         $barang = BarangModel::where('barang_kode', $kode)->firstOrFail();
            
    //         $query = BarangmasukModel::where('barang_kode', $kode);
    //         $queryKeluar = BarangkeluarModel::where('barang_kode', $kode);

    //         if ($request->has('start_date') && $request->has('end_date')) {
    //             $query->whereBetween('bm_tanggal', [$request->start_date, $request->end_date]);
    //             $queryKeluar->whereBetween('bk_tanggal', [$request->start_date, $request->end_date]);
    //         }

    //         $jmlmasuk = $query->sum('bm_jumlah');
    //         $jmlkeluar = $queryKeluar->sum('bk_jumlah');
    //         $totalstok = $barang->barang_stok + ($jmlmasuk - $jmlkeluar);

    //         return response()->json([
    //             'status' => 'success',
    //             'data' => [
    //                 'initial_stock' => $barang->barang_stok,
    //                 'stock_in' => $jmlmasuk,
    //                 'stock_out' => $jmlkeluar,
    //                 'current_stock' => $totalstok
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }