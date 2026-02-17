<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $department = array(
            array('id' => '1', 'deprt_name' => 'Admin / Backoffice', 'header_color' => '#08b7e2', 'body_color' => '#ebf6ff', 'badge_bgcolor' => '#fffa75', 'badge_fontcolor' => '#050000', 'is_join_morning_meeting' => '1', 'rank' => '1', 'status' => '1', 'created_at' => '2024-07-31 14:14:46', 'updated_at' => '2024-10-24 14:45:35'),
        );

        $builder = $this->db->table('department');
        $builder->insertBatch($department);
    }
}
