<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use CodeIgniter\Database\RawSql;

class CreateAssetList extends Migration
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
            'asset_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'asset_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'asset_brand_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'storage' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
            ],
            'ram' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
            ],
            'processor' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
            ],
            'asset_details_date' => [
                'type'       => 'CHAR',
                'constraint' => 250,
            ],
            'asset_price' => [
                'type'       => 'VARCHAR',
                'constraint' => 11,
            ],
            'asset_warranty' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'vendor' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'invoice_pdf' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'assets_serial_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
            ],
            'validate_date' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
            ],
            'asset_status' => [
                'type'       => 'VARCHAR',
                'constraint' => 11,
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('asset_list');
    }

    public function down()
    {
        $this->forge->dropTable('asset_list');
    }
}
