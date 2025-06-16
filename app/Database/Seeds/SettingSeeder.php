<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id' => 1,
            'amc_check_min' => 10,
            'check_description' => 'AMC Site Check',
            'check_span' => 15
        ];

        $this->db->table('setting')->upsert($data);
    }
}
