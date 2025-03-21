<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_barang', function (Blueprint $table) {
            $table->increments('barang_id');
            $table->unsignedBigInteger('jenisbarang_id')->nullable();
            $table->foreign('jenisbarang_id')->references('jenisbarang_id')->on('tbl_jenisbarang')->onDelete('set null');
            $table->string('satuan_id')->nullable();
            $table->string('gudang_id')->nullable();
            $table->string('barang_kode');
            $table->string('barang_nama');
            $table->string('barang_slug');
            $table->string('barang_harga');
            $table->string('barang_stok');
            $table->string('barang_gambar');
            $table->string('barcode');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_barang');
    }
};
