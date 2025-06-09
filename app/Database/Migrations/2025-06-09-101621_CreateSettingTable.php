<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSettingTable extends Migration
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
            'amc_check_min' => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'check_description' => [
                'type' => 'TEXT',
            ],
            'check_span' => [
                'type'       => 'VARCHAR',
                'constraint' => 7,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('setting');
    }

    public function down()
    {
        $this->forge->dropTable('setting');
    }
}
