<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateClientTable extends Migration
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
            'entried_by' => [
                'type'       => 'INT',
                'constraint' => 12,
                'unsigned'   => true,
            ],
            'client_of' => [
                'type'       => 'INT',
                'constraint' => 12,
                'unsigned'   => true,
            ],
            'role_id' => [
                'type'       => 'INT',
                'constraint' => 12,
                'default'    => 0,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'compnay' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'address_1' => [
                'type' => 'LONGTEXT',
            ],
            'state' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'city' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'country' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'pin' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'address_2' => [
                'type' => 'LONGTEXT',
            ],
            'email_1' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'email_2' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'phone_1' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'phone_2' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'dob_day' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'dob_month' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'dob_year' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'password_md5' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'password_org' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'comment' => [
                'type' => 'LONGTEXT',
            ],
            'reference' => [
                'type' => 'LONGTEXT',
            ],
            'added_date' => [
                'type' => 'DATETIME',
            ],
            'login_access' => [
                'type'       => 'ENUM("1","0")',
                'default'    => '0',
                'comment' => '1 => YES, 0 => NO',
            ],
            'last_login' => [
                'type' => 'DATETIME',
            ],
            'encoded_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'encoded_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('client');
    }

    public function down()
    {
        $this->forge->dropTable('client');
    }
}
