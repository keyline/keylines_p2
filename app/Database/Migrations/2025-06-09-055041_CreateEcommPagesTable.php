<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateEcommPagesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT',    'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'page_title'        => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'slug'              => ['type' => 'VARCHAR', 'constraint' => 250, 'null' => true],
            'short_description' => ['type' => 'LONGTEXT',                 'null' => true],
            'long_description'  => ['type' => 'LONGTEXT',                 'null' => true],
            'meta_title'        => ['type' => 'LONGTEXT',                 'null' => true],
            'meta_description'  => ['type' => 'LONGTEXT',                 'null' => true],
            'meta_keywords'     => ['type' => 'LONGTEXT',                 'null' => true],
            'status'            => ['type' => 'TINYINT', 'constraint' => 1,   'default' => 1,   'null' => false],
            'created_at'        => ['type' => 'TIMESTAMP',                'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'        => ['type' => 'TIMESTAMP',                'null' => true,   'default' => null],
            'created_by'        => ['type' => 'INT',    'constraint' => 11,  'default' => 0,   'null' => false],
            'updated_by'        => ['type' => 'INT',    'constraint' => 11,  'default' => 0,   'null' => false],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('ecomm_pages');
    }

    public function down()
    {
        $this->forge->dropTable('ecomm_pages');
    }
}
