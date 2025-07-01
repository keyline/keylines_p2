<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ScreenshotSettingsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            'screenshot_resolution' => '1280x720',
            'idle_time'             => 180,  // in seconds
            'screenshot_time'       => 180,  // in seconds
        ];

        $this->db->table('screenshot_settings')->insert($data);
    }
}
