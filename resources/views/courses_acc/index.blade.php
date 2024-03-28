<!DOCTYPE html>
<html class="loading semi-dark-layout" lang="en" data-layout="semi-dark-layout" data-textdirection="rtl">
<!-- BEGIN: Head-->

    @include('layouts.header')
    @yield('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&family=Noto+Sans+Arabic:wght@700&display=swap" rel="stylesheet">


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static " data-open="click" data-menu="vertical-menu-modern" data-col="">

      <!-- BEGIN: Header-->
      <nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
        <div class="navbar-container d-flex content">
            <div class="bookmark-wrapper d-flex align-items-center">
                <ul class="nav navbar-nav d-xl-none">
                    <li class="nav-item"><a class="nav-link menu-toggle" href="javascript:void(0);"><i class="ficon" data-feather="menu"></i></a></li>
                </ul>
                <ul class="nav navbar-nav bookmark-icons">
                 
                </ul>
                <ul class="nav navbar-nav">
                    <li class="nav-item d-none d-lg-block"><a class="nav-link bookmark-star"></a>
                        <div class="bookmark-input search-input">
                            <div class="bookmark-input-icon"><i data-feather="search"></i></div>
                            <input class="form-control input" type="text" placeholder="Bookmark" tabindex="0" data-search="search">
                            <ul class="search-list search-list-bookmark"></ul>
                        </div>
                    </li>
                </ul>
            
            </div>
            <ul class="nav navbar-nav align-items-center ml-auto" style="position: relative;left: 37%;">
    
               
                
                {{-- <li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="javascript:void(0);" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-{{ LaravelLocalization::getCurrentLocale() == "ar" ? "jo" :"us" }}"></i><span class="selected-language">{{ LaravelLocalization::getCurrentLocale() }}</span></a>
                    
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-flag">
                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        
                                <a rel="alternate" class="dropdown-item" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                   
                                     {{ $properties['native'] }}</a>
                                </a>
                        
                        @endforeach
                    </div>
                </li> --}}
    
          
                <div>
                    <h1 style="color: green;font-family: 'Cairo', sans-serif;font-family: 'Noto Sans Arabic', sans-serif;">الاحصائيات المالية (أكاديمية مرماز)</h1>
                </div>
            </ul>
        </div>
    </nav>




      <!-- BEGIN: Main Menu-->
      <div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <?php $image = \App\Models\Setting::pluck('image')->first() ?>
                <?php $name = \App\Models\Setting::pluck('dashboardname')->first() ?>
            
                <li class="nav-item mr-auto"><a class="navbar-brand" href=""><span class="brand-logo">
                  <img src="{{ $image }}" alt="">  </span>
                        <h2 class="brand-text">{{ $name }}</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>


            <div class="main-menu-content">
                <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
                    <?php $aa = LaravelLocalization::getCurrentLocale() ?>

                    <li class=" nav-item {{ Route::is('courses_acc')? 'active' : '' }}"><a class="d-flex align-items-center" href="{{ route('courses_acc') }}"><i style="color:{{ Route::is('courses_acc') ? '#d2d2d2' : '#656565'}}" class="fa-solid chalkboard"></i><span style="color:{{ Route::is('courses_acc') ? '#d2d2d2' : '#656565' }}" class="menu-title text-truncate">الدورات</span></a></li>
                   
             

                </ul>
            </div>

      
    </div>
    <!-- END: Main Menu-->
   

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">

              
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic table table-responsive-md yajra-datatable">
                                    <thead>
                                        <tr>
                                                
                                            <th>#</th>
                                            <th>اسم الدورة</th>
                                            <th>اسم المعلم</th>
                                            <th> كشف الاحصائيات  </th>
                                    
                                        
                                            
                                        </tr>
                                    </thead>

                                    <tbody>
                                
                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                    <!-- Modal to add new record -->

                </section>


            </div>
        </div>
    </div>
    <!-- END: Content-->

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

    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>

    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>

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

<script>
        
    function msg_add(){

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تمت الاضافة بنجاح ',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
            confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false

        });

    }

    function msg_edit(){

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تم التعديل بنجاح',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
            confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false

        });

    }

    function msg_delete(){

        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تم الحذف بنجاح',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
            confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false

        });

      }

</script>

 {{-- show information in yajradatatable --}}
 <script type="text/javascript">

    $(function () {
    var table = $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('get_all_courses_acc') }}",
        columns: [
            {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name'         ,name: 'name'},
            {data: 'teacher_id'         ,name: 'teacher_id'},
            {data: 'statistices'         ,name: 'statistices'},

  
        ],
        "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
    });
    });
</script>
{{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}



{{-- open modal add user --}}
<script>
    $('#modal_add').on('show.bs.modal', function(event) {
        $('#city').text('');
    
    })
</script>

<script>
$(function () {
    'use strict';
    var changePicture = $('#change-picture'),
        userAvatar = $('.user-avatar');
    // Change user profile picture
    if (changePicture.length) {
        $(changePicture).on('change', function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (userAvatar.length) {
                    userAvatar.attr('src', reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });
    }
});
</script>




{{-- add user --}}
<script>
    $(document).on('click', '#add_user', function (e) {
        // $('#name_error').text('');

   
        $("#add_user2").css("display", "block");
        $("#add_user").css("display", "none");
        var formData = new FormData($('#add_user_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('store_cities')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        $("#add_user2").css("display", "none");
                        $("#add_user").css("display", "block");
                        $('.close').click();
                        $('#position-top-start').click();
             
                },
                error: function (reject) {
                    $("#add_user2").css("display", "none");
                    $("#add_user").css("display", "block");
                    var response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function (key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        });
</script>


{{-- edit user --}}
<script>
    $('#edit_user').on('show.bs.modal', function(event) {
    
        var button = $(event.relatedTarget)
        var id =                  button.data('id')
        var city =                button.data('city')
        
        
        var modal = $(this)
        modal.find('.modal-body #id2').val(id);
        modal.find('.modal-body #city2').val(city);
  

    })
</script>


{{-- update user --}}
<script>
    function do_update(){
    
        $('#title2_error').text('')
        $('#body2_error').text('')

        
        $("#editing").css("display", "none");
        $("#editing2").css("display", "block");

        var formData = new FormData($('#edit_user_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('update_cities')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    $("#editing").css("display", "block");
                    $("#editing2").css("display", "none");
            
                    $('.close').click();
                
                    $('#position-top-start_edit').click();
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                
                }, error: function (reject) {
                        $("#editing").css("display", "block");
                        $("#editing2").css("display", "none");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "2_error").text(val[0]);
                        });
                }
            });
    }
</script>

{{-- fill delete modal user --}}
<script>
    $('#delete_user').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id     =  button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id3').val(id);
    })
</script>


{{-- delete user--}}
<script>
    function do_delete(){

        $("#delete_user_button").css("display", "none");
        $("#delete_user2").css("display", "block");
        var formData = new FormData($('#delete_user_form')[0]);
        $.ajax({
            type: 'post',
            url: "{{route('destroy_cities')}}",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#delete_user2").css("display", "none");
                $("#delete_user_button").css("display", "block");
                $('.close').click();
                $('#position-top-start_delete').click();
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
            
            }, error: function (reject) {
            }
        });
 }
</script>
</body>
<!-- END: Body-->

</html>
