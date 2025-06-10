<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use CodeIgniter\Database\RawSql;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'             => ['type' => 'INT',       'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'source'         => ['type' => "ENUM('FROM ADMIN','FROM APP')", 'null' => true],
            'title'          => ['type' => 'VARCHAR',   'constraint' => 250, 'null' => true],
            'description'    => ['type' => 'LONGTEXT',  'null' => true],
            'user_type'      => ['type' => "ENUM('COMPANY','PLANT','VENDOR')", 'null' => true],
            'users'          => ['type' => 'LONGTEXT',  'null' => true],
            'is_send'        => ['type' => 'TINYINT',   'constraint' => 1,   'default' => 0],
            'send_timestamp' => ['type' => 'VARCHAR',   'constraint' => 250, 'null' => true],
            'status'         => ['type' => 'TINYINT',   'constraint' => 1,   'default' => 0],
            'created_at'     => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'     => ['type' => 'TIMESTAMP', 'null' => true,     'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP')],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('notifications');
    }

    public function down()
    {
        $this->forge->dropTable('notifications');
    }
}
