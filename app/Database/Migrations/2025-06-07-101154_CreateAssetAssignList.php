<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAssetAssignList extends Migration
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
            'asset_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'location' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'assign_date' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('asset_assign_list');
    }

    public function down()
    {
        $this->forge->dropTable('asset_assign_list');
    }
}
