<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class GudangSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_gudang')->insert([
            [
                'gudang_id' => 1,
                'gudang_nama' => 'Gudang Pertama TSTH2 Aek Nauli',
                'gudang_slug' => 'gudang-pertama-tsth2-aek-nauli',
                'gudang_deskripsi' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 2,
                'gudang_nama' => 'Gudang Kedua TSTH2 Aek Nauli',
                'gudang_slug' => 'gudang-kedua-tsth2-aek-nauli',
                'gudang_deskripsi' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 3,
                'gudang_nama' => 'Gudang Ketiga TSTH2 Aek Nauli',
                'gudang_slug' => 'gudang-ketiga-tsth2-aek-nauli',
                'gudang_deskripsi' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 4,
                'gudang_nama' => 'Gudang Pertama Food Estate',
                'gudang_slug' => 'gudang-pertama-food-estate',
                'gudang_deskripsi' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 5,
                'gudang_nama' => 'Lainnya (Lapangan)',
                'gudang_slug' => 'lainnya-lapangan',
                'gudang_deskripsi' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 6,
                'gudang_nama' => 'Gudang Utilitas',
                'gudang_slug' => 'gudang-utilitas',
                'gudang_deskripsi' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'gudang_id' => 7,
                'gudang_nama' => 'Rusun',
                'gudang_slug' => 'rusun',
                'gudang_deskripsi' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}