<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokOpname extends Model
{
    //
    protected $table = 'tblStokOpname';

    protected $fillable = [
        'tglStok', 'noStokOpname', 'totalOpname' 
        
    ];
}
