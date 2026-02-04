<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pembayara extends Model
{
    //
    protected $table = 'tblPembayaran';

    protected $fillable = [
        'notaPembayaran', 'diskonPembayaran', 'pajakPembayaran', 'typePembayaran', 
        'chargePembayaran', 'noKartuPembayaran'
    ];
}
