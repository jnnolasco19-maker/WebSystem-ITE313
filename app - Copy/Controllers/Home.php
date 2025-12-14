<?php

namespace App\Controllers;

class Home extends BaseController
{
    // Homepage
    public function index()
    {
        return view('index'); 
    }

    // About page
    public function about()
    {
        return view('about'); 
    }

    // Contact page
    public function contact()
    {
        return view('contact'); 
    }
}
