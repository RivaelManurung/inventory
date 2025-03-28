<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tbl_jenisbarang', function (Blueprint $table) {
            $table->increments('jenisbarang_id');
            $table->string('jenisbarang_nama');
            $table->string('jenisbarang_slug')->unique();
            $table->text('jenisbarang_ket')->nullable(); // Changed to text for longer descriptions
            $table->timestamps();
            $table->softDeletes(); // Added soft delete
        });
    }

    public function down()
    {
        Schema::dropIfExists('tbl_jenisbarang');
    }
};