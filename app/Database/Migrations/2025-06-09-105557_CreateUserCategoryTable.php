<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserCategoryTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'   => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('user_category');
    }

    public function down()
    {
        $this->forge->dropTable('user_category');
    }
}
