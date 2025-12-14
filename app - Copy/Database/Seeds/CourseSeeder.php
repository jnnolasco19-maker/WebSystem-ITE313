<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'System Analysis and Design',
                'description' => 'Course on system analysis methodologies and techniques',
                'teacher_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Web Systems and Technologies',
                'description' => 'Course on web technologies and systems development',
                'teacher_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Advance Database Systems',
                'description' => 'In-depth study of advanced topics in databases',
                'teacher_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Systems Integration and Architecture',
                'description' => 'Learning about integration and architecture of complex systems',
                'teacher_id' => 2,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert multiple records into "courses" table
        $this->db->table('courses')->insertBatch($data);
    }
}
