<style>
  body,
  html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Segoe UI', sans-serif;
  }

  .gradient-bg {
    background: linear-gradient(135deg, #f9ed4c, #f19620);
  }

  input.form-control {
    height: 45px;
    border-radius: 6px;
    font-size: 16px;
  }

  button.btn {
    height: 45px;
    font-size: 16px;
    border-radius: 6px;
  }

  a {
    text-decoration: none;
  }

  .logo {
    width: 200px;
    margin-bottom: 20px;
  }

  .signin-box {
    background-color: #fff;
    border-radius: 8px;
    padding: 20px;
  }

  .qr-box {
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    text-align: center;
    width: 100%;
    max-width: 600px;
    margin: 0 auto;
  }

  .qr-box img {
    max-width: 150px;
    margin-bottom: 10px;
  }

  .app-path {
    margin-top: 20px;
    font-size: 16px;
    color: #333;
  }
  @media (max-width: 768px) {

    .qr-box .qr-image{
      display: none
    }
    .gradient-bg{
      background: transparent !important;
    }
    .signin_box{
      background: linear-gradient(135deg, #f9ed4c, #f19620);
      padding-bottom: 20px;
    }
    .signin_box .col-md-8,
    .signin_box .col-md-4{
      width: 100%;
    }
    .signin_box .col-md-4.bg-white{
      background: transparent !important;
    }
    .signin_box.vh-100 {
      height: 100% !important;
    }
    .app-path{
      margin-top: 12px;
    }
  }
</style>

<div class="signin_box d-flex flex-wrap vh-100">
  <!-- Left Panel -->
  <div class="col-md-8 d-flex flex-column justify-content-center align-items-center">
    <div class="gradient-bg text-white w-100 h-100 d-flex flex-column justify-content-center px-3">
      <div class="text-center my-4 mb-md-4">
        <img src="<?=getenv('app.uploadsURL').$general_settings->site_logo?>" alt="<?=$general_settings->site_name?>"
          style="width: 100%;max-width: 200px;">
      </div>
      <div class="qr-box mb-4">
        <div class="row justify-content-center">
          <div class="col-sm-5">
            <img src="<?= base_url('public/uploads/Android.png')?>" alt="" class="img-fluid qr-image">
            <a href="https://play.google.com/store/apps/details?id=com.keytracker.keyline" target="_blank" class="d-block">
              <img src="<?= base_url('public/uploads/play-store.png')?>" alt="" class="img-fluid">
            </a>
          </div>
          <div class="col-sm-5">
            <img src="<?= base_url('public/uploads/iOS.png')?>" alt="" class="img-fluid qr-image">
            <a href="https://apps.apple.com/us/app/effortrak/id6502506223" target="_blank" class="d-block">
              <img src="<?= base_url('public/uploads/app-store.png')?>" alt="" class="img-fluid">
            </a>
          </div>
        </div>
        <div class="app-path">
          <p><b>Application Link :</b> <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
              title="Copy this link and paste it in the mobile app URL location">
              <?=getenv('app.baseURL')?>
            </a></p>
        </div>
      </div>
    </div>
  </div>
  <!-- Right Panel -->
  <div class="col-md-4 d-flex align-items-center justify-content-center bg-white px-3">
    <div class="card shadow p-4" style="width: 100%; max-width: 380px; border-radius: 16px;">
      <div class="card-body">
        <div class="text-center mb-4">
          <h3 class="mb-1 text-primary">SignIn to Your Account</h3>
          <p class="text-muted small">Enter your email & password to login</p>
        </div>
        <form method="POST" action="">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <div class="input-group">
              <span class="input-group-text">@</span>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <div class="input-group">
              <span class="input-group-text"><i class="fa fa-key"></i></span>
              <input type="password" class="form-control" id="password" name="password" required>
              <span class="input-group-text">
                <i class="fa fa-eye-slash" id="viewPassword" style="cursor:pointer;"></i>
                <i class="fa fa-eye d-none" id="hidePassword" style="cursor:pointer;"></i>
              </span>
            </div>
          </div>
          <div class="d-grid">
            <button class="btn btn-warning text-white w-100 mb-3 mt-2" type="submit">Sign In</button>
          </div>
          <p class="text-center small">Forgot Password? <a href="#">Click Here</a></p>
        </form>
        <div class="credits text-center mt-2">
          <small class="text-muted">Maintained by <a href="https://keylines.net/">Keylines Digitech Pvt.
              Ltd.</a></small>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
  $(function () {
    $('#viewPassword').on('click', function () {
      $('#password').attr('type', 'text');
      $('#viewPassword').hide();
      $('#hidePassword').show();
    });
    $('#hidePassword').on('click', function () {
      $('#password').attr('type', 'password');
      $('#hidePassword').hide();
      $('#viewPassword').show();
    });
  })
</script>