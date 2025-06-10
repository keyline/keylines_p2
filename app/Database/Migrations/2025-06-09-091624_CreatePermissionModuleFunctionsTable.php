<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreatePermissionModuleFunctionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'function_id'   => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'module_id'     => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'function_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
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

        $this->forge->addKey('function_id', true);
        $this->forge->createTable('permission_module_functions');
    }

    public function down()
    {
        $this->forge->dropTable('permission_module_functions');
    }
}
