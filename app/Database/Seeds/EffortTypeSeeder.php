<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EffortTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id' => '1',
            'name' => 'Meeting',
            'status' => '1',
            'created_at' => date('Y-m-d H:i:s'),
        ];
        $builder = $this->db->table('effort_type');
        $builder->upsert($data);
    }
}
