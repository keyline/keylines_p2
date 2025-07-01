<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateTodaysWorkTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'         => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id'    => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'project_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'task_id'    => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'work'       => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
                'comment'  => '0=no, 1=yes',
            ],
            'createdAt'  => [
                'type'    => 'DATETIME',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('todays_work');
    }

    public function down()
    {
        $this->forge->dropTable('todays_work');
    }
}
