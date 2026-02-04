<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = [
        'nmBarang', 'hrgPokok', 'hrgJual', 'stkBarang', 'deskripsi', 'gmbrBarang'
    ];
}
