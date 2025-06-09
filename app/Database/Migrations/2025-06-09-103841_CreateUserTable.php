<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUserTable extends Migration
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
            'name'              => ['type' => 'VARCHAR', 'constraint' => 256, 'null' => true],
            'email'             => ['type' => 'VARCHAR', 'constraint' => 256, 'null' => true],
            'personal_email'    => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'phone1'            => ['type' => 'VARCHAR', 'constraint' => 256, 'null' => true],
            'phone2'            => ['type' => 'VARCHAR', 'constraint' => 256, 'null' => true],
            'address'           => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'pincode'           => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'latitude'          => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'longitude'         => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'password'          => ['type' => 'VARCHAR', 'constraint' => 256, 'null' => true],
            'remember_token'    => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'type'              => [
                'type'       => "ENUM('ADMIN','USER','CLIENT','SALES','SUPER ADMIN')",
                'null'       => true,
            ],
            'role_id'           => ['type' => 'INT', 'constraint' => 11, 'null' => true, 'default' => 0],
            'category'          => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
            'hour_cost'         => ['type' => 'VARCHAR', 'constraint' => 256, 'null' => true],
            'dob'               => ['type' => 'VARCHAR', 'constraint' => 256, 'null' => true],
            'doj'               => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'profile_image'     => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'department'        => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'dept_type'         => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'date_added'        => [
                'type'    => 'DATETIME',
                'null'    => true,
                'default' => null,
            ],
            'date_updated'      => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
                'default' => null,
            ],
            'status'            => [
                'type'       => "ENUM('0','1','3')",
                'constraint' => null,
                'default'    => '0',
                'comment' => '0=deactive, 1=active, 3=deleted',
            ],
            'approve_date'      => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'work_mode'         => [
                'type'       => "ENUM('Work From Office','Work From Home','Hybrid')",
                'null'       => true,
            ],
            'is_tracker_user'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'is_salarybox_user' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'attendence_type'   => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true, 'default' => '["0"]'],
            'tracker_depts_show' => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true, 'default' => '[]'],
            'last_login'        => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'ip_address'        => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'last_browser_used' => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('user');
    }

    public function down()
    {
        $this->forge->dropTable('user');
    }
}
