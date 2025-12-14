<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'created_by', 'created_at', 'updated_at'];

    /**
     * Get all available courses (not enrolled by user)
     * 
     * @param int $user_id User ID to exclude enrolled courses
     * @return array Array of course records
     */
    public function getAvailableCourses($user_id = null)
    {
        if ($user_id === null) {
            return $this->findAll();
        }
        
        // Get enrolled course IDs for this user
        $enrolledCourseIds = $this->db->table('enrollments')
            ->select('course_id')
            ->where('user_id', $user_id)
            ->get()
            ->getResultArray();
        
        $ids = array_column($enrolledCourseIds, 'course_id');
        
        if (empty($ids)) {
            return $this->findAll();
        }
        
        // Get courses that the user is NOT enrolled in
        return $this->whereNotIn('id', $ids)->findAll();
    }

    /**
     * Get all courses
     * 
     * @return array Array of all course records
     */
    public function getAllCourses()
    {
        return $this->findAll();
    }
}

