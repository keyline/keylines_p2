<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCalendarEventMaster extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'event_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'event_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'event_start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'event_end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('event_id', true); // Primary Key
        $this->forge->createTable('calendar_event_master');
    }

    public function down()
    {
        $this->forge->dropTable('calendar_event_master');
    }
}
