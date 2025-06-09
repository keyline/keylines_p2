<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;


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
                'comment'    => 'Indicates if Desklog is used',
            ],
            'is_task_approval' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => 'Indicates if task approval is required',
            ],
            'is_project_cost' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'null'       => false,
                'comment'    => 'Indicates if project cost tracking is enabled',
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
                'null'    => true,
                'default' => new \CodeIgniter\Database\RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated_at' => [
                'type'    => 'TIMESTAMP',
                'null'    => true,
            ],
            'published' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'comment'    => 'Indicates if the setting is published',
            ],
        ]);

        $this->forge->addKey('id', true); // Set 'id' as primary key
        $this->forge->createTable('application_settings');
    }

    public function down()
    {
        $this->forge->dropTable('application_settings');
    }
}
