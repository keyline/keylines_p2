<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<title><?=$page_header?></title>
<meta content="" name="description">
<meta content="" name="keywords">
<!-- Favicons -->
<link href="<?=getenv('app.uploadsURL').$general_settings->site_favicon?>" rel="icon">
<link href="<?=getenv('app.uploadsURL'.$general_settings->site_favicon)?>" rel="apple-touch-icon">
<!-- Google Fonts -->
<!-- <link href="https://fonts.gstatic.com" rel="preconnect">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">

<!-- inter fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

<!-- Vendor CSS Files -->
<link href="<?=getenv('app.adminAssetsURL')?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=getenv('app.adminAssetsURL')?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link href="<?=getenv('app.adminAssetsURL')?>assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
<link href="<?=getenv('app.adminAssetsURL')?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
<link href="<?=getenv('app.adminAssetsURL')?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
<link href="<?=getenv('app.adminAssetsURL')?>assets/vendor/remixicon/remixicon.css" rel="stylesheet">
<link href="<?=getenv('app.adminAssetsURL')?>assets/vendor/simple-datatables/style.css" rel="stylesheet">
<!-- Template Main CSS File -->
<link href="<?=getenv('app.adminAssetsURL')?>assets/css/style.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="<?=getenv('app.adminAssetsURL')?>assets/css/local-admin.css" rel="stylesheet">
<link href="<?=getenv('app.adminAssetsURL')?>assets/css/toastr.css" rel="stylesheet"/>
<style type="text/css">    
    .toast-success {
        background-color: #000;
        color: #28a745 !important;
    }
    .toast-error {
        background-color: #000;
        color: #dc3545 !important;
    }
    .toast-warning {
        background-color: #000;
        color: #ffc107 !important;
    }
    .toast-info {
        background-color: #000;
        color: #007bff !important;
    }
    #simpletable_filter{
        float: right;
    }
    .simpletable_length label {
        display: inline-flex;
        padding: 10px;
    }
</style>