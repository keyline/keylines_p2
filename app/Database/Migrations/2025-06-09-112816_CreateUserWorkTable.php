<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserWorkTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id'      => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'task_id'         => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'user_id'         => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'work_hour'       => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'work_minute'     => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'work_date'       => [
                'type'       => 'DATE',
            ],
            'comment'         => [
                'type' => 'LONGTEXT',
            ],
            'entry_date'      => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('user_work');
    }

    public function down()
    {
        $this->forge->dropTable('user_work');
    }
}
