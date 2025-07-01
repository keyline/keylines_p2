<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id' => '627',
            'entried_by' => '56',
            'client_of' => '56',
            'role_id' => '0',
            'name' => 'XHQJdBHGIeaHiWIIOByOxA==',
            'compnay' => 'NqOrUijANwCFEZRN9t0g5w==',
            'address_1' => 'Addresss',
            'state' => 'West Bengal',
            'city' => 'Netaji Nagar (Kolkata)',
            'country' => 'India',
            'pin' => '700040',
            'address_2' => '',
            'email_1' => 'OFcW1vqBQzoAT5N/lzZVEWf9QllNVe815rYsvChJ/uo=',
            'email_2' => 'So8JtTJzkXt07njlxdHwKg==',
            'phone_1' => 'WG5ukv5lUZ3akuiQ0tFF7w==',
            'phone_2' => 'So8JtTJzkXt07njlxdHwKg==',
            'dob_day' => '',
            'dob_month' => '',
            'dob_year' => '',
            'password_md5' => '81dc9bdb52d04dc20036dbd8313ed055',
            'password_org' => '1234',
            'comment' => '',
            'reference' => '',
            'added_date' => '2024-10-08 15:50:07',
            'login_access' => '1',
            'last_login' => '2024-10-08 15:50:07',
            'encoded_email' => NULL,
            'encoded_phone' => NULL
        ];

        $builder = $this->db->table('client');
        $builder->upsert($data);
    }
}
