<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTeamTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'dep_id'     => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'user_id'    => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'type'       => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('team');
    }

    public function down()
    {
        $this->forge->dropTable('team');
    }
}
