<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KartuStok extends Model
{
    //
    protected $table = 'tblKartuStok';

    protected $fillable = [
        'kdBarang', 'tglKartu', 'qtyMasuk', 'qtyKeluar', 'noTransaksi', 'keteranganKartu', 'satuanKartu' 
        
    ];
}
