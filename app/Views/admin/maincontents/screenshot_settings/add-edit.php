<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
$users              = $common_model->find_data('user','array', ['status' => '1'], 'id, name', );
// ($table, $return_type = 'array', $conditions = '', $select = '*', $join = '', $group_by = '', $order_by = '', $limit = 0, $offset = 0, $orConditions = '')
?>
<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>

            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
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
        <?php
        // if ($row) {
        //     $id                   = $row->id;
        //     $idle_time            = $row->idle_time;
        //     $screenshot_resolution = $row->screenshot_resolution;
        //     $screenshot_time      = $row->screenshot_time;
        // } else {
        //     $id                   = '';
        //     $idle_time            = '';
        //     $screenshot_resolution = '';
        //     $screenshot_time      = '';
        // }
        ?>
        <?php if (checkModuleFunctionAccess(39, 121)) { ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data" >
                       
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-lg-2 col-form-label">Employee Name</label>
                            <div class="col-md-10 col-lg-10">
                                <select name="user_id" class="form-control" id="employee">
                                    <option value="">--Select Employee--</option>
                                   <?php foreach($users as $user){ ?>
                                    <option value="<?php echo $user->id; ?>"><?php echo $user->name; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-lg-2 col-form-label">Screenshot Resolution</label>
                            <div class="col-md-10 col-lg-10">
                                <!-- <input type="text" class="form-control" id="screenshot_resolution" name="screenshot_resolution" value="</?= $screenshot_resolution ?>" required placeholder="e.g. 1920x1080"> -->
                                <input type="text" class="form-control" id="screenshot_resolution" name="screenshot_resolution"  required placeholder="e.g. 1920x1080">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-2 col-lg-2 col-form-label">Idle Time</label>
                            <div class="col-md-10 col-lg-10">
                                <!-- <input type="text" class="form-control" id="idle_time" name="idle_time" value="</?= $idle_time ?>" required placeholder="e.g. 300 (in seconds)"> -->
                                <input type="text" class="form-control" id="idle_time" name="idle_time"  required placeholder="e.g. 300 (in seconds)">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="title" class="col-md-2 col-lg-2 col-form-label">Screenshot time</label>
                            <div class="col-md-10 col-lg-10">
                                <!-- <input type="text" class="form-control" id="screenshot_time" name="screenshot_time" value="</?= $screenshot_time ?>" required placeholder="e.g. 60 (in seconds)"> -->
                                <input type="text" class="form-control" id="screenshot_time" name="screenshot_time"  required placeholder="e.g. 60 (in seconds)">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label  class="col-md-2 col-lg-2 col-form-label">Screenshot Blur</label>
                            <div class="col-md-10 col-lg-10">
                                <input type="radio" value="0" name="blur" id="blur_yes"><label for="blur" >Yes</label>
                                <input type="radio" value="1" name="blur" id="blur_no"><label for="blur" >No</label>
                            </div>
                        </div>
                        <div class="text-center">
                            <!-- <button type="submit" class="btn btn-primary"></?= (($row) ? 'Save' : 'Add') ?></button> -->
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
         <?php } ?>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        $("#employee").on("change", function(){
            var employeeId = $(this).val();
             if (!employeeId) return;

            // var employeeId = $("#employee").val();
            $.ajax({
                url: "<?= base_url('admin/screenshot-settings/fetch') ?>",
                type: "POST",
                dataType: "json",
                data: {
                    user_id: employeeId,
                    <?= csrf_token() ?>: "<?= csrf_hash() ?>",
                },
                success: function (res) {
                    if(res.success){
                       $("#screenshot_resolution").val(res.screenshot_resolution || '');
                        $("#idle_time").val(res.idle_time || '');
                        $("#screenshot_time").val(res.screenshot_time || '');

                                // Reset radios first
                                $("input[name='blur']").prop('checked', false);

                                // Set radio based on blur value
                                if (res.blur == 1) {
                                    $("#blur_yes").prop('checked', true);
                                } else if (res.blur == 0) {
                                    $("#blur_no").prop('checked', true);
                                }
                    }else {
                        console.log("No data not found");
                    $("#screenshot_resolution, #idle_time, #screenshot_time").val('');
                    }
                  },
                error: function (xhr) {
                        console.log(xhr.responseText);  
                }
            })
        })
    })
</script>
