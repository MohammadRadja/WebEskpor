<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function show(){
        return view('sales.berita.index');
    }
    public function addShow(){
        return view('sales.berita.addNews');
    }
    public function editShow(){
        return view('sales.berita.editNews');
    }
}
