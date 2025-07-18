<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenanamanController extends Controller
{
    public function index(){
        return view('dashboard.farm-manager.penanaman.index');
    }
}
