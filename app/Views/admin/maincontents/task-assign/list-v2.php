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
    table thead th { 
        padding: 5px; 
        background-color: #4cb96b; 
/*        position: -webkit-sticky; */
        position: sticky; 
        top: 60px; 
    } 
</style>

<!-- <div class="dt-responsive table-responsive"> -->
   
    <table width="100%">
        <thead> 
            <th>CHARACTER</th> 
            <th>ENCODED FORM</th> 
        </thead> 
        <tbody style="text-align: center;">
            <tr>
                <td colspan="2"><h6 class="badge bg-primary mb-2"><?=date('M d, Y - l', strtotime("-1 days"));?></h6></td>
            </tr> 
            <tr> 
                <td>backspace</td> 
                <td>%08</td> 
            </tr> 
            <tr> 
                <td>tab</td> 
                <td>%09</td> 
            </tr> 
            <tr> 
                <td>linefeed</td> 
                <td>%0A</td> 
            </tr> 
            <tr> 
                <td>c return</td> 
                <td>%0D</td> 
            </tr> 
            <tr> 
                <td>space</td> 
                <td>%20</td> 
            </tr> 
            <tr> 
                <td>!</td> 
                <td>%21</td> 
            </tr> 
            <tr> 
                <td>“</td> 
                <td>%22</td> 
            </tr> 
            <tr> 
                <td>#</td> 
                <td>%23</td> 
            </tr> 
            <tr> 
                <td>$</td> 
                <td>%24</td> 
            </tr> 
            <tr> 
                <td>%</td> 
                <td>%25</td> 
            </tr> 
            <tr> 
                <td>&</td> 
                <td>%26</td> 
            </tr> 
            <tr> 
                <td>‘</td> 
                <td>%27</td> 
            </tr> 
            <tr> 
                <td>(</td> 
                <td>%28</td> 
            </tr> 
            <tr> 
                <td>)</td> 
                <td>%29</td> 
            </tr> 
            <tr> 
                <td>*</td> 
                <td>%2A</td> 
            </tr> 
            <tr> 
                <td>+</td> 
                <td>%2B</td> 
            </tr> 
            <tr> 
                <td>,</td> 
                <td>%2C</td> 
            </tr> 
            <tr> 
                <td>–</td> 
                <td>%2D</td> 
            </tr> 
            <tr> 
                <td>.</td> 
                <td>%2E</td> 
            </tr> 
            <tr> 
                <td>/</td> 
                <td>%2F</td> 
            </tr> 
            <tr> 
                <td>0</td> 
                <td>%30</td> 
            </tr> 
            <tr> 
                <td>1</td> 
                <td>%31</td> 
            </tr> 
            <tr> 
                <td>2</td> 
                <td>%32</td> 
            </tr> 
            <tr> 
                <td>3</td> 
                <td>%33</td> 
            </tr> 
            <tr> 
                <td>4</td> 
                <td>%34</td> 
            </tr> 
            <tr> 
                <td>5</td> 
                <td>%35</td> 
            </tr> 
            <tr> 
                <td>6</td> 
                <td>%36</td> 
            </tr> 
            <tr> 
                <td>7</td> 
                <td>%37</td> 
            </tr> 
            <tr> 
                <td>8</td> 
                <td>%38</td> 
            </tr> 
            <tr> 
                <td>9</td> 
                <td>%39</td> 
            </tr> 
            <tr> 
                <td>backspace</td> 
                <td>%08</td> 
            </tr> 
            <tr> 
                <td>tab</td> 
                <td>%09</td> 
            </tr> 
            <tr> 
                <td>linefeed</td> 
                <td>%0A</td> 
            </tr> 
            <tr> 
                <td>c return</td> 
                <td>%0D</td> 
            </tr> 
            <tr> 
                <td>space</td> 
                <td>%20</td> 
            </tr> 
            <tr> 
                <td>!</td> 
                <td>%21</td> 
            </tr> 
            <tr> 
                <td>“</td> 
                <td>%22</td> 
            </tr> 
            <tr> 
                <td>#</td> 
                <td>%23</td> 
            </tr> 
            <tr> 
                <td>$</td> 
                <td>%24</td> 
            </tr> 
            <tr> 
                <td>%</td> 
                <td>%25</td> 
            </tr> 
            <tr> 
                <td>&</td> 
                <td>%26</td> 
            </tr> 
            <tr> 
                <td>‘</td> 
                <td>%27</td> 
            </tr> 
            <tr> 
                <td>(</td> 
                <td>%28</td> 
            </tr> 
            <tr> 
                <td>)</td> 
                <td>%29</td> 
            </tr> 
            <tr> 
                <td>*</td> 
                <td>%2A</td> 
            </tr> 
            <tr> 
                <td>+</td> 
                <td>%2B</td> 
            </tr> 
            <tr> 
                <td>,</td> 
                <td>%2C</td> 
            </tr> 
            <tr> 
                <td>–</td> 
                <td>%2D</td> 
            </tr> 
            <tr> 
                <td>.</td> 
                <td>%2E</td> 
            </tr> 
            <tr> 
                <td>/</td> 
                <td>%2F</td> 
            </tr> 
            <tr> 
                <td>0</td> 
                <td>%30</td> 
            </tr> 
            <tr> 
                <td>1</td> 
                <td>%31</td> 
            </tr> 
            <tr> 
                <td>2</td> 
                <td>%32</td> 
            </tr> 
            <tr> 
                <td>3</td> 
                <td>%33</td> 
            </tr> 
            <tr> 
                <td>4</td> 
                <td>%34</td> 
            </tr> 
            <tr> 
                <td>5</td> 
                <td>%35</td> 
            </tr> 
            <tr> 
                <td>6</td> 
                <td>%36</td> 
            </tr> 
            <tr> 
                <td>7</td> 
                <td>%37</td> 
            </tr> 
            <tr> 
                <td>8</td> 
                <td>%38</td> 
            </tr> 
            <tr> 
                <td>9</td> 
                <td>%39</td> 
            </tr>
            <tr> 
                <td>backspace</td> 
                <td>%08</td> 
            </tr> 
            <tr> 
                <td>tab</td> 
                <td>%09</td> 
            </tr> 
            <tr> 
                <td>linefeed</td> 
                <td>%0A</td> 
            </tr> 
            <tr> 
                <td>c return</td> 
                <td>%0D</td> 
            </tr> 
            <tr> 
                <td>space</td> 
                <td>%20</td> 
            </tr> 
            <tr> 
                <td>!</td> 
                <td>%21</td> 
            </tr> 
            <tr> 
                <td>“</td> 
                <td>%22</td> 
            </tr> 
            <tr> 
                <td>#</td> 
                <td>%23</td> 
            </tr> 
            <tr> 
                <td>$</td> 
                <td>%24</td> 
            </tr> 
            <tr> 
                <td>%</td> 
                <td>%25</td> 
            </tr> 
            <tr> 
                <td>&</td> 
                <td>%26</td> 
            </tr> 
            <tr> 
                <td>‘</td> 
                <td>%27</td> 
            </tr> 
            <tr> 
                <td>(</td> 
                <td>%28</td> 
            </tr> 
            <tr> 
                <td>)</td> 
                <td>%29</td> 
            </tr> 
            <tr> 
                <td>*</td> 
                <td>%2A</td> 
            </tr> 
            <tr> 
                <td>+</td> 
                <td>%2B</td> 
            </tr> 
            <tr> 
                <td>,</td> 
                <td>%2C</td> 
            </tr> 
            <tr> 
                <td>–</td> 
                <td>%2D</td> 
            </tr> 
            <tr> 
                <td>.</td> 
                <td>%2E</td> 
            </tr> 
            <tr> 
                <td>/</td> 
                <td>%2F</td> 
            </tr> 
            <tr> 
                <td>0</td> 
                <td>%30</td> 
            </tr> 
            <tr> 
                <td>1</td> 
                <td>%31</td> 
            </tr> 
            <tr> 
                <td>2</td> 
                <td>%32</td> 
            </tr> 
            <tr> 
                <td>3</td> 
                <td>%33</td> 
            </tr> 
            <tr> 
                <td>4</td> 
                <td>%34</td> 
            </tr> 
            <tr> 
                <td>5</td> 
                <td>%35</td> 
            </tr> 
            <tr> 
                <td>6</td> 
                <td>%36</td> 
            </tr> 
            <tr> 
                <td>7</td> 
                <td>%37</td> 
            </tr> 
            <tr> 
                <td>8</td> 
                <td>%38</td> 
            </tr> 
            <tr> 
                <td>9</td> 
                <td>%39</td> 
            </tr>
            <tr> 
                <td>backspace</td> 
                <td>%08</td> 
            </tr> 
            <tr> 
                <td>tab</td> 
                <td>%09</td> 
            </tr> 
            <tr> 
                <td>linefeed</td> 
                <td>%0A</td> 
            </tr> 
            <tr> 
                <td>c return</td> 
                <td>%0D</td> 
            </tr> 
            <tr> 
                <td>space</td> 
                <td>%20</td> 
            </tr> 
            <tr> 
                <td>!</td> 
                <td>%21</td> 
            </tr> 
            <tr> 
                <td>“</td> 
                <td>%22</td> 
            </tr> 
            <tr> 
                <td>#</td> 
                <td>%23</td> 
            </tr> 
            <tr> 
                <td>$</td> 
                <td>%24</td> 
            </tr> 
            <tr> 
                <td>%</td> 
                <td>%25</td> 
            </tr> 
            <tr> 
                <td>&</td> 
                <td>%26</td> 
            </tr> 
            <tr> 
                <td>‘</td> 
                <td>%27</td> 
            </tr> 
            <tr> 
                <td>(</td> 
                <td>%28</td> 
            </tr> 
            <tr> 
                <td>)</td> 
                <td>%29</td> 
            </tr> 
            <tr> 
                <td>*</td> 
                <td>%2A</td> 
            </tr> 
            <tr> 
                <td>+</td> 
                <td>%2B</td> 
            </tr> 
            <tr> 
                <td>,</td> 
                <td>%2C</td> 
            </tr> 
            <tr> 
                <td>–</td> 
                <td>%2D</td> 
            </tr> 
            <tr> 
                <td>.</td> 
                <td>%2E</td> 
            </tr> 
            <tr> 
                <td>/</td> 
                <td>%2F</td> 
            </tr> 
            <tr> 
                <td>0</td> 
                <td>%30</td> 
            </tr> 
            <tr> 
                <td>1</td> 
                <td>%31</td> 
            </tr> 
            <tr> 
                <td>2</td> 
                <td>%32</td> 
            </tr> 
            <tr> 
                <td>3</td> 
                <td>%33</td> 
            </tr> 
            <tr> 
                <td>4</td> 
                <td>%34</td> 
            </tr> 
            <tr> 
                <td>5</td> 
                <td>%35</td> 
            </tr> 
            <tr> 
                <td>6</td> 
                <td>%36</td> 
            </tr> 
            <tr> 
                <td>7</td> 
                <td>%37</td> 
            </tr> 
            <tr> 
                <td>8</td> 
                <td>%38</td> 
            </tr> 
            <tr> 
                <td>9</td> 
                <td>%39</td> 
            </tr>
            <tr> 
                <td>backspace</td> 
                <td>%08</td> 
            </tr> 
            <tr> 
                <td>tab</td> 
                <td>%09</td> 
            </tr> 
            <tr> 
                <td>linefeed</td> 
                <td>%0A</td> 
            </tr> 
            <tr> 
                <td>c return</td> 
                <td>%0D</td> 
            </tr> 
            <tr> 
                <td>space</td> 
                <td>%20</td> 
            </tr> 
            <tr> 
                <td>!</td> 
                <td>%21</td> 
            </tr> 
            <tr> 
                <td>“</td> 
                <td>%22</td> 
            </tr> 
            <tr> 
                <td>#</td> 
                <td>%23</td> 
            </tr> 
            <tr> 
                <td>$</td> 
                <td>%24</td> 
            </tr> 
            <tr> 
                <td>%</td> 
                <td>%25</td> 
            </tr> 
            <tr> 
                <td>&</td> 
                <td>%26</td> 
            </tr> 
            <tr> 
                <td>‘</td> 
                <td>%27</td> 
            </tr> 
            <tr> 
                <td>(</td> 
                <td>%28</td> 
            </tr> 
            <tr> 
                <td>)</td> 
                <td>%29</td> 
            </tr> 
            <tr> 
                <td>*</td> 
                <td>%2A</td> 
            </tr> 
            <tr> 
                <td>+</td> 
                <td>%2B</td> 
            </tr> 
            <tr> 
                <td>,</td> 
                <td>%2C</td> 
            </tr> 
            <tr> 
                <td>–</td> 
                <td>%2D</td> 
            </tr> 
            <tr> 
                <td>.</td> 
                <td>%2E</td> 
            </tr> 
            <tr> 
                <td>/</td> 
                <td>%2F</td> 
            </tr> 
            <tr> 
                <td>0</td> 
                <td>%30</td> 
            </tr> 
            <tr> 
                <td>1</td> 
                <td>%31</td> 
            </tr> 
            <tr> 
                <td>2</td> 
                <td>%32</td> 
            </tr> 
            <tr> 
                <td>3</td> 
                <td>%33</td> 
            </tr> 
            <tr> 
                <td>4</td> 
                <td>%34</td> 
            </tr> 
            <tr> 
                <td>5</td> 
                <td>%35</td> 
            </tr> 
            <tr> 
                <td>6</td> 
                <td>%36</td> 
            </tr> 
            <tr> 
                <td>7</td> 
                <td>%37</td> 
            </tr> 
            <tr> 
                <td>8</td> 
                <td>%38</td> 
            </tr> 
            <tr> 
                <td>9</td> 
                <td>%39</td> 
            </tr>
        </tbody> 
    </table>
    
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