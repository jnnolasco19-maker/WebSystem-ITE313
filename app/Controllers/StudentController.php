<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class StudentController extends BaseController
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

    private function checkStudent()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        if (session()->get('user_role') !== 'student') {
            return redirect()->to('/dashboard');
        }
        return true;
    }

    private function getStudentData()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        return [
            'user' => $user,
            'enrolledCourses' => $this->enrollmentModel->getUserEnrollments($userId),
            'enrolledCount' => $this->enrollmentModel->where('user_id', $userId)->countAllResults(),
        ];
    }

    public function dashboard()
    {
        if ($this->checkStudent() !== true) return $this->checkStudent();

        $userId = session()->get('user_id');
        $studentData = $this->getStudentData();
        
        // Get available courses
        $allCourses = $this->courseModel->getAllCourses();
        $enrolledCourseIds = array_column($studentData['enrolledCourses'], 'course_id');
        $availableCourses = array_filter($allCourses, function($course) use ($enrolledCourseIds) {
            return !in_array($course['id'], $enrolledCourseIds);
        });

        $data = array_merge($studentData, [
            'availableCourses' => array_values($availableCourses),
            'availableCount' => count($availableCourses),
        ]);

        return view('student/dashboard', $data);
    }

    public function myCourses()
    {
        if ($this->checkStudent() !== true) return $this->checkStudent();

        $data = $this->getStudentData();
        return view('student/my_courses', $data);
    }

    public function browseCourses()
    {
        if ($this->checkStudent() !== true) return $this->checkStudent();

        $userId = session()->get('user_id');
        $search = $this->request->getGet('search');
        
        $studentData = $this->getStudentData();
        $enrolledCourseIds = array_column($studentData['enrolledCourses'], 'course_id');

        // Get available courses with search
        $builder = $this->courseModel;
        if ($search) {
            $builder = $builder->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->groupEnd();
        }
        
        $allCourses = $builder->findAll();
        $availableCourses = array_filter($allCourses, function($course) use ($enrolledCourseIds) {
            return !in_array($course['id'], $enrolledCourseIds);
        });

        $data = array_merge($studentData, [
            'availableCourses' => array_values($availableCourses),
            'search' => $search ?? '',
        ]);

        return view('student/browse_courses', $data);
    }

    public function profile()
    {
        if ($this->checkStudent() !== true) return $this->checkStudent();

        $data = $this->getStudentData();
        return view('student/profile', $data);
    }

    public function updateProfile()
    {
        if ($this->checkStudent() !== true) return $this->checkStudent();

        $userId = session()->get('user_id');

        $rules = [
            'name' => 'required|min_length[3]|max_length[100]|regex_match[/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'min_length[8]';
            $rules['password_confirm'] = 'matches[password]';
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->listErrors());
        }

        $updateData = [
            'name' => $this->request->getPost('name'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->request->getPost('password')) {
            $updateData['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $updateData);

        return redirect()->to('/student/profile')->with('success', 'Profile updated successfully.');
    }

    public function unenroll($courseId)
    {
        if ($this->checkStudent() !== true) return $this->checkStudent();

        $userId = session()->get('user_id');

        // Check if enrolled
        $enrollment = $this->enrollmentModel->isAlreadyEnrolled($userId, $courseId);
        if (!$enrollment) {
            return redirect()->back()->with('error', 'You are not enrolled in this course.');
        }

        $this->enrollmentModel->where('user_id', $userId)->where('course_id', $courseId)->delete();

        return redirect()->back()->with('success', 'Successfully unenrolled from the course.');
    }
}
