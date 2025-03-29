<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class JenisTransaksiSeeder extends Seeder
{
    public function run()
    {
        // Insert data default
        DB::table('tbl_jenis_transaksi')->insert([
            ['nama_transaksi' => 'barang_masuk'],
            ['nama_transaksi' => 'barang_keluar'],
            ['nama_transaksi' => 'peminjaman'],
            ['nama_transaksi' => 'pengembalian'],
        ]);
    }
}
