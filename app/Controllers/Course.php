<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;
use App\Models\CourseModel;
use CodeIgniter\Controller;

class Course extends BaseController
{
    /**
     * Handle AJAX enrollment request
     * 
     * Security measures implemented:
     * - Authorization check (user must be logged in)
     * - CSRF protection (handled by CodeIgniter)
     * - Input validation (course_id must be valid integer)
     * - Duplicate enrollment prevention
     * - Course existence validation
     * - User ID from session (prevents data tampering)
     */
    public function enroll()
    {
        $session = session();

        // Check if user is logged in (Authorization Bypass protection)
        if (!$session->get('logged_in') || !$session->get('user_id')) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Unauthorized. Please log in to enroll in courses.'
            ])->setStatusCode(401);
        }

        // Get user_id from session (Data Tampering protection - never trust client-supplied user_id)
        $user_id = $session->get('user_id');
        
        // Get course_id from POST request
        $course_id = $this->request->getPost('course_id');

        // Input validation (Input Validation & SQL Injection protection)
        if (empty($course_id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No course selected.'
            ])->setStatusCode(400);
        }

        // Validate course_id is a valid integer (SQL Injection protection)
        if (!is_numeric($course_id) || (int)$course_id <= 0) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid course ID.'
            ])->setStatusCode(400);
        }

        $course_id = (int)$course_id;

        // Validate that the course exists (Input Validation)
        $courseModel = new CourseModel();
        $course = $courseModel->find($course_id);
        
        if (!$course) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Course not found.'
            ])->setStatusCode(404);
        }

        $enrollmentModel = new EnrollmentModel();

        // Check if already enrolled (Duplicate prevention)
        if ($enrollmentModel->isAlreadyEnrolled($user_id, $course_id)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'You are already enrolled in this course.'
            ])->setStatusCode(400);
        }

        // Enroll the user
        $data = [
            'user_id' => $user_id, // Always use session user_id, never client-supplied
            'course_id' => $course_id,
            'enrollment_date' => date('Y-m-d H:i:s')
        ];

        if ($enrollmentModel->enrollUser($data)) {
            // Check if AJAX request
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Successfully enrolled in ' . esc($course['title']) . '!',
                    'course' => [
                        'id' => $course['id'],
                        'title' => $course['title'],
                        'description' => $course['description']
                    ]
                ]);
            }
            // Regular form submission - redirect back
            return redirect()->back()->with('success', 'Successfully enrolled in ' . $course['title'] . '!');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Enrollment failed. Please try again.'
                ])->setStatusCode(500);
            }
            return redirect()->back()->with('error', 'Enrollment failed. Please try again.');
        }
    }
}

