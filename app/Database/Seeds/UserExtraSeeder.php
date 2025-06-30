<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserExtraSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'id' => '1',
            'userId' => '37',
            'address' => 'C-303, Swarg Swapna Flat,Pethapur, Gandhinagar, 382610',
            'profilePhoto' => '1655182332_adf.jpg',
            'latesCV' => '',
            'aadharCard' => '40332255004433',
            'aadharFront' => '',
            'aadharBack' => '',
            'panCard' => 'AVYPC0282F',
            'panCardAttach' => '',
            'bank' => 'SBI',
            'accountNo' => 'Dharmendrasinh Chavda',
            'branch' => 'Infocity Gandhinagar',
            'ifsc' => 'SBIN0012700',
            'size' => 'XL',
            'dob' => '1993-03-05',
            'skill' => 'PHP,Magento,Wordpress,CI,Laravel',
            'createdAt' => '2022-06-14 10:08:29',
            'updatedAt' => '2022-06-29 10:31:13'
        ];

        $this->db->table('user_extra')->upsert($data);
    }
}
