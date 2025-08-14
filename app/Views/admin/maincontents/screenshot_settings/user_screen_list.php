<!-- lightbox CSS -->
<link href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" rel="stylesheet" />
<style>
    .appusage_top_view_sec {
        width: 100%;
        height: auto;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .appusage_top_timehour_graph {
        width: 100%;
        height: 100%;
        min-width: 230px;
        max-width: 230px;
        border-right: 1px dashed #e5e5e5;
        padding-bottom: 10px;
    }
    
    .grph-btm-details .text-center {
        margin: 0;
        width: 100%;
    }
    .grph-btm-details span {
        font-size: 14px;
    }
    .grph-btm-details h4 {
        font-size: 15px;
        color: #f4d41f;
    }
    .timeline_dv_center {
        width: 100%;
    }
    .admin-user-overview {
        margin: auto;
        width: 100%;
        text-align: center;
    }
    .admin-user-overview-col {
        display: inline-block;
        margin-right: 3%;
        margin-left: 3%;
        padding: 10px 0px;
        text-align: center;
    }
    .admin-user-overview-col .top-grid-title {
        font-size: 15px;
        margin-bottom: 4px;
        display: inline-block;
        width: 100%;
    }
    .down_arrow_tsk {
        display: inline-block;
        background-color: #FFDDDD;
        padding: 2px 5px;
        float: none !important;
        width: 20px !important;
        text-align: center;
        position: relative;
        top: -5px;
        border-radius: 5px;
        height: 25px;
        line-height: 13px;
    }
    .desklog-time-bar {
        position: relative;
        padding: 0px 0 5px;
        width: 100%;
    }
    .user_timeline_new_view {
        overflow: auto;
        margin: auto;
    }
    .user_timeline_new_time_line_srcl {
        width: 100%;
        white-space: nowrap;
        min-width: 800px;
    }
    .hourly_work_detail_appusage {
        width: 100%;
        height: auto;
        display: flex    ;
        background: linear-gradient(180deg, #F6F6F6 0%, rgba(235, 235, 235, 0.00) 100%);
        min-height: 40px;
        margin-top: 10px;
        gap: 3px;
    }
    .hourly_work_detail_appusage_timeatwork {
        width: auto;
        height: auto;
        display: inline-block;
        background: #f6f6f6;
        min-height: 40px;
        margin-bottom: 0;
        position: relative;
    }
    .hourly_work_detail_appusage_timeatwork::before {
        position: absolute;
        right: -4px;
        height: 100%;
        width: 4px;
        content: '';
        background-color: #fff;
        z-index: 8;
    }
    .hourly_time_work_productive_sec {
        width: 100%;
        height: 45px;
        display: flex;
        margin-bottom: 0;
        align-items: end;
        flex-direction: column;
        position: relative;
    }
    .hourly_time_work_timeatwork {
        height: 20px;
        width: 100%;
        background-color: #b7ca84;
        display: inline-block;
        position: absolute;
        left: 0;
        bottom: 0;
    }
    .hourly_time_work_productive {
        height: 20px;
        width: 100%;
        background-color: #81b504;
        display: inline-block;
        position: absolute;
        left: 0;
        bottom: 0;
    }
    .desklog-time-bar.admin-user-overview-time-bar .progress {
        height: 15px !important;
        border-radius: 0px !important;
    }
    .appusage_day_view_2 .progress {
        overflow: visible !important;
    }
    .desklog-time-bar .progress {
        display: -ms-flexbox;
        display: flex;
        font-size: .75rem;
    }
    .desklog-time-bar .progress {
        height: 50px;
        margin-bottom: 20px;
        overflow: hidden;
        background-color: #f5f5f5;
        border-radius: 0px;
        -webkit-box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, .1);
    }
    .desklog-time-bar.admin-user-overview-time-bar .project_progress {
        height: 10px !important;
        margin-bottom: 5px !important;
        margin-top: 2px !important;
    }
    .desklog-time-bar.admin-user-overview-time-bar .progress {
        margin-bottom: 0;
    }
    .desklog-time-bar.admin-user-overview-time-bar .progress {
        height: 15px !important;
        border-radius: 0px !important;
    }

    .appusage_day_view_2 .progress {
        overflow: visible !important;
    }
    .desklog-time-bar .progress-bar-dark {
        background-color: #e1e5e6;
        color: #e1e5e6;
    }
    #off_req {
        display: inline-block;
        position: relative;
        z-index: 1;
        padding: 0;
        margin: 0;
    }
    .total-time {
        display: inline-block;
        width: 100%;
    }
    .time-all {
        margin-bottom: 14px;
        display: flex;
        width: 100%;
    }
    .time-all li {
        flex: 3.9%;
    }
    .total-time li {
        list-style: none;
        position: relative;
        font-size: 12px;
    }
    .total-time li:before {
        position: absolute;
        content: "";
        width: 1px;
        height: 6px;
        background-color: #c5c5c5;
        top: -5px;
        left: 0px;
    }
 
    .admin-user-timeLlne .note-content ul{
        text-align: left;
        display: flex;
        justify-content: center;
    }
    .admin-user-timeLlne .note-content ul li {
        margin-right: 10px;
        font-size: 13px;
    }
    .green-dot {
        width: 13px;
        height: 13px;
        background-color: #a0c33f;
        display: inline-block;
        border-radius: 10px;
        margin-right: 5px;
    }
    span.red-dot {
        width: 13px;
        height: 13px;
        background-color: #eb4064;
        color: #eb4064;
        display: inline-block;
        border-radius: 10px;
        margin-right: 5px;
    }
    span.orenge-dot {
        width: 13px;
        height: 13px;
        background-color: #f4d41f;
        color: #f4d41f;
        display: inline-block;
        border-radius: 10px;
        margin-right: 5px;
    }
    span.light-orange-dot {
        width: 13px;
        height: 13px;
        background-color: #5cb85c;
        color: #5cb85c;
        display: inline-block;
        border-radius: 10px;
        margin-right: 5px;
    }
    .dark-dot {
        width: 13px;
        height: 13px;
        background-color: #d0d5d6;
        display: inline-block;
        border-radius: 10px;
        margin-right: 5px;
    }


