<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KartuStokInventori extends Model
{
    //
    protected $table = 'tblKartuStokInventori';

    protected $fillable = [
        'kdBarang', 'tglInv', 'qtyMasukInv', 'qtyKeluarInv', 'noTransaksiInv', 'keteranganKartuInv', 'satuanKartuInv' 
        
    ];
}
