<!DOCTYPE html>
<html lang="en">

<head>
    <?= $head ?>
</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <?= $header ?>
    </header>
    <!-- End Header -->
    
    <!-- ======= Sidebar ======= -->
   <div class="wrapper">
        <!-- <aside id="sidebar" class="sidebar"> -->
        <div class="sidebar close">
            <?= $sidebar ?>
        </div>
        <!-- </aside> -->
        <!-- End Sidebar-->
        <main id="main" class="home-section">
            <?= $maincontent ?>
            <!-- ======= Footer ======= -->
            <footer id="footer" class="footer">
                <?= $footer ?>
            </footer>
            <!-- End Footer -->
        </main>
        <!-- End #main -->
   </div>
   
    <a href="javascript:void(0);" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <!-- Vendor JS Files -->
    <script src="<?= getenv('app.adminAssetsURL') ?>assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="<?= getenv('app.adminAssetsURL') ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- <script src="<?= getenv('app.adminAssetsURL') ?>assets/vendor/chart.js/chart.umd.js"></script>
        <script src="<?= getenv('app.adminAssetsURL') ?>assets/vendor/echarts/echarts.min.js"></script> -->
    <script src="<?= getenv('app.adminAssetsURL') ?>assets/vendor/quill/quill.min.js"></script>
    <!-- <script src="<?= getenv('app.adminAssetsURL') ?>assets/vendor/simple-datatables/simple-datatables.js"></script> -->

    <!-- <script src="<?= getenv('app.adminAssetsURL') ?>assets/vendor/tinymce/tinymce.min.js"></script> -->
    <!-- <script src="<?= getenv('app.adminAssetsURL') ?>assets/vendor/php-email-form/validate.js"></script> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css" integrity="sha512-rRQtF4V2wtAvXsou4iUAs2kXHi3Lj9NE7xJR77DE7GHsxgY9RTWy93dzMXgDIG8ToiRTD45VsDNdTiUagOFeZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Template Main JS File -->
    <script src="<?= getenv('app.adminAssetsURL') ?>assets/js/main.js"></script>
    <script src="<?= getenv('app.adminAssetsURL') ?>assets/js/jquery.min.js"></script>
    <!-- Stable Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Stable Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    if ($.fn.select2) {
      console.log("Select2 loaded successfully");
    } else {
      console.error("Select2 not loaded");
    }

    $('#project_id').select2({
      placeholder: "Search...",
      allowClear: true
    });
  });
