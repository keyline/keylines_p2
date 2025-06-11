<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AttendancesSeeder extends Seeder
{
    public function run()
    {

    $attendances = array(
    array('id' => '1154','user_id' => '56','punch_date' => '2025-05-29','punch_in_time' => '16:55:11','punch_in_lat' => '22.4788407','punch_in_lng' => '88.3517785','punch_in_address' => '45/16, Surya Nagar Colony, Ashok Nagar, Tollygunge, Kolkata, West Bengal 700040, India','punch_in_image' => '683844169be78.jpg','punch_out_time' => '16:57:23','punch_out_lat' => '22.478821','punch_out_lng' => '88.351761','punch_out_address' => '45/30/1A, 45/30/1A, Surya Nagar Colony, Ashok Nagar, Tollygunge, Kolkata, West Bengal 700040, India','punch_out_image' => '6838449ab6b98.jpg','note' => NULL,'attendance_time' => '2','status' => '2','created_at' => '2025-05-29 16:55:10','updated_at' => '2025-05-29 16:57:23')
    );

        $builder = $this->db->table('attendances');
        $builder->upsert($attendances);
    }
}
