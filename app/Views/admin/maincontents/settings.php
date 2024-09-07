<?php
$user_type = session('user_type');
?>
<div class="pagetitle">
  <h1><?= $page_header ?></h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
      <li class="breadcrumb-item active"><?= $page_header ?></li>
    </ol>
  </nav>
</div><!-- End Page Title -->
<?php //if (checkModuleFunctionAccess(11, 54)) { ?>
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
      <div class="col-xl-2">
        <div class="card">
          <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <?php
            if ($user_type == "CLIENT") {
              if ($client) {  ?>
                <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $client->name ?>" class="rounded-circle">
              <?php }
            } else {
              if ($admin->profile_image != '') { ?>
                <img src="<?= getenv('app.uploadsURL') . 'user/' . $admin->profile_image ?>" alt="<?= $admin->name ?>" class="rounded-circle">
              <?php } else { ?>
                <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $admin->name ?>" class="img-thumbnail" class="rounded-circle" style="width: 150px; height: 150px; margin-top: 10px;">
            <?php }
            } ?>
            <h2><?= session('name') ?></h2>
            <h3><?= session('type') ?></h3>
            <!-- <div class="social-links mt-2">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div> -->
          </div>
        </div>
      </div>
      <div class="col-xl-10">
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab1">Profile</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab3">Change Password</button>
              </li>
              <?php if ($user_type == 'SUPER ADMIN' || $user_type == 'ADMIN') { ?>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab2">General</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab11">Application</button>
                </li>
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab4">Email</button>
                </li>
                <!-- <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab9">Email Templates</button>
            </li> -->
                <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab5">SMS</button>
            </li>
                <!-- <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab6">Footer</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab7">SEO</button>
            </li>
            <li class="nav-item">
              <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab8">Payment</button>
            </li>
            -->
              <?php } ?>
            </ul>

            <div class="tab-content pt-2">
              <?php if ($user_type != "CLIENT") { ?>
                <div class="tab-pane fade show active profile-overview" id="tab1">
                  <!-- profile settings Form -->
                  <form method="POST" action="<?= base_url('admin/profile-settings') ?>" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="name" class="col-md-4 col-lg-3 col-form-label">Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="name" class="form-control" id="name" value="<?= $admin->name ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="email" class="col-md-4 col-lg-3 col-form-label">Primary Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="email" class="form-control" id="email" value="<?= $admin->email ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="phone1" class="col-md-4 col-lg-3 col-form-label">Phone 1</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="phone1" class="form-control" id="phone1" value="<?= $admin->phone1 ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="phone2" class="col-md-4 col-lg-3 col-form-label">Phone 2</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="phone2" class="form-control" id="phone2" value="<?= $admin->phone2 ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="hour_cost" class="col-md-4 col-lg-3 col-form-label">Hour Cost</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="hour_cost" class="form-control" id="hour_cost" value="<?= $admin->hour_cost ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="dob" class="col-md-4 col-lg-3 col-form-label">DOB</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="date" name="dob" class="form-control" max="<?= date('Y-m-d') ?>" id="dob" value="<?= $admin->dob ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="doj" class="col-md-4 col-lg-3 col-form-label">DOJ</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="date" name="doj" class="form-control" id="doj" value="<?= $admin->doj ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="image" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="file" name="image" class="form-control" id="profile_image">
                        <small class="text-info">* Only JPG, JPEG, ICO, SVG, PNG files are allowed</small><br>
                        <?php if ($admin->profile_image != '') { ?>
                          <img src="<?= getenv('app.uploadsURL') . 'user/' . $admin->profile_image ?>" alt="<?= $admin->name ?>" style="width: 150px; height: 150px; margin-top: 10px;">
                        <?php } else { ?>
                          <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $admin->name ?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px;">
                        <?php } ?>
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form><!-- End profile settings Form -->
                </div>
              <?php } else { ?>
                <div class="tab-pane fade show active profile-overview" id="tab1">
                  <!-- profile settings Form -->
                  <form method="POST" action="<?= base_url('admin/profile-settings') ?>" enctype="multipart/form-data">
                    <div class="row mb-3">
                      <label for="name" class="col-md-4 col-lg-3 col-form-label">Name</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="name" class="form-control" id="name" value="<?= $pro->decrypt($client->name) ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="email_1" class="col-md-4 col-lg-3 col-form-label">Primary Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="email_1" class="form-control" id="email_1" value="<?= $pro->decrypt($client->email_1) ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="email_2" class="col-md-4 col-lg-3 col-form-label">Secondary Email</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="email_2" class="form-control" id="email_2" value="<?= $pro->decrypt($client->email_2) ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="phone_1" class="col-md-4 col-lg-3 col-form-label">Phone 1</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="phone_1" class="form-control" id="phone_1" value="<?= $pro->decrypt($client->phone_1) ?>">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="phone_2" class="col-md-4 col-lg-3 col-form-label">Phone 2</label>
                      <div class="col-md-8 col-lg-9">
                        <input type="text" name="phone_2" class="form-control" id="phone_2" value="<?= $pro->decrypt($client->phone_2) ?>">
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                  </form><!-- End profile settings Form -->
                </div>
              <?php } ?>
              <div class="tab-pane fade profile-edit pt-3" id="tab2">
                <!-- general settings Form -->
                <form method="POST" action="<?= base_url('admin/general-settings') ?>" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="site_name" class="col-md-4 col-lg-3 col-form-label">Site Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="site_name" type="text" class="form-control" id="site_name" value="<?= $setting->site_name ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="site_phone" class="col-md-4 col-lg-3 col-form-label">Site Phone</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="site_phone" type="text" class="form-control" id="site_phone" value="<?= $setting->site_phone ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="site_mail" class="col-md-4 col-lg-3 col-form-label">Site Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="site_mail" type="email" class="form-control" id="site_mail" value="<?= $setting->site_mail ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="system_email" class="col-md-4 col-lg-3 col-form-label">System Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="system_email" type="email" class="form-control" id="system_email" value="<?= $setting->system_email ?>">
                    </div>
                  </div>
                  <!-- <div class="row mb-3">
                    <label for="site_url" class="col-md-4 col-lg-3 col-form-label">Site URL</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="site_url" type="text" class="form-control" id="site_url" value="<?= $setting->site_url ?>">
                    </div>
                  </div> -->
                  <div class="row mb-3">
                    <label for="description" class="col-md-4 col-lg-3 col-form-label">Address</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="description" class="form-control" id="description" rows="5"><?= $setting->description ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="copyright_statement" class="col-md-4 col-lg-3 col-form-label">Copyright Statement</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="copyright_statement" class="form-control" id="copyright_statement" rows="5"><?= $setting->copyright_statement ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="google_map_api_code" class="col-md-4 col-lg-3 col-form-label">Google Map API Code</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="google_map_api_code" class="form-control" id="google_map_api_code" rows="5"><?= $setting->google_map_api_code ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="google_analytics_code" class="col-md-4 col-lg-3 col-form-label">Google Analytics Code</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="google_analytics_code" class="form-control" id="google_analytics_code" rows="5"><?= $setting->google_analytics_code ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="google_pixel_code" class="col-md-4 col-lg-3 col-form-label">Google Pixel Code</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="google_pixel_code" class="form-control" id="google_pixel_code" rows="5"><?= $setting->google_pixel_code ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="facebook_tracking_code" class="col-md-4 col-lg-3 col-form-label">Facebook Tracking Code</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="facebook_tracking_code" class="form-control" id="facebook_tracking_code" rows="5"><?= $setting->facebook_tracking_code ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="gst_api_code" class="col-md-4 col-lg-3 col-form-label">GST API Code</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="gst_api_code" class="form-control" id="gst_api_code" rows="3"><?= $setting->gst_api_code ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="firebase_server_key" class="col-md-4 col-lg-3 col-form-label">Firebase Server Key</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="firebase_server_key" class="form-control" id="firebase_server_key" rows="3"><?= $setting->firebase_server_key ?></textarea>
                    </div>
                  </div>                  
                  <div class="row mb-3">
                    <label for="twitter_profile" class="col-md-4 col-lg-3 col-form-label">Twitter Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="twitter_profile" type="text" class="form-control" id="twitter_profile" value="<?= $setting->twitter_profile ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="facebook_profile" class="col-md-4 col-lg-3 col-form-label">Facebook Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="facebook_profile" type="text" class="form-control" id="facebook_profile" value="<?= $setting->facebook_profile ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="instagram_profile" class="col-md-4 col-lg-3 col-form-label">Instagram Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="instagram_profile" type="text" class="form-control" id="instagram_profile" value="<?= $setting->instagram_profile ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="linkedin_profile" class="col-md-4 col-lg-3 col-form-label">Pinterest Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="linkedin_profile" type="text" class="form-control" id="linkedin_profile" value="<?= $setting->linkedin_profile ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="youtube_profile" class="col-md-4 col-lg-3 col-form-label">Youtube Profile</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="youtube_profile" type="text" class="form-control" id="youtube_profile" value="<?= $setting->youtube_profile ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="site_logo" class="col-md-4 col-lg-3 col-form-label">Logo</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="file" name="site_logo" class="form-control" id="site_logo">
                      <small class="text-info">* Only jpg, jpeg, png, ico, SVG files are allowed</small><br>
                      <?php if ($setting->site_logo != '') { ?>
                        <img src="<?= getenv('app.uploadsURL') . $setting->site_logo ?>" alt="<?= $setting->site_name ?>">
                      <?php } else { ?>
                        <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $setting->site_name ?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px;">
                      <?php } ?>

                      <!-- <div class="pt-2">
                      <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Remove Image"><i class="bi bi-trash"></i></a>
                    </div> -->
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="site_footer_logo" class="col-md-4 col-lg-3 col-form-label">Footer Logo</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="file" name="site_footer_logo" class="form-control" id="site_footer_logo">
                      <small class="text-info">* Only jpg, jpeg, png, ico, SVG files are allowed</small><br>
                      <?php if ($setting->site_footer_logo != '') { ?>
                        <img src="<?= getenv('app.uploadsURL') . $setting->site_footer_logo ?>" alt="<?= $setting->site_name ?>">
                      <?php } else { ?>
                        <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $setting->site_name ?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px;">
                      <?php } ?>

                      <!-- <div class="pt-2">
                      <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Remove Image"><i class="bi bi-trash"></i></a>
                    </div> -->
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="site_favicon" class="col-md-4 col-lg-3 col-form-label">Favicon</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="file" name="site_favicon" class="form-control" id="site_favicon">
                      <small class="text-info">* Only jpg, jpeg, png, ico, SVG files are allowed</small><br>
                      <?php if ($setting->site_favicon != '') { ?>
                        <img src="<?= getenv('app.uploadsURL') . $setting->site_favicon ?>" alt="<?= $setting->site_name ?>">
                      <?php } else { ?>
                        <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $setting->site_name ?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px;">
                      <?php } ?>

                      <!-- <div class="pt-2">
                      <a href="javascript:void(0);" class="btn btn-danger btn-sm" title="Remove Image"><i class="bi bi-trash"></i></a>
                    </div> -->
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form><!-- End general settings Form -->
              </div>
              <div class="tab-pane fade profile-edit pt-3" id="tab11">
                <!-- application settings Form -->
                <form method="POST" action="<?= base_url('admin/application-settings') ?>" enctype="multipart/form-data">                  
                  <div class="row mb-3">
                    <label for="theme_color" class="col-md-4 col-lg-3 col-form-label">Theme Color</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="theme_color" type="color" class="form-control" id="theme_color" value="<?= $application_setting->theme_color ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="font_color" class="col-md-4 col-lg-3 col-form-label">Font Color</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="font_color" type="color" class="form-control" id="font_color" value="<?= $application_setting->font_color ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="tomorrow_task_editing_time" class="col-md-4 col-lg-3 col-form-label">Tomorrow Task Editing Time</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="tomorrow_task_editing_time" type="time" class="form-control" id="tomorrow_task_editing_time" value="<?= $application_setting->tomorrow_task_editing_time ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="block_tracker_fillup_after_days" class="col-md-4 col-lg-3 col-form-label">Block Tracker Fillup After Days</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="block_tracker_fillup_after_days" type="number" class="form-control" id="block_tracker_fillup_after_days" value="<?= $application_setting->block_tracker_fillup_after_days ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="amc_checking_after_days" class="col-md-4 col-lg-3 col-form-label">AMC Checking After Days</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="amc_checking_after_days" type="number" class="form-control" id="amc_checking_after_days" value="<?= $amc_setting->check_span ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="api_url" class="col-md-4 col-lg-3 col-form-label">API URL</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="api_url" type="text" class="form-control" id="api_url" value="<?=$application_setting->api_url?>" <?=(($application_setting->api_url != '')?'readonly':'')?>>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="api_key" class="col-md-4 col-lg-3 col-form-label">API KEY</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="api_key" type="text" class="form-control" id="api_key" value="<?=$application_setting->api_key?>" <?=(($application_setting->api_key != '')?'readonly':'')?>>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="is_desklog_use" class="col-md-4 col-lg-3 col-form-label">Use Desklog</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_desklog_use" id="is_desklog_user" value="1" <?=(($application_setting->is_desklog_use == 1)?'checked':'')?>>
                        <label class="form-check-label" for="is_desklog_use1">YES/NO</label>                        
                      </div>                      
                    </div>
                  </div>  
                  <div class="row mb-3">
                    <label for="is_task_approval" class="col-md-4 col-lg-3 col-form-label">Task Approval Process</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_task_approval" id="is_task_approval1" value="1" <?=(($application_setting->is_task_approval == 1)?'checked':'')?>>
                        <label class="form-check-label" for="is_desklog_use1">YES/NO</label>                       
                      </div>                      
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="is_project_cost" class="col-md-4 col-lg-3 col-form-label">Unit Cost Calculation</label>
                    <div class="col-md-8 col-lg-9">
                      <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="is_project_cost" id="is_project_cost" value="1" <?=(($application_setting->is_project_cost == 1)?'checked':'')?>>
                        <label class="form-check-label" for="is_desklog_use1">YES/NO</label>                       
                      </div>                      
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="encryption_api_secret_key" class="col-md-4 col-lg-3 col-form-label">Encryption API Secret Key</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="encryption_api_secret_key" type="text" class="form-control" id="encryption_api_secret_key" value="<?=$application_setting->encryption_api_secret_key?>" <?=(($application_setting->encryption_api_secret_key != '')?'readonly':'')?>>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="encryption_api_secret_iv" class="col-md-4 col-lg-3 col-form-label">Encryption API Secret IV</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="encryption_api_secret_iv" type="text" class="form-control" id="encryption_api_secret_iv" value="<?=$application_setting->encryption_api_secret_iv?>" <?=(($application_setting->encryption_api_secret_iv != '')?'readonly':'')?>>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="encryption_api_encrypt_method" class="col-md-4 col-lg-3 col-form-label">Encryption API Encryption Method</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="encryption_api_encrypt_method" type="text" class="form-control" id="encryption_api_encrypt_method" value="<?=$application_setting->encryption_api_encrypt_method?>" <?=(($application_setting->encryption_api_encrypt_method != '')?'readonly':'')?>>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="google_map_api_code" class="col-md-4 col-lg-3 col-form-label">Google Map API Code</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="google_map_api_code" type="text" class="form-control" id="google_map_api_code" value="<?=$application_setting->google_map_api_code?>" <?=(($application_setting->google_map_api_code != '')?'readonly':'')?>>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="allow_punch_distance" class="col-md-4 col-lg-3 col-form-label">Allow Punch Distance (In Meters)</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="allow_punch_distance" type="text" class="form-control" id="allow_punch_distance" value="<?=$application_setting->allow_punch_distance?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="current_date_tasks_show_in_effort" class="col-md-4 col-lg-3 col-form-label">Current Date Tasks Show In Effort Time After</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="current_date_tasks_show_in_effort" type="time" class="form-control" id="current_date_tasks_show_in_effort" value="<?= $application_setting->current_date_tasks_show_in_effort ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="block_tracker_fillup_after_days" class="col-md-4 col-lg-3 col-form-label">Monthly Minimum Effort Time</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="monthly_minimum_effort_time" type="number" class="form-control" id="monthly_minimum_effort_time" value="<?= $application_setting->monthly_minimum_effort_time ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="block_tracker_fillup_after_days" class="col-md-4 col-lg-3 col-form-label">Daily Minimum Effort Time</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="daily_minimum_effort_time" type="number" class="form-control" id="daily_minimum_effort_time" value="<?= $application_setting->daily_minimum_effort_time ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="mark_later_after" class="col-md-4 col-lg-3 col-form-label">Mark Later After (24 hrs)</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="mark_later_after" type="time" class="form-control" id="mark_later_after" value="<?= $application_setting->mark_later_after ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="currency" class="col-md-4 col-lg-3 col-form-label">Currency</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="currency" type="text" class="form-control" id="currency" value="<?= $application_setting->currency ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="week_off" class="col-form-label">Week Off</label>
                    <br>
                    <div class="col-md-8 col-lg-9">
                      <label for="sunday" class="col-md-4 col-lg-3 col-form-label">Sunday: </label>
                      <?php
                        $sunday_values = json_decode($application_setting->sunday, true);
                        // pr($sunday_values);
                        for ($i = 1; $i <= 5; $i++) {
                            $checked        = in_array($i, $sunday_values) ? 'checked' : '';
                            $ordinal_number = ordinal($i);
                            echo "<div class='form-check form-check-inline'>
                                    <input class='form-check-input' name='sunday[]' type='checkbox' id='sunday_$i' value='$i' $checked>
                                    <label class='form-check-label' for='sunday_$i'>$ordinal_number</label>
                                  </div>";
                        }
                      ?>                      
                    </div>
                    <div class="col-md-8 col-lg-9">
                      <label for="is_project_cost" class="col-md-4 col-lg-3 col-form-label">Monday: </label>
                      <?php
                        $monday_values = json_decode($application_setting->monday, true);
                        // pr($monday_values);
                        for ($i = 1; $i <= 5; $i++) {
                            $checked        = in_array($i, $monday_values) ? 'checked' : '';
                            $ordinal_number = ordinal($i);
                            echo "<div class='form-check form-check-inline'>
                                    <input class='form-check-input' name='monday[]' type='checkbox' id='monday_$i' value='$i' $checked>
                                    <label class='form-check-label' for='monday_$i'>$ordinal_number</label>
                                  </div>";
                        }
                      ?>      
                    </div>
                    <div class="col-md-8 col-lg-9">
                      <label for="is_project_cost" class="col-md-4 col-lg-3 col-form-label">Tuesday: </label>
                      <?php
                        $tuesday_values = json_decode($application_setting->tuesday, true);
                        // pr($tuesday_values);
                        for ($i = 1; $i <= 5; $i++) {
                            $checked = in_array($i, $tuesday_values) ? 'checked' : '';
                            $ordinal_number = ordinal($i);
                            echo "<div class='form-check form-check-inline'>
                                    <input class='form-check-input' name='tuesday[]' type='checkbox' id='tuesday_$i' value='$i' $checked>
                                    <label class='form-check-label' for='tuesday_$i'>$ordinal_number</label>
                                  </div>";
                        }
                      ?>      
                    </div>
                    <div class="col-md-8 col-lg-9">
                      <label for="is_project_cost" class="col-md-4 col-lg-3 col-form-label">Wednesday: </label>
                      <?php
                        $wednesday_values = json_decode($application_setting->wednesday, true);
                        // pr($wednesday_values);
                        for ($i = 1; $i <= 5; $i++) {
                            $checked = in_array($i, $wednesday_values) ? 'checked' : '';
                            $ordinal_number   = ordinal($i);
                            echo "<div class='form-check form-check-inline'>
                                    <input class='form-check-input' name='wednesday[]' type='checkbox' id='wednesday_$i' value='$i' $checked>
                                    <label class='form-check-label' for='wednesday_$i'>$ordinal_number</label>
                                  </div>";
                        }
                      ?>      
                    </div>
                    <div class="col-md-8 col-lg-9">
                      <label for="is_project_cost" class="col-md-4 col-lg-3 col-form-label">Thursday: </label>
                      <?php
                        $thursday_values  = json_decode($application_setting->thursday, true);
                        // pr($thursday_values);
                        for ($i = 1; $i <= 5; $i++) {
                            $checked = in_array($i, $thursday_values) ? 'checked' : '';
                            $ordinal_number   = ordinal($i);
                            echo "<div class='form-check form-check-inline'>
                                    <input class='form-check-input' name='thursday[]' type='checkbox' id='thursday_$i' value='$i' $checked>
                                    <label class='form-check-label' for='thursday_$i'>$ordinal_number</label>
                                  </div>";
                        }
                      ?>      
                    </div>
                    <div class="col-md-8 col-lg-9">
                      <label for="is_project_cost" class="col-md-4 col-lg-3 col-form-label">Friday: </label>
                      <?php
                        $friday_values  = json_decode($application_setting->friday, true);
                        // pr($friday_values);
                        for ($i = 1; $i <= 5; $i++) {
                            $checked = in_array($i, $friday_values) ? 'checked' : '';
                            $ordinal_number = ordinal($i);
                            echo "<div class='form-check form-check-inline'>
                                    <input class='form-check-input' name='friday[]' type='checkbox' id='friday_$i' value='$i' $checked>
                                    <label class='form-check-label' for='friday_$i'>$ordinal_number</label>
                                  </div>";
                        }
                      ?>      
                    </div>
                    <div class="col-md-8 col-lg-9">
                      <label for="is_project_cost" class="col-md-4 col-lg-3 col-form-label">Satarday: </label>
                      <?php
                        $satarday_values  = json_decode($application_setting->satarday, true);
                        // pr($satarday_values);
                        for ($i = 1; $i <= 5; $i++) {
                            $checked = in_array($i, $satarday_values) ? 'checked' : '';
                            $ordinal_number   = ordinal($i);
                            echo "<div class='form-check form-check-inline'>
                                    <input class='form-check-input' name='satarday[]' type='checkbox' id='satarday_$i' value='$i' $checked>
                                    <label class='form-check-label' for='satarday_$i'>$ordinal_number</label>
                                  </div>";
                        }
                      ?>      
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form><!-- End general settings Form -->
              </div>
              <div class="tab-pane fade pt-3" id="tab3">
                <!-- change password Form -->
                <form method="POST" action="<?= base_url('admin/change-password') ?>" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="old_password" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="password" name="old_password" class="form-control" id="old_password">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="new_password" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="password" name="new_password" class="form-control" id="new_password">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="confirm_password" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="password" name="confirm_password" class="form-control" id="confirm_password">
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form><!-- End change password Form -->
              </div>
              <div class="tab-pane fade pt-3" id="tab4">
                <h3>Email Configuration</h3>
                <!-- email settings Form -->
                <form method="POST" action="<?= base_url('admin/email-settings') ?>" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="from_email" class="col-md-4 col-lg-3 col-form-label">From Email</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="from_email" class="form-control" id="from_email" value="<?= $setting->from_email ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="from_name" class="col-md-4 col-lg-3 col-form-label">From Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="from_name" class="form-control" id="from_name" value="<?= $setting->from_name ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="smtp_host" class="col-md-4 col-lg-3 col-form-label">SMTP Host</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="smtp_host" class="form-control" id="smtp_host" value="<?= $setting->smtp_host ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="smtp_username" class="col-md-4 col-lg-3 col-form-label">SMTP Username</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="smtp_username" class="form-control" id="smtp_username" value="<?= $setting->smtp_username ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="smtp_password" class="col-md-4 col-lg-3 col-form-label">SMTP Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="smtp_password" class="form-control" id="smtp_password" value="<?= $setting->smtp_password ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="smtp_port" class="col-md-4 col-lg-3 col-form-label">SMTP Port</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="smtp_port" class="form-control" id="smtp_port" value="<?= $setting->smtp_port ?>">
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form><!-- End email settings Form -->
                <h3>Test Email</h3>
                <a href="<?= base_url('admin/test-email') ?>" class="btn btn-success"><i class="fa fa-envelope"></i> Click To Send Test Email</a>
              </div>
              <div class="tab-pane fade pt-3" id="tab5">
                <!-- sms settings Form -->
                <form method="POST" action="<?= base_url('admin/sms-settings') ?>" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="sms_authentication_key" class="col-md-4 col-lg-3 col-form-label">Authentication Key</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="sms_authentication_key" class="form-control" id="sms_authentication_key" value="<?= $setting->sms_authentication_key ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="sms_sender_id" class="col-md-4 col-lg-3 col-form-label">Sender ID</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="sms_sender_id" class="form-control" id="sms_sender_id" value="<?= $setting->sms_sender_id ?>">
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="sms_base_url" class="col-md-4 col-lg-3 col-form-label">Base URL</label>
                    <div class="col-md-8 col-lg-9">
                      <input type="text" name="sms_base_url" class="form-control" id="sms_base_url" value="<?= $setting->sms_base_url ?>">
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form><!-- End sms settings Form -->
              </div>
              <div class="tab-pane fade pt-3" id="tab6">
                <!-- footer settings Form -->
                <form method="POST" action="<?= base_url('admin/footer-settings') ?>" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="footer_text" class="col-md-4 col-lg-3 col-form-label">Footer Text</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea type="text" name="footer_text" class="form-control" id="footer_text" rows="5"><?= $setting->footer_text ?></textarea>
                    </div>
                  </div>
                  <label for="" class="col-md-4 col-lg-3 col-form-label">Column 1</label>
                  <div class="field_wrapper1" style="border: 1px solid #8144f0;padding: 10px;margin-bottom: 10px;">
                    <?php
                    $footer_link_name = (($setting->footer_link_name != '') ? json_decode($setting->footer_link_name) : []);
                    $footer_link = (($setting->footer_link != '') ? json_decode($setting->footer_link) : []);
                    if (!empty($footer_link_name)) {
                      for ($i = 0; $i < count($footer_link_name); $i++) {
                    ?>
                        <div class="row">
                          <div class="col-md-5">
                            <label for="lefticon" class="control-label">Link Text<span class="red">*</span></label>
                            <span class="input-with-icon">
                              <input type="text" class="form-control requiredCheck" data-check="Link Text" name="footer_link_name[]" value="<?= $footer_link_name[$i] ?>" autocomplete="off">
                            </span>
                          </div>
                          <div class="col-md-5">
                            <label for="lefticon" class="control-label">Link<span class="red">*</span></label>
                            <span class="input-with-icon">
                              <input type="text" class="form-control requiredCheck" data-check="Link" value="<?= $footer_link[$i] ?>" name="footer_link[]" autocomplete="off">
                            </span>
                          </div>
                          <div class="col-md-2" style="margin-top: 26px;">
                            <a href="javascript:void(0);" class="remove_button1" title="Add field"><i class="fa fa-minus-circle fa-2x text-danger"></i></a>
                          </div>
                        </div>
                    <?php }
                    } ?>
                    <div class="row">
                      <div class="col-md-5">
                        <label for="lefticon" class="control-label">Link Text<span class="red">*</span></label>
                        <span class="input-with-icon">
                          <input type="text" class="form-control requiredCheck" data-check="Link Text" name="footer_link_name[]" autocomplete="off">
                        </span>
                      </div>
                      <div class="col-md-5">
                        <label for="lefticon" class="control-label">Link<span class="red">*</span></label>
                        <span class="input-with-icon">
                          <input type="text" class="form-control requiredCheck" data-check="Link" name="footer_link[]" autocomplete="off">
                        </span>
                      </div>
                      <div class="col-md-2" style="margin-top: 26px;">
                        <a href="javascript:void(0);" class="add_button1" title="Add field"><i class="fa fa-plus-circle fa-2x text-success"></i></a>
                      </div>
                    </div>
                  </div>
                  <label for="" class="col-md-4 col-lg-3 col-form-label">GET HELP</label>
                  <div class="field_wrapper2" style="border: 1px solid #8144f0;padding: 10px;margin-bottom: 10px;">
                    <?php
                    $footer_link_name2 = (($setting->footer_link_name2 != '') ? json_decode($setting->footer_link_name2) : []);
                    $footer_link2 = (($setting->footer_link2 != '') ? json_decode($setting->footer_link2) : []);
                    if (!empty($footer_link_name2)) {
                      for ($i = 0; $i < count($footer_link_name2); $i++) {
                    ?>
                        <div class="row">
                          <div class="col-md-5">
                            <label for="lefticon" class="control-label">Link Text<span class="red">*</span></label>
                            <span class="input-with-icon">
                              <input type="text" class="form-control requiredCheck" data-check="Link Text" name="footer_link_name2[]" value="<?= $footer_link_name2[$i] ?>" autocomplete="off">
                            </span>
                          </div>
                          <div class="col-md-5">
                            <label for="lefticon" class="control-label">Link<span class="red">*</span></label>
                            <span class="input-with-icon">
                              <input type="text" class="form-control requiredCheck" data-check="Link" value="<?= $footer_link2[$i] ?>" name="footer_link2[]" autocomplete="off">
                            </span>
                          </div>
                          <div class="col-md-2" style="margin-top: 26px;">
                            <a href="javascript:void(0);" class="remove_button2" title="Add field"><i class="fa fa-minus-circle fa-2x text-danger"></i></a>
                          </div>
                        </div>
                    <?php }
                    } ?>
                    <div class="row">
                      <div class="col-md-5">
                        <label for="lefticon" class="control-label">Link Text<span class="red">*</span></label>
                        <span class="input-with-icon">
                          <input type="text" class="form-control requiredCheck" data-check="Link Text" name="footer_link_name2[]" autocomplete="off">
                        </span>
                      </div>
                      <div class="col-md-5">
                        <label for="lefticon" class="control-label">Link<span class="red">*</span></label>
                        <span class="input-with-icon">
                          <input type="text" class="form-control requiredCheck" data-check="Link" name="footer_link2[]" autocomplete="off">
                        </span>
                      </div>
                      <div class="col-md-2" style="margin-top: 26px;">
                        <a href="javascript:void(0);" class="add_button2" title="Add field"><i class="fa fa-plus-circle fa-2x text-success"></i></a>
                      </div>
                    </div>
                  </div>
                  <label for="" class="col-md-4 col-lg-3 col-form-label">SERVICES</label>
                  <div class="field_wrapper3" style="border: 1px solid #8144f0;padding: 10px;margin-bottom: 10px;">
                    <?php
                    $footer_link_name3 = (($setting->footer_link_name3 != '') ? json_decode($setting->footer_link_name3) : []);
                    $footer_link3 = (($setting->footer_link3 != '') ? json_decode($setting->footer_link3) : []);
                    if (!empty($footer_link_name3)) {
                      for ($i = 0; $i < count($footer_link_name3); $i++) {
                    ?>
                        <div class="row">
                          <div class="col-md-5">
                            <label for="lefticon" class="control-label">Link Text<span class="red">*</span></label>
                            <span class="input-with-icon">
                              <input type="text" class="form-control requiredCheck" data-check="Link Text" name="footer_link_name3[]" value="<?= $footer_link_name3[$i] ?>" autocomplete="off">
                            </span>
                          </div>
                          <div class="col-md-5">
                            <label for="lefticon" class="control-label">Link<span class="red">*</span></label>
                            <span class="input-with-icon">
                              <input type="text" class="form-control requiredCheck" data-check="Link" value="<?= $footer_link3[$i] ?>" name="footer_link3[]" autocomplete="off">
                            </span>
                          </div>
                          <div class="col-md-2" style="margin-top: 26px;">
                            <a href="javascript:void(0);" class="remove_button3" title="Add field"><i class="fa fa-minus-circle fa-2x text-danger"></i></a>
                          </div>
                        </div>
                    <?php }
                    } ?>
                    <div class="row">
                      <div class="col-md-5">
                        <label for="lefticon" class="control-label">Link Text<span class="red">*</span></label>
                        <span class="input-with-icon">
                          <input type="text" class="form-control requiredCheck" data-check="Link Text" name="footer_link_name3[]" autocomplete="off">
                        </span>
                      </div>
                      <div class="col-md-5">
                        <label for="lefticon" class="control-label">Link<span class="red">*</span></label>
                        <span class="input-with-icon">
                          <input type="text" class="form-control requiredCheck" data-check="Link" name="footer_link3[]" autocomplete="off">
                        </span>
                      </div>
                      <div class="col-md-2" style="margin-top: 26px;">
                        <a href="javascript:void(0);" class="add_button3" title="Add field"><i class="fa fa-plus-circle fa-2x text-success"></i></a>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form><!-- End footer settings Form -->
              </div>
              <div class="tab-pane fade pt-3" id="tab7">
                <!-- seo settings Form -->
                <form method="POST" action="<?= base_url('admin/seo-settings') ?>" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="meta_title" class="col-md-4 col-lg-3 col-form-label">Meta Title</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="meta_title" class="form-control" id="meta_title" rows="5"><?= $setting->meta_title ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="meta_description" class="col-md-4 col-lg-3 col-form-label">Meta Description</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="meta_description" class="form-control" id="meta_description" rows="5"><?= $setting->meta_description ?></textarea>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="meta_keywords" class="col-md-4 col-lg-3 col-form-label">Meta Keywords</label>
                    <div class="col-md-8 col-lg-9">
                      <textarea name="meta_keywords" class="form-control" id="meta_keywords" rows="5"><?= $setting->meta_keywords ?></textarea>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form><!-- End seo settings Form -->
              </div>
              <div class="tab-pane fade pt-3" id="tab8">
                <!-- payment settings Form -->
                <form method="POST" action="<?= base_url('admin/payment-settings') ?>" enctype="multipart/form-data">
                  <div class="row mb-3">
                    <label for="stripe_payment_type" class="col-md-4 col-lg-3 col-form-label">Stripe Sandbox Secret Key</label>
                    <div class="col-md-8 col-lg-9">
                      <select name="stripe_payment_type" class="form-control" id="stripe_payment_type" required>
                        <option value="" selected>Select Payment Environment</option>
                        <option value="1" <?= (($setting->stripe_payment_type == 1) ? 'selected' : '') ?>>SANDBOX</option>
                        <option value="2" <?= (($setting->stripe_payment_type == 2) ? 'selected' : '') ?>>LIVE</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="stripe_sandbox_sk" class="col-md-4 col-lg-3 col-form-label">Razorpay Sandbox Key ID</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="stripe_sandbox_sk" type="text" class="form-control" id="stripe_sandbox_sk" value="<?= $setting->stripe_sandbox_sk ?>" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="stripe_sandbox_pk" class="col-md-4 col-lg-3 col-form-label">Razorpay Sandbox Secret Key</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="stripe_sandbox_pk" type="text" class="form-control" id="stripe_sandbox_pk" value="<?= $setting->stripe_sandbox_pk ?>" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="stripe_live_sk" class="col-md-4 col-lg-3 col-form-label">Razorpay Live Key ID</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="stripe_live_sk" type="text" class="form-control" id="stripe_live_sk" value="<?= $setting->stripe_live_sk ?>" required>
                    </div>
                  </div>
                  <div class="row mb-3">
                    <label for="stripe_live_pk" class="col-md-4 col-lg-3 col-form-label">Razorpay Live Secret Key</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="stripe_live_pk" type="text" class="form-control" id="stripe_live_pk" value="<?= $setting->stripe_live_pk ?>" required>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                </form><!-- End payment settings Form -->
              </div>
            </div><!-- End Bordered Tabs -->
          </div>
        </div>
      </div>
    </div>
  </section>
