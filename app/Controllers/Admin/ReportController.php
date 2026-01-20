<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use CodeIgniter\CLI\Console;

class ReportController extends BaseController
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
            'title'                 => 'Report',
            'controller_route'      => 'reports',
            'controller'            => 'ReportController',
            'table_name'            => 'effort_type',
            'primary_key'           => 'id'
        );
    }
    public function advanceSearch()
    {        
        if (!$this->common_model->checkModuleFunctionAccess(22, 88)) {
                $data['action']             = 'Access Forbidden';
                $title                      = $data['action'] . ' ' . $this->data['title'];
                $page_name                  = 'access-forbidden';
                echo $this->layout_after_login($title, $page_name, $data);
                exit;
            }  
        
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'] . ' : Advance Search';
        $page_name                  = 'report/advance-search';
        $order_by[0]                = array('field' => 'status', 'type' => 'DESC');
        $order_by[1]                = array('field' => 'name', 'type' => 'ASC');
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status!=' => '3'], 'id,name,status', '', '', $order_by);

        // $data['projectwise_users']  = $this->data['model']->find_data('user', 'array', ['status!=' => '3'], 'id,name,status', '', '', $order_by); 

        // $order_by[0]                = array('field' => 'project.status', 'type' => 'ASC');
        $order_by[0]                = array('field' => 'project.name', 'type' => 'ASC');
        $join[0]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
        $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
        $user_type                  = $this->session->get('user_type');
        $user_id                    = $this->session->get('user_id');

        if ($user_type == 'CLIENT') {
            $data['projects']           = $this->data['model']->find_data('project', 'array', ['project.status!=' => 13, 'project.client_id' => $user_id], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
            $data['closed_projects']    = $this->data['model']->find_data('project', 'array', ['project.status' => 13, 'project.client_id' => $user_id], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
            // dd($data['projects']); die;
            $project_id = $data['projects'][0]->id;
            $sql = "SELECT DISTINCT user.status, user.name, user.id FROM `timesheet` INNER JOIN user on timesheet.user_id = user.id WHERE timesheet.project_id = $project_id and user.status = '1';";
            $rows = $this->db->query($sql)->getResult();
            $data['projectwise_user'] = $rows;
            // pr($data['projectwise_user']);
        } else {
            $data['projects']           = $this->data['model']->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
            $data['closed_projects']    = $this->data['model']->find_data('project', 'array', ['project.status' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
        }


        $data['response']           = [];
        $data['search_user_id']     = 'all';
        $data['search_project_id']  = '';
        $data['search_day_id']      = 'all';
        $data['is_date_range']      = 0;
        $data['search_range_from']  = '';
        $data['search_range_to']    = '';
        $data['graph_users']        = '';
        $data['graph_user_data']    = '';
        if ($this->request->getGet('mode') == 'advance_search') {
            // pr($this->request->getGet());
            $search_user_id     = $this->request->getGet('search_user_id');
            $search_project_id  = $this->request->getGet('search_project_id');
            $search_day_id      = $this->request->getGet('search_day_id');
            $search_range_from  = $this->request->getGet('search_range_from');
            $search_range_to    = $this->request->getGet('search_range_to');
            if (array_key_exists('is_date_range', $this->request->getGet())) {
                $dayQuery = "date_added >= '$search_range_from' and date_added <= '$search_range_to'";
                $dayQuery4 = "t.date_added >= '$search_range_from' and t.date_added <= '$search_range_to'";
                if ($search_user_id == 'all' && $search_project_id == 'all') {
                    $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " order by id desc";
                    // $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " group by user_id";  
                    $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min, sum(cost) as tot_cost from timesheet where " . $dayQuery . " group by user_id";
                    $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " group by effort_type";
                    // $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " group by t.project_id order by p.name asc";
                    $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min, sum(cost) as tot_cost from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " group by t.project_id order by p.name asc";
                } elseif ($search_user_id != 'all' && $search_project_id == 'all') {
                    $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and user_id = '$search_user_id' order by id desc";
                    // $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by user_id";
                    $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min, sum(cost) as tot_cost from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by user_id";
                    $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by effort_type";
                    // $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
                    $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min, sum(cost) as tot_cost from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
                } elseif ($search_user_id == 'all' && $search_project_id != 'all') {
                    $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and project_id = '$search_project_id' order by id desc";
                    // $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by user_id";
                    $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min, sum(cost) as tot_cost from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by user_id";
                    $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by effort_type";
                    // $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' group by t.project_id order by p.name asc";
                    $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min, sum(cost) as tot_cost from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' group by t.project_id order by p.name asc";
                } elseif ($search_user_id != 'all' && $search_project_id != 'all') {
                    $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' order by id desc";
                    // $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by user_id";
                    $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min, sum(cost) as tot_cost from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by user_id";
                    $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by effort_type";
                    // $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
                    $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min, sum(cost) as tot_cost from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
                }
                $data['is_date_range']      = 1;
            } else {
                $today          = date('Y-m-d');
                $yesterday      = date('Y-m-d', strtotime("-1 days"));
                $lastMonday     = date('Y-m-d', strtotime('last Monday'));
                $lastWeekmonday = date('Y-m-d', strtotime('monday last week'));
                $lastWeeksunday = date('Y-m-d', strtotime('sunday last week'));
                $currentMonthFirstDay = date('Y-m') . "-01";
                $firstDayLastMonth = date("Y-m-d", mktime(0, 0, 0, date("m") - 1, 1));
                $lastDayLastMonth = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
                $last7Day = date('Y-m-d', strtotime('-7 days'));
                $last30Day = date('Y-m-d', strtotime('-30 days'));
                $data['is_date_range']      = 0;
                if ($search_day_id == 'all') {
                    $dayQuery = "date_added >= '2018-05-01'";
                    $dayQuery4 = "t.date_added >= '2018-05-01'";
                } elseif ($search_day_id == 'today') {
                    $dayQuery = "date_added = '$today'";
                    $dayQuery4 = "t.date_added = '$today'";
                } elseif ($search_day_id == 'yesterday') {
                    $dayQuery = "date_added = '$yesterday'";
                    $dayQuery4 = "t.date_added = '$yesterday'";
                } elseif ($search_day_id == 'this_week') {
                    $dayQuery = "date_added >= '$lastMonday' and date_added <= '$today'";
                    $dayQuery4 = "t.date_added >= '$lastMonday' and t.date_added <= '$today'";
                } elseif ($search_day_id == 'last_week') {
                    $dayQuery = "date_added >= '$lastWeekmonday' and date_added <= '$lastWeeksunday'";
                    $dayQuery4 = "t.date_added >= '$lastWeekmonday' and t.date_added <= '$lastWeeksunday'";
                } elseif ($search_day_id == 'this_month') {
                    $dayQuery = "date_added >= '$currentMonthFirstDay' and date_added <= '$today'";
                    $dayQuery4 = "t.date_added >= '$currentMonthFirstDay' and t.date_added <= '$today'";
                } elseif ($search_day_id == 'last_month') {
                    $dayQuery = "date_added >= '$firstDayLastMonth' and date_added <= '$lastDayLastMonth'";
                    $dayQuery4 = "t.date_added >= '$firstDayLastMonth' and t.date_added <= '$lastDayLastMonth'";
                } elseif ($search_day_id == 'last_7_days') {
                    $dayQuery = "date_added >= '$last7Day' and date_added <= '$yesterday'";
                    $dayQuery4 = "t.date_added >= '$last7Day' and t.date_added <= '$yesterday'";
                } elseif ($search_day_id == 'last_30_days') {
                    $dayQuery = "date_added >= '$last30Day' and date_added <= '$yesterday'";
                    $dayQuery4 = "t.date_added >= '$last30Day' and t.date_added <= '$yesterday'";
                }

                if ($search_user_id == 'all' && $search_project_id == 'all') {
                    $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " order by id desc";
                    // $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " group by user_id";
                    $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min, sum(cost) as tot_cost from timesheet where " . $dayQuery . " group by user_id";
                    $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " group by effort_type";
                    // $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " group by t.project_id order by p.name asc";
                    $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min, sum(cost) as tot_cost from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " group by t.project_id order by p.name asc";
                } elseif ($search_user_id != 'all' && $search_project_id == 'all') {
                    $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and user_id = '$search_user_id' order by id desc";
                    // $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by user_id";
                    $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min, sum(cost) as tot_cost from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by user_id";
                    $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by effort_type";
                    // $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
                    $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min, sum(cost) as tot_cost from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
                } elseif ($search_user_id == 'all' && $search_project_id != 'all') {
                    $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and project_id = '$search_project_id' order by id desc";
                    // $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by user_id";
                    $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min, sum(cost) as tot_cost from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by user_id";
                    $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by effort_type";
                    // $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' group by t.project_id order by p.name asc";
                    $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min, sum(cost) as tot_cost from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' group by t.project_id order by p.name asc";
                } elseif ($search_user_id != 'all' && $search_project_id != 'all') {
                    $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' order by id desc";
                    // $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by user_id";
                    $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min, sum(cost) as tot_cost from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by user_id";
                    $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by effort_type";
                    // $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
                    $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min, sum(cost) as tot_cost from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
                }
            }
            // echo $sql;die;
            $rows = $this->db->query($sql)->getResult();
            $response = [];
            $total_effort_in_mins = 0;
            if ($rows) {
                $sl = 1;
                foreach ($rows as $row) {
                    $getProject = $this->common_model->find_data('project', 'row', ['id' => $row->project_id], 'name');
                    $getUser = $this->common_model->find_data('user', 'row', ['id' => $row->user_id], 'name');
                    $getProjectStatus = $this->common_model->find_data('project_status', 'row', ['id' => $row->status_id], 'name');
                    $getEffortType = $this->common_model->find_data('effort_type', 'row', ['id' => $row->effort_type], 'name');
                    $effort_time = $row->hour . ':' . $row->min;
                    $response[] = [
                        'sl_no'             => $sl++,
                        'id'                => $row->id,
                        'project_name'      => (($getProject) ? $getProject->name : ''),
                        'user_name'         => (($getUser) ? $getUser->name : ''),
                        'work_date'         => date_format(date_create($row->date_added), "d-m-Y"),
                        'date_today'        => date_format(date_create($row->date_today), "d-m-Y"),
                        'description'       => $row->description,
                        'effort_time'       => $effort_time,
                        'hour'              => $row->hour,
                        'min'               => $row->min,
                        'project_status'    => (($getProjectStatus) ? $getProjectStatus->name : ''),
                        'effort_type'       => (($getEffortType) ? $getEffortType->name : ''),
                    ];
                    $total_hour_min = ($row->hour * 60); // 0*60 = 0
                    $total_min_min = $row->min; // 30
                    $total_effort_in_mins += ($total_hour_min + $total_min_min);
                }
            }
            $data['response']               = $response;
            $data['total_effort_in_mins']   = $total_effort_in_mins;
            $data['search_user_id']         = $search_user_id;
            $data['search_project_id']      = $search_project_id;
            $data['search_day_id']          = $search_day_id;
            $data['search_range_from']      = $search_range_from;
            $data['search_range_to']        = $search_range_to;

            

            /* user graph */
            $getUserGraphs = $this->db->query($sql2)->getResult();
            $graphUsers     = [];
            $graphUserData  = [];
            if ($getUserGraphs) {
                foreach ($getUserGraphs as $getUserGraph) {
                    $getUser = $this->common_model->find_data('user', 'row', ['id' => $getUserGraph->user_id], 'name');
                    $tot_hour               = $getUserGraph->tot_hour * 60;
                    $tot_min                = $getUserGraph->tot_min;
                    $totMins                = $tot_hour + $tot_min;
                    $totalBooked            = intdiv($totMins, 60) . '.' . ($totMins % 60);
                    $graphUserData[]        = "'" . $totalBooked . "'";
                    $totalCost              =  number_format($getUserGraph->tot_cost, 2);
                    // $graphUsers[]           = (($getUser) ? "'" . $getUser->name . " [" . $totalBooked . "]'" : '');
                    // if($user_type == 'SUPER ADMIN' ){
                        $graphUsers[]           = (($getUser) ? "'" . $getUser->name . " [" . $totalBooked . "]    [ ₹" . $totalCost . " ]'" : '');
                    // }else{
                    //     $graphUsers[]           = (($getUser) ? "'" . $getUser->name . " [" . $totalBooked . "]'" : '');
                    // }
            }
            // pr($graphUsers,0);
            // pr($graphUserData);
            $data['graph_users']            = $graphUsers;
            $data['graph_user_data']        = $graphUserData;
            /* user graph */
            /* type graph */
            $getTypeGraphs = $this->db->query($sql3)->getResult();
            $graphTypes     = [];
            $graphTypeData  = [];
            if ($getTypeGraphs) {
                foreach ($getTypeGraphs as $getTypeGraph) {
                    $getEffortType          = $this->common_model->find_data('effort_type', 'row', ['id' => $getTypeGraph->effort_type], 'name');

                    $tot_hour               = $getTypeGraph->tot_hour * 60;
                    $tot_min                = $getTypeGraph->tot_min;
                    $totMins                = $tot_hour + $tot_min;
                    $totalBooked            = intdiv($totMins, 60) . '.' . ($totMins % 60);
                    $graphTypeData[]        = "'" . $totalBooked . "'";
                    $graphTypes[]           = (($getEffortType) ? "'" . $getEffortType->name . " [" . $totalBooked . "]'" : '');
                }
            }
            // pr($graphTypes,0);
            // pr($graphTypeData);
            $data['graph_types']            = $graphTypes;
            $data['graph_type_data']        = $graphTypeData;
            /* type graph */
            /* project graph */
            $getProjectGraphs = $this->db->query($sql4)->getResult();
            $graphProjects     = [];
            $graphProjectData  = [];
            if ($getProjectGraphs) {
                foreach ($getProjectGraphs as $getProjectGraph) {
                    $getProject          = $this->common_model->find_data('project', 'row', ['id' => $getProjectGraph->project_id], 'name');

                    $tot_hour               = $getProjectGraph->tot_hour * 60;
                    $tot_min                = $getProjectGraph->tot_min;
                    $totMins                = $tot_hour + $tot_min;
                    $totalBooked            = intdiv($totMins, 60) . '.' . ($totMins % 60);
                    $graphProjectData[]     = "'" . $totalBooked . "'";
                    $totalCostOfProject     =  number_format($getProjectGraph->tot_cost, 2);
                    $graphProjects[]        = (($getProject) ? "'" . $getProject->name . " [" . $totalBooked . "]    [ ₹" . $totalCostOfProject . " ]'" : '');
                }
            }
            // pr($graphProjects,0);
            // pr($graphProjectData);
            $data['graph_projects_bar_height']            = ((count($graphProjects) > 1) ? (count($graphProjects) * 30) : 100);
            $data['graph_projects']            = $graphProjects;
            $data['graph_project_data']        = $graphProjectData;
            /* project graph */
        }
        echo $this->layout_after_login($title, $page_name, $data);
        }
    }

    // public function advanceSearch()
    // {        
    //     if (!$this->common_model->checkModuleFunctionAccess(22, 88)) {
    //             $data['action']             = 'Access Forbidden';
    //             $title                      = $data['action'] . ' ' . $this->data['title'];
    //             $page_name                  = 'access-forbidden';
    //             echo $this->layout_after_login($title, $page_name, $data);
    //             exit;
    //         }  
    //     $data['moduleDetail']       = $this->data;
    //     $title                      = 'Manage ' . $this->data['title'] . ' : Advance Search';
    //     $page_name                  = 'report/advance-search';
    //     $order_by[0]                = array('field' => 'status', 'type' => 'DESC');
    //     $order_by[1]                = array('field' => 'name', 'type' => 'ASC');
    //     $data['users']              = $this->data['model']->find_data('user', 'array', ['status!=' => '3'], 'id,name,status', '', '', $order_by);

    //     // $data['projectwise_users']  = $this->data['model']->find_data('user', 'array', ['status!=' => '3'], 'id,name,status', '', '', $order_by); 

    //     // $order_by[0]                = array('field' => 'project.status', 'type' => 'ASC');
    //     $order_by[0]                = array('field' => 'project.name', 'type' => 'ASC');
    //     $join[0]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
    //     $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
    //     $user_type                  = $this->session->get('user_type');
    //     $user_id                    = $this->session->get('user_id');

    //     if ($user_type == 'CLIENT') {
    //         $data['projects']           = $this->data['model']->find_data('project', 'array', ['project.status!=' => 13, 'project.client_id' => $user_id], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
    //         $data['closed_projects']    = $this->data['model']->find_data('project', 'array', ['project.status' => 13, 'project.client_id' => $user_id], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
    //         dd($data['projects']); die;
    //         $project_id = $data['projects'][0]->id;
    //         $sql = "SELECT DISTINCT user.status, user.name, user.id FROM `timesheet` INNER JOIN user on timesheet.user_id = user.id WHERE timesheet.project_id = $project_id and user.status = '1';";
    //         $rows = $this->db->query($sql)->getResult();
    //         $data['projectwise_user'] = $rows;
    //         // pr($data['projectwise_user']);
    //     } else {
    //         $data['projects']           = $this->data['model']->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
    //         $data['closed_projects']    = $this->data['model']->find_data('project', 'array', ['project.status' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);
    //     }


    //     $data['response']           = [];
    //     $data['search_user_id']     = 'all';
    //     $data['search_project_id']  = '';
    //     $data['search_day_id']      = 'all';
    //     $data['is_date_range']      = 0;
    //     $data['search_range_from']  = '';
    //     $data['search_range_to']    = '';
    //     $data['graph_users']        = '';
    //     $data['graph_user_data']    = '';
    //     if ($this->request->getGet('mode') == 'advance_search') {
    //         // pr($this->request->getGet());
    //         $search_user_id     = $this->request->getGet('search_user_id');
    //         $search_project_id  = $this->request->getGet('search_project_id');
    //         $search_day_id      = $this->request->getGet('search_day_id');
    //         $search_range_from  = $this->request->getGet('search_range_from');
    //         $search_range_to    = $this->request->getGet('search_range_to');
    //         if (array_key_exists('is_date_range', $this->request->getGet())) {
    //             $dayQuery = "date_added >= '$search_range_from' and date_added <= '$search_range_to'";
    //             $dayQuery4 = "t.date_added >= '$search_range_from' and t.date_added <= '$search_range_to'";
    //             if ($search_user_id == 'all' && $search_project_id == 'all') {
    //                 $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " order by id desc";
    //                 $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " group by user_id";
    //                 $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " group by effort_type";
    //                 $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " group by t.project_id order by p.name asc";
    //             } elseif ($search_user_id != 'all' && $search_project_id == 'all') {
    //                 $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and user_id = '$search_user_id' order by id desc";
    //                 $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by user_id";
    //                 $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by effort_type";
    //                 $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
    //             } elseif ($search_user_id == 'all' && $search_project_id != 'all') {
    //                 $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and project_id = '$search_project_id' order by id desc";
    //                 $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by user_id";
    //                 $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by effort_type";
    //                 $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' group by t.project_id order by p.name asc";
    //             } elseif ($search_user_id != 'all' && $search_project_id != 'all') {
    //                 $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' order by id desc";
    //                 $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by user_id";
    //                 $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by effort_type";
    //                 $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
    //             }
    //             $data['is_date_range']      = 1;
    //         } else {
    //             $today          = date('Y-m-d');
    //             $yesterday      = date('Y-m-d', strtotime("-1 days"));
    //             $lastMonday     = date('Y-m-d', strtotime('last Monday'));
    //             $lastWeekmonday = date('Y-m-d', strtotime('monday last week'));
    //             $lastWeeksunday = date('Y-m-d', strtotime('sunday last week'));
    //             $currentMonthFirstDay = date('Y-m') . "-01";
    //             $firstDayLastMonth = date("Y-m-d", mktime(0, 0, 0, date("m") - 1, 1));
    //             $lastDayLastMonth = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
    //             $last7Day = date('Y-m-d', strtotime('-7 days'));
    //             $last30Day = date('Y-m-d', strtotime('-30 days'));
    //             $data['is_date_range']      = 0;
    //             if ($search_day_id == 'all') {
    //                 $dayQuery = "date_added >= '2018-05-01'";
    //                 $dayQuery4 = "t.date_added >= '2018-05-01'";
    //             } elseif ($search_day_id == 'today') {
    //                 $dayQuery = "date_added = '$today'";
    //                 $dayQuery4 = "t.date_added = '$today'";
    //             } elseif ($search_day_id == 'yesterday') {
    //                 $dayQuery = "date_added = '$yesterday'";
    //                 $dayQuery4 = "t.date_added = '$yesterday'";
    //             } elseif ($search_day_id == 'this_week') {
    //                 $dayQuery = "date_added >= '$lastMonday' and date_added <= '$today'";
    //                 $dayQuery4 = "t.date_added >= '$lastMonday' and t.date_added <= '$today'";
    //             } elseif ($search_day_id == 'last_week') {
    //                 $dayQuery = "date_added >= '$lastWeekmonday' and date_added <= '$lastWeeksunday'";
    //                 $dayQuery4 = "t.date_added >= '$lastWeekmonday' and t.date_added <= '$lastWeeksunday'";
    //             } elseif ($search_day_id == 'this_month') {
    //                 $dayQuery = "date_added >= '$currentMonthFirstDay' and date_added <= '$today'";
    //                 $dayQuery4 = "t.date_added >= '$currentMonthFirstDay' and t.date_added <= '$today'";
    //             } elseif ($search_day_id == 'last_month') {
    //                 $dayQuery = "date_added >= '$firstDayLastMonth' and date_added <= '$lastDayLastMonth'";
    //                 $dayQuery4 = "t.date_added >= '$firstDayLastMonth' and t.date_added <= '$lastDayLastMonth'";
    //             } elseif ($search_day_id == 'last_7_days') {
    //                 $dayQuery = "date_added >= '$last7Day' and date_added <= '$yesterday'";
    //                 $dayQuery4 = "t.date_added >= '$last7Day' and t.date_added <= '$yesterday'";
    //             } elseif ($search_day_id == 'last_30_days') {
    //                 $dayQuery = "date_added >= '$last30Day' and date_added <= '$yesterday'";
    //                 $dayQuery4 = "t.date_added >= '$last30Day' and t.date_added <= '$yesterday'";
    //             }

    //             if ($search_user_id == 'all' && $search_project_id == 'all') {
    //                 $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " order by id desc";
    //                 $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " group by user_id";
    //                 $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " group by effort_type";
    //                 $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " group by t.project_id order by p.name asc";
    //             } elseif ($search_user_id != 'all' && $search_project_id == 'all') {
    //                 $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and user_id = '$search_user_id' order by id desc";
    //                 $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by user_id";
    //                 $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and user_id = '$search_user_id' group by effort_type";
    //                 $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
    //             } elseif ($search_user_id == 'all' && $search_project_id != 'all') {
    //                 $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and project_id = '$search_project_id' order by id desc";
    //                 $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by user_id";
    //                 $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' group by effort_type";
    //                 $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' group by t.project_id order by p.name asc";
    //             } elseif ($search_user_id != 'all' && $search_project_id != 'all') {
    //                 $sql = "select id,project_id,status_id,user_id,description,hour,min,effort_type,date_today,date_added from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' order by id desc";
    //                 $sql2 = "select user_id,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by user_id";
    //                 $sql3 = "select effort_type,sum(hour) as tot_hour,sum(min) as tot_min from timesheet where " . $dayQuery . " and project_id = '$search_project_id' and user_id = '$search_user_id' group by effort_type";
    //                 $sql4 = "select t.project_id,sum(t.hour) as tot_hour,sum(t.min) as tot_min from timesheet as t inner join project as p on p.id = t.project_id where " . $dayQuery4 . " and t.project_id = '$search_project_id' and t.user_id = '$search_user_id' group by t.project_id order by p.name asc";
    //             }
    //         }
    //         // echo $sql;die;
    //         $rows = $this->db->query($sql)->getResult();
    //         $response = [];
    //         $total_effort_in_mins = 0;
    //         if ($rows) {
    //             $sl = 1;
    //             foreach ($rows as $row) {
    //                 $getProject = $this->common_model->find_data('project', 'row', ['id' => $row->project_id], 'name');
    //                 $getUser = $this->common_model->find_data('user', 'row', ['id' => $row->user_id], 'name');
    //                 $getProjectStatus = $this->common_model->find_data('project_status', 'row', ['id' => $row->status_id], 'name');
    //                 $getEffortType = $this->common_model->find_data('effort_type', 'row', ['id' => $row->effort_type], 'name');
    //                 $effort_time = $row->hour . ':' . $row->min;
    //                 $response[] = [
    //                     'sl_no'             => $sl++,
    //                     'id'                => $row->id,
    //                     'project_name'      => (($getProject) ? $getProject->name : ''),
    //                     'user_name'         => (($getUser) ? $getUser->name : ''),
    //                     'work_date'         => date_format(date_create($row->date_added), "d-m-Y"),
    //                     'date_today'        => date_format(date_create($row->date_today), "d-m-Y"),
    //                     'description'       => $row->description,
    //                     'effort_time'       => $effort_time,
    //                     'hour'              => $row->hour,
    //                     'min'               => $row->min,
    //                     'project_status'    => (($getProjectStatus) ? $getProjectStatus->name : ''),
    //                     'effort_type'       => (($getEffortType) ? $getEffortType->name : ''),
    //                 ];
    //                 $total_hour_min = ($row->hour * 60); // 0*60 = 0
    //                 $total_min_min = $row->min; // 30
    //                 $total_effort_in_mins += ($total_hour_min + $total_min_min);
    //             }
    //         }
    //         $data['response']               = $response;
    //         $data['total_effort_in_mins']   = $total_effort_in_mins;
    //         $data['search_user_id']         = $search_user_id;
    //         $data['search_project_id']      = $search_project_id;
    //         $data['search_day_id']          = $search_day_id;
    //         $data['search_range_from']      = $search_range_from;
    //         $data['search_range_to']        = $search_range_to;

    //         /* user graph */
    //         $getUserGraphs = $this->db->query($sql2)->getResult();
    //         $graphUsers     = [];
    //         $graphUserData  = [];
    //         if ($getUserGraphs) {
    //             foreach ($getUserGraphs as $getUserGraph) {
    //                 $getUser = $this->common_model->find_data('user', 'row', ['id' => $getUserGraph->user_id], 'name');
    //                 $tot_hour               = $getUserGraph->tot_hour * 60;
    //                 $tot_min                = $getUserGraph->tot_min;
    //                 $totMins                = $tot_hour + $tot_min;
    //                 $totalBooked            = intdiv($totMins, 60) . '.' . ($totMins % 60);
    //                 $graphUserData[]        = "'" . $totalBooked . "'";
    //                 $graphUsers[]           = (($getUser) ? "'" . $getUser->name . " [" . $totalBooked . "]'" : '');
    //             }
    //         }
    //         // pr($graphUsers,0);
    //         // pr($graphUserData);
    //         $data['graph_users']            = $graphUsers;
    //         $data['graph_user_data']        = $graphUserData;
    //         /* user graph */
    //         /* type graph */
    //         $getTypeGraphs = $this->db->query($sql3)->getResult();
    //         $graphTypes     = [];
    //         $graphTypeData  = [];
    //         if ($getTypeGraphs) {
    //             foreach ($getTypeGraphs as $getTypeGraph) {
    //                 $getEffortType          = $this->common_model->find_data('effort_type', 'row', ['id' => $getTypeGraph->effort_type], 'name');

    //                 $tot_hour               = $getTypeGraph->tot_hour * 60;
    //                 $tot_min                = $getTypeGraph->tot_min;
    //                 $totMins                = $tot_hour + $tot_min;
    //                 $totalBooked            = intdiv($totMins, 60) . '.' . ($totMins % 60);
    //                 $graphTypeData[]        = "'" . $totalBooked . "'";
    //                 $graphTypes[]           = (($getEffortType) ? "'" . $getEffortType->name . " [" . $totalBooked . "]'" : '');
    //             }
    //         }
    //         // pr($graphTypes,0);
    //         // pr($graphTypeData);
    //         $data['graph_types']            = $graphTypes;
    //         $data['graph_type_data']        = $graphTypeData;
    //         /* type graph */
    //         /* project graph */
    //         $getProjectGraphs = $this->db->query($sql4)->getResult();
    //         $graphProjects     = [];
    //         $graphProjectData  = [];
    //         if ($getProjectGraphs) {
    //             foreach ($getProjectGraphs as $getProjectGraph) {
    //                 $getProject          = $this->common_model->find_data('project', 'row', ['id' => $getProjectGraph->project_id], 'name');

    //                 $tot_hour               = $getProjectGraph->tot_hour * 60;
    //                 $tot_min                = $getProjectGraph->tot_min;
    //                 $totMins                = $tot_hour + $tot_min;
    //                 $totalBooked            = intdiv($totMins, 60) . '.' . ($totMins % 60);
    //                 $graphProjectData[]     = "'" . $totalBooked . "'";
    //                 $graphProjects[]        = (($getProject) ? "'" . $getProject->name . " [" . $totalBooked . "]'" : '');
    //             }
    //         }
    //         // pr($graphProjects,0);
    //         // pr($graphProjectData);
    //         $data['graph_projects_bar_height']            = ((count($graphProjects) > 1) ? (count($graphProjects) * 30) : 100);
    //         $data['graph_projects']            = $graphProjects;
    //         $data['graph_project_data']        = $graphProjectData;
    //         /* project graph */
    //     }
    //     echo $this->layout_after_login($title, $page_name, $data);
    // }

    public function effortType()
    {
        if (!$this->common_model->checkModuleFunctionAccess(23, 41)) {
                $data['action']             = 'Access Forbidden';
                $title                      = $data['action'] . ' ' . $this->data['title'];
                $page_name                  = 'access-forbidden';
                echo $this->layout_after_login($title, $page_name, $data);
                exit;
            }
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'] . ' : Effort Report';
        $page_name                  = 'report/effort-report';
        $data['userType']           = $this->session->user_type;
        //  pr($data['userType']);
        $userType                   = $data['userType'];
        $userId                             = $this->session->user_id;
        $order_by[0]        = array('field' => 'status', 'type' => 'DESC');
        $order_by[1]        = array('field' => 'name', 'type' => 'ASC');
        if($data['userType'] == 'SUPER ADMIN' || $data['userType'] == "ADMIN" ){
            $users              = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'is_tracker_user' => 1], 'id,name,status', '', '', $order_by);
        }else{
            $users              = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'is_tracker_user' => 1,'id='=>$userId], 'id,name,status', '', '', $order_by);
        }
        // pr($users);
        $deskloguser        = $this->common_model->find_data('application_settings', 'row', '', 'is_desklog_use', '', '');
        //  pr($deskloguser);
        $desklog_user       = $deskloguser->is_desklog_use;
        $response = [];
        $year = [];
        $sl = 1;
        if ($users) {
            foreach ($users as $row) {
                if ($this->request->getGet('mode') == 'year') {
                    //  pr($this->request->getGet('year'));                    
                    $year = $this->request->getGet('year');
                } else {
                    $year = date('Y');
                }
                $monthYear1 = $year . '-' . date('01');
                $yearString = $year;
                $jan_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear1%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 1 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result1 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    // $result1 = floor($getDesktimeHour->total_desktime_hour);
                    $result1 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result1 = '';
                }
                if ($jan_booked) {
                    $tothour = $jan_booked->tothour * 60;
                    $totmin = $jan_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked1            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear2 = $year . '-' . date('02');
                $yearString = $year;
                $feb_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear2%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 2 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result2 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result2 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result2 = '';
                }
                if ($feb_booked) {
                    $tothour = $feb_booked->tothour * 60;
                    $totmin = $feb_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked2            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear3 = $year . '-' . date('03');
                $yearString = $year;
                $mar_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id=$row->id and date_added LIKE '%$monthYear3%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 3 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result3 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result3 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result3 = '';
                }
                if ($mar_booked) {
                    $tothour3 = $mar_booked->tothour * 60;
                    $totmin3 = $mar_booked->totmin;
                    $totalMin3 = ($tothour3 + $totmin3);
                    $totalBooked3            = intdiv($totalMin3, 60) . '.' . ($totalMin3 % 60);
                }
                $monthYear4 = $year . '-' . date('04');
                $yearString = $year;
                $apr_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear4%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 4 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result4 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result4 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result4 = '';
                }
                if ($apr_booked) {
                    $tothour = $apr_booked->tothour * 60;
                    $totmin = $apr_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked4            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear5 = $year . '-' . date('05');
                $yearString = $year;
                $may_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear5%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 5 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result5 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result5 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result5 = '';
                }
                if ($may_booked) {
                    $tothour = $may_booked->tothour * 60;
                    $totmin = $may_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked5            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear6 = $year . '-' . date('06');
                $yearString = $year;
                $jun_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear6%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 6 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result6 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result6 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result6 = '';
                }
                if ($jun_booked) {
                    $tothour = $jun_booked->tothour * 60;
                    $totmin = $jun_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked6            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear7 = $year . '-' . date('07');
                $yearString = $year;
                $jul_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear7%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 7 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result7 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result7 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result7 = '';
                }
                if ($jul_booked) {
                    $tothour = $jul_booked->tothour * 60;
                    $totmin = $jul_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked7            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear8 = $year . '-' . date('08');
                $yearString = $year;
                $aug_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear8%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 8 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result8 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result8 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result8 = '';
                }
                if ($aug_booked) {
                    $tothour = $aug_booked->tothour * 60;
                    $totmin = $aug_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked8            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear9 = $year . '-' . date('09');
                $yearString = $year;
                $sep_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear9%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 9 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result9 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result9 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result9 = '';
                }
                if ($sep_booked) {
                    $tothour = $sep_booked->tothour * 60;
                    $totmin = $sep_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked9            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear10 = $year . '-' . date('10');
                $yearString = $year;
                $oct_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear10%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 10 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result10 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result10 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result10 = '';
                }
                if ($oct_booked) {
                    $tothour = $oct_booked->tothour * 60;
                    $totmin = $oct_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked10            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear11 = $year . '-' . date('11');
                $yearString = $year;
                $nov_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear11%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 11 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result11 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result11 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result11 = '';
                }
                if ($nov_booked) {
                    $tothour = $nov_booked->tothour * 60;
                    $totmin = $nov_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked11            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }
                $monthYear12 = $year . '-' . date('12');
                $yearString = $year;
                $dec_booked = $this->db->query("SELECT sum(hour) as tothour, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '%$monthYear12%'")->getRow();
                $getDesktimeHour = $this->db->query("SELECT * FROM `desktime_sheet_tracking`  WHERE year_upload = '$yearString' AND month_upload = 12 AND user_id = '$row->id'")->getRow();
                if ($getDesktimeHour) {
                    // $result12 = substr($getDesktimeHour->total_desktime_hour, 0, -3);
                    $result12 = (int)$getDesktimeHour->total_desktime_hour;
                } else {
                    $result12 = '';
                }
                if ($dec_booked) {
                    $tothour = $dec_booked->tothour * 60;
                    $totmin = $dec_booked->totmin;
                    $totalMin = ($tothour + $totmin);
                    $totalBooked12            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                }

                $data['year']        = $yearString;
                $response[] = [
                    'sl_no'         => $sl++,
                    'userId'        => $row->id,
                    'name'          => $row->name,
                    'jan_booked'    => $totalBooked1,
                    'feb_booked'    => $totalBooked2,
                    'mar_booked'    => $totalBooked3,
                    'apr_booked'    => $totalBooked4,
                    'may_booked'    => $totalBooked5,
                    'jun_booked'    => $totalBooked6,
                    'jul_booked'    => $totalBooked7,
                    'aug_booked'    => $totalBooked8,
                    'sep_booked'    => $totalBooked9,
                    'oct_booked'    => $totalBooked10,
                    'nov_booked'    => $totalBooked11,
                    'dec_booked'    => $totalBooked12,
                    'jan_desklog'   => $result1,
                    'feb_desklog'   => $result2,
                    'mar_desklog'   => $result3,
                    'apr_desklog'   => $result4,
                    'may_desklog'   => $result5,
                    'jun_desklog'   => $result6,
                    'jul_desklog'   => $result7,
                    'aug_desklog'   => $result8,
                    'sep_desklog'   => $result9,
                    'oct_desklog'   => $result10,
                    'nov_desklog'   => $result11,
                    'dec_desklog'   => $result12,
                    'deskloguser'   => $desklog_user,
                ];
            }
        }
        $data['responses']                   = $response;

        $last7DaysResponses = [];
        $arr                = [];
        $users_data              = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'is_tracker_user' => 1], 'id,name,status', '', '', $order_by);
        $arr = $this->getLastNDays(7, 'Y-m-d');
        //print_r($arr);die;
        if ($user = ($userType == 'admin') ? $users_data : $users) {
            foreach ($user as $row) {
                if (!empty($arr)) {
                    $reports = [];
                    for ($k = 0; $k < count($arr); $k++) {
                        $loopDate           = $arr[$k];
                        $dayWiseBooked      = $this->db->query("SELECT sum(hour) as tothour, date_today, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '$loopDate'")->getRow();
                        $tothour                = $dayWiseBooked->tothour * 60;
                        $totmin                 = $dayWiseBooked->totmin;
                        $totalMin               = ($tothour + $totmin);
                        $booked_effort          = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                        $workdate = date_create($loopDate);
                        $entrydate = date_create($dayWiseBooked->date_today);
                        $reports[] = [
                            'booked_date'   => date_format(date_create($loopDate), "d-m-Y"),
                            'booked_effort' => $booked_effort,
                            'booked_today' => date_format(date_create($dayWiseBooked->date_today), "d-m-Y")
                        ];
                    }
                }
                $last7DaysResponses[] = [
                    'name'      => $row->name,
                    'reports'   => $reports,
                ];
            }
        }
        $data['arr']                        = $arr;
        $data['last7DaysResponses']         = $last7DaysResponses;
        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function projectReport()
    {
        if (!$this->common_model->checkModuleFunctionAccess(25, 44)) {
                $data['action']             = 'Access Forbidden';
                $title                      = $data['action'] . ' ' . $this->data['title'];
                $page_name                  = 'access-forbidden';
                echo $this->layout_after_login($title, $page_name, $data);
                exit;
            }
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'] . ' : Project Report';
        $page_name                  = 'report/project-report';
        $data['userType']           = $this->session->user_type;
        $userType                   = $data['userType'];
        $userId                     = $this->session->user_id;
        $order_by[0]                = array('field' => 'status', 'type' => 'DESC');
        $order_by[1]                = array('field' => 'name', 'type' => 'ASC');
        $users                      = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'is_tracker_user' => 1], 'id,name,status', '', '', $order_by);
        $projects                    = $this->db->query("SELECT timesheet.project_id, timesheet.date_added, project.name FROM `timesheet` LEFT JOIN project ON timesheet.project_id = project.id WHERE timesheet.date_added LIKE '%2024%' GROUP BY timesheet.project_id, project.name ORDER BY `project`.`name` ASC")->getResult();
        $response                   = [];
        $year                       = [];
        $sl                         = 1;
        // pr($projects);       
        foreach ($projects as $project) {
            $project_name = $project->name;
            $project_id = $project->project_id;
            if ($this->request->getGet('mode') == 'year') {
                //  pr($this->request->getGet('year'));                    
                $year = $this->request->getGet('year');
            } else {
                $year = date('Y');
            }
            $monthYear1 = $year . '-' . date('01');
            $yearString = $year;
            $jan_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and  timesheet.date_added LIKE '%$monthYear1%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            //  echo $this->db->getLastquery();die;
            if ($jan_booked) {
                // pr($jan_booked);
                $tothour = $jan_booked->tothour * 60;
                $totmin = $jan_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked1            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked1 = '';
            }
            $monthYear2 = $year . '-' . date('02');
            $yearString = $year;
            $feb_booked = $this->db->query("SELECT timesheet.project_id,
                timesheet.date_added,
                project.name,
                timesheet.bill,
                SUM(timesheet.hour) AS tothour,
                SUM(timesheet.min) AS totmin
                FROM
                    `timesheet`
                LEFT JOIN project ON timesheet.project_id = project.id
                WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear2%' GROUP BY
                    timesheet.project_id, project.name
                ORDER BY
                `project`.`name` ASC;")->getRow();
            if ($feb_booked) {
                $tothour = $feb_booked->tothour * 60;
                $totmin = $feb_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked2            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked2 = '';
            }
            $monthYear3 = $year . '-' . date('03');
            $yearString = $year;
            $mar_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear3%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($mar_booked) {
                $tothour3 = $mar_booked->tothour * 60;
                $totmin3 = $mar_booked->totmin;
                $totalMin3 = ($tothour3 + $totmin3);
                $totalBooked3            = intdiv($totalMin3, 60) . '.' . ($totalMin3 % 60);
            } else {
                $totalBooked3 = '';
            }
            $monthYear4 = $year . '-' . date('04');
            $yearString = $year;
            $apr_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear4%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($apr_booked) {
                $tothour = $apr_booked->tothour * 60;
                $totmin = $apr_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked4            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked4 = '';
            }
            $monthYear5 = $year . '-' . date('05');
            $yearString = $year;
            $may_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear5%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($may_booked) {
                $tothour = $may_booked->tothour * 60;
                $totmin = $may_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked5            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked5 = '';
            }
            $monthYear6 = $year . '-' . date('06');
            $yearString = $year;
            $jun_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear6%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($jun_booked) {
                $tothour = $jun_booked->tothour * 60;
                $totmin = $jun_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked6            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked6 = '';
            }
            $monthYear7 = $year . '-' . date('07');
            $yearString = $year;
            $jul_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear7%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($jul_booked) {
                $tothour = $jul_booked->tothour * 60;
                $totmin = $jul_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked7            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked7 = '';
            }
            $monthYear8 = $year . '-' . date('08');
            $yearString = $year;
            $aug_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear8%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($aug_booked) {
                $tothour = $aug_booked->tothour * 60;
                $totmin = $aug_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked8            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked8 = '';
            }
            $monthYear9 = $year . '-' . date('09');
            $yearString = $year;
            $sep_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear9%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($sep_booked) {
                $tothour = $sep_booked->tothour * 60;
                $totmin = $sep_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked9            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked9 = '';
            }
            $monthYear10 = $year . '-' . date('10');
            $yearString = $year;
            $oct_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear10%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($oct_booked) {
                $tothour = $oct_booked->tothour * 60;
                $totmin = $oct_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked10            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked10 = '';
            }
            $monthYear11 = $year . '-' . date('11');
            $yearString = $year;
            $nov_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear11%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($nov_booked) {
                $tothour = $nov_booked->tothour * 60;
                $totmin = $nov_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked11            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked11 = '';
            }
            $monthYear12 = $year . '-' . date('12');
            $yearString = $year;
            $dec_booked = $this->db->query("SELECT timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            timesheet.bill,
                            SUM(timesheet.hour) AS tothour,
                            SUM(timesheet.min) AS totmin
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE timesheet.project_id = $project_id and timesheet.date_added LIKE '%$monthYear12%' GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC;")->getRow();
            if ($dec_booked) {
                // pr($dec_booked); die;
                $tothour = $dec_booked->tothour * 60;
                $totmin = $dec_booked->totmin;
                $totalMin = ($tothour + $totmin);
                $totalBooked12            = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
            } else {
                $totalBooked12 = '';
            }

            $data['year']        = $yearString;
            $response[] = [
                'sl_no'         => $sl++,
                'project_name'  => $project_name,
                'jan_booked'    => $totalBooked1,
                'feb_booked'    => $totalBooked2,
                'mar_booked'    => $totalBooked3,
                'apr_booked'    => $totalBooked4,
                'may_booked'    => $totalBooked5,
                'jun_booked'    => $totalBooked6,
                'jul_booked'    => $totalBooked7,
                'aug_booked'    => $totalBooked8,
                'sep_booked'    => $totalBooked9,
                'oct_booked'    => $totalBooked10,
                'nov_booked'    => $totalBooked11,
                'dec_booked'    => $totalBooked12,
            ];
        }

        $data['responses']                   = $response;
        // pr($data['responses']);

        $last7DaysResponses = [];
        $arr                = [];
        $users_data              = $this->common_model->find_data('user', 'array', ['status!=' => '3', 'is_tracker_user' => 1], 'id,name,status', '', '', $order_by);
        $arr = $this->getLastNDays(7, 'Y-m-d');
        //print_r($arr);die;
        if ($user = ($userType == 'admin') ? $users_data : $users) {
            foreach ($user as $row) {
                if (!empty($arr)) {
                    $reports = [];
                    for ($k = 0; $k < count($arr); $k++) {
                        $loopDate           = $arr[$k];
                        $dayWiseBooked      = $this->db->query("SELECT sum(hour) as tothour, date_today, sum(min) as totmin FROM `timesheet` where user_id='$row->id' and date_added LIKE '$loopDate'")->getRow();
                        $tothour                = $dayWiseBooked->tothour * 60;
                        $totmin                 = $dayWiseBooked->totmin;
                        $totalMin               = ($tothour + $totmin);
                        $booked_effort          = intdiv($totalMin, 60) . '.' . ($totalMin % 60);
                        $workdate = date_create($loopDate);
                        $entrydate = date_create($dayWiseBooked->date_today);
                        $reports[] = [
                            'booked_date'   => date_format(date_create($loopDate), "d-m-Y"),
                            'booked_effort' => $booked_effort,
                            'booked_today' => date_format(date_create($dayWiseBooked->date_today), "d-m-Y")
                        ];
                    }
                }
                $last7DaysResponses[] = [
                    'name'      => $row->name,
                    'reports'   => $reports,
                ];
            }
        }
        $data['arr']                        = $arr;
        $data['last7DaysResponses']         = $last7DaysResponses;
        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function viewMonthlyProjectReport($id, $year, $range)
    {
        $title            = 'Monthly Report';
        $page_name        = 'report/viewMonthlyProjectReport';
        $id               = base64_decode($id);
        $year             = base64_decode($year);
        $range            = base64_decode($range);
        switch ($range) {
            case '1':
                $condition = "`date_added` BETWEEN '{$year}-01-01' AND '{$year}-01-31' ORDER BY `id` DESC";
                $month     = "January";
                break;
            case '2':
                $condition = "`date_added` BETWEEN '{$year}-02-01' AND '{$year}-02-29' ORDER BY `id` DESC";
                $month     = "February";
                break;
            case '3':
                $condition = "`date_added` BETWEEN '{$year}-03-01' AND '{$year}-03-31' ORDER BY `id` DESC";
                $month     = "March";
                break;
            case '4':
                $condition = "`date_added` BETWEEN '{$year}-04-01' AND '{$year}-04-30' ORDER BY `id` DESC";
                $month     = "April";
                break;
            case '5':
                $condition = "`date_added` BETWEEN '{$year}-05-01' AND '{$year}-05-31' ORDER BY `id` DESC";
                $month     = "May";
                break;
            case '6':
                $condition = "`date_added` BETWEEN '{$year}-06-01' AND '{$year}-06-30' ORDER BY `id` DESC";
                $month     = "June";
                break;
            case '7':
                $condition = "`date_added` BETWEEN '{$year}-07-01' AND '{$year}-07-31' ORDER BY `id` DESC";
                $month     = "July";
                break;
            case '8':
                $condition = "`date_added` BETWEEN '{$year}-08-01' AND '{$year}-08-31' ORDER BY `id` DESC";
                $month     = "August";
                break;
            case '9':
                $condition = "`date_added` BETWEEN '{$year}-09-01' AND '{$year}-09-30' ORDER BY `id` DESC";
                $month     = "September";
                break;
            case '10':
                $condition = "`date_added` BETWEEN '{$year}-10-01' AND '{$year}-10-31' ORDER BY `id` DESC";
                $month     = "October";
                break;
            case '11':
                $condition = "`date_added` BETWEEN '{$year}-11-01' AND '{$year}-11-31' ORDER BY `id` DESC";
                $month     = "November";
                break;
            case '12':
                $condition = "`date_added` BETWEEN '{$year}-12-01' AND '{$year}-12-31' ORDER BY `id` DESC";
                $month     = "December";
                break;
            default:
                # code...
                break;
        }
        $sql                = "SELECT *  FROM `timesheet` WHERE `user_id` = " . $id . " AND " . $condition . "";
        $data['rows']       = $this->db->query($sql)->getResult();
        $data['userName']   = $this->common_model->find_data('user', 'row', ['id' => $id]);
        $data['year']       = $year;
        $data['month']      = $month;
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
    public function hoursReport()
    {
        if (!$this->common_model->checkModuleFunctionAccess(24, 43)) {
                $data['action']             = 'Access Forbidden';
                $title                      = $data['action'] . ' ' . $this->data['title'];
                $page_name                  = 'access-forbidden';
                echo $this->layout_after_login($title, $page_name, $data);
                exit;
            }
        $title     = 'Manage ' . $this->data['title'];
        $page_name = 'report/hours-report';
        $data      = [];
        // pr($this->request->getPost());
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        // echo $yesterday;die;
        $sql1      = "  SELECT
                            timesheet.project_id,
                            timesheet.date_added,
                            project.name,
                            project.project_time_type,
                            timesheet.bill,
                            SUM(timesheet.hour) AS total_hours,
                            SUM(timesheet.min) AS total_minutes
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        WHERE
                            timesheet.`date_added` = '$yesterday'
                        GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            `project`.`name` ASC ";
        // echo $sql1;die;
        $data['ongoingProjects']       = $this->db->query($sql1)->getResult();
        // pr($data['ongoingProjects']);

        $sql2      = "  SELECT
                            timesheet.project_id,
                            SUM(HOUR) hour,
                            SUM(MIN) min,
                            timesheet.bill
                        FROM
                            timesheet
                        WHERE
                            date_added = '$yesterday'
                        GROUP BY
                            timesheet.project_id
                        ORDER BY
                            timesheet.date_added
                        DESC";
        // echo $sql2;die;
        $res_yesterday_proj       = $this->db->query($sql2)->getResult();

        $i4               = 1;
        $ystrdhr          = 0;
        $ystrdmin         = 0;
        $ystrdbill_hr     = 0;
        $ystrdbill_min    = 0;
        $ystrdnonbill_hr  = 0;
        $ystrdnonbill_min = 0;

        foreach ($res_yesterday_proj as $row_yesterday_proj) {
            if ($row_yesterday_proj->bill != '1') {
                $ystrdbill_hr   = $ystrdbill_hr + $row_yesterday_proj->hour;
                $ystrdbill_min  = $ystrdbill_min + $row_yesterday_proj->min;
            } else {
                $ystrdnonbill_hr    = $ystrdnonbill_hr + $row_yesterday_proj->hour;
                $ystrdnonbill_min   = $ystrdnonbill_min + $row_yesterday_proj->min;
            }
            $i4++;
        }

        if ($ystrdbill_min < 60) {
            $ystrdtotbill_hour      = $ystrdbill_hr;
            $ystrdtotbill_minute    = $ystrdbill_min;
        } else {
            $ystrdtotbill_hour_res1 = floor($ystrdbill_min / 60);
            $ystrdtotbill_minute    = $ystrdbill_min % 60;
            $ystrdtotbill_hour      = $ystrdbill_hr + $ystrdtotbill_hour_res1;
        }
        if ($ystrdnonbill_min < 60) {
            $ystrdtotnonbill_hour   = $ystrdnonbill_hr;
            $ystrdtotnonbill_minute = $ystrdnonbill_min;
        } else {
            $ystrdtotnonbill_hour_res1  = floor($ystrdnonbill_min / 60);
            $ystrdtotnonbill_minute     = $ystrdnonbill_min % 60;
            $ystrdtotnonbill_hour       = $ystrdnonbill_hr + $ystrdtotnonbill_hour_res1;
        }
        $data['yesterdayAllUserHourBill']   = number_format($ystrdtotbill_hour + ($ystrdtotbill_minute / 60), 2);
        $data['yesterdayAllUserMinBill']    = number_format($ystrdtotnonbill_hour + ($ystrdtotnonbill_minute / 60), 2);

        // echo $yesterdayAllUserMinBill;
        // die;

        // echo $ystrdnonbill_min;die;

        echo $this->layout_after_login($title, $page_name, $data);
    }
    public function dayWiseListUpdate()
    {
        $day               = $this->request->getGet('day');
        switch ($day) {
            case 'today':
                $today              = date('Y-m-d');
                $startDate          = $today;
                $endDate            = $today;
                $sql1               = "SELECT timesheet.project_id,timesheet.date_added, project.name,project.project_time_type, timesheet.bill, SUM(timesheet.hour) AS total_hours, SUM(timesheet.min) AS total_minutes FROM `timesheet` LEFT JOIN project ON timesheet.project_id = project.id WHERE timesheet.`date_added` = '$today' GROUP BY timesheet.project_id, project.name ORDER BY `project`.`name` ASC";
                $ongoingProjects    = $this->db->query($sql1)->getResult();

                $sql2               = "SELECT timesheet.project_id, SUM(HOUR) hour, SUM(MIN) min, timesheet.bill FROM timesheet WHERE date_added = '$today' GROUP BY timesheet.project_id ORDER BY timesheet.date_added DESC";
                $res_yesterday_proj = $this->db->query($sql2)->getResult();

                break;
            case 'yesterday':
                $yesterday          = date('Y-m-d', strtotime('-1 day'));
                $startDate          = $yesterday;
                $endDate            = $yesterday;
                $sql1               = "SELECT timesheet.project_id,timesheet.date_added, project.name,project.project_time_type, timesheet.bill, SUM(timesheet.hour) AS total_hours, SUM(timesheet.min) AS total_minutes FROM `timesheet` LEFT JOIN project ON timesheet.project_id = project.id WHERE timesheet.`date_added` = '$yesterday' GROUP BY timesheet.project_id, project.name ORDER BY `project`.`name` ASC";
                $ongoingProjects    = $this->db->query($sql1)->getResult();

                $sql2               = "SELECT timesheet.project_id, SUM(HOUR) hour, SUM(MIN) min, timesheet.bill FROM timesheet WHERE date_added = '$yesterday' GROUP BY timesheet.project_id ORDER BY timesheet.date_added DESC";
                $res_yesterday_proj = $this->db->query($sql2)->getResult();

                break;
            case 'this_week':
                $startDate  = date('Y-m-d', strtotime('monday this week'));
                $endDate    = date('Y-m-d', strtotime('sunday this week'));

                $sql1               = "SELECT timesheet.project_id,timesheet.date_added, project.name,project.project_time_type, timesheet.bill, SUM(timesheet.hour) AS total_hours, SUM(timesheet.min) AS total_minutes FROM `timesheet` LEFT JOIN project ON timesheet.project_id = project.id WHERE timesheet.`date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id, project.name ORDER BY `project`.`name` ASC";
                $ongoingProjects    = $this->db->query($sql1)->getResult();

                $sql2               = "SELECT timesheet.project_id, SUM(HOUR) hour, SUM(MIN) min, timesheet.bill FROM timesheet WHERE `date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id ORDER BY timesheet.date_added DESC";
                $res_yesterday_proj = $this->db->query($sql2)->getResult();

                break;
            case 'last_week':
                $startDate  = date('Y-m-d', strtotime('monday last week'));
                $endDate    = date('Y-m-d', strtotime('sunday last week'));

                $sql1               = "SELECT timesheet.project_id,timesheet.date_added, project.name,project.project_time_type, timesheet.bill, SUM(timesheet.hour) AS total_hours, SUM(timesheet.min) AS total_minutes FROM `timesheet` LEFT JOIN project ON timesheet.project_id = project.id WHERE timesheet.`date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id, project.name ORDER BY `project`.`name` ASC";
                $ongoingProjects    = $this->db->query($sql1)->getResult();

                $sql2               = "SELECT timesheet.project_id, SUM(HOUR) hour, SUM(MIN) min, timesheet.bill FROM timesheet WHERE `date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id ORDER BY timesheet.date_added DESC";
                $res_yesterday_proj = $this->db->query($sql2)->getResult();
                break;
            case 'this_month':
                $startDate  = date('Y-m-01');
                $endDate    = date('Y-m-t');

                $sql1               = "SELECT timesheet.project_id,timesheet.date_added, project.name,project.project_time_type, timesheet.bill, SUM(timesheet.hour) AS total_hours, SUM(timesheet.min) AS total_minutes FROM `timesheet` LEFT JOIN project ON timesheet.project_id = project.id WHERE timesheet.`date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id, project.name ORDER BY `project`.`name` ASC";
                $ongoingProjects    = $this->db->query($sql1)->getResult();

                $sql2               = "SELECT timesheet.project_id, SUM(HOUR) hour, SUM(MIN) min, timesheet.bill FROM timesheet WHERE `date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id ORDER BY timesheet.date_added DESC";
                $res_yesterday_proj = $this->db->query($sql2)->getResult();
                break;
            case 'last_month':
                $startDate  = date('Y-m-01', strtotime('first day of last month'));
                $endDate    = date('Y-m-t', strtotime('last day of last month'));

                $sql1               = "SELECT timesheet.project_id,timesheet.date_added, project.name,project.project_time_type, timesheet.bill, SUM(timesheet.hour) AS total_hours, SUM(timesheet.min) AS total_minutes FROM `timesheet` LEFT JOIN project ON timesheet.project_id = project.id WHERE timesheet.`date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id, project.name ORDER BY `project`.`name` ASC";
                $ongoingProjects    = $this->db->query($sql1)->getResult();

                $sql2               = "SELECT timesheet.project_id, SUM(HOUR) hour, SUM(MIN) min, timesheet.bill FROM timesheet WHERE `date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id ORDER BY timesheet.date_added DESC";
                $res_yesterday_proj = $this->db->query($sql2)->getResult();
                break;
            case 'last_7_days':
                $startDate  = date('Y-m-d', strtotime('-7 days'));
                $endDate    = date('Y-m-d');

                $sql1               = "SELECT timesheet.project_id,timesheet.date_added, project.name,project.project_time_type, timesheet.bill, SUM(timesheet.hour) AS total_hours, SUM(timesheet.min) AS total_minutes FROM `timesheet` LEFT JOIN project ON timesheet.project_id = project.id WHERE timesheet.`date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id, project.name ORDER BY `project`.`name` ASC";
                $ongoingProjects    = $this->db->query($sql1)->getResult();

                $sql2               = "SELECT timesheet.project_id, SUM(HOUR) hour, SUM(MIN) min, timesheet.bill FROM timesheet WHERE `date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id ORDER BY timesheet.date_added DESC";
                $res_yesterday_proj = $this->db->query($sql2)->getResult();
                break;
            case 'last_30_days':
                $startDate  = date('Y-m-d', strtotime('-30 days'));
                $endDate    = date('Y-m-d');

                $sql1               = "SELECT timesheet.project_id,timesheet.date_added, project.name,project.project_time_type, timesheet.bill, SUM(timesheet.hour) AS total_hours, SUM(timesheet.min) AS total_minutes FROM `timesheet` LEFT JOIN project ON timesheet.project_id = project.id WHERE timesheet.`date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id, project.name ORDER BY `project`.`name` ASC";
                $ongoingProjects    = $this->db->query($sql1)->getResult();

                $sql2               = "SELECT timesheet.project_id, SUM(HOUR) hour, SUM(MIN) min, timesheet.bill FROM timesheet WHERE `date_added` BETWEEN '$startDate' AND '$endDate' GROUP BY timesheet.project_id ORDER BY timesheet.date_added DESC";
                $res_yesterday_proj = $this->db->query($sql2)->getResult();
                break;
            default:
                # code...
                break;
        }
        $i4               = 1;
        $ystrdhr          = 0;
        $ystrdmin         = 0;
        $ystrdbill_hr     = 0;
        $ystrdbill_min    = 0;
        $ystrdnonbill_hr  = 0;
        $ystrdnonbill_min = 0;

        foreach ($res_yesterday_proj as $row_yesterday_proj) {
            if ($row_yesterday_proj->bill != '1') {
                $ystrdbill_hr   = $ystrdbill_hr + $row_yesterday_proj->hour;
                $ystrdbill_min  = $ystrdbill_min + $row_yesterday_proj->min;
            } else {
                $ystrdnonbill_hr    = $ystrdnonbill_hr + $row_yesterday_proj->hour;
                $ystrdnonbill_min   = $ystrdnonbill_min + $row_yesterday_proj->min;
            }
            $i4++;
        }
        if ($ystrdbill_min < 60) {
            $ystrdtotbill_hour      = $ystrdbill_hr;
            $ystrdtotbill_minute    = $ystrdbill_min;
        } else {
            $ystrdtotbill_hour_res1 = floor($ystrdbill_min / 60);
            $ystrdtotbill_minute    = $ystrdbill_min % 60;
            $ystrdtotbill_hour      = $ystrdbill_hr + $ystrdtotbill_hour_res1;
        }
        if ($ystrdnonbill_min < 60) {
            $ystrdtotnonbill_hour   = $ystrdnonbill_hr;
            $ystrdtotnonbill_minute = $ystrdnonbill_min;
        } else {
            $ystrdtotnonbill_hour_res1  = floor($ystrdnonbill_min / 60);
            $ystrdtotnonbill_minute     = $ystrdnonbill_min % 60;
            $ystrdtotnonbill_hour       = $ystrdnonbill_hr + $ystrdtotnonbill_hour_res1;
        }
        $billabkeHoursMin               = number_format($ystrdtotbill_hour + ($ystrdtotbill_minute / 60), 2);
        $nonBillableHoursMin            = number_format($ystrdtotnonbill_hour + ($ystrdtotnonbill_minute / 60), 2);

        // echo $startDate.'||'.$endDate;die;
        $start_date_array   = explode("-", $startDate);
        $end_date_array     = explode("-", $endDate);
        $last_month_year    = $start_date_array[0];
        $last_month_month   = $start_date_array[1];
        $fDate              = date_format(date_create($startDate), "M d, Y");
        $tDate              = date_format(date_create($endDate), "M d, Y");

        $html = '';
        $html = '<div class="" id="project-container">
                    <div class="row">
                        <div class="col md-6">
                            <div class="card-header card-header2">
                                <h6 class="heading_style text-center">
                                    ONGOING PROJECT
                                    <button type="button" class="btn btn-primary btn-sm" onclick="printDiv();"><i class="fa fa-print"></i></button>
                                </h6>
                            </div>
                            <div class="dt-responsive table-responsive" id="DivIdToPrint">
                                <table class="table padding-y-10 general_table_style" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3">From Date : <u>'.$fDate.'</u></th>
                                            <th colspan="3">To Date : <u>'.$tDate.'</u></th>
                                        </tr>
                                        <tr>
                                            <th width="3%">#</th>
                                            <th width="5%">Project</th>
                                            <th width="5%">Project Status</th>
                                            <th width="5%">Total Time</th>
                                            <th width="5%">Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        if ($ongoingProjects) { $sl = 1;$total_cost = 0;$billable_cost=0;$non_billable_cost=0; foreach ($ongoingProjects as $ongoingProject) {
                /* cost calculation */
                    // $cost_sql1      = "SELECT project_cost FROM `project_cost` WHERE month=$last_month_month AND year=$last_month_year AND project_id = $ongoingProject->project_id";
                    // $checkCost      = $this->db->query($cost_sql1)->getRow();
                    $project_cost   = 0;
                    // if($checkCost){
                    //     $project_cost   = $checkCost->project_cost;
                    // } else {
                    //     $date_added     = $last_month_year.'-'.$last_month_month;
                    //     $cost_sql2      = "SELECT sum(cost) as total_cost FROM `timesheet` WHERE project_id=$ongoingProject->project_id AND date_added LIKE '%$date_added%'";
                    //     $checkCost      = $this->db->query($cost_sql2)->getRow();
                    //     $project_cost   = $checkCost->total_cost;
                    // }
                    $date_added     = $last_month_year.'-'.$last_month_month;
                    $cost_sql2      = "SELECT sum(cost) as total_cost FROM `timesheet` WHERE project_id=$ongoingProject->project_id AND date_added >= '$startDate' AND date_added <= '$endDate'";
                    $checkCost      = $this->db->query($cost_sql2)->getRow();
                    $project_cost   = $checkCost->total_cost;
                    $total_cost += $project_cost;
                /* cost calculation */
                $html .= '<tr>
                            <th>' . $sl++ . '</th>';

                            if ($ongoingProject->bill == 0) {
                                if ($ongoingProject->project_time_type == 'Onetime') {
                                    $html .= '<th>' . $ongoingProject->name . 
                                            '<a target="_blank" href="' . base_url('admin/projects/reports/' . base64_encode($ongoingProject->project_id)) . 
                                            '"><i class="fa fa-file" style="margin-left: 5px;"></i></a>' . 
                                            '</th>';
                                } else {
                                    $html .= '<th>' . $ongoingProject->name . 
                                                '<a target="_blank" href="' . base_url('admin/projects/reports/' . base64_encode($ongoingProject->project_id)) . 
                                                '"><i class="fa fa-file" style="margin-left: 5px;"></i></a>' . 
                                                '</th>';
                                }
                                $billable_cost += $project_cost;
                            } else {
                                if ($ongoingProject->project_time_type == 'Onetime') {
                                    $html .= '<th>' . $ongoingProject->name . 
                                            '<a target="_blank" href="' . base_url('admin/projects/reports/' . base64_encode($ongoingProject->project_id)) . 
                                            '"><i class="fa fa-file" style="margin-left: 5px;"></i></a>' . 
                                            '</th>';
                                } else {
                                    $html .= '<th>' . $ongoingProject->name . 
                                            '<a target="_blank" href="' . base_url('admin/projects/reports/' . base64_encode($ongoingProject->project_id)) . 
                                            '"><i class="fa fa-file" style="margin-left: 5px;"></i></a>' . 
                                            '</th>';
                                }
                                $non_billable_cost += $project_cost;
                            }

                            $totalHours         = (int) $ongoingProject->total_hours;
                            $totalMinutes       = (int) $ongoingProject->total_minutes;
                            $additionalHours    = intdiv($totalMinutes, 60);
                            $remainingMinutes   = $totalMinutes % 60;
                            $totalHours        += $additionalHours;
                            $formattedTime      = sprintf("%d hours %d minutes", $totalHours, $remainingMinutes);

                            if ($ongoingProject->bill == 0) {
                                if ($ongoingProject->project_time_type == 'Onetime') {
                                    $html .= '<th>  <span class="badge bg-success mx-1">Billable</span><span class="badge bg-info">Fixed</span></th>';
                                } else {
                                    $html .= '<th>  <span class="badge bg-success mx-1">Billable</span><span class="badge bg-primary">Monthly</span></th>';
                                }
                                $billable_cost += $project_cost;
                            } else {
                                if ($ongoingProject->project_time_type == 'Onetime') {
                                    $html .= '<th> <span class="badge bg-danger mx-1">Non-Billable</span><span class="badge bg-info">Fixed</span></th>';
                                } else {
                                    $html .= '<th> <span class="badge bg-danger mx-1">Non-Billable</span><span class="badge bg-info">Monthly</span></th>';
                                }
                                $non_billable_cost += $project_cost;
                            }                


                $html .= '<th style="cursor: pointer;" onclick="showWorkList(' . $ongoingProject->project_id . ', \'' . $day . '\' , ' . ($ongoingProject->bill == 0 ? '0' : '1') . ' , \'' . $formattedTime . '\')">';

                $html .= $formattedTime;

                $html .=    '</th>
                            <th>'.number_format($project_cost,2).'</th>
                        </tr>';
            }
            $html .= '<tr>
                        <th colspan="3" style="text-align:right; font-weight:bold;">Total</th>
                        <th>'.number_format($total_cost,2).'</th>
                    </tr>';
        } else {
            $html .= '<tr>
                        <td colspan="5">No records found for the selected date.</td>
                     </tr>';
        }
        $html .= '</tbody>
                    </table>
                </div>
            </div>';

        $html .= '<div class="col md-6">
                    <div class="card-header card-header2">
                        <h6 class="heading_style text-center">NONBILLABLE HOURS</h6>
                    </div>
                    <div class="dt-responsive table-responsive">
                        <table class="table general_table_style padding-y-10" style="width: 100%">
                            <thead>
                                <tr>
                                    <th width="1%">#</th>
                                    <th width="5%">Billable Hour<br>Billable Cost</th>
                                    <th width="5%">Nonbillable Hour<br>Nonbillable Cost</th>
                                </tr>
                            </thead>
                            <tbody>     
                                <tr>
                                    <th>1</th>';
            $html .= '              <th>' . $billabkeHoursMin . '<br>'.number_format($billable_cost,2).'</th>
                                    <th>' . $nonBillableHoursMin . '<br>'.number_format($non_billable_cost,2).'</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>';
        return $html;
    }
    public function showWorkList()
    {
        $model          = new CommonModel();
        $projectId      = $this->request->getGet('projectId');
        $billable       = $this->request->getGet('billable');
        $hours          = $this->request->getGet('hours');
        $date           = $this->request->getGet('date');
        switch ($date) {
            case 'today':
                $today          = date('Y-m-d');
                $condition      = '`timesheet`.`date_added` = "' . $today . '"';
                break;
            case 'yesterday':
                $yesterday      = date('Y-m-d', strtotime('-1 day'));
                $condition      = '`timesheet`.`date_added` = "' . $yesterday . '"';
                break;
            case 'this_week':
                $startDate      = date('Y-m-d', strtotime('monday this week'));
                $endDate        = date('Y-m-d', strtotime('sunday this week'));
                $condition      = '`timesheet`.`date_added` BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
                break;
            case 'last_week':
                $startDate      = date('Y-m-d', strtotime('monday last week'));
                $endDate        = date('Y-m-d', strtotime('sunday last week'));
                $condition      = '`timesheet`.`date_added` BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
                break;
            case 'this_month':
                $startDate      = date('Y-m-01');
                $endDate        = date('Y-m-t');
                $condition      = '`timesheet`.`date_added` BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
                break;
            case 'last_month':
                $startDate      = date('Y-m-01', strtotime('first day of last month'));
                $endDate        = date('Y-m-t', strtotime('last day of last month'));
                $condition      = '`timesheet`.`date_added` BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
                break;
            case 'last_7_days':
                $startDate      = date('Y-m-d', strtotime('-7 days'));
                $endDate        = date('Y-m-d');
                $condition      = '`timesheet`.`date_added` BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
                break;
            case 'last_30_days':
                $startDate      = date('Y-m-d', strtotime('-30 days'));
                $endDate        = date('Y-m-d');
                $condition      = '`timesheet`.`date_added` BETWEEN "' . $startDate . '" AND "' . $endDate . '"';
                break;
            default:
                # code...
                break;
        }
        $project    = $model->find_data('project', 'row', ['id=' => $projectId]);
        $sql        = "SELECT
                            timesheet.*,
                            project.name AS projectName,
                            user.name AS userName,
                            effort_type.name AS effortName
                        FROM
                            `timesheet`
                        LEFT JOIN project ON timesheet.project_id = project.id
                        LEFT JOIN user ON timesheet.user_id = user.id
                        LEFT JOIN effort_type ON timesheet.effort_type = effort_type.id
                        WHERE
                            " .  $condition  . " AND timesheet.project_id = '$projectId'
                        ORDER BY
                            timesheet.`date_added` DESC";
        // echo $sql;die;
        $rows       = $this->db->query($sql)->getResult();
        $html = '<div class="modal-header" style="justify-content: center;">
                    <center><h6 style="font-size: x-large;" class="modal-title">Reports of Project <b><u> ' . $project->name . ' </b></u>' . '(' . ucwords(str_replace('_', ' ', (string)$date)) . ')' . '</h6></center>
                    <button style="position: absolute;right: 1rem;top: 1rem;background-color: #dd828b;border-radius: 50%;width: 30px;height: 30px;font-size: 1.2rem;color: #7e1019;cursor: pointer;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div style="justify-content: center;display: flex;gap: 10px;margin-top: 10px;">
                    <div class="btn btn-info"> <i class="fa fa-hourglass-end"></i>&nbsp; Total Effort: ' . $hours . '</div>';
        if ($billable == 0) {
            $html .=        '<div class="btn btn-success"><i class="fa fa-rupee"></i>&nbsp; ' . $hours . '</div>
                         <div class="btn btn-danger"><i class="fa fa-coffee"></i>&nbsp;  0 Hour 0 Minute</div>';
        } else {
            $html .=        '<div class="btn btn-success"><i class="fa fa-rupee"></i>&nbsp; 0 Hour 0 Minute</div>
                         <div class="btn btn-danger"><i class="fa fa-coffee"></i>&nbsp;  ' . $hours . '</div>';
        }
        $html .= '</div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="table-responsive">
                                <table class="table general_table_style padding-y-10">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Project</th>
                                            <th>User</th>
                                            <th>Work Date</th>
                                            <th>Time</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        if (!empty($rows)) {
            $sl = 1;
            foreach ($rows as $record) {
                $date1              = date_create($record->date_today);
                $date2              = date_create($record->date_added);
                $diff               = date_diff($date1, $date2);
                $date_difference    = $diff->format("%R%a");

                $html .= '<tr>
                        <td>' . $sl++ . '</td>';
                if ($record->bill == 0) {
                    $html .=    '<td>' . esc($record->projectName) . ' <span class="badge bg-success">Billable</span>' . '</td>';
                } else {
                    $html .=    '<td>' . esc($record->projectName) . ' <span class="badge bg-danger">Non-Billable</span>' . '</td>';
                }
                $html .=    '<td><b>' . esc($record->userName) . '</b></td>';
                if ($date_difference < 0) {
                    $html .=    '<td>' . esc($record->date_added) . ' <span class="text-danger">' . '(' . $date_difference . ')' . '</span>' . '</td>';
                } else {
                    $html .=    '<td>' . esc($record->date_added) . '</td>';
                }
                $html .=   '<td>' . esc($record->hour) . ':' . esc($record->min) . '</td>
                        <td>' . esc($record->description) . '</td>
                        <td>' . esc($record->effortName) . '</td>
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

    public function fetchData()
    {        
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');
        // pr($this->request->getPost());

        $query = "SELECT
                            timesheet.project_id, timesheet.date_added, project.name,project.project_time_type, timesheet.bill, SUM(timesheet.hour) AS total_hours, SUM(timesheet.min) AS total_minutes
                        FROM
                            timesheet
                        LEFT JOIN 
                            project ON timesheet.project_id = project.id
                            WHERE timesheet.date_added BETWEEN '$startDate' AND '$endDate'
                             GROUP BY
                            timesheet.project_id, project.name
                        ORDER BY
                            project.name ASC";

        $projects = $this->db->query($query)->getResult();
        //  pr($projects);
         $i4               = 1;
        $ystrdhr          = 0;
        $ystrdmin         = 0;
        $ystrdbill_hr     = 0;
        $ystrdbill_min    = 0;
        $ystrdnonbill_hr  = 0;
        $ystrdnonbill_min = 0;

        foreach ($projects as $row_yesterday_proj) {
            if ($row_yesterday_proj->bill != '1') {
                $ystrdbill_hr   = $ystrdbill_hr + $row_yesterday_proj->total_hours;
                $ystrdbill_min  = $ystrdbill_min + $row_yesterday_proj->total_minutes;
            } else {
                $ystrdnonbill_hr    = $ystrdnonbill_hr + $row_yesterday_proj->total_hours;
                $ystrdnonbill_min   = $ystrdnonbill_min + $row_yesterday_proj->total_minutes;
            }
            $i4++;
        }
        if ($ystrdbill_min < 60) {
            $ystrdtotbill_hour      = $ystrdbill_hr;
            $ystrdtotbill_minute    = $ystrdbill_min;
        } else {
            $ystrdtotbill_hour_res1 = floor($ystrdbill_min / 60);
            $ystrdtotbill_minute    = $ystrdbill_min % 60;
            $ystrdtotbill_hour      = $ystrdbill_hr + $ystrdtotbill_hour_res1;
        }
        if ($ystrdnonbill_min < 60) {
            $ystrdtotnonbill_hour   = $ystrdnonbill_hr;
            $ystrdtotnonbill_minute = $ystrdnonbill_min;
        } else {
            $ystrdtotnonbill_hour_res1  = floor($ystrdnonbill_min / 60);
            $ystrdtotnonbill_minute     = $ystrdnonbill_min % 60;
            $ystrdtotnonbill_hour       = $ystrdnonbill_hr + $ystrdtotnonbill_hour_res1;
        }
        $billabkeHoursMin               = number_format($ystrdtotbill_hour + ($ystrdtotbill_minute / 60), 2);
        $nonBillableHoursMin            = number_format($ystrdtotnonbill_hour + ($ystrdtotnonbill_minute / 60), 2);
        $html = '';
        $html = '<div class="" id="project-container">
                    <div class="row">
                        <div class="col md-6">
                            <div class="card-header card-header2">
                                <h6 class="heading_style text-center">
                                    ONGOING PROJECT
                                    <button type="button" class="btn btn-primary btn-sm" onclick="printDiv();"><i class="fa fa-print"></i></button>
                                </h6>
                            </div>
                            <div class="dt-responsive table-responsive" id="DivIdToPrint">
                                <table class="table padding-y-10 general_table_style" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th colspan="3">From Date : <u>'.$startDate.'</u></th>
                                            <th colspan="3">To Date : <u>'.$endDate.'</u></th>
                                        </tr>
                                        <tr>
                                            <th width="3%">#</th>
                                            <th width="5%">Project</th>
                                            <th width="5%">Project Status</th>
                                            <th width="5%">Total Time</th>
                                            <th width="5%">Total Cost</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        if ($projects) { $sl = 1;$total_cost = 0;$billable_cost=0;$non_billable_cost=0; foreach ($projects as $project) {
                /* cost calculation */
                    // $cost_sql1      = "SELECT project_cost FROM `project_cost` WHERE month=$last_month_month AND year=$last_month_year AND project_id = $ongoingProject->project_id";
                    // $checkCost      = $this->db->query($cost_sql1)->getRow();
                    $project_cost   = 0;
                    // if($checkCost){
                    //     $project_cost   = $checkCost->project_cost;
                    // } else {
                    //     $date_added     = $last_month_year.'-'.$last_month_month;
                    //     $cost_sql2      = "SELECT sum(cost) as total_cost FROM `timesheet` WHERE project_id=$ongoingProject->project_id AND date_added LIKE '%$date_added%'";
                    //     $checkCost      = $this->db->query($cost_sql2)->getRow();
                    //     $project_cost   = $checkCost->total_cost;
                    // }                    
                    $cost_sql2      = "SELECT sum(cost) as total_cost FROM `timesheet` WHERE project_id=$project->project_id AND date_added >= '$startDate' AND date_added <= '$endDate'";
                    $checkCost      = $this->db->query($cost_sql2)->getRow();
                    $project_cost   = $checkCost->total_cost;
                    $total_cost += $project_cost;
                /* cost calculation */
                $html .= '<tr>
                            <th>' . $sl++ . '</th>';

                            if ($project->bill == 0) {
                                if ($project->project_time_type == 'Onetime') {
                                    $html .= '<th>' . $project->name . 
                                            '<a target="_blank" href="' . base_url('admin/projects/reports/' . base64_encode($project->project_id)) . 
                                            '"><i class="fa fa-file" style="margin-left: 5px;"></i></a>' . 
                                            '</th>';
                                } else {
                                    $html .= '<th>' . $project->name . 
                                                '<a target="_blank" href="' . base_url('admin/projects/reports/' . base64_encode($project->project_id)) . 
                                                '"><i class="fa fa-file" style="margin-left: 5px;"></i></a>' . 
                                                '</th>';
                                }
                                $billable_cost += $project_cost;
                            } else {
                                if ($project->project_time_type == 'Onetime') {
                                    $html .= '<th>' . $project->name . 
                                            '<a target="_blank" href="' . base_url('admin/projects/reports/' . base64_encode($project->project_id)) . 
                                            '"><i class="fa fa-file" style="margin-left: 5px;"></i></a>' . 
                                            '</th>';
                                } else {
                                    $html .= '<th>' . $project->name . 
                                            '<a target="_blank" href="' . base_url('admin/projects/reports/' . base64_encode($project->project_id)) . 
                                            '"><i class="fa fa-file" style="margin-left: 5px;"></i></a>' . 
                                            '</th>';
                                }
                                $non_billable_cost += $project_cost;
                            }

                            $totalHours         = (int) $project->total_hours;
                            $totalMinutes       = (int) $project->total_minutes;
                            $additionalHours    = intdiv($totalMinutes, 60);
                            $remainingMinutes   = $totalMinutes % 60;
                            $totalHours        += $additionalHours;
                            $formattedTime      = sprintf("%d hours %d minutes", $totalHours, $remainingMinutes);

                            if ($project->bill == 0) {
                                if ($project->project_time_type == 'Onetime') {
                                    $html .= '<th>  <span class="badge bg-success mx-1">Billable</span><span class="badge bg-info">Fixed</span></th>';
                                } else {
                                    $html .= '<th>  <span class="badge bg-success mx-1">Billable</span><span class="badge bg-primary">Monthly</span></th>';
                                }
                                $billable_cost += $project_cost;
                            } else {
                                if ($project->project_time_type == 'Onetime') {
                                    $html .= '<th> <span class="badge bg-danger mx-1">Non-Billable</span><span class="badge bg-info">Fixed</span></th>';
                                } else {
                                    $html .= '<th> <span class="badge bg-danger mx-1">Non-Billable</span><span class="badge bg-info">Monthly</span></th>';
                                }
                                $non_billable_cost += $project_cost;
                            }                


                $html .= '<th style="cursor: pointer;" onclick="showWorkList(' . $project->project_id . ', \'' . $startDate .'-'. $endDate . '\' , ' . ($project->bill == 0 ? '0' : '1') . ' , \'' . $formattedTime . '\')">';

                $html .= $formattedTime;

                $html .=    '</th>
                            <th>'.number_format($project_cost,2).'</th>
                        </tr>';
            }
            $html .= '<tr>
                        <th colspan="3" style="text-align:right; font-weight:bold;">Total</th>
                        <th>'.number_format($total_cost,2).'</th>
                    </tr>';
        } else {
            $html .= '<tr>
                        <td colspan="5">No records found for the selected date.</td>
                     </tr>';
        }
        $html .= '</tbody>
                    </table>
                </div>
            </div>';

        $html .= '<div class="col md-6">
                    <div class="card-header card-header2">
                        <h6 class="heading_style text-center">NONBILLABLE HOURS</h6>
                    </div>
                    <div class="dt-responsive table-responsive">
                        <table class="table general_table_style padding-y-10" style="width: 100%">
                            <thead>
                                <tr>
                                    <th width="1%">#</th>
                                    <th width="5%">Billable Hour<br>Billable Cost</th>
                                    <th width="5%">Nonbillable Hour<br>Nonbillable Cost</th>
                                </tr>
                            </thead>
                            <tbody>     
                                <tr>
                                    <th>1</th>';
            $html .= '              <th>' . $billabkeHoursMin . '<br>'.number_format($billable_cost,2).'</th>
                                    <th>' . $nonBillableHoursMin . '<br>'.number_format($non_billable_cost,2).'</th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            </div>';
        return $html;
    }

    public function desklogReport()
    {
        if (!$this->common_model->checkModuleFunctionAccess(26, 49)) {
                $data['action']             = 'Access Forbidden';
                $title                      = $data['action'] . ' ' . $this->data['title'];
                $page_name                  = 'access-forbidden';
                echo $this->layout_after_login($title, $page_name, $data);
                exit;
            }  
        $form_type = $this->request->getPost('form_type');
        if ($form_type == 'fetch_backlog_date') {
            // Handle the first form submission (Fetching backlog date)
            $date           = $this->request->getPost('date');  
        }               
        $apiSettings        = $this->common_model->find_data('application_settings', 'row', ['id' => 1]);            
        // $apiUrl = 'https://api.desklog.io/api/v2/app_usage_attendance';
        $apiUrl             = $apiSettings->api_url;
        // $appKey = '0srjzz9r2x4isr1j2i0eg8f4u5ndmhilvbr5w3t5';
        $appKey             = $apiSettings->api_key;
        // $cu_date = date('d-m-Y'); // Or however you are getting the current date
        $cu_date            = date('d-m-Y', strtotime($date)); // Or however you are getting the current date

        $url                = $apiUrl . '?appKey=' . $appKey . '&date=' . $cu_date;
        $response           = file_get_contents($url);
        $data               = json_decode($response, true);
        $records_status     = $data['status'];
        $records            = $data['data'];
        if($records_status){
            foreach ($records as $item) {
                $db_date = date_format(date_create($cu_date), "Y-m-d");
                $existingRecord = $this->common_model->find_data('desklog_report', 'row', ['desklog_usrid' => $item['id'], 'insert_date LIKE' => '%' . $db_date . '%']);
                if (!$existingRecord) {
                    $postData   = array(
                        'desklog_usrid' => $item['id'],
                        'email' => $item['email'],
                        'arrival_at' => $item['arrival_at'],
                        'left_at' => $item['left_at'],
                        'time_at_work' => $item['time_at_work'],
                        'productive_time' => $item['productive_time'],
                        'idle_time' => $item['idle_time'],
                        'private_time' => $item['private_time'],
                        'total_time_allocated' => $item['total_time_allocated'],
                        'total_time_spended' => $item['total_time_spended'],
                        'time_zone' => $item['time_zone'],
                        'app_and_os' => $item['app_and_os'],
                    );
                    $user_email                     = $item['email'];
                    $data['user']                   = $this->data['model']->find_data('user', 'array', ['status!=' => 3, 'email' => $user_email]);
                    //   pr($data['user'][0]['id']);
                    $user_id                        = $data['user'][0]->id;
                    $postData['tracker_user_id']    = $user_id;
                    $postData['insert_date']        = $db_date;

                    // print_r($postData);die();
                    $record = $this->common_model->save_data('desklog_report', $postData, '', $this->data['primary_key']);

                    $year = date('Y');
                        $month  =   date('m');
                        $sql10 = "SELECT * FROM `desktime_sheet_tracking` WHERE year_upload = '$year' AND month_upload = '$month' AND user_id = '$user_id'";
                        $getDesktimeHour = $this->db->query($sql10)->getRow();                        
                        $sql = "SELECT time_at_work FROM `desklog_report` where tracker_user_id='$user_id' and insert_date LIKE '%" . date('Y').'-'.date('m') . "%'";
                        $getDesktime = $this->db->query($sql)->getResult();                        
                        $totalHours = 0;
                        $totalMinutes = 0;
                        foreach ($getDesktime as $entry) {                            
                            // Extract hours and minutes
                            sscanf($entry->time_at_work, "%dh %dm", $hours, $minutes);                            
                            // Sum up hours and minutes
                            $totalHours += $hours;
                            $totalMinutes += $minutes;                           
                        }
                         $totalHours += intdiv($totalMinutes, 60);
                         $totalMinutes = $totalMinutes % 60;   
                         $MonthlyDesktime = $totalHours.'.'.$totalMinutes;                                                                
                        if ($getDesktimeHour) {                               
                        $postData = array(
                            'total_desktime_hour' => $MonthlyDesktime,                                
                        );                         
                        $updateData = $this->common_model->save_data('desktime_sheet_tracking',$postData,$getDesktimeHour->id,'id'); 
                         $result7 = $getDesktimeHour->total_desktime_hour;
                        }else{
                            $postData = array(
                                'month_upload' => $month,                                
                                'year_upload' => $year,                                
                                'user_id' => $user_id,                                
                                'name' => $user_name,                                
                                'email' => $user_email,
                                'department' => $user_dept,
                                'total_desktime_hour' => $MonthlyDesktime,
                                'total_working_time' => $MonthlyDesktime,
                                'added_on' => $db_date,                               
                            );                             
                            $insertData = $this->common_model->save_data('desktime_sheet_tracking',$postData,'','id');
                            $result7 ='';
                        }

                } else {
                    $id = $existingRecord->id;
                    $postData   = array(
                        'desklog_usrid' => $item['id'],
                        'email' => $item['email'],
                        'arrival_at' => $item['arrival_at'],
                        'left_at' => $item['left_at'],
                        'time_at_work' => $item['time_at_work'],
                        'productive_time' => $item['productive_time'],
                        'idle_time' => $item['idle_time'],
                        'private_time' => $item['private_time'],
                        'total_time_allocated' => $item['total_time_allocated'],
                        'total_time_spended' => $item['total_time_spended'],
                        'time_zone' => $item['time_zone'],
                        'app_and_os' => $item['app_and_os'],
                    );
                    $user_email = $item['email'];
                    $data['user']               = $this->data['model']->find_data('user', 'array', ['status!=' => 3, 'email' => $user_email]);
                    $user_id = $data['user'][0]->id;
                    $postData['tracker_user_id'] = $user_id;
                    $postData['insert_date'] = $db_date;
                    $record = $this->common_model->save_data('desklog_report', $postData, $id, $this->data['primary_key']);

                    $year = date('Y');
                    $month  =   date('m');
                    $sql10 = "SELECT * FROM `desktime_sheet_tracking` WHERE year_upload = '$year' AND month_upload = '$month' AND user_id = '$user_id'";                     
                    $getDesktimeHour = $this->db->query($sql10)->getRow();                        
                    
                    $sql = "SELECT time_at_work FROM `desklog_report` where tracker_user_id='$user_id' and insert_date LIKE '%" . date('Y').'-'.date('m') . "%'";
                    $getDesktime = $this->db->query($sql)->getResult();  
                    // echo $this->db->getLastquery();die;                      
                    $totalHours = 0;
                    $totalMinutes = 0;
                    foreach ($getDesktime as $entry) {                            
                        // Extract hours and minutes
                        sscanf($entry->time_at_work, "%dh %dm", $hours, $minutes);                            
                        // Sum up hours and minutes
                        $totalHours += $hours;
                        $totalMinutes += $minutes;                           
                    }
                     $totalHours += intdiv($totalMinutes, 60);
                     $totalMinutes = $totalMinutes % 60;   
                     $MonthlyDesktime = $totalHours.'.'.$totalMinutes;                                                                
                    if ($getDesktimeHour) {                               
                        $postData = array(
                            'total_desktime_hour' => $MonthlyDesktime,                                
                        );                         
                        $updateData = $this->common_model->save_data('desktime_sheet_tracking',$postData,$getDesktimeHour->id,'id'); 
                        // pr($updateData);

                        $result7 = $getDesktimeHour->total_desktime_hour;
                    } else{
                        $postData = array(
                            'month_upload' => $month,                                
                            'year_upload' => $year,                                
                            'user_id' => $user_id,                                
                            'name' => $user_name,                                
                            'email' => $user_email,
                            'department' => $user_dept,
                            'total_desktime_hour' => $MonthlyDesktime,
                            'total_working_time' => $MonthlyDesktime,
                            'added_on' => $db_date,                               
                        );                             
                        $insertData = $this->common_model->save_data('desktime_sheet_tracking',$postData,'','id');
                        $result7 ='';
                    }
                }
            }
        }
        $this->session->setFlashdata('success_message', 'Data fetched and saved successfully.');
        // echo $this->layout_after_login($title, $page_name, $data);
        return redirect()->to('/admin/reports/desklog-report-view/');
    }

    public function show()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'] . ' : Desktop App Report';
        $page_name                  = 'report/desklog-report';

        $currentDate                = date('Y-m-d');
        // $dateWise                = $this->common_model->find_data('desktop_app', 'array', ['insert_date LIKE' => '%' . $currentDate . '%']);
        $join                       = [['table' => 'user', 'field' => 'id', 'table_master' => 'desktop_app', 'field_table_master' => 'desktopapp_userid', 'type' => 'INNER']];  
        $select                     = 'desktop_app.*, user.name AS name, user.email';   
        $dateWise                   = $this->common_model->find_data('desktop_app', 'array', ['insert_date LIKE' => '%' . $currentDate . '%'], $select, $join);
        $data['dateWise']           = $dateWise;
        $data['is_date_range']      = $currentDate;

        if ($this->request->getMethod() == 'post') {

            $is_date_range              = $this->request->getPost('is_date_range');
            // $dateWise                = $this->common_model->find_data('desktop_app', 'array', ['insert_date LIKE' => '%' . $is_date_range . '%']);
            $join                       = [['table' => 'user', 'field' => 'id', 'table_master' => 'desktop_app', 'field_table_master' => 'desktopapp_userid', 'type' => 'INNER']];   
            $select                     = 'desktop_app.*, user.name AS name, user.email';            
            $dateWise                   = $this->common_model->find_data('desktop_app', 'array', ['insert_date LIKE' => '%' . $is_date_range . '%'], $select, $join);
            $data['dateWise']           = $dateWise;
            //  print_r($data['dateWise']);
            //  var_dump($data['dateWise']);
            $data['is_date_range']      = $is_date_range;
        }

        echo $this->layout_after_login($title, $page_name, $data);
    }
}
