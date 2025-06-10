<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

use CodeIgniter\Database\RawSql;

class CreateGeneralSettingsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                            => ['type' => 'INT',        'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'company_name'                 => ['type' => 'TEXT'],
            'site_name'                    => ['type' => 'TEXT',        'null' => true],
            'site_phone'                   => ['type' => 'TEXT',        'null' => true],
            'site_mail'                    => ['type' => 'VARCHAR',     'constraint' => 255, 'null' => true],
            'system_email'                 => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'site_url'                     => ['type' => 'VARCHAR',     'constraint' => 255, 'null' => true],
            'description'                  => ['type' => 'LONGTEXT',    'null' => true],
            'site_logo'                    => ['type' => 'VARCHAR',     'constraint' => 255, 'null' => true],
            'site_footer_logo'             => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'site_favicon'                 => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'become_partner_text'          => ['type' => 'LONGTEXT',    'null' => true],
            'copyright_statement'          => ['type' => 'LONGTEXT',    'null' => true],
            'google_map_api_code'          => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'google_analytics_code'        => ['type' => 'LONGTEXT',    'null' => true],
            'google_pixel_code'            => ['type' => 'LONGTEXT',    'null' => true],
            'facebook_tracking_code'       => ['type' => 'LONGTEXT',    'null' => true],
            'gst_api_code'                 => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'firebase_server_key'          => ['type' => 'LONGTEXT',    'null' => true],
            'theme_color'                  => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'font_color'                   => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'tomorrow_task_editing_time'   => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'block_tracker_fillup_after_days' => ['type' => 'INT',    'constraint' => 11, 'null' => true],
            'is_desklog_use'               => ['type' => 'TINYINT',     'constraint' => 1,   'default' => 1, 'null' => true],
            'is_task_approval'             => ['type' => 'TINYINT',     'constraint' => 1,   'default' => 1, 'null' => true],
            'twitter_profile'              => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'facebook_profile'             => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'instagram_profile'            => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'linkedin_profile'             => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'youtube_profile'              => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'sms_authentication_key'       => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'sms_sender_id'                => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'sms_base_url'                 => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'from_email'                   => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'from_name'                    => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'smtp_host'                    => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'smtp_username'                => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'smtp_password'                => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'smtp_port'                    => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'meta_title'                   => ['type' => 'LONGTEXT',    'null' => true],
            'meta_description'             => ['type' => 'LONGTEXT',    'null' => true],
            'meta_keywords'                => ['type' => 'LONGTEXT',    'null' => true],
            'footer_text'                  => ['type' => 'LONGTEXT',    'null' => true],
            'footer_link_name'             => ['type' => 'LONGTEXT',    'null' => true],
            'footer_link'                  => ['type' => 'LONGTEXT',    'null' => true],
            'footer_link_name2'            => ['type' => 'LONGTEXT',    'null' => true],
            'footer_link2'                 => ['type' => 'LONGTEXT',    'null' => true],
            'footer_link_name3'            => ['type' => 'LONGTEXT',    'null' => true],
            'footer_link3'                 => ['type' => 'LONGTEXT',    'null' => true],
            'stripe_payment_type'          => ['type' => "ENUM('1','2')", 'null' => false],
            'stripe_sandbox_sk'            => ['type' => 'LONGTEXT',    'null' => true],
            'stripe_sandbox_pk'            => ['type' => 'LONGTEXT',    'null' => true],
            'stripe_live_sk'               => ['type' => 'LONGTEXT',    'null' => true],
            'stripe_live_pk'               => ['type' => 'LONGTEXT',    'null' => true],
            'bank_name'                    => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'branch_name'                  => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'acc_no'                       => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'ifsc_code'                    => ['type' => 'VARCHAR',     'constraint' => 250, 'null' => true],
            'created_at'                   => ['type' => 'TIMESTAMP',   'default' => new RawSql('CURRENT_TIMESTAMP')],
            'updated_at'                   => ['type' => 'TIMESTAMP',   'default' => new RawSql('CURRENT_TIMESTAMP'), 'null' => false],
            'published'                    => ['type' => 'TINYINT',     'constraint' => 1, 'default' => 1],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('general_settings');
    }

    public function down()
    {
        $this->forge->dropTable('general_settings');
    }
}
