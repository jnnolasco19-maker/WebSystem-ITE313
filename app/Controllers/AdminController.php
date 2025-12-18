<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class AdminController extends BaseController
{
    protected $userModel;
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    // Check if user is admin
    private function checkAdmin()
    {
        if (session()->get('user_role') !== 'admin') {
            return redirect()->to('/dashboard');
        }
        return true;
    }

    // Dashboard with real statistics
    public function dashboard()
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        // Get recent courses with instructor names
        $recentCourses = $this->courseModel
            ->select('courses.*, users.name as instructor_name')
            ->join('users', 'users.id = courses.created_by', 'left')
            ->orderBy('courses.created_at', 'DESC')
            ->limit(5)
            ->findAll();

        $data = [
            'totalStudents' => $this->userModel->where('role', 'student')->countAllResults(),
            'totalInstructors' => $this->userModel->where('role', 'instructor')->countAllResults(),
            'totalCourses' => $this->courseModel->countAllResults(),
            'totalEnrollments' => $this->enrollmentModel->countAllResults(),
            'restrictedUsers' => $this->userModel->where('status', 'restricted')->countAllResults(),
            'recentUsers' => $this->userModel->orderBy('created_at', 'DESC')->limit(5)->findAll(),
            'recentCourses' => $recentCourses,
        ];

        return view('admin/dashboard', $data);
    }

    // ==================== USER MANAGEMENT ====================

    public function users()
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        $search = $this->request->getGet('search');

        // Get all users including soft deleted ones
        $builder = $this->userModel->withDeleted();
        
        if ($search) {
            $builder = $builder->groupStart()
                ->like('name', $search)
                ->orLike('email', $search)
                ->groupEnd();
        }

        $users = $builder->orderBy('created_at', 'DESC')->findAll();

        // Get enrollment count for students
        foreach ($users as &$user) {
            if ($user['role'] === 'student') {
                $user['enrollment_count'] = $this->enrollmentModel->where('user_id', $user['id'])->countAllResults();
            } else {
                $user['enrollment_count'] = 0;
            }
            // Add a flag to indicate if the user is soft deleted
            $user['is_deleted'] = !empty($user['deleted_at']);
        }

        $data = [
            'users' => $users,
            'search' => $search ?? '',
            'editUser' => null
        ];

        return view('admin/users', $data);
    }

    public function editUser($id)
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        $search = $this->request->getGet('search') ?? '';

        $data = [
            'users' => $this->userModel->orderBy('created_at', 'DESC')->findAll(),
            'search' => $search,
            'role' => '',
            'status' => '',
            'editUser' => $this->userModel->find($id)
        ];

        return view('admin/users', $data);
    }

    public function updateUser()
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        $rules = [
            'id' => 'required|numeric',
            'name' => 'required|min_length[3]|max_length[100]|regex_match[/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/]',
            'role' => 'required|in_list[instructor,student]',
            'status' => 'required|in_list[granted,restricted]'
        ];

        // Add password validation only if password is provided
        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->listErrors());
        }

        $id = $this->request->getPost('id');
        
        // Prevent self-demotion
        if ($id == session()->get('user_id') && $this->request->getPost('role') !== 'admin') {
            return redirect()->back()->with('error', 'You cannot change your own role.');
        }

        $updateData = [
            'name' => $this->request->getPost('name'),
            'role' => $this->request->getPost('role'),
            'status' => $this->request->getPost('status'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        // Only update password if provided
        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to('/admin/users')->with('success', 'User updated successfully.');
    }

    public function createUser()
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]|regex_match[/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'role' => 'required|in_list[instructor,student]',
            'status' => 'required|in_list[granted,restricted]',
            'password' => 'required|min_length[8]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->listErrors())->withInput();
        }

        $this->userModel->insert([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'role' => $this->request->getPost('role'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'status' => $this->request->getPost('status'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/users')->with('success', 'User created successfully.');
    }

    public function deleteUser($id)
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        // Prevent self-deletion
        if ($id == session()->get('user_id')) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Get the user to be deleted
        $user = $this->userModel->find($id);
        
        // Check if user exists
        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Prevent deletion of instructors
        if ($user['role'] === 'instructor') {
            return redirect()->back()->with('error', 'You cannot delete instructors. Only students can be deleted.');
        }

        // Soft delete the user (students only)
        $this->userModel->delete($id);

        return redirect()->to('/admin/users')->with('success', 'Student deleted successfully.');
    }

    public function restoreUser($id)
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        // Restore the soft deleted user
        $result = $this->userModel->restore($id);

        if ($result) {
            return redirect()->to('/admin/users')->with('success', 'User restored successfully.');
        } else {
            return redirect()->to('/admin/users')->with('error', 'Failed to restore user.');
        }
    }

    // ==================== COURSE MANAGEMENT ====================

    public function courses()
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        $search = $this->request->getGet('search');

        // Get all courses including soft deleted ones
        $builder = $this->courseModel->withDeleted();
        
        if ($search) {
            $builder = $builder->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->groupEnd();
        }

        $courses = $builder->orderBy('created_at', 'DESC')->findAll();

        // Get enrollment count for each course
        foreach ($courses as &$course) {
            $course['enrollment_count'] = $this->enrollmentModel->where('course_id', $course['id'])->countAllResults();
            // Add a flag to indicate if the course is soft deleted
            $course['is_deleted'] = !empty($course['deleted_at']);
        }

        $data = [
            'courses' => $courses,
            'search' => $search ?? '',
            'instructors' => $this->userModel->where('role', 'instructor')->findAll(),
            'editCourse' => null
        ];

        return view('admin/courses', $data);
    }

    public function editCourse($id)
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        $courses = $this->courseModel->orderBy('created_at', 'DESC')->findAll();
        foreach ($courses as &$course) {
            $course['enrollment_count'] = $this->enrollmentModel->where('course_id', $course['id'])->countAllResults();
        }

        $data = [
            'courses' => $courses,
            'search' => '',
            'instructors' => $this->userModel->where('role', 'instructor')->findAll(),
            'editCourse' => $this->courseModel->find($id)
        ];

        return view('admin/courses', $data);
    }

    public function createCourse()
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        $rules = [
            'title' => 'required|min_length[3]|max_length[200]',
            'description' => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->listErrors())->withInput();
        }

        $this->courseModel->insert([
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'created_by' => $this->request->getPost('instructor_id') ?: session()->get('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/courses')->with('success', 'Course created successfully.');
    }

    public function updateCourse()
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        $rules = [
            'id' => 'required|numeric',
            'title' => 'required|min_length[3]|max_length[200]',
            'description' => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->listErrors());
        }

        $this->courseModel->update($this->request->getPost('id'), [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'created_by' => $this->request->getPost('instructor_id'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/courses')->with('success', 'Course updated successfully.');
    }

    public function deleteCourse($id)
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        // Instead of deleting enrollments and course, we'll soft delete the course
        // The enrollments will remain in the database
        
        // Soft delete the course
        $this->courseModel->delete($id);

        return redirect()->to('/admin/courses')->with('success', 'Course deleted successfully.');
    }

    public function restoreCourse($id)
    {
        if ($this->checkAdmin() !== true) return $this->checkAdmin();

        // Restore the soft deleted course
        $result = $this->courseModel->restore($id);

        if ($result) {
            return redirect()->to('/admin/courses')->with('success', 'Course restored successfully.');
        } else {
            return redirect()->to('/admin/courses')->with('error', 'Failed to restore course.');
        }
    }
}
