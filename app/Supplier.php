<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $table = 'tblSupplier';

    protected $fillable = [
        'kdSupplier', 'nmSupplier', 'almtSupplier', 'noHp', 'kontakSupplier'
    ];
}
