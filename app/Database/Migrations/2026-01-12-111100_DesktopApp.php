<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DesktopApp extends Migration
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
            'desktopapp_userid' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'email' => [
                'type'       => 'varchar',
                'constraint' => 255,
            ], 
            'arrival_at' => [
                'type'       => 'DATETIME',
                'null' => true,
            ],
            'left_at' => [
                'type'       => 'DATETIME',
                'null' => true,
            ],
            'time_at_work' => [
                'type'       => 'varchar',
                'constraint' => 50,
                'null' => true,
            ], 
            'productive_time' => [
                'type'       => 'varchar',
                'constraint' => 50,
                'null' => true,
            ], 
            'idle_time' => [
                'type'       => 'varchar',
                'constraint' => 50,
                'null' => true,
            ], 
             'private_time' => [
                'type'       => 'varchar',
                'constraint' => 50,
                'null' => true,
            ], 
             'time_zone' => [
                'type'       => 'varchar',
                'constraint' => 100,
                'null' => true,
            ], 
             'app_and_os' => [
                'type'       => 'TEXT',
                'null' => true,
            ], 
             'insert_date' => [
                'type'    => 'DATETIME',
                'null'    => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('desktop_app');

    }

    public function down()
    {
        $this->forge->dropTable('desktop_app');
    }
}
