<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_barang';
    protected $primaryKey = 'barang_id';
    protected $fillable = [
        'jenisbarang_id',
        'satuan_id',
        'klasifikasi_barang',
        'barang_kode',
        'barang_nama',
        'barang_slug',
        'barang_harga',
        'barang_gambar',
        'user_id'
    ];

    public function jenis()
    {
        return $this->belongsTo(JenisBarang::class, 'jenisbarang_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }
}