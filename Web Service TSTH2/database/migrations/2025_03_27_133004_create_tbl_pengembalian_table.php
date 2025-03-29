<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_pengembalian', function (Blueprint $table) {
            $table->increments('pengembalian_id');
            $table->unsignedInteger('peminjaman_id');
            $table->unsignedInteger('barang_id');
            $table->unsignedInteger('gudang_id');
            $table->unsignedInteger('user_id_pengembali');
            $table->integer('jumlah');
            $table->dateTime('tanggal_kembali_aktual');
            $table->enum('kondisi', ['baik', 'rusak', 'hilang']);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('peminjaman_id')->references('peminjaman_id')->on('tbl_peminjaman');
            $table->foreign('barang_id')->references('barang_id')->on('tbl_barang');
            $table->foreign('gudang_id')->references('gudang_id')->on('tbl_gudang');
            $table->foreign('user_id_pengembali')->references('user_id')->on('tbl_user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_pengembalian');
    }
};