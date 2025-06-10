<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserScreenshotsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => false,
            ],
            'org_id' => [
                'type'     => 'BIGINT',
                'unsigned' => true,
                'null'     => false,
            ],
            'active_app_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'default'    => null,
            ],
            'active_app_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 555,
                'null'       => true,
                'default'    => null,
            ],
            'image_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
            'idle_status' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'null'       => false,
                'comment'    => '1 for active, 0 for idle',
            ],
            'time_stamp' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addKey('id', true);      // Primary key
        $this->forge->addKey('user_id');       // Index for performance
        $this->forge->addKey('org_id');        // Index for performance

        // No foreign keys
        $this->forge->createTable('user_screenshots');
    }

    public function down()
    {
        $this->forge->dropTable('user_screenshots');
    }
}
