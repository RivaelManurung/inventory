<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisBarang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_jenisbarang';
    protected $primaryKey = 'jenisbarang_id';
    protected $fillable = [
        'jenisbarang_nama',
        'jenisbarang_slug',
        'jenisbarang_ket'
    ];
    public function barangs(): HasMany
    {
        return $this->hasMany(Barang::class, 'jenisbarang_id', 'jenisbarang_id');
    }
}
