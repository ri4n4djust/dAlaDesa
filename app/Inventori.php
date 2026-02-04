<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventori extends Model
{
    //
    protected $table = 'tblInventori';
    protected $fillable = [
        'kdBarang', 'stkInventori', 'satuanInventori', 'hrgSatuan', 'stkSatuan'
        
    ];


}
