<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gudang extends Model
{
    use SoftDeletes;

    protected $table = 'tbl_gudang';
    protected $primaryKey = 'gudang_id';
    protected $fillable = [
        'gudang_nama',
        'gudang_slug',
        'gudang_deskripsi'
    ];
}