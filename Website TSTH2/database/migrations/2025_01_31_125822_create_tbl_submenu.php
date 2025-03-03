<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tbl_submenu', function (Blueprint $table) {
            $table->increments('submenu_id');
            $table->string('menu_id');
            $table->string('submenu_judul');
            $table->string('submenu_slug');
            $table->string('submenu_redirect');
            $table->string('submenu_sort');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_submenu');
    }
};
