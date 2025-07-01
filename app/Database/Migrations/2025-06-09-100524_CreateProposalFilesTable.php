<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateProposalFilesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'client_id'    => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'project_id'   => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'proposal_id'  => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'file'         => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'uploaded_by'  => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'created_at'   => [
                'type'       => 'DATETIME',
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at'   => [
                'type'       => 'DATETIME',
                'default'    => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('proposal_files');
    }

    public function down()
    {
        $this->forge->dropTable('proposal_files');
    }
}
