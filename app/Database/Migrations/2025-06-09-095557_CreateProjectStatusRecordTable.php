<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProjectStatusRecordTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'BIGINT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id'   => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'status_id'    => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'user_id'      => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'changed_date' => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('project_status_record');
    }

    public function down()
    {
        $this->forge->dropTable('project_status_record');
    }
}
