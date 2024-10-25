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
    <div style="background: #8bc34a1c; padding: 15px;">
      <h3 style="color: #009688; font-family: Arial; margin-top: 0"><?=$subject?></h3>
      <p><b><?=$added_by?>,</b></p>
      <p>Here is your Booking Details -</p>
      <p><b>Project Name: </b><?=$project_name?></p>
      <p><b>Booked Time: </b><?=$task_created?> - <?=$hour?>:<?=$min?></p>
      <p><b>Booked By: </b><?=$added_by?></p>
      <p><b>Booking description: </b><?=$description?></p>
    </div>    
  </div>
</body>
</html>
