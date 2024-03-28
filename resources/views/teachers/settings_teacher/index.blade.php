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
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 

 @if(Auth::guard('teachers')->user()->is_complete == 0)
 <h1 style="text-align: center"> يجب تعبئة حقل الوصف واضافة الصورة الشخصية والغلاف</h1> <br>
 @endif

     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#">الاعدادات </a>
        </li>
    </ol>
</div>



{{-- <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a>  --}}




<form id="edit_user_form">
    @csrf
    <div class="modal-body">
        <div class="row">
            <input type="hidden" value="{{ Auth::guard('teachers')->user()->id }}" name="id">
            <div class="col-md-6"> 
             
                <label>اسم الأستاذ </label>
                <div class="form-group">
                    <input type="text" name="name" value="{{ Auth::guard('teachers')->user()->name }}" id="name2" class="form-control" />
                    <span id="name2_error" class="text-danger"></span>
                </div>
            </div>
            <div class="col-md-6"> 
           
                <label> الايميل </label>
                <div class="form-group">
                    <input type="text" name="email" id="email2" value="{{ Auth::guard('teachers')->user()->email }}"  class="form-control" />
                    <span id="email2_error" class="text-danger"></span>
                </div>
            </div>
            <div class="col-md-6"> 
           
                <label> معرف التيلغرام </label>
                <div class="form-group">
                    <input type="text" name="telegram" id="telegram2" value="{{ Auth::guard('teachers')->user()->telegram }}"  class="form-control" />
                    <span id="telegram2_error" class="text-danger"></span>
                </div>
            </div>
            <div class="col-md-6"> 
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <label for="login-password">الباسورد </label>

                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <input class="form-control form-control-merge @error('password') is-invalid @enderror" id="login-password" value="{{ Auth::guard('teachers')->user()->password_show }}" type="password" name="password" placeholder="············" aria-describedby="login-password" tabindex="2" />
                        <div class="input-group-append"><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span></div>
                          
                    </div>
                </div>
            </div>
            <div class="col-md-12"> 
                <span id="remain">240</span> عدد الاحرف المسموح بها 
                <br />
                <label> الوصف </label>
                <div class="form-group">
                  <textarea name="descriptions" id="descriptions2"  class="form-control" cols="30" rows="4">{{ Auth::guard('teachers')->user()->descriptions }} </textarea>
                    <span id="descriptions2_error" class="text-danger"></span>
                </div>
            </div>
            <br><br>
            <div class="col-md-12" style="margin-bottom: 2%;">
                <span> تلميح</span> <br>
               - <span>صورة البروفايل: مقاس الصورة المطلوبة هي (1000X1000) او بابعاد 1:1.</span> <br>
                -<span>  صورة الغلاف: مقاس الصورة المطلوبة هي (1280X720) او بابعاد 16:9.</span>

            </div>
           

            <div class="form-group">
                <label>الصورة الشخصية  </label>
             </div>
             <div class="media mb-2">
                 <img src="{{ Auth::guard('teachers')->user()->image }} " alt="users avatar" id="image2" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" /> 
                 <div class="media-body mt-50">
                     <div class="col-12 d-flex mt-1 px-0">
                         <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                             <span class="d-none d-sm-block">Change</span>
                                 <input class="form-control" type="file" multiple id="change-picture" name="image" hidden required accept="image/png, image/jpeg, image/jpg" />
                                 <span class="d-block d-sm-none">
                                 <i class="mr-0" data-feather="edit"></i>
                             </span>
                         </label>
                         <button class="btn btn-outline-secondary d-block d-sm-none">
                             <i class="mr-0" data-feather="trash-2"></i>
                         </button>
                     </div>
                 </div>
                 <span id="image2_error" class="text-danger"></span>
             </div>

            <div class="form-group">
                <label> صورة الغلاف  </label>
             </div>
             <div class="media mb-2">
                 <img src="{{ Auth::guard('teachers')->user()->image_cover }} " alt="users avatar" id="image24" class="user-avatar2 users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" /> 
                 <div class="media-body mt-50">
                     <div class="col-12 d-flex mt-1 px-0">
                         <label class="btn btn-primary mr-75 mb-0" for="change-picture2">
                             <span class="d-none d-sm-block">Change</span>
                                 <input class="form-control" type="file" multiple id="change-picture2" name="image_cover" hidden required accept="image/png, image/jpeg, image/jpg" />
                                 <span class="d-block d-sm-none">
                                 <i class="mr-0" data-feather="edit"></i>
                             </span>
                         </label>
                         <button class="btn btn-outline-secondary d-block d-sm-none">
                             <i class="mr-0" data-feather="trash-2"></i>
                         </button>
                     </div>
                 </div>
                 <span id="image24_error" class="text-danger"></span>
             </div>
            
        
    
        </div>
      
    </div>
    <div class="modal-footer" style="float: right">
        <button type="button" style="display: none;max-width: 107%;" id="editing2" class="btn btn-primary btn-block"> يتم التعديل ...</button>
        <button type="button" style="max-width: 107%;" id="editing" onclick="do_update()" class="btn btn-primary btn-block">حفظ التعديلات</button>
    </div>
</form>




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
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12"> 
                                <input type="hidden" name="id" id="id2">
                                <label>المدينة </label>
                                <div class="form-group">
                                    <input type="text" name="city" id="city2" class="form-control" />
                                    <span id="city2_error" class="text-danger"></span>
                                </div>
                            </div>
                            
                        
                    
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">حفظ التعديلات</button>
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
            ajax: "{{ route('teachers.get_all_cities') }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'city'         ,name: 'city'},

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
    var maxchars = 240;

    $('textarea').keyup(function () {
        var tlength = $(this).val().length;
        $(this).val($(this).val().substring(0, maxchars));
        var tlength = $(this).val().length;
        remain = maxchars - parseInt(tlength);
        $('#remain').text(remain);
    });
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
<script>
    $(function () {
        'use strict';
        var changePicture = $('#change-picture2'),
            userAvatar = $('.user-avatar2');
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
                    url: "{{route('teachers.store_cities')}}",
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
                    url: "{{route('teachers.update_settings_teacher')}}",
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
                url: "{{route('teachers.destroy_cities')}}",
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