<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $role = $session->get('role');

        // not logged in
        if (! $session->get('isLoggedIn')) {
            return redirect()->to(site_url('login'));
        }

        $uri = $request->getUri()->getPath();

        // admin allowed only on /admin/*
        if ($role === 'admin' && str_starts_with($uri, 'admin')) {
            return;
        }

        // teacher allowed only on /teacher/*
        if ($role === 'teacher' && str_starts_with($uri, 'teacher')) {
            return;
        }

        // student allowed only on /student/* and /announcements
        if ($role === 'student' && 
           (str_starts_with($uri, 'student') || $uri === 'announcements')) {
            return;
        }

        // else → no permission
        $session->setFlashdata('error', 'Access Denied: Insufficient Permissions');
        return redirect()->to(site_url('announcements'));
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing needed after
    }
}
