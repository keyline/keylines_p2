<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use CodeIgniter\Database\RawSql;

class CreateProjectTable extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id'                => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'name'              => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'description'       => [
                'type' => 'LONGTEXT',
            ],
            'assigned_by'       => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'status'            => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'hour'              => [
                'type'       => 'INT',
                'constraint' => 12,
                'null'       => true,
            ],
            'hour_month'        => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'project_time_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
            ],
            'date_added'        => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'date_modified'     => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            'client_id'         => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'temporary_url'     => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'permanent_url'     => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'client_service'    => [
                'type' => 'LONGTEXT',
            ],
            'start_date'        => [
                'type' => 'DATE',
                'null' => true,
            ],
            'deadline'          => [
                'type' => 'DATE',
                'null' => true,
            ],
            'parent'            => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'bill'              => [
                'type'       => 'INT',
                'constraint' => 12,
                'default'    => 1,
                'comment'    => "'1' = 'Nonbill', '2' = 'bill' ",
            ],
            'type'              => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
                'default'    => 'Own',
                'comment'    => "'Own','Lost','Prospect'",
            ],
            'active'            => [
                'type'       => 'INT',
                'constraint' => 12,
                'default'    => 0,
                'comment'    => '0 = Active, 1 = Inactive ',
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('project');
    }

    public function down()
    {
        $this->forge->dropTable('project');
    }
}
