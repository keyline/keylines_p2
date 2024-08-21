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

    
<div class="container">
	
	<div style="height:600px;width:100%;">
		<table id="myTable" class="table table-condensed table-striped">
            <thead>
                <tr>
                    <th><div class="flextop_date">16-08-2024</div></th>
                    <th class=""> <div class="flextop"> <div>Amalesh Das</div> <div class="datehour">0:00</div></div></th>
                    <th class=""><div class="flextop"><div>Jayshree Mondal</div> <div class="datehour">0:00</div></div></th>
                    <th class=""><div class="flextop"><div>Matinur Rahaman</div> <div class="datehour">0:00</div></th>
                    <th class="fletop"><div class="flextop"><div>Sourav Pal</div> <div class="datehour">0:00</div></th>
                    <th class=""><div class="flextop"><div>Payel Mukherjee</div> <div class="datehour">0:00</div></th>
                    <th class=""><div class="flextop"><div>Poulami Mitra</div> <div class="datehour">0:00</div></th>
                </tr>
            </thead>
			<tbody>
						<tr>
							<th></th>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
                                        <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism 22
                                        </div>
									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
                                
							</td>
                            
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>Leave</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
						</tr>

						<tr>
							<th></th>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
                                        <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>Leave</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
						</tr>

						<tr>
							<th></th>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
							<td>Leave</td>
							<td>
								<div class="tabtasklist_item">
									<h4>Limton / Llounge Promotion :</h4>
									    <div class="taskinfo_text">
                                            Llounge Website Blog Post Then 15 Links Prism
                                        </div>

									<div class="worktask_time">[1hr 25mint]</div>
									<div class="worktask_assign">Sudip Kulovi</div>
								</div>
							</td>
						</tr>

					</tbody>
		</table>
	</div>
</div>
    
    
<!-- </div> -->
<!-- <section class="task-section">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card mb-3">
                    <div class="card-body">
                        
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</section> -->

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
                                        <span style="margin-left : 10px;"><input type="radio" name="priority" id="priority1" value="1" required><label for="priority1" style="margin-left : 3px;">Priority LOW</label></span>
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

