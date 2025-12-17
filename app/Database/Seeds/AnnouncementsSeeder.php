<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Welcome to the Portal',
                'content' => 'This is your learning management system. Stay updated with announcements here.',
                'created_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Assignments',
                'content' => 'There will be upcoming Assignments. Please check your dashboard for the schedule.',
                'created_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // insert multiple rows
        $this->db->table('announcements')->insertBatch($data);
    }
}
