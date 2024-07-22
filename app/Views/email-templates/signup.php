<?php
use App\Models\CommonModel;
$this->common_model = new CommonModel;
$generalSetting     = $this->common_model->find_data('general_settings', 'row');
?>
<!doctype html>
<html lang="en">
  <head>
    <title><?=$generalSetting->site_name?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  </head>
  <body style="padding: 0; margin: 0; box-sizing: border-box;">
    <section style="padding: 80px 0; height: 80vh; margin: 0 15px;">
        <div style="max-width: 600px; background: #ffffff; margin: 0 auto; border-radius: 15px; padding: 20px 15px; box-shadow: 0 0 30px -5px #ccc;">
          <div style="text-align: center;">
              <img src="<?=getenv('app.uploadsURL').$generalSetting->site_logo?>" alt="" style=" width: 100%; max-width: 250px;margin: 0 auto;
    display: flex;">
          </div>
          <div>
            <h3 style="text-align: center; font-size: 25px; color: #5c5b5b; font-family: sans-serif;">Hi, Welcome to <?=$generalSetting->site_name?>!</h3>
            <h5 style="text-align: center; font-size: 15px; color: green; font-family: sans-serif;">Your Account Has Been Successfully Created</h5>
            <table style="width: 100%;  border-spacing: 2px;">
              <tbody>
                <tr>
                  <th style="background: #ffe1c3; color: #000; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Sign In Link</th>
                  <td style="padding: 10px; background: #ffe1c3; text-align: left; color: #000;font-family: sans-serif;font-size: 15px; font-weight: 600;"><a href="<?=base_url()?>" target="_blank" style="text-decoration: none;">Click Here</a></td>
                </tr>
                <tr>
                  <th style="background: #ffe1c3; color: #000; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Email</th>
                  <td style="padding: 10px; background: #ffe1c3; text-align: left; color: #000;font-family: sans-serif;font-size: 15px; font-weight: 600;"><?=$email?></td>
                </tr>
                <tr>
                  <th style="background: #ffe1c3; color: #000; padding: 10px; text-align: left; font-family: sans-serif; font-size: 14px;">Password</th>
                  <td style="padding: 10px; background: #ffe1c3; text-align: left; color: #000;font-family: sans-serif;font-size: 15px; font-weight: 600;"><?=$password?></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div style="border-top: 2px solid #ccc; margin-top: 50px; text-align: center; font-family: sans-serif;">
          <div style="text-align: center; margin: 15px 0 10px;">All right reserved: © <?=date('Y')?> <?=$generalSetting->site_name?></div>
        </div>
      </div>
    </section>
  </body>
</html>