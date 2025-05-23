<?php
    $title              = $moduleDetail['title'];
    $primary_key        = $moduleDetail['primary_key'];
    $controller_route   = $moduleDetail['controller_route'];
?>
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
            $sql = "SELECT * FROM `general_settings`";
            // $query = $db->query($sql, [$deprt_id]);
            $settings = $db->query($sql)->getRow();
            $day_count = $settings->block_tracker_fillup_after_days;                  
            $days_ago = date('Y-m-d', strtotime('-'.$day_count .'days', strtotime(date('Y-m-d'))));
            ?>
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <form method="POST" action="" enctype="multipart/form-data">
                            <div class="row justify-content-between align-items-center floating">
                                <div class="col-md-3">
                                    <label class="control-label">Date</label>
                                    <br>
                                    <input class="form-control form-control-inline" size="16" type="date" name="date_task" id="date_task" min="<?=$days_ago?>" max="<?=date('Y-m-d')?>" data-date-format="dd/mm/yyyy" value="<?=date('Y-m-d')?>" onchange="getTrackerDate(this.value, '<?=date('Y-m-d')?>');" onkeydown="return false" autocomplete="off" required>
                                    <div class="fill_up_date" style="color: red;"></div>
                                </div>
                                <div class="col-md-3">
                                    <div class="dailyhour_cal">
                                        <h3 id="tracker-date">Total Added</h3>&nbsp;=&nbsp;<span id="tracker-hour">0</span>:<span id="tracker-min">0</span>
                                    </div>
                                </div>
                            </div>
                            <div class="field_wrapper">
                                <div class="row" style="border:1px solid #f19620a6; padding: 15px 0; border-radius: 5px; margin-top: 10px; margin-bottom: 10px;">
                                    <h5 class="badge bg-warning text-dark" style="width: auto; margin-left: 13px; ">Work List 1</h5>
                                    <div class="col-md-12">
                                        <label class="control-label">Project</label>
                                        <br>
                                        <select name="project[]" data-index="0" class="select_proj form-control" style="font-size: 12px;" autocomplete="off" required onchange="getProjectInfo(this.value, 0);">
                                            <option value="" selected="">Select Project</option>
                                            <hr>
                                            <?php if($projects){ foreach($projects as $project){?>
                                                <option value="<?=$project->id?>"><?=$project->name?> (<?=$project->client_name?>) - <?=$project->project_status_name?></option>
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
                                        <input type="number" name="hour[]" id="hour0" minlength="0" maxlength="2" min="0" max="4" class="form-control hours" required="" autocomplete="off" onblur="maxHour(this.value,0);">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="control-label">Minute</label>
                                        <br>
                                        <input type="number" name="minute[]" id="minute0" minlength="0" maxlength="2" min="0" max="50" class="form-control minutes" required="" autocomplete="off" onblur="maxMinute(this.value,0);">
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
                            </div>
                            <a href="javascript:void(0);" class="btn btn-info add_button" title="Add field"><i class="fa fa-plus-circle"></i> Add</a>
                            <div class="text-left mt-3">
                                <button type="submit" class="btn btn_org btn-primary">Submit</button>
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
                var fieldHTML = '<div class="row" style="border:1px solid #f19620a6; padding: 10px; border-radius: 5px; margin-bottom: 10px;">\
                                    <h5 class="badge bg-warning text-dark" style="width: auto;">Work List '+(x + 1)+'</h5>\
                                    <div class="col-md-12">\
                                        <label class="control-label">Project</label>\
                                        <br>\
                                        <select name="project[]" data-index="0" class="select_proj form-control" style="font-size: 12px;" autocomplete="off" onchange="getProjectInfo(this.value, ' + x + ');" required>\
                                            <option value="" selected="">Select Project</option>\
                                            <?php if($projects){ foreach($projects as $project){?>
                                                <option value="<?=$project->id?>"><?=$project->name?> (<?=$project->client_name?>) - <?=$project->project_status_name?></option>\
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
        if(inputValue == currentDate){
            var trackerDate = 'Total Added';
        } else {
            var trackerDate = inputValue;
        }
        $('#tracker-date').text(trackerDate);
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
                    // if(res.data.project_time_type == 'Onetime'){
                    //     html += '<span><b>Assigned Fixed :</b> ' + res.data.assigned + '</span><br>';
                    //     html += '<span><b>Booked Current Month :</b> ' + res.data.current_month_booking + '</span><br>';
                    //     html += '<span><b>Total Booked from Start :</b> ' + res.data.total_booked + '</span>';
                    // } else if(res.data.project_time_type == 'Monthlytime'){
                    //     html += '<span><b>Assigned Monthly :</b> ' + res.data.assigned + '</span><br>';
                    //     html += '<span><b>Booked Current Month :</b> ' + res.data.current_month_booking + '</span><br>';
                    //     html += '<span><b>Total Booked from Start :</b> ' + res.data.total_booked + '</span>';
                    // }
                    
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