<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokOpnameDetail extends Model
{
    //
    protected $table = 'tblStokOpnameDetail';

    protected $fillable = [
        'kdBarang', 'tglStokOpname', 'qtyGudang', 'selisihStok', 'keteranganStok', 'noStokOpname', 'satuanStok', 'nilaiStok' 
        
    ];
}
