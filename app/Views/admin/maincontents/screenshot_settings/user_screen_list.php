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
    .grph-btm-details {
        display: flex    ;
        gap: 5px;
        padding: 0;
        text-align: center;
        justify-content: center;
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
        display: table;
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
    .admin-user-overview-time-bar .first_time_bar .progress-bar-dark::before {
        height: 45px;
        top: -45px;
        content: '';
        background-color: #f6f6f6;
        width: 100%;
        position: absolute;
        pointer-events: none;
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
    .admin-user-timeLlne {
        display: table;
        margin-left: auto;
        margin-right: auto;
    }
    .admin-user-timeLlne .note-content {
        text-align: left;
        display: inline-block;
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
    .app_usage_top_activity_sec {
        width: 100%;
        max-width: 200px;
        height: 100%;
        padding: 10px 7px;
    }
    .appusage_activity_efficiency_row {
        position: relative;
        width: 100%;
        display: inline-block;
        z-index: 8;
    }
    .app_usage_top_activity_sec .acteff_main_box {
        border-radius: 7px;
        background: #fff;
        box-shadow: 0 2px 6px 0 rgba(0, 0, 0, .09);
        margin-bottom: 15px;
        width: 100%;
        z-index: 9;
        position: relative;
        border: 1px #81b504 dashed;
    }
    .acteff_main_box {
        display: inline-block !important;
        text-align: left !important;
        padding: 13px !important;
    }
    .acteff_content {
        width: 100%;
        height: auto;
        display: inline-block;
    }
    .acteff_main_box .task_qck_bx_info {
        left: inherit;
        right: 5px;
    }
    .task_qck_bx_info {
        position: absolute;
        top: 0;
        left: 0;
        position: absolute;
        top: 5px;
        left: 5px;
        opacity: 0.6;
    }
    .acteff_content h5 {
        width: 100%;
        display: inline-block;
        margin: 0;
        font-size: 14px;
        color: #5e5e5e;
    }
    .acteff_content h2 {
        width: 100%;
        position: relative;
        display: inline-block;
        color: #272727;
        font-size: 25px;
        margin-top: 0;
        margin-bottom: 0;
        font-weight: 600;
        text-shadow: 1px 2px #ccc;
    }
    .feature_in_highplan_text {
        position: absolute;
        left: 0;
        width: 94%;
        text-align: center;
        color: #323232;
        font-size: 13px;
        background-color: #ffffffd6;
        height: 77%;
        margin: 5px;
        display: flex;
        align-items: center;
        padding: 10px;
        font-weight: bold;
        z-index: 91;
    }
    .app_usage_top_activity_sec .acteff_main_box {
        border-radius: 7px;
        background: #fff;
        box-shadow: 0 2px 6px 0 rgba(0, 0, 0, .09);
        margin-bottom: 15px;
        width: 100%;
        z-index: 9;
        position: relative;
        border: 1px #81b504 dashed;
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
                                            <div id="idlechartdiv" style="display: block">
                                                <span style="width:100%;position:relative;display:inline-block">
                                                    <div class="chartjs-size-monitor">
                                                        <div class="chartjs-size-monitor-expand">
                                                            <div class=""></div>
                                                        </div>
                                                        <div class="chartjs-size-monitor-shrink">
                                                            <div class=""></div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="idletimepercentage"
                                                        value="{&quot;labels&quot;:[&quot;Idle&quot;,&quot;Focus&quot;,&quot;Private&quot;],&quot;data&quot;:[4140,8119,3],&quot;tooltip&quot;:[&quot;01h 09m&quot;,&quot;02h 15m&quot;,&quot;00h 00m&quot;],&quot;colors&quot;:[&quot;#F4D41F&quot;,&quot;#81B504&quot;,&quot;rgb(235, 64, 100)&quot;]}">
                                                    <canvas height="150px" style="margin: auto; width: 100%; display: block;" id="idlechart" width="229"
                                                        class="chartjs-render-monitor"></canvas>
                                                    <div id="work_graph_center_perc" class="work-report-graph-totalprdct-percntg percg_inn">
                                                        <strong>66.21%</strong>
                                                        Focused
                                                    </div>
                                                </span>
                                            </div>
                                            <div id="noworktaskbarChart" class="no-data-found text-center" style="display: none">
                                                <h4 class="no_data_text" style="padding-top: 10px;"><img src="https://ap-app.desklog.io/img/no-data1.png">
                                                </h4>
                                            </div>
                                            <div id="work_graph_detail" class="grph-btm-details">
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
                                    
                                        <div class="timeline_dv_center">
                                            <div class="admin-user-overview animated fadeInDown">
                                    
                                                <div class="admin-user-overview-col time_at_work">
                                                    <div class="top-grid-img-user"><img class="top-grid-img" src="/img/Time-At-Work.png"></div>
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
                                                <div class="admin-user-overview-col focus_time" style="display: none">
                                                    <div class="top-grid-img-user"><img class="top-grid-img" src="/img/Left-Time.png">
                                                    </div>
                                                    <a>
                                                        <span class="top-grid-title">Focus Time</span>
                                                        <span class="top-grid-report block clouck_out"><span class="left" id="" data-from="0"
                                                                data-to="02h 15m">02h 15m
                                                            </span>
                                                        </span></a>
                                                </div>
                                                <div class="admin-user-overview-col task_spent">
                                                    <div class="top-grid-img-user"><img class="top-grid-img" src="/img/Productive-Time.png"></div>
                                                    <a href="#" class="">
                                                        <span class="top-grid-title">Task Spent</span>
                                                        <span class="top-grid-report block"><span class="prod_time" style="color: #81B504" data-from="0"
                                                                data-to="--">--</span></span>
                                                    </a>
                                                </div>
                                                <div class="admin-user-overview-col clock_in">
                                                    <div class="top-grid-img-user"><img class="top-grid-img" src="/img/Arrival-Time.png"></div>
                                                    <a>
                                                        <span class="top-grid-title">Clock In</span>
                                                        <div class="top-grid-report block"><span class="timer" id="arrival" data-from="0"
                                                                data-to="10:02 AM">10:02 AM</span></div>
                                                    </a>
                                                </div>
                                                <div class="admin-user-overview-col clock_out">
                                                    <div class="top-grid-img-user"><img class="top-grid-img" src="/img/Left-Time.png"></div>
                                                    <a>
                                                        <span class="top-grid-title">Clock Out</span>
                                                        <span class="top-grid-report block"><span class="left" id="leave" data-from="0"
                                                                data-to="Online">Online</span></span>
                                                    </a>
                                                </div>
                                            </div>
                                    
                                            <div class="over-flow appusage_day_view_2 " style="max-width: 1024px; margin: auto;">
                                    
                                    
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
                                    
                                        <div class="app_usage_top_activity_sec">
                                            <div class="appusage_activity_efficiency_row animated fadeInDown">
                                                <div class="acteff_main_box ">
                                                    <div class="acteff_content">
                                                        <i class="fa fa-info-circle task_qck_bx_info" aria-hidden="true">
                                                            <span
                                                                data-tooltip="Efficiency is measured by comparing the amount of productive time to the total time at work.">
                                                            </span>
                                                        </i>
                                                        <h5>Efficiency</h5>
                                                        <h2>0%
                                                        </h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="appusage_activity_efficiency_row animated fadeInDown">
                                                <small class="feature_in_highplan_text">This feature is available in higher plans</small>
                                                <div class="acteff_main_box  no_feature_blur ">
                                                    <div class="acteff_content">
                                                        <i class="fa fa-info-circle task_qck_bx_info" aria-hidden="true">
                                                            <span
                                                                data-tooltip="Activity is the percentage of keyboard and mouse strokes during the total tracked time.(All users must install latest version of Desklog app for accurate data)"></span>
                                                        </i>
                                                        <h5>Activity</h5>
                                                        <h2>0%
                                                        </h2>
                                                    </div>
                                                </div>
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

<script>
    const lightbox = GLightbox({
        selector: '.glightbox'
    });
</script>