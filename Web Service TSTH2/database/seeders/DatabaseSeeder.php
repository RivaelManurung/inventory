<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            GudangSeeder::class,
            SatuanSeeder::class,
            JenisBarangSeeder::class,
            BarangSeeder::class,
            GudangSeeder::class,
            JenisTransaksiSeeder::class,
            StatusBarangSeeder::class,
            
        ]);
    }
}
