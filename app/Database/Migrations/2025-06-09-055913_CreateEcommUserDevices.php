<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateEcommUserDevices extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                 => ['type' => 'INT',      'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'            => ['type' => 'INT',      'constraint' => 11, 'default' => 0],
            'device_type'        => ['type' => 'VARCHAR',  'constraint' => 250, 'null' => true],
            'device_token'       => ['type' => 'VARCHAR',  'constraint' => 250, 'null' => true],
            'fcm_token'          => ['type' => 'LONGTEXT',                  'null' => true],
            'app_access_token'   => ['type' => 'LONGTEXT',                  'null' => true],
            'published'          => ['type' => 'TINYINT',  'constraint' => 1,   'default' => 1],
            'created_at'         => ['type' => 'TIMESTAMP',               'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'         => ['type' => 'TIMESTAMP',               'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('ecomm_user_devices');
    }

    public function down()
    {
        $this->forge->dropTable('ecomm_user_devices');
    }
}
