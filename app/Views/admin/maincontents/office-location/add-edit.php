<?php
$title                      = $moduleDetail['title'];
$primary_key                = $moduleDetail['primary_key'];
$controller_route           = $moduleDetail['controller_route'];
$application_setting        = $common_model->find_data('application_settings', 'row', ['id' => 1]);
?>
<script>
   let autocomplete;
   let address1Field;
   let address2Field;
   let postalField;
   
   function initAutocomplete() {
   address1Field = document.querySelector("#address1");
   address2Field = document.querySelector("#street_no1");
   postalField = document.querySelector("#zipcode1");
   autocomplete = new google.maps.places.Autocomplete(address1Field, {
   componentRestrictions: { country: [] },
   fields: ["address_components", "geometry", "formatted_address"],
   types: ["address"],
   });
   address1Field.focus();
   autocomplete.addListener("place_changed", fillInAddress);
   }
   
   function fillInAddress() {
   const place = autocomplete.getPlace();
   let address1 = "";
   let postcode = "";
   for (const component of place.address_components) {
   const componentType = component.types[0];
   switch (componentType) {
     case "postal_code": {
       postcode = `${component.long_name}${postcode}`;
       break;
     }
     case "postal_code_suffix": {
       postcode = `${postcode}-${component.long_name}`;
       break;
     }
     case "street_number": {
       document.querySelector("#street_no1").value = component.long_name;
       break;
     }
     case "route": {
       document.querySelector("#locality1").value = component.long_name;
       break;
     }
     case "locality": {
       document.querySelector("#city1").value = component.long_name;
       break;
     }
     case "administrative_area_level_1": {
       document.querySelector("#state1").value = component.short_name;
       break;
     }
     case "country":
       document.querySelector("#country1").value = component.short_name;
       break;
    }
   }
   address1Field.value = place.formatted_address;
   postalField.value = postcode;
   document.querySelector("#lat1").value = place.geometry.location.lat();
   document.querySelector("#lng1").value = place.geometry.location.lng();
   address2Field.focus();
   }
   window.initAutocomplete = initAutocomplete;
</script>
<div class="pagetitle">
    <h1><?=$page_header?></h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?=base_url('admin/dashboard')?>">Home</a></li>
            <li class="breadcrumb-item active"><a href="<?=base_url('admin/' . $controller_route . '/list/')?>"><?=$title?> List</a></li>
            <li class="breadcrumb-item active"><?=$page_header?></li>
        </ol>
    </nav>
</div>
<!-- End Page Title -->
<section class="section profile">
    <div class="row">
        <div class="col-xl-12">
            <?php if(session('success_message')){?>
            <div class="alert alert-success bg-success text-light border-0 alert-dismissible fade show hide-message custom-alert" role="alert">
                <?=session('success_message')?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
            <?php if(session('error_message')){?>
            <div class="alert alert-danger bg-danger text-light border-0 alert-dismissible fade show hide-message custom-alert" role="alert">
                <?=session('error_message')?>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>
        </div>
        <?php
            if($row){
              $name                 = $row->name;
              $phone                = $row->phone;
              $email                = $row->email;
              $address              = $row->address;
              $country              = $row->country;
              $state                = $row->state;
              $city                 = $row->city;
              $locality             = $row->locality;
              $street_no            = $row->street_no;
              $zipcode              = $row->zipcode;
              $latitude             = $row->latitude;
              $longitude            = $row->longitude;
            } else {
              $name                 = '';
              $phone                = '';
              $email                = '';
              $address              = '';
              $country              = '';
              $state                = '';
              $city                 = '';
              $locality             = '';
              $street_no            = '';
              $zipcode              = '';
              $latitude             = '';
              $longitude            = '';
            }
        ?>
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body pt-3">
                    <form method="POST" action="" enctype="multipart/form-data" class="general_form_style">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="name" class="col-form-label">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="name" class="form-control" id="name" value="<?=$name?>" style="text-transform: uppercase;" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="phone" class="col-form-label">Phone</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="phone" class="form-control" id="phone" value="<?=$phone?>" maxlength="10" minlength="10" onkeypress="return isNumber(event)" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="email" class="col-form-label">Email</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="email" name="email" class="form-control" id="email" value="<?=$email?>" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="address" class="col-form-label">Address</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="address" class="form-control" id="address1" value="<?=$address?>" required>
                                        <input type="hidden" name="latitude" class="form-control" id="lat1" value="<?=$latitude?>" required>
                                        <input type="hidden" name="longitude" class="form-control" id="lng1" value="<?=$longitude?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="country" class="col-form-label">Country</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="country" class="form-control" id="country1" value="<?=$country?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="state" class="col-form-label">State</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="state" class="form-control" id="state1" value="<?=$state?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="city" class="col-form-label">City</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="city" class="form-control" id="city1" value="<?=$city?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="locality" class="col-form-label">Locality</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="locality" class="form-control" id="locality1" value="<?=$locality?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="street_no" class="col-form-label">Street No</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="street_no" class="form-control" id="street_no1" value="<?=$street_no?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 col-lg-2">
                                    <div class="general_form_left_box">
                                        <label for="zipcode" class="col-form-label">Zipcode</label>
                                    </div>
                                </div>
                                <div class="col-md-10 col-lg-10">
                                    <div class="general_form_right_box">
                                        <input type="text" name="zipcode" class="form-control" id="zipcode1" maxlength="6" minlength="6" onkeypress="return isNumber(event)" value="<?=$zipcode?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-sm small-btn"><?=(($row)?'Save':'Add')?></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script type="text/javascript">
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
</script>
<?php
    $google_map_api_code = $application_setting->google_map_api_code;
?>
<script type="text/javascript">
    var google_map_api_code = '<?=$google_map_api_code?>';
</script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBMbNCogNokCwVmJCRfefB6iCYUWv28LjQ&libraries=places&callback=initAutocomplete&libraries=places&v=weekly"></script>