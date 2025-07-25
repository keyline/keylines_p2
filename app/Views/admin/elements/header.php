<?php
$userType                   = $session->user_type;
?>
<div class="d-flex align-items-center justify-content-between">
    <a href="<?= base_url('admin/dashboard') ?>" class="logo d-flex align-items-center">
        <?php if ($general_settings->site_logo != '') { ?>
            <img src="<?= getenv('app.uploadsURL') . $general_settings->site_logo ?>" alt="<?= $general_settings->site_name ?>">
        <?php } else { ?>
            <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $general_settings->site_name ?>" class="img-thumbnail" style="width: 150px; height: 150px; margin-top: 10px;">
        <?php } ?>
        <!-- <img src="<?= getenv('app.adminAssetsURL') ?>assets/img/logo.svg" alt="<?= $general_settings->site_name ?>"> -->
        <!-- <img src="<?= getenv('app.adminAssetsURL') ?>assets/img/logo.png" alt="<?= $general_settings->site_name ?>"> -->
        <!-- <span class="d-none d-lg-block" style="font-size: 23px;"><?= $general_settings->site_name ?></span> -->
    </a>
</div>
<!-- End Logo -->
<!-- <div class="search-bar">
    <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
    </form>
</div> -->
<!-- End Search Bar -->
<nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">
        <!-- <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
            </a>
        </li> -->
        <!-- End Search Icon-->
        <li class="nav-item dropdown">
            <!-- <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
            </a> -->
            <!-- End Notification Icon -->
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                <li class="dropdown-header">
                    You have 4 new notifications
                    <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="notification-item">
                    <i class="bi bi-exclamation-circle text-warning"></i>
                    <div>
                        <h4>Lorem Ipsum</h4>
                        <p>Quae dolorem earum veritatis oditseno</p>
                        <p>30 min. ago</p>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="notification-item">
                    <i class="bi bi-x-circle text-danger"></i>
                    <div>
                        <h4>Atque rerum nesciunt</h4>
                        <p>Quae dolorem earum veritatis oditseno</p>
                        <p>1 hr. ago</p>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="notification-item">
                    <i class="bi bi-check-circle text-success"></i>
                    <div>
                        <h4>Sit rerum fuga</h4>
                        <p>Quae dolorem earum veritatis oditseno</p>
                        <p>2 hrs. ago</p>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="notification-item">
                    <i class="bi bi-info-circle text-primary"></i>
                    <div>
                        <h4>Dicta reprehenderit</h4>
                        <p>Quae dolorem earum veritatis oditseno</p>
                        <p>4 hrs. ago</p>
                    </div>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="dropdown-footer">
                    <a href="#">Show all notifications</a>
                </li>
            </ul>
            <!-- End Notification Dropdown Items -->
        </li>
        <!-- End Notification Nav -->
        <li class="nav-item dropdown">
            <!-- <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
            </a> -->
            <!-- End Messages Icon -->
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
                <li class="dropdown-header">
                    You have 3 new messages
                    <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="message-item">
                    <a href="#">
                        <img src="<?= getenv('app.adminAssetsURL') ?>assets/img/messages-1.jpg" alt="" class="rounded-circle">
                        <div>
                            <h4>Maria Hudson</h4>
                            <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                            <p>4 hrs. ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="message-item">
                    <a href="#">
                        <img src="<?= getenv('app.adminAssetsURL') ?>assets/img/messages-2.jpg" alt="" class="rounded-circle">
                        <div>
                            <h4>Anna Nelson</h4>
                            <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                            <p>6 hrs. ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="message-item">
                    <a href="#">
                        <img src="<?= getenv('app.adminAssetsURL') ?>assets/img/messages-3.jpg" alt="" class="rounded-circle">
                        <div>
                            <h4>David Muldon</h4>
                            <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                            <p>8 hrs. ago</p>
                        </div>
                    </a>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li class="dropdown-footer">
                    <a href="#">Show all messages</a>
                </li>
            </ul>
            <!-- End Messages Dropdown Items -->
        </li>
        <!-- End Messages Nav -->
        <!-- <li class="nav-item admin_item dropdown me-2">
            <span>?=$session->user_type?></span>
        </li> -->
        <li class="nav-item user_item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="javascript:void(0);" data-bs-toggle="dropdown">
                <?php
                // pr($userType);
                if ($userType == "CLIENT") {
                    if ($client) {  ?>
                        <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $client->name ?>" class="rounded-circle">
                    <?php }
                } else {
                    if ($admin) { ?>
                        <?php if ($admin->profile_image != '') { ?>
                            <img src="<?= getenv('app.uploadsURL') . 'user/' . $admin->profile_image ?>" alt="<?= $admin->name ?>" class="rounded-circle">
                        <?php } else { ?>
                            <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $admin->name ?>" class="rounded-circle">
                        <?php } ?>
                    <?php } else { ?>
                        <img src="<?= getenv('app.NO_IMAGE') ?>" alt="<?= $admin->name ?>" class="rounded-circle">
                <?php }
                } ?>
                <span class="d-none d-md-block px-3">
                    <?= $session->name ?>
                    <small><?= $session->user_type ?></small>
                </span>
                <i class='bx bxs-chevron-down arrow ms-auto'></i>
            </a><!-- End Profile Iamge Icon -->
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                <li class="dropdown-header">
                    <h6><?= $session->name ?></h6>
                    <span><?= $session->user_type ?></span>
                </li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <?php //if($userType == 'admin'){
                ?>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('admin/settings') ?>">
                        <i class="bi bi-gear"></i>
                        <span>Account Settings</span>
                    </a>
                </li>
                <?php //}
                ?>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>

                    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('admin/user/screenshots/' . encoded($session->user_id)); ?>">
                        <i class="fas fa-image"></i>
                        <span>My Screenshots</span>
                    </a>
                </li>
                <li>
                    <a class="dropdown-item d-flex align-items-center" href="<?= base_url('admin/signout') ?>">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Sign Out</span>
                    </a>
                </li>
            </ul>
            <!-- End Profile Dropdown Items -->
        </li>
        <!-- End Profile Nav -->
    </ul>
</nav>
<!-- End Icons Navigation -->