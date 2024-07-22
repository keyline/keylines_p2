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
        $users              = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'is_tracker_user' => 1], 'id,name,status', '', '', $order_by);
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
        $data['year']        = $yearString;
        $data['arr']                        = $arr;
        $data['last7DaysResponses']         = $last7DaysResponses;
        // pr($data['last7DaysResponses']); die();
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

        $dateFormate = date_create($date);
        if ($dateFormate) {
            $formattedDate = date_format($dateFormate, 'Y-m-d');
        }
        $sql = "SELECT attendances.user_id, attendances.punch_date, attendances.punch_in_time, attendances.punch_in_address, attendances.punch_in_image, user.name FROM `attendances`
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
                                <img src="' . getenv('app.uploadsURL') . 'user/' . esc($record->punch_in_image) . '" alt="' . esc($record->user_id) . '" class="rounded-circle">
                            </td>
                            <td>' . esc($record->name) . '</td>
                            <td>' . esc($record->punch_date) . '</td>
                            <td>' . esc($record->punch_in_time) . '</td>
                            <td>' . esc($record->punch_in_address) . '</td>
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
}
