<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssignedTask extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 12,
                'unsigned'   => true,
            ],
            'assigned_by' => [
                'type'       => 'INT',
                'constraint' => 12,
                'unsigned'   => true,
            ],
            'assigned_to' => [
                'type'       => 'INT',
                'constraint' => 12,
                'unsigned'   => true,
            ],
            'description' => [
                'type' => 'LONGTEXT',
            ],
            'estimated_hour' => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'estimated_minute' => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'start_date' => [
                'type' => 'DATE',
            ],
            'end_date' => [
                'type' => 'DATE',
            ],
            'priority' => [
                'type'       => 'INT',
                'constraint' => 12,
                'comment'    => '1 => LOW, 2 => MEDIUM, 3 => HIGH',
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'entry_date' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('assigned_task');
    }

    public function down()
    {
        $this->forge->dropTable('assigned_task');
    }
}
