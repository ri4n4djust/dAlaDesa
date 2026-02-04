<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'tblOrder';

    protected $fillable = [
        'kdMenu', 'idMeja', 'wktOrder', 'waiterOrder', 'stsPrintOrder', 'qtyOrder',
        'noteOrder', 'ktgMenuOrder'

    ];
}
