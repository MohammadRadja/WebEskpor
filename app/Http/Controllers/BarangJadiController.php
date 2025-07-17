<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BarangJadiController extends Controller
{
    public function show(){
        return view('kepalakebun.barangjadi.index');
    } 
}
