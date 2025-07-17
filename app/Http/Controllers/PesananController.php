<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function show(){
        return view('sales.order.index');
    }
}
