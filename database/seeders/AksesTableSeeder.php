<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AksesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tbl_akses')->insert([
            // Akses untuk menu_id 1667444041
            ['menu_id' => '1667444041', 'role_id' => 1, 'akses_type' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['menu_id' => '1667444041', 'role_id' => 1, 'akses_type' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['menu_id' => '1667444041', 'role_id' => 1, 'akses_type' => 'update', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['menu_id' => '1667444041', 'role_id' => 1, 'akses_type' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Akses untuk menu_id 1668509889
            ['menu_id' => '1668509889', 'role_id' => 1, 'akses_type' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['menu_id' => '1668509889', 'role_id' => 1, 'akses_type' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['menu_id' => '1668509889', 'role_id' => 1, 'akses_type' => 'update', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['menu_id' => '1668509889', 'role_id' => 1, 'akses_type' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],

            // Akses untuk submenu_id 9
            ['submenu_id' => 9, 'role_id' => 1, 'akses_type' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['submenu_id' => 9, 'role_id' => 1, 'akses_type' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['submenu_id' => 9, 'role_id' => 1, 'akses_type' => 'update', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['submenu_id' => 9, 'role_id' => 1, 'akses_type' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
