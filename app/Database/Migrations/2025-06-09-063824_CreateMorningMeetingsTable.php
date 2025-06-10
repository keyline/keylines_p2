<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateMorningMeetingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                    => ['type' => 'INT',     'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'dept_id'               => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'project_id'            => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'user_id'               => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'status_id'             => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'description'           => ['type' => 'LONGTEXT',                  'null' => true],
            'hour'                  => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'min'                   => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'work_home'             => ['type' => 'TINYINT', 'constraint' => 1,  'default' => 0, 'comment' => '0=work from office,1=work from home'],
            'effort_type'           => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'date_added'            => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'added_by'              => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'bill'                  => ['type' => 'TINYINT', 'constraint' => 1,  'default' => 0, 'comment' => '0=>billable,1=no-billable '],
            'work_status_id'        => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'priority'              => ['type' => 'TINYINT', 'constraint' => 1,  'default' => 3, 'comment' => '1 = LOW, 2 = MEDIUM, 3 = HIGH'],
            'effort_id'             => ['type' => 'INT',     'constraint' => 11, 'default' => 0],
            'next_day_task_action'  => ['type' => 'TINYINT', 'constraint' => 1,  'default' => 0, 'comment' => '1=approved, 3=not done'],
            'is_leave'              => ['type' => 'TINYINT', 'constraint' => 1,  'default' => 0, 'comment' => '1=halfday leave,2=fullday leave'],
            'created_at'            => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'            => ['type' => 'TIMESTAMP', 'null' => true, 'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('morning_meetings');
    }

    public function down()
    {
        $this->forge->dropTable('morning_meetings');
    }
}
