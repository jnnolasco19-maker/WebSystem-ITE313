<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;

class Auth extends Controller
{
    // Registration
    public function register()
    {
        helper(['form']);
        $session = session();

        $db = \Config\Database::connect();

        //

        if (strtolower($this->request->getMethod()) === 'post') {
            $rules = [
                'name' => 'required|min_length[3]|max_length[50]',
                'email' => 'required|valid_email',
                'password' => 'required|min_length[6]',
                'password_confirm' => 'matches[password]'
            ];

            if (!$this->validate($rules)) {
                return view('auth/register', ['validation' => $this->validator]);
            }

            $userModel = new UserModel();

            // Check if email already exists
            $existingUser = $userModel->where('email', $this->request->getPost('email'))->first();
            if ($existingUser) {
                $session->setFlashdata('error', 'Email already exists.');
                return view('auth/register');
            }

            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => 'student',
            ];

            // Try insert
            if (!$userModel->insert($data)) {
                // Show detailed DB/model errors
                echo "<h3>⚠️ Registration Failed</h3>";
                echo "<pre>";
                print_r($userModel->errors()); // validation errors
                print_r($userModel->db->error()); // database errors
                echo "</pre>";
                exit;
            }

            $session->setFlashdata('success', 'Registration successful! Please log in.');
            return redirect()->to(site_url('/login'));
        }

        return view('auth/register');
    }

    // Login
    public function login()
{
    helper(['form']);
    $session = session();
    $userModel = new UserModel();

    if (strtolower($this->request->getMethod()) === 'post') {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];

        if (!$this->validate($rules)) {
            return view('auth/login', ['validation' => $this->validator]);
        }

        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $user = $userModel->where('email', $email)->first();

        if ($user && password_verify($password, $user['password'])) {
            // store user session data
            $session->set([
                'userID'     => $user['id'],
                'name'       => $user['name'],
                'email'      => $user['email'],
                'role'       => $user['role'],
                'isLoggedIn' => true,
            ]);

            // role-based redirect
            switch ($user['role']) {
                case 'student':
                    return redirect()->to(site_url('announcements'));
                case 'teacher':
                    return redirect()->to(site_url('teacher/dashboard'));
                case 'admin':
                    return redirect()->to(site_url('admin/dashboard'));
                default:
                    return redirect()->to(site_url('/dashboard')); // fallback
            }
        } else {
            $session->setFlashdata('error', 'Invalid email or password.');
        }
    }

    return view('auth/login');
}


    // Logout
    public function logout()
    {
        session()->destroy();
        return redirect()->to(site_url('/login'));
    }

    // Dashboard
    public function dashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(site_url('/login'));
        }

        $role = $session->get('role');
        if ($role === 'student') {
            return redirect()->to(site_url('student/dashboard'));
        } elseif ($role === 'teacher') {
            return redirect()->to(site_url('teacher/dashboard'));
        } elseif ($role === 'admin') {
            return redirect()->to(site_url('admin/dashboard'));
        } else {
            return redirect()->to(site_url('/logout'));
        }
    }

    // Student dashboard logic (moved from dashboard())
    public function studentDashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(site_url('/login'));
        }
        $user_id = $session->get('userID');
        $courseModel = new \App\Models\CourseModel();
        $courses = $courseModel->findAll();
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $enrollments = $enrollmentModel->select('courses.id, courses.title, courses.description')->join('courses', 'courses.id = enrollments.course_id')->where('enrollments.user_id', $user_id)->findAll();
        $enrolledIds = array_column($enrollments, 'id');
        $available = array_filter($courses, function($c) use ($enrolledIds) { return !in_array($c['id'], $enrolledIds); });
        return view('auth/dashboard', [
            'name' => $session->get('name'),
            'role' => $session->get('role'),
            'enrollments' => $enrollments,
            'courses' => $available,
        ]);
    }

    // Stub for teacher dashboard
    public function teacherDashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(site_url('/login'));
        }
        return view('auth/teacher_dashboard', [
            'name' => $session->get('name'),
            'role' => $session->get('role'),
        ]);
    }

    // Stub for admin dashboard
    public function adminDashboard()
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(site_url('/login'));
        }
        $courseModel = new \App\Models\CourseModel();
        $courses = $courseModel->findAll();
        return view('auth/admin_dashboard', [
            'name' => $session->get('name'),
            'role' => $session->get('role'),
            'courses' => $courses,
        ]);
    }

    // Student courses - show enrolled courses with materials
    public function studentCourses()
    {
        $session = session();
        if (!$session->get('isLoggedIn') || $session->get('role') !== 'student') {
            return redirect()->to(site_url('/login'));
        }
        
        $user_id = $session->get('userID');
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $materialModel = new \App\Models\MaterialModel();
        
        // Get enrolled courses with materials
        $enrolledCourses = $enrollmentModel->select('courses.*')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->where('enrollments.user_id', $user_id)
            ->findAll();
        
        // Get materials for each course
        foreach ($enrolledCourses as &$course) {
            $course['materials'] = $materialModel->getMaterialsByCourse($course['id']);
        }
        
        return view('auth/student_courses', [
            'name' => $session->get('name'),
            'role' => $session->get('role'),
            'courses' => $enrolledCourses,
        ]);
    }
}