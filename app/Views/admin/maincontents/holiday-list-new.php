<?php
$user               = $session->user_type;
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<!-- CSS for full calender -->

<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" />
<!-- JS for full calender -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.20.1/moment.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>

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
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption"></div>
                                <div class="tools"> </div>
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
                        <div class="modal" id="myModal">
                            <div class="modal-dialog">
                                <div class="modal-content">        
                                    <div class="modal-header">
                                    <h4 class="modal-title">Create event for <span id="eventDate1"></span></h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                    <div class="modal-body">
                                        <form id="eventForm" method="POST">
                                            <input type="hidden" name="start_event" id="start_event" />
                                            <input type="hidden" name="end_event" id="end_event" />
                                            <div class="form-group">              
                                                <input type="text" class="form-control requiredCheck" data-check="Event Title" name="title" id="title" aria-describedby="helpId" placeholder="Enter Event title">
                                            </div>
                                            <div class="form-group">
                                                <input type="color" class="form-control requiredCheck" data-check="Color Code" name="color_code" id="color_code" aria-describedby="helpId" placeholder="Select Color Code">
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
            <div class="col-md-5">                                            
                <div class="row">
                    <div class="portlet box green portlet-right">
                        <div class="portlet-title">
                            <div class="caption">
                            </div>
                            <div class="tools"> </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover table-condensed" id="event-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Event Name</th>
                                        <th>Event Date</th>
                                        <!-- <th>End Event Date</th> -->
                                        <th>Edit</th>
                                        <th>Delete</th>
                                    </tr>
                                </thead>
                                
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
                $(document).ready(function(){
                    $('.menu-toggler').click(function(){
                        $('.holiday-page-menu').slideToggle();
                    });
                    $('.menu-dropdown').click(function(){
                        $(this).children('.dropdown-menu').slideToggle();
                        $(this).prevAll().children('.dropdown-menu').slideUp();
                        $(this).nextAll().children('.dropdown-menu').slideUp();
                    });
                });
            </script>
        <script>
            $(document).ready(function() {
                $('#calendar').fullCalendar({
                    header:{
                        left: 'title',                        
                        right: 'prev, today, next'
                    },
                    buttonText:{
                        today: 'Today'                        
                    },
                    viewRender: function(view) {
                    if(view.title){
                       var a= 1;
                          $('.fc-day.fc-sat').each(function() {                        
                                  $($(this)).addClass("sat"+a);                                   
                                 a++;
                               });                    
                       }
                    },
                    events: 'load.php',
                    selectable: true,
                    selectHelper: true,
                    showNonCurrentDates: false,
                    select: function(start,end,allDay)
                    {
                        let startDate   = $.fullCalendar.formatDate(start, "D-MM-Y");
                        let endDate     = $.fullCalendar.formatDate(end, "D-MM-Y");
                        $('#eventDate1').text(startDate);
                        $('#eventDate2').text(endDate);
                        $('#start_event').val(startDate);
                        $('#end_event').val(startDate);
                        $('#myModal').modal('toggle');
                    },  
            //         eventClick:function(event){
            //     if(confirm("Are you confirm to delete it?"))
            //     {
            //         var id = event.id;
            //         $.ajax({
            //             url:'delete.php',
            //             method: 'POST',
            //             data:{id:id},
            //             success:function(){
            //                 //calendar.fullCalendar('refetchEvents');
            //                 alert("Event got deleted");
            //                 location.reload(true);
            //             }
            //         })
            //     }
            // }                  
                });
            });
        </script>
        <script>
            $(function(){
                $("#eventForm").submit(function (e) {
                    e.preventDefault();
                    let flag = commonFormChecking(true, 'requiredCheck');
                    if (flag) {
                        if (flag) {
                            var formData = new FormData(this);
                            $.ajax({
                                type: "POST",
                                url: "insert_new.php",
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: "JSON",
                                beforeSend: function () {
                                    $("#eventForm").loading();
                                },
                                success: function (res) {
                                    $("#eventForm").loading("stop");             
                                    if(1){
                                        $('#eventForm').trigger("reset");
                                        toastAlert("success", "Event Inserted Successfully !!!");
                                        $('#myModal').modal('hide');
                                        //calendar.fullCalendar('refetchEvents');
                                        location.reload(true);
                                        /* show all events */
                                            let html = '';
                                            $("#event-list").empty();
                                            $.each(res, function(key, item) {
                                                html += `<tr>
                                                            <td style="text-align: center;">${key+1}</td>
                                                            <td>${item.title}</td>
                                                            <td>${item.start}</td>
                                                            <td>${item.end}</td>
                                                            <td>                                                                
                                                                <button class="btn btn-primary btn-sm text-white editButton"  data-eid='(${item.id})'><span class="glyphicon glyphicon-pencil"></span></button>                                                               
                                                            </td>
                                                            <td>
                                                                <button class="btn btn-danger btn-sm" id="deleteButton" onclick="deleteData(${item.id})"><span class="glyphicon glyphicon-trash"></span></button>
                                                            </td>
                                                        </tr>`;
                                            });
                                            $("#event-list").html(html);
                                        /* show all events */
                                    }else{
                                        toastAlert("error", res.message);
                                    }
                                },
                                error:function (xhr, ajaxOptions, thrownError){
                                    $("#eventForm").loading("stop");
                                    var res = xhr.responseJSON;
                                    if(xhr.status==404) {
                                        toastAlert("error", res.message);
                                    }
                                }
                            });
                        }
                    }
                });
            })
        </script>
        <script>
            //for open modal box with exsisting data
            $(document).ready(function(start,end,allDay) {
                $(document).on("click",".editButton", function(){
                    $("#modal").show();
                    var id = $(this).data("eid");
                    //alert(id);
                    $.ajax({
                            url:'load_form.php',
                            type:'POST',
                            data: {id:id},
                            success:function(data){
                                $("#modal_form").html(data);                                
                            }                            
                            })
                });
                //for save editated data
                $(document).on("click","#edit-form", function(){
                    var eventid = $("#edit_id").val();
                    var title = $("#edit_title").val();
                    var color_code = $("#edit_color_code").val();                    
                    $.ajax({
                            url:'update.php',
                            type:'POST',
                            data: {title:title,                                                                   
                                    color_code:color_code,
                                    id:eventid},
                            success:function(data){
                                if(data == 1){
                                    $("#modal").hide();
                                    loadTable();
                                }                              
                            }                            
                            })
                });
                function loadTable(){
                    $.ajax({
                                url:'load.php',
                                type:'POST',                                
                                success:function(data){
                                    $("#event-table").html(data);
                                }                            
                            });
                }
            });            
        </script>
<script>    
    function deleteData(data) {
        //Make an Ajax request to delete the data
        if(confirm("Are you confirm to delete it?"))
        {
            var id = data;
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: {
                id:id
                },
                success: function(response) {
                    alert('Data deleted successfully');
                    location.reload(true);
                },
                error: function(xhr, status, error) {
                    alert('Error deleting data:', error);
                }
            });
        }
    }    
</script>