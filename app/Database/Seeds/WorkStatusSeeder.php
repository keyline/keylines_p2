<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class WorkStatusSeeder extends Seeder
{
    public function run()
    {
        $work_status = array(
            array('id' => '1', 'name' => 'Finish & Close', 'background_color' => '#ddffd6', 'border_color' => '#000000', 'is_schedule' => '1', 'is_reassign' => '0', 'status' => '1', 'created_at' => '2024-10-08 15:38:39', 'updated_at' => '2024-10-08 16:11:26'),
            array('id' => '2', 'name' => 'Not finished', 'background_color' => '#ffc88a', 'border_color' => '#000000', 'is_schedule' => '1', 'is_reassign' => '1', 'status' => '1', 'created_at' => '2024-10-08 15:47:41', 'updated_at' => NULL)
        );

        $this->db->table('work_status')->insertBatch($work_status);
    }
}
