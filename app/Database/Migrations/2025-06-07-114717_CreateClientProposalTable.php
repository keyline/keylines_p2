<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientProposalTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'client_id' => [
                'type'       => 'INT',
                'constraint' => 12,
                'unsigned'   => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 12,
                'unsigned'   => true,
            ],
            'title' => [
                'type' => 'LONGTEXT',
            ],
            'description' => [
                'type' => 'LONGTEXT',
            ],
            'date' => [
                'type' => 'DATE',
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key

        $this->forge->createTable('client_proposal');
    }

    public function down()
    {
        $this->forge->dropTable('client_proposal');
    }
}
