<?php
$baseUrl    = base_url();
if($baseUrl == 'https://tracker2.keylines.net/'){
    $currentLink    = current_url();
    $uri            = new \CodeIgniter\HTTP\URI($currentLink);
    $pageSegment    = $uri->getSegment(2);
} else {
    $currentLink    = current_url();
    $uri            = new \CodeIgniter\HTTP\URI($currentLink);
    $pageSegment    = $uri->getSegment(3);
}
// echo $pageSegment;die;
$paramerId = '';
if($baseUrl == 'https://tracker2.keylines.net/'){
    $segmentCount = $uri->getTotalSegments();
    if($segmentCount > 2){
        $paramerId = $uri->getSegment(3);
    } else {
        $paramerId = '';
    }
} else {
    $segmentCount = $uri->getTotalSegments();
    if($segmentCount > 3){
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
<ul class="sidebar-nav" id="sidebar-nav">
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'dashboard')?'active':'')?>" href="<?=base_url('admin/dashboard')?>">
                <i class="fa fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <?php if($userType == 'admin'){ ?>
            <li class="nav-item">
                <a class="nav-link" data-bs-target="#access-nav" data-bs-toggle="collapse" href="#">
                    <i class="fas fa-key"></i><span>Access & Permission</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="access-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="" href="<?=base_url('admin/manage_functionlist')?>">
                            <i class="fa fa-arrow-right"></i><span>Functions</span>
                        </a>
                    </li>
                    <li>
                        <a class="" href="<?=base_url('admin/manage_modulelist')?>">
                            <i class="fa fa-arrow-right"></i><span>Modules</span>
                        </a>
                    </li>
                    <li>
                        <a class="" href="<?=base_url('admin/manage_roles')?>">
                            <i class="fa fa-arrow-right"></i><span>Role</span>
                        </a>
                    </li>
                </ul>
            </li>
        <?php } ?>
        <?php if($userType == 'admin'){?>
            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'effort-type' || $pageSegment == 'project-status')?'':'collapsed')?> <?=(($pageSegment == 'effort-type' || $pageSegment == 'project-status')?'active':'')?>" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa fa-database"></i><span>Masters</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="master-nav" class="nav-content collapse <?=(($pageSegment == 'effort-type' || $pageSegment == 'project-status')?'show':'')?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="<?=(($pageSegment == 'effort-type')?'active':'')?>" href="<?=base_url('admin/effort-type/list')?>">
                            <i class="fa fa-arrow-right"></i><span>Effort Type</span>
                        </a>
                    </li>
                    <li>
                        <a class="<?=(($pageSegment == 'project-status')?'active':'')?>" href="<?=base_url('admin/project-status/list')?>">
                            <i class="fa fa-arrow-right"></i><span>Project Status</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'users')?'active':'')?>" href="<?=base_url('admin/users/list')?>">
                    <i class="fa fa-users"></i>
                    <span>Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'team')?'active':'')?>" href="<?=base_url('admin/team/list')?>">
                    <i class="fa fa-users"></i>
                    <span>Team</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'projects')?'active':'')?>" href="<?=base_url('admin/projects/list')?>">
                    <i class="fas fa-project-diagram"></i>
                    <span>Projects</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'clients')?'active':'')?>" href="<?=base_url('admin/clients/list')?>">
                    <i class="fas fa-industry"></i>
                    <span>Clients</span>
                </a>
            </li>

        <?php }?>
        <?php if($userType != 'client'){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'efforts')?'':'collapsed')?> <?=(($pageSegment == 'efforts')?'active':'')?>" data-bs-target="#notification-nav" data-bs-toggle="collapse" href="#">
                <i class="fa fa-tasks"></i><span>Effort Booking</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="notification-nav" class="nav-content collapse <?=(($pageSegment == 'efforts')?'show':'')?>" data-bs-parent="#sidebar-nav">
                <?php if($admin->is_tracker_user){?>
                    <li>
                        <a class="<?=(($pageSegment == 'efforts' && $paramerId == 'add')?'active':'')?>" href="<?=base_url('admin/efforts/add')?>">
                            <i class="fa fa-arrow-right"></i><span>Add My Effort</span>
                        </a>
                    </li>
                <?php }?>
                <li>
                    <a class="<?=(($pageSegment == 'efforts' && $paramerId == 'list')?'active':'')?>" href="<?=base_url('admin/efforts/list')?>">
                        <i class="fa fa-arrow-right"></i><span>My History</span>
                    </a>
                </li>
            </ul>
        </li>
        <?php }?>
    <?php if($userType == 'admin' || $userType == 'client'){?>
        <!-- <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'notifications' || $pageSegment == 'notifications')?'':'collapsed')?> <?=(($pageSegment == 'notifications' || $pageSegment == 'notifications')?'active':'')?>" data-bs-target="#notification-nav" data-bs-toggle="collapse" href="#">
                <i class="fa fa-bell"></i><span>Notifications</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="notification-nav" class="nav-content collapse <?=(($pageSegment == 'notifications' || $pageSegment == 'notifications')?'show':'')?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="<?=(($pageSegment == 'notifications')?'active':'')?>" href="<?=base_url('admin/notifications/list')?>">
                        <i class="fa fa-arrow-right"></i><span>From Admin</span>
                    </a>
                </li>
                <li>
                    <a class="<?=(($pageSegment == 'notifications')?'active':'')?>" href="<?=base_url('admin/notifications/list_from_app')?>">
                        <i class="fa fa-arrow-right"></i><span>From App</span>
                    </a>
                </li>
            </ul>
        </li> -->
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'reports')?'':'collapsed')?> <?=(($pageSegment == 'reports')?'active':'')?>" data-bs-target="#report-nav" data-bs-toggle="collapse" href="#">
                <i class="fa fa-tasks"></i><span>Reports</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="report-nav" class="nav-content collapse <?=(($pageSegment == 'reports')?'show':'')?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="<?=(($pageSegment == 'reports' && $paramerId == 'advance-search')?'active':'')?>" href="<?=base_url('admin/reports/advance-search')?>">
                        <i class="fa fa-arrow-right"></i><span>Advance Search</span>
                    </a>
                </li>
                <?php if($userType == 'admin'){?>
                <li>
                    <a class="<?=(($pageSegment == 'reports' && $paramerId == 'effort-report')?'active':'')?>" href="<?=base_url('admin/reports/effort-report')?>">
                        <i class="fa fa-arrow-right"></i><span>Effort Report</span>
                    </a>
                </li>                
                <li>
                    <a class="<?=(($pageSegment == 'reports' && $paramerId == 'hours-report')?'active':'')?>" href="<?=base_url('admin/reports/hours-report')?>">
                        <i class="fa fa-arrow-right"></i><span>Project Effort</span>
                    </a>
                </li>
                <li>
                    <a class="<?=(($pageSegment == 'reports' && $paramerId == 'project-report')?'active':'')?>" href="<?=base_url('admin/reports/project-report')?>">
                        <i class="fa fa-arrow-right"></i><span>Project Hourly Report</span>
                    </a>
                </li>
                <li>
                    <a class="<?=(($pageSegment == 'reports' && $paramerId == 'desklog-report-view')?'active':'')?>" href="<?=base_url('admin/reports/desklog-report-view')?>">
                        <i class="fa fa-arrow-right"></i><span>Desklog Report</span>
                    </a>
                </li>
                <?php } ?>
            </ul>
        </li>
        <?php if($userType == 'admin'){?>
            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'attendance-report')?'active':'')?>" href="<?=base_url('admin/attendance-report')?>">
                    <i class="fa fa-user"></i>
                    <span>Attendance</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'delete-account-request')?'active':'')?>" href="<?=base_url('admin/delete-account-request/list')?>">
                    <i class="fa fa-trash"></i>
                    <span>Delete Account Requests</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'email-logs')?'active':'')?>" href="<?=base_url('admin/email-logs')?>">
                    <i class="fa fa-envelope"></i>
                    <span>Email Logs</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'login-logs')?'active':'')?>" href="<?=base_url('admin/login-logs')?>">
                    <i class="fa fa-list"></i>
                    <span>Login Logs</span>
                </a>
            </li>
        <?php }?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'settings')?'active':'')?>" href="<?=base_url('admin/settings')?>">
                <i class="fa fa-gear"></i>
                <span>Settings</span>
            </a>
        </li>
    <?php }?>
</ul>