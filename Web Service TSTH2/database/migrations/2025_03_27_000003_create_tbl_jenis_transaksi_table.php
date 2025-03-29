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
        Schema::create('tbl_jenis_transaksi', function (Blueprint $table) {
            $table->increments('transaction_type_id');
            $table->string('nama_transaksi')->unique(); // Diubah dari enum ke string biasa
            $table->timestamps();
        });

        // Insert data default
        // DB::table('tbl_jenis_transaksi')->insert([
        //     ['nama_transaksi' => 'barang_masuk'],
        //     ['nama_transaksi' => 'barang_keluar'],
        //     ['nama_transaksi' => 'peminjaman'],
        //     ['nama_transaksi' => 'pengembalian'],
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_jenis_transaksi');
    }
};