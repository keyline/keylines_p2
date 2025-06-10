<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateUserActivitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'activity_id'      => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_email'       => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'user_name'        => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'user_type'        => [
                'type'       => "ENUM('admin','user','client','sales')",
                'null'       => true,
            ],
            'ip_address'       => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'activity_type'    => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
                'comment'    => '0=failed login,1=success login,2=logout ',
            ],
            'activity_details' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'platform_type'    => [
                'type'       => "ENUM('WEB','MOBILE','ANDROID','IOS')",
                'default'    => 'WEB',
            ],
            'created_at'       => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at'       => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('activity_id', true);
        $this->forge->createTable('user_activities');
    }

    public function down()
    {
        $this->forge->dropTable('user_activities');
    }
}
