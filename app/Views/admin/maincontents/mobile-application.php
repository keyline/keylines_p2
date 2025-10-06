<?php
$user               = $session->user_type;
$title              = $moduleDetail['title'];
$primary_key        = $moduleDetail['primary_key'];
$controller_route   = $moduleDetail['controller_route'];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.css" integrity="sha512-UTNP5BXLIptsaj5WdKFrkFov94lDx+eBvbKyoe1YAfjeRPC+gT5kyZ10kOHCfNZqEui1sxmqvodNUx3KbuYI/A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" integrity="sha512-OTcub78R3msOCtY3Tc6FzeDJ8N9qvQn1Ph49ou13xgA9VsH9+LRxoFU6EqLhW4+PKRfU+/HReXmSZXHEkpYoOA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style type="text/css">
    #simpletable_filter {
        float: right;
    }

    .simpletable_length label {
        display: inline-flex;
        padding: 10px;
    }

    .charts {
        border: 1px solid #ff980073;
        padding: 10px;
    }
    .download-left,
    .download-right,
    .btn-stor{
        text-align: center;
    }
    .download-left img,
    .download-right img,
    .btn-stor img{
        width: 50%;
    }

</style>
<div class="pagetitle">
    <h1><?= $page_header ?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('admin/dashboard') ?>">Home</a></li>
            <li class="breadcrumb-item active"><a href="<?= base_url('admin/' . $controller_route . '/list/') ?>"><?= $title ?> List</a></li>
            <li class="breadcrumb-item active"><?= $page_header ?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
    <?php if (checkModuleFunctionAccess(26, 49)) { ?>
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
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <div class="portlet box green">
                            <div class="portlet-title">
                                <div class="caption"></div>
                                <div class="tools"> </div>
                            </div>
                            <div class="portlet-body">
                                  <h4>Application Location Path :</h4> 
                                  <p><?=getenv('app.baseURL')?></p>
                            </div>
                            <div class="app-path">
                                <h4>Application Location Path :</h4>
                                <a href="#" data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Copy this link and paste it in the mobile app URL location">
                                    <?=getenv('app.baseURL')?>
                                </a>
                            </div>
                        </div>                       
                    </div>
                </div>                
            </div>           
        </div>
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-3">
                        <h4 class="mb-3">Download Mobile App</h4>  
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <div class="scan-left">
                                    <div class="card">
                                        <div class="card-body pt-3">
                                            <div class="download-left">
                                                <img src="<?= base_url('public/uploads/Android.png')?>" alt="" class="img-fluid">
                                            </div>
                                            <div class="btn-stor">
                                                <a href="https://shorturl.at/HPZ8r">
                                                    <img src="<?= base_url('public/uploads/play-store.png')?>" alt="" class="img-fluid">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="scan-right">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="download-right">
                                                <img src="<?= base_url('public/uploads/iOS.png')?>" alt="" class="img-fluid">
                                            </div>
                                            <div class="btn-stor">
                                                <a href="https://shorturl.at/VMYlc">
                                                    <img src="<?= base_url('public/uploads/app-store.png')?>" alt="" class="img-fluid">
                                                </a>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-bPs7Ae6pVvhOSiIcyUClR7/q2OAsRiovw4vAkX+zJbw3ShAeeqezq50RIIcIURq7Oa20rW2n2q+fyXBNcU9lrw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    v$('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:true,
    responsive:{
        0:{
            items:1
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
})
</script>