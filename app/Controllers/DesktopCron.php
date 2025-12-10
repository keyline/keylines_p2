<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DesktopCron extends BaseController
{
    /**
     * Main entry: cron calls this URL once per hour.
     * It will process ALL active users for TODAY.
     */
    public function run()
    {
        // Simple security so random people can't hit your cron URL
        $token = $this->request->getGet('token');
        if ($token !== getenv('cron.secret')) {
            return $this->response->setStatusCode(403, 'Forbidden');
        }

        $today = date('Y-m-d');

        // Get all active users (adjust table/column names as per your DB)
        $users = $this->db->table('user')
            ->where('status', '1')
            ->get()
            ->getResult();

        foreach ($users as $u) {
            // echo $u->id; echo "<br>";
             
            $this->saveTimelineForUser($u->id, $today);
        }
    //   echo $today;
    //    die;

        return $this->response->setJSON(['status' => 'done', 'date' => $today]);
        // echo "Cron running...";
    }

    /**
     * For one user & one date: calculate totals & insert/update desktop_app
     */
    public function saveTimelineForUser($userId, $date = null)
    {
        $date = $date ?? date('Y-m-d');   // e.g. 2025-12-09

        // 1) get screenshots for that user/date
        //  CHANGE 'screenshots' AND COLUMN NAMES IF NEEDED
        $items = $this->db->table('user_screenshots')
            ->where('user_id', $userId)
             ->where("CAST(time_stamp AS DATE) =", $date)
            ->orderBy('time_stamp', 'ASC')
            ->get()
            ->getResultArray();
            // print_r($items); die;
        if (empty($items)) {
            return; // nothing to save
        }

        // 2) calculate totals in PHP (similar logic to your segments)
        $totals = $this->calculateTimeline($items); // ['total','productive','idle'] in minutes

        $timeAtWork     = sprintf('%02d:%02d', intdiv($totals['total'], 60), $totals['total'] % 60);
        $productiveTime = sprintf('%02d:%02d', intdiv($totals['productive'], 60), $totals['productive'] % 60);
        $idleTime       = sprintf('%02d:%02d', intdiv($totals['idle'], 60), $totals['idle'] % 60);

        $firstShotTime = $items[0]['time_stamp'];
        $lastShotTime  = end($items)['time_stamp'];

        // 3) Check if a row already exists for this user + date
        $existingRow = $this->db->table('desktop_app')
        ->where('desktopapp_userid', $userId)
        ->where("CAST(arrival_at AS DATE) =", $date)
        ->get()
        ->getRow(); // or getRowArray()

        // Common data for update/insert
        $data = [
            'arrival_at'        => $firstShotTime,
            'left_at'           => $lastShotTime,
            'time_at_work'      => $timeAtWork,
            'productive_time'   => $productiveTime,
            'idle_time'         => $idleTime,
            'private_time'      => '00:00', // adjust if you calculate this
            'time_zone'         => date_default_timezone_get(),
            'app_and_os'        => '',
            'insert_date'       => date('Y-m-d H:i:s'),
        ];

        if ($existingRow) {
            // 4A) UPDATE existing record
            $this->db->table('desktop_app')
                ->where('desktopapp_userid', $userId)
                ->where("CAST(arrival_at AS DATE) =", $date)
                ->update($data);

        } else {
            // 4B) INSERT new record
            $userRow = $this->db->table('user')
                ->where('id', $userId)
                ->get()
                ->getRow();

            $data['desktopapp_userid'] = $userId;
            $data['email']             = $userRow->email ?? '';

            $this->db->table('desktop_app')->insert($data);
        }
    }

        private function buildSegments(array $row): array
    {
        $segments = [];
        if (count($row)) {
            $index = 0;
            $items = array_reverse($row);
            $previousScreenshot = $items[0];
            $previousTime = $items[0]['time_stamp'];

            while ($index < count($items)) {

                if ($index === 0) {
                    $width = 300;
                    $initTime = date('H:i', strtotime($items[0]['time_stamp']) - $width);
                    $endTime  = date('H:i', strtotime($items[0]['time_stamp']));
                    $diffSeconds = 300;
                    $color  = 'green';
                    $status = 'Active';
                    $index++;
                    continue;   // same as your view: nothing is pushed to $segments for index 0
                }

                $screenshot = $items[$index];
                $time       = $screenshot['time_stamp'];

                if ($screenshot['idle_status'] == 1) {
                    if ($previousScreenshot['idle_status'] == 1) {
                        $currTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                    date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                    date('s', strtotime($screenshot['time_stamp']));

                        $prevTime = date('H', strtotime($previousScreenshot['time_stamp'])) * 3600 +
                                    date('i', strtotime($previousScreenshot['time_stamp'])) * 60 +
                                    date('s', strtotime($previousScreenshot['time_stamp']));

                        $width = (abs($currTime - $prevTime) > 300)
                            ? 300
                            : abs($currTime - $prevTime);

                        $initTime = date('H:i', strtotime($screenshot['time_stamp']) - $width);
                        $endTime  = date('H:i', strtotime($screenshot['time_stamp']));

                        $diffSeconds = (abs(strtotime($initTime) - strtotime($endTime)) > 300)
                            ? 300
                            : (strtotime($endTime) - strtotime($initTime));

                        $diffMinutes = round(abs($diffSeconds) / 60);
                        $color  = 'green';
                        $status = 'Active';
                    } else {
                        $prevTime = date('H', strtotime($previousScreenshot['time_stamp'])) * 3600 +
                                    date('i', strtotime($previousScreenshot['time_stamp'])) * 60 +
                                    date('s', strtotime($previousScreenshot['time_stamp']));
                        $currTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                    date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                    date('s', strtotime($screenshot['time_stamp']));

                        $width = (abs($currTime - $prevTime) > 300)
                            ? 300
                            : abs($currTime - $prevTime);

                        $initTime = date('H:i', strtotime($screenshot['time_stamp']) - $width);
                        $endTime  = date('H:i', strtotime($screenshot['time_stamp']));

                        $diffSeconds = (abs(strtotime($endTime) - strtotime($initTime)) > 300)
                            ? 300
                            : (strtotime($endTime) - strtotime($initTime));

                        $diffMinutes = round(abs($diffSeconds) / 60);
                        $color  = 'yellow';
                        $status = 'Idle';
                    }
                } else {

                    if ($previousScreenshot['idle_status'] == 1) {
                        $prevTime = date('H', strtotime($previousScreenshot['time_stamp'])) * 3600 +
                                    date('i', strtotime($previousScreenshot['time_stamp'])) * 60 +
                                    date('s', strtotime($previousScreenshot['time_stamp']));
                        $currTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                    date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                    date('s', strtotime($screenshot['time_stamp']));

                        $width = 180; // fixed 3 minutes

                        $startTime = date('H:i', strtotime($screenshot['time_stamp']));
                        $initTime  = date('H:i', strtotime($startTime . ' -3 minutes'));
                        $endTime   = date('H:i', strtotime($screenshot['time_stamp']));

                        $diffSeconds = 180;
                        $diffMinutes = round(abs($diffSeconds) / 60);
                        $color  = 'yellow';
                        $status = 'Idle';

                    } else {
                        $prevTime = date('H', strtotime($previousScreenshot['time_stamp'])) * 3600 +
                                    date('i', strtotime($previousScreenshot['time_stamp'])) * 60 +
                                    date('s', strtotime($previousScreenshot['time_stamp']));
                        $currTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                    date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                    date('s', strtotime($screenshot['time_stamp']));

                        $width = (abs($currTime - $prevTime) > 300)
                            ? 300
                            : abs($currTime - $prevTime);

                        $initTime = date('H:i', strtotime($screenshot['time_stamp']) - $width);
                        $endTime  = date('H:i', strtotime($screenshot['time_stamp']));

                        $diffSeconds = (abs(strtotime($endTime) - strtotime($initTime)) > 300)
                            ? 300
                            : (strtotime($endTime) - strtotime($initTime));

                        $diffMinutes = round(abs($diffSeconds) / 60);
                        $color  = 'yellow';
                        $status = 'Idle';
                    }
                }

                $previousScreenshot = $screenshot;
                $secondsInDay = 86400;

                $percentage        = ($currTime / $secondsInDay) * 100;
                $durationPercentage = ($width / $secondsInDay) * 100;

                $segments[] = [
                    'diffTime' => $diffMinutes,
                    'initTime' => $initTime,
                    'endTime'  => $endTime,
                    'start'    => $percentage,
                    'width'    => $durationPercentage,
                    'color'    => $color,
                    'status'   => $status,
                ];

                $index++;
            }
        }

        return $segments;
    }

    /**
     * Copy your PHP logic from the view that builds $segments
     * and converts to total / productive / idle minutes.
     */
    private function calculateTimeline(array $items): array
    {
        $segments = $this->buildSegments($items);

        $total = 0;
        $productive = 0;
        $idle = 0;

        foreach ($segments as $s) {

            // mimic JS: skip segments beyond 100%
            $end = $s['start'] + $s['width'];
            if ($end > 100) {
                continue;
            }

            $total += $s['diffTime'];

            if ($s['color'] === 'green') {
                $productive += $s['diffTime'];
            } else {
                // JS logic: any non-green (yellow/others) is treated as idle
                $idle += $s['diffTime'];
            }
        }

        return [
            'total'      => $total,
            'productive' => $productive,
            'idle'       => $idle,
        ];
    }

}
