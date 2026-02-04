<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    //
    protected $table = 'tblPembelian';

    protected $fillable = [
        'noNotaPembelian', 'tglNotaPembelian', 'totalNotaPembelian', 'idSupplier', 'userPembelian'
    ];


}
