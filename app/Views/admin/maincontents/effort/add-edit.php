<?php
    $title              = $moduleDetail['title'];
    $primary_key        = $moduleDetail['primary_key'];
    $controller_route   = $moduleDetail['controller_route'];
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style type="text/css">
    .control-label{
        font-weight: bold;
    }
    .fill_up_project{
        border: 1px solid #0dcaf06b;
        margin-top: 10px;
        margin-bottom: 10px;
        padding: 10px;
        width: 35%;
        border-radius: 10px;
    }
    .floating{
        position: sticky;
        top: 60px;
        background: #fff;
        box-shadow: 0 2px 10px -5px #000;
        padding: 5px 0 10px;
    }
</style>
<div class="pagetitle">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1><?=$page_header?></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
                        <li class="breadcrumb-item active"><?=$page_header?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- End Page Title -->
<section class="section profile add-effort">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12">
                <?php if(session('success_message')){?>
                <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?=session('success_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php }?>
                <?php if(session('error_message')){?>
                <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                    <?=session('error_message')?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php }?>
            </div>
            <?php
            $settings   = $db->query("SELECT * FROM `application_settings`")->getRow();
            $day_count  = $settings->block_tracker_fillup_after_days;                  
            $days_ago   = date('Y-m-d', strtotime('-'.$day_count .'days', strtotime(date('Y-m-d'))));
            ?>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <form id="myForm" method="POST" action="" enctype="multipart/form-data" data-show-date-alert="<?=date('Y-m-d')?>">
                            <div class="row" style="border:1px solid #010f1a; padding: 15px 0; border-radius: 5px; margin-top: 10px; margin-bottom: 10px;background-color: #010f1a;">
                                <div class="col-md-12"><span style="text-transform: uppercase; color:#ffc107ed; font-weight:bold; display: flex; justify-content: center;">Task for&nbsp;<span id="new-task-date-text"><?=date('M d, Y l')?></span></span></div>
                            </div>
                            <div class="row justify-content-between align-items-center floating">
                                <div class="col-md-3">
                                    <label class="control-label">Date</label>
                                    <br>
                                    <input class="form-control form-control-inline" size="16" type="date" name="date_task" id="date_task" min="<?=$days_ago?>" max="<?=date('Y-m-d')?>" data-date-format="dd/mm/yyyy" value="<?=date('Y-m-d')?>" onchange="getTrackerDate(this.value, '<?=date('Y-m-d')?>');" onkeydown="return false" autocomplete="off" required>
                                    <div class="fill_up_date" style="color: red;"></div>
                                    <input type="hidden" id="show_date_alert" value="<?=date('Y-m-d')?>">
                                </div>
                                <div class="col-md-3">
                                    <div class="dailyhour_cal">
                                        <h3 id="tracker-date">Total Added</h3>&nbsp;=&nbsp;<span id="tracker-hour">0</span>:<span id="tracker-min">0</span>
                                    </div>
                                </div>
                            </div>

                            <div class="field_wrapper">
                                <!-- new tasks -->
                                    <div class="row" style="border:2px solid #f19620; padding: 15px 0; border-radius: 5px; margin-top: 10px; margin-bottom: 10px;">
                                        <h5 class="badge bg-warning text-dark" style="width: auto; margin-left: 13px; ">New Work List 1</h5>
                                        <input type="hidden" name="assigned_task_id[]" value="0">
                                        <input type="hidden" name="date_added[]" value="<?=date('Y-m-d')?>">
                                        <input type="hidden" name="work_status_id[]" value="4">
                                        <div class="col-md-12">
                                            <label class="control-label">Project</label>
                                            <br>
                                            <select name="project[]" data-index="0" class="select_proj form-control" style="font-size: 12px;" autocomplete="off" onchange="getProjectInfo(this.value, 0);" required>
                                                <option value="" selected="">Select Project</option>
                                                <hr>
                                                <?php if($projects){ foreach($projects as $project){?>
                                                    <option value="<?=$project->id?>"><?=$project->name?> (<?=$pro->decrypt($project->client_name)?>) - <?=$project->project_status_name?></option>
                                                    <hr>
                                                <?php } }?>
                                            </select>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="fill_up_projectss" id="fill_up_project_0" style="display:none;">
                                                
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label">Hour</label>
                                            <br>
                                            <input type="number" name="hour[]" id="hour0" minlength="0" maxlength="2" min="0" max="4" class="form-control hours" autocomplete="off" onblur="maxHour(this.value,0);" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label">Minute</label>
                                            <br>
                                            <input type="number" name="minute[]" id="minute0" minlength="0" maxlength="2" min="0" max="50" class="form-control minutes" autocomplete="off" onblur="maxMinute(this.value,0);" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="control-label">Description</label>
                                            <languagebr>
                                                <textarea name="description[]" class="form-control description" rows="3" autocomplete="off" required></textarea>
                                                <div class="itemDetails">
                                                    
                                                </div>
                                            </languagebr>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label">Effort Type</label>
                                            <br>
                                            <select name="effort_type[]" class="select_et form-control" style="font-size: 12px;" autocomplete="off" required>
                                                <option value="" selected="">Select Type</option>
                                                <hr>
                                                <?php if($effortTypes){ foreach($effortTypes as $effortType){?>
                                                <option value="<?=$effortType->id?>"><?=$effortType->name?></option>
                                                <hr>
                                                <?php } }?>
                                            </select>
                                            <div class="fill_up_et" style="color: red;"></div>
                                        </div>
                                    </div>
                                <!-- new tasks -->
                            </div>
                            <a href="javascript:void(0);" class="btn btn-primary btn-sm add_button" title="Add field"><i class="fa fa-plus-circle"></i> Add More Tasks</a>
                            <div class="text-left mt-3">
                                <button type="submit" class="btn btn_org btn-primary btn-sm"><i class="fa fa-paper-plane"></i> Submit Effort</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="<?=getenv('app.adminAssetsURL')?>assets/js/ckeditor.js"></script>
<script src="<?=getenv('app.adminAssetsURL')?>assets/js/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var maxField = 100; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var x = 1; //Initial field counter is 1
        
        // Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                var fieldHTML = '<div class="row" style="border:2px solid #f19620; padding: 10px; border-radius: 5px; margin-bottom: 10px;">\
                                    <h5 class="badge bg-warning text-dark" style="width: auto;">New Work List '+(x + 1)+'</h5>\
                                    <input type="hidden" name="assigned_task_id[]" value="0">\
                                    <input type="hidden" name="date_added[]" value="<?=date('Y-m-d')?>">\
                                    <input type="hidden" name="work_status_id[]" value="4">\
                                    <div class="col-md-12">\
                                        <label class="control-label">Project</label>\
                                        <br>\
                                        <select name="project[]" data-index="0" class="select_proj form-control" style="font-size: 12px;" autocomplete="off" onchange="getProjectInfo(this.value, ' + x + ');" required>\
                                            <option value="" selected="">Select Project</option>\
                                            <?php if($projects){ foreach($projects as $project){?>
                                                <option value="<?=$project->id?>"><?=$project->name?> (<?=$pro->decrypt($project->client_name)?>) - <?=$project->project_status_name?></option>\
                                                <hr>\
                                            <?php } }?>
                                        </select>\
                                        <div class="fill_up_projectss" id="fill_up_project_' + x + '" style="display:none;"></div>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <label class="control-label">Hour</label>\
                                        <br>\
                                        <input type="number" name="hour[]" id="hour' + x + '" minlength="0" maxlength="2" min="0" max="4" class="form-control hours" required autocomplete="off" onblur="maxHour(this.value,' + x + ');">\
                                    </div>\
                                    <div class="col-md-2">\
                                        <label class="control-label">Minute</label>\
                                        <br>\
                                        <input type="number" name="minute[]" id="minute' + x + '" minlength="0" maxlength="2" min="0" max="50" class="form-control minutes" required autocomplete="off" onblur="maxMinute(this.value,' + x + ');">\
                                    </div>\
                                    <div class="col-md-6">\
                                        <label class="control-label">Description</label>\
                                        <languagebr>\
                                            <textarea name="description[]" class="form-control description" rows="3" autocomplete="off" required></textarea>\
                                            <div class="itemDetails">\
                                            </div>\
                                        </languagebr>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <label class="control-label">Effort Type</label>\
                                        <br>\
                                        <select name="effort_type[]" class="select_et form-control" style="font-size: 12px;" autocomplete="off" required>\
                                            <option value="" selected="">Select Type</option>\
                                            <?php if($effortTypes){ foreach($effortTypes as $effortType){?>
                                            <option value="<?=$effortType->id?>"><?=$effortType->name?></option>\
                                            <?php } }?>
                                        </select>\
                                        <div class="fill_up_et" style="color: red;"></div>\
                                    </div>\
                                    <div class="col-md-2">\
                                        <a href="javascript:void(0);" class="btn btn-danger btn-sm remove_button" style="margin-top: 20px;">\
                                            <i class="fa fa-trash"></i> Delete</a>\
                                    </div>\
                                </div>';
                x++; //Increase field counter
                $(wrapper).append(fieldHTML); //Add field html
            }else{
                alert('A maximum of '+maxField+' fields are allowed to be added. ');
            }
        });
        
        // Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e){
            if(confirm('Are you sure you want to delete this element?')){
                e.preventDefault();
                $(this).parent('div').parent('div').remove(); //Remove field html
                x--; //Decrease field counter
            }
        });
    });
