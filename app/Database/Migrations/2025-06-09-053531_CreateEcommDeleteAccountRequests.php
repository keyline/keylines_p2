<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateEcommDeleteAccountRequests extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'               => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_type'        => ['type' => 'ENUM', 'constraint' => ['admin', 'user', 'client', 'sales', 'superadmin'], 'null' => true],
            'entity_name'      => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'email'            => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'is_email_verify'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'null' => true],
            'phone'            => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'is_phone_verify'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'null' => true],
            'comments'         => ['type' => 'LONGTEXT', 'null' => true],
            'status'           => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'approve_date'     => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'created_at'       => ['type' => 'TIMESTAMP', 'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'       => ['type' => 'TIMESTAMP', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('ecomm_delete_account_requests');
    }

    public function down()
    {
        $this->forge->dropTable('ecomm_delete_account_requests');
    }
}
