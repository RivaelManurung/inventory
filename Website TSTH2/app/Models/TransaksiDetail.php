<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    use HasFactory;

    protected $table = 'tbl_transaksi_detail';
    protected $primaryKey = 'transaksi_detail_id';
    protected $fillable = [
        'transaksi_id',
        'barang_id',
        'gudang_id',
        'status_barang_id',
        'quantity'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function statusBarang()
    {
        return $this->belongsTo(StatusBarang::class, 'status_barang_id');
    }
}