@extends('layouts.main_page')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">
   


@endsection


@section('content')


 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="status2()" id="position-top-status"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="status22()" id="position-top-status2"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#">سلايدر </a>
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
                            <th>النوع</th>
                            <th>العنوان</th>
                            <th>الوصف</th>
                            <th>المشاهدات</th>
                            <th>المرحلة</th>
                            <th>الرابط</th>
                            <th>ظهور/اخفاء لغير المسجل دخول</th>
                            {{-- <th>المنتج</th> --}}
                            <th style="width:100px">الصورة</th>
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
                    <h4 class="modal-title" id="myModalLabel33">اضافة سلايدر </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="form-group">
                               <label>صورة لسلايدر </label>
                            </div>
                            <div class="media mb-2">
                                <img src="{{ asset('upload.png') }}" alt="users avatar" id="image" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" /> 
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
                                <span id="image_error" class="text-danger"></span>
                            </div>
                       

                            <div class="col-md-12">
                                <label> نوع لسلايدر </label>
                                <div class="form-group">
                                    <select class="form-control form-control-lg" name="slider_type" id="m1">
                                        <option selected>اختر ---</option>
                                        <option value="1">خارجي</option>
                                        <option value="2">داخلي</option>
                                        
                                        <option value="4">فيديو</option>
                                        <option value="5">قسم</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12" style="display: none" id="b1">
                                <label> الرابط </label>
                                <div class="form-group">
                                    <input type="text" name="link" id="f1"  class="form-control form-control-lg">
                                </div>
                            </div>
                            
                            <div class="col-md-12" style="display: none" id="b2">
                                <label> العنوان </label>
                                <div class="form-group">
                                    <input type="text" name="title" id="f2" class="form-control form-control-lg">
                                </div>
                            </div>
                            <div class="col-md-12" style="display: none" id="b3">
                                <label> الوصف </label>
                                <div class="form-group">
                                    {{-- <input type="text" name="description" id="f3" class="form-control form-control-lg"> --}}
                                    <textarea name="description" class="form-control" id="f3" cols="30" rows="4"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12" style="display: none" id="b5">
                                <label> الاقسام </label>
                                <div class="form-group">
                                    <select class="form-control form-control-lg" name="section" id="m5">
                                        <option selected>اختر ---</option>
                                        <option value="discount_course">الدورات التي تحتوي على خصم</option>
                                        <option value="new_course">احدث الدورات</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>المراحل <span class="badge badge-danger">(بدون تحديد اي شئ.. سيظهر للجميع)</span></label>
                                <div class="form-group">
                                    <select class="select2 form-control" multiple="multiple"  name="level_id[]" id="default-select-multi2">
                                        <?php $levels = \App\Models\Level::get(); ?>
                                        @foreach($levels as $level)

                                                <?php $study =   \App\Models\Study::where('id',$level->study_id )->first(); ?>

                                                @if($study)
                                                    <option value="{{ $level->id }}">{{ $study->name }} - {{ $level->name }} </option>
                                                @else
                                                    <option value="{{ $level->id }}">{{ $level->name }} </option>
                                                @endif
                                           
                                        @endforeach
                                       
                                    </select>
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
                    <h4 class="modal-title" id="myModalLabel33">تعديل سلايدر </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id2">
                        <div class="row">
                            <div class="form-group">
                                <label>صورة لسلايدر </label>
                             </div>
                             <div class="media mb-2">
                                 <img src="{{ asset('upload.png') }}" alt="users avatar" id="image2" class="user-avatar2 users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" /> 
                                 <div class="media-body mt-50">
                                     <div class="col-12 d-flex mt-1 px-0">
                                         <label class="btn btn-primary mr-75 mb-0" for="change-picture2">
                                             <span class="d-none d-sm-block">Change</span>
                                                 <input class="form-control" type="file" multiple id="change-picture2" name="image" hidden required accept="image/png, image/jpeg, image/jpg" />
                                                 <span class="d-block d-sm-none">
                                                 <i class="mr-0" data-feather="edit"></i>
                                             </span>
                                         </label>
                                         <button class="btn btn-outline-secondary d-block d-sm-none">
                                             <i class="mr-0" data-feather="trash-2"></i>
                                         </button>
                                     </div>
                                 </div>
                                 <span id="image_error" class="text-danger"></span>
                             </div>
                        
 
                             <div class="col-md-12">
                                 <label> نوع لسلايدر </label>
                                 <div class="form-group">
                                     <select class="form-control form-control-lg" name="slider_type" id="type2">
                                         <option selected>اختر ---</option>
                                         <option value="1">خارجي</option>
                                         <option value="2">داخلي</option>
                                         <option value="4">فيديو</option>
                                         <option value="5">قسم</option>
                                     </select>
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <label> الرابط </label>
                                 <div class="form-group">
                                     <input type="text" name="link" id="url2"  class="form-control form-control-lg">
                                 </div>
                             </div>
                             
                             <div class="col-md-12">
                                 <label> العنوان </label>
                                 <div class="form-group">
                                     <input type="text" name="title" id="title2" class="form-control form-control-lg">
                                 </div>
                             </div>
                             <div class="col-md-12">
                                 <label> الوصف </label>
                                 <div class="form-group">
                                     {{-- <input type="text" name="description" id="description2" class="form-control form-control-lg"> --}}
                                     <textarea name="description" class="form-control" id="description2" cols="30" rows="4"></textarea>
                                 </div>
                             </div>
                             <div class="col-md-12" id="b52">
                                <label> الاقسام </label>
                                <div class="form-group">
                                    <select class="form-control form-control-lg" name="section" id="m52">
                                        <option selected>اختر ---</option>
                                        <option value="discount_course">الدورات التي تحتوي على خصم</option>
                                        <option value="new_course">احدث الدورات</option>
                                    </select>
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
                <h5 class="modal-title" id="myModalLabel120">حذف سلايدر </h5>
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

    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>

    <script src="{{asset('app-assets/js/scripts/forms/form-select2.js')}}"></script>

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
        function status2(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: ' سيتم ظهور السلايدر لغير المسجل دخول للتطبيق ',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function status22(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: ' سيتم اخفاء السلايدر لغير المسجل دخول للتطبيق ',
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


    <script>
        $(document).ready(function () {
        $('.select2').select2({
            closeOnSelect: false, // تمكين هذه الخاصية لمنع إغلاق القائمة بعد اختيار عنصر
            // المزيد من الإعدادات الخاصة بك هنا...
        });
    });
    </script>

     {{-- show information in yajradatatable --}}
     <script type="text/javascript">
    
        $(function () {
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_all_sliders') }}",
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'type'        ,name: 'type'},
                {data: 'title'       ,name: 'title'},
                {data: 'description' ,name: 'description'},
                {data: 'views' ,name: 'views'},
                {data: 'level_id'    ,name: 'level_id'},
                {data: 'url'         ,name: 'url'},
                {data: 'is_acess'    ,name: 'is_acess'},
                // {data: 'product_id'         ,name: 'product_id'},
                {data: 'image'         ,name: 'image'},

                {data: 'action'     ,   name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}


    <script>
        
        $(document).on('change','#cousome_switch', function (e) {
     
              
                let id = $(this).data('id');
        
                
                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: '{{ route('change_sliders') }}',
            
                    data: {  
                            '_token':'{{ csrf_token() }}',
                            'id':id,
                            
                        },
                    success: function (data) {
                       
                        if(data.is_acess == 1){
                            $('#position-top-status').click();
                        }else{
                            $('#position-top-status2').click();
                        }
                       
                    }
                });
        });
    
    </script>



    <script>
      $(document).ready(function(){
	
	    $("#m1").change(function(){
      
            if ( $(this).val() == "1" ) { 
                $("#b1").css("display", "block");
                $("#b2").css("display", "none");
                $("#b3").css("display", "none");
                $("#b4").css("display", "none");
                $("#b5").css("display", "none");

                $('.modal-body #f1').val('')
                $('.modal-body #f2').val('')
                $('.modal-body #f3').val('')
                $('.modal-body #m5').val('')
               
            }
            if ( $(this).val() == "2" ) { 
                $("#b2").css("display", "block");
                $("#b3").css("display", "block");
                $("#b1").css("display", "none");
                $("#b4").css("display", "none");
                $("#b5").css("display", "none");

                $('.modal-body #f1').val('')
                $('.modal-body #f2').val('')
                $('.modal-body #f3').val('')
                $('.modal-body #m5').val('')
               
            }
            if ( $(this).val() == "4" ) { 
                $("#b1").css("display", "block");
                $("#b2").css("display", "block");
                $("#b3").css("display", "block");
                $("#b4").css("display", "block");
                $("#b5").css("display", "none");

                $('.modal-body #f1').val('')
                $('.modal-body #f2').val('')
                $('.modal-body #f3').val('')
                $('.modal-body #m5').val('')
               
            }
            if ( $(this).val() == "5" ) { 
                $("#b1").css("display", "none");
                $("#b2").css("display", "none");
                $("#b3").css("display", "none");
                $("#b4").css("display", "none");
                $("#b5").css("display", "block");

                $('.modal-body #f1').val('')
                $('.modal-body #f2').val('')
                $('.modal-body #f3').val('')
                $('.modal-body #m5').val('')
               
            }
 
    
    }); 
	
});
    </script>
  
    {{-- open modal add user --}}
    {{-- <script>
        $('#modal_add').on('show.bs.modal', function(event) {
    
        
        })
   </script> --}}

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
   
  
            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('store_sliders')}}",
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
            
            var id =                 button.data('id')
            var title =              button.data('title')
            var description =        button.data('description')
            var type =               button.data('type')
            var url =                button.data('url')
            var product_id =         button.data('product_id')
            var image =              button.data('image')
            
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #title2').val(title);
            modal.find('.modal-body #description2').val(description);
            modal.find('.modal-body #type2').val(type);
            modal.find('.modal-body #url2').val(url);
            modal.find('.modal-body #product_id2').val(product_id);
            $(".modal-body #image2").attr('src', image);
      
  
        })
    </script>


   {{-- update user --}}
   <script>
        function do_update(){
        
            // $('#title2_error').text('')
            // $('#body2_error').text('')

            
            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#edit_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('update_sliders')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing").css("display", "block");
                        $("#editing2").css("display", "none");
                
                        $('.close').click();
                        $('#change-picture2').val('');
                    
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
                url: "{{route('destroy_sliders')}}",
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