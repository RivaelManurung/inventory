<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusBarang extends Model
{
    use HasFactory;

    protected $table = 'tbl_status_barang';
    protected $primaryKey = 'status_id';
    protected $fillable = [
        'nama_status',
        'deskripsi'
    ];

    public function transaksiDetails()
    {
        return $this->hasMany(TransaksiDetail::class, 'status_barang_id');
    }
}