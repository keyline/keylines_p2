<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TeamSeeder extends Seeder
{
    public function run()
    {

        $team = array(
            array('id' => '1', 'dep_id' => '7', 'user_id' => '95', 'type' => 'Teamlead', 'created_at' => '2024-10-08 21:37:55', 'updated_at' => '2024-10-08 16:07:55'),
            array('id' => '2', 'dep_id' => '7', 'user_id' => '56', 'type' => 'Member', 'created_at' => '2024-10-08 21:38:02', 'updated_at' => '2024-10-08 16:08:02')
        );

        $this->db->table('team')->insertBatch($team);
    }
}
