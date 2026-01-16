<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddShiftTimeToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user', [
            'shift_time' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'attendence_type', // optional
            ],            
        ]);
    }

    public function down()
    {
        //
    }
}
