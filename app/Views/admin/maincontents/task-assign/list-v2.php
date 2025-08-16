<?php
$user_type              = $session->user_type;
$user_id                = $session->user_id;
$getTeamMemberStatus    = $common_model->find_data('team', 'row', ['user_id' => $user_id], 'type');
$team_member_type       = (($getTeamMemberStatus)?$getTeamMemberStatus->type:'');

$title                  = $moduleDetail['title'];
$primary_key            = $moduleDetail['primary_key'];
$controller_route       = $moduleDetail['controller_route'];
?>

<style> 
    #simpletable_filter{
        float: right;
    }
    .simpletable_length label {
        display: inline-flex;
        padding: 10px;
    }
    .charts{
        border: 1px solid #ff980073;
        padding: 10px;
    }
    .task-assign-table th,
    .task-assign-table td,
    .input-group > .card{
        width: 250px !important;
        vertical-align: top !important;
    }
    .input-group > .card{
        margin-bottom: 5px;
    }
    .bg-blue{
        background: #0d6efdc2;
    }
    .card_projectname {
	    padding-bottom: 5px;
	}
	.card_projecttime {
	    font-weight: 700;
	    margin-bottom: 0;
	    padding-top: 10px;
	}
	span.card_priotty_item {
	    position: absolute;
	    right: 0;
	    top: -2px;
	    background: #ddd;
	    padding: 2px 5px;
	    font-size: 10px;
	    font-weight: 600;
	}
	span.card_priotty_item.proiodty_high {
	    background: #ff0404;
	    color: #fff;
	}
	span.card_priotty_item.proiodty_low {
	    background: #f5d74f;
	}
	span.card_priotty_item.proiodty_medium {
	    background: #80edc0;
	}
	a.taskedit_iconright {
	    float: right;
	    margin: inherit;
	}
    th,td{border: 1px solid #ddd;}
    .flextop {
        display: flex;
        justify-content: space-between;
        min-width: 300px;
    }
    .flextop_date{
        min-width: 150px; 
    }
</style>

<!-- <div class="dt-responsive table-responsive"> -->

    
<div class="container-fluid">
	
	<div style="height:800px;width:100%;">
		<table id="myTable" class="table table-condensed table-striped">
            <thead>
            	<tr>
                    <th>
                    	
                    </th>
                    <th class="" colspan="4">
                    	<div class="flextop">
                    		<div>Design</div>
                    	</div>
                    </th>
                    <th class="" colspan="2">
                    	<div class="flextop">
                    		<div>Digital</div>
                    	</div>
                    </th>
                </tr>
                <tr>
                    <th>
                    	
                    </th>
                    <th class="">
                    	<div class="flextop">
                    		<div>Amalesh Das</div>
                    		<div class="datehour">0:00</div>
                    	</div>
                    </th>
                    <th class="">
                    	<div class="flextop">
                    		<div>Jayshree Mondal</div>
                    		<div class="datehour">0:00</div>
                    	</div>
                    </th>
                    <th class="">
                    	<div class="flextop">
                    		<div>Matinur Rahaman</div>
                    		<div class="datehour">0:00</div>
                    	</div>
                    </th>
                    <th class="">
                    	<div class="flextop">
                    		<div>Sourav Pal</div>
                    		<div class="datehour">0:00</div>
                    	</div>
                    </th>
                    <th class="">
                    	<div class="flextop">
                    		<div>Payel Mukherjee</div>
                    		<div class="datehour">0:00</div>
                    	</div>
                    </th>
                    <th class="">
                    	<div class="flextop">
                    		<div>Poulami Mitra</div>
                    		<div class="datehour">0:00</div>
                    	</div>
                    </th>
                </tr>

                
            </thead>
			<tbody>
				<tr>
					<th>
						<div class="flextop">
							<div class="flextop_date">16-08-2024</div>
							<div class="datehour">0:00</div>
						</div>
					</th>
					<td class="text-center">TRACKER</td>
					<td class="text-center">TRACKER</td>
					<td class="text-center">TRACKER</td>
					<td class="text-center">TRACKER</td>
					<td class="text-center">TRACKER</td>
					<td class="text-center">TRACKER</td>
				</tr>
				<tr>
					<th>
						<div class="flextop">
							<div class="flextop_date">Friday</div>
						</div>
					</th>
					<td class="text-center">Punch In - On Time</td>
					<td class="text-center">Punch In - On Time</td>
					<td class="text-center">Punch In - On Time</td>
					<td class="text-center">Punch In - On Time</td>
					<td class="text-center">Punch In - On Time</td>
					<td class="text-center">Punch In - On Time</td>
				</tr>

				<tr>
					<th></th>
					<td>
						<div class="tabtasklist_item">
							<div class="row">
							    <div class="col-12" id="meeting-user-57">
							        <div class="input-group">
							            <div class="card">
							                <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: #FFF;">
							                    <p class="mb-2">
							                        <span class="card_priotty_item proiodty_high">High</span>
							                    </p>
							                    <div class="mb-1 d-block">
							                        <div class="card_projectname"><b>Benud Behari Dutt Pvt. Ltd. :</b> </div>
							                        <div class="card_proj_info">In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.
							                        </div>
							                    </div>
							                    <div class="card_projecttime">
							                        [3 hrs ]
							                    </div>
							                    <div class="d-flex justify-content-between">
							                        <p class="mb-0 assign-name">Subhomoy Samanta</p>
							                        <a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm(2, 57, 'Debojyti Debroy', 116);">
							                        <i class="fa-solid fa-pencil text-primary"></i>
							                        </a>
							                    </div>
							                </div>
							            </div>
							        </div>
							        <div class="input-group">
							            <div class="card">
							                <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: #FFF;">
							                    <p class="mb-2">
							                        <span class="card_priotty_item proiodty_medium">Medium</span>
							                    </p>
							                    <div class="mb-1 d-block">
							                        <div class="card_projectname"><b>Arun Gupta :</b> </div>
							                        <div class="card_proj_info">fsfas fas fas as asdas<br></div>
							                    </div>
							                    <div class="card_projecttime">
							                        [2 hrs ]
							                    </div>
							                    <div class="d-flex justify-content-between">
							                        <p class="mb-0 assign-name">Subhomoy Samanta</p>
							                        <a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm(2, 57, 'Debojyti Debroy', 115);">
							                        <i class="fa-solid fa-pencil text-primary"></i>
							                        </a>
							                    </div>
							                </div>
							            </div>
							        </div>
							        <div class="input-group">
							            <div class="card">
							                <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: #FFF;">
							                    <p class="mb-2">
							                        <span class="card_priotty_item proiodty_high">High</span>
							                    </p>
							                    <div class="mb-1 d-block">
							                        <div class="card_projectname"><b>Benud Behari Dutt Pvt. Ltd. :</b> </div>
							                        <div class="card_proj_info">In publishing and graphic design, Lorem ipsum is a placeholder text commonly used to demonstrate the visual form of a document or a typeface without relying on meaningful content. Lorem ipsum may be used as a placeholder before the final copy is available.
							                        </div>
							                    </div>
							                    <div class="card_projecttime">
							                        [3 hrs ]
							                    </div>
							                    <div class="d-flex justify-content-between">
							                        <p class="mb-0 assign-name">Subhomoy Samanta</p>
							                        <a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm(2, 57, 'Debojyti Debroy', 116);">
							                        <i class="fa-solid fa-pencil text-primary"></i>
							                        </a>
							                    </div>
							                </div>
							            </div>
							        </div>
							        <div class="input-group">
							            <div class="card">
							                <div class="card-body" style="border: 1px solid #0c0c0c4a;width: 100%;padding: 5px;background-color: #fff;border-radius: 6px;text-align: left;vertical-align: top;background-color: #FFF;">
							                    <p class="mb-2">
							                        <span class="card_priotty_item proiodty_low">Low</span>
							                    </p>
							                    <div class="mb-1 d-block">
							                        <div class="card_projectname"><b>Arun Gupta :</b> </div>
							                        <div class="card_proj_info">fsfas fas fas as asdas<br></div>
							                    </div>
							                    <div class="card_projecttime">
							                        [2 hrs ]
							                    </div>
							                    <div class="d-flex justify-content-between">
							                        <p class="mb-0 assign-name">Subhomoy Samanta</p>
							                        <a href="javascript:void(0);" class="task_edit_btn taskedit_iconright" onclick="openEditForm(2, 57, 'Debojyti Debroy', 115);">
							                        <i class="fa-solid fa-pencil text-primary"></i>
							                        </a>
							                    </div>
							                </div>
							            </div>
							        </div>
							        <a href="javascript:void(0);" class="task_edit_btn" onclick="openForm(2, 57, 'Debojyti Debroy');">
							        <i class="fa-solid fa-plus-circle text-success"></i>
							        </a>
							    </div>
							</div>
						</div>
                        
					</td>
                    
					<td>
						<div class="tabtasklist_item">
							
						</div>
					</td>
					<td>
						<div class="tabtasklist_item">
							
						</div>
					</td>
					<td>
						<div class="tabtasklist_item">
							
						</div>
					</td>
					<td>Leave</td>
					<td>
						<div class="tabtasklist_item">
							
						</div>
					</td>
				</tr>			

			</tbody>
		</table>
	</div>
</div>

<!-- lead activity modal -->
    <div class="modal fade" id="morningformModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999999;">
        <div class="modal-dialog" role="document" style="max-width: 50%; margin-top: 20px;">
            <div class="modal-content">
                <div class="modal-header" id="morningformTitle">
                    
                </div>
                <div class="modal-body" id="morningformBody">
                    
                </div>
            </div>
        </div>
    </div>
<!-- lead activity modal -->
<!-- reject task modal -->
 <div class="modal fade" id="taskRescheduleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="z-index: 9999999;">
        <div class="modal-dialog" role="document" style="max-width: 50%; margin-top: 20px;">
            <div class="modal-content">
                <div class="modal-header" id="taskRescheduleTitle">
                    
                </div>
                <div class="modal-body" id="taskRescheduleBody">
                    
                </div>
            </div>
        </div>
    </div>
<!-- reject task modal -->

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    function openForm(deptId, userId, userName){
        $('#morningformModal').modal('show');
        var heading = '<h5>Task Schedule For <strong>' + userName + '</strong></h5>';
        var body    = '';
        body        =   `<form id="morningMeetingForm">
                            <input type="hidden" name="dept_id" id="dept_id" value="${deptId}">
                            <input type="hidden" name="user_id" id="user_id" value="${userId}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <input type="date" name="date_added" id="date_added" placeholder="Schedule Date" class="form-control" value="<?=date('Y-m-d')?>" min="<?=date('Y-m-d')?>" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="input-group mb-1">
                                        <select name="project_id" id="project_id" class="form-control" required>
                                            <option value="" selected="">Select Project</option>
                                            <hr>
                                            <?php if($projects){ foreach($projects as $project){?>
                                                <option value="<?=$project->id?>"><?=$project->name?> (<?=$project->client_name?>) - <?=$project->project_status_name?></option>
                                                <hr>
                                            <?php } }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-1">
                                        <textarea name="description" id="description" placeholder="Description" class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <select name="hour" class="form-control" id="hour" required>
                                            <option value="">Select Hour</option>
                                            <?php for($h=0;$h<=8;$h++){?>
                                                <option value="<?=$h?>" <?=(($h == 0)?'selected':'')?>><?=$h?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <select name="min" class="form-control" id="min" required>
                                            <option value="">Select Minute</option>
                                            <?php for($m=0;$m<=59;$m++){?>
                                                <option value="<?=$m?>" <?=(($m == 0)?'selected':'')?>><?=$m?></option>
                                            <?php }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <span><input type="radio" name="priority" id="priority1" value="1" required><label for="priority1" style="margin-left : 3px;">Priority LOW</label></span>
                                        <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority2" value="2" required><label for="priority2" style="margin-left : 3px;">Priority MEDIUM</label></span>
                                        <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority3" value="3" required><label for="priority3" style="margin-left : 3px;">Priority HIGH</label></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-1">
                                        <button type="button" class="btn btn-success" onClick="submitForm();">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>`;

        $('#morningformTitle').empty();
        $('#morningformBody').empty();
        $('#morningformTitle').html(heading);
        $('#morningformBody').html(body);
    }
    function submitForm(){
        var base_url        = '<?=base_url()?>';
        var dataJson        = {};
        dataJson.dept_id                    = $('#dept_id').val();
        dataJson.user_id                    = $('#user_id').val();
        dataJson.date_added                 = $('#date_added').val();
        dataJson.project_id                 = $('#project_id').val();
        dataJson.description                = $('#description').val();
        dataJson.hour                       = $('#hour').val();
        dataJson.min                        = $('#min').val();
        dataJson.priority                   = $('input[name="priority"]:checked').val();
        dataJson.work_home                  = '';
        var user_id                         = $('#user_id').val();
        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-schedule-submit", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    $('#morningMeetingForm').trigger("reset");
                    $('#morningformModal').modal('hide');
                    $('#meeting-user-' + user_id).empty();
                    $('#meeting-user-' + user_id).html(res.data.scheduleHTML);
                    $('#total-time-' + user_id).html('[' + res.data.totalTime + ']');
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }

    function openEditForm(deptId, userId, userName, scheduleId){
        var base_url                        = '<?=base_url()?>';
        var dataJson                        = {};
        dataJson.dept_id                    = deptId;
        dataJson.user_id                    = userId;
        dataJson.schedule_id                = scheduleId;
        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-schedule-prefill", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    var heading = '<h5>Task Schedule Modify For <strong>' + userName + '</strong></h5>';
                    var body    = res.data;
                    $('#morningformModal').modal('show');
                    $('#morningformTitle').empty();
                    $('#morningformBody').empty();
                    $('#morningformTitle').html(heading);
                    $('#morningformBody').html(body);
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }
    function submitEditForm(){
        var base_url        = '<?=base_url()?>';
        var dataJson        = {};
        dataJson.dept_id                    = $('#dept_id').val();
        dataJson.user_id                    = $('#user_id').val();
        dataJson.schedule_id                = $('#schedule_id').val();
        dataJson.date_added                 = $('#date_added').val();
        dataJson.project_id                 = $('#project_id').val();
        dataJson.description                = $('#description').val();
        dataJson.hour                       = $('#hour').val();
        dataJson.min                        = $('#min').val();
        dataJson.priority                   = $('input[name="priority"]:checked').val();
        dataJson.work_home                  = '';
        var user_id                         = $('#user_id').val();
        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-schedule-update", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    $('#morningMeetingForm').trigger("reset");
                    $('#morningformModal').modal('hide');
                    $('#meeting-user-' + user_id).empty();
                    $('#meeting-user-' + user_id).html(res.data.scheduleHTML);
                    $('#total-time-' + user_id).html('[' + res.data.totalTime + ']');
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }

    function approveTask(schedule_id, effort_id, user_id){
        var base_url                        = '<?=base_url()?>';
        var dataJson                        = {};
        dataJson.schedule_id                = schedule_id;
        dataJson.effort_id                  = effort_id;
        dataJson.user_id                    = user_id;
        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-schedule-approve-task", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    $('.action-' + schedule_id + '-' + user_id).hide();
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }
    function rejectTask(schedule_id, effort_id, user_id){
        var base_url                        = '<?=base_url()?>';
        var dataJson                        = {};
        dataJson.schedule_id                = schedule_id;
        dataJson.effort_id                  = effort_id;
        dataJson.user_id                    = user_id;
        $('#taskRescheduleModal').modal('show');
        var modalTitle  = 'Task Reschedule';
        var modalBody   = `<form id="taskRescheduleForm">
                            <input type="hidden" name="schedule_id" id="schedule_id" value="${schedule_id}">
                            <input type="hidden" name="effort_id" id="effort_id" value="${effort_id}">
                            <input type="hidden" name="user_id" id="user_id" value="${user_id}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-1">
                                        <label for="reschedule_date">Reschedule Date</label>
                                        <input type="date" name="reschedule_date" id="reschedule_date" placeholder="Reschedule Date" class="form-control" value="<?=date('Y-m-d')?>" min="<?=date('Y-m-d')?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group mb-1">
                                        <button type="button" class="btn btn-success" onClick="submitRescheduleTaskForm();">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>`;
        $('#taskRescheduleTitle').empty();
        $('#taskRescheduleBody').empty();
        $('#taskRescheduleTitle').html(modalTitle);
        $('#taskRescheduleBody').html(modalBody);
    }
    function submitRescheduleTaskForm(){
        var base_url                        = '<?=base_url()?>';
        var dataJson                        = {};
        dataJson.schedule_id                = $('#schedule_id').val();
        dataJson.effort_id                  = $('#effort_id').val();
        dataJson.user_id                    = $('#user_id').val();
        dataJson.reschedule_date            = $('#reschedule_date').val();

        schedule_id                         = $('#schedule_id').val();
        effort_id                           = $('#effort_id').val();
        user_id                             = $('#user_id').val();

        $.ajax({
            type: 'POST',
            url: base_url + "admin/task-assign/morning-meeting-reschedule-task", // Replace with your server endpoint
            data: JSON.stringify(dataJson),
            success: function(res) {
                res = $.parseJSON(res);
                if(res.success){
                    $('#taskRescheduleModal').modal('hide');
                    $('#meeting-user-' + user_id).empty();
                    $('#meeting-user-' + user_id).html(res.data.scheduleHTML);
                    $('#total-time-' + user_id).html('[' + res.data.totalTime + ']');
                    $('.action-' + schedule_id + '-' + user_id).hide();
                    toastAlert("success", res.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error); // Handle errors
            }
        });
    }
    $(function(){
        
    })
</script>

