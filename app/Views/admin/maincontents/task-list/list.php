<?php
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="pagetitle">
                <h1><?=$page_header?></h1>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
                        <li class="breadcrumb-item active"><?=$page_header?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<?php if(checkModuleFunctionAccess(17,15)){ ?>
<section class="section">
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
            <div class="col-lg-12">
                <div class="card table-card">
                    <div class="card-header">
                        <?php if(checkModuleFunctionAccess(17,16)){ ?>
                        <h5>
                            <button type="button" class="btn btn-outline-success btn-sm js-add-task" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                                        Add <?=$title?>
                            </button>

                        </h5>
                        <?php   } ?>
                    </div>
                    <div class="card-body">
                        <div class="dt-responsive table-responsive">
                            <table id="simpletable" class="table nowrap general_table_style padding-y-10">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Project</th>
                                        <th scope="col">Estimated Hours</th>
                                        <th scope="col">Created At<br>Updated At</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if($rows){ $sl=1; foreach($rows as $row){?>
                                    <tr>
                                        <th scope="row"><?=$sl++?></th>
                                        <td><?=$row->task_name?></td>
                                        <td><?=$row->project_name??'N/A'?></td>
                                        <?php 
                                             if($row->estimated_minutes > 0){
                                                $hours = floor($row->estimated_minutes / 60); 
                                              $minutes = $row->estimated_minutes % 60; 
                                              } else {
                                                $hours = 0;
                                                $minutes = 0;
                                              }
                                            ?>
                                        <td><?= $hours ?> hrs <?= $minutes ?> mins</td>
                                        <td>
                                            <h6>
                                                <?=(($row->created_at != '')?date_format(date_create($row->created_at), "M d, Y h:i A"):'')?>
                                            </h6>
                                            <h6 style="<?=($row->updated_at != '') ? 'border-top: 1px solid #444444; margin-top: 15px; padding: 15px 20px 0; width: auto; display: inline-block;' : ''?>">
                                                <?=(($row->updated_at != '')?date_format(date_create($row->updated_at), "M d, Y h:i A"):'')?>
                                            </h6>
                                        </td>
                                        <td>
                                            <?php if(checkModuleFunctionAccess(17,17)){ ?>
                                            <button
                                                type="button"
                                                class="btn btn-outline-primary btn-sm js-edit-task"
                                                data-bs-toggle="modal"
                                                data-bs-target="#addTaskModal"
                                                data-task-id="<?=esc($row->task_id, 'attr')?>"
                                                data-task-name="<?=esc($row->task_name, 'attr')?>"
                                                data-project-id="<?=esc($row->project_id, 'attr')?>"
                                                data-estimate-hours="<?=esc($hours, 'attr')?>"
                                                data-estimate-minutes="<?=esc($minutes, 'attr')?>"
                                            >
                                                Edit
                                            </button>
                                            <?php } ?>
                                            <!-- </?php if(checkModuleFunctionAccess(17,60)){ ?>
                                            <a href="</?=base_url('admin/' . $controller_route . '/delete/'.encoded($row->$primary_key))?>" class="btn btn-outline-danger btn-sm" title="Delete </?=$title?>" onclick="return confirm('Do You Want To Delete This </?=$title?>');"><i class="fa fa-trash"></i></a>
                                            </?php } ?> -->
                                            <!-- </?php if($row->status){?>
                                                </?php if(checkModuleFunctionAccess(17,18)){ ?>
                                                <a href="</?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-success btn-sm" title="Activate </?=$title?>" onclick="return confirm('Do You Want To Deactivate This </?=$title?>');"><i class="fa fa-check"></i></a>
                                                </?php } ?> -->
                                            <!-- </?php } else {?>
                                                </?php if(checkModuleFunctionAccess(17,19)){ ?>
                                                <a href="</?=base_url('admin/' . $controller_route . '/change-status/'.encoded($row->$primary_key))?>" class="btn btn-outline-warning btn-sm" title="Deactivate </?=$title?>" onclick="return confirm('Do You Want To Activate This </?=$title?>');"><i class="fa fa-times"></i></a>
                                                </?php } ?>
                                            </?php }?> -->
                                        </td>
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
</section>

<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="post" action="<?= current_url() ?>">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addTaskModalLabel">Add <?=$title?></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="task_id" name="id" value="">
          <div class="form-group mb-2">
            <label for="task_name">Task Name</label>
            <input type="text" class="form-control" id="task_name" name="task_name" required>
          </div>
          <div class="form-group mb-2">
            <label for="project_id">Project</label>
            <select class="form-control" id="project_id" name="project_id" required>
              <option value="">Select Project</option>
              <?php if (!empty($projects)) { foreach ($projects as $project) { ?>
                <option value="<?=$project->id?>"><?=$project->name?></option>
              <?php } } ?>
            </select>
          </div>
          <div class="form-group mb-2">
            <label for="estimate_hour">Estimated Hours</label>
            <input type="number" step="0.01" min="0" class="form-control" id="estimate_hour" name="estimate_hour" required>
          </div>
          <div class="form-group mb-2">
            <label for="estimate_minutes">Estimated Minutes</label>
            <input type="number" step="0.01" min="0" class="form-control" id="estimate_minutes" name="estimate_minutes" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="taskSubmitBtn">Save Task</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('addTaskModal');
    if (!modalEl) return;

    modalEl.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        const titleEl = document.getElementById('addTaskModalLabel');
        const submitBtn = document.getElementById('taskSubmitBtn');
        const idInput = document.getElementById('task_id');
        const taskName = document.getElementById('task_name');
        const projectId = document.getElementById('project_id');
        const estimateHours = document.getElementById('estimate_hour');
        const estimateMinutes = document.getElementById('estimate_minutes');

        idInput.value = '';
        taskName.value = '';
        projectId.value = '';
        estimateHours.value = '';
        estimateMinutes.value = '';
        titleEl.textContent = 'Add <?=$title?>';
        submitBtn.textContent = 'Save Task';

        if (trigger && trigger.classList.contains('js-edit-task')) {
            idInput.value = trigger.getAttribute('data-task-id') || '';
            taskName.value = trigger.getAttribute('data-task-name') || '';
            projectId.value = trigger.getAttribute('data-project-id') || '';
            estimateHours.value = trigger.getAttribute('data-estimate-hours') || '';
            estimateMinutes.value = trigger.getAttribute('data-estimate-minutes') || '';

            titleEl.textContent = 'Edit <?=$title?>';
            submitBtn.textContent = 'Update Task';
        }
    });
});
</script>

<?php   } ?>
