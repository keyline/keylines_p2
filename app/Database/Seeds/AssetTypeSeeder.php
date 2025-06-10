<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AssetTypeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id'         => 1,
                'type_name'  => 'Desktop',
                'status'     => 1,
                'added_on'   => '2023-02-19 12:05:56',
            ],
            [
                'id'         => 2,
                'type_name'  => 'Laptop',
                'status'     => 1,
                'added_on'   => '2023-02-19 12:07:00',
            ],
            [
                'id'         => 3,
                'type_name'  => 'iMac',
                'status'     => 1,
                'added_on'   => '2023-02-19 12:08:34',
            ],
            [
                'id'         => 4,
                'type_name'  => 'Wireless Mic',
                'status'     => 1,
                'added_on'   => '2023-02-19 12:09:59',
            ],
        ];

        $this->db->table('asset_type')->insertBatch($data);
    }
}
