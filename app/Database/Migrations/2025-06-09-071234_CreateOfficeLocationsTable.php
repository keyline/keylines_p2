<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateOfficeLocationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => ['type' => 'INT',        'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name'       => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'phone'      => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'email'      => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'address'    => ['type' => 'LONGTEXT',   'null' => true],
            'country'    => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'state'      => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'city'       => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'locality'   => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'street_no'  => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'zipcode'    => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'latitude'   => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'longitude'  => ['type' => 'VARCHAR',    'constraint' => 250, 'null' => true],
            'status'     => ['type' => 'TINYINT',    'constraint' => 1,   'default' => 1],
            'created_at' => ['type' => 'TIMESTAMP',  'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('office_locations');
    }

    public function down()
    {
        $this->forge->dropTable('office_locations');
    }
}