</script>

    <!-- <script src="<?= getenv('app.adminAssetsURL') ?>assets/js/plugins/jquery.dataTables.min.js"></script>
        <script src="<?= getenv('app.adminAssetsURL') ?>assets/js/plugins/dataTables.bootstrap4.min.js"></script> -->
    <script src="<?= getenv('app.adminAssetsURL') ?>assets/js/pages/data-basic-custom.js"></script>


    <!-- <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.0/dist/umd/simple-datatables.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.0/dist/style.min.css" rel="stylesheet"> -->

    <link href="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-2.0.3/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.0.1/js/buttons.print.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.hide-message').delay(5000).fadeOut('slow');
        });
    </script>
    <script src="<?= getenv('app.adminAssetsURL') ?>assets/js/toastr.js"></script>
    <link rel="stylesheet" href="<?= getenv('app.adminAssetsURL'); ?>assets/owl/owl3.css">
    <script src="<?= getenv('app.adminAssetsURL'); ?>assets/owl/owl-min.js"></script>
    <!-- <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
        <script type="text/javascript" src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script> -->
    <script type="text/javascript">
        function toastAlert(type, message, redirectStatus = false, redirectUrl = '') {
            toastr.options = {
                "closeButton": true,
                "debug": true,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-bottom-left",
                "preventDuplicates": false,
                "showDuration": "3000",
                "hideDuration": "1000000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            toastr[type](message);
            if (redirectStatus) {
                setTimeout(function() {
                    window.location = redirectUrl;
                }, 3000);
            }
        }

        $(function() {
            $('#company_email').on('blur', function() {
                let company_email = $('#company_email').val();
                let url = '<?= base_url() ?>';
                var settings = {
                    "url": url + "admin/companies/check-email",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                    },
                    "data": JSON.stringify({
                        "company_email": company_email
                    }),
                };

                $.ajax(settings).done(function(response) {
                    response = $.parseJSON(response);
                    if (response.success) {
                        toastAlert('success', response.message);
                    } else {
                        toastAlert('error', response.message);
                        $('#company_email').val('');
                    }
                });
            });
            $('#company_phone').on('blur', function() {
                let company_phone = $('#company_phone').val();
                let url = '<?= base_url() ?>';
                var settings = {
                    "url": url + "admin/companies/check-phone",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                    },
                    "data": JSON.stringify({
                        "company_phone": company_phone
                    }),
                };

                $.ajax(settings).done(function(response) {
                    response = $.parseJSON(response);
                    if (response.success) {
                        toastAlert('success', response.message);
                    } else {
                        toastAlert('error', response.message);
                        $('#company_phone').val('');
                    }
                });
            });

            $('#plant_email').on('blur', function() {
                let plant_email = $('#plant_email').val();
                let url = '<?= base_url() ?>';
                var settings = {
                    "url": url + "admin/plants/check-email",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                    },
                    "data": JSON.stringify({
                        "plant_email": plant_email
                    }),
                };

                $.ajax(settings).done(function(response) {
                    response = $.parseJSON(response);
                    if (response.success) {
                        toastAlert('success', response.message);
                    } else {
                        toastAlert('error', response.message);
                        $('#plant_email').val('');
                    }
                });
            });
            $('#plant_phone').on('blur', function() {
                let plant_phone = $('#plant_phone').val();
                let url = '<?= base_url() ?>';
                var settings = {
                    "url": url + "admin/plants/check-phone",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                    },
                    "data": JSON.stringify({
                        "plant_phone": plant_phone
                    }),
                };

                $.ajax(settings).done(function(response) {
                    response = $.parseJSON(response);
                    if (response.success) {
                        toastAlert('success', response.message);
                    } else {
                        toastAlert('error', response.message);
                        $('#plant_phone').val('');
                    }
                });
            });

            $('#vendor_email').on('blur', function() {
                let vendor_email = $('#vendor_email').val();
                let url = '<?= base_url() ?>';
                var settings = {
                    "url": url + "admin/vendors/check-email",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                    },
                    "data": JSON.stringify({
                        "vendor_email": vendor_email
                    }),
                };

                $.ajax(settings).done(function(response) {
                    response = $.parseJSON(response);
                    if (response.success) {
                        toastAlert('success', response.message);
                    } else {
                        toastAlert('error', response.message);
                        $('#vendor_email').val('');
                    }
                });
            });
            $('#vendor_phone').on('blur', function() {
                let vendor_phone = $('#vendor_phone').val();
                let url = '<?= base_url() ?>';
                var settings = {
                    "url": url + "admin/vendors/check-phone",
                    "method": "POST",
                    "timeout": 0,
                    "headers": {
                        "key": "4e1c3ee6861ac425437fa8b662651cde",
                        "source": "ANDROID",
                        "Content-Type": "application/json",
                        "Cookie": "ci_session=f3meuemlu90ugrr16h69p1fbd5nhlker"
                    },
                    "data": JSON.stringify({
                        "vendor_phone": vendor_phone
                    }),
                };

                $.ajax(settings).done(function(response) {
                    response = $.parseJSON(response);
                    if (response.success) {
                        toastAlert('success', response.message);
                    } else {
                        toastAlert('error', response.message);
                        $('#vendor_phone').val('');
                    }
                });
            });
        })


        jQuery(document).ready(function() {
            jQuery(".home-successstories").owlCarousel({
                loop: true,
                margin: 0,
                dots: false,
                nav: true,
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: true,
                animateIn: 'fadeIn',
                animateOut: 'fadeOut',
                navText: ["<i class='zmdi zmdi-arrow-left'></i>", "<i class='zmdi zmdi-arrow-right'></i>"],
                responsive: {
                    0: {
                        items: 1,
                    },
                    600: {
                        items: 1,
                    },
                    750: {
                        items: 1,
                    },
                    1000: {
                        items: 1,
                    },
                    1200: {
                        items: 1,
                    }
                }
            });
        });

        // function getImageModal(enq_id){
        //     let baseUrl = '<?= base_url() ?>';
        //     $.ajax({
        //       type: "POST",
        //       data: { enq_id: enq_id },
        //       url: baseUrl+"/admin/get-image-modal",
        //       dataType: "JSON",
        //       success: function(res){
        //         if(res.success){
        //           $('#enquiryImage').modal('show');
        //           $('#enquiryImageTitle').html(res.data.title);
        //           $('#enquiryImageBody').append(res.data.body);
        //         } else {
        //           $('#enquiryImage').modal('hide');
        //           $('#enquiryImageTitle').html('');
        //           $('#enquiryImageBody').html('');
        //         }
        //       }
        //     });
        // }
    </script>
<link href="https://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?=getenv('app.adminAssetsURL')?>assets/css/jquery-stickytable.css">

<script>
var  w_width = $(window).width();
var position_obj = [];

var half_w_width = w_width /2;
$('.obj').each(function(){ 
  position_obj.push($(this).offset().left);
});

