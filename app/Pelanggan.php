<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    //
    //
    protected $table = 'tblPelanggan';

    protected $fillable = [
        'kdPelanggan', 'nmPelanggan', 'almtPelanggan', 'noHpPelanggan'
    ];
}
