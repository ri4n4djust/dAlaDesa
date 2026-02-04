<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PembelianDetail extends Model
{
    //
    protected $table = 'tblPembelianDetail';

    protected $fillable = [
        'noNotaPembelian', 'kdBarang', 'hrgPokok', 'qtyBeli', 'totalBeli', 'qtySatuan'
    ];
}
