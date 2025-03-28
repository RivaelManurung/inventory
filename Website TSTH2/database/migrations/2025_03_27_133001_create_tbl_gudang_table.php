<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_gudang', function (Blueprint $table) {
            $table->increments('gudang_id');
            $table->string('gudang_nama');
            $table->string('gudang_slug')->unique();
            $table->text('gudang_deskripsi')->nullable();
            $table->timestamps();
            $table->softDeletes();  
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_gudang');
    }
};