<?php
use App\Models\CommonModel;
$this->common_model = new CommonModel;
$generalSetting     = $this->common_model->find_data('general_settings', 'row');
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$generalSetting->site_name?></title>
</head>
<body>
  <div style="padding: 20px;">
    <div style="text-align: center;"><img style="max-width: 250px;" src="<?=getenv('app.uploadsURL').$generalSetting->site_logo?>" alt="<?=$generalSetting->site_name?>"></div>    
    <div style="background: #f5e6e6; padding: 15px;">
      <h3 style="color: #E40E11; font-family: Arial; margin-top: 0">New task is assigned in KEYLINE TRACKER</h3>
      <p><b><?=$assign_user?>,</b></p>
      <p>Here is your Task Details -</p>
      <p><b>Project Name: </b><a href="<?=$project_url?>" target="_blank"><?=$project_name?></a>(<?=$project_status?>)</p>
      <p><b>Assigned By: </b><?=$assigned_by?></p>
      <p><b>Task description: </b><?=$description?></p>
    </div>    
  </div>
</body>
</html>
