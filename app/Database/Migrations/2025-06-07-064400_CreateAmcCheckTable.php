<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAmcCheckTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id' => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'comment' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'INT',
                'constraint' => 12,
                'comment'    => '0 => ok, 1 => not ok',
            ],
            'date' => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true); // Set 'id' as primary key
        $this->forge->createTable('amc_check');

        // Add comments to specific columns
        // $this->db->query("ALTER TABLE `amc_check` MODIFY `status` INT(12) COMMENT '0 => ok, 1 => not ok'");
        // Add more ALTER TABLE statements here if you want to add comments to other columns
    }

    public function down()
    {
        $this->forge->dropTable('amc_check');
    }
}
