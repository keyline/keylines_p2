<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $department = array(
            array('id' => '1', 'deprt_name' => 'Designs', 'header_color' => '#d17b24', 'body_color' => '#f0e9d9', 'badge_bgcolor' => '#f9fb7e', 'badge_fontcolor' => '#0a0000', 'is_join_morning_meeting' => '1', 'rank' => '1', 'status' => '1', 'created_at' => '2024-07-29 16:43:36', 'updated_at' => '2024-10-24 14:44:36'),
            array('id' => '2', 'deprt_name' => 'Development', 'header_color' => '#799cb0', 'body_color' => '#d8f2ff', 'badge_bgcolor' => '#d1fa05', 'badge_fontcolor' => '#000000', 'is_join_morning_meeting' => '1', 'rank' => '3', 'status' => '1', 'created_at' => '2024-07-31 14:15:43', 'updated_at' => '2024-10-24 14:44:52'),
            array('id' => '3', 'deprt_name' => 'Digital', 'header_color' => '#ab79be', 'body_color' => '#dfc4ef', 'badge_bgcolor' => '#000000', 'badge_fontcolor' => '#ffffff', 'is_join_morning_meeting' => '1', 'rank' => '2', 'status' => '1', 'created_at' => '2024-07-29 16:43:13', 'updated_at' => '2024-10-24 14:45:15'),
            array('id' => '4', 'deprt_name' => 'Sales / Marketing', 'header_color' => '#0a4ff0', 'body_color' => '#95bae9', 'badge_bgcolor' => '#fcfe6c', 'badge_fontcolor' => '#050000', 'is_join_morning_meeting' => '0', 'rank' => '4', 'status' => '1', 'created_at' => '2024-07-31 14:14:40', 'updated_at' => '2024-10-24 14:46:01'),
            array('id' => '5', 'deprt_name' => 'Admin / Backoffice', 'header_color' => '#08b7e2', 'body_color' => '#ebf6ff', 'badge_bgcolor' => '#fffa75', 'badge_fontcolor' => '#050000', 'is_join_morning_meeting' => '1', 'rank' => '4', 'status' => '1', 'created_at' => '2024-07-31 14:14:46', 'updated_at' => '2024-10-24 14:45:35'),
            array('id' => '6', 'deprt_name' => 'Intern', 'header_color' => '#0092d1', 'body_color' => '#94dfff', 'badge_bgcolor' => NULL, 'badge_fontcolor' => NULL, 'is_join_morning_meeting' => '0', 'rank' => '5', 'status' => '1', 'created_at' => '2024-09-04 21:15:44', 'updated_at' => '2024-09-04 21:15:44'),
            array('id' => '7', 'deprt_name' => 'test - new department', 'header_color' => '#000000', 'body_color' => '#000000', 'badge_bgcolor' => '#000000', 'badge_fontcolor' => '#000000', 'is_join_morning_meeting' => '1', 'rank' => '1', 'status' => '1', 'created_at' => '2025-05-26 12:30:23', 'updated_at' => '2025-05-26 12:30:23')
        );

        $builder = $this->db->table('department');
        $builder->insertBatch($department);
    }
}
