<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateScreenshotSettings extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
                'unsigned'       => true
            ],
            'screenshot_resolution' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
                'comment'    => 'e.g., 1920x1080'
            ],
            'idle_time' => [
                'type'    => 'INT',
                'null'    => true,
                'comment' => 'Idle time in seconds before taking screenshot'
            ],
            'screenshot_time' => [
                'type'    => 'INT',
                'null'    => true,
                'comment' => 'Interval in seconds between screenshots'
            ]
        ]);

        $this->forge->addKey('id', true); // primary key
        $this->forge->createTable('screenshot_settings');
    }

    public function down()
    {
        $this->forge->dropTable('screenshot_settings');
    }
}
