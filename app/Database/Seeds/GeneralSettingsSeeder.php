<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GeneralSettingsSeeder extends Seeder
{
    public function run()
    {
        $general_settings =  array(
            'id' => '1',
            'company_name' => 'Keyline Effortrak Demo',
            'site_name' => 'Effortrak',
            'site_phone' => '033-3565-5440 / 9330109091',
            'site_mail' => 'info@keylines.net',
            'system_email' => 'info@keylines.net',
            'site_url' => 'https://demo.effortrak.com',
            'description' => '36A, Chandi Ghosh Road, Kolkata – 700040, West Bengal',
            'site_logo' => '1725035306Effortrak.png',
            'site_footer_logo' => '1725035326Effortrak.png',
            'site_favicon' => '1725035361pro-time-icon.gif',
            'become_partner_text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is imply dummy text Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is imply dummy text Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is imply dummy text Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is imply dummy text Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is imply dummy text Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum is imply dummy text Lorem Ipsum is simply dummy text of the printing and typesetting industry',
            'copyright_statement' => '',
            'google_map_api_code' => '',
            'google_analytics_code' => '',
            'google_pixel_code' => '',
            'facebook_tracking_code' => '',
            'gst_api_code' => 'bc302a97f51e2193d99b4ec87862edf2',
            'firebase_server_key' => 'AAAAcuxW4TM:APA91bEYf0IFYnSCeuzdtQ-83wkjiQLVtfmo5fgFqaxxb2A9oI5q9p7AHNOklkUZwKJ3uzRmHo5MkNKWJHW-Q4PlkoiW_oEyFINnwaipChLIW7MHJ3uBtnMQf8P0RskK_mqJ5hS1q2Yh',
            'theme_color' => NULL,
            'font_color' => NULL,
            'tomorrow_task_editing_time' => '',
            'block_tracker_fillup_after_days' => '3',
            'is_desklog_use' => '1',
            'is_task_approval' => '1',
            'twitter_profile' => '',
            'facebook_profile' => '',
            'instagram_profile' => '',
            'linkedin_profile' => '',
            'youtube_profile' => '',
            'sms_authentication_key' => 'Cuj0HpSThBwCIWai',
            'sms_sender_id' => 'KEYLIN',
            'sms_base_url' => 'http://sms.keylines.net/V2/http-api.php',
            'from_email' => 'no-reply@keylines.net',
            'from_name' => 'Keyline Time Sheet',
            'smtp_host' => 'smtp-relay.brevo.com',
            'smtp_username' => 'info@keylines.net',
            'smtp_password' => 'ENv4c1a8R9xZ2zjd',
            'smtp_port' => '587',
            'meta_title' => 'Effort Booking System - Keyline Digitech',
            'meta_description' => '',
            'meta_keywords' => '',
            'footer_text' => '<p>&copy; 2024 Keyline Time Sheet. ALL RIGHTS RESERVED.</p>
',
            'footer_link_name' => '["home 1","home 2"]',
            'footer_link' => '["https:\\/\\/commodity.ecoex.market\\/","https:\\/\\/commodity.ecoex.market\\/"]',
            'footer_link_name2' => '["profile 1","profile 2"]',
            'footer_link2' => '["https:\\/\\/commodity.ecoex.market\\/","https:\\/\\/commodity.ecoex.market\\/"]',
            'footer_link_name3' => '["contact 1","contact 2"]',
            'footer_link3' => '["https:\\/\\/commodity.ecoex.market\\/","https:\\/\\/commodity.ecoex.market\\/"]',
            'stripe_payment_type' => '1',
            'stripe_sandbox_sk' => '',
            'stripe_sandbox_pk' => '',
            'stripe_live_sk' => '',
            'stripe_live_pk' => '',
            'bank_name' => 'PUNJAB NATIONAL BANK',
            'branch_name' => 'Kolkata',
            'acc_no' => '9999999999',
            'ifsc_code' => 'GFFYUR76785',
            'created_at' => '0000-00-00 00:00:00',
            'updated_at' => '2023-11-03 15:15:26',
            'published' => '1'
        );


        $builder = $this->db->table('general_settings');
        $builder->upsert($general_settings);
    }
}
