<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use CodeIgniter\Database\RawSql;

class CreateRoleModuleFunctionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'role_id'       => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'module_id'     => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'function_id'   => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'published'     => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'created_at'    => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at'    => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('role_module_functions');
    }

    public function down()
    {
        $this->forge->dropTable('role_module_functions');
    }
}
