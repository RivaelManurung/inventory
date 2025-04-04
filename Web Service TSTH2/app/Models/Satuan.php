<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Satuan extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_satuan';
    protected $primaryKey = 'satuan_id';
    protected $fillable = [
        'satuan_nama',
        'satuan_slug',
        'satuan_keterangan'
    ];
    public function barangs()
    {
        return $this->hasMany(Barang::class, 'satuan_id');
    }
}
