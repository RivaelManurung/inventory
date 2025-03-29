<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_barang_gudang', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('barang_id');
            $table->unsignedInteger('gudang_id');
            $table->integer('stok_tersedia')->default(0);
            $table->integer('stok_dipinjam')->default(0);
            $table->integer('stok_maintenance')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('barang_id')->references('barang_id')->on('tbl_barang');
            $table->foreign('gudang_id')->references('gudang_id')->on('tbl_gudang');
            $table->unique(['barang_id', 'gudang_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_barang_gudang');
    }
};