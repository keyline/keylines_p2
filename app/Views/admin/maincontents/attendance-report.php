<?php
$user = $session->user_type;
//pr($user);
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<style type="text/css">
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
</style>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <!-- <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li> -->
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section dashboard">
    <div class="row">
        <!-- <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="GET" action="" enctype="multipart/form-data">
                        <input type="hidden" name="mode" value="year">
                        <div class="row mb-3 align-items-center">                                                        
                            <div class="col-md-6 col-lg-6" id="day_type_row" style="display:'block'">
                                <label for="year">Years</label>
                                <select name="year" class="form-control" id="year" required>
                                    <option value="2018" <?=(($year == '2018')?'selected':'')?>>2018</option>
                                    <hr>
                                    <option value="2019" <?=(($year == '2019')?'selected':'')?>>2019</option>
                                    <hr>
                                    <option value="2020" <?=(($year == '2020')?'selected':'')?>>2020</option>
                                    <hr>
                                    <option value="2021" <?=(($year == '2021')?'selected':'')?>>2021</option>
                                    <hr>
                                    <option value="2022" <?=(($year == '2022')?'selected':'')?>>2022</option>
                                    <hr>
                                    <option value="2023" <?=(($year == '2023')?'selected':'')?>>2023</option>
                                    <hr>
                                    <option value="2024" <?=(($year == '2024')?'selected':'')?>>2024</option>
                                    <hr>                                    
                                </select>
                            </div>                                                        
                            <div class="col-md-6 col-lg-6" style="margin-top: 20px;">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane"></i> Generate</button>
                                <?php if(!empty($response)){?>
                                    <a href="<?=base_url('admin/reports/advance-search')?>" class="btn btn-secondary"><i class="fa fa-refresh"></i> Reset</a>
                                <?php }?>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> -->
        <!-- Left side columns -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header text-dark">
                    <h5 class="fw-bold text-center heading_style">Last 7 Days Attendance Report</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xxl-12 col-md-12 table-responsive">
                            <table class="table table-striped table-bordered general_table_style">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>User</th>
                                        <?php if (!empty($arr)) {
                                            for ($a = 0; $a < count($arr); $a++) { ?>
                                                <th><?= date_format(date_create($arr[$a]), "d-m-Y") ?></th>
                                        <?php }
                                        } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($last7DaysResponses) {
                                        $sl = 1;
                                        $counter = 0;
                                        foreach ($last7DaysResponses as $res) { ?>
                                            <tr>
                                                <td><?= $sl++ ?></td>
                                                <td class="fw-bold"><?= $res['name'] ?></td>
                                                <?php
                                                $reports = $res['reports'];
                                                foreach ($reports as $report) {
                                                    // $date1              = date_create($report['booked_date']);
                                                    // $date2              = date_create($report['booked_today']);
                                                    // $diff               = date_diff($date1, $date2);
                                                    // $date_difference    = $diff->format("%a");
                                                    $punchIn = $report['punchIn'];
                                                    $punchOut = $report['punchOut'];
                                                    //    echo $report['booked_effort']                                                  
                                                ?>
                                                <td>
                                                    <p onclick="punchin('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['punchIn'] ?>')"><?php if($punchIn > 0){ ?><span class="badge <?=(($punchIn <= 10)?'bg-success':'bg-danger')?>" style="cursor:pointer;">IN: <?=date('H:i', strtotime($punchIn))?></span> <?php } ?></p><br>
                                                   <p onclick="punchout('<?= $res['userId'] ?>','<?= $res['name'] ?>','<?= $report['booked_date'] ?>','<?= $report['punchOut'] ?>')"><?php if($punchOut > 0){ ?><span class="badge" style="background-color: #28c009;cursor:pointer;">OUT: <?=date('H:i', strtotime($punchOut))?></span> <?php } ?></p>
                                                </td>
                                                <?php } ?>
                                            </tr>
                                    <?php $counter++;
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Left side columns -->
        
    </div>
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog wide-modal">
            <div class="modal-content" id="modalBody1" style="height: 650px; width: 900px; overflow-y: scroll;">
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog wide-modal">
            <div class="modal-content" id="modalBody2" style="height: 650px; width: 900px; overflow-y: scroll;">
            </div>
        </div>
    </div>
</section>
<script>
    function punchin(userId, name, date, punchIn) {
        $('#modalBody1').html('');
        $.ajax({
            url: '<?php echo base_url('admin/PunchInRecords'); ?>',
            type: 'GET',
            data: {
                userId: userId,
                name: name,
                date: date,
                punchIn : punchIn
            },
            dataType: 'html',
            success: function(response) {
                $('#modalBody1').html(response);
                $('#myModal1').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching modal content:', error);
            }
        });
    }

    function punchout(userId, name, date, effort_time) {
        $('#modalBody2').html('');
        $.ajax({
            url: '<?php echo base_url('admin/PunchOutRecords'); ?>',
            type: 'GET',
            data: {
                userId: userId,
                name: name,
                date: date,
                effort_time : effort_time
            },
            dataType: 'html',
            success: function(response) {
                $('#modalBody2').html(response);
                $('#myModal2').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error fetching modal content:', error);
            }
        });
    }
</script>