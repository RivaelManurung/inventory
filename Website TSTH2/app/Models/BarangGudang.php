<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BarangGudang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_barang_gudang';
    protected $fillable = [
        'barang_id',
        'gudang_id',
        'stok_tersedia',
        'stok_dipinjam',
        'stok_maintenance'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }
}