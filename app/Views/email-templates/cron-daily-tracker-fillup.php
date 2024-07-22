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
    <div style="font-family: Arial;text-transform: uppercase;font-weight: 600;text-align: center;background: #ffe1c3;display: table;margin: 30px auto;padding: 20px;">
      Tracker Report - <?=date_format(date_create($yesterday_date), "M d, Y")?>
    </div>
    <div style="background: #f5e6e6; padding: 15px;">
      <h3 style="color: #E40E11; font-family: Arial; margin-top: 0">Not Filled Tracker</h3>
      <ul>
        <?php if($notFilledUsers){ foreach($notFilledUsers as $row1){?>
          <li style="font-family: Arial;padding-bottom: 10px;border-bottom: 1px solid #999;margin-bottom: 10px;"><?=$row1['name']?></li>
        <?php } }?>
      </ul>
    </div>
    <div style=" margin: 20px 0; background: #e6eee5; padding: 20px;">
      <h3 style="color: #0F9C3C; font-family: Arial; margin-top: 0">Filled Tracker</h3>
      <ul>
        <?php if($filledUsers){ foreach($filledUsers as $row2){?>
          <li style="font-family: Arial;padding-bottom: 10px;border-bottom: 1px solid #999;margin-bottom: 10px;"><?=$row2['name']?> (<?=$row2['time']?>)</li>
        <?php } }?>
      </ul>
    </div>
  </div>
</body>
</html>
