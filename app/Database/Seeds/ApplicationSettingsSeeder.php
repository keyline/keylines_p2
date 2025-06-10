<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ApplicationSettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'theme_color'                         => '#f19620',
            'font_color'                          => '#ffffff',
            'tomorrow_task_editing_time'          => '11:00',
            'api_url'                             => 'https://api.desklog.io/api/v2/app_usage_attendance',
            'api_key'                             => 'b1y6yvgff8ipadvhjb3yhkvnhwunb4eul11vwdyp',
            'block_tracker_fillup_after_days'     => 3,
            'is_desklog_use'                      => 1,
            'is_task_approval'                    => 0,
            'is_project_cost'                     => 1,
            'encryption_api_secret_key'           => '09213752946580284628402947517393',
            'encryption_api_secret_iv'            => 'pwhdyevskeifywbx',
            'encryption_api_encrypt_method'       => 'AES-256-CBC',
            'google_map_api_code'                 => 'AIzaSyBX7ODSt5YdPpUA252kxr459iV2UZwJwfQ',
            'allow_punch_distance'                => 100,
            'current_date_tasks_show_in_effort'   => '00:00',
            'monthly_minimum_effort_time'         => 172,
            'daily_minimum_effort_time'           => 8,
            'mark_later_after'                    => '10:00:00',
            'currency'                            => 'INR',
            'edit_time_after_task_add'            => 960,
            'sunday'                              => json_encode(["1", "2", "3", "4", "5"]),
            'monday'                              => json_encode([]),
            'tuesday'                             => json_encode([]),
            'wednesday'                           => json_encode([]),
            'thursday'                            => json_encode([]),
            'friday'                              => json_encode([]),
            'satarday'                            => json_encode(["2", "4"]),
            'created_at'                          => '0000-00-00 00:00:00',
            'updated_at'                          => '2023-11-03 15:15:26',
            'published'                           => 1,
        ];

        // Use Query Builder to perform an upsert (insert or update)  
        $builder = $this->db->table('application_settings');
        $builder->upsert($data);
    }
}
