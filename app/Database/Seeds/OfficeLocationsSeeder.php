<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class OfficeLocationsSeeder extends Seeder
{
    public function run()
    {
        $data =   array(
            'id' => '1',
            'name' => 'OFFICE 1',
            'phone' => '9330109091',
            'email' => 'info@keylines.net',
            'address' => '36A',
            'country' => 'India',
            'state' => 'West Bengal',
            'city' => 'Netaji Nagar (Kolkata)',
            'locality' => 'Netaji Nagar (Kolkata)',
            'street_no' => '36A Chandi Ghosh Road',
            'zipcode' => '700040',
            'latitude' => '22.484',
            'longitude' => '830000',
            'status' => '1',
            'created_at' => '2024-10-08 16:06:00',
            'updated_at' => NULL
        );

        $builder = $this->db->table('office_locations');
        $builder->upsert($data);
    }
}
