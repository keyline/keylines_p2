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
        margin-top: 10px;
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

    /* SSSSSSSSSSSSSSSSSS time line chart SSSSSSSSSSSSSSSSSS */

    .timeline-wrapper {
    position: relative;
    width: 86400; /* 1440 minutes in a day */
    border: 1px solid #333;
    height: 30px;
    margin-bottom: 20px;
    }

    .timeline {
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: lightgray;
    }



    .hours {
    position: absolute;
    top: 100%;
    left: 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    font-size: 12px;
    }

    .hours span {
        position: relative;
        margin: 0;
        padding: 0;
        width: 0.025%;
    }
    .hours span strong{
        display: block;
        width: 40px;
    }

    .hours span::before {
        content: "";
        position: absolute;
        top: -22px;
        left: 0;
        width: 1px;
        height: 15px;
        background:#6b6b6b;
    }
    .hours span:first-child::before,
    .hours span:last-child::before {
        display: none;
    }

    /* SSSSSSSSSSSSSSSSSSS Timeline working time counting SSSSSSSSSSSSSSSSSS*/
        /* symbols css */
    .symbolsContainer{
        display: flex;
        justify-content: center;
        margin-top: 2rem;
    }

    .activeColor{
            width:15px;
        height:15px;
        background-color: green;
        margin-right: 10px;
        border-radius: 50%;
    }
    .idleColor{
            width:15px;
        height:15px;
        background-color: yellow;
            margin-right: 10px;
            border-radius: 50%;
    }
    .othersColor{
            width:15px;
        height:15px;
        background-color: grey;
            margin-right: 10px;
            border-radius: 50%;
    }
    .active, .idle, .others {
        display: flex;
        margin-left: 3rem;
        align-items: center;
    }
    /* total working time */
    .workCountingContainer{
    display: flex;
    justify-content: center;
    }
    .totalWorking, .focusedTime, .idleTime{
        margin-bottom: 1rem;
    }
    .totalWorking{
        background: #F1F1F1;
        border: 1px solid #9D9D9D;
    }
    .focusedTime{
        background: #d2f3d3;
        border: 1px solid #9dc59e;
    }
    .focusedTime p{
        color: #247426;
    }
    .idleTime{
        background: #fffaf0;
        border: 1px solid #ffe2b5;
    }
    .idleTime p{
        color: #FC9A06;
    }
    .time_box{
        padding: 20px;
        /* box-shadow: 0 4px 14px -6px #000; */
        border-radius: 10px;
        text-align: center;
    }
     .time_box p{
        font-size: 18px
     }
    p{
    font-size: 2rem;
    }

    @media(max-width: 1199px){
        .user_timeline_new_view{
            max-width: 640px;
        }
    }
    @media(max-width: 991px){
        .user_timeline_new_view{
            max-width: 400px;
        }
    }
    @media(max-width: 767px){
        .appusage_top_view_sec,
        .admin-user-timeLlne .note-content ul{
            flex-wrap: wrap;
        }
        .user_timeline_new_view{
            max-width: 400px;
        }
        .appusage_top_timehour_graph {
            width: 100%;
            height: 100%;
            max-width: 100%;
            border-right: none;
            padding-bottom: 10px;
        }
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
                            <div class="row g-3 justify-content-center">
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
                                <!-- <div class="col-12">
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
                                </div> -->
                                <!-- <div class="col-12">
                                    <div style="width:100%;height:4rem;background-color:blue;">
                                        </?php for($i = 1; $i < 86400; $i++){ ?>
                                           <span style="background-color:green;"></span>
                                       </?php } ?>
                                    </div>
                                </div> -->
                                <div class=" col-lg-9 col-xl-7 col-xxl-6">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="totalWorking time_box">
                                                <p class="totalWorkingLabel">Total working time</p>
                                                <p class="totalWorkingValue">0:0</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="focusedTime time_box">
                                                <p class="focusedTimeLabel">Productive time</p>
                                                <p class="focusedTimeValue">0:0</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="idleTime time_box">
                                                <p class="idleTimeLabel">Idle time</p>
                                                <p class="idleTimeValue">0:0</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>   

                             <!-- SSSSSSSSSSSSSSSSSSSSSSSSSS WORKING TIMELINE GRAPH START SSSSSSSSSSSSSSSSSSSSSSSS  -->
                                <div class="col-12">
                                    <div class="timeline-wrapper">
                                        <div class="timeline" id="timeline"></div>
                                        <div class="hours" id="hours"></div>
                                    </div>
                                    <div class="symbolsContainer">
                                        <div class="active"><div class="activeColor"></div> <div>Active</div></div>
                                        <div class="idle"><div class="idleColor"></div> <div>Idle</div></div>
                                        <div class="others"><div class="othersColor"></div> <div>Others</div></div>
                                    </div>
                                </div>
                                <?php
                                $segments = [];
                                if (count($row)) {
                                     $previousTime = null;
                                     $previousScreenshot = [];
                                     $index = 0;
                                    $items = array_reverse($row);
                                while ($index < count($items)){
                                // if($index !== 0){
                                      if ($index === 0) {
                                            // only remember the first screenshot
                                            $previousScreenshot = $items[0];
                                            $index++;
                                            continue; // go to next iteration without pushing a segment
                                        }
                                     $screenshot = $items[$index];
                                     $time = $screenshot['time_stamp'];
                                        if($screenshot['idle_status'] == 1){
                                            if($previousScreenshot['idle_status'] == 1){
                                                $currTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                                                    date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                                                    date('s', strtotime($screenshot['time_stamp']));   
                                                $prevTime = date('H', strtotime($previousScreenshot['time_stamp'])) * 3600 +
                                                                    date('i', strtotime($previousScreenshot['time_stamp'])) * 60 +
                                                                    date('s', strtotime($previousScreenshot['time_stamp'])); 
                                                    if(abs($currTime - $prevTime) > 300){
                                                         $width = 300;
                                                    }else{
                                                        $width = abs($currTime - $prevTime);
                                                    }                                                                                                                
                                                
                                               $initTime = date('H:i', strtotime($previousScreenshot['time_stamp']));
                                               $endTime = date('H:i', strtotime($screenshot['time_stamp'])); 
                                                if(abs(strtotime($initTime) - strtotime($endTime)) > 300){
                                                    $diffSeconds = 300;
                                                }else{
                                                    $diffSeconds = strtotime($endTime) - strtotime($initTime);
                                                } 
                                                $diffMinutes = round(abs($diffSeconds) / 60); 
                                                $color =  'green';
                                                $status =  'Active';                                         
                                            }else{
                                                $prevTime = date('H', strtotime($previousScreenshot['time_stamp'])) * 3600 +
                                                                    date('i', strtotime($previousScreenshot['time_stamp'])) * 60 +
                                                                    date('s', strtotime($previousScreenshot['time_stamp']));
                                                $currTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                                                    date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                                                    date('s', strtotime($screenshot['time_stamp']));  

                                                // $width = abs($currTime - $prevTime);
                                                if(abs($currTime - $prevTime) > 300){
                                                         $width = 300;
                                                    }else{
                                                        $width = abs($currTime - $prevTime);
                                                    }  
                                            $initTime = date('H:i', strtotime($previousScreenshot['time_stamp']));
                                            $endTime = date('H:i', strtotime($screenshot['time_stamp']));   
                                            if(abs(strtotime($endTime) - strtotime($initTime)) > 300){
                                                $diffSeconds = 300;
                                            }else{
                                                $diffSeconds = strtotime($endTime) - strtotime($initTime);
                                            }   
                                        $diffMinutes = round(abs($diffSeconds) / 60);  
                                            $color =  'yellow';
                                           $status =  'Idle';                                                                                     
                                            }

                                        }else{

                                              if($previousScreenshot['idle_status'] == 1){
                                                $prevTime = date('H', strtotime($previousScreenshot['time_stamp'])) * 3600 +
                                                                    date('i', strtotime($previousScreenshot['time_stamp'])) * 60 +
                                                                    date('s', strtotime($previousScreenshot['time_stamp']));                                                
                                                $currTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                                                    date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                                                    date('s', strtotime($screenshot['time_stamp']));                                                  
                                                // $width = abs($currTime - $prevTime);
                                                // if(abs($currTime - $prevTime) > 180){
                                                         $width = 180;
                                                    // }
                                                    $startTime = date('H:i', strtotime($screenshot['time_stamp']));
                                                    $initTime = date('H:i', strtotime($startTime . ' -3 minutes'));
                                                    $endTime = date('H:i', strtotime($screenshot['time_stamp'])); 
                                                // if(abs(strtotime($endTime) - strtotime($initTime)) > 180){
                                                        $diffSeconds = 180;
                                                    // } 
                                                    $diffMinutes = round(abs($diffSeconds) / 60);                                                                                 
                                                $color =  'yellow';
                                                $status =  'Idle';

                                           }else{
                                                $prevTime = date('H', strtotime($previousScreenshot['time_stamp'])) * 3600 +
                                                                    date('i', strtotime($previousScreenshot['time_stamp'])) * 60 +
                                                                    date('s', strtotime($previousScreenshot['time_stamp']));                                                
                                                $currTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                                                    date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                                                    date('s', strtotime($screenshot['time_stamp']));                                                  
                                                // $width = abs($currTime - $prevTime);
                                                if(abs($currTime - $prevTime) > 300){
                                                         $width = 300;
                                                    }else{
                                                        $width = abs($currTime - $prevTime);
                                                    }  
                                                    $initTime = date('H:i', strtotime($previousScreenshot['time_stamp']));
                                                    $endTime = date('H:i', strtotime($screenshot['time_stamp'])); 
                                                if(abs(strtotime($endTime) - strtotime($initTime)) > 300){
                                                        $diffSeconds = 300;
                                                    }else{
                                                        $diffSeconds = strtotime($endTime) - strtotime($initTime);
                                                    } 
                                                    $diffMinutes = round(abs($diffSeconds) / 60);                                                                                 
                                                $color =  'yellow';
                                                $status =  'Idle';

                                           }
                                       }
                                        $previousScreenshot = $screenshot;
                                        $secondsInDay = 86400;

                                        $percentage = ($currTime / $secondsInDay) * 100;
                                        $durationPercentage = ($width / $secondsInDay) * 100; 
                                        $segments[] = [
                                            'diffTime' => $diffMinutes,
                                            'initTime' => $initTime,
                                            'endTime' => $endTime,
                                            'start' => $percentage,
                                            'width' => $durationPercentage,
                                            'color' => $color,
                                            'status'=> $status
                                        ];
                                         $index++; 
                                    }                                        
                                    // }else{
                                    //      $screenshot = $items[0];
                                    //       $prevTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                    //                            date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                    //                            date('s', strtotime($screenshot['time_stamp']));
                                    //       $currTime = date('H', strtotime($screenshot['time_stamp'])) * 3600 +
                                    //                            date('i', strtotime($screenshot['time_stamp'])) * 60 +
                                    //                            date('s', strtotime($screenshot['time_stamp']));  

                                    //       $width = 60;
                                    //   $initTime = date('H:i', strtotime($screenshot['time_stamp']));
                                    //   $endTime = date('H:i', strtotime($screenshot['time_stamp']));   
                                    //   $diffSeconds = strtotime($endTime) - strtotime($initTime);
                                    //   $diffMinutes = round(abs($diffSeconds) / 60); 
                                    //    $color =  'green';
                                    //    $status =  'Active';

                                    //     $previousScreenshot = $screenshot;
                                    //     $secondsInDay = 86400;

                                    //     $percentage = ($currTime / $secondsInDay) * 100;
                                    //     $durationPercentage = ($width / $secondsInDay) * 100; 
                                    //     $segments[] = [
                                    //         'diffTime' => $diffMinutes,
                                    //         'initTime' => $initTime,
                                    //         'endTime' => $endTime,
                                    //         'start' => $percentage,
                                    //         'width' => $durationPercentage,
                                    //         'color' => $color,
                                    //         'status'=> $status
                                    //     ];
                                    //      $index++;                                         
                                    // } 
                                     
                                    }
                                //  }
                                  ?>
                            <!-- SSSSSSSSSSSSSSSSSSSSSSSSSS WORKING TIMELINE GRAPH END SSSSSSSSSSSSSSSSSSSSSSSS  -->      
                                <?php if (count($row)) {
                                    foreach ($row as $screenshot) { ?>
                                        <div class="col-lg-3 col-md-4 col-sm-6">
                                            <div class="card screenshort_card p-2">
                                                <?php if($screenshot['idle_status'] == 1){ ?>
                                                    <?php
                                                        $baseUrl = getenv('app.uploadsURL');
                                                        $imageUrl = $baseUrl . 'screenshot/' . ($screenshot['image_name'] ?? '');
                                                        $headers = @get_headers($imageUrl);
                                                    ?>
                                                    <?php if ($headers && strpos($headers[0], '200') !== false) { ?>
                                                        <a href="<?= $imageUrl ?>" class="glightbox" data-title="<?= htmlspecialchars($screenshot['active_app_name']) ?>">
                                                            <img src="<?= $imageUrl ?>" class="card-img-top img-fluid rounded" alt="Screenshot image">
                                                        </a>
                                                    <?php } else { ?>
                                                        <a href="<?= $baseUrl . 'no-image-available.jpg' ?>" class="glightbox" data-title="<?= htmlspecialchars($screenshot['active_app_name']) ?>">
                                                            <img src="<?= $baseUrl . 'no-image-available.jpg' ?>" class="card-img-top img-fluid rounded" alt="Screenshot image">
                                                        </a>
                                                    <?php } ?>

                                                    <div class="card-body">
                                                        <p class="card-text mb-0 screenshort_date"><?= date('F j, Y \a\t h:i A', strtotime($screenshot['time_stamp'])) ?></p>
                                                        <!-- <p class="card-text mb-0 screenshort_app_name"><?= $screenshot['active_app_name']; ?></p> -->
                                                    </div>
                                                <?php } else { ?>
                                                    <a href="<?= getenv('app.uploadsURL') . '/idle.jpg'?>" class="glightbox" data-title="Idle">
                                                        <img src="<?= getenv('app.uploadsURL') . '/idle.jpg'?>" class="card-img-top img-fluid rounded" alt="Screenshot image">
                                                    </a>
                                                    <div class="card-body">
                                                        <p class="card-text mb-0 screenshort_date"><?= date('F j, Y \a\t h:i A', strtotime($screenshot['time_stamp'])) ?></p>
                                                    </div>
                                                <?php } ?>


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
    dataLabels: {
        enabled: true,
        dropShadow: {
        enabled: false  // Disable the box shadow here
        },
        style: {
        fontSize: '12px',
        },
        background: {
        enabled: true,
        foreColor: '#000',
        padding: 4,
        borderRadius: 2,
        borderWidth: 1,
        borderColor: '#ffc107',
        },
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

<!-- Working timing chart script -->
<script>
const hoursDiv = document.getElementById("hours");
for (let h = 0; h <= 24; h++) {
    if(h == 24){
     let label = document.createElement("span");
     let time = "";
     label.innerHTML = `<strong>${time}</strong>`;
     hoursDiv.appendChild(label); 
    }else{
      let label = document.createElement("span");
    let time = h + "h";
    label.innerHTML = `<strong>${time}</strong>`;
    hoursDiv.appendChild(label);
  }
}

    const timeline = document.getElementById("timeline");
    // helper: color percentage width
    function addPercentSegment(diffTime,initTime,endTime,startPercent, widthPercent, color, status, class_name) {
    let seg = document.createElement("div");
    seg.dataset.diffTime = diffTime;
    seg.dataset.initTime = initTime;
    seg.dataset.endTime = endTime;
    seg.dataset.status = status;
    seg.classList.add("timeDiv");
    if (class_name) seg.classList.add(class_name);
    seg.setAttribute("onmouseover", "diffTimeShow(this)");
    seg.setAttribute("onmouseout", "diffTimeRemove(this)");
    seg.style.position = "absolute";
    seg.style.top = 0;
    seg.style.height = "100%";
    seg.style.left = (startPercent-widthPercent) + "%";       // where to start . And From original percentange reduce 2.967 for match the width
    seg.style.width = (widthPercent) + "%";      // how wide
    seg.style.background = color;
    timeline.appendChild(seg);

    }

    // Example: 25%–50% (a quarter of the day)
    // addPercentSegment(38.9, 39.36, "green");  (For standard timing 10AM to 7PM . From original percentange reduce 2.967)
    // addPercentSegment(0,0,0,41.407, 37.86, "grey", "");
    // Example: 70%–80%
    // addPercentSegment(47.4, 2.5, "yellow");
    // addPercentSegment(59.5, 3.5, "yellow");

       let segments = <?php echo json_encode($segments); ?>;

                function timeToMinutes(t) {
                let [h, m] = t.split(':').map(Number);
                return h * 60 + m;
            }

            function minutesToTime(mins) {
                let h = Math.floor(mins / 60);
                let m = mins % 60;
                return `${h}:${m.toString().padStart(2, '0')}`;
            }

        let totalWorkingTime = 0;
        let lastColor = 'green';
        let lastEndTime = null;   // keep track of previous segment end time
        let idx = 0;
        //  console.log(segments[1]['currentInitMins']);
        //  console.log('Yes here this is');
        // console.log(segments[0]['initTime']);
        // console.log(segments[1]['initTime']);
        segments.forEach((s, i)=> {
            let end = s.start + s.width;
            if (end > 100) {
                return false; 
            }

            // convert init/end times into minutes for gap checking
            let currentInitMins = timeToMinutes(s.initTime);
            console.log("Current time " + currentInitMins + "<br>");
            let prevEndMins = lastEndTime !== null ? timeToMinutes(lastEndTime) : 0;
             console.log("Previoust time " + prevEndMins + "<br>");
            let gap =  Math.abs((currentInitMins - prevEndMins));

            
            let class_name;
            console.log(gap);
                if(lastColor === s.color){
                        if(gap > 5){
                            idx++;
                         class_name = s.color + idx;
                        }else{
                        class_name = s.color + idx;
                        }
                }else{
                // idx++;
                // class_name = s.color + idx;   
                        if(gap > 5){
                        idx++;
                        class_name = s.color + idx;  
                        }else{
                            idx++;
                        class_name = s.color + idx;
                        }           
                }
 

          addPercentSegment(s.diffTime,s.initTime,s.endTime,s.start, s.width, s.color, s.status, class_name);    

            // update tracking
            lastColor = s.color;
            lastEndTime = s.initTime;

            // update totals
            let focusedTimeEl = document.querySelector('.focusedTimeValue');
            let idleTimeEl = document.querySelector('.idleTimeValue');

            let focusedMins = timeToMinutes(focusedTimeEl.textContent);
            let idleMins = timeToMinutes(idleTimeEl.textContent);

                    if (s.color === 'green') {
                        focusedMins += s.diffTime;
                    } else {
                        idleMins += s.diffTime;
                    }

            totalWorkingTime += s.diffTime;
            focusedTimeEl.textContent = minutesToTime(focusedMins);
            idleTimeEl.textContent = minutesToTime(idleMins);
        });

        document.querySelector('.totalWorkingValue').textContent = minutesToTime(totalWorkingTime);

    
            function diffTimeShow(el) {
            var class_name = "." + el.classList[1];  // use assigned group class
            var allElements = document.querySelectorAll(class_name);

            let totalDiffTime = 0;
            let startTime = allElements[0].dataset.initTime;
            let endTime = allElements[allElements.length - 1].dataset.endTime;
            let status = el.dataset.status;

            allElements.forEach(div => {
                totalDiffTime += parseInt(div.dataset.diffTime, 10);
            });

            let tooltip = document.createElement("div");
            tooltip.className = "tooltip-time";
            tooltip.innerHTML =
                totalDiffTime + " mins<br>" +
                status + "<br>" +
                startTime + " - " + endTime;

            tooltip.style.position = "absolute";
            tooltip.style.bottom = "100%";
            tooltip.style.left = "50%";
            tooltip.style.transform = "translateX(-50%)";
            tooltip.style.whiteSpace = "nowrap";
            tooltip.style.background = "#333";
            tooltip.style.color = "#fff";
            tooltip.style.padding = "2px 6px";
            tooltip.style.fontSize = "12px";
            tooltip.style.borderRadius = "4px";
            tooltip.style.pointerEvents = "none";

            el.appendChild(tooltip);
        }


        function diffTimeRemove(el) {
            let tooltip = document.querySelector(".tooltip-time");
            if (tooltip) {
                tooltip.remove();
            }
        }
               
</script>

