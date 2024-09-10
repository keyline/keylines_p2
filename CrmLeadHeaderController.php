<?php
namespace App\Controllers\Admin; // Controller namespace
use App\Controllers\BaseController;
use App\Models\AdminAuth;
use App\Models\CommonModel;
use App\Models\Company;
use App\Models\MemberType;
class CrmLeadHeaderController extends BaseController
{  
  /* lead status */  
  public function leadHeader()
  {
    $session                = \Config\Services::session();
    $userId                 = $session->get('userId');
    if(isset($userId)){      
      if(!$this->checkModuleAccess(40)){
        return redirect()->to(base_url('admin/access-denied')); 
      }
      $model                = new CommonModel();
      $data['commonModel']  = $model;
      $order_by[0]          = ['field' => 'rank', 'type' => 'ASC'];
      $data['rows']         = $model->find_data('crm_lead_headers', 'array', ['published!=' => 3], '', '', '', $order_by); 
      // pr($data['rows']);
      return view('admin/layout/crm/leadHeader',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function addLeadHeader()
  {
    $session = \Config\Services::session();
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'name'                  => strtoupper($this->request->getPost('name')),
                  'header_type'           => strtoupper($this->request->getPost('header_type')),
                  'rank'                  => strtoupper($this->request->getPost('header_rank'))
                ];
        $this->common_model->save_data('crm_lead_headers', $postData, '', 'id');
        return redirect()->to(base_url('admin/leadHeader'));
      }
      $data['row'] = [];
      return view('admin/layout/crm/addEditLeadHeader',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function updateLeadHeader($id)
  {
    $session = \Config\Services::session();
    $userId = $session->get('userId');
    $this->common_model = new CommonModel();
    if(isset($userId)){
      if($this->request->getPost()){
        $postData = [
                  'name'                  => strtoupper($this->request->getPost('name')),
                  'header_type'           => strtoupper($this->request->getPost('header_type')),
                  'rank'                  => strtoupper($this->request->getPost('header_rank'))
                ];
        $this->common_model->save_data('crm_lead_headers', $postData, $id, 'id');
        return redirect()->to(base_url('admin/leadHeader'));
      }
      $data['row'] = $this->common_model->find_data('crm_lead_headers', 'row', ['id' => $id]);
      return view('admin/layout/crm/addEditLeadHeader',$data);
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }
  public function deleteLeadHeader($id)
  {
    $session = \Config\Services::session();
    $userId = $session->get('userId');
    if(isset($userId)){
      $model = new CommonModel();
      $model->delete_data('crm_lead_headers', $id, 'id');
      return redirect()->to(base_url('admin/leadHeader'));
    } else {
      return redirect()->to(base_url('admin/login'));
    }
  }

  /* lead status */

  
	
}