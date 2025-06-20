<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionModuleFunctionsSeeder extends Seeder
{
    public function run()
    {
        $permission_module_functions = array(
            array('function_id' => '1', 'module_id' => '12', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-22 11:38:16', 'updated_at' => '2024-07-22 11:38:16'),
            array('function_id' => '2', 'module_id' => '12', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-22 11:38:16', 'updated_at' => '2024-07-22 11:38:16'),
            array('function_id' => '3', 'module_id' => '12', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-22 11:38:16', 'updated_at' => '2024-07-22 11:38:16'),
            array('function_id' => '4', 'module_id' => '13', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-22 11:59:33', 'updated_at' => '2024-07-22 11:59:33'),
            array('function_id' => '5', 'module_id' => '13', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-22 11:59:33', 'updated_at' => '2024-07-22 11:59:33'),
            array('function_id' => '6', 'module_id' => '13', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-22 11:59:33', 'updated_at' => '2024-07-22 11:59:33'),
            array('function_id' => '7', 'module_id' => '14', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-22 16:38:32', 'updated_at' => '2024-07-22 16:38:32'),
            array('function_id' => '75', 'module_id' => '1', 'function_name' => 'Statistical Report in Dashboard', 'published' => '1', 'created_at' => '2024-07-26 11:32:42', 'updated_at' => '2024-07-26 11:32:42'),
            array('function_id' => '9', 'module_id' => '14', 'function_name' => 'Both Add/Edit Permission', 'published' => '1', 'created_at' => '2024-07-22 16:38:32', 'updated_at' => '2024-07-22 16:38:32'),
            array('function_id' => '10', 'module_id' => '16', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 13:03:19', 'updated_at' => '2024-07-23 13:03:19'),
            array('function_id' => '11', 'module_id' => '16', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-23 13:03:19', 'updated_at' => '2024-07-23 13:03:19'),
            array('function_id' => '12', 'module_id' => '16', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-23 13:03:19', 'updated_at' => '2024-07-23 13:03:19'),
            array('function_id' => '13', 'module_id' => '16', 'function_name' => 'Active', 'published' => '1', 'created_at' => '2024-07-23 13:03:19', 'updated_at' => '2024-07-23 13:03:19'),
            array('function_id' => '14', 'module_id' => '16', 'function_name' => 'Deactive', 'published' => '1', 'created_at' => '2024-07-23 13:03:19', 'updated_at' => '2024-07-23 13:03:19'),
            array('function_id' => '15', 'module_id' => '17', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 13:06:15', 'updated_at' => '2024-07-23 13:06:15'),
            array('function_id' => '16', 'module_id' => '17', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-23 13:06:15', 'updated_at' => '2024-07-23 13:06:15'),
            array('function_id' => '17', 'module_id' => '17', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-23 13:06:15', 'updated_at' => '2024-07-23 13:06:15'),
            array('function_id' => '18', 'module_id' => '17', 'function_name' => 'Active', 'published' => '1', 'created_at' => '2024-07-23 13:06:15', 'updated_at' => '2024-07-23 13:06:15'),
            array('function_id' => '19', 'module_id' => '17', 'function_name' => 'Deactive', 'published' => '1', 'created_at' => '2024-07-23 13:06:15', 'updated_at' => '2024-07-23 13:06:15'),
            array('function_id' => '20', 'module_id' => '4', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 13:18:50', 'updated_at' => '2024-07-23 13:18:50'),
            array('function_id' => '21', 'module_id' => '4', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-23 13:18:50', 'updated_at' => '2024-07-23 13:18:50'),
            array('function_id' => '22', 'module_id' => '4', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-23 13:18:50', 'updated_at' => '2024-07-23 13:18:50'),
            array('function_id' => '23', 'module_id' => '4', 'function_name' => 'Active', 'published' => '1', 'created_at' => '2024-07-23 13:18:50', 'updated_at' => '2024-07-23 13:18:50'),
            array('function_id' => '24', 'module_id' => '4', 'function_name' => 'Deactive', 'published' => '1', 'created_at' => '2024-07-23 13:18:50', 'updated_at' => '2024-07-23 13:18:50'),
            array('function_id' => '25', 'module_id' => '4', 'function_name' => 'Send Credentials', 'published' => '1', 'created_at' => '2024-07-23 13:18:50', 'updated_at' => '2024-07-23 13:18:50'),
            array('function_id' => '26', 'module_id' => '18', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 13:23:20', 'updated_at' => '2024-07-23 13:23:20'),
            array('function_id' => '27', 'module_id' => '18', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-23 13:23:20', 'updated_at' => '2024-07-23 13:23:20'),
            array('function_id' => '28', 'module_id' => '5', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 13:24:26', 'updated_at' => '2024-07-23 13:24:26'),
            array('function_id' => '29', 'module_id' => '5', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-23 13:24:26', 'updated_at' => '2024-07-23 13:24:26'),
            array('function_id' => '30', 'module_id' => '5', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-23 13:24:26', 'updated_at' => '2024-07-23 13:24:26'),
            array('function_id' => '31', 'module_id' => '5', 'function_name' => 'Active', 'published' => '1', 'created_at' => '2024-07-23 13:24:26', 'updated_at' => '2024-07-23 13:24:26'),
            array('function_id' => '32', 'module_id' => '5', 'function_name' => 'Deactive', 'published' => '1', 'created_at' => '2024-07-23 13:24:26', 'updated_at' => '2024-07-23 13:24:26'),
            array('function_id' => '33', 'module_id' => '6', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:32:59', 'updated_at' => '2024-07-23 14:32:59'),
            array('function_id' => '34', 'module_id' => '6', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-23 14:32:59', 'updated_at' => '2024-07-23 14:32:59'),
            array('function_id' => '35', 'module_id' => '19', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-23 14:34:30', 'updated_at' => '2024-07-23 14:34:30'),
            array('function_id' => '36', 'module_id' => '20', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:35:24', 'updated_at' => '2024-07-23 14:35:24'),
            array('function_id' => '37', 'module_id' => '20', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-23 14:35:24', 'updated_at' => '2024-07-23 14:35:24'),
            array('function_id' => '38', 'module_id' => '20', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-23 14:35:24', 'updated_at' => '2024-07-23 14:35:24'),
            array('function_id' => '39', 'module_id' => '20', 'function_name' => 'Delete', 'published' => '1', 'created_at' => '2024-07-23 14:36:55', 'updated_at' => '2024-07-23 14:36:55'),
            array('function_id' => '41', 'module_id' => '23', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:42:01', 'updated_at' => '2024-07-23 14:42:01'),
            array('function_id' => '43', 'module_id' => '24', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:48:28', 'updated_at' => '2024-07-23 14:48:28'),
            array('function_id' => '44', 'module_id' => '25', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:50:01', 'updated_at' => '2024-07-23 14:50:01'),
            array('function_id' => '48', 'module_id' => '8', 'function_name' => 'Approval', 'published' => '1', 'created_at' => '2024-07-23 14:55:05', 'updated_at' => '2024-07-23 14:55:05'),
            array('function_id' => '49', 'module_id' => '26', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:55:25', 'updated_at' => '2024-07-23 14:55:25'),
            array('function_id' => '50', 'module_id' => '8', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:55:58', 'updated_at' => '2024-07-23 14:55:58'),
            array('function_id' => '51', 'module_id' => '9', 'function_name' => 'View', 'published' => '1', 'created_at' => '2024-07-23 14:57:11', 'updated_at' => '2024-07-23 14:57:11'),
            array('function_id' => '52', 'module_id' => '9', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:57:47', 'updated_at' => '2024-07-23 14:57:47'),
            array('function_id' => '53', 'module_id' => '10', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:58:22', 'updated_at' => '2024-07-23 14:58:22'),
            array('function_id' => '54', 'module_id' => '11', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 14:58:53', 'updated_at' => '2024-07-23 14:58:53'),
            array('function_id' => '55', 'module_id' => '6', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-23 15:41:54', 'updated_at' => '2024-07-23 15:41:54'),
            array('function_id' => '56', 'module_id' => '27', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-23 16:22:29', 'updated_at' => '2024-07-23 16:22:29'),
            array('function_id' => '57', 'module_id' => '5', 'function_name' => 'Delete', 'published' => '1', 'created_at' => '2024-07-23 13:24:26', 'updated_at' => '2024-07-23 13:24:26'),
            array('function_id' => '58', 'module_id' => '4', 'function_name' => 'Delete', 'published' => '1', 'created_at' => '2024-07-23 13:18:50', 'updated_at' => '2024-07-23 13:18:50'),
            array('function_id' => '59', 'module_id' => '16', 'function_name' => 'Delete', 'published' => '1', 'created_at' => '2024-07-23 13:03:19', 'updated_at' => '2024-07-23 13:03:19'),
            array('function_id' => '60', 'module_id' => '17', 'function_name' => 'Delete', 'published' => '1', 'created_at' => '2024-07-23 13:06:15', 'updated_at' => '2024-07-23 13:06:15'),
            array('function_id' => '61', 'module_id' => '12', 'function_name' => 'Delete', 'published' => '1', 'created_at' => '2024-07-22 11:38:16', 'updated_at' => '2024-07-22 11:38:16'),
            array('function_id' => '62', 'module_id' => '13', 'function_name' => 'View', 'published' => '1', 'created_at' => '2024-07-22 11:59:33', 'updated_at' => '2024-07-22 11:59:33'),
            array('function_id' => '63', 'module_id' => '14', 'function_name' => 'Only View Permission', 'published' => '1', 'created_at' => '2024-07-22 16:38:32', 'updated_at' => '2024-07-22 16:38:32'),
            array('function_id' => '66', 'module_id' => '1', 'function_name' => 'Tracker Report in Dashboard', 'published' => '1', 'created_at' => '2024-07-23 18:00:47', 'updated_at' => '2024-07-23 18:00:47'),
            array('function_id' => '67', 'module_id' => '1', 'function_name' => 'Attendance Report in Dashboard', 'published' => '1', 'created_at' => '2024-07-23 18:00:47', 'updated_at' => '2024-07-23 18:00:47'),
            array('function_id' => '68', 'module_id' => '1', 'function_name' => 'Last 7 Days Report in Dashboard', 'published' => '1', 'created_at' => '2024-07-23 18:00:47', 'updated_at' => '2024-07-23 18:00:47'),
            array('function_id' => '74', 'module_id' => '28', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-25 15:38:42', 'updated_at' => '2024-07-25 15:38:42'),
            array('function_id' => '73', 'module_id' => '28', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-25 15:38:42', 'updated_at' => '2024-07-25 15:38:42'),
            array('function_id' => '71', 'module_id' => '1', 'function_name' => 'All user billing pie chart dashboard', 'published' => '1', 'created_at' => '2024-07-25 15:15:27', 'updated_at' => '2024-07-25 15:15:27'),
            array('function_id' => '72', 'module_id' => '1', 'function_name' => 'User own billing pie chart dashboard', 'published' => '1', 'created_at' => '2024-07-25 15:15:27', 'updated_at' => '2024-07-25 15:15:27'),
            array('function_id' => '76', 'module_id' => '29', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-30 14:47:48', 'updated_at' => '2024-07-30 14:47:48'),
            array('function_id' => '77', 'module_id' => '29', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-30 14:47:48', 'updated_at' => '2024-07-30 14:47:48'),
            array('function_id' => '78', 'module_id' => '29', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-30 14:47:48', 'updated_at' => '2024-07-30 14:47:48'),
            array('function_id' => '79', 'module_id' => '29', 'function_name' => 'Delete', 'published' => '1', 'created_at' => '2024-07-30 14:47:48', 'updated_at' => '2024-07-30 14:47:48'),
            array('function_id' => '80', 'module_id' => '29', 'function_name' => 'Active', 'published' => '1', 'created_at' => '2024-07-30 14:47:48', 'updated_at' => '2024-07-30 14:47:48'),
            array('function_id' => '81', 'module_id' => '29', 'function_name' => 'Deactive', 'published' => '1', 'created_at' => '2024-07-30 14:47:48', 'updated_at' => '2024-07-30 14:47:48'),
            array('function_id' => '82', 'module_id' => '30', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-07-30 14:49:38', 'updated_at' => '2024-07-30 14:49:38'),
            array('function_id' => '83', 'module_id' => '30', 'function_name' => 'Add', 'published' => '1', 'created_at' => '2024-07-30 14:49:38', 'updated_at' => '2024-07-30 14:49:38'),
            array('function_id' => '84', 'module_id' => '30', 'function_name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-30 14:49:38', 'updated_at' => '2024-07-30 14:49:38'),
            array('function_id' => '85', 'module_id' => '30', 'function_name' => 'Delete', 'published' => '1', 'created_at' => '2024-07-30 14:49:38', 'updated_at' => '2024-07-30 14:49:38'),
            array('function_id' => '86', 'module_id' => '30', 'function_name' => 'Active', 'published' => '1', 'created_at' => '2024-07-30 14:49:38', 'updated_at' => '2024-07-30 14:49:38'),
            array('function_id' => '87', 'module_id' => '30', 'function_name' => 'Deactive', 'published' => '1', 'created_at' => '2024-07-30 14:49:38', 'updated_at' => '2024-07-30 14:49:38'),
            array('function_id' => '88', 'module_id' => '22', 'function_name' => 'List', 'published' => '1', 'created_at' => '2024-08-07 17:29:28', 'updated_at' => '2024-08-07 17:29:28')
        );

        $this->db->table('permission_module_functions')->insertBatch($permission_module_functions);
    }
}
