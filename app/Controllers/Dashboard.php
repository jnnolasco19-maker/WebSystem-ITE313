<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $session = session();
        if (! $session->get('user_id')) {
            return redirect()->to('/login');
        }

        return view('dashboard/index', [
            'userName' => $session->get('user_name')
        ]);
    }
}
