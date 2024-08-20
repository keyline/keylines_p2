<?php
$user               = $session->user_type;
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@5.11.3/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@5.11.3/main.min.js'></script>

<style type="text/css">
    #simpletable_filter {
        float: right;
    }

    .simpletable_length label {
        display: inline-flex;
        padding: 10px;
    }

    .charts {
        border: 1px solid #ff980073;
        padding: 10px;
    }
</style>
<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '/list/') ?>"><?= $title ?> List</a></li>
            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
    <?php if (checkModuleFunctionAccess(26, 49)) { ?>
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
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption"></div>
                                <!-- <div class="tools"> </div> -->
                            </div>
                            <div class="portlet-body">
                                <div id="calendar">
                                    <center>
                                        <span class="dot" style="background:red" ></span>&nbsp;All 1st,3rd Saturday and Sunday &nbsp;&nbsp;
                                    </center>
                                </div>                        
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal" id="holidayModal">
                            <div class="modal-dialog">
                                <div class="modal-content">        
                                    <div class="modal-header">
                                    <h4 class="modal-title">Create event for <span id="eventDate1"></span></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                    <div class="modal-body">
                                        <form id="holidayForm" method="POST">
                                            <input type="hidden" name="start_event" id="start_event" />
                                            <input type="hidden" name="end_event" id="end_event" />
                                            <input type="hidden" id="holidayId">
                                            <div class="form-group">              
                                                <input type="text" class="form-control requiredCheck" data-check="Event Title" name="title" id="title" aria-describedby="helpId" placeholder="Enter Event title">
                                            </div>
                                            <div class="form-group">
                                                <label for="color_code_bc">Background Color</label>
                                                <input type="color" class="form-control requiredCheck" data-check="Color Code" name="color_code_bc" id="color_code_bc" aria-describedby="helpId" placeholder="Select Background Color Code" value="#FFFFFF">
                                            </div>
                                            <div class="form-group">
                                                <label for="color_code_fc">Font Color</label>
                                                <input type="color" class="form-control requiredCheck" data-check="Color Code" name="color_code_fc" id="color_code_fc" aria-describedby="helpId" placeholder="Select Font Color Code" value="#000000">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" id="dataForm" class="btn btn-primary" data-dismiss="modal">Save</button>                          
                                            </div> 
                                        </form>                   
                                    </div>        
                                </div>                                                
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
            <div class="col-md-6"> 
                <div class="card">                                           
                    <div class="row">
                        <div class="portlet box green portlet-right">
                            <div class="portlet-title">
                                <div class="caption">
                                </div>
                                <div class="tools">
                                    <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-success btn-sm mb-3" data-bs-toggle="modal" data-bs-target="#holidayAddModal">
                                      Add New Event
                                    </button>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-striped table-bordered table-hover table-condensed" id="event-table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Event Name</th>
                                            <th>Event Date</th>
                                            <th>Action</th>                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php                                                    
                                        if($events){ $sl=1; foreach($events as $row){ ?>
                                        <tr>
                                        <th scope="row"><?=$sl++?></th>
                                        <th scope="row"><?=$row->title?></th>
                                        <th scope="row"><?=date_format(date_create($row->start_event), "l, M d, Y")?></th>
                                        <th scope="row">                                            
                                            <a href="<?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete <?=$title?>" onclick="return confirm('Do You Want To Delete This <?=$title?>');"><i class="fa fa-trash"></i></a>
                                        </th>
                                        </tr>
                                    <?php } }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</section>

<!-- Modal -->
<div class="modal fade" id="holidayAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add New Holiday Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="start_event">Start Date</label>
                    <input type="date" class="form-control" data-check="Color Code" name="start_event" id="start_event" aria-describedby="helpId" placeholder="Start Date" required>
                </div>
                <div class="form-group">
                    <label for="end_event">End Date</label>
                    <input type="date" class="form-control" data-check="Color Code" name="end_event" id="end_event" aria-describedby="helpId" placeholder="End Date" required>
                </div>
                <div class="form-group">
                    <label for="end_event">Event Name</label>
                    <input type="text" class="form-control" data-check="Event Title" name="title" id="title" aria-describedby="helpId" placeholder="Enter Event title" required>
                </div>
                <div class="form-group">
                    <label for="color_code_bc">Background Color</label>
                    <input type="color" class="form-control" data-check="Color Code" name="color_code_bc" id="color_code_bc" value="#FFFFFF" aria-describedby="helpId" placeholder="Select Background Color Code" required>
                </div>
                <div class="form-group">
                    <label for="color_code_fc">Font Color</label>
                    <input type="color" class="form-control" data-check="Color Code" name="color_code_fc" id="color_code_fc" value="#000000" aria-describedby="helpId" placeholder="Select Font Color Code" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </div>
    </form>
  </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    async function holidaylist() {
    var url = '<?= site_url('/admin/holiday-list-api') ?>';
    let response = await fetch(url, {
        method: 'GET',                    
    });
    let data = await response.json();
    return data;
}

// Example usage
async function loadHolidayData() {
    let data = await holidaylist();
    // return data;
    // console.log(data);  // Process the data here
}
                  
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');
    // Initialize FullCalendar
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        buttonText: {
                today: 'Today'        // Change the "Day" button text
            },    
        events: async function(fetchInfo, successCallback, failureCallback) {
            try {
                let events = await holidaylist();
                successCallback(events);
            } catch (error) {
                failureCallback(error);
            }
        },// Load existing events here
        dateClick: function(info) {
            document.getElementById('holidayForm').reset();
            document.getElementById('holidayId').value = '';
            document.getElementById('start_event').value = info.dateStr;
            document.getElementById('end_event').value = info.dateStr;
            new bootstrap.Modal(document.getElementById('holidayModal')).show();
        },
        eventClick: function(info) {
            // console.log(info);
            var event = info.event;
            document.getElementById('holidayId').value = event.id;
            document.getElementById('title').value = event.title;
            document.getElementById('start_event').value = event.startStr;
            document.getElementById('end_event').value = event.endStr || event.startStr;
            document.getElementById('color_code_bc').value = event.backgroundColor;
            document.getElementById('color_code_fc').value = event.textColor;
            new bootstrap.Modal(document.getElementById('holidayModal')).show();
        },
        editable: true,
        eventDrop: function(info) {
            updateHoliday(info.event);
        },
        eventResize: function(info) {
            updateHoliday(info.event);
        }
    });

    calendar.render();
    document.getElementById('holidayForm').addEventListener('submit', function(event) {
        event.preventDefault();       
        var id = document.getElementById('holidayId').value;
        var url = id ? '<?= site_url('/admin/holiday-list/edit') ?>/' + id : '<?= site_url('/admin/holiday-list-add') ?>';
        // alert(id);
        
        fetch(url, {
            method: 'POST',
            body: new FormData(document.getElementById('holidayForm'))
        }).then(response => response.json())
            .then(data => {
            // alert(data.status);
                if (data.status === 'success') {                
                window.location.reload();
                }
            });
    });

    function updateHoliday(event) {
        var url = '<?= site_url('/admin/holiday-list/edit') ?>/' + event.id;
        
        fetch(url, {
            method: 'POST',
            body: new FormData(document.getElementById('holidayForm'))
        }).then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    calendar.refetchEvents();
                }
            });
    }
});
</script>