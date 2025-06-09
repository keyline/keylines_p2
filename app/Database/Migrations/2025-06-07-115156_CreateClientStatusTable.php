<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientStatusTable extends Migration
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
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('client_status');
    }

    public function down()
    {
        $this->forge->dropTable('client_status');
    }
}
