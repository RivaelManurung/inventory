<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\BarangModel;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barangData = [
            ["nama" => "Laptop ASUS ROG", "kode" => "LPT123", "harga" => 15000000],
            ["nama" => "Monitor LG 24 Inch", "kode" => "MON456", "harga" => 2500000],
            ["nama" => "Keyboard Mechanical RGB", "kode" => "KEY789", "harga" => 750000],
            ["nama" => "Mouse Logitech Wireless", "kode" => "MSE321", "harga" => 500000],
            ["nama" => "Headset Gaming Razer", "kode" => "HST654", "harga" => 1800000],
            ["nama" => "Webcam Full HD", "kode" => "WBC987", "harga" => 1200000],
            ["nama" => "SSD NVMe 1TB", "kode" => "SSD741", "harga" => 2200000],
            ["nama" => "RAM DDR4 16GB", "kode" => "RAM852", "harga" => 1300000],
            ["nama" => "Printer Epson L3110", "kode" => "PRT963", "harga" => 2800000],
            ["nama" => "Flashdisk 64GB", "kode" => "FLD159", "harga" => 150000],
        ];

        foreach ($barangData as $data) {
            $qrPath = "public/barang/barcodes/{$data['kode']}.png";
            Storage::put($qrPath, QrCode::format('png')->size(200)->generate($data['kode']));

            BarangModel::create([
                'barang_nama' => $data['nama'],
                'barang_kode' => $data['kode'],
                'barang_slug' => Str::slug($data['nama']),
                'barang_gambar' => 'image.png',
                'barang_stok' => 20,
                'barang_harga' => $data['harga'],
                'barcode' => basename($qrPath),
                'jenisbarang_id' => 14,
                'satuan_id' => 1,
                'gudang_id' => 1,
            ]);
        }
    }
}
