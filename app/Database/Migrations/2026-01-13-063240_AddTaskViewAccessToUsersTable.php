<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddTaskViewAccessToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('user', [            
            'task_view_access' => [
                'type'    => "ENUM('1','2','3')",
                'null'    => true,
                'default' => '3',
                'after'   => 'last_browser_used', // optional
            ],
        ]);
    }

    public function down()
    {
        //
    }
}
