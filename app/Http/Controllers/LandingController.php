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
    public function blog()
    {
        return view('user.blog.index');
    }
    public function cart()
    {
        return view('user.cart.index');
    }
    public function messages()
    {
        return view('user.messages.index');
    }


}
