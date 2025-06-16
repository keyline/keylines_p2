<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionFunctionSeeder extends Seeder
{
    public function run()
    {
        $permission_function = array(
            array('id' => '1', 'name' => 'List', 'published' => '1', 'created_at' => '2024-07-22 13:10:57', 'updated_at' => '2024-07-22 13:10:57'),
            array('id' => '2', 'name' => 'Add', 'published' => '1', 'created_at' => '2024-07-22 13:11:55', 'updated_at' => '2024-07-22 13:11:55'),
            array('id' => '3', 'name' => 'Edit', 'published' => '1', 'created_at' => '2024-07-22 13:13:04', 'updated_at' => '2024-07-22 13:13:04'),
            array('id' => '4', 'name' => 'Active', 'published' => '1', 'created_at' => '2024-07-22 14:52:34', 'updated_at' => '2024-07-22 14:52:34'),
            array('id' => '5', 'name' => 'Deactive', 'published' => '1', 'created_at' => '2024-07-22 14:52:55', 'updated_at' => '2024-07-22 14:52:55'),
            array('id' => '6', 'name' => 'Send Credentials', 'published' => '1', 'created_at' => '2024-07-22 14:53:19', 'updated_at' => '2024-07-22 14:53:19'),
            array('id' => '8', 'name' => 'Delete', 'published' => '1', 'created_at' => '2024-07-23 14:35:59', 'updated_at' => '2024-07-23 14:35:59'),
            array('id' => '9', 'name' => 'Generate', 'published' => '1', 'created_at' => '2024-07-23 14:38:02', 'updated_at' => '2024-07-23 14:38:02'),
            array('id' => '10', 'name' => 'Fetch Desklog Report', 'published' => '1', 'created_at' => '2024-07-23 14:51:55', 'updated_at' => '2024-07-23 14:51:55'),
            array('id' => '11', 'name' => 'Approval', 'published' => '1', 'created_at' => '2024-07-23 14:54:45', 'updated_at' => '2024-07-23 14:54:45'),
            array('id' => '12', 'name' => 'View', 'published' => '1', 'created_at' => '2024-07-23 14:56:34', 'updated_at' => '2024-07-23 14:56:34'),
            array('id' => '13', 'name' => 'Tracker Report in Dashboard', 'published' => '1', 'created_at' => '2024-07-23 17:58:42', 'updated_at' => '2024-07-23 17:58:42'),
            array('id' => '14', 'name' => 'Attendance Report in Dashboard', 'published' => '1', 'created_at' => '2024-07-23 17:59:04', 'updated_at' => '2024-07-23 17:59:04'),
            array('id' => '15', 'name' => 'Last 7 Days Report in Dashboard', 'published' => '1', 'created_at' => '2024-07-23 17:59:26', 'updated_at' => '2024-07-23 17:59:26'),
            array('id' => '16', 'name' => 'All user billing pie chart dashboard', 'published' => '1', 'created_at' => '2024-07-23 17:59:46', 'updated_at' => '2024-07-23 17:59:46'),
            array('id' => '17', 'name' => 'User own billing pie chart dashboard', 'published' => '1', 'created_at' => '2024-07-23 18:00:02', 'updated_at' => '2024-07-23 18:00:02'),
            array('id' => '18', 'name' => 'Provide Permission', 'published' => '1', 'created_at' => '2024-07-25 15:44:10', 'updated_at' => '2024-07-25 15:44:10'),
            array('id' => '19', 'name' => 'Analyze Permission', 'published' => '1', 'created_at' => '2024-07-25 15:44:37', 'updated_at' => '2024-07-25 15:44:37'),
            array('id' => '20', 'name' => 'Staticics', 'published' => '1', 'created_at' => '2024-07-26 11:30:27', 'updated_at' => '2024-07-26 11:30:27')
        );

        $this->db->table('permission_function')->insertBatch($permission_function);
    }
}
