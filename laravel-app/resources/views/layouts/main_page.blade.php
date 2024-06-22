<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="rtl">
<!-- BEGIN: Head-->

    @include('layouts.header')
    @yield('css')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    @include('layouts.navbar')
    <ul class="main-search-list-defaultlist d-none">
        <li class="d-flex align-items-center"><a href="javascript:void(0);">
                <h6 class="section-label mt-75 mb-0">Files</h6>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/xls.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Two new item submitted</p><small class="text-muted">Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;17kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/jpg.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">52 JPG file Generated</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;11kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/pdf.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">25 PDF File Uploaded</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;150kb</small>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between w-100" href="app-file-manager.html">
                <div class="d-flex">
                    <div class="mr-75"><img src="../../../app-assets/images/icons/doc.png" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna_Strong.doc</p><small class="text-muted">Web Designer</small>
                    </div>
                </div><small class="search-data-size mr-50 text-muted">&apos;256kb</small>
            </a></li>
        <li class="d-flex align-items-center"><a href="javascript:void(0);">
                <h6 class="section-label mt-75 mb-0">Members</h6>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-8.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">John Doe</p><small class="text-muted">UI designer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-1.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Michal Clark</p><small class="text-muted">FontEnd Developer</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-14.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Milena Gibson</p><small class="text-muted">Digital Marketing Manager</small>
                    </div>
                </div>
            </a></li>
        <li class="auto-suggestion"><a class="d-flex align-items-center justify-content-between py-50 w-100" href="app-user-view.html">
                <div class="d-flex align-items-center">
                    <div class="avatar mr-75"><img src="../../../app-assets/images/portrait/small/avatar-s-6.jpg" alt="png" height="32"></div>
                    <div class="search-data">
                        <p class="search-data-title mb-0">Anna Strong</p><small class="text-muted">Web Designer</small>
                    </div>
                </div>
            </a></li>
    </ul>
    <ul class="main-search-list-defaultlist-other-list d-none">
        <li class="auto-suggestion justify-content-between"><a class="d-flex align-items-center justify-content-between w-100 py-50">
                <div class="d-flex justify-content-start"><span class="mr-75" data-feather="alert-circle"></span><span>No results found.</span></div>
            </a></li>
    </ul>
    <!-- END: Header-->

    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm44444" id="btnprimary22" style="margin-bottom:1%;display:none">{{ trans('main_trans.add') }}</a> 


    @if(Auth::guard('teachers')->check())
         @include('layouts.sidebar_teachers')
    @else
         @include('layouts.sidebar_admins')
    @endif

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
    <!-- END: Content-->

        {{-- modal add --}}
        <div class="form-modal-ex" id="modal_add">
            <div class="modal fade text-left" id="inlineForm44444" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">الدخول الى لوحة الأمور المالية </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div style="max-width:40%;padding: 4%;">

                            <button class="form-control btn btn-primary" id="send_pass_id_block" onclick="send_noti_pass()"> ارسال كلمة السر </button>
                            <span id="msg_pass"></span>
                            <span id="msg_pass_success" style="color:green"></span>
                        </div>
                        <form id="add_user_form_all">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                            

                                    <div class="col-md-12">
                                        <label>كلمة السر  </label>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password"  class="form-control" />
                                            <span id="password_error" class="text-danger"></span>
                                        </div>
                                    </div>
                                 
                                
                                </div>
                                
                            
                        
                            
                            
                            </div>
                            <div class="modal-footer">
                                <button type="button" style="display: none" id="add_user_all_not2" class="btn btn-primary btn-block"> جاري الدخول الى اللوحة ...</button>
                                <button type="button" id="add_user_all_not" class="btn btn-primary btn-block">الدخول</button>
                            </div>
                        </form>
                    </div>
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