<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiDetail extends Model
{
    //
    protected $table = 'tblTmp_TransaksiDetail';

    protected $fillable = [
        'noNotaTmp', 'noMejaTmp', 'kdBarangTmp', 'hrgJualTmp', 'qtyTmp', 'totalTmp',
         'typeTmp', 'nmBarangTmp', 'note', 'ktgMenu', 'promoMenu'
    ];
}
