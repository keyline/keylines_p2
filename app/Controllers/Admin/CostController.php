<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use CodeIgniter\CLI\Console;

class CostController extends BaseController
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
            'title'                 => 'User Cost',
            'controller_route'      => 'user-cost',
            'controller'            => 'CostController',
            'table_name'            => 'effort_type',
            'primary_key'           => 'id'
        );
    }
    public function usercost()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage ' . $this->data['title'];
        $page_name                  = 'user-cost';
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


        $data['response']           = [];
        $data['search_user_id']     = 'all';
        $data['user_cost']     = '';
        $data['search_range_from']  = '';
        $data['search_range_to']    = '';
        
        if ($this->request->getGet('mode') == 'user-cost') {
            // pr($this->request->getGet());
            $search_user_id     = $this->request->getGet('search_user_id');                        
            $user_cost          = $this->request->getGet('user_cost');                        
            $search_range_from  = $this->request->getGet('search_range_from');
            $search_range_to    = $this->request->getGet('search_range_to');

            // Fetch user's hourly cost
            $user_hour_cost = $this->data['model']->find_data('user', 'row', ['id' => $search_user_id], 'id,hour_cost');            
            $cal_usercost = ($user_cost / 60);

            // Prepare and execute the query safely
            $sql = "SELECT * FROM `timesheet` 
                    WHERE `user_id` = ? 
                    AND `date_added` BETWEEN ? AND ?";
            $rows = $this->db->query($sql, [$search_user_id, $search_range_from, $search_range_to])->getResult();

            // Add calculated cost to each row
            foreach ($rows as &$row) {
                $id = $row->id;
                $hour = $row->hour;
                $min = $row->min;
                $row->hour_rate = $user_cost;  // Assuming you want cost per minute
                $cal= (($hour*60) + $min); //converted to minutes
                $projectCost= floatval($cal_usercost * $cal);
                $row->cost = number_format($projectCost, 2, '.', '');

                $record     = $this->data['model']->save_data('timesheet', $row, $id, 'id');
                // $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            }                                                    
            $response = [];
            $total_effort_in_mins = 0;
            if ($rows) {
                // pr($rows);
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
                        'cost'              => $row->cost,
                        'hour_rate'         => $row->hour_rate,
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
            $data['search_range_from']      = $search_range_from;
            $data['search_range_to']        = $search_range_to;            
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function projectcost()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage Project Cost';
        $page_name                  = 'project-cost';
        $order_by[0]                = array('field' => 'project.name', 'type' => 'ASC');
        $join[0]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
        $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
        $data['projects']           = $this->data['model']->find_data('project', 'array', ['project.status!=' => 13], 'project.id,project.name,project_status.name as project_status_name,client.name as client_name', $join, '', $order_by);

        // $data['projectwise_users']  = $this->data['model']->find_data('user', 'array', ['status!=' => '3'], 'id,name,status', '', '', $order_by); 

        // $order_by[0]                = array('field' => 'project.status', 'type' => 'ASC');
        $order_by[0]                = array('field' => 'project.name', 'type' => 'ASC');
        $join[0]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'status', 'type' => 'INNER'];
        $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => 'project', 'field_table_master' => 'client_id', 'type' => 'INNER'];
        $user_type                  = $this->session->get('user_type');
        $user_id                    = $this->session->get('user_id');        


        $data['response']           = [];
        $data['search_project_id']     = 'all';
        $data['project_month']     = '';
        $data['project_year']  = '';
    
        
        if ($this->request->getGet('mode') == 'project-cost') {
            // pr($this->request->getGet());
            $search_project_id     = $this->request->getGet('search_project_id');                        
            $user_cost          = $this->request->getGet('user_cost');                        
            $search_range_from  = $this->request->getGet('search_range_from');
            $search_range_to    = $this->request->getGet('search_range_to');

            // Fetch user's hourly cost
            $user_hour_cost = $this->data['model']->find_data('user', 'row', ['id' => $search_project_id], 'id,hour_cost');            
            $cal_usercost = ($user_cost / 60);

            // Prepare and execute the query safely
            $sql = "SELECT * FROM `timesheet` 
                    WHERE `user_id` = ? 
                    AND `date_added` BETWEEN ? AND ?";
            $rows = $this->db->query($sql, [$search_project_id, $search_range_from, $search_range_to])->getResult();

            // Add calculated cost to each row
            foreach ($rows as &$row) {
                $id = $row->id;
                $hour = $row->hour;
                $min = $row->min;
                $row->hour_rate = $user_cost;  // Assuming you want cost per minute
                $cal= (($hour*60) + $min); //converted to minutes
                $projectCost= floatval($cal_usercost * $cal);
                $row->cost = number_format($projectCost, 2, '.', '');

                $record     = $this->data['model']->save_data('timesheet', $row, $id, 'id');
                // $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            }                                                    
            $response = [];
            $total_effort_in_mins = 0;
            if ($rows) {
                // pr($rows);
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
                        'cost'              => $row->cost,
                        'hour_rate'         => $row->hour_rate,
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
            $data['search_project_id']         = $search_project_id;            
            $data['search_range_from']      = $search_range_from;
            $data['search_range_to']        = $search_range_to;            
        }
        echo $this->layout_after_login($title, $page_name, $data);
    }
    
    // public function getLastNDays($days, $format = 'd/m')
    // {
    //     $m = date("m");
    //     $de = date("d");
    //     $y = date("Y");
    //     $dateArray = array();
    //     for ($i = 0; $i <= $days - 1; $i++) {
    //         $dateArray[] = date($format, mktime(0, 0, 0, $m, ($de - $i), $y));
    //     }
    //     return array_reverse($dateArray);
    // }

    
}
