<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    //
    protected $table = 'tblTmp_Transaksi';

    protected $fillable = [
        'noNota', 'pelangganNota', 'tglNota', 'totalNota','taxNota', 'diskonNota', 'bayarNota', 'kembalianNota'
    ];
}