</script>
<script type="text/javascript">
    function getTrackerDate(inputValue, currentDate){
        var date = new Date(inputValue);
        var formattedDate = date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        if(inputValue == currentDate){
            var trackerDate = 'Total Added';
        } else {
            var trackerDate = formattedDate;
        }
        $('#tracker-date').text(trackerDate);
        $('#new-task-date-text').text(formattedDate);
    }
    $(document).on("blur", ".hours", function() {
        var tracketHour = 0;
        $(".hours").each(function(){
            tracketHour += +$(this).val();
        });
        $("#tracker-hour").text(tracketHour);
        var sum = 0;
        $(".minutes").each(function(){
            sum += +$(this).val();
        });
        var tracketHour = parseInt(tracketHour);
        var totMins = parseInt(sum);
        var result1 = parseInt((totMins / 60), 10);
        var result2 = (totMins % 60);
        var actualHour = (tracketHour + result1);
        var actualMins = result2;
        $("#tracker-hour").text(actualHour);
        $("#tracker-min").text(actualMins);
    });
    $(document).on("blur", ".minutes", function() {
        var sum = 0;
        $(".minutes").each(function(){
            sum += +$(this).val();
        });
        var tracketHour = 0;
        $(".hours").each(function(){
            tracketHour += +$(this).val();
        });
        var tracketHour = parseInt(tracketHour);
        var totMins = parseInt(sum);
        var result1 = parseInt((totMins / 60), 10);
        var result2 = (totMins % 60);
        var actualHour = (tracketHour + result1);
        var actualMins = result2;
        $("#tracker-hour").text(actualHour);
        $("#tracker-min").text(actualMins);
    });
    function getProjectInfo(projectId, counter){
        var base_url = '<?=base_url()?>';
        $.ajax({
            type: "POST",
            url: base_url + "admin/efforts/get-project-info",
            data: {projectId : projectId},
            dataType: "JSON",
            beforeSend: function () {
               
            },
            success: function (res) {
                var html = '';
                $('#fill_up_project_' + counter).show();
                if(res.success){
                    if(res.data.project_time_type == 'Onetime'){
                        html += '<div class="row">\
                                    <div class="col-md-4 col-sm-4">\
                                        <div class="info-date" style="border: 1px solid #fff;margin-top: 10px;margin-bottom: 10px; padding: 10px;border-radius: 10px;background-color: #06a79d;color: #fff;text-align: center;"><span class="time-font"><b>Assigned Fixed :</b><br class="d-none d-sm-block d-md-none"> ' + res.data.assigned + '</span></div>\
                                    </div>\
                                    <div class="col-md-4 col-sm-4">\
                                        <div class="info-date"><span class="time-font"><b>Booked Current Month :</b><br class="d-none d-sm-block d-md-none"> ' + res.data.current_month_booking + '</span></div>\
                                    </div>\
                                    <div class="col-md-4 col-sm-4">\
                                        <div class="info-date"><span class="time-font"><b>Total Booked from Start :</b><br class="d-none d-sm-block d-md-none"> ' + res.data.total_booked + '</span></div>\
                                    </div>\
                                </div>';
                    } else if(res.data.project_time_type == 'Monthlytime'){
                        html += '<div class="row">\
                                    <div class="col-md-4 col-sm-4">\
                                        <div class="info-date"><span class="time-font"><b>Assigned Monthly :</b><br class="d-none d-sm-block d-md-none"> ' + res.data.assigned + '</span></div>\
                                    </div>\
                                    <div class="col-md-4 col-sm-4">\
                                        <div class="info-date"><span class="time-font"><b>Booked Current Month :</b><br class="d-none d-sm-block d-md-none"> ' + res.data.current_month_booking + '</span></div>\
                                    </div>\
                                    <div class="col-md-4 col-sm-4">\
                                        <div class="info-date"><span class="time-font"><b>Total Booked from Start :</b><br class="d-none d-sm-block d-md-none"> ' + res.data.total_booked + '</span></div>\
                                    </div>\
                                </div>';
                    }  
                    $('#fill_up_project_' + counter).html(html);
                }
            }
        });
    }
