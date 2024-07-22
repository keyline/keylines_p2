<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Client Detais</title>
</head>
<style>
    .loader {
        border: 5px solid #f3f3f3; /* Light grey */
        border-top: 5px solid #3498db; /* Blue */
        border-radius: 50%;
        width: 50px;
        height: 50px;
        animation: spin 1s linear infinite;
        margin: 20px auto;
        display: none; /* Initially hidden */
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    body{
        background: url(<?php echo base_url("/public/material/frontend/assets/images/client_background.jpg") ?>) no-repeat;
        background-size: cover;
    }
    .project-tracking-box{
        padding: 12px 10px 16px;
        /* background: linear-gradient(50deg, #e63927 5%, #f7b662 80%); */
        background: #f7b662;
        max-width: 400px;
        margin: 0 auto
    }
    .project-tracking-box h6{
        color: #fff;
        text-shadow: 1px 1px 0px #865617;
        font-size: 20px;
        text-align: center;
        font-weight: 600;
        font-family: 'Times New Roman';
        line-height: 15px;
    }
    .project-tracking-box h4{
        color: #fff;
        text-shadow: 1px 1px 0px #865617;
        font-size: 24px;
        text-align: center;
        font-weight: 600;
        font-family: 'Times New Roman';
        line-height: 25px;
        padding-bottom: 3px;
    }
    .project-tracking-form{
        border: 1px solid #ec9b2d;
        padding: 3px 3px 0px;
        border-radius: 5px ;
        margin-bottom: 8px
    }
    .form-label{
        border: 1px solid #ec9b2d;
        padding: 3px;
        display: flex;
        align-items: center;
        border-radius: 3px;
        width: 100%;
        height: 93%;
        color: #000;
        font-size: 14px;
        font-family: 'Times New Roman';
    }
    .row{
        margin: 0;
    }
    .col-md-3,
    .col-md-9{
        padding: 0;
    }
    .input-box{
        padding: 3px;
        border: 1px solid #ec9b2d;
        margin-left: 5px;
        border-radius: 5px 
    }
    .input-box input,
    .input-box select{
        padding: 2px 5px 2px;
        font-size: 13px
    }
    .input-box input:focus,
    .input-box select:focus{
        box-shadow: none
    }
    .last-label{
        height: 100%;
        border: 1px solid #ec9b2d;
        padding: 3px;
        display: flex;
        align-items: center;
        border-radius: 3px;
        width: 100%;
        height: 93%;
        color: #000;
        font-size: 14px;
        font-family: 'Times New Roman';
    }
    textarea{
        resize: none;
        font-weight: 500;
        font-family: 'Times New Roman';
        height: 47px;
    }
    .submit-btn{
        display: block;
        margin: 0 auto;
        background-color: #ffff;
        border: 1px solid #ec9b2d;
        border-radius: 4px;
        padding: 2px 16px;
        transition: ease 0.3s;
        text-transform: uppercase;
        font-weight: 500;
        font-family: 'Times New Roman';
        font-size: 15px;
        transition: all .3s ease-in-out;
    }
    .submit-btn:focus{
        box-shadow: none;
    }
    .submit-btn:hover{
        color: #fff;
        background-color: #ec9b2d;
        border: 1px solid #ec9b2d;
    }
    @media(max-width: 767px){
        .input-box{
            margin: 0 0 9px 0
        }
        .input-box input, .input-box select {
            padding: 3px 5px 3px;
        }
    }
</style>

<body>

    <section class="project-tracking">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-4 col-lg-6">
                    <div class="project-tracking-box">
                        <h6 class="text-center text-white">Keyline Project Tracking System</h6>
                        <h4 class="text-center text-white">Please register your Company Details</h4>
                        <div class="project-tracking-form">
                            <form method="POST" id="myform">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="name" class="form-label">Name <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="text" class="form-control" name="name" id="name" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="company" class="form-label">Company <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="text" class="form-control" name="company" id="company" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="address1" class="form-label">Address 1 <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="text" class="form-control" name="address1" id="address1" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="address2" class="form-label">Address 2</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="text" class="form-control" name="address2" id="address2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="country" class="form-label">Country <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <select class="form-control" name="country" id="country" >
                                                <option value="">Select Country</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="state" class="form-label">State <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <select class="form-control" name="state" id="state" >
                                                <option value="">Select State</option>
                                            </select>   
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="state" class="form-label">City <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <select class="form-control" name="city" id="city" >
                                                <option value="">Select City</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="city" class="form-label">Pin <span style="color: red;">*</span> </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="text" class="form-control" name="pin" id="pin" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="state" class="form-label">Email 1 <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="email" class="form-control" name="email1" id="email1" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="state" class="form-label">Email 2</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="email" class="form-control" name="email2" id="email2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="phone1" class="form-label">Phone 1 <span style="color: red;">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="tel" class="form-control" name="phone1" id="phone1" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="phone2" class="form-label">Phone 2</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="tel" class="form-control" name="phone2" id="phone2">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="state" class="form-label">Date of Birth </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <input type="date" class="form-control" name="dob" id="dob">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="gstNoComment" class="form-label last-label">GST no. & Comment</label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-box">
                                            <textarea class="form-control" name="gstNoComment" id="gstNoComment"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="loader" id="loader"></div>
                                <div id="response"></div>
                                <div class="row justify-content-center">
                                    <div class="col-md-12 mt-1 text-center">
                                        <button id="submit" type="submit" class="btn submit-btn">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        // Country Data Fetch 
        $.ajax({
            url: "<?=base_url('/countryInfoJSON');?>",
            method: "GET",
            data: {
                username: "avijit678"
            },
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(data) {
                console.log(data);
                var countryDropdown = $("#country");
                countryDropdown.empty();
                countryDropdown.append('<option value="">Select Country</option>');

                data.geonames.forEach(function(country) {
                    countryDropdown.append('<option value="' + country.geonameId + '">' + country.countryName + '</option>');
                });
            },
            error: function(err) {
                console.error("Error fetching countries: ", err);
            }
        });
        // Country Data Fetch 
        // State Data Fetch 
        $('#country').on('change', function() {
            var countryCode = $(this).val();
            if (countryCode) {
                $.ajax({
                    url: '<?=base_url('/stateInfoJSON');?>',
                    method: 'GET',
                    data: {
                        geonameId: countryCode,
                        username: 'avijit678'
                    },
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(data) {
                        console.log(data);
                        var stateDropdown = $("#state");
                        stateDropdown.empty();
                        stateDropdown.append('<option value="">Select State</option>');
                        if (data.geonames) {
                            data.geonames.forEach(function(state) {
                                stateDropdown.append('<option value="' + state.geonameId + '">' + state.name + '</option>');
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + status + " " + error);
                    }
                });
            } else {
                $("#state").empty().append('<option value="">Select State</option>');
            }
        });
        // State Data Fetch
        // City Data Fetch 
        $('#state').on('change', function() {
            var stateCode = $(this).val();
            if (stateCode) {
                $.ajax({
                    url: "<?=base_url('/cityInfoJSON');?>",
                    method: "GET",
                    data: {
                        geonameId: stateCode,
                        username: 'avijit678'
                    },
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    success: function(data) {
                        var cityDropdown = $("#city");
                        cityDropdown.empty();
                        cityDropdown.append('<option value="">Select City</option>');

                        data.geonames.forEach(function(city) {
                            cityDropdown.append('<option value="' + city.geonameId + '">' + city.name + '</option>');
                        });
                    },
                    error: function(err) {
                        console.error("Error fetching cities: ", err);
                    }
                });
            } else {
                $("#state").empty().append('<option value="">Select State</option>');
            }
        });
        // City Data Fetch 
        // Form Submission
        $('#myform').submit(function(event) {
            event.preventDefault();
            var formData    = $(this).serialize();

            var name        = $('#name').val().trim();
            var company     = $('#company').val().trim();
            var address1    = $('#address1').val().trim();
            var country     = $('#country').val().trim();
            var state       = $('#state').val().trim();
            var city        = $('#city').val().trim();
            var pin         = $('#pin').val().trim();
            var email1      = $('#email1').val().trim();
            var phone1      = $('#phone1').val().trim();

            if (name === '' || company === '' || address1 === '' || country === '' || state === '' || city === '' || pin === '' || email1 === ''|| phone1 === '' ) {
                $('#response').html('<div class="error" style="text-align: center;color: red;">All (*) fields are Required .</div>');
                setTimeout(function() {
                    $('#response').fadeOut();
                }, 3000);
                return;
            }

            $('#loader').show();
            $('#submit').hide();
            $.ajax({
                type: 'POST',
                url : '<?=base_url('client-Details-Data')?>',
                data: formData,
                success: function(response) {
                    $('#response').html(response);
                    $('#myform')[0].reset();
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('#response').html('<div class="error">Error occurred. Please try again.</div>');
                },
                complete: function() {
                    $('#loader').hide();
                    $('#submit').show();
                    $('#response').html('<div class="error" style="text-align: center;color: green;">Form successfully submitted. Please keep in touch.</div>');
                    setTimeout(function() {
                        $('#response').fadeOut();
                    }, 3000);
                }
            });
        });
        // Form Submission
        $('#phone1, #phone2').on('keypress', function(event) {
            var charCode = (event.which) ? event.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                event.preventDefault();
            }
        });
        $('#phone1, #phone2').on('blur', function() {
        var minLength   = 10;
        var maxLength   = 10;
        
        var inputValue  = $(this).val().trim();
        var inputLength = inputValue.length;

        if (inputLength < minLength || inputLength > maxLength) {
            $(this).next('.error-message').remove();
            $(this).after('<div class="error-message" style="color: red;">Phone number must be 10 characters long.</div>');
        } else {
            $(this).next('.error-message').remove();
        }
    });
    
    });
</script>