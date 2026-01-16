<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ShiftingWorkDetails extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'shifting_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
            ],
            'shift_in_time' => [
                'type'       => 'varchar',
                'constraint' => 250,
            ],
            'shift_out_time' => [
                'type'       => 'varchar',
                'constraint' => 250,
            ],
            'status' => [
                'type'       => 'tinyint',
                'constraint' => 4, 
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('shifting_work_details');
    }

    public function down()
    {
        $this->forge->dropTable('shifting_work_details');
    }
}