<?php //} ?>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button1'); //Add button selector
    var wrapper = $('.field_wrapper1'); //Input field wrapper
    var fieldHTML = '<div class="row">\
                            <div class="col-md-5">\
                                <label for="lefticon" class="control-label">Link Text<span class="red">*</span></label>\
                                <span class="input-with-icon">\
                                    <input type="text" class="form-control requiredCheck" data-check="Link Text" name="footer_link_name[]" autocomplete="off">\
                                </span>\
                            </div>\
                            <div class="col-md-5">\
                                <label for="lefticon" class="control-label">Link<span class="red">*</span></label>\
                                <span class="input-with-icon">\
                                    <input type="text" class="form-control requiredCheck" data-check="Link" name="footer_link[]" autocomplete="off">\
                                </span>\
                            </div>\
                            <div class="col-md-2" style="margin-top: 26px;">\
                                <a href="javascript:void(0);" class="remove_button1" title="Remove field"><i class="fa fa-minus-circle fa-2x text-danger"></i></a>\
                            </div>\
                        </div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
      //Check maximum number of input fields
      if (x < maxField) {
        x++; //Increment field counter
        $(wrapper).append(fieldHTML); //Add field html
      }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button1', function(e) {
      e.preventDefault();
      $(this).parent('div').parent('div').remove(); //Remove field html
      x--; //Decrement field counter
    });
  });
  $(document).ready(function() {
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button2'); //Add button selector
    var wrapper = $('.field_wrapper2'); //Input field wrapper
    var fieldHTML = '<div class="row">\
                            <div class="col-md-5">\
                                <label for="lefticon" class="control-label">Link Text<span class="red">*</span></label>\
                                <span class="input-with-icon">\
                                    <input type="text" class="form-control requiredCheck" data-check="Second Column Link Text" name="footer_link_name2[]" autocomplete="off">\
                                </span>\
                            </div>\
                            <div class="col-md-5">\
                                <label for="lefticon" class="control-label">Link<span class="red">*</span></label>\
                                <span class="input-with-icon">\
                                    <input type="text" class="form-control requiredCheck" data-check="Second Column Link" name="footer_link2[]" autocomplete="off">\
                                </span>\
                            </div>\
                            <div class="col-md-2" style="margin-top: 33px;">\
                                <a href="javascript:void(0);" class="remove_button2" title="Remove field"><i class="fa fa-minus-circle fa-2x text-danger"></i></a>\
                            </div>\
                        </div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
      //Check maximum number of input fields
      if (x < maxField) {
        x++; //Increment field counter
        $(wrapper).append(fieldHTML); //Add field html
      }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button2', function(e) {
      e.preventDefault();
      $(this).parent('div').parent('div').remove(); //Remove field html
      x--; //Decrement field counter
    });
  });
  $(document).ready(function() {
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button3'); //Add button selector
    var wrapper = $('.field_wrapper3'); //Input field wrapper
    var fieldHTML = '<div class="row">\
                            <div class="col-md-5">\
                                <label for="lefticon" class="control-label">Link Text<span class="red">*</span></label>\
                                <span class="input-with-icon">\
                                    <input type="text" class="form-control requiredCheck" data-check="Third Column Link Text" name="footer_link_name3[]" autocomplete="off">\
                                </span>\
                            </div>\
                            <div class="col-md-5">\
                                <label for="lefticon" class="control-label">Link<span class="red">*</span></label>\
                                <span class="input-with-icon">\
                                    <input type="text" class="form-control requiredCheck" data-check="Third Column Link" name="footer_link3[]" autocomplete="off">\
                                </span>\
                            </div>\
                            <div class="col-md-2" style="margin-top: 33px;">\
                                <a href="javascript:void(0);" class="remove_button3" title="Remove field"><i class="fa fa-minus-circle fa-2x text-danger"></i></a>\
                            </div>\
                        </div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
      //Check maximum number of input fields
      if (x < maxField) {
        x++; //Increment field counter
        $(wrapper).append(fieldHTML); //Add field html
      }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button3', function(e) {
      e.preventDefault();
      $(this).parent('div').parent('div').remove(); //Remove field html
      x--; //Decrement field counter
    });
  });
</script>