<div class="container">
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">
                    <div class="d-flex justify-content-center py-4">
                        <a href="<?=base_url('admin/')?>" class="logo d-flex align-items-center w-auto">
                        <img src="<?=getenv('app.uploadsURL').$general_settings->site_logo?>" alt="<?=$general_settings->site_name?>">
                        </a>
                    </div>
                    <!-- End Logo -->
                    <div class="card mb-3 signin-box">
                        <div class="card-body">
                            <div class="pt-4 pb-2">
                                <h5 class="card-title text-center pb-0 fs-4">SignIn to Your Account</h5>
                                <p class="text-center small">Enter your email & password to login</p>
                            </div>
                            <?php if($session->getFlashdata('success_message')){?>
                            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                                <?=$session->getFlashdata('success_message')?>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php }?>
                            <?php if($session->getFlashdata('error_message')){?>
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                                <?=$session->getFlashdata('error_message')?>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php }?>
                            <form class="row g-3" method="POST" action="">
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                        <div class="invalid-feedback">Please enter your email.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-key"></i></span>
                                        <input type="password" name="password" class="form-control" id="password" required>
										<div class="passeye">
                                            <i class="fa fa-eye-slash" id="viewPassword" style="cursor:pointer;"></i>
                                            <i class="fa fa-eye" id="hidePassword" style="cursor:pointer;display: none;"></i>
										</div>
                                        <div class="invalid-feedback">Please enter your password.</div>
                                    </div>
                                </div>
                                <!-- <div class="col-12">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                      <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    </div> -->
                                <div class="col-12">
                                    <button class="btn btn-success btn_org w-100 mb-4 mt-2" type="submit">Sign In</button>
                                </div>
                                <div class="col-12">
                                    <p class="small mb-0">Forgot Password? <a href="<?=base_url('/admin/forgot-password')?>">Click Here</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="credits">
                        Maintained by <a href="https://keylines.net/">Keylines Digitech Pvt. Ltd.</a>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">                    
                    <div class="card mb-3 signin-box">
                        <div class="card-body">
                            <div class="portlet box green">
                                <div class="portlet-title">
                                    <div class="caption"></div>
                                    <div class="tools"> </div>
                                </div>
                                <div class="portlet-body">
                                    <h4>Application Location Path :</h4> 
                                    <p><?=getenv('app.baseURL')?></p>
                                </div>
                            </div>                              
                            <?php if($session->getFlashdata('success_message')){?>
                            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message" role="alert">
                                <?=$session->getFlashdata('success_message')?>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php }?>
                            <?php if($session->getFlashdata('error_message')){?>
                            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message" role="alert">
                                <?=$session->getFlashdata('error_message')?>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php }?>
                            <form class="row g-3" method="POST" action="">
                                <div class="col-12">
                                    <label for="email" class="form-label">Email</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                                        <input type="email" name="email" class="form-control" id="email" required>
                                        <div class="invalid-feedback">Please enter your email.</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group has-validation">
                                        <span class="input-group-text" id="inputGroupPrepend"><i class="fa fa-key"></i></span>
                                        <input type="password" name="password" class="form-control" id="password" required>
										<div class="passeye">
                                            <i class="fa fa-eye-slash" id="viewPassword" style="cursor:pointer;"></i>
                                            <i class="fa fa-eye" id="hidePassword" style="cursor:pointer;display: none;"></i>
										</div>
                                        <div class="invalid-feedback">Please enter your password.</div>
                                    </div>
                                </div>
                                <!-- <div class="col-12">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                      <label class="form-check-label" for="rememberMe">Remember me</label>
                                    </div>
                                    </div> -->
                                <div class="col-12">
                                    <button class="btn btn-success btn_org w-100 mb-4 mt-2" type="submit">Sign In</button>
                                </div>
                                <div class="col-12">
                                    <p class="small mb-0">Forgot Password? <a href="<?=base_url('/admin/forgot-password')?>">Click Here</a></p>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="credits">
                        Maintained by <a href="https://keylines.net/">Keylines Digitech Pvt. Ltd.</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">
    $(function(){
        $('#viewPassword').on('click', function(){
            $('#password').attr('type', 'text');
            $('#viewPassword').hide();
            $('#hidePassword').show();
        });
        $('#hidePassword').on('click', function(){
            $('#password').attr('type', 'password');
            $('#hidePassword').hide();
            $('#viewPassword').show();
        });
    })
</script>