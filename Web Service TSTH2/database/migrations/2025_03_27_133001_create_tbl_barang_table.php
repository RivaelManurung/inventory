<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_barang', function (Blueprint $table) {
            $table->increments('barang_id');
            $table->unsignedInteger('jenisbarang_id');
            $table->unsignedInteger('satuan_id');
            $table->enum('klasifikasi_barang', ['sekali_pakai', 'berulang']);
            $table->string('barang_kode')->unique();
            $table->string('barang_nama', 100);
            $table->string('barang_slug')->unique();
            $table->decimal('barang_harga', 12, 2);
            $table->string('barang_gambar')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        
            $table->foreign('jenisbarang_id')->references('jenisbarang_id')->on('tbl_jenisbarang');
            $table->foreign('satuan_id')->references('satuan_id')->on('tbl_satuan');
            $table->foreign('user_id')->references('user_id')->on('tbl_user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_barang');
    }
};