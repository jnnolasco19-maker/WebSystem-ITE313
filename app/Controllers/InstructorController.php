<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

class InstructorController extends BaseController
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

    private function checkInstructor()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        if (session()->get('user_role') !== 'instructor') {
            return redirect()->to('/dashboard');
        }
        return true;
    }

    private function getInstructorData()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);
        
        // Get instructor's courses
        $myCourses = $this->courseModel->where('created_by', $userId)->findAll();
        
        // Get total students enrolled in instructor's courses
        $totalStudents = 0;
        foreach ($myCourses as $course) {
            $totalStudents += $this->enrollmentModel->where('course_id', $course['id'])->countAllResults();
        }
        
        // Add student count to each course
        foreach ($myCourses as &$course) {
            $course['student_count'] = $this->enrollmentModel->where('course_id', $course['id'])->countAllResults();
        }
        
        return [
            'user' => $user,
            'myCourses' => $myCourses,
            'myCoursesCount' => count($myCourses),
            'totalStudents' => $totalStudents,
        ];
    }

    public function dashboard()
    {
        if ($this->checkInstructor() !== true) return $this->checkInstructor();

        $data = $this->getInstructorData();
        
        // Get recent enrollments in instructor's courses
        $courseIds = array_column($data['myCourses'], 'id');
        $recentEnrollments = [];
        
        if (!empty($courseIds)) {
            $recentEnrollments = $this->enrollmentModel
                ->select('enrollments.*, courses.title as course_title, users.name as student_name')
                ->join('courses', 'courses.id = enrollments.course_id')
                ->join('users', 'users.id = enrollments.user_id')
                ->whereIn('enrollments.course_id', $courseIds)
                ->orderBy('enrollments.enrollment_date', 'DESC')
                ->limit(5)
                ->findAll();
        }
        
        $data['recentEnrollments'] = $recentEnrollments;
        
        return view('instructor/dashboard', $data);
    }

    public function myCourses()
    {
        if ($this->checkInstructor() !== true) return $this->checkInstructor();

        $data = $this->getInstructorData();
        
        // Add enrollment count for each course
        foreach ($data['myCourses'] as &$course) {
            $course['enrollment_count'] = $this->enrollmentModel->where('course_id', $course['id'])->countAllResults();
        }
        
        return view('instructor/my_courses', $data);
    }

    public function createCourse()
    {
        if ($this->checkInstructor() !== true) return $this->checkInstructor();

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
            'created_by' => session()->get('user_id'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/instructor/my-courses')->with('success', 'Course created successfully.');
    }

    public function editCourse($id)
    {
        if ($this->checkInstructor() !== true) return $this->checkInstructor();

        $course = $this->courseModel->find($id);
        
        // Check if instructor owns this course
        if (!$course || $course['created_by'] != session()->get('user_id')) {
            return redirect()->to('/instructor/my-courses')->with('error', 'Course not found or access denied.');
        }

        $data = $this->getInstructorData();
        $data['editCourse'] = $course;
        
        // Add enrollment count for each course
        foreach ($data['myCourses'] as &$course) {
            $course['enrollment_count'] = $this->enrollmentModel->where('course_id', $course['id'])->countAllResults();
        }
        
        return view('instructor/my_courses', $data);
    }

    public function updateCourse()
    {
        if ($this->checkInstructor() !== true) return $this->checkInstructor();

        $rules = [
            'id' => 'required|numeric',
            'title' => 'required|min_length[3]|max_length[200]',
            'description' => 'permit_empty|max_length[1000]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('error', $this->validator->listErrors());
        }

        $courseId = $this->request->getPost('id');
        $course = $this->courseModel->find($courseId);
        
        // Check if instructor owns this course
        if (!$course || $course['created_by'] != session()->get('user_id')) {
            return redirect()->to('/instructor/my-courses')->with('error', 'Course not found or access denied.');
        }

        $this->courseModel->update($courseId, [
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/instructor/my-courses')->with('success', 'Course updated successfully.');
    }

    public function deleteCourse($id)
    {
        if ($this->checkInstructor() !== true) return $this->checkInstructor();

        $course = $this->courseModel->find($id);
        
        // Check if instructor owns this course
        if (!$course || $course['created_by'] != session()->get('user_id')) {
            return redirect()->to('/instructor/my-courses')->with('error', 'Course not found or access denied.');
        }

        // Delete course enrollments first
        $this->enrollmentModel->where('course_id', $id)->delete();
        
        // Delete course
        $this->courseModel->delete($id);

        return redirect()->to('/instructor/my-courses')->with('success', 'Course deleted successfully.');
    }

    public function students()
    {
        if ($this->checkInstructor() !== true) return $this->checkInstructor();

        $userId = session()->get('user_id');
        $data = $this->getInstructorData();
        
        // Get all students enrolled in instructor's courses
        $courseIds = array_column($data['myCourses'], 'id');
        $students = [];
        
        if (!empty($courseIds)) {
            $students = $this->enrollmentModel
                ->select('enrollments.*, courses.title as course_title, users.name as student_name, users.email as student_email')
                ->join('courses', 'courses.id = enrollments.course_id')
                ->join('users', 'users.id = enrollments.user_id')
                ->whereIn('enrollments.course_id', $courseIds)
                ->orderBy('enrollments.enrollment_date', 'DESC')
                ->findAll();
        }
        
        $data['students'] = $students;
        
        return view('instructor/students', $data);
    }

    public function profile()
    {
        if ($this->checkInstructor() !== true) return $this->checkInstructor();

        $data = $this->getInstructorData();
        return view('instructor/profile', $data);
    }

    public function updateProfile()
    {
        if ($this->checkInstructor() !== true) return $this->checkInstructor();

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

        return redirect()->to('/instructor/profile')->with('success', 'Profile updated successfully.');
    }
}