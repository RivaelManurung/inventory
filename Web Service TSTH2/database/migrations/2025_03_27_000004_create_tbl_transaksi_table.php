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
        Schema::create('tbl_transaksi', function (Blueprint $table) {
            $table->increments('transaksi_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('transaction_type_id');
            $table->string('transaction_code')->unique();
            $table->timestamp('transaction_date');
            $table->timestamps();
        
            $table->foreign('user_id')->references('user_id')->on('tbl_user');
            $table->foreign('transaction_type_id')->references('transaction_type_id')->on('tbl_jenis_transaksi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_transaksi');
    }
};
