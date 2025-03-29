<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}