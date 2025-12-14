<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        //return view('template/header');
    }

     public function restricted()
    {
        if(! session()->get('logged_in') &&  session()->get('user_status')!== 'restricted') {
            return redirect()->to('/login');

        }
        return view('restricted');
    }
}

