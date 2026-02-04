<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = 'tblMenu';

    protected $fillable = [
        'kdMenu', 'nmMenu', 'hargaMenu', 'stokMenu', 'hppMenu', 'ktgMenu', 'promoMenu'

    ];
}