</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="pagetitle">
                <h1><?= $page_header ?></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>

                        <li class="breadcrumb-item active"><?= $page_header ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- End Page Title -->
<section class="section profile">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <?php if (session('success_message')) { ?>
                    <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('success_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
                <?php if (session('error_message')) { ?>
                    <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                        <?= session('error_message') ?>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php } ?>
            </div>

            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">

                        <!-- ____ code ____ -->

                        <div class="container-fluid my-4">
                            <div class="row">
                                <div class="col-12">
                                    <div class="user_back_box user_back_box d-flex gap-2 mb-3">
                                        <a href="javascript:window.history.back()"><i class="fa-solid fa-arrow-left"></i></a>
                                        <h5><?= $user->name ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3">
                                <div class="co1-12">
                                    <form method="GET" action="" enctype="multipart/form-data">
                                        <input type="hidden" name="mode" value="search">
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-sm-8 col-lg-4" id="day_range_row">
                                                <div class="input-group input-daterange date_holder">
                                                    <!-- <label for="search_range_from">Date Range</label> -->
                                                    <input type="date" id="search_range_from" name="start" class="form-control" value="<?= $start_date ?>" style="height: 40px;">
                                                    <span class="input-group-text">To</span>
                                                    <input type="date" id="search_range_to" name="end" class="form-control" value="<?= $end_date ?>" style="height: 40px;">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 col-lg-4">
                                                <div class="text-left generate_btn">
                                                    <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Get Report</button>
                                                </div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                                <div class="col-12">
                                    <div class="appusage_top_view_sec">
                                        <div class="appusage_top_timehour_graph">
                                            <div id="work_graph_detail" class="grph-btm-details">
                                                <div id="screenshort_chart"></div>
                                                <div class="d-flex">
                                                    <div class="text-center">
                                                        <span class="block text">Idle</span>
                                                        <h4 class="font-weight-bolder m-t-none m-b-none text-primary-lt" id="total_idle_time">
                                                            <span class="timer" data-from="0" data-to="01h 09m"><strong>01h 09m</strong></span>
                                                        </h4>
                                                    </div>
                                                    <div class="text-center wrk_time_show">
                                                        <span class="block text"> Focus </span>
                                                        <h4 class="font-weight-bolder m-t-none m-b-none text-primary-lt" id="total_time_at_work">
                                                            <span class="timer" data-from="0" data-to="02h 15m"><strong>02h 15m</strong></span>
                                                        </h4>
                                                    </div>
                                                    <div class="text-center">
                                                        <span class="block text">Private</span>
                                                        <h4 class="font-weight-bolder m-t-none m-b-none text-primary-lt" id="total_private_time">
                                                            <span class="timer" data-from="0" data-to="00h 00m"><strong>00h 00m</strong></span>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    
                                        <div class="timeline_dv_center">
                                            <div class="admin-user-overview animated fadeInDown">
                                    
                                                <div class="admin-user-overview-col time_at_work">
                                                    <a>
                                                        <span class="top-grid-title">Time At Work</span>
                                                        <span class="top-grid-report block" style="color: #484848" id="work_time">02h 15m
                                                            <span class="down_arrow_tsk">
                                                                <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M3 9V7.8H6.954L0 0.846L0.846 -3.57628e-07L7.8 6.954V3H9V9H3Z" fill="#B60101"
                                                                        fill-opacity="0.54"></path>
                                                                </svg>
                                                            </span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="admin-user-overview-col clock_in">
                                                    <a>
                                                        <span class="top-grid-title">Clock In</span>
                                                        <div class="top-grid-report block"><span class="timer" id="arrival" data-from="0"
                                                                data-to="10:02 AM">10:02 AM</span></div>
                                                    </a>
                                                </div>
                                                <div class="admin-user-overview-col clock_out">
                                                    <a>
                                                        <span class="top-grid-title">Clock Out</span>
                                                        <span class="top-grid-report block"><span class="left" id="leave" data-from="0"
                                                                data-to="Online">Online</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                    
                                            <div class="over-flow appusage_day_view_2 ">
                                                <section class="desklog-time-bar admin-user-overview-time-bar">
                                                    <div class="user_timeline_new_view" style="width:100%;">
                                                        <div class="user_timeline_new_time_line_srcl">
                                                            <div class="hourly_work_detail_appusage">
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:70.583333333333%" class="hourly_time_work_timeatwork"
                                                                            data-toggle="popover" data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 42m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:100%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (01h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:80.027777777778%" class="hourly_time_work_timeatwork"
                                                                            data-toggle="popover" data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 48m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0.11111111111111%" class="hourly_time_work_timeatwork"
                                                                            data-toggle="popover" data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hourly_work_detail_appusage_timeatwork" style="width: 3.85%">
                                                                    <div class="hourly_time_work_productive_sec">
                                                                        <div style="height:0%" class="hourly_time_work_timeatwork" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Time at work (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                        <div style="height: 0%" class="hourly_time_work_productive" data-toggle="popover"
                                                                            data-placement="bottom" data-trigger="hover"
                                                                            data-content="Productive Time (00h 00m)" data-original-title="" title="">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="progress first_time_bar">
                                                                <div class="progress-bar progress-bar-dark" role="progressbar"
                                                                    style="width:41.830345258626%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="12:00:00 AM - 10:02:21 AM"
                                                                    data-original-title="Other Time (10h 02m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                                    style="width:0.0057871040174076%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="10:02:21 AM - 10:02:26 AM" data-html="true"
                                                                    data-original-title="Work (00h 00m)">
                                                                </div>
                                                                <div class="progress-bar progress-bar-danger" role="progressbar"
                                                                    style="width:0.0034722624104446%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="10:02:26 AM - 10:02:29 AM" data-html="true"
                                                                    data-original-title="Private (00h 00m)">
                                                                </div>
                                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                                    style="width:1.8912255928888%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="10:02:29 AM - 10:29:43 AM"
                                                                    data-original-title="Work (27m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                                                    style="width:0.20833574462667%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="10:29:43 AM - 10:32:43 AM"
                                                                    data-original-title="Idle (03m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                                    style="width:0.20833574462667%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="10:32:43 AM - 10:35:43 AM"
                                                                    data-original-title="Work (03m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                                                    style="width:0.41667148925335%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="10:35:43 AM - 10:41:43 AM"
                                                                    data-original-title="Idle (06m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                                    style="width:6.2489149179967%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="10:41:43 AM - 12:11:42 PM"
                                                                    data-original-title="Work (01h 29m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                                                    style="width:0.20833574462667%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="12:11:42 PM - 12:14:42 PM"
                                                                    data-original-title="Idle (03m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                                    style="width:0.0011574208034815%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="12:14:42 PM - 12:14:43 PM" data-html="true"
                                                                    data-original-title="Work (00h 00m)">
                                                                </div>
                                                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                                                    style="width:0.41667148925335%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="12:14:43 PM - 12:20:43 PM"
                                                                    data-original-title="Idle (06m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                                    style="width:2.7083646801468%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="12:20:43 PM - 12:59:43 PM"
                                                                    data-original-title="Work (39m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                                                    style="width:0.41667148925335%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="12:59:43 PM - 01:05:43 PM"
                                                                    data-original-title="Idle (06m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                                    style="width:0.20833574462667%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="01:05:43 PM - 01:08:43 PM"
                                                                    data-original-title="Work (03m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                                                    style="width:0.41667148925335%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="01:08:43 PM - 01:14:43 PM"
                                                                    data-original-title="Idle (06m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                                    style="width:0.20949316543016%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="01:14:43 PM - 01:17:44 PM"
                                                                    data-original-title="Work (03m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-warning" role="progressbar"
                                                                    style="width:0.41551406844987%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="01:17:44 PM - 01:23:43 PM"
                                                                    data-original-title="Idle (05m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-success" role="progressbar"
                                                                    style="width:0.20833574462667%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="01:23:43 PM - 01:26:43 PM"
                                                                    data-original-title="Work (03m)" data-html="true">
                                                                    <a id="off_req" href="javascript:void(0)">&nbsp;</a>
                                                                </div>
                                                                <div class="progress-bar progress-bar-dark" role="progressbar"
                                                                    style="width:43.977360849084%" data-toggle="popover" data-placement="top"
                                                                    data-trigger="hover" data-content="01:26:43 PM - 11:59:59 PM" data-html="true"
                                                                    data-original-title="Other Time (10h 33m)">
                                                                </div>
                                                            </div>
                                    
                                    
                                                            <div class="progress project_progress usr_task_view">
                                                                <div class="progress-bar progress-bar-dark" role="progressbar" style="width:100%"
                                                                    data-toggle="popover" data-placement="top" data-trigger="hover"
                                                                    data-content="12:00:00 AM - 11:59:59 PM" data-original-title="Free time">
                                                                    <a id="task_req" href="javascript:void(0)"
                                                                        onclick="openTaskRequest('Asia/Kolkata', '14-08-2025', '00:00:00', '23:59:59', '', '', '', '', '')">&nbsp;</a>
                                                                </div>
                                                            </div>
                                    
                                                            <div class="total-time">
                                                                <div class="time-all">
                                                                    <li>12 AM</li>
                                                                    <li>1 AM</li>
                                                                    <li>2 AM</li>
                                                                    <li>3 AM</li>
                                                                    <li>4 AM</li>
                                                                    <li>5 AM</li>
                                                                    <li>6 AM</li>
                                                                    <li>7 AM</li>
                                                                    <li>8 AM</li>
                                                                    <li>9 AM</li>
                                                                    <li>10 AM</li>
                                                                    <li>11 AM</li>
                                                                    <li>12 PM</li>
                                                                    <li>1 PM</li>
                                                                    <li>2 PM</li>
                                                                    <li>3 PM</li>
                                                                    <li>4 PM</li>
                                                                    <li>5 PM</li>
                                                                    <li>6 PM</li>
                                                                    <li>7 PM</li>
                                                                    <li>8 PM</li>
                                                                    <li>9 PM</li>
                                                                    <li>10 PM</li>
                                                                    <li>11 PM</li>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="admin-user-timeLlne">
                                                        <div class="note-content">
                                                            <ul>
                                                                <li><span class="green-dot"></span>Work Time</li>
                                                                <li><span class="red-dot"></span>Private Time</li>
                                                                <li><span class="orenge-dot"></span>Idle Time</li>
                                                                <li><span class="light-orange-dot"></span>Time Request</li>
                                                                <li><span class="dark-dot"></span>Other Time</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (count($row)) {
                                    foreach ($row as $screenshot) { ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="card screenshort_card p-2">
                                                <?php if($screenshot['idle_status'] == 1){?>
                                                    <a href="<?= getenv('app.uploadsURL') . 'screenshot/' . $screenshot['image_name'] ?>" class="glightbox">
                                                        <img src="<?= getenv('app.uploadsURL') . 'screenshot/' . $screenshot['image_name'] ?>" class="card-img-top img-fluid rounded" alt="Screenshot image">
                                                    </a>
                                                <?php } else {?>
                                                    <a href="<?= getenv('app.uploadsURL') . '/idle.jpg'?>" class="glightbox">
                                                        <img src="<?= getenv('app.uploadsURL') . '/idle.jpg'?>" class="card-img-top img-fluid rounded" alt="Screenshot image">
                                                    </a>
                                                <?php } ?>
                                                <div class="card-body">
                                                    <p class="card-text mb-0 screenshort_date"><?= date('F j, Y \a\t h:i A', strtotime($screenshot['time_stamp'])) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div class="col-12">
                                        <div class="alert alert-warning" role="alert">
                                            No screenshots found for the selected date range.
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                        </div>


                        <!-- ____ code ____ -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    const lightbox = GLightbox({
        selector: '.glightbox'
    });
</script>
<script>
    var options = {
    series: [240, 279, 26], // Idle, Focus, Private in minutes
    chart: {
        type: 'donut',
        height: 180 // Reduced height
    },
    labels: ['Idle', 'Focus', 'Private'],
    colors: ['#ffd700', '#6bbf00', '#ff4d4f'], // Yellow, Green, Red
    plotOptions: {
        pie: {
            donut: {
                size: '75%', // Smaller donut
                labels: {
                    show: true,
                    total: {
                        show: true,
                        label: 'Focused',
                        formatter: function (w) {
                            let totalMinutes = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                            let focusMinutes = w.globals.seriesTotals[1];
                            let percentage = (focusMinutes / totalMinutes) * 100;
                            return percentage.toFixed(2) + '%';
                        }
                    }
                }
            }
        }
    },
    legend: {
        show: false
    },
    tooltip: {
        y: {
            formatter: function (val) {
                let hours = Math.floor(val / 60);
                let minutes = val % 60;
                return (hours > 0 ? hours + "h " : "") + minutes + "m";
            }
        }
    }
};

var chart = new ApexCharts(document.querySelector("#screenshort_chart"), options);
chart.render();
</script>