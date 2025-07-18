<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('pages.index');
    }

    public function about()
    {
        return view('pages.about');
    }
    public function contact()
    {
        return view('pages.contact');
    }
    public function product()
    {
        return view('pages.product');
    }
    public function blog()
    {
        return view('pages.blog');
    }
    public function cart()
    {
        return view('pages.cart');
    }
    public function message()
    {
        return view('pages.messages');
    }
}
