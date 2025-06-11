<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    public function run()
    {
        $project_status = array(
            array('id' => '1', 'name' => 'Development', 'status' => '1', 'created_at' => '2024-10-08 15:58:02', 'updated_at' => NULL),
            array('id' => '13', 'name' => 'Closed', 'status' => '1', 'created_at' => '2024-10-17 18:45:02', 'updated_at' => '2024-10-17 18:45:26')
        );

        $this->db->table('project_status')->insertBatch($project_status);
    }
}