Draggable.create(".general_table_style", {
    type: "scrollLeft",
    edgeResistance: 0.9,
    throwProps: !0,
    maxDuration: 1.2,
    minDuration: 1.2,
    lockAxis:true,
    throwProps:true,
    onThrowUpdate : function(){
    var wrapper_left = this.x *(-1) + half_w_width;

    $(position_obj).each(function( i, val ) {
         obj_c = i + 1;
         if( val < wrapper_left) {
            $('.obj').removeClass('active');
            $('#obj_'+obj_c).addClass('active');
         }
     });
    },
    snap: function(e) { 
      var span_window_w = $(window).width();
        return -Math.round(Math.round(e / (.3 * span_window_w)) * (.3 * span_window_w)) // This changes the threshold for dragging and snapping the obj's
    },
  onDragStart: function() {
  
   
    },
   onThrowComplete: function() { 
       
          TweenLite.set(".obj", {className:"+=loc"})
    }
   
   
}), TweenMax.set(".general_table_style", {
    overflow: "scroll",
}), $(".general_table_style").scroll(function() {
    $(".parallax").each(function() {
        var leftOffset = $(this).offset().left;
        var element_w = $(this).width();
      
        leftOffset < w_width && leftOffset + element_w > 0 && TweenLite.to($(this), 1.2, {
            xPercent: (w_width - leftOffset) / w_width * $(this).attr("data-velocity"),
            overwrite: 0
        })
    })
})

</script>
<script src="<?=getenv('app.adminAssetsURL')?>assets/css/jquery-stickytable.js"></script>
<!-- 
<script src="https://amphiluke.github.io/jquery-plugins/floatingscroll/jquery.floatingscroll.min.js"></script>
<script src="https://amphiluke.github.io/jquery-plugins/floatingscroll/floatingscroll-demo.js"></script> -->
<script type="text/javascript">
			$(function() {
				//load stickyTable with overflowy option
				$('#myTable').stickyTable({overflowy: true});

				

				
			});
		</script>
    <script type="text/javascript">
        function copyToClipboard() {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($('#whatsapp_link').text()).select();
            console.log($temp.val($('#whatsapp_link').text()).select());
            document.execCommand("copy");
            $temp.remove();
            toastAlert("success", 'Link Copied To Clipboard !!!');
        }

        function maxHour(valam, counter) {
            if (valam == '') {
                toastAlert("error", 'Hour Can\'t be Blank !!!');
                $('#hour' + counter).css('border', '1px solid red');
            } else {
                if (valam > 4) {
                    toastAlert("error", 'Hour Can\'t be Greater Than Four Hours !!!');
                    $('#hour' + counter).css('border', '1px solid red');
                    $('#hour' + counter).val('');
                } else {
                    $('#hour' + counter).css('border', '1px solid green');
                }
            }
        }

        function maxMinute(valam, counter) {
            if (valam == '') {
                toastAlert("error", 'Minute Can\'t be Blank !!!');
                $('#minute' + counter).css('border', '1px solid red');
            } else {
                if (valam > 59) {
                    toastAlert("error", 'Minute Can\'t be Greater Than Fifty Nine Minutes !!!');
                    $('#minute' + counter).css('border', '1px solid red');
                    $('#minute' + counter).val('');
                } else {
                    $('#minute' + counter).css('border', '1px solid green');
                }
            }
        }
    </script>
    <script>
        
        // surajit sidebar js

        // let arrow = document.querySelectorAll(".arrow");
        // for (var i = 0; i < arrow.length; i++) {
        // arrow[i].addEventListener("click", (e)=>{
        // let arrowParent = e.target.parentElement.parentElement.parentElement;//selecting main parent of arrow
        // arrowParent.classList.toggle("showMenu");
        // });
        // }

        let sidebar = document.querySelector(".sidebar");
        let sidebarBtn = document.querySelector(".bx-menu");
        console.log(sidebarBtn);
        sidebarBtn.addEventListener("click", ()=>{
        sidebar.classList.toggle("close");
        });
        $(document).ready(function(){
            //jquery for toggle sub menus
            $('.iocn-link').click(function(){
            $(this).next('.sub-menu').slideToggle();
            $(this).find('.arrow').toggleClass('rotate');
            $(this).parent('li').siblings().find('.sub-menu').slideUp();
            $(this).parent('li').siblings().find('.arrow').removeClass('rotate');
            });
            $('.nav-links li').click(function(){
                $(this).addClass('showMenu').siblings().removeClass();
            });
            $('.bx-menu').click(function(){
                $('.close li').find('.sub-menu').slideUp();
                $('.close li').siblings().find('.arrow').removeClass('rotate');
            });
        });
    </script>
    <script src="https://cdn.canvasjs.com/jquery.canvasjs.min.js"></script>
    
<link rel="stylesheet" href="<?=getenv('app.adminAssetsURL')?>assets/css/jquery.floatingscroll.css">
<link rel="stylesheet" href="<?=getenv('app.adminAssetsURL')?>assets/css/floatingscroll-demo.css">
 <script src="<?= getenv('app.adminAssetsURL') ?>assets/js/jquery.floatingscroll.min.js"></script>
<script src="<?= getenv('app.adminAssetsURL') ?>assets/js/floatingscroll-demo.js"></script>
<script src="<?= getenv('app.adminAssetsURL') ?>assets/js/jquery.dragscroll.min.js"></script>
<script src="<?= getenv('app.adminAssetsURL') ?>assets/js/freeze-table.min.js"></script>


<script type="text/javascript">
    $(".fixed-header").freezeTable({
        freezeColumn:false,
        fixedNavbar:'.fixed-table-head',
        container:false,
    });

    $('.drag').dragScroll({

    });
</script>
</body>

</html>