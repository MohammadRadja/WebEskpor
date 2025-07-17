<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenanamanController extends Controller
{
    public function index(){
        return view('kepalakebun.penanaman.index');
    }
}
