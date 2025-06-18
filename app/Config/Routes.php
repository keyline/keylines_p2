<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/enquiry-request/(:any)', 'Home::enquiryRequest/$1');
$routes->get('/delete-account-request', 'Home::deleteAccountRequest');
$routes->post('/delete-account-request', 'Home::deleteAccountRequest');
$routes->post('/get-email-otp', 'Home::getEmailOTP');
$routes->post('/get-phone-otp', 'Home::getPhoneOTP');
$routes->get('/daily-tracker-fillup-report', 'Home::dailyTrackerFillupReport');
$routes->get('/daily-desklog-report', 'Home::dailyDesklogReport');
$routes->match(['get'], "/fetch-desklog-report", "Home::fetchDesklogReport");

$routes->get('/client-details', 'Home::clientDetails');
$routes->post('/client-details', 'Home::clientDetails');
$routes->get('/countryInfoJSON', 'Home::countryDetailsProxy');
$routes->get('/stateInfoJSON', 'Home::stateDetailsProxy');
$routes->get('/cityInfoJSON', 'Home::cityDetailsProxy');
$routes->post('/client-Details-Data', 'Home::clientDetailsData/');

/* ADMIN PANEL */
$routes->group("admin", ["namespace" => "App\Controllers\Admin"], function ($routes) {
	// authentication
	$routes->match(['get', 'post'], "/", "User::login");
	$routes->match(['get', 'post'], "signout", "User::signout");
	$routes->match(['get', 'post'], "forgot-password", "User::forgotPassword");
	$routes->match(['get', 'post'], "verify-otp/(:any)", "User::verifyOtp/$1");
	$routes->match(['get', 'post'], "reset-password/(:any)", "User::resetPassword/$1");
	// authentication
	//	access & permission
	$routes->match(['get', 'post'], "manage_functionlist", "Manage_functionlist::index");
	$routes->match(['get', 'post'], "manage_functionlist/add", "Manage_functionlist::add");
	$routes->match(['get', 'post'], "manage_functionlist/edit/(:any)", "Manage_functionlist::edit/$1");
	$routes->match(['get', 'post'], "manage_functionlist/delete/(:any)", "Manage_functionlist::confirm_delete/$1");

	$routes->match(['get', 'post'], "manage_modulelist", "Manage_modulelist::index");
	$routes->match(['get', 'post'], "manage_modulelist/add", "Manage_modulelist::add");
	$routes->match(['get', 'post'], "manage_modulelist/edit/(:any)", "Manage_modulelist::edit/$1");
	$routes->match(['get', 'post'], "manage_modulelist/view/(:any)", "Manage_modulelist::view/$1");
	$routes->match(['get', 'post'], "manage_roles", "Manage_roles::index");

	$routes->match(['get', 'post'], "manage_roles", "Manage_roles::index");
	$routes->match(['get', 'post'], "manage_roles/add", "Manage_roles::add");
	$routes->match(['get', 'post'], "manage_roles/edit/(:any)", "Manage_roles::edit/$1");
	$routes->match(['get', 'post'], "manage_roles/view/(:any)", "Manage_roles::view/$1");
	$routes->match(['get', 'post'], "manage_roles/active/(:any)", "Manage_roles::active/$1");
	$routes->match(['get', 'post'], "manage_roles/deactive/(:any)", "Manage_roles::deactive/$1");
	//  access & permission
	// dashboard
	$routes->match(['get', 'post'], "dashboard", "User::dashboard");
	$routes->match(['get', 'post'], "dayWiseListRecords", "User::dayWiseListRecords");
	$routes->match(['get', 'post'], "PunchInRecords", "User::PunchInRecords");
	$routes->match(['get', 'post'], "PunchOutRecords", "User::PunchOutRecords");
	$routes->match(['get', 'post'], "email-logs", "User::emailLogs");
	$routes->match(['get', 'post'], "email-logs-details/(:any)", "User::emailLogsDetails/$1");
	$routes->match(['get', 'post'], "login-logs", "User::loginLogs");
	$routes->match(['get', 'post'], "save-task", "User::Savetask");
	// dashboard
	// settings
	$routes->match(['get', 'post'], "settings", "User::settings");
	$routes->match(['post'], "profile-settings", "User::profileSetting");
	$routes->match(['post'], "general-settings", "User::generalSetting");
	$routes->match(['post'], "application-settings", "User::applicationSetting");
	$routes->match(['post'], "change-password", "User::changePassword");
	$routes->match(['post'], "email-settings", "User::emailSetting");
	$routes->match(['post'], "sms-settings", "User::smsSetting");
	$routes->match(['post'], "footer-settings", "User::footerSetting");
	$routes->match(['post'], "seo-settings", "User::seoSetting");
	$routes->match(['post'], "payment-settings", "User::paymentSetting");
	$routes->match(['post'], "bank-settings", "User::bankSetting");
	$routes->match(['get', 'post'], "test-email", "User::testEmail");
	$routes->get('test-sms/(:num)', 'User::testSmS/$1');
	// settings
	// master
	/* effort type */
	$routes->match(['get'], "effort-type/list", "EffortTypeController::list");
	$routes->match(['get', 'post'], "effort-type/add", "EffortTypeController::add");
	$routes->match(['get', 'post'], "effort-type/edit/(:any)", "EffortTypeController::edit/$1");
	$routes->match(['get', 'post'], "effort-type/delete/(:any)", "EffortTypeController::confirm_delete/$1");
	$routes->match(['get', 'post'], "effort-type/change-status/(:any)", "EffortTypeController::change_status/$1");
	/* effort type */
	/*role master */
	$routes->match(['get'], "role-master/list", "RoleMasterController::list");
	$routes->match(['get', 'post'], "role-master/add", "RoleMasterController::add");
	/*role master */
	/* project status */
	$routes->match(['get'], "project-status/list", "ProjectStatusController::list");
	$routes->match(['get', 'post'], "project-status/add", "ProjectStatusController::add");
	$routes->match(['get', 'post'], "project-status/edit/(:any)", "ProjectStatusController::edit/$1");
	$routes->match(['get', 'post'], "project-status/delete/(:any)", "ProjectStatusController::confirm_delete/$1");
	$routes->match(['get', 'post'], "project-status/change-status/(:any)", "ProjectStatusController::change_status/$1");
	$routes->match(['get', 'post'], "projects/reports/(:any)", "ProjectController::reports/$1");
	/* project status */
	/* department */
	$routes->match(['get'], "department/list", "DepartmentController::list");
	$routes->match(['get', 'post'], "department/add", "DepartmentController::add");
	$routes->match(['get', 'post'], "department/edit/(:any)", "DepartmentController::edit/$1");
	$routes->match(['get', 'post'], "department/delete/(:any)", "DepartmentController::confirm_delete/$1");
	$routes->match(['get', 'post'], "department/change-status/(:any)", "DepartmentController::change_status/$1");
	/* department */
	/* work status */
	$routes->match(['get'], "work-status/list", "WorkStatusController::list");
	$routes->match(['get', 'post'], "work-status/add", "WorkStatusController::add");
	$routes->match(['get', 'post'], "work-status/edit/(:any)", "WorkStatusController::edit/$1");
	$routes->match(['get', 'post'], "work-status/delete/(:any)", "WorkStatusController::confirm_delete/$1");
	$routes->match(['get', 'post'], "work-status/change-status/(:any)", "WorkStatusController::change_status/$1");
	/* work status */
	/* office location */
	$routes->match(['get'], "office-location/list", "OfficeLocationController::list");
	$routes->match(['get', 'post'], "office-location/add", "OfficeLocationController::add");
	$routes->match(['get', 'post'], "office-location/edit/(:any)", "OfficeLocationController::edit/$1");
	$routes->match(['get', 'post'], "office-location/delete/(:any)", "OfficeLocationController::confirm_delete/$1");
	$routes->match(['get', 'post'], "office-location/change-status/(:any)", "OfficeLocationController::change_status/$1");
	/* office location */
	// master
	/* projects */
	$routes->match(['get', 'post'], "projects/list", "ProjectController::list");
	$routes->match(['get', 'post'], "projects/add", "ProjectController::add");
	$routes->match(['get', 'post'], "projects/edit/(:any)", "ProjectController::edit/$1");
	$routes->match(['get', 'post'], "projects/delete/(:any)", "ProjectController::confirm_delete/$1");
	$routes->match(['get', 'post'], "projects/change-status/(:any)", "ProjectController::change_status/$1");
	$routes->match(['get', 'post'], "projects/project-effort-list/(:any)", "ProjectController::projectEffortList/$1");
	$routes->match(['get', 'post'], "projects/active-project/", "ProjectController::activeProject");
	$routes->match(['get', 'post'], "projects/inactive-project/", "ProjectController::InactiveProject");

	/* projects */
	/* clients */
	$routes->match(['get'], "clients/list", "ClientController::list");
	$routes->match(['get', 'post'], "clients/add", "ClientController::add");
	$routes->match(['get', 'post'], "clients/edit/(:any)", "ClientController::edit/$1");
	$routes->match(['get', 'post'], "clients/delete/(:any)", "ClientController::confirm_delete/$1");
	$routes->match(['get', 'post'], "clients/change-status/(:any)", "ClientController::change_status/$1");
	$routes->match(['get', 'post'], "clients/project-effort-list/(:any)", "ClientController::projectEffortList/$1");
	$routes->match(['get', 'post'], "clients/encrypt-info", "ClientController::encryptInfo");

	$routes->match(['get', 'post'], "clients/add-project/(:any)", "ClientController::addProject/$1");

	$routes->match(['get', 'post'], "clients/add-proposal/(:any)", "ClientController::addProposal/$1");
	$routes->match(['get', 'post'], "clients/view-proposal/(:any)", "ClientController::viewProposal/$1");
	$routes->match(['get', 'post'], "clients/edit-proposal/(:any)", "ClientController::editProposal/$1");
	$routes->match(['get', 'post'], "clients/delete-proposal/(:any)", "ClientController::deleteProposal/$1");
	/* clients */
	//AMC Checking//
	$routes->match(['get', 'post'], "amc-checking", "AmcCheckingController::list");
	$routes->match(['get', 'post'], "amc-checking/ok_status/(:any)", "AmcCheckingController::ok_status/$1");
	//AMC Checking//
	//outside project cost//
	$routes->match(['get', 'post'], "outside_project/project_name", "OutsideProjectCostController::list");
	$routes->match(['get', 'post'], "outside_project/showexsisting", "OutsideProjectCostController::showexsisting");
	//outside project cost//


	// task assign
	$routes->match(['get', 'post'], "task-assign", "TaskAssignController::task_list");
	$routes->match(['post'], "task-assign/morning-meeting-schedule-submit", "TaskAssignController::morning_meeting_schedule_submit");
	$routes->match(['post'], "task-assign/morning-meeting-schedule-prefill", "TaskAssignController::morning_meeting_schedule_prefill");
	$routes->match(['post'], "task-assign/morning-meeting-schedule-prefill-effort-booking", "TaskAssignController::morning_meeting_schedule_prefill_effort_booking");
	$routes->match(['post'], "task-assign/morning-meeting-schedule-update", "TaskAssignController::morning_meeting_schedule_update");
	$routes->match(['post'], "task-assign/morning-meeting-effort-booking", "TaskAssignController::morning_meeting_effort_booking");
	$routes->match(['post'], "task-assign/morning-meeting-schedule-approve-task", "TaskAssignController::morning_meeting_schedule_approve_task");
	$routes->match(['post'], "task-assign/morning-meeting-reschedule-task", "TaskAssignController::morning_meeting_reschedule_task");
	$routes->match(['post'], "task-assign/morning-meeting-get-previous-task", "TaskAssignController::morning_meeting_get_previous_task");

	$routes->match(['get'], "task-assign-v2", "TaskAssignController::task_listv2");
	// task assign

	/* users */
	$routes->match(['get'], "users/list", "UserController::list");
	$routes->match(['get', 'post'], "user_cost/list", "UserController::usercostlist");
	$routes->match(['get'], "users/DeactivateUserlist", "UserController::DeactivateUserlist");
	$routes->match(['get', 'post'], "users/add", "UserController::add");
	$routes->match(['get', 'post'], "users/edit/(:any)", "UserController::edit/$1");
	$routes->match(['get', 'post'], "users/delete/(:any)", "UserController::confirm_delete/$1");
	$routes->match(['get', 'post'], "users/change-status/(:any)", "UserController::change_status/$1");
	$routes->match(['get', 'post'], "users/change-tracker-status/(:any)", "UserController::change_tracker_status/$1");
	$routes->match(['get', 'post'], "users/change-salarybox-status/(:any)", "UserController::change_salarybox_status/$1");
	$routes->match(['get', 'post'], "users/send-credentials/(:any)", "UserController::sendCredentials/$1");
	/* users */
	/* team */
	$routes->match(['get', 'post'], "team/list", "TeamController::list");
	$routes->match(['get', 'post'], "team/add", "TeamController::add");
	$routes->match(['get', 'post'], "team/edit/(:any)", "TeamController::edit/$1");
	$routes->match(['get', 'post'], "team/delete/(:any)", "TeamController::confirm_delete/$1");
	$routes->match(['get', 'post'], "team/change-status/(:any)", "TeamController::change_status/$1");
	$routes->match(['get', 'post'], "team/change-tracker-status/(:any)", "TeamController::change_tracker_status/$1");
	$routes->match(['get', 'post'], "team/change-salarybox-status/(:any)", "TeamController::change_salarybox_status/$1");
	$routes->match(['get', 'post'], "team/send-credentials/(:any)", "TeamController::sendCredentials/$1");
	/* team */
	// effort
	$routes->match(['get'], "efforts/list", "EffortController::list");
	$routes->match(['get', 'post'], "efforts/addBackup", "EffortController::addBackup");
	$routes->match(['get', 'post'], "efforts/effort-success", "EffortController::effortSuccess");
	$routes->match(['get', 'post'], "efforts/edit/(:any)", "EffortController::edit/$1");
	$routes->match(['get', 'post'], "efforts/view/(:any)", "EffortController::view/$1");
	$routes->match(['get', 'post'], "efforts/delete/(:any)", "EffortController::confirm_delete/$1");
	$routes->match(['get', 'post'], "efforts/change-status/(:any)", "EffortController::change_status/$1");
	$routes->match(['get', 'post'], "efforts/get-project-info", "EffortController::getProjectInfo");
	$routes->match(['get', 'post'], "efforts/request-previous-task-submit/(:any)", "EffortController::requestPreviousTaskSubmit/$1");
	// effort
	// hour_cost
	$routes->match(['get', 'post'], "user-cost", "CostController::usercost");
	// hour_cost
	// project_cost
	$routes->match(['get', 'post'], "project-cost", "CostController::projectcost");
	// project_cost
	// report			
	$routes->match(['get', 'post'], "reports/advance-search", "ReportController::advanceSearch");
	$routes->match(['get', 'post'], "reports/effort-report", "ReportController::effortType");
	$routes->match(['get', 'post'], "reports/project-report", "ReportController::projectReport");
	$routes->match(['get', 'post'], "reports/viewMonthlyProjectReport/(:any)/(:any)/(:any)", "ReportController::viewMonthlyProjectReport/$1/$2/$3");
	$routes->match(['get', 'post'], "reports/hours-report", "ReportController::hoursReport");
	$routes->match(['get', 'post'], "reports/dayWiseListUpdate", "ReportController::dayWiseListUpdate");
	$routes->match(['get', 'post'], "reports/showWorkList", "ReportController::showWorkList");
	$routes->match(['get', 'post'], "reports/fetchData", "ReportController::fetchData");
	$routes->match(['get', 'post'], "reports/get-desklog-report", "ReportController::desklogReport");
	$routes->match(['get', 'post'], "reports/desklog-report-view", "ReportController::show");

	// report
	// attendance
	$routes->match(['get', 'post'], "attendance-report", "AttendanceController::attendance");
	$routes->match(['get', 'post'], "save-attendance", "AttendanceController::SaveAttendance");	
	// $routes->match(['get', 'post'], "monthly-attendance-report", "AttendanceController::monthlyAttendance");
	$routes->match(['get', 'post'], "PunchOutRecords", "AttendanceController::PunchOutRecords");
	$routes->match(['get', 'post'], "PunchOutRecords", "AttendanceController::PunchOutRecords");
	// attendance

	// holiday
	$routes->match(['get', 'post'], "holiday-list", "HolidayController::fetchHolidays");
	$routes->match(['get'], "holiday-list-api", "HolidayController::Holidaylistapi");
	$routes->match(['get'], "weekoff-list-api", "HolidayController::Weekofflistapi");
	$routes->match(['get', 'post'], "holiday-list-add", "HolidayController::addHoliday");
	$routes->match(['get', 'post'], "holiday-list/edit/(:any)", "HolidayController::editHoliday/$1");
	$routes->match(['get', 'post'], "holiday-list/delete/(:any)", "HolidayController::confirm_delete/$1");
	// holiday

	// mobile-application
	$routes->match(['get'], "mobile-application", "MobileController::show");
	// $routes->match(['get'], "holiday-list-api", "HolidayController::Holidaylistapi");
	// $routes->match(['get', 'post'], "holiday-list-add", "HolidayController::addHoliday");
	// $routes->match(['get', 'post'], "holiday-list/edit/(:any)", "HolidayController::editHoliday/$1");
	// $routes->match(['get', 'post'], "holiday-list/delete/(:any)", "HolidayController::confirm_delete/$1");
	// mobile-application

	// delete account requests
	$routes->match(['get'], "delete-account-request/list", "DeleteAccountRequestController::list");
	$routes->match(['get', 'post'], "delete-account-request/delete/(:any)", "DeleteAccountRequestController::confirm_delete/$1");
	$routes->match(['get', 'post'], "delete-account-request/change-status/(:any)", "DeleteAccountRequestController::change_status/$1");
	// delete account requests
	// notifications
	$routes->match(['get'], "notifications/list", "NotificationController::list");
	$routes->match(['get', 'post'], "notifications/add", "NotificationController::add");
	$routes->match(['get', 'post'], "notifications/edit/(:any)", "NotificationController::edit/$1");
	$routes->match(['get', 'post'], "notifications/delete/(:any)", "NotificationController::confirm_delete/$1");
	$routes->match(['get', 'post'], "notifications/change-status/(:any)", "NotificationController::change_status/$1");
	$routes->match(['get', 'post'], "notifications/send/(:any)", "NotificationController::send/$1");
	$routes->match(['get'], "notifications/list_from_app", "NotificationController::list_from_app");
	// notifications

	// screenshots settings
	$routes->match(['get', 'post'], "screenshot-settings", "ScreenshotSettingsController::index");
	$routes->get('user/screenshots/(:any)', 'ScreenshotSettingsController::screenshotList/$1');
});
/* ADMIN PANEL */
/* API */
$routes->group("api", ["namespace" => "App\Controllers\Api"], function ($routes) {
	//notification
	$routes->match(['get'], "mobile-notification", "ApiController::testnotification");
	// before login
	$routes->match(['post'], "get-app-setting", "ApiController::getAppSetting");
	$routes->match(['post'], "get-static-pages", "ApiController::getStaticPages");
	// before login
	// authentication
	$routes->match(['post'], "forgot-password", "ApiController::forgotPassword");
	$routes->match(['post'], "validate-otp", "ApiController::validateOTP");
	$routes->match(['post'], "resend-otp", "ApiController::resendOtp");
	$routes->match(['post'], "reset-password", "ApiController::resetPassword");

	$routes->match(['post'], "signin", "ApiController::signin");
	$routes->match(['post'], "signin-with-mobile", "ApiController::signinWithMobile");
	$routes->match(['post'], "signin-validate-mobile", "ApiController::signinValidateMobile");
	// authentication
	// after login
	$routes->match(['post'], "signout", "ApiController::signout");
	$routes->match(['post'], "change-password", "ApiController::changePassword");
	$routes->match(['post'], "get-profile", "ApiController::getProfile");
	$routes->match(['post'], "update-profile", "ApiController::updateProfile");
	$routes->match(['post'], "send-email-otp", "ApiController::sendEmailOTP");
	$routes->match(['post'], "verify-email", "ApiController::verifyEmail");
	$routes->match(['post'], "send-mobile-otp", "ApiController::sendMobileOTP");
	$routes->match(['post'], "verify-mobile", "ApiController::verifyMobile");
	$routes->match(['post'], "delete-account", "ApiController::deleteAccount");
	$routes->match(['post'], "update-profile-image", "ApiController::updateProfileImage");
	$routes->match(['post'], "get-holiday", "ApiController::getHoliday");
	$routes->match(['get'], "get-employee", "ApiController::getEmployee");
	$routes->match(['post'], "get-geolocation-distance", "ApiController::getGeolocationDistance");
	$routes->match(['post'], "mark-attendance", "ApiController::markAttendance");
	$routes->match(['post'], "get-month-attendance", "ApiController::getMonthAttendance");
	$routes->match(['post'], "get-month-attendance-new", "ApiController::getMonthAttendanceNew");
	$routes->match(['post'], "get-single-attendance", "ApiController::getSingleAttendance");
	$routes->match(['post'], "get-single-attendance-new", "ApiController::getSingleAttendanceNew");

	$routes->match(['post'], "get-notifications", "ApiController::getNotifications");
	$routes->match(['post'], "get-notes", "ApiController::getNotes");
	$routes->match(['post'], "update-note", "ApiController::updateNote");
	$routes->match(['get'], "get-project", "ApiController::getProject");
	$routes->match(['post'], "add-task", "ApiController::addTask");
	$routes->match(['post'], "edit-task", "ApiController::editTask");
	$routes->match(['post'], "get-tasks", "ApiController::getTasks");
	$routes->match(['post'], "get-tasks-new", "ApiController::getTasksNew");
	// after login


	//_______ screenshots api before login_______
	// user authentication check:
	$routes->post('screenshot/auth', 'Screenshots\ScreenshotsUploadController::authCheck');
	// Base64‐only endpoint:
	$routes->post('screenshot/base64', 'Screenshots\ScreenshotsUploadController::uploadBase64');
	// multipart/form‐data (file)‐only endpoint:
	$routes->post('screenshot/upload', 'Screenshots\ScreenshotsUploadController::uploadFile');
	// screenshot settings:
	$routes->post('screenshot/settings', 'Screenshots\ScreenshotsUploadController::settings');
	// list endpoint for both Base64 and file uploads:
	$routes->get('screenshot/list', 'Screenshots\ScreenshotsUploadController::list');
});
/* API */