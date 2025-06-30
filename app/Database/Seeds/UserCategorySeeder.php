<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserCategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id' => '1',
            'name' => 'Management'
        ];

        $this->db->table('user_category')->upsert($data);
    }
}
