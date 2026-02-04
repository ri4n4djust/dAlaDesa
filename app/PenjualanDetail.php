<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PenjualanDetail extends Model
{
    //
    protected $table = 'tblPenjualanDetail';

    protected $fillable = [
        'noNota', 'noMeja', 'kdBarang', 'hrgJual', 'qty', 'total', 'type', 
        'nmBarang', 'note'
    ];
}
