<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateAssetType extends Migration
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
            'type_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'added_on' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('asset_type');
    }

    public function down()
    {
        $this->forge->dropTable('asset_type');
    }
}
