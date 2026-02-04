<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Veritrans\Veritrans;

class paymentController extends Controller
{
    //
    
    public function __construct(){   
        Veritrans::$serverKey = 'Mid-server-8QwXN6peMqBFwonypG-rK4Jy';
        Veritrans::$isProduction = false;
    }
}
