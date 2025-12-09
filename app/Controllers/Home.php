<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('index');  // Homepage view
    }

    public function about()
    {
        return view('about');  // About page view
    }

    public function contact()
    {
        return view('contact');  // Contact page view
    }
}
