@extends('layouts2.main_page')



@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo&family=Noto+Sans+Arabic:wght@700&display=swap" rel="stylesheet">

    <style>
          
      </style>

@endsection

@section('content')




                <div style="padding:2%">
                   <?php $course = \App\Models\Course::find($course_id); ?>(الطلاب المنهي اشتراكهم)

                </div>
                <div class="col-xl-12 col-md-12 col-12">
                    <div class="card card-statistics">
                        <div class="card-header">
                            <?php $course =  \App\Models\Course::where('id',$course_id)->first(); ?>
                            <?php $teacher = \App\Models\Teacher::where('id',$course->teacher_id)->first(); ?>
                            <h4 class="card-title"> {{ $course->name }} <span style="font-size:12px"> ({{ $teacher->name }})</span></h4> 
                            <div class="d-flex align-items-center">
                                {{-- <p class="card-text font-small-2 mr-25 mb-0">Updated 1 day ago</p> --}}
                            </div>
                        </div>
                        <div class="card-body statistics-body">
                            <div class="row">
                                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="media">
                                        <div class="avatar bg-light-primary mr-2">
                                            <div class="avatar-content">
                                                <i data-feather="trending-up" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto">
                                            <?php $user_id = \App\Models\UserCourse::where('course_id',$course_id)->where('user_id','!=',2)->onlyTrashed()->pluck('user_id'); ?>
                                            <?php $user_count = \App\Models\User::whereIn('id',$user_id)->count(); ?>
                                            <h4 class="font-weight-bolder mb-0">{{ $user_count }}</h4>
                                            <p class="card-text font-small-3 mb-0">عدد المشتركين</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="media">
                                        <div class="avatar bg-light-info mr-2">
                                            <div class="avatar-content">
                                                <i data-feather="user" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto">
                                            <?php $total = \App\Models\Wallet::whereIn('user_id',$user_id)->where('course_id',$course_id)->where('user_id','!=',2)->where('type_recharge','subscripe')->sum('money'); ?>
                                            <h4 class="font-weight-bolder mb-0">{{ number_format($total) }} دع</h4>
                                            <p class="card-text font-small-3 mb-0">المجموع</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                    <div class="media">
                                        <div class="avatar bg-light-info mr-2">
                                            <div class="avatar-content">
                                                <i data-feather="user" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto">
                                            <?php $total =   \App\Models\Wallet::whereIn('user_id',$user_id)->where('course_id',$course_id)->where('user_id','!=',2)->where('type_recharge','subscripe')->sum('money'); ?>
                                            <?php $course =  \App\Models\Course::where('id',$course_id)->first(); ?>
                                            <?php $teacher = \App\Models\Teacher::where('id',$course->teacher_id)->first(); ?>
                                            
                                            <h4 class="font-weight-bolder mb-0">{{ number_format($total -  $total *  $teacher->ratio / 100  )}} دع</h4>
                                            <p class="card-text font-small-3 mb-0">نسبة الأستاذ ( % {{ 100 - $teacher->ratio }})</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-12 mb-4 mb-sm-0">
                                    <div class="media"  style="margin-bottom:8%;">
                                        <div class="avatar bg-light-danger mr-2">
                                            <div class="avatar-content">
                                                <i data-feather="box" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto">
                                            <?php $total =   \App\Models\Wallet::whereIn('user_id',$user_id)->where('course_id',$course_id)->where('user_id','!=',2)->where('type_recharge','subscripe')->sum('money'); ?>
                                            <?php $course =  \App\Models\Course::where('id',$course_id)->first(); ?>
                                            <?php $teacher = \App\Models\Teacher::where('id',$course->teacher_id)->first(); ?>
                                            
                                            <h4 class="font-weight-bolder mb-0">{{ number_format($total *  $teacher->ratio / 100  )}} دع</h4>
                                            <p class="card-text font-small-3 mb-0">نسبة الأكاديمية ( % {{$teacher->ratio }})</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                    <div class="media">
                                        <div class="avatar bg-light-danger mr-2">
                                            <div class="avatar-content">
                                                <i data-feather="box" class="avatar-icon"></i>
                                            </div>
                                        </div>
                                        <div class="media-body my-auto">
                                            <?php $course =  \App\Models\Course::where('id',$course_id)->first(); ?>
                                            <h4 class="font-weight-bolder mb-0">{{ number_format( $course->price - $course->discount  )}}</h4>
                                            <p class="card-text font-small-3 mb-0">سعر الدورة</p>
                                        </div>
                                    </div>
                                </div>
                              
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Statistics Card -->
            </div>

            <div style="display: flex">
                <div style="margin-left: 1%">
                    <h1>الطلاب المشتركين</h1>
                </div>
                <div>
                    <a href="{{ route('export-excel_expire',$course_id) }}" class="btn btn-sm btn-success">تصدير إلى Excel</a>
                    <a href="{{ route('export-excel_free_expire',$course_id) }}" class="btn btn-sm btn-success">تصدير إلى Excel (مجاني)</a>
                </div>

                

            </div>
             
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic table table-responsive-md yajra-datatable">
                                    <thead>
                                        <tr>
                                                
                                            <th>#</th>
                                            <th>ID</th>
                                            <th> اسم المستخدم</th>
                                            <th> الجوال </th>
                                            <th> الدفع </th>
                                            <th> ملاحظة عند الاشتراك </th>
                                            <th>تاريخ الاشتراك</th>
                                            <th>تاريخ انتهاء الاشتراك</th>
                                      
                                            
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
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>


    @endsection


    @section('js')
    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>


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
    var table; // Declare table variable in a broader scope

    $(function () {
        table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_all_users_courses_expire', $course_id) }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'id', name: 'id'},
                {data: 'full_name', name: 'verified_data.full_name'},
                {data: 'mobile', name: 'mobile'},
                {data: 'transactions', name: 'transactions'},
                {data: 'notes', name: 'notes'},
                {data: 'data_subscripe', name: 'data_subscripe'},
                {data: 'deleted_at', name: 'deleted_at'},
            ],
            "lengthMenu": [[25, 50, -1], [25, 50, 'All']], // page length options
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

@endsection