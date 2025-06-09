<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserEducationalCertificatesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'       => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'userId'   => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'document' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'updatedAt' => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
            'createdAt' => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('user_educational_certificates');
    }

    public function down()
    {
        $this->forge->dropTable('user_educational_certificates');
    }
}
