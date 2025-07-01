<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProjectCostSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id' => '1',
            'project_id' => '501',
            'month' => '10',
            'year' => '2024',
            'project_cost' => '690',
            'created_at' => '2024-10-08 21:39:40',
            'updated_at' => '2024-10-08 21:41:39'
        ];

        $this->db->table('project_cost')->upsert($data);
    }
}
