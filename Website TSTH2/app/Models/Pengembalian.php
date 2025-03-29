<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    use HasFactory;

    protected $table = 'tbl_pengembalian';
    protected $primaryKey = 'pengembalian_id';
    protected $fillable = [
        'peminjaman_id',
        'barang_id',
        'gudang_id',
        'user_id_pengembali',
        'jumlah',
        'tanggal_kembali_aktual',
        'kondisi',
        'catatan'
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'peminjaman_id');
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function pengembali()
    {
        return $this->belongsTo(UserModel::class, 'user_id_pengembali');
    }
}