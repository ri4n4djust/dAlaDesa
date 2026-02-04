<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    //
    protected $table = 'tblPenjualan';

    protected $fillable = [
        'noNota','userNota', 'noMeja', 'tglNota', 'totalNota', 'bayarNota', 'kembalianNota', 'pelangganNota', 'taxNota', 'diskonNota', 
        'waiterNota', 'typeNota', 'chargeNota', 'pax'
    ];
}
