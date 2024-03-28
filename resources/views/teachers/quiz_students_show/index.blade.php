@extends('layouts.main_page')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">
   


@endsection


@section('content')


 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add2()" id="position-top-start2"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#">التصحيح </a>
        </li>
    </ol>
</div>


<?php $user =  \App\Models\User::where('id',$user_id)->first(); ?>
 <h1>  اجابات الطالب  {{ $user->name ?? "-" }} </h1>



{{-- <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a>  --}}

<section id="basic-datatable">
    <div class="row">
        <div class="col-6">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                            <th>الاجابات</th>
                            {{-- <th>العمليات</th> --}}
                          
                            
                        </tr>
                    </thead>

                    <tbody>
                 
                    </tbody>

                </table>

            </div>
        </div>
        <div class="col-6">
     
            <form id="add_user_form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                   
                        <input type="hidden" name="quiz_id" value="{{ $quiz_id }}">
                        <input type="hidden" name="user_id" value="{{ $user_id }}">
                        <div class="col-md-12">
                            <label>  علامة الطالب </label>
                            <div class="form-group">
                                <?php $quiz_wait = \App\Models\QuizStart::where('quiz_id',$quiz_id)->where('user_id',$user_id)->orderBy('id','desc')->first(); ?>
                                @if($quiz_wait->waiting_pending == "waiting_pending")
                                    <input type="name" name="student_points" id="student_points"  class="form-control" placeholder="النقاط" />
                                    <span id="student_points_error" class="text-danger"></span>
                                @else
                                    <input type="name" value="{{  $quiz_wait ->end_points}}" name="student_points" id="student_points"  class="form-control" placeholder="النقاط" />
                                    <span id="student_points_error" class="text-danger"></span>
                                @endif

                            </div>
                        </div>
                        <div class="col-md-12">
                            <?php $uesr = \App\Models\User::where('id',$user_id)->first(); ?>
                            <label>    ارفاق صور الاجابة  ل الطالب : <span style="color:red"> {{ $uesr->name }} </span>  (اختياري) </label>
                            <div class="media mb-2">
                                <div class="media-body mt-50">
                                    <div class="col-12 d-flex mt-1 px-0">
                                        <label class="btn btn-primary mr-75 mb-0" for="change-picture2">
                                            <span class="d-none d-sm-block">اختر عدة صور</span>
                                            <input class="form-control" type="file" multiple id="change-picture2" name="imagee[]" hidden required accept="image/png, image/jpeg, image/jpg" />
                                            <span class="d-block d-sm-none">
                                                <i class="mr-0" data-feather="edit"></i>
                                            </span>
                                        </label>
                                        <button class="btn btn-outline-secondary d-block d-sm-none">
                                            <i class="mr-0" data-feather="trash-2"></i>
                                        </button>
                                    </div>
                                </div>
                            
                                <div id="selected-images" class="row"></div>
                                
                            
                                <span id="image_error" class="text-danger"></span>
                            </div>
                        </div>

                       
                    </div>
                    
                
            
                
                  
                </div>
                <?php $quiz_wait = \App\Models\QuizStart::where('quiz_id',$quiz_id)->where('user_id',$user_id)->orderBy('id','desc')->first(); ?>
                @if($quiz_wait->waiting_pending == "waiting_pending")
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                @else
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">يتم التعديل ...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                @endif
            </form>

        </div>

        <div class="col-6">
        </div>
        <div class="col-6">
        </div>
       
        <div class="col-6">
            <h1>صور الاجابات المرفقة للطالب </h1> 
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable2">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                            <th>الصورة</th>
                            <th>العمليات</th>
                          
                            
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


{{-- modal add --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                       

                            <div class="col-md-12">
                                <label>اسم المدينة </label>
                                <div class="form-group">
                                    <input type="name" name="city" id="city"  class="form-control" />
                                    <span id="city_error" class="text-danger"></span>
                                </div>
                            </div>

                           
                        </div>
                        
                    
                
                    
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- modal edit --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">عرض الصورة بالكامل  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
        
                <img src="" id="image2" alt="">
                  
               
            </div>
        </div>
    </div>
</div>

{{-- delete user --}}
<div class="modal fade modal-danger text-left" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">حذف  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="delete_user_form">
                    @csrf
                    <input type="hidden" name="id" id="id3">
                     هل انت متأكد من عملية الحذف ؟    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete_user2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                        <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_user_button" data-dismiss="modal">تأكيد</button>
                    </div>
                </form>
        </div>
    </div>
</div>


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

    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>

  




    <script>
        
        function msg_add(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم تصحيح الاختبار بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        
        function msg_add2(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'info',
                title: ' لا يمكن اضافة نقاط اكثر من النقاط العامة للاختبار  ',
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
            @php
                    $quiz_id= \Illuminate\Support\Facades\Crypt::encrypt($quiz_id); 
                    $user_id= \Illuminate\Support\Facades\Crypt::encrypt($user_id); 
            @endphp
            ajax: "{{ route('teachers.get_all_quiz_students_show',[$quiz_id,$user_id]) }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'image'         ,name: 'image'},

                // {data: 'action'     ,   name: 'action'},
            ],
            "lengthMenu": [[20,25,50,-1],[20,25,50,'All']],     // page length options
        });
        });
    </script>
     <script type="text/javascript">
    
        $(function () {
        var table = $('.yajra-datatable2').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('teachers.get_all_quiz_students_show_images',[$quiz_id,$user_id]) }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'image'         ,name: 'image'},
                {data: 'action3'     ,   name: 'action3'},
            ],
            "lengthMenu": [[20,25,50,-1],[20,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}


    <script>
        $(document).ready(function() {
            $('#change-picture2').on('change', function() {
                var files = $(this).prop('files');
                var imagesPerDiv = 3;
                
                // Clear previous images
                $('#selected-images').empty();
        
                // Create an image element for each file.
                for (var i = 0; i < files.length; i++) {
                    var reader = new FileReader();
                    reader.onload = (function(index) { // Pass the index with a closure
                        return function(e) {
                            if (index % imagesPerDiv === 0) {
                                $('#selected-images').append('<div class="selected-images-container" style="padding:5%;"></div>');
                            }
                            $('.selected-images-container:last').append('<img src="' + e.target.result + '" style="width:20%;margin-left: 3%;border:inset" class="selected-image" />');
                        };
                    })(i); // Pass the current index
                    reader.readAsDataURL(files[i]);
                }
            });
        });
        </script>
    

  
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
                    url: "{{route('teachers.store_quiz_students_show')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                        if(data.status == true){
                        
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                            $("#change-picture2").val("");
                            $('.close').click();
                            $('#position-top-start').click();
                            $('.yajra-datatable2').DataTable().ajax.reload(null, false);
                            // window.location.href = "{{ route('teachers.quiz_students',[$quiz_id,$user_id]) }}";
                        }else{
                       
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                         
                            $('#position-top-start2').click();
                            $('.yajra-datatable2').DataTable().ajax.reload(null, false);
                        }
                 
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
            var image =              button.data('image')
            
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            $("#image2").attr('src', image);
      
  
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
                    url: "{{route('teachers.update_cities')}}",
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
                url: "{{route('teachers.destroy_quiz_students_show')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_user2").css("display", "none");
                    $("#delete_user_button").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_delete').click();
                    $('.yajra-datatable2').DataTable().ajax.reload(null, false);
                
                }, error: function (reject) {
                }
            });
     }
   </script>



@endsection