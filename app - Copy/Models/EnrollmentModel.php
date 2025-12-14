<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments'; // name of your database table
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'course_id', 'enrollment_date'];

    // Insert a new enrollment record
    public function enrollUser($data)
    {
        return $this->insert($data);
    }

    // Get all courses a user is enrolled in
    public function getUserEnrollments($user_id)
    {
        return $this->where('user_id', $user_id)->findAll();
    }

    // Check if a user is already enrolled in a specific course
    public function isAlreadyEnrolled($user_id, $course_id)
    {
        return $this->where('user_id', $user_id)
                    ->where('course_id', $course_id)
                    ->first();
    }
}
