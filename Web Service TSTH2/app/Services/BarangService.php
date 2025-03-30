<?php
namespace App\Services;

use App\Http\Repositories\BarangRepository;
use Milon\Barcode\DNS1D;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Str;

class BarangService
{
    protected $barang_repository;

    public function __construct(BarangRepository $barangRepository)
    {
        $this->barang_repository = $barangRepository;
    }

    public function getAllBarang()
    {
        return $this->barang_repository->getAll();
    }

    public function getDetailBarang(int $id)
    {
        return $this->barang_repository->getById($id);
    }

    public function createBarang(array $data)
    {
        $randomNumber = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
        $data['barang_kode'] = 'BRG-' . $randomNumber;
        $data['barang_slug'] = Str::slug($data['barang_nama']);
        $data['user_id'] = Auth::check() ? Auth::user()->id : null;

        $barang = $this->barang_repository->create($data);
        
        // Generate barcode
        $this->saveBarcodeImage($barang->barang_kode);
        
        return $barang;
    }

    public function updateBarang(array $data, int $id)
    {
        if (isset($data['barang_nama'])) {
            $data['barang_slug'] = Str::slug($data['barang_nama']);
        }

        $barang = $this->barang_repository->update($data, $id);
        
        // Update barcode if code changed
        if (isset($data['barang_kode'])) {
            $this->saveBarcodeImage($barang->barang_kode);
        }
        
        return $barang;
    }

    public function deleteBarang(int $id)
    {
        $barang = $this->barang_repository->getById($id);
        $this->deleteBarcodeImage($barang->barang_kode);
        return $this->barang_repository->delete($id);
    }

    public function generateBarangBarcode(int $id)
    {
        $barang = $this->barang_repository->getById($id);
        return $this->generateBarcode($barang->barang_kode);
    }

    public function downloadBarangBarcode(int $id): StreamedResponse
    {
        $barang = $this->barang_repository->getById($id);
        $barcodeData = $this->generateBarcode($barang->barang_kode);
        $image = base64_decode(str_replace('data:image/png;base64,', '', $barcodeData['image_png']));

        return response()->streamDownload(
            function () use ($image) {
                echo $image;
            },
            "barcode-{$barang->barang_kode}.png",
            ['Content-Type' => 'image/png']
        );
    }

    private function generateBarcode($code)
    {
        try {
            $dns = new DNS1D();

            return [
                'image_png' => 'data:image/png;base64,' . $dns->getBarcodePNG($code, 'C128'),
                'image_svg' => $dns->getBarcodeSVG($code, 'C128', 2, 50),
                'html' => $dns->getBarcodeHTML($code, 'C128', 2, 50),
                'code' => $code,
                'success' => true
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Gagal generate barcode: ' . $e->getMessage(),
                'code' => $code
            ];
        }
    }

    private function saveBarcodeImage($code)
    {
        try {
            $barcodeData = $this->generateBarcode($code);

            if (!$barcodeData['success']) {
                logger()->error('Failed to generate barcode', ['code' => $code]);
                return false;
            }

            $image = base64_decode(str_replace('data:image/png;base64,', '', $barcodeData['image_png']));
            $path = "public/barcodes/{$code}.png";

            return Storage::put($path, $image);
        } catch (\Exception $e) {
            logger()->error('Failed to save barcode image', [
                'code' => $code,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    private function deleteBarcodeImage($code)
    {
        $path = "public/barcodes/{$code}.png";
        if (Storage::exists($path)) {
            Storage::delete($path);
        }
    }
}