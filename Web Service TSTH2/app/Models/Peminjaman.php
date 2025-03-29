<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjaman extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tbl_peminjaman';
    protected $primaryKey = 'peminjaman_id';
    protected $fillable = [
        'barang_id',
        'gudang_id',
        'user_id_peminjam',
        'jumlah',
        'tanggal_pinjam',
        'tanggal_kembali',
        'status',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'gudang_id');
    }

    public function peminjam()
    {
        return $this->belongsTo(UserModel::class, 'user_id_peminjam');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'peminjaman_id');
    }
}