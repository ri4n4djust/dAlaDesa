<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Split extends Model
{
    //
    protected $table = 'splitPayment';

    protected $fillable = [
        'noNota', 'noMeja', 'groupNota', 'kdBarang', 'nmBarang', 'hrgBarang', 'qtyBarang', 'subTotal', 'bayar', 'kembalian'
    ];
}
