<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateAssetVendorMaster extends Migration
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
            'vendor_company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 256,
            ],
            'vendor_contact_person' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
            ],
            'vendor_phone_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'vendor_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'vendor_address' => [
                'type'       => 'VARCHAR',
                'constraint' => 500,
            ],
            'vendor_state' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'vendor_city' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'vendor_pincode' => [
                'type'       => 'INT',
                'constraint' => 100,
            ],
            'vendor_gst' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'vendor_pan' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
            ],
            'added_on' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_on' => [
                'type'    => 'TIMESTAMP',
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
        ]);

        $this->forge->addKey('id', true); // Primary Key
        $this->forge->createTable('asset_vendor_master');
    }

    public function down()
    {
        $this->forge->dropTable('asset_vendor_master');
    }
}
