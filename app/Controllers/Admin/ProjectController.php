<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class ProjectController extends BaseController {

    private $model;  //This can be accessed by all class methods
	public function __construct()
    {
        $session = \Config\Services::session();
        if(!$session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }
        $model = new CommonModel();
        $this->data = array(
            'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Projects',
            'controller_route'      => 'projects',
            'controller'            => 'ProjectController',
            'table_name'            => 'project',
            'primary_key'           => 'id'
        );
    }
    public function list()
    {
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'project/list';
        $order_by1[0]                = array('field' => 'name', 'type' => 'ASC');
        $data['projectStats']       = $this->data['model']->find_data('project_status', 'array', ['status' => 1], 'id,name', '', '', $order_by1);
        $order_by[0]                = array('field' => $this->data['table_name'].'.'.$this->data['primary_key'], 'type' => 'desc');
        $select                     = 'project.*, user.name as assigned_name, client.name as client_name, client.compnay as client_company_name, project_status.name as project_status_name';
        $join[0]                    = ['table' => 'user', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'assigned_by', 'type' => 'inner'];
        $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'client_id', 'type' => 'inner'];
        $join[2]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'status', 'type' => 'inner'];
        // $join[2]                    = ['table' => 'user', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'client_service', 'type' => 'inner'];
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['project.active!=' => 3], $select, $join, '', $order_by);
        if($this->request->getMethod() == 'post') {
            //    pr($this->request->getPost());
              $project_id           = $this->request->getPost('project_id');
              $project_status       = $this->request->getPost('status');
            $data['project']        = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$project_id]);
            // pr($data['project']);
            $postData = array(
                'active' => 0,
                'status' => $project_status
            );
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$project_id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');

        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function activeProject(){
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'project/active-project';

        $order_by[0]                = array('field' => $this->data['table_name'].'.'.$this->data['primary_key'], 'type' => 'desc');
        $select                     = 'project.*, user.name as assigned_name, client.name as client_name, client.compnay as client_company_name, project_status.name as project_status_name';
        $join[0]                    = ['table' => 'user', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'assigned_by', 'type' => 'inner'];
        $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'client_id', 'type' => 'inner'];
        $join[2]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'status', 'type' => 'inner'];
        // $join[2]                    = ['table' => 'user', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'client_service', 'type' => 'inner'];
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['project.active!=' => 3,'active'=>0], $select, $join, '', $order_by);



        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function InactiveProject(){
        $data['moduleDetail']       = $this->data;
        $title                      = 'Manage '.$this->data['title'];
        $page_name                  = 'project/inactive-project';

        $order_by[0]                = array('field' => $this->data['table_name'].'.'.$this->data['primary_key'], 'type' => 'desc');
        $select                     = 'project.*, user.name as assigned_name, client.name as client_name, client.compnay as client_company_name, project_status.name as project_status_name';
        $join[0]                    = ['table' => 'user', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'assigned_by', 'type' => 'inner'];
        $join[1]                    = ['table' => 'client', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'client_id', 'type' => 'inner'];
        $join[2]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'status', 'type' => 'inner'];
        // $join[2]                    = ['table' => 'user', 'field' => 'id', 'table_master' => $this->data['table_name'], 'field_table_master' => 'client_service', 'type' => 'inner'];
        $data['rows']               = $this->data['model']->find_data($this->data['table_name'], 'array', ['project.active!=' => 3,'active'=>1], $select, $join, '', $order_by);
                // To print the last executed query
