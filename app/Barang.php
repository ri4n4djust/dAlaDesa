<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //
    protected $table = 'tblBarang';

    protected $fillable = [
        'nmBarang', 'hrgPokok', 'hrgJual', 'stkBarang', 'deskripsi', 'gmbrBarang', 'ktgBarang', 'satuanBarang', 
        'merek', 'qtyMin', 'qtyMax', 'kdBarang', 'stsBarang'
    ];
}
