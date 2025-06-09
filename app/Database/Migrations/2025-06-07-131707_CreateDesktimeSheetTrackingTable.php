<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateDesktimeSheetTrackingTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'month_upload'              => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'year_upload'               => ['type' => 'INT', 'constraint' => 11, 'null' => true],
            'upload_id'                 => ['type' => 'INT', 'constraint' => 11],
            'desktime_usrid'            => ['type' => 'BIGINT', 'constraint' => 20, 'null' => true],
            'user_id'                   => ['type' => 'INT', 'constraint' => 11],
            'name'                      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'email'                     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'desktime_userrole'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'department'                => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'desktime_adsence'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'productive_time'           => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'unproductive_time'         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'neutral_time'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'total_desktime_hour'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'offline_time'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'private_time'              => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'arrived_timing'            => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'left_timing'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'late_timing'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'total_working_time'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'idle_time'                 => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'extra_hours_before_work'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'extra_hours_after_work'    => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'hourly_rate'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'added_on'                  => ['type' => 'TIMESTAMP','default' => new RawSql('CURRENT_TIMESTAMP')],
        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('desktime_sheet_tracking');
    }

    public function down()
    {
        $this->forge->dropTable('desktime_sheet_tracking');
    }
}
