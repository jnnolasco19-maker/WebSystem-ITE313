<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'email',
        'status',
        'role',
        'password',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    // Enable soft deletes
    protected $useSoftDeletes = true;
    protected $deletedField  = 'deleted_at';
    
    /**
     * Get all users including soft deleted ones
     * 
     * @return array Array of all user records including soft deleted
     */
    public function getAllUsersWithTrashed()
    {
        return $this->withDeleted()->findAll();
    }
    
    /**
     * Get only soft deleted users
     * 
     * @return array Array of soft deleted user records
     */
    public function getOnlyTrashed()
    {
        return $this->onlyDeleted()->findAll();
    }
    
    /**
     * Restore a soft deleted user
     * 
     * @param int $id User ID to restore
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