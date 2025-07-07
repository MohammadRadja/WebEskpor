<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function tentang()
    {
        return view('user.tentang.index');
    }
    public function contact()
    {
        return view('user.contact.index');
    }
    public function service()
    {
        return view('user.service.index');
    }


}
