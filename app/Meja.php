<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meja extends Model
{
    //
    protected $table = 'tblMeja';

    protected $fillable = [
        'noMeja', 'paxMeja', 'time', 'status', 'waiterMeja'
    ];
}
