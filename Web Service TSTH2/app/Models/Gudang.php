<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gudang extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_gudang';
    protected $primaryKey = 'gudang_id';
    protected $fillable = [
        'gudang_nama',
        'gudang_slug',
        'gudang_deskripsi'
    ];

    public function barangs()
    {
        return $this->belongsToMany(Barang::class, 'tbl_barang_gudang', 'gudang_id', 'barang_id')
            ->withPivot('stok_tersedia', 'stok_dipinjam', 'stok_maintenance')
            ->withTimestamps();
    }
}
