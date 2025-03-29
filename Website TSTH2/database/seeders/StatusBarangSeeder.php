<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusBarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'nama_status' => 'tersedia',
                'deskripsi' => 'Barang tersedia di gudang dan siap digunakan'
            ],
            [
                'nama_status' => 'dipinjam',
                'deskripsi' => 'Barang sedang dipinjam oleh pengguna'
            ],
            [
                'nama_status' => 'maintenance',
                'deskripsi' => 'Barang sedang dalam perbaikan/perawatan'
            ],
            [
                'nama_status' => 'digunakan',
                'deskripsi' => 'Barang sedang digunakan (untuk barang tidak dipinjam)'
            ],
            [
                'nama_status' => 'dikembalikan',
                'deskripsi' => 'Barang telah dikembalikan setelah dipinjam'
            ],
        ];

        DB::table('tbl_status_barang')->insert($statuses);
    }
}