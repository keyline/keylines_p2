<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use CodeIgniter\CLI\Console;

class AttendanceController extends BaseController
{
    private $model;  //This can be accessed by all class methods
    public function __construct()
    {
        $session = \Config\Services::session();
        if (!$session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }
        $model = new CommonModel();
        $this->data = array(
            'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Attendance',
            'controller_route'      => 'attendance',
            'controller'            => 'AttendanceController',
            'table_name'            => 'attendances',
            'primary_key'           => 'id'
        );
    }

    public function attendance()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'attendance-report';
        $data['userType']           = $this->session->user_type;
        $userType                   = $data['userType'];
        $userId                     = $this->session->user_id;
        $order_by[0]        = array('field' => 'status', 'type' => 'DESC');
        $order_by[1]        = array('field' => 'name', 'type' => 'ASC');
        $cu_date            = date('Y-m-d');
        $users              = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'is_tracker_user' => 1], 'id,name,status', '', '', $order_by);
        $data['total_app_user']             = $this->db->query("SELECT COUNT(id) as user_count FROM `user` WHERE is_salarybox_user = '1'")->getRow();                
        $data['total_present_user']         = $this->db->query("SELECT COUNT(DISTINCT attendances.user_id) AS user_count FROM `attendances` WHERE attendances.punch_date LIKE '%$cu_date%'")->getRow();
        $response = [];
        $year = [];
        $sl = 1;        
        $last7DaysResponses = [];
        $arr                = [];        
        $arr = $this->getLastNDays(7, 'Y-m-d');
        // print_r($arr);die;
        if ($users) {
            foreach ($users as $row) {
                if ($this->request->getGet('mode') == 'year') {
                    //  pr($this->request->getGet('year'));                    
                    $year = $this->request->getGet('year');
                } else {
                    $year = date('Y');
                }
                $yearString = $year;
                if (!empty($arr)) {
                    $reports = [];
                    for ($k = 0; $k < count($arr); $k++) {
                        $loopDate           = $arr[$k];                        
                        $dayWiseBooked      = $this->db->query("SELECT punch_in_time, punch_out_time FROM `attendances` where user_id='$row->id' and punch_date LIKE '$loopDate'")->getRow();
                        
                        if ($dayWiseBooked) {
                            $punchIn = $dayWiseBooked->punch_in_time;
                            $punchOut = $dayWiseBooked->punch_out_time;
                        } else {
                            $punchIn = null;
                            $punchOut = null;
                        }
                        $reports[] = [
                            'booked_date'   => date_format(date_create($loopDate), "d-m-Y"),
                            'punchIn' => $punchIn,
                            'punchOut' => $punchOut,
                        ];
                    }
                }
                $last7DaysResponses[] = [
                    'userId'    => $row->id,
                    'name'      => $row->name,
                    'reports'   => $reports,
                ];
            }
        }
        //monthly attendance
        $data['month_fetch'] = '';
        $form_type = $this->request->getPost('form_type');
        // $orderBy[0]         = ['field' => 'id', 'type' => 'ASC'];
        // $getEvents          = $this->common_model->find_data('event', 'array', '', 'title,start_event', '', '', $orderBy);
        // pr($getEvents);
        if ($form_type == 'monthly_attendance_report') {

            // Handle the first form submission (Fetching backlog date)
            $month_fetch             = $this->request->getPost('month');             
            $sql = "SELECT attendances.user_id, team.type as designation, department.deprt_name as team, 
                    COUNT(DISTINCT attendances.punch_date) as present_count, user.name
                    FROM attendances
                    INNER JOIN team ON attendances.user_id = team.user_id  -- First join attendances with team
                    INNER JOIN department ON team.dep_id = department.id   -- Then join team with department
                    INNER JOIN user ON attendances.user_id = user.id       -- Finally join user to get the name
                    WHERE punch_date LIKE '%$month_fetch%'  -- Filter for September 2024
                    GROUP BY attendances.user_id, team.dep_id, team.type, department.deprt_name, user.name";
            $rows = $this->db->query($sql)->getResult();
            // pr($rows);
            $data['monthlyAttendancereport'] = $rows;
            $data['month_fetch']      = $month_fetch;

            $year = date('Y', strtotime($month_fetch));
            $month = date('m', strtotime($month_fetch));

            function getWorkingDays($year, $month) {
                // Total days in the given month
                $total_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
                
                // Connect to the database
                $db = \Config\Database::connect();
                
                // Fetch week-off Saturdays (2nd and 4th) from the application settings
                $sql1 = "SELECT satarday FROM `application_settings`";
                $week_off = $db->query($sql1)->getRow();                                                
                $saturdays_off = json_decode($week_off->satarday);
                // pr(json_decode($week_off->satarday));
                
                
                // Fetch holidays for the month
                $holidays = getHolidays($year, $month);  // Ensure this returns an array of dates (YYYY-MM-DD)
            
                // Initialize total working days counter
                $total_working_days = 0;
                $dates = [];
            
                for ($day = 1; $day <= $total_days_in_month; $day++) {                   
                    // Get the date for the current day
                    $current_date = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $dates[] = $current_date;
                    
                    // Get the day of the week: 0 (Sunday) to 6 (Saturday)
                    $day_of_week = date('w', strtotime($current_date));
            
                    // Skip Sundays (0)
                    if ($day_of_week == 0) {
                        continue;  // Skip this day, it's a Sunday
                    }
            
                    // Check if the current day is a Saturday (6)
                    if ($day_of_week == 6) {
                        // Determine if it's the 2nd or 4th Saturday
                        $week_number = ceil($day / 7); // Calculate the week number (1st, 2nd, etc.) 
                        
                        // Skip if the Saturday is marked as a week-off
                        if (in_array($week_number, $saturdays_off)) {
                            continue;  // Skip this Saturday
                        }
                    }
            
                    // If the current date is not a holiday or a week-off, count it as a working day
                    if (!in_array($current_date, $holidays)) {
                        $total_working_days++;
                    }
                }
            
                return [
                            'total_working_days' => $total_working_days,
                            'month_dates' => $dates
                        ];
            }                                    
            function getHolidays($year, $month) {
                // You can fetch this data from the database
                // Example SQL query to fetch holidays dynamically for the given month
                $db = \Config\Database::connect();
                $holiday_count = "SELECT * FROM event WHERE MONTH(start_event) = $month AND YEAR(start_event) = $year"; 
                $query = $db->query($holiday_count); 
                $holidays = array_column($query->getResultArray(), 'start_event');               
                return $holidays;
            }                        
            $working_days = getWorkingDays($year, $month);
            $data['working_days'] = $working_days['total_working_days'];
            $data['month_dates'] = $working_days['month_dates'];
            $dates = $working_days['month_dates'];
            //  echo "Total working days: " . $working_days; die;

            // Prepare attendance details data
            $attendance_map = [];
            $results = $this->db->query("SELECT user_id, punch_date, punch_in_time
                                        FROM attendances
                                        WHERE punch_date LIKE '%$month_fetch%'")->getResult();

            foreach ($results as $r) {
                $attendance_map[$r->user_id][$r->punch_date] = $r->punch_in_time;
            }
            $latetime = "SELECT mark_later_after FROM `application_settings`";
            $latetime_fetch = $db->query($latetime)->getRow();  
            $late_threshold = $latetime_fetch ? $latetime_fetch->mark_later_after : '10:00:00';

            // Calculate attendance summary
            $finalReport = [];
            foreach ($users as $user) {
                $userRow = [
                    'user_id' => $user->id,
                    'name' => $user->name,                    
                    'days' => [],
                    'present' => 0,
                    'absent' => 0,
                    'late' => 0
                ];

                foreach ($dates as $date) {
                    $status = 'A';
                    $punchIn = $attendance_map[$user->id][$date] ?? null;
                    if ($punchIn) {
                        $status = (strtotime($punchIn) > strtotime($late_threshold)) ? 'L' : 'P';
                        $userRow['present']++;
                        if ($status == 'L') $userRow['late']++;
                    } else {
                        $userRow['absent']++;
                    }
                    $userRow['days'][] = $status;
                }
                $finalReport[] = $userRow;
            }
            $data['monthlyAttendancedetailsreport'] = $finalReport;
            pr($data['monthlyAttendancedetailsreport']);
            
        } 
        //monthly attendance         
        $data['year']        = $yearString;
        $data['arr']                        = $arr;
        $data['last7DaysResponses']         = $last7DaysResponses;        
        echo $this->layout_after_login($title, $page_name, $data);
    }
    
    public function getLastNDays($days, $format = 'd/m')
    {
        $m = date("m");
        $de = date("d");
        $y = date("Y");
        $dateArray = array();
        for ($i = 0; $i <= $days - 1; $i++) {
            $dateArray[] = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
        }
        return array_reverse($dateArray);
    }

    /* day-wise modal punchin list */
    public function PunchInRecords()
        {
            $userId         = $this->request->getGet('userId');
            $name           = $this->request->getGet('name');
            $date           = $this->request->getGet('date');
            $punchIn        = $this->request->getGet('punchIn');
            $punchOut       = $this->request->getGet('punchOut');

            // pr($this->request->getGet());

            $dateFormate = date_create($date);
            if ($dateFormate) {
                $formattedDate = date_format($dateFormate, 'Y-m-d');
            }
            $sql = "SELECT attendances.user_id, attendances.punch_date, attendances.punch_in_time, attendances.punch_in_address, attendances.punch_in_image, attendances.punch_out_time, attendances.punch_out_address, attendances.punch_out_image, user.name FROM `attendances`
                    INNER JOIN user WHERE attendances.user_id = user.id and user_id = $userId AND punch_date = '$formattedDate'";

            $rows = $this->db->query($sql)->getResult();
            $html = '<div class="modal-header" style="justify-content: center;">
                        <center><h6 class="modal-title">Attendance of  <b><u> ' . $name . ' </b></u> on <b><u> ' . $date . ' </b></u></h6></center>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="table-responsive">
                                <table class="table general_table_style table-bordered">
                                    <thead>
                                        <tr>                                            
                                            <th>Image</th>                                           
                                            <th>Punch Date</th>
                                            <th>Punch Time(IN-OUT)</th>
                                            <th>Address</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
            if (!empty($rows)) {
                $sl = 1;
                foreach ($rows as $record) {
                    $html .= '<tr>
                                <td>
                                    <img src="' . getenv('app.uploadsURL') . 'user/' . esc($record->punch_in_image) . '" alt="' . esc($record->user_id) . '" class="rounded-circle punch-img">
                                </td>                                                                
                                <td><b>IN:</b> ' . esc($record->punch_in_time) .'</td>
                                <td>' . esc($record->punch_in_address) . '</td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="' . getenv('app.uploadsURL') . 'user/' . esc($record->punch_out_image) . '" alt="' . esc($record->user_id) . '" class="rounded-circle punch-img">
                                </td>                                                                
                                <td><b>OUT:</b> ' . esc($record->punch_out_time) .'</td>
                                <td>' . esc($record->punch_out_address) . '</td>
                            </tr>';
                }
            } else {
                $html .= '<tr>
                            <td colspan="6">No records found for the selected date.</td>
                          </tr>';
            }
            $html .= '</tbody>                            
                        </table>
                    </div>
                </div>
            </div>';
        echo $html;
        }
    /* day-wise modal punchin list */

    /* day-wise modal punchout list */
    public function PunchOutRecords()
    {
        $userId         = $this->request->getGet('userId');
        $name           = $this->request->getGet('name');
        $date           = $this->request->getGet('date');
        $punchIn        = $this->request->getGet('punchOut');

        $dateFormate = date_create($date);
        if ($dateFormate) {
            $formattedDate = date_format($dateFormate, 'Y-m-d');
        }
        $sql = "SELECT attendances.user_id, attendances.punch_date, attendances.punch_out_time, attendances.punch_out_address, attendances.punch_out_image, user.name FROM `attendances`
                INNER JOIN user WHERE attendances.user_id = user.id and user_id = $userId AND punch_date = '$formattedDate'";

        $rows = $this->db->query($sql)->getResult();
        $html = '<div class="modal-header" style="justify-content: center;">
                    <center><h5 style="font-size: x-large;" class="modal-title">Attendance of  <b><u> ' . $name . ' </b></u> on <b><u> ' . $date . ' </b></u></h5></center>
                    <button style="position: absolute;right: 1rem;top: 1rem;background-color: #dd828b;border-radius: 50%;width: 30px;height: 30px;font-size: 1.2rem;color: #7e1019;cursor: pointer;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>                                            
                                        <th>Image</th>
                                        <th>User Name</th>
                                        <th>Punch Date</th>
                                        <th>Punch in Time</th>
                                        <th>Punch in Address</th>
                                    </tr>
                                </thead>
                                <tbody>';
        if (!empty($rows)) {
            $sl = 1;
            foreach ($rows as $record) {
                $html .= '<tr>
                            <td>
                                <img src="' . getenv('app.uploadsURL') . 'user/' . esc($record->punch_out_image) . '" alt="' . esc($record->user_id) . '" class="rounded-circle">
                            </td>
                            <td>' . esc($record->name) . '</td>
                            <td>' . esc($record->punch_date) . '</td>
                            <td>' . esc($record->punch_out_time) . '</td>
                            <td>' . esc($record->punch_out_address) . '</td>
                        </tr>';
            }
        } else {
            $html .= '<tr>
                        <td colspan="6">No records found for the selected date.</td>
                      </tr>';
        }
        $html .= '</tbody>                            
                    </table>
                </div>
            </div>
        </div>';
    echo $html;
    }
    /* day-wise modal punchout list */

    /* monthly attendance report */
    public function monthlyAttendance()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'attendance-report';
        $data['userType']           = $this->session->user_type;
        $form_type = $this->request->getPost('form_type');

        if ($form_type == 'monthly_attendance_report') {

            // Handle the first form submission (Fetching backlog date)
            $month              = $this->request->getPost('month'); 
            $sql = "SELECT attendances.user_id, team.type as designation, department.deprt_name as team, 
                    COUNT(attendances.punch_date) as present_count, user.name
                    FROM attendances
                    INNER JOIN team ON attendances.user_id = team.user_id  -- First join attendances with team
                    INNER JOIN department ON team.dep_id = department.id   -- Then join team with department
                    INNER JOIN user ON attendances.user_id = user.id       -- Finally join user to get the name
                    WHERE punch_date LIKE '2024-09%'  -- Filter for September 2024
                    GROUP BY attendances.user_id, team.dep_id, team.type, department.deprt_name, user.name";
            $rows = $this->db->query($sql)->getResult();
            // pr($rows);
            $data['monthlyAttendancereport'] = $rows;
            
        }  
        echo $this->layout_after_login($title, $page_name, $data);  
    }
    
    /* monthly attendance report */
}
