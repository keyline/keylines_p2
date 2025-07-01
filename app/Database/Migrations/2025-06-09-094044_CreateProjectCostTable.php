<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use CodeIgniter\Database\RawSql;

class CreateProjectCostTable extends Migration
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
            'project_id'    => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'month'         => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'year'          => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'project_cost'  => [
                'type'       => 'INT',
                'constraint' => 11,
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
        $this->forge->createTable('project_cost');
    }

    public function down()
    {
        $this->forge->dropTable('project_cost');
    }
}
