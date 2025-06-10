<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserExtraTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'           => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'userId'       => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'address'      => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'profilePhoto' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'latesCV'      => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'aadharCard'   => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'aadharFront'  => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'aadharBack'   => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'panCard'      => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'panCardAttach' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'bank'         => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'accountNo'    => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'branch'       => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'ifsc'         => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'size'         => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'dob'          => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'skill'        => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'createdAt'    => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
            'updatedAt'    => [
                'type'       => 'DATETIME',
                'null'       => false,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('user_extra');
    }

    public function down() {
        $this->forge->dropTable('user_extra');
    }
}
