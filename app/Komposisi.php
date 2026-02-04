<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Komposisi extends Model
{
    //
    protected $table = 'tblKomposisi';

    protected $fillable = [
        'idMenu', 'idBarang', 'qtyBarang', 'hargaBarang', 'totalBarang', 'satuanBarang', 'totalSatuan'
    ];
}
