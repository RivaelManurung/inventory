<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barang extends Model
{
    use HasFactory, SoftDeletes;

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

    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarang::class, 'jenisbarang_id');
    }

    public function satuan()
    {
        return $this->belongsTo(Satuan::class, 'satuan_id');
    }

    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id');
    }

    public function gudangs()
    {
        return $this->belongsToMany(Gudang::class, 'tbl_barang_gudang', 'barang_id', 'gudang_id')
                    ->withPivot('stok_tersedia', 'stok_dipinjam', 'stok_maintenance')
                    ->withTimestamps();
    }
}