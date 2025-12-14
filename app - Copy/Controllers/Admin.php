<?php

namespace App\Controllers;

use App\Models\CourseModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    public function coursesList()
    {
        $session = session();
        if (!in_array($session->get('role'), ['admin', 'teacher'])) {
            return redirect()->to('/login');
        }
        $courseModel = new CourseModel();
        $courses = $courseModel->findAll();
        return view('courses/courses', [
            'courses' => $courses,
        ]);
    }
}
