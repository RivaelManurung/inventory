<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisTransaksi extends Model
{
    use HasFactory;

    protected $table = 'tbl_jenis_transaksi';
    protected $primaryKey = 'transaction_type_id';
    protected $fillable = ['nama_transaksi'];

    // Jika perlu relasi ke tabel transaksi
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'transaction_type_id');
    }
}