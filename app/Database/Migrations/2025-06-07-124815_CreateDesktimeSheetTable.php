<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateDesktimeSheetTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'month_name' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'year_name' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'excel_filename' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'added_on' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('desktime_sheet');
    }

    public function down()
    {
        $this->forge->dropTable('desktime_sheet');
    }
}
