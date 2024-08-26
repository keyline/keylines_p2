<?php
use App\Models\CommonModel;
$this->common_model = new CommonModel;
$generalSetting     = $this->common_model->find_data('general_settings', 'row');
$getDepartment      = $this->common_model->find_data('department', 'row', ['id' => (($getUser)?$getUser->department:'')], 'deprt_name');
?>
<!doctype html>
<html lang="en">
  <head>
    <title><?=$generalSetting->site_name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body>
    <div style="padding: 20px;">
      <div style="text-align: center;"><img style="max-width: 250px;" src="<?=getenv('app.uploadsURL').$generalSetting->site_logo?>" alt="<?=$generalSetting->site_name?>"></div>
      <div style="font-family: Arial;text-transform: uppercase;font-weight: 600;text-align: center;background: #ffe1c3;display: table;margin: 30px auto;padding: 20px;">
        Effort Booking Request Before - <?=date_format(date_create($before_date), "M d, Y")?>
      </div>
      <div style="background: #f5e6e6; padding: 15px;">
        <h3 style="color: #E40E11; font-family: Arial; margin-top: 0">Dear <?=(($getTL)?$getTL->name:'Sir/Madam')?></h3>
        <p>I hope this message finds you well.</p>
        <p> Kindly give me booking access for my backlog tasks.</p>
        <p>Please let me know if there are any specific guidelines or changes you would like to see in the email.</p>
        <p>Thank you for your support.</p>
        <p>
          Best regards,<br>
          <?=(($getUser)?$getUser->name:'')?><br>
          <?=(($getDepartment)?$getDepartment->deprt_name:'')?><br>
          <?=(($getUser)?$getUser->phone1:'')?><br>
          <?=(($getUser)?$getUser->email:'')?>
        </p>
      </div>
    </div>
  </body>
</html>