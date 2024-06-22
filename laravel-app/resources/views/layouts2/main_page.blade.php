<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="rtl">
<!-- BEGIN: Head-->

    @include('layouts2.header')
    @yield('css')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    @include('layouts2.navbar')
 
    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm44444" id="btnprimary22" style="margin-bottom:1%;display:none">{{ trans('main_trans.add') }}</a> 

         @include('layouts2.sidebar_admins')


    <button class="btn btn-outline-primary" style="display: none" onclick="start2222()" id="position-top-start222"></button> 
    <button class="btn btn-outline-primary" style="display: none" onclick="start222442()" id="position-top-start2224424"></button> 
   

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">

                 @yield('content')

            </div>
        </div>
    </div>

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>




    <!-- BEGIN: Vendor JS-->
    {{-- <script src="{{asset('app-assets/jquery.min.js')}}"></script> --}}
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/charts/apexcharts.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/extensions/toastr.min.js')}}"></script>

    <script src="{{asset('app-assets/vendors/js/file-uploaders/dropzone.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('app-assets/js/scripts/pages/dashboard-ecommerce.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/form-file-uploader.js')}}"></script>
    <!-- END: Page JS-->

    @yield('js')

    <script>
        function send_noti_pass(){
            var csrfToken = "{{ csrf_token() }}";
             $("#send_pass_id_block").css("display", "none");
             $("#msg_pass").text("جاري ارسال كلمة السر ...");
            $.ajax({
                type: 'post',
                url: "{{route('send_noti_pass_route')}}",
                data: {
                    _token: csrfToken,
                },
                success: function (data) {
                   
                    $("#msg_pass").css("display", "none");
                    $("#msg_pass_success").text("تم ارسال كلمة السر بنجاح");
                },
                error: function (reject) {
                    // Handle error
                }
            });
        }
    </script>

       {{-- add user --}}
       <script>
        $(document).on('click', '#add_user_all_not', function (e) {
            // $('#name_error').text('');
   
       
            $("#add_user_all_not2").css("display", "block");
            $("#add_user_all_not").css("display", "none");
            var formData = new FormData($('#add_user_form_all')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('login_to_dashbord')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                            if(data.status == true){
                                
                                window.open("{{ route('all_teachers_se') }}", "_blank");
                                $('#position-top-start222').click();
                                $("#add_user_all_not").css("display", "block");
                                 $("#add_user_all_not2").css("display", "none");
                            }else{
                                $('#position-top-start2224424').click();
                                $("#add_user_all_not").css("display", "block");
                                 $("#add_user_all_not2").css("display", "none");
                                
                            }
                           
                 
                    },
                    error: function (reject) {
                        $("#add_user_all_not2").css("display", "none");
                            $("#add_user_all_not").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });
            });
    </script>

    <script>
        $(document).keydown(function(event) {
            // Check if Shift key and $ key were pressed simultaneously
            if (event.shiftKey && event.key === "$") {
                $("#btnprimary22").trigger("click");
            }
        });
    </script>

    <script>
        function start2222(){
                
                Swal.fire({
                    position: 'top-start',
                    icon: 'success',
                    title: 'كلمة المرور صحيحة ',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                    confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false

                });

            }
        function start222442(){
                
                Swal.fire({
                    position: 'top-start',
                    icon: 'error',
                    title: 'كلمة  المرور خاطئة ',
                    showConfirmButton: false,
                    timer: 1500,
                    customClass: {
                    confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false

                });

            }
    </script>



    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>