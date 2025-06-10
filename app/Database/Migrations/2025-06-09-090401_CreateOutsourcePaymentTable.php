<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOutsourcePaymentTable extends Migration
{
    public function up()
    {
         $this->forge->addField([
            'id'           => [
                'type'           => 'INT',
                'constraint'     => 12,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'project_id'   => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'amount'       => [
                'type'       => 'INT',
                'constraint' => 12,
            ],
            'payment_date' => [
                'type' => 'DATE',
            ],
            'comment'      => [
                'type' => 'LONGTEXT',
            ],
            'date_added'   => [
                'type' => 'DATETIME',
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('outsource_payment');
    }

    public function down()
    {
        $this->forge->dropTable('outsource_payment');
    }
}