</script>
<script>
    document.getElementById('myForm').addEventListener('submit', function(e) {
        event.preventDefault(); // Prevent the form from submitting
        // var show_date_alert = $(this).attr('data-show-date-alert');
        // console.log(show_date_alert);
        var show_date_alert = $('#date_task').val();
        var date = new Date(show_date_alert);
        var formattedDate = date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        var dayNames    = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var dayName     = dayNames[date.getDay()];
        // Check if the form is valid (this will trigger the browser's validation)
        if (this.checkValidity()) {
            Swal.fire({
                title: 'Are you sure?',
                html: "You are submitting tasks for <strong>" + formattedDate + " (" + dayName + ")</strong>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4CAF50',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        } else {
            // If the form is not valid, manually trigger validation
            this.reportValidity();
        }
    });
    document.getElementById('scheduleForm').addEventListener('submit', function(e) {
        event.preventDefault(); // Prevent the form from submitting
        var show_date_alert = $(this).attr('data-show-date-alert');
        console.log(show_date_alert);
        var date = new Date(show_date_alert);
        var formattedDate = date.toLocaleDateString('en-GB', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        var dayNames    = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
        var dayName     = dayNames[date.getDay()];
        // Check if the form is valid (this will trigger the browser's validation)
        if (this.checkValidity()) {
            Swal.fire({
                title: 'Are you sure?',
                html: "You are submitting tasks for <strong>" + formattedDate + " (" + dayName + ")</strong>",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4CAF50',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        } else {
            // If the form is not valid, manually trigger validation
            this.reportValidity();
        }
    });
</script>