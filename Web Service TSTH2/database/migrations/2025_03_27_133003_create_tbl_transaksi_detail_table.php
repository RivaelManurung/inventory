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
        Schema::create('tbl_transaksi_detail', function (Blueprint $table) {
    $table->increments('transaksi_detail_id');
    $table->unsignedInteger('transaksi_id');
    $table->unsignedInteger('barang_id');
    $table->unsignedInteger('gudang_id');
    $table->unsignedInteger('status_barang_id');
    $table->integer('quantity');
    $table->timestamps();

    $table->foreign('transaksi_id')->references('transaksi_id')->on('tbl_transaksi');
    $table->foreign('barang_id')->references('barang_id')->on('tbl_barang');
    $table->foreign('gudang_id')->references('gudang_id')->on('tbl_gudang');
    $table->foreign('status_barang_id')->references('status_id')->on('tbl_status_barang');
    $table->unique(['transaksi_id', 'barang_id', 'gudang_id'], 'transaction_details_unique');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksi_detail');
    }
};
