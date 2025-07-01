<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProspectFollowupTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id'    => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'schedule_date' => [
                'type' => 'DATE',
            ],
            'schedule_time' => [
                'type' => 'TEXT',
            ],
            'schedule_type' => [
                'type'       => 'ENUM',
                'constraint' => ['Phone Call', 'Meeting'],
            ],
            'comment'       => [
                'type' => 'TEXT',
            ],
            'status'        => [
                'type'       => 'ENUM',
                'constraint' => ['0', '1'],
            ],
            'user_id'       => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'google_calender' => [
                'type'       => 'INT',
                'constraint' => 2,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('prospect_followup');
    }

    public function down()
    {
        $this->forge->dropTable('prospect_followup');
    }
}
