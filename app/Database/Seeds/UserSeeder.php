<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {

        $user = array(
            array('id' => '56', 'name' => 'Effortrak Admin', 'email' => 'admin@effortrak.com', 'personal_email' => 'admin@effortrak.com', 'phone1' => '1234567890', 'phone2' => '1234567890', 'address' => 'Address', 'pincode' => '700075', 'latitude' => '', 'longitude' => '', 'password' => 'f93abe4525103d6ecbdd0d7fcdda6652', 'remember_token' => '0', 'type' => 'SUPER ADMIN', 'role_id' => '1', 'category' => '1', 'hour_cost' => '345', 'dob' => '1997-12-16', 'doj' => '2022-02-01', 'profile_image' => '1728364014profile.png', 'department' => '7 ', 'dept_type' => 'Member', 'date_added' => '2022-02-01 10:39:36', 'date_updated' => '2025-06-09 14:13:01', 'status' => '1', 'approve_date' => NULL, 'work_mode' => 'Hybrid', 'is_tracker_user' => '1', 'is_salarybox_user' => '1', 'attendence_type' => '["0"]', 'tracker_depts_show' => '[]', 'last_login' => '09-06-2025 02:13:01 pm', 'ip_address' => '45.113.88.207', 'last_browser_used' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:140.0) Gecko/20100101 Firefox/140.0'),
            array('id' => '95', 'name' => 'Emp 1', 'email' => 'emp1@keylines.net', 'personal_email' => '', 'phone1' => '1231231231', 'phone2' => '', 'address' => '', 'pincode' => '', 'latitude' => '', 'longitude' => '', 'password' => '81dc9bdb52d04dc20036dbd8313ed055', 'remember_token' => NULL, 'type' => 'USER', 'role_id' => '3', 'category' => '1', 'hour_cost' => '0', 'dob' => '2024-10-08', 'doj' => '2024-10-08', 'profile_image' => '', 'department' => '7 ', 'dept_type' => 'Teamlead', 'date_added' => '2024-10-08 15:48:45', 'date_updated' => '2024-10-08 16:07:55', 'status' => '1', 'approve_date' => NULL, 'work_mode' => NULL, 'is_tracker_user' => '1', 'is_salarybox_user' => '1', 'attendence_type' => '["0"]', 'tracker_depts_show' => '[]', 'last_login' => NULL, 'ip_address' => NULL, 'last_browser_used' => NULL),
            array('id' => '96', 'name' => 'Test user', 'email' => 'testuser@effortrak.com', 'personal_email' => '', 'phone1' => '7984652031', 'phone2' => '', 'address' => 'test address', 'pincode' => '700045', 'latitude' => '', 'longitude' => '', 'password' => 'dadd25ea9658be1f5e47e5d8eca044bb', 'remember_token' => NULL, 'type' => 'USER', 'role_id' => '3', 'category' => '1', 'hour_cost' => '0', 'dob' => '2025-04-30', 'doj' => '2025-05-25', 'profile_image' => '', 'department' => NULL, 'dept_type' => NULL, 'date_added' => '2025-05-26 11:28:41', 'date_updated' => '2025-05-26 11:40:49', 'status' => '1', 'approve_date' => NULL, 'work_mode' => NULL, 'is_tracker_user' => '0', 'is_salarybox_user' => '1', 'attendence_type' => '["0"]', 'tracker_depts_show' => '[]', 'last_login' => '26-05-2025 11:40:49 am', 'ip_address' => '116.206.223.237', 'last_browser_used' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36')
        );

        $this->db->table('user')->insertBatch($user);
    }
}
