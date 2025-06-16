<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TimesheetSeeder extends Seeder
{
    public function run()
    {
        $timesheet = array(
            array('id' => '110367', 'project_id' => '501', 'status_id' => '1', 'user_id' => '56', 'description' => 'test', 'hour' => '2', 'min' => '0', 'work_home' => '0', 'effort_type' => '1', 'work_status_id' => '2', 'date_today' => '2024-10-08 16:09:40', 'date_added' => '2024-10-08', 'bill' => '1', 'assigned_task_id' => '1', 'hour_rate' => '345', 'cost' => '690.00', 'next_day_task_action' => '0'),
            array('id' => '110368', 'project_id' => '501', 'status_id' => '1', 'user_id' => '95', 'description' => 'test', 'hour' => '1', 'min' => '0', 'work_home' => '0', 'effort_type' => '1', 'work_status_id' => '1', 'date_today' => '2024-10-08 16:11:39', 'date_added' => '2024-10-08', 'bill' => '1', 'assigned_task_id' => '2', 'hour_rate' => '0', 'cost' => '0.00', 'next_day_task_action' => '0')
        );

        $this->db->table('timesheet')->insertBatch($timesheet);
    }
}
