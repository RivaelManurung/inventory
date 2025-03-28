<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_peminjaman', function (Blueprint $table) {
            $table->increments('peminjaman_id');
            $table->unsignedInteger('barang_id');
            $table->unsignedInteger('gudang_id');
            $table->unsignedInteger('user_id_peminjam');
            $table->integer('jumlah');
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali');
            $table->enum('status', ['dipinjam', 'dikembalikan', 'hilang', 'rusak']);
            $table->text('keterangan')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('barang_id')->references('barang_id')->on('tbl_barang');
            $table->foreign('gudang_id')->references('gudang_id')->on('tbl_gudang');
            $table->foreign('user_id_peminjam')->references('user_id')->on('tbl_user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_peminjaman');
    }
};