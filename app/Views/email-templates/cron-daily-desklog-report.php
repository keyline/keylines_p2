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
      Desklog Report - <?=date_format(date_create($yesterday_date), "M d, Y")?>
    </div>    
    <div style=" margin: 20px 0; background: #e6eee5; padding: 20px;">      
      <table id="simpletable" class="table padding-y-10 general_table_style">
        <thead>
          <tr>                        
            <th>Name</th>
            <th>Arrival At</th>
            <th>Left At</th>
            <th>Time At Work</th>
            <th>Productive Time</th>            
          </tr>
        </thead>
        <tbody>
          <?php if ($userdata) {              
              foreach ($userdata as $res) { ?>
                  <tr>                      
                      <td><?= $res['name'] ?></td>
                      <td><?= $res['clock_in'] ?></td>
                      <td><?= $res['clock_out'] ?></td>
                      <td><?= $res['time_at_work'] ?></td>
                      <td><?= $res['productive_time'] ?></td>                                  
                  </tr>                  
          <?php } }?>          
        </tbody>
      </table>      
    </div>
  </div>
</body>
</html>