// echo $this->db->getLastQuery(); die;
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function add()
    {
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Add';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'project/add-edit';        
        $data['row']                = [];

        $order_by[0]                = array('field' => 'name', 'type' => 'ASC');
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status' => '1'], 'id,name', '', '', $order_by);
        $data['projectStats']       = $this->data['model']->find_data('project_status', 'array', ['status' => 1], 'id,name', '', '', $order_by);
        $data['clients']            = $this->data['model']->find_data('client', 'array', '', 'id,name,compnay', '', '', $order_by);
        $data['projects']           = $this->data['model']->find_data('project', 'array', '', 'id,name', '', '', $order_by);

        if($this->request->getMethod() == 'post') {
            //  pr($this->request->getPost());
            $project_status = $this->request->getPost('status');
            $postData   = array(
                'name'                  => $this->request->getPost('name'),
                'description'           => $this->request->getPost('description'),
                'assigned_by'           => $this->request->getPost('assigned_by'),
                'status'                => $this->request->getPost('status'),
                'type'                  => $this->request->getPost('type'),
                'client_id'             => $this->request->getPost('client_id'),
                'project_time_type'     => $this->request->getPost('project_time_type'),
                'hour'                  => (($this->request->getPost('hour') != '')?$this->request->getPost('hour'):NULL),
                'hour_month'            => (($this->request->getPost('hour_month') != '')?$this->request->getPost('hour_month'):NULL),
                'start_date'            => date_format(date_create($this->request->getPost('start_date')), "Y-m-d"),
                'deadline'              => date_format(date_create($this->request->getPost('deadline')), "Y-m-d"),
                'temporary_url'         => $this->request->getPost('temporary_url'),
                'permanent_url'         => $this->request->getPost('permanent_url'),
                'parent'                => $this->request->getPost('parent'),
                'client_service'        => $this->request->getPost('client_service'),
                'bill'                  => $this->request->getPost('bill'),
                'active'                => ($project_status != 13) ? 0 : 1,
                'date_added'            => date('Y-m-d H:i:s'),
                'date_modified'         => date('Y-m-d H:i:s'),
            );
            //  pr($postData);
            $record     = $this->data['model']->save_data($this->data['table_name'], $postData, '', $this->data['primary_key']);
            $this->session->setFlashdata('success_message', $this->data['title'].' inserted successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function edit($id)
    {
        $id                         = decoded($id);
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = $data['action'].' '.$this->data['title'];
        $page_name                  = 'project/add-edit';        
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions);

        $order_by[0]                = array('field' => 'name', 'type' => 'ASC');
        $data['users']              = $this->data['model']->find_data('user', 'array', ['status' => '1'], 'id,name', '', '', $order_by);
        $data['projectStats']       = $this->data['model']->find_data('project_status', 'array', ['status' => 1], 'id,name', '', '', $order_by);
        $data['clients']            = $this->data['model']->find_data('client', 'array', '', 'id,name,compnay', '', '', $order_by);
        $data['projects']           = $this->data['model']->find_data('project', 'array', '', 'id,name', '', '', $order_by);

        if($this->request->getMethod() == 'post') {
            $projectStatus = $this->request->getPost('status');
            $postData   = array(
                'name'                  => $this->request->getPost('name'),
                'description'           => $this->request->getPost('description'),
                'assigned_by'           => $this->request->getPost('assigned_by'),
                'status'                => $projectStatus,
                'type'                  => $this->request->getPost('type'),
                'client_id'             => $this->request->getPost('client_id'),
                'project_time_type'     => $this->request->getPost('project_time_type'),
                'hour'                  => (($this->request->getPost('hour') != '')?$this->request->getPost('hour'):NULL),
                'hour_month'            => (($this->request->getPost('hour_month') != '')?$this->request->getPost('hour_month'):NULL),
                'start_date'            => date_format(date_create($this->request->getPost('start_date')), "Y-m-d"),
                'deadline'              => date_format(date_create($this->request->getPost('deadline')), "Y-m-d"),
                'temporary_url'         => $this->request->getPost('temporary_url'),
                'permanent_url'         => $this->request->getPost('permanent_url'),
                'parent'                => $this->request->getPost('parent'),
                'client_service'        => $this->request->getPost('client_service'),
                'bill'                  => $this->request->getPost('bill'),
                'active'                => (($projectStatus == 13)?1:0),
                'date_modified'         => date('Y-m-d H:i:s'),
            );
            $record = $this->common_model->save_data($this->data['table_name'], $postData, $id, $this->data['primary_key']);
            
            $this->session->setFlashdata('success_message', $this->data['title'].' updated successfully');
            return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
        }        
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function confirm_delete($id)
    {
        $id                         = decoded($id);
        // $updateData = $this->common_model->delete_data($this->data['table_name'],$id,$this->data['primary_key']);
        $this->common_model->save_data($this->data['table_name'],['active' => 3],$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' deleted successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function change_status($id)
    {
        $id                         = decoded($id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', [$this->data['primary_key']=>$id]);
        if($data['row']->active == 0){
            $status     = 13;
            $msg        = 'Deactivated';
            $postData = array(
                'active' => 1,
                'status' => $status
            );
        } else {
            $status     = 1;
            $msg        = 'Activated';
            $postData = array(
                'active' => 0,
                'status' => $status
            );
        }
        // pr($postData);
        $updateData = $this->common_model->save_data($this->data['table_name'],$postData,$id,$this->data['primary_key']);
        $this->session->setFlashdata('success_message', $this->data['title'].' '.$msg.' successfully');
        return redirect()->to('/admin/'.$this->data['controller_route'].'/list');
    }
    public function projectEffortList($id)
    {
        $id                         = decoded($id);
        $conditions                 = array($this->data['primary_key']=>$id);
        $data['row']                = $this->data['model']->find_data($this->data['table_name'], 'row', $conditions, 'name');
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Edit';
        $title                      = 'Effort Booking : '.(($data['row'])?$data['row']->name:'');
        $page_name                  = 'project/project-effort-list';
        $orderBy[0]                 = ['field' => 'timesheet.id', 'type' => 'DESC'];
        $join[0]                    = ['table' => 'user', 'field' => 'id', 'table_master' => 'timesheet', 'field_table_master' => 'user_id', 'type' => 'inner'];
        $join[1]                    = ['table' => 'project_status', 'field' => 'id', 'table_master' => 'timesheet', 'field_table_master' => 'status_id', 'type' => 'inner'];
        $data['efforts']            = $this->data['model']->find_data('timesheet', 'array', ['timesheet.project_id' => $id], 'timesheet.*, user.name as booked_name, project_status.name as project_status_name', $join, '', $orderBy);
        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function reports($id){
        $id                             = base64_decode($id);
        $data['project']                = $this->data['model']->find_data('project', 'row', ['id' => $id], '', '', '', '');
        // Split the date and time
        // $datePart                  = explode(" ", $data['project']->date_added)[0]; // Extract '2024-01-08'
        // echo $startMonth                = explode("-", $data['project']->start_date)[1];
        // echo $startYear                = explode("-", $data['project']->start_date)[0];
        // Define the start date
        $startDate = new DateTime($data['project']->start_date); // Convert to DateTime object

// Get the current date
$currentDate = new DateTime(); // Current date as a DateTime object

// Calculate the difference
$interval = $startDate->diff($currentDate);

// Get the total months count
$totalMonths = ($interval->y * 12) + $interval->m;
        // pr($startMonth);
        pr($data['project']);        
        $order_by[0]                    = array('field' => 'name', 'type' => 'ASC');
        // $data['all_projects']        = $this->data['model']->find_data('project', 'array', ['active' => 0], '', '', '', $order_by);
        $sql1                           = "SELECT project.*, project_status.name AS project_status_name FROM project, project_status WHERE project.status NOT IN (SELECT id FROM project_status WHERE id = 13) AND project.status = project_status.id ORDER BY project.name";
        $data['all_projects']           = $this->db->query($sql1)->getResult();
        $sql2                           = "SELECT project.*, project_status.name AS project_status_name FROM project JOIN project_status ON project.status = project_status.id WHERE project.status = 13 ORDER BY project.name";
        $data['all_closed_projects']    = $this->db->query($sql2)->getResult();
        $data['moduleDetail']           = $this->data;
        $title                          = 'Manage '.$this->data['title'];
        $page_name                      = 'project/reports';
        $sql10                          = 'SELECT timesheet.id as timesheet_id, effort_type.id AS effort_type_id, effort_type.name FROM timesheet LEFT JOIN effort_type ON timesheet.effort_type = effort_type.id WHERE timesheet.project_id = '.$id.' AND date_added BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND CURDATE() GROUP BY effort_type.name ORDER BY effort_type.id ASC';
        $data['effortTypes']            = $this->db->query($sql10)->getResult();

        $sql20                          = 'SELECT timesheet.id as timesheet_id, user.id AS user_id, user.name FROM timesheet LEFT JOIN user ON timesheet.user_id = user.id WHERE timesheet.project_id = '.$id.' AND timesheet.date_added BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 YEAR) AND CURDATE() GROUP BY user.name ORDER BY user.name ASC';
        $data['usersData']              = $this->db->query($sql20)->getResult();
        
        $months                         = [];
        for ($i = 11; $i >= 0; $i--) {
            $date               = date("M-y", strtotime( date( 'Y-m-01' )." -$i months"));
            $numericDate        = date("Y-m", strtotime(date('Y-m-01') . " -$i months"));
            $monthData[]        = $date;
            $numeric_dates[]    = $numericDate;
            $months[]           = strtoupper($date);            
             $sql                = "SELECT SUM(hour) as hours,SUM(min) as mins, SUM(cost) AS total_hours_worked FROM `timesheet` WHERE `date_added` LIKE '%".$numericDate."%' and project_id=".$id."";
            $rows               = $this->db->query($sql)->getResult();
            
            $eachMonthHour[]    = $rows;
        }
         $sql                = "SELECT SUM(hour) as hours,SUM(min) as mins, SUM(cost) AS total_hours_worked FROM `timesheet` WHERE `date_added` LIKE '%".$numericDate."%' and project_id=".$id."";
        // pr($rows);
        $data['id']             = $id;
        $data['months']         = $months;
        $data['eachMonthHour']  = $eachMonthHour;
        $data['numeric_dates']  = $numeric_dates;

        echo $this->layout_after_login($title,$page_name,$data);
    }
}