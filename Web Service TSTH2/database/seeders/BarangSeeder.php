<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kosongkan tabel terlebih dahulu
        DB::table('tbl_barang_gudang')->delete();
        DB::table('tbl_barang')->delete();

        // Data untuk tbl_barang
        $barang = [
            [
                'barang_id' => 1,
                'jenisbarang_id' => 9, // Pupuk
                'satuan_id' => 1, // Kilogram
                'klasifikasi_barang' => 'sekali_pakai', // Changed from 'Pupuk Organik'
                'barang_kode' => 'PUP-001',
                'barang_nama' => 'Pupuk Kompos',
                'barang_slug' => 'pupuk-kompos',
                'barang_harga' => 15000,
                'barang_gambar' => 'pupuk_kompos.jpg',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'barang_id' => 2,
                'jenisbarang_id' => 2, // Fungisida
                'satuan_id' => 2, // Liter
                'klasifikasi_barang' => 'sekali_pakai', // Changed from 'Pestisida'
                'barang_kode' => 'FUN-001',
                'barang_nama' => 'Fungisida Antracol',
                'barang_slug' => 'fungisida-antracol',
                'barang_harga' => 75000,
                'barang_gambar' => 'antracol.jpg',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'barang_id' => 3,
                'jenisbarang_id' => 1, // Perkakas
                'satuan_id' => 3, // Buah
                'klasifikasi_barang' => 'berulang', // Changed from 'Alat Pertanian'
                'barang_kode' => 'PER-001',
                'barang_nama' => 'Cangkul',
                'barang_slug' => 'cangkul',
                'barang_harga' => 85000,
                'barang_gambar' => 'cangkul.jpg',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'barang_id' => 4,
                'jenisbarang_id' => 10, // Bahan Bakar
                'satuan_id' => 2, // Liter
                'klasifikasi_barang' => 'sekali_pakai', // Changed from 'Bahan Bakar Mesin'
                'barang_kode' => 'BBM-001',
                'barang_nama' => 'Solar',
                'barang_slug' => 'solar',
                'barang_harga' => 10000,
                'barang_gambar' => 'solar.jpg',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'barang_id' => 5,
                'jenisbarang_id' => 3, // Insektisida
                'satuan_id' => 2, // Liter
                'klasifikasi_barang' => 'sekali_pakai', // Changed from 'Pestisida'
                'barang_kode' => 'INS-001',
                'barang_nama' => 'Insektisida Decis',
                'barang_slug' => 'insektisida-decis',
                'barang_harga' => 120000,
                'barang_gambar' => 'decis.jpg',
                'user_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        // Insert data ke tbl_barang
        DB::table('tbl_barang')->insert($barang);

        // Data untuk tbl_barang_gudang (unchanged)
        $barangGudang = [
            [
                'barang_id' => 1,
                'gudang_id' => 1, // Gudang Utama
                'stok_tersedia' => 50,
                'stok_dipinjam' => 0,
                'stok_maintenance' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'barang_id' => 1,
                'gudang_id' => 2, // Gudang Cabang
                'stok_tersedia' => 30,
                'stok_dipinjam' => 5,
                'stok_maintenance' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'barang_id' => 2,
                'gudang_id' => 1,
                'stok_tersedia' => 20,
                'stok_dipinjam' => 2,
                'stok_maintenance' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'barang_id' => 3,
                'gudang_id' => 1,
                'stok_tersedia' => 15,
                'stok_dipinjam' => 3,
                'stok_maintenance' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'barang_id' => 4,
                'gudang_id' => 1,
                'stok_tersedia' => 100,
                'stok_dipinjam' => 0,
                'stok_maintenance' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'barang_id' => 5,
                'gudang_id' => 1,
                'stok_tersedia' => 25,
                'stok_dipinjam' => 0,
                'stok_maintenance' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];

        // Insert data ke tbl_barang_gudang
        DB::table('tbl_barang_gudang')->insert($barangGudang);
    }
}