<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class CreateApplicationSettingsTable extends Migration
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
            'theme_color' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'font_color' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'tomorrow_task_editing_time' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'api_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'api_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'block_tracker_fillup_after_days' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'is_desklog_use' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'is_task_approval' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'is_project_cost' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
            ],
            'encryption_api_secret_key' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'encryption_api_secret_iv' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'encryption_api_encrypt_method' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'google_map_api_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'allow_punch_distance' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'current_date_tasks_show_in_effort' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'monthly_minimum_effort_time' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'daily_minimum_effort_time' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false,
            ],
            'mark_later_after' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'currency' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'null'       => true,
            ],
            'edit_time_after_task_add' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
                'null'       => true,
            ],
            'sunday' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'default'    => '[]',
            ],
            'monday' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'default'    => '[]',
            ],
            'tuesday' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'default'    => '[]',
            ],
            'wednesday' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'default'    => '[]',
            ],
            'thursday' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'default'    => '[]',
            ],
            'friday' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'default'    => '[]',
            ],
            'satarday' => [
                'type'       => 'VARCHAR',
                'constraint' => 250,
                'default'    => '[]',
            ],
            'created_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'default' => 'CURRENT_TIMESTAMP',
            ],
            'published' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
        ]);

        $this->forge->addKey('id', true); // Set 'id' as primary key
        $this->forge->createTable('application_settings');

        // Add comments to specific columns
        $this->db->query("ALTER TABLE `application_settings` MODIFY `is_desklog_use` TINYINT(1) COMMENT 'Indicates if Desklog is used'");
        $this->db->query("ALTER TABLE `application_settings` MODIFY `is_task_approval` TINYINT(1) COMMENT 'Indicates if task approval is required'");
        $this->db->query("ALTER TABLE `application_settings` MODIFY `is_project_cost` TINYINT(1) COMMENT 'Indicates if project cost tracking is enabled'");
        $this->db->query("ALTER TABLE `application_settings` MODIFY `published` TINYINT(1) COMMENT 'Indicates if the setting is published'");
    }

    public function down()
    {
        $this->forge->dropTable('application_settings');
    }
}
