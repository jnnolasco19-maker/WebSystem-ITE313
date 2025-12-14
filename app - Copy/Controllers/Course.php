<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;
use CodeIgniter\Controller;

class Course extends Controller
{
    public function enroll()
    {
        $session = session();

        // Check if user is logged in
        if (!$session->has('userID')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'User not logged in.'
            ]);
        }

        $user_id = $session->get('userID');
        $course_id = $this->request->getPost('course_id');

        if (!$course_id) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No course selected.'
            ]);
        }

        $enrollmentModel = new EnrollmentModel();

        // Check if already enrolled
        if ($enrollmentModel->isAlreadyEnrolled($user_id, $course_id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'You are already enrolled in this course.'
            ]);
        }

        // Enroll the user
        $data = [
            'user_id' => $user_id,
            'course_id' => $course_id,
            'enrollment_date' => date('Y-m-d H:i:s')
        ];

        if ($enrollmentModel->enrollUser($data)) {
            // Create a notification for the student with course title
            $courseModel = new \App\Models\CourseModel();
            $course = $courseModel->find($course_id);
            $courseTitle = $course && isset($course['title']) ? $course['title'] : 'the course';

            $notifModel = new \App\Models\NotificationModel();
            $notifModel->insert([
                'user_id' => $user_id,
                'message' => 'You have successfully enrolled in ' . $courseTitle . '.',
                'is_read' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Enrollment successful.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Enrollment failed. Please try again.'
            ]);
        }
    }

    public function search()
    {
        $request = $this->request;
        $searchTerm = $request->getGet('search_term');
        if ($searchTerm === null) {
            // If not found in GET, check POST
            $searchTerm = $request->getPost('search_term');
        }
        $courseModel = new \App\Models\CourseModel();

        if (!empty($searchTerm)) {
            $courses = $courseModel
                ->groupStart()
                ->like('title', $searchTerm)
                ->orLike('description', $searchTerm)
                ->groupEnd()
                ->findAll();
        } else {
            $courses = $courseModel->findAll();
        }

        if ($request->isAJAX()) {
            return $this->response->setJSON(['courses' => $courses]);
        }
        // Pass searchTerm for optional display
        return view('courses/courses', [
            'courses' => $courses,
            'searchTerm' => $searchTerm
        ]);
    }
}