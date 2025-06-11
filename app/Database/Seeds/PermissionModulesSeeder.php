<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionModulesSeeder extends Seeder
{
    public function run()
    {
        $permission_modules = array(
            array('id' => '1', 'parent_id' => '0', 'module_name' => 'DASHBOARD ', 'published' => '1', 'created_at' => '2024-07-22 11:19:03', 'updated_at' => '2024-07-26 11:32:42'),
            array('id' => '2', 'parent_id' => '0', 'module_name' => 'ACCESS & PERMISSION ', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-22 11:19:27'),
            array('id' => '3', 'parent_id' => '0', 'module_name' => 'MASTERS', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-22 11:19:27'),
            array('id' => '4', 'parent_id' => '0', 'module_name' => 'USERS', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 13:18:50'),
            array('id' => '5', 'parent_id' => '0', 'module_name' => 'PROJECTS', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 13:24:26'),
            array('id' => '6', 'parent_id' => '0', 'module_name' => 'CLIENTS', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 15:41:54'),
            array('id' => '7', 'parent_id' => '0', 'module_name' => 'EFFORT BOOKING', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-22 11:19:27'),
            array('id' => '8', 'parent_id' => '0', 'module_name' => 'DELETE ACCOUNT REQUEST ', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 14:55:58'),
            array('id' => '9', 'parent_id' => '0', 'module_name' => 'EMAIL LOGS', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 14:57:47'),
            array('id' => '10', 'parent_id' => '0', 'module_name' => 'LOGIN LOGS', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 14:58:22'),
            array('id' => '11', 'parent_id' => '0', 'module_name' => 'SETTINGS', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 14:58:53'),
            array('id' => '12', 'parent_id' => '2', 'module_name' => 'FEATURES', 'published' => '1', 'created_at' => '2024-07-22 11:38:16', 'updated_at' => '2024-07-22 11:38:16'),
            array('id' => '13', 'parent_id' => '2', 'module_name' => 'MODULES', 'published' => '1', 'created_at' => '2024-07-22 11:59:33', 'updated_at' => '2024-07-22 11:59:33'),
            array('id' => '14', 'parent_id' => '2', 'module_name' => 'GRANT PERMISSION', 'published' => '1', 'created_at' => '2024-07-22 16:38:32', 'updated_at' => '2024-07-22 16:38:32'),
            array('id' => '16', 'parent_id' => '3', 'module_name' => 'EFFORT TYPE', 'published' => '1', 'created_at' => '2024-07-23 13:03:19', 'updated_at' => '2024-07-23 13:03:19'),
            array('id' => '17', 'parent_id' => '3', 'module_name' => 'PROJECT STATUS', 'published' => '1', 'created_at' => '2024-07-23 13:06:15', 'updated_at' => '2024-07-23 13:06:15'),
            array('id' => '18', 'parent_id' => '0', 'module_name' => 'TEAMS', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 13:23:20'),
            array('id' => '19', 'parent_id' => '7', 'module_name' => 'ADD MY EFFORT', 'published' => '1', 'created_at' => '2024-07-23 14:34:30', 'updated_at' => '2024-07-23 14:34:30'),
            array('id' => '20', 'parent_id' => '7', 'module_name' => 'MY HISTORY', 'published' => '1', 'created_at' => '2024-07-23 14:35:24', 'updated_at' => '2024-07-23 14:36:55'),
            array('id' => '21', 'parent_id' => '0', 'module_name' => 'REPORT', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 13:23:20'),
            array('id' => '22', 'parent_id' => '21', 'module_name' => 'ADVANCE SEARCH', 'published' => '1', 'created_at' => '2024-07-23 14:40:22', 'updated_at' => '2024-07-23 14:40:22'),
            array('id' => '23', 'parent_id' => '21', 'module_name' => 'EFFORT REPORT', 'published' => '1', 'created_at' => '2024-07-23 14:42:01', 'updated_at' => '2024-07-23 14:42:01'),
            array('id' => '24', 'parent_id' => '21', 'module_name' => 'PROJECT EFFORT', 'published' => '1', 'created_at' => '2024-07-23 14:48:28', 'updated_at' => '2024-07-23 14:48:28'),
            array('id' => '25', 'parent_id' => '21', 'module_name' => 'PROJECT HOURLY REPORT', 'published' => '1', 'created_at' => '2024-07-23 14:50:01', 'updated_at' => '2024-07-23 14:50:01'),
            array('id' => '26', 'parent_id' => '21', 'module_name' => 'DESKLOG REPORT', 'published' => '1', 'created_at' => '2024-07-23 14:52:48', 'updated_at' => '2024-07-23 14:55:25'),
            array('id' => '27', 'parent_id' => '0', 'module_name' => 'ATTENDANCE', 'published' => '1', 'created_at' => '2024-07-22 11:19:27', 'updated_at' => '2024-07-23 16:22:29'),
            array('id' => '28', 'parent_id' => '3', 'module_name' => 'ROLE MASTER', 'published' => '1', 'created_at' => '2024-07-25 15:38:42', 'updated_at' => '2024-07-25 15:38:42'),
            array('id' => '29', 'parent_id' => '3', 'module_name' => 'DEPARTMENTS', 'published' => '1', 'created_at' => '2024-07-30 14:47:48', 'updated_at' => '2024-07-30 14:47:48'),
            array('id' => '30', 'parent_id' => '3', 'module_name' => 'WORK STATUS', 'published' => '1', 'created_at' => '2024-07-30 14:49:38', 'updated_at' => '2024-07-30 14:49:38'),
            array('id' => '31', 'parent_id' => '11', 'module_name' => 'TEST SETTING', 'published' => '1', 'created_at' => '2024-08-06 11:01:46', 'updated_at' => '2024-08-06 11:01:46')
        );
        $this->db->table('permission_modules')->insertBatch($permission_modules);
    }
}
