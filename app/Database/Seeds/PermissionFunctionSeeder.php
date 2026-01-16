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
            array('id' => '20', 'name' => 'Staticics', 'published' => '1', 'created_at' => '2024-07-26 11:30:27', 'updated_at' => '2024-07-26 11:30:27'),
            array('id'=>'21','name'=>'Add Bulk User','published'=>'1','created_at'=>'2025-11-07 15:22:41','updated_at'=>'2025-11-07 15:22:41'),
            array('id'=>'22','name'=>'Load More','published'=>'1','created_at'=>'2025-11-07 15:24:19','updated_at'=>'2025-11-07 15:24:19'),
            array('id'=>'23','name'=>'TASK MANAGEMENT DASHBOARD','published'=>'1','created_at'=>'2025-11-07 18:28:11','updated_at'=>'2025-11-07 18:28:11'),
            array('id'=>'24','name'=>'COUNT OF PRESENT & ABSENT','published'=>'1','created_at'=>'2025-11-10 16:30:24','updated_at'=>'2025-11-10 16:30:24'),
            array('id'=>'25','name'=>'Filter Department','published'=>'1','created_at'=>'2025-11-10 18:25:14','updated_at'=>'2025-11-10 18:25:14'),
            array('id'=>'26','name'=>'tracker access user','published'=>'1','created_at'=>'2025-11-11 17:44:04','updated_at'=>'2025-11-11 17:44:04'),
            array('id'=>'27','name'=>'app access user','published'=>'1','created_at'=>'2025-11-11 17:45:05','updated_at'=>'2025-11-11 17:45:05'),
            array('id'=>'28','name'=>'add project','published'=>'1','created_at'=>'2025-11-11 18:23:08','updated_at'=>'2025-11-11 18:23:08'),
            array('id'=>'29','name'=>'add proposal','published'=>'1','created_at'=>'2025-11-11 18:23:46','updated_at'=>'2025-11-11 18:23:46'),
            array('id'=>'30','name'=>'view proposal','published'=>'1','created_at'=>'2025-11-11 18:28:27','updated_at'=>'2025-11-11 18:28:27'),
            array('id'=>'31','name'=>'edit proposal','published'=>'1','created_at'=>'2025-11-11 18:28:56','updated_at'=>'2025-11-11 18:28:56'),
            array('id'=>'32','name'=>'delete proposal','published'=>'1','created_at'=>'2025-11-11 18:29:06','updated_at'=>'2025-11-11 18:29:06'),
            array('id'=>'33','name'=>'show user in advance search','published'=>'1','created_at'=>'2025-11-12 17:36:42','updated_at'=>'2025-11-12 17:36:42'),
            array('id'=>'34','name'=>'screenshot setting modification','published'=>'1','created_at'=>'2025-11-14 18:01:24','updated_at'=>'2025-11-14 18:01:24'),
            array('id'=>'35','name'=>'profile setting','published'=>'1','created_at'=>'2025-11-14 18:51:38','updated_at'=>'2025-11-14 18:51:38'),
            array('id'=>'36','name'=>'Change Password setting','published'=>'1','created_at'=>'2025-11-14 18:51:59','updated_at'=>'2025-11-14 18:51:59'),
            array('id'=>'37','name'=>'General setting','published'=>'1','created_at'=>'2025-11-14 18:52:11','updated_at'=>'2025-11-14 18:52:11'),
            array('id'=>'38','name'=>'Application setting','published'=>'1','created_at'=>'2025-11-14 18:52:21','updated_at'=>'2025-11-14 18:52:21'),
            array('id'=>'39','name'=>'Email setting','published'=>'1','created_at'=>'2025-11-14 18:52:31','updated_at'=>'2025-11-14 18:52:31'),
            array('id'=>'40','name'=>'SMS setting','published'=>'1','created_at'=>'2025-11-14 18:53:05','updated_at'=>'2025-11-14 18:53:05'),
            array('id'=>'41','name'=>'add task','published'=>'3','created_at'=>'2025-11-15 11:42:01','updated_at'=>'2025-11-15 11:42:01'),
            array('id'=>'42','name'=>'count details dashboard','published'=>'1','created_at'=>'2025-11-17 15:11:48','updated_at'=>'2025-11-17 15:11:48')

        );

        $this->db->table('permission_function')->insertBatch($permission_function);
    }
}
