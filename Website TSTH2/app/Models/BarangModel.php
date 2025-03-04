<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangModel extends Model
{
    use HasFactory;
    protected $table = "tbl_barang";
    protected $primaryKey = 'barang_id';
    protected $fillable = [
        'jenisbarang_id',
        'satuan_id',
        'gudang_id',
        'barang_kode',
        'barang_nama',
        'barang_slug',
        'barang_harga',
        'barang_stok',
        'barang_gambar',
        'jenis_barang',
        'barcode'
    ];
    public function jenisBarang()
    {
        return $this->belongsTo(JenisBarangModel::class, 'jenisbarang_id', 'jenisbarang_id');
    }
    public function satuan()
{
    return $this->belongsTo(SatuanModel::class, 'satuan_id', 'satuan_id');
}
public function gudang()
{
    return $this->belongsTo(GudangModel::class, 'gudang_id', 'gudang_id');
}

}
