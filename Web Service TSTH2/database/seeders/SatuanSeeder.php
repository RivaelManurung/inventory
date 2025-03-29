<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SatuanSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_satuan')->insert([
            [
                'satuan_id' => 1,
                'satuan_nama' => 'Gulung',
                'satuan_slug' => 'gulung',
                'satuan_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'satuan_id' => 2,
                'satuan_nama' => 'Unit',
                'satuan_slug' => 'unit',
                'satuan_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'satuan_id' => 3,
                'satuan_nama' => 'Kg',
                'satuan_slug' => 'kg',
                'satuan_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'satuan_id' => 4,
                'satuan_nama' => 'Gram',
                'satuan_slug' => 'gram',
                'satuan_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'satuan_id' => 5,
                'satuan_nama' => 'Mililiter',
                'satuan_slug' => 'mililiter',
                'satuan_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'satuan_id' => 6,
                'satuan_nama' => 'Liter',
                'satuan_slug' => 'liter',
                'satuan_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'satuan_id' => 7,
                'satuan_nama' => 'buah',
                'satuan_slug' => 'buah',
                'satuan_keterangan' => NULL,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}