<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionRolesSeeder extends Seeder
{
    public function run()
    {
        $permission_roles = array(
            array('id' => '1', 'role_name' => 'SUPER ADMIN', 'published' => '1', 'created_at' => '2024-07-25 11:41:29', 'updated_at' => '2024-08-20 11:48:04'),
            array('id' => '2', 'role_name' => 'ADMIN', 'published' => '1', 'created_at' => '2024-07-25 11:41:46', 'updated_at' => '2024-08-31 17:41:58'),
            array('id' => '3', 'role_name' => 'USER', 'published' => '1', 'created_at' => '2024-07-25 11:42:02', 'updated_at' => '2024-08-28 14:32:45'),
            array('id' => '4', 'role_name' => 'CLIENT', 'published' => '1', 'created_at' => '2024-07-25 11:43:42', 'updated_at' => '2024-09-02 16:55:05'),
            array('id' => '5', 'role_name' => 'SALES', 'published' => '1', 'created_at' => '2024-07-25 11:44:00', 'updated_at' => '2024-08-28 14:51:10'),
            array('id' => '6', 'role_name' => 'ACCOUNTS', 'published' => '1', 'created_at' => '2024-07-25 15:19:53', 'updated_at' => '2024-07-25 15:19:53'),
            array('id' => '7', 'role_name' => 'ACCOUNTANT', 'published' => '1', 'created_at' => '2024-08-05 16:16:44', 'updated_at' => '2024-08-05 16:16:44')
        );

        $this->db->table('permission_roles')->insertBatch($permission_roles);
    }
}
