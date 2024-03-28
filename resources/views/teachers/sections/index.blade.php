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



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        @if(isset($id))
            <?php $sections = \App\Models\Course::where('id',$id)->first(); ?>
            @if($sections)
                <li class="breadcrumb-item"><a href="#">الفصول .____. {{ $sections->name }} </a>
                </li>
            @endif
        @else
            <li class="breadcrumb-item"><a href="#">الفصول </a>
            </li>
        @endif
    </ol>
</div>


@can("اضافة فصل")
    <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a> 
@endcan


<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                            <th>اسم الفصل</th>
                            <th>اسم الدورة</th>
                            @if(auth()->check() && auth()->user()->id == 169)
                                <th>عدد الساعات</th>
                            @endif
                            <th> الدروس</th>
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
                                <label>الاسم  </label>
                                <div class="form-group">
                                    <input type="name" name="name" id="name"  class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>
                   

                            @if(isset($id))

                            <input type="hidden" name="course_id" value="{{ $id }}" id="course_id">

                            @else
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">اختر الدورة</label>
                                        <select class="form-control" name="course_id" id="course_id">
                                            <?php $levels = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->orWhere('teacher_id',Auth::guard('teachers')->user()->parent)->get(); ?>
                                                <option selected disabled>اختر الدورة..</option>  
                                            @foreach($levels as $level)
                                                <option value="{{ $level->id }}">{{ $level->name }}</option>  
                                                @endforeach
                                            </select>
                                            <span id="course_id_error" class="text-danger"></span>
                                    </div>
                                </div>
                            @endif

                           
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
                            <input type="hidden" name="id" id="id2">
                            <div class="col-md-12">
                                <label>الاسم  </label>
                                <div class="form-group">
                                    <input type="name" name="name" id="name2"  class="form-control" />
                                    <span id="name2_error" class="text-danger"></span>
                                </div>
                            </div>
                   

                            @if(isset($id))

                            <input type="hidden" name="course_id" id="course_id_hidden">

                            @else
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">اختر الدورة</label>
                                        <select class="form-control" name="course_id" id="course_id_visable">
                                            <?php $levels = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->orWhere('teacher_id',Auth::guard('teachers')->user()->parent)->get(); ?>
                                                <option selected disabled>اختر الدورة..</option>  
                                            @foreach($levels as $level)
                                                <option value="{{ $level->id }}">{{ $level->name }}</option>  
                                                @endforeach
                                            </select>
                                            <span id="course_id_error" class="text-danger"></span>
                                    </div>
                                </div>
                            @endif

                           
                       
                            
                        
                    
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


{{-- add_section_to_course --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="add_section_to_course" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة هذا الفصل الى دورة اخرى  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_section_to_course_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="id" id="id23">
                

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">اختر الدورة</label>
                                    <select class="form-control" name="course_id" id="course_id_visable">
                                        <?php $levels = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->get(); ?>
                                            <option selected disabled>اختر الدورة..</option>  
                                        @foreach($levels as $level)
                                            <option value="{{ $level->id }}">{{ $level->name }}</option>  
                                            @endforeach
                                        </select>
                                        <span id="course_id_error" class="text-danger"></span>
                                </div>
                            </div>
                     

                    
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing23" class="btn btn-primary btn-block">  تتم الاضافة ...</button>
                        <button type="button" id="editing3" onclick="add_section_to_course_button()" class="btn btn-primary btn-block">اضافة</button>
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
            @if(isset($id))
               ajax: "{{ route('teachers.get_all_sections',$id) }}",
            @else
               ajax: "{{ route('teachers.get_all_sections') }}",
            @endif
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'         ,name: 'name'},
                {data: 'name_course'         ,name: 'name_course'},
                @if(auth()->check() && auth()->user()->id == 169)
     {data: 'section_hours'         ,name: 'section_hours'},
@endif
               
                
                {data: 'count_lessons'         ,name: 'count_lessons'},

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
                    url: "{{route('teachers.store_sections')}}",
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
            var name =                button.data('name')
            var course_id =           button.data('course_id')
            
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #course_id_hidden').val(course_id);
            modal.find('.modal-body #course_id_visable').val(course_id);
      
  
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
                    url: "{{route('teachers.update_sections')}}",
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



    {{-- show add_section_to_course_button  --}}
    <script>
        $('#add_section_to_course').on('show.bs.modal', function(event) {
        
            var button = $(event.relatedTarget)
            var id =                  button.data('id')
    
            
            
            var modal = $(this)
            modal.find('.modal-body #id23').val(id);

      
  
        })
    </script>


   {{-- update add_section_to_course_button --}}
   <script>
        function add_section_to_course_button(){
        
            // $('#title2_error').text('')
            // $('#body2_error').text('')

            
            $("#editing3").css("display", "none");
            $("#editing23").css("display", "block");

            var formData = new FormData($('#add_section_to_course_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.add_section_to_course')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing3").css("display", "block");
                        $("#editing23").css("display", "none");
                
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
                url: "{{route('teachers.destroy_sections')}}",
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