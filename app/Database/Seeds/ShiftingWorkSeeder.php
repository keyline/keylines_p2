<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ShiftingWorkSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'shifting_name' => 'Morning Shift',
                'shift_in_time' => '08:00',
                'shift_out_time' => '16:00',
                'status' => 1,
                'created_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'shifting_name' => 'Afternoon Shift',
                'shift_in_time' => '10:00',
                'shift_out_time' => '19:00',
                'status' => 1,
                'created_at'    => date('Y-m-d H:i:s'),
            ],
        ];

        $this->db->table('shifting_work_details')->insertBatch($data);
    }
}
