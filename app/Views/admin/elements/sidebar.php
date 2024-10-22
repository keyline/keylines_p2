<?php
$baseUrl    = base_url();
if ($baseUrl == 'https://tracker2.keylines.net/') {
    $currentLink    = current_url();
    $uri            = new \CodeIgniter\HTTP\URI($currentLink);
    $pageSegment    = $uri->getSegment(2);
} else {
    $currentLink    = current_url();
    $uri            = new \CodeIgniter\HTTP\URI($currentLink);
    $pageSegment    = $uri->getSegment(3);
}
$paramerId = '';
if ($baseUrl == 'https://tracker2.keylines.net/') {
    $segmentCount = $uri->getTotalSegments();
    if ($segmentCount > 2) {
        $paramerId = $uri->getSegment(3);
    } else {
        $paramerId = '';
    }
} else {
    $segmentCount = $uri->getTotalSegments();
    if ($segmentCount > 3) {
        $paramerId = $uri->getSegment(4);
    } else {
        $paramerId = '';
    }
}
$userType           = $session->user_type;
$userId             = $session->user_id;
?>
<style type="text/css">
  a.nav-link.active {
    color: green;
  }
</style>
<!-- sidebar start -->
<ul class="nav-links">
  <li>
    <i class='bx bx-menu'></i>
  </li>

  <li>
    <div class="iocn-link">
      <a class="<?= (($pageSegment == 'dashboard') ? 'active' : '') ?>" href="<?= base_url('admin/dashboard') ?>">
        <i class="fa fa-home"></i>
        <span class="link_name">Dashboard</span>
      </a>
    </div>
    <ul class="sub-menu blank">
      <li><a class="link_name" href="<?= base_url('admin/dashboard') ?>">Dashboard</a></li>
    </ul>
  </li>

  <?php if (checkModuleAccess(12) || checkModuleAccess(13) || checkModuleAccess(14)) { ?>
  <li>
    <div class="iocn-link">
      <a class="<?= (($pageSegment == 'manage_functionlist' || $pageSegment == 'manage_modulelist' || $pageSegment == 'manage_roles') ? '' : 'collapsed') ?> <?= (($pageSegment == 'manage_functionlist' || $pageSegment == 'manage_modulelist' || $pageSegment == 'manage_roles') ? 'active' : '') ?>"
        href="javascript:void(0)">
        <i class="fas fa-users"></i>
        <span class="link_name">User & Permission Management</span>
        <i class='bx bxs-chevron-down arrow ms-auto'></i>
      </a>
    </div>
    <ul
      class="sub-menu <?= (($pageSegment == 'manage_functionlist' || $pageSegment == 'manage_modulelist' || $pageSegment == 'manage_roles') ? 'show' : '') ?>">
      <li>
        <a class="<?= (($pageSegment == 'manage_functionlist' || $pageSegment == 'manage_modulelist' || $pageSegment == 'manage_roles') ? '' : 'collapsed') ?> <?= (($pageSegment == 'manage_functionlist' || $pageSegment == 'manage_modulelist' || $pageSegment == 'manage_roles') ? 'active' : '') ?>">
          <span class="link_name">User & Permission Management</span>
        </a>
      </li>
      <li>
        <a class="<?= (($pageSegment == 'users') ? 'active' : '') ?>" href="<?= base_url('admin/users/list') ?>">
          <i class="fa fa-arrow-right"></i>
          <span>Employees</span>
        </a>
      </li>
      <li>
        <a class="<?= (($pageSegment == 'team') ? 'active' : '') ?>" href="<?= base_url('admin/team/list') ?>">
          <i class="fa fa-arrow-right"></i>
          <span>Team</span>
        </a>        
      </li>
      <?php if($userType == 'SUPER ADMIN') { ?>
      <li>
        <a class="<?= (($pageSegment == 'user_cost') ? 'active' : '') ?>"
          href="<?= base_url('admin/user_cost/list') ?>">
          <i class="fa fa-arrow-right"></i>
          <span>Cost Update</span>
        </a>
      </li>
      <?php } ?>
      <!-- <li>
        <a class="<?= (($pageSegment == 'manage_functionlist' || $pageSegment == 'manage_modulelist' || $pageSegment == 'manage_roles') ? '' : 'collapsed') ?> <?= (($pageSegment == 'manage_functionlist' || $pageSegment == 'manage_modulelist' || $pageSegment == 'manage_roles') ? 'active' : '') ?>"
          href="javascript:void(0)">
          <span class="link_name">Access & Permission</span>
        </a>
      </li> -->
      <?php if(checkModuleAccess(12)){ ?>
      <!-- <li>
        <a class="?= (($pageSegment == 'manage_functionlist') ? 'active' : '') ?>"
          href="?= base_url('admin/manage_functionlist') ?>">
          <i class="fa fa-arrow-right"></i><span>Features</span>
        </a>
      </li>
      <?php } ?>
      <?php if(checkModuleAccess(13)){ ?>
      <li>
        <a class="?= (($pageSegment == 'manage_modulelist') ? 'active' : '') ?>"
          href="?= base_url('admin/manage_modulelist') ?>">
          <i class="fa fa-arrow-right"></i><span>Modules</span>
        </a>
      </li>
      <?php } ?> -->
      <?php if(checkModuleAccess(28)){ ?>
      <li>
        <a class="<?= (($pageSegment == 'role-master') ? 'active' : '') ?>"
          href="<?= base_url('admin/role-master/list') ?>">
          <i class="fa fa-arrow-right"></i><span>Roles</span>
        </a>
      </li>
      <?php } ?>
      <?php if(checkModuleAccess(14)){ ?>
      <li>
        <a class="<?= (($pageSegment == 'manage_roles') ? 'active' : '') ?>"
          href="<?= base_url('admin/manage_roles') ?>">
          <i class="fa fa-arrow-right"></i><span>Permission</span>
        </a>
      </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>
  <?php if (checkModuleAccess(5)) { ?>
    <li>
      <div class="iocn-link">
      <a class="<?= (($pageSegment == 'projects') ? 'active' : '') ?>" 
          href="javascript:void(0)">
          <i class="fas fa-project-diagram"></i>
          <span class="link_name">Projects</span>
          <i class='bx bxs-chevron-down arrow ms-auto'></i>
        </a>
      </div>                                    
        <ul class="sub-menu">
          <li>
            <a class="<?= (($pageSegment == 'projects') ? '' : 'collapsed') ?> <?= (($pageSegment == 'projects') ? 'active' : '') ?>"
              href="javascript:void(0)">
              <span class="link_name">Projects</span>
            </a>
          </li>  
          <li>
            <a class="<?= (($pageSegment == 'projects') ? 'active' : '') ?>" href="<?= base_url('admin/projects/list') ?>">
              <i class="fa fa-arrow-right"></i>
              <span>Project List</span>
            </a>             
          <li>        
          <li>
            <a class="<?= (($pageSegment == 'outside_project_cost') ? 'active' : '') ?>" href="<?= base_url('admin/outside_project/project_name') ?>">
              <i class="fa fa-arrow-right"></i>
              <span>Add Expenses</span>
            </a>             
          <li>
            <a class="<?= (($pageSegment == 'amc-checking') ? 'active' : '') ?>" href="<?= base_url('admin/amc-checking') ?>">
              <i class="fa fa-arrow-right"></i>
              <span>AMC Checking</span>
            </a>             
        </ul>
    </li>
  <?php } ?>
  <?php if (checkModuleAccess(6)) { ?>
    <li>
        <a class="<?= (($pageSegment == 'clients') ? 'active' : '') ?>" href="<?= base_url('admin/clients/list') ?>">
          <i class="fas fa-store"></i>
          <span class="link_name">Clients</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="<?= base_url('admin/clients/list') ?>">Clients</a></li>
        </ul>
    </li>
  <?php } ?>

  <?php if($userType != 'CLIENT'){ ?>
    <?php if (checkModuleAccess(7) || checkModuleAccess(19) || checkModuleAccess(20)) { ?>
        <li>
          <div class="iocn-link">
            <a class="<?= (($pageSegment == 'efforts') ? '' : 'collapsed') ?> <?= (($pageSegment == 'efforts') ? 'active' : '') ?>" href="javascript:void(0)">
              <i class="fa fa-tasks"></i>
              <span class="link_name">Effort Management</span>
              <i class='bx bxs-chevron-down arrow ms-auto'></i>
            </a>
          </div>
            <ul class="sub-menu <?= (($pageSegment == 'efforts') ? 'show' : '') ?>">
              <li>
                <a class="<?= (($pageSegment == 'efforts') ? '' : 'collapsed') ?> <?= (($pageSegment == 'efforts') ? 'active' : '') ?>"
                  href="javascript:void(0)">
                  <span class="link_name">Effort Management</span>
                </a>
              </li>
                <?php if ($admin->is_tracker_user) {  ?>
                  <!-- <li>
                    <a class="<?= (($pageSegment == 'team') ? 'active' : '') ?>" href="<?= base_url('admin/task-assign') ?>">
                      <i class="fa fa-arrow-right"></i>
                      <span>Task Assign</span>
                    </a>        
                  </li>  -->                 
                    <?php if(checkModuleAccess(19)){ ?>
                    <li>
                        <a class="<?= (($pageSegment == 'efforts' && $paramerId == 'add') ? 'active' : '') ?>" href="<?= base_url('admin/efforts/add') ?>">
                            <i class="fa fa-arrow-right"></i><span>Add My Effort</span>
                        </a>
                    </li>
                    <?php } ?>
                <?php } ?>
                <?php if(checkModuleAccess(20)){ ?>
                <li>
                    <a class="<?= (($pageSegment == 'efforts' && $paramerId == 'list') ? 'active' : '') ?>" href="<?= base_url('admin/efforts/list') ?>">
                        <i class="fa fa-arrow-right"></i><span>My History</span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
    <?php } ?>
  <?php } ?>

  <?php if (checkModuleAccess(22) || checkModuleAccess(23) || checkModuleAccess(24) || checkModuleAccess(25) || checkModuleAccess(26)) {    ?>
    <li>
      <div class="iocn-link">
        <a class="<?= (($pageSegment == 'reports') ? '' : 'collapsed') ?> <?= (($pageSegment == 'reports') ? 'active' : '') ?>" href="javascript:void(0)">
        <i class="fa fa-chart-simple"></i>  
          <span class="link_name">Reports</span>
          <i class='bx bxs-chevron-down arrow ms-auto'></i>
        </a>
      </div>
        <ul class="sub-menu <?= (($pageSegment == 'reports') ? 'show' : '') ?>">
            <li>
              <a class="<?= (($pageSegment == 'reports') ? '' : 'collapsed') ?> <?= (($pageSegment == 'reports') ? 'active' : '') ?>"
                href="javascript:void(0)">
                <span class="link_name">Reports</span>
              </a>
            </li>
            <?php if(checkModuleAccess(22)){ ?>
            <li>
                <a class="<?= (($pageSegment == 'reports' && $paramerId == 'advance-search') ? 'active' : '') ?>" href="<?= base_url('admin/reports/advance-search') ?>">
                    <i class="fa fa-arrow-right"></i><span>Advance Search</span>
                </a>
            </li>
            <?php } ?>
            <?php if(checkModuleAccess(23)){ ?>
            <li>
                <a class="<?= (($pageSegment == 'reports' && $paramerId == 'effort-report') ? 'active' : '') ?>" href="<?= base_url('admin/reports/effort-report') ?>">
                    <i class="fa fa-arrow-right"></i><span>Effort Report</span>
                </a>
            </li>
            <?php } ?>
            <?php if(checkModuleAccess(24)){ ?>
            <li>
                <a class="<?= (($pageSegment == 'reports' && $paramerId == 'hours-report') ? 'active' : '') ?>" href="<?= base_url('admin/reports/hours-report') ?>">
                    <i class="fa fa-arrow-right"></i><span>Project Effort</span>
                </a>
            </li>
            <?php } ?>
            <?php if(checkModuleAccess(25)){ ?>
            <li>
                <a class="<?= (($pageSegment == 'reports' && $paramerId == 'project-report') ? 'active' : '') ?>" href="<?= base_url('admin/reports/project-report') ?>">
                    <i class="fa fa-arrow-right"></i><span>Project Hourly Report</span>
                </a>
            </li>
            <?php } ?>
            <?php if(checkModuleAccess(26)){
                $sql       = "SELECT is_desklog_use FROM `application_settings`";
                $desklog    = $db->query($sql)->getRow();
                if($desklog->is_desklog_use == 1){ ?>
            <li>
                <a class="<?= (($pageSegment == 'reports' && $paramerId == 'desklog-report-view') ? 'active' : '') ?>" href="<?= base_url('admin/reports/desklog-report-view') ?>">
                    <i class="fa fa-arrow-right"></i><span>Desklog Report</span>
                </a>
            </li>
            <?php } } ?>
            <?php if ($userType == 'SUPER ADMIN' || $userType == 'ADMIN') { ?>
              <li>
                <a class="<?= (($pageSegment == 'attendance-report') ? 'active' : '') ?>" href="<?= base_url('admin/attendance-report') ?>">
                  <i class="fa fa-arrow-right"></i>
                  <span>Attendance</span>
                </a>        
              </li>
              <li>
                <a class="<?= (($pageSegment == 'email-logs') ? 'active' : '') ?>" href="<?= base_url('admin/email-logs') ?>">
                  <i class="fa fa-arrow-right"></i>
                  <span>Email Logs</span>
                </a>        
              </li>
              <li>
                <a class="<?= (($pageSegment == 'login-logs') ? 'active' : '') ?>" href="<?= base_url('admin/login-logs') ?>">
                  <i class="fa fa-arrow-right"></i>
                  <span>Login Logs</span>
                </a>        
              </li>
          <?php }?>
        </ul>
    </li>
  <?php } ?>  

  <?php if (checkModuleAccess(16) || checkModuleAccess(17) || checkModuleAccess(28)) { ?>
  <li>
    <div class="iocn-link">
      <a class="<?= (($pageSegment == 'effort-type' || $pageSegment == 'project-status' || $pageSegment == 'role-master' || $pageSegment == 'department' || $pageSegment == 'work-status') ? '' : 'collapsed') ?> <?= (($pageSegment == 'effort-type' || $pageSegment == 'project-status' || $pageSegment == 'role-master' || $pageSegment == 'department' || $pageSegment == 'work-status') ? 'active' : '') ?>"
        href="javascript:void(0)">
        <i class="fa fa-database"></i>
        <span class="link_name">Masters</span>
        <i class='bx bxs-chevron-down arrow ms-auto'></i>
      </a>
    </div>
    <ul
      class="sub-menu <?= (($pageSegment == 'effort-type' || $pageSegment == 'project-status' || $pageSegment == 'role-master' || $pageSegment == 'department' || $pageSegment == 'work-status' || $pageSegment == 'office-location') ? 'show' : '') ?>">
      <li>
        <a class="<?= (($pageSegment == 'effort-type' || $pageSegment == 'project-status' || $pageSegment == 'role-master' || $pageSegment == 'department' || $pageSegment == 'work-status' || $pageSegment == 'office-location') ? '' : 'collapsed') ?> <?= (($pageSegment == 'effort-type' || $pageSegment == 'project-status' || $pageSegment == 'role-master' || $pageSegment == 'department' || $pageSegment == 'work-status' || $pageSegment == 'office-location') ? 'active' : '') ?>"
          href="javascript:void(0)">
          <span class="link_name">Masters</span>
        </a>
      </li>
      <?php if(checkModuleAccess(16)){ ?>
      <li>
        <a class="<?= (($pageSegment == 'effort-type') ? 'active' : '') ?>"
          href="<?= base_url('admin/effort-type/list') ?>">
          <i class="fa fa-arrow-right"></i><span>Effort Type</span>
        </a>
      </li>
      <?php } ?>
      <?php if(checkModuleAccess(17)){ ?>
      <li>
        <a class="<?= (($pageSegment == 'project-status') ? 'active' : '') ?>"
          href="<?= base_url('admin/project-status/list') ?>">
          <i class="fa fa-arrow-right"></i><span>Project Status</span>
        </a>
      </li>
      <?php } ?>

      <?php if(checkModuleAccess(29)){ ?>
      <li>
        <a class="<?= (($pageSegment == 'department') ? 'active' : '') ?>"
          href="<?= base_url('admin/department/list') ?>">
          <i class="fa fa-arrow-right"></i><span>Departments</span>
        </a>
      </li>
      <?php } ?>

      <?php if(checkModuleAccess(30)){ ?>
      <li>
        <a class="<?= (($pageSegment == 'work-status') ? 'active' : '') ?>"
          href="<?= base_url('admin/work-status/list') ?>">
          <i class="fa fa-arrow-right"></i><span>Work Status</span>
        </a>
      </li>      
      <li>
        <a class="<?= (($pageSegment == 'holiday-list') ? 'active' : '') ?>"
          href="<?= base_url('admin/holiday-list') ?>">
          <i class="fa fa-arrow-right"></i><span>Holiday List</span>
        </a>
      </li>
      <?php } ?>
      <?php if(checkModuleAccess(30)){ ?>
      <li>
        <a class="<?= (($pageSegment == 'office-location') ? 'active' : '') ?>"
          href="<?= base_url('admin/office-location/list') ?>">
          <i class="fa fa-arrow-right"></i><span>Office Locations</span>
        </a>
      </li>
      <?php } ?>
    </ul>
  </li>
  <?php } ?>

  <?php if($userType == 'ADMIN'){ ?>   
    <!-- <li>
        <a class="">
        <i class="fas fa-money-check"></i>
        <span class="link_name">Add Expenses</span>
        </a>
        <ul class="sub-menu blank">
          
        </ul>
    </li> -->
  <?php } ?>  

  

  <?php //if (checkModuleAccess(11)) { ?>
    <?php if ($userType == 'SUPER ADMIN' || $userType == 'ADMIN') { ?>
        <li>
          <div class="iocn-link">
            <a class="<?= (($pageSegment == 'settings') ? '' : 'collapsed') ?> <?= (($pageSegment == 'settings') ? 'active' : '') ?>" href="javascript:void(0)">
              <i class="fa fa-gear"></i>
              <span class="link_name">Settings</span>
              <i class='bx bxs-chevron-down arrow ms-auto'></i>
            </a>
          </div>            
            <ul class="sub-menu">
            <li>
                <a class="<?= (($pageSegment == 'settings') ? 'active' : '') ?>" href="javascript:void(0)">
                  <span class="link_name">All Settings</span>
                </a>        
              </li> 
              <li>
                <a class="<?= (($pageSegment == 'settings') ? 'active' : '') ?>" href="<?= base_url('admin/settings') ?>">
                  <i class="fa fa-arrow-right"></i>
                  <span>General Settings</span>
                </a>        
              </li>                       
              <li>
                <a class="<?= (($pageSegment == 'mobile-application') ? 'active' : '') ?>" href="<?= base_url('admin/mobile-application') ?>">
                  <i class="fa fa-arrow-right"></i>
                  <span>Mobile Application</span>
                </a>        
              </li>
              <li>
                <a class="<?= (($pageSegment == 'delete-account-request') ? 'active' : '') ?>" href="<?= base_url('admin/delete-account-request/list') ?>">
                  <i class="fa fa-arrow-right"></i>
                  <span>Delete Account Requests</span>
                </a>        
              </li>
            </ul>
        </li>        
  <?php } ?>
</ul>