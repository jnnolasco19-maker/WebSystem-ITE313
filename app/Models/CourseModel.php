<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'description', 'created_by', 'created_at', 'updated_at', 'deleted_at'];
    
    // Enable soft deletes
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';

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
    
    /**
     * Get all courses including soft deleted ones
     * 
     * @return array Array of all course records including soft deleted
     */
    public function getAllCoursesWithTrashed()
    {
        return $this->withDeleted()->findAll();
    }
    
    /**
     * Get only soft deleted courses
     * 
     * @return array Array of soft deleted course records
     */
    public function getOnlyTrashed()
    {
        return $this->onlyDeleted()->findAll();
    }
    
    /**
     * Restore a soft deleted course
     * 
     * @param int $id Course ID to restore
     * @return bool Result of restore operation
     */
    public function restore($id)
    {
        return $this->save([
            'id' => $id,
            'deleted_at' => null
        ]);
    }
}