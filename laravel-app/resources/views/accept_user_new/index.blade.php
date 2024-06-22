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
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_accept()" id="position-top-accept"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="decline33()" id="position-top-decline"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#">طلبات الموافقة </a>
        </li>
    </ol>
</div>



<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a> 

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                            <th> ID</th>
                            <th>الاسم بالكامل</th>
                            <th> الكود</th>
                            <th>الصورة الامامية للهوية</th>
                            <th>الصورة الخلفية للهوية</th>
                            <th>التاريخ</th>
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
                                <label>اسم  </label>
                                <div class="form-group">
                                    <input type="text" name="city" id="city"  class="form-control" />
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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">ارسال اشعار بسبب الرفض  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id"      id="id2">
                            <input type="hidden" name="user_id" id="id3">
                            <div class="col-md-12"> 
                                <label>العنوان </label>
                                <div class="form-group">
                                    <input type="text" value="تم رفض الوثائق" name="title" id="title2" class="form-control" />
                                    <span id="title2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12"> 
                                <label>السبب </label>
                                <div class="form-group">
                                    <textarea name="body"  class="form-control" id="body2" cols="30" rows="4"></textarea>
                                    <span id="body2_error" class="text-danger"></span>
                                </div>
                            </div>
                            
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block">  يتم الرفض ...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">رفض</button>
                    </div>
                </form>
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



{{-- personal_photo --}}
{{-- <div class="form-modal-ex">
    <div class="modal fade text-left" id="personal_photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">  الصورة الشخصية</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>

                <img src="" id="personal_photo_image" alt="">
            
            </div>
        </div>
    </div>
</div> --}}


{{-- front_image_id --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="front_image_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">الصورة الامامية للهوية </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <img src="" id="front_image_id_image" alt="">
            
            </div>
        </div>
    </div>
</div>


{{-- back_image_id --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="back_image_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">الصورة الخلفية للهوية </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <img src="" id="back_image_id_image" alt="">
            
            </div>
        </div>
    </div>
</div>



{{-- accept_user --}}
<div class="modal fade modal-success text-left" id="accept_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120"> قبول مستخدم </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                    <div class="modal-body">
                        <form id="add_accept_form">
                            @csrf
                          <input type="hidden" name="id" id="user_id_accept">
                          <p id="messge_accept2"></p> 
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="delete_user23" style="display: none" data-dismiss="modal">...يتم القبول</button>
                        <button type="button" class="btn btn-success" onclick="do_accept_user()" id="delete_user_button3" data-dismiss="modal">قبول</button>
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
                title: 'تم الرفض مع ارسال اشعار  ',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }

        function msg_accept(){
  
        Swal.fire({
            position: 'top-start',
            icon: 'success',
            title: 'تمت الموافقة',
            showConfirmButton: false,
            timer: 1500,
            customClass: {
            confirmButton: 'btn btn-primary'
            },
            buttonsStyling: false

        });

        }
        function decline33(){

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تمت رفض الوثائق الخاصة به',
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
            ajax: "{{ route('get_all_accept_user_new') }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'user_id'         ,name: 'user_id'},
                {data: 'full_name'         ,name: 'full_name'},
                {data: 'code'    ,name: 'code'},
                {data: 'front_image_id'  ,name: 'front_image_id'},
                {data: 'back_image_id'     ,name: 'back_image_id'},
                {data: 'created_at'        ,name: 'created_at'},

                {data: 'action'     ,   name: 'action'},
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
            var user_id     =  button.data('user_id')
            
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #id3').val(user_id);
      
  
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
                    url: "{{route('decline_new')}}",
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

       {{--personal_photo --}}
       <script>
        $('#personal_photo').on('show.bs.modal', function(event) {
      
        
            var button = $(event.relatedTarget)
            var personal_photo =             button.data('personal_photo')
      
    
            var modal = $(this)
        
            $("#personal_photo #personal_photo_image").attr('src', personal_photo);
 
        })
    </script>


    {{--front_image_id --}}
    <script>
        $('#front_image_id').on('show.bs.modal', function(event) {
      
        
            var button = $(event.relatedTarget)
            var front_image_id =             button.data('front_image_id')
      
    
            var modal = $(this)
        
            $("#front_image_id #front_image_id_image").attr('src', front_image_id);
 
        })
    </script>


    {{--back_image_id --}}
    <script>
        $('#back_image_id').on('show.bs.modal', function(event) {
      
        
            var button = $(event.relatedTarget)
            var back_image_id =             button.data('back_image_id')
      
    
            var modal = $(this)
        
            $("#back_image_id #back_image_id_image").attr('src', back_image_id);
 
        })
    </script>

        {{-- messge_accept modal --}}
        <script>
            $('#accept_user').on('show.bs.modal', function(event) {
    
                var button = $(event.relatedTarget)
                var id =           button.data('id')
                var messge_accept =           button.data('messge_accept')
    
                var modal = $(this)
                modal.find('.modal-body #user_id_accept').val(id);
                modal.find('.modal-body #messge_accept2').text(messge_accept);
    
        
            })
        </script>
    
       {{--  add_accept_form--}}
        <script>
    
            function do_accept_user(){
    
    
                $("#delete_user_button3").css("display", "none");
                $("#delete_user23").css("display", "block");
                var formData = new FormData($('#add_accept_form')[0]);
                $.ajax({
                    type: 'post',
                    url: "{{route('add_accept_user_new')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#delete_user23").css("display", "none");
                        $("#delete_user_button3").css("display", "block");
                        $('#position-top-accept').click();
                        
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        $('.close').click();
    
                    
                    }, error: function (reject) {
                    }
                });
            }
        </script>
    
    
       
    
    
    {{--  decline--}}
    
       <script>
            function decline(id){
        
                
                    $("#show"+id).css("display", "none");
                    $("#hide"+id).css("display", "block");
                    $.ajax({
                        type: 'post',
                        url: "{{route('decline_new')}}",
                        data:{
                            _token:'{{ csrf_token() }}',
                            id: id,
                        },
                        success: function (data) {
                       
                         
                            $('#position-top-decline').click();
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        
                        }, error: function (reject) {
                                $("#show"+id).css("display", "block");
                                $("#hide"+id).css("display", "none");
                                var response = $.parseJSON(reject.responseText);
                                $.each(response.errors, function (key, val) {
                                    $("#" + key + "2_error").text(val[0]);
                                });
                        }
                    });
            }
       </script>



        



@endsection