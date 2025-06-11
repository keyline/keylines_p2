<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run()
    {
        $project = array(
            array('id' => '501', 'name' => 'Demo Project', 'description' => '', 'assigned_by' => '56', 'status' => '1', 'hour' => '100', 'hour_month' => NULL, 'project_time_type' => 'Onetime', 'date_added' => '2024-10-08 16:07:02', 'date_modified' => '2024-10-08 16:07:02', 'client_id' => '627', 'temporary_url' => '', 'permanent_url' => '', 'client_service' => '56', 'start_date' => '2024-10-08', 'deadline' => '2024-10-09', 'parent' => '0', 'bill' => '1', 'type' => 'Own', 'active' => '0'),
            array('id' => '502', 'name' => 'test test', 'description' => '', 'assigned_by' => '56', 'status' => '13', 'hour' => '300', 'hour_month' => NULL, 'project_time_type' => 'Onetime', 'date_added' => '2024-10-17 18:16:21', 'date_modified' => '2024-10-17 18:16:21', 'client_id' => '627', 'temporary_url' => '', 'permanent_url' => '', 'client_service' => '56', 'start_date' => '2024-10-18', 'deadline' => '2024-10-27', 'parent' => '0', 'bill' => '0', 'type' => 'Own', 'active' => '1')
        );

        $this->db->table('project')->insertBatch($project);
    }
}
