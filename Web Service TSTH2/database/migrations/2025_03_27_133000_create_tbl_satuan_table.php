<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_satuan', function (Blueprint $table) {
            $table->increments('satuan_id');
            $table->string('satuan_nama');
            $table->string('satuan_slug')->unique();
            $table->string('satuan_keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_satuan');
    }
};