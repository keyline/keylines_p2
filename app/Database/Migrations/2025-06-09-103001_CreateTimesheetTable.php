<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTimesheetTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id'        => ['type' => 'INT', 'constraint' => 12, 'default' => 0],
            'status_id'         => ['type' => 'INT', 'constraint' => 12, 'default' => 0],
            'user_id'           => ['type' => 'INT', 'constraint' => 12, 'default' => 0],
            'description'       => ['type' => 'LONGTEXT', 'null' => true],
            'hour'              => ['type' => 'INT', 'constraint' => 12, 'default' => 0],
            'min'               => ['type' => 'INT', 'constraint' => 12, 'default' => 0],
            'work_home'         => ['type' => 'INT', 'constraint' => 12, 'default' => 0],
            'effort_type'       => ['type' => 'INT', 'constraint' => 12, 'default' => 0],
            'work_status_id'    => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'date_today'        => ['type' => 'DATETIME', 'null' => false],
            'date_added'        => ['type' => 'DATE', 'null' => false],
            'bill'              => ['type' => 'INT', 'constraint' => 12, 'default' => 0],
            'assigned_task_id'  => ['type' => 'INT', 'constraint' => 12, 'default' => 0],
            'hour_rate'         => ['type' => 'VARCHAR', 'constraint' => 256, 'null' => true],
            'cost'              => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'next_day_task_action' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('work_status_id'); 
        $this->forge->createTable('timesheet');
    }

    public function down()
    {
        $this->forge->dropTable('timesheet');
    }
}
