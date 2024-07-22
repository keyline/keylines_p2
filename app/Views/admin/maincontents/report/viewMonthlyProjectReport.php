<style type="text/css">
    #simpletable_filter{
        float: right;
    }
    .simpletable_length label {
        display: inline-flex;
        padding: 10px;
    }
</style>
<div class="pagetitle">
    <h1><?= 'Monthly Report of <b><u>' . $userName->name . '</u></b>'.'<b> ( '.$month.' '.$year.' )</b>'.'' ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="dt-responsive table-responsive">
                        <table id="simpletable" class="table table-striped table-bordered nowrap" style="width: 100%">
                            <thead>
                                <tr>
                                    <th width="1%">#</th>
                                    <th width="5%">Project</th>
                                    <th width="5%">Work Date</th>
                                    <th width="2%">Time</th>
                                    <th width="10%">Description</th>
                                    <th width="10%">Type</th>
                                    <th width="3%">Entry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($rows){ $sl=1; foreach($rows as $row){?>
                                <?php
                                $getProject     = $common_model->find_data('project', 'row', ['id' => $row->project_id], 'name');
                                $getEffortType  = $common_model->find_data('effort_type', 'row', ['id' => $row->effort_type], 'name');
                                ?>
                                <tr>
                                    <th scope="row"><?=$sl++?></th>
                                    <td>
                                        <?=(($getProject)?$getProject->name:'')?>
                                        <p>
                                            <?php if($row->bill == 0){?>
                                                <span class="badge bg-success">Billable</span>
                                            <?php } else {?>
                                                <span class="badge bg-danger">Non-Billable</span>
                                            <?php }?>
                                        </p>
                                    </td>
                                    <td width="10%">
                                        <?=date_format(date_create($row->date_added), "d-m-Y")?>
                                        <!-- <p>
                                            <?php if($row->work_home == 1){?>
                                                <span class="text-primary"><i class="fa fa-home"></i></span>
                                            <?php }?>
                                        </p> -->
                                        <?php
                                        $date1              = date_create($row->date_today);
                                        $date2              = date_create($row->date_added);
                                        $diff               = date_diff($date1,$date2);
                                        $date_difference    = $diff->format("%R%a");
                                        if($date_difference < 0){
                                        ?>
                                        <span class="text-danger">(<?=$date_difference?>)</span>
                                        <?php }?>
                                    </td>
                                    <td><?=$row->hour?>:<?=$row->min?></td>
                                    <td><?=$row->description?></td>
                                    <td><?=(($getEffortType)?$getEffortType->name:'')?></td>
                                    <td width="10%"><?=date_format(date_create($row->date_today), "d-m-Y h:i:s A")?></td>
                                </tr>
                                <?php } }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>