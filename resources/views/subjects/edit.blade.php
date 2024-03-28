@extends('layouts.main_page')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">

  
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
   


@endsection


@section('content')


 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#">المواضيع </a>
        </li>
    </ol>
</div>




                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id" value="{{ $subject->id }}" id="">
                            <div class="col-md-6"> 
                             
                                <label>اسم المادة الدراسية </label>
                                <div class="form-group">
                                    <input type="text" value="{{ $subject->name }}"  name="name" id="name2" class="form-control" />
                                    <span id="name2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label> الاهتمامات </label>
                                <div class="form-group">
                                    <select class="select2 form-control" multiple="multiple"  name="topics[]" id="topics2">

                                  
                                        <?php $topics = \App\Models\Topic::all(); ?>

                                        @foreach($topics as $topic)
                                             <?php $topics = \App\Models\TopicSubject::where('subject_id',$subject->id)->where('topic_id',$topic->id)->first(); ?>
                                             @if($topics)
                                                  <option selected  value="{{ $topic->id }}">{{ $topic->name }}</option>
                                             @else
                                                  <option   value="{{ $topic->id }}">{{ $topic->name }}</option>
                                             @endif
                                        @endforeach
                                       
                                    </select>
                                    <span id="topics2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="study_id">اختر الدراسة</label>
                                    <select class="form-control" name="study_id" id="study_id">
                                        <?php $studys = \App\Models\Study::all(); ?>
                                            <option disabled>اختر الدراسة..</option>  
                                        @foreach($studys as $study)
                                            <option {{ $study->id == $subject->study_id ? "selected" : "" }} value="{{ $study->id }}">{{ $study->name }}</option>  
                                        @endforeach
                                    </select>
                                    <span id="study_id_error" class="text-danger"></span>
                                </div>
                            </div> 

                            <div class="spinner-border" role="status" id="loading_solutions" style="display: none">
                                <span class="sr-only">Loading...</span>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="level_id">اختر المرحلة</label>
                                    <select class="form-control" name="level_id" id="level_id2">
                                        <?php $level = \App\Models\Level::where('id',$subject->level_id)->first(); ?>
                                      <option value="{{ $level->id }}" selected>{{ $level->name }}</option>
                                    
                                    </select>
                                    <span id="level_id2_error" class="text-danger"></span>
                                </div>
                            </div> 


                            <div class="media mb-2">
                                <img src="{{ $subject->image }}" alt="users avatar" id="image2" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" /> 
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
                            
                        
                    
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                </form>





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
            ajax: "{{ route('get_all_subjects') }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'         ,name: 'name'},
                {data: 'image'         ,name: 'image'},

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


{{-- selected levels --}}
<script>
    $(document).ready(function() {
        $('select[name="study_id"]').on('change', function() {
        
            $("#loading_solutions").css("display", "block");
            $("#loading_solutions2").css("display", "block");

            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: "{{ URL::to('get_levels_in_form_add') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                           $("#loading_solutions").css("display", "none");
                           $("#loading_solutions2").css("display", "none");
                   

                            $('select[name="level_id"]').empty();
                            $('select[name="level_id"]').append('<option selected disabled selected>اختر المرحلة..</option>');
                            for (var i = 0; i < data.levels.length; i++){
                                    $('select[name="level_id"]').append('<option value="' +
                                    data.levels[i].id + '">' + data.levels[i].name+ '</option>');
                            }
                        
                        }
                    
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
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
                    url: "{{route('store_subjects')}}",
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
            var image =               button.data('image')
 
          
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            $(".modal-body #image2").attr('src', image);

  
        })
    </script>


   {{-- update user --}}
   <script>
        function do_update(){
        
            $('#name2_error').text('')
            

            
            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#edit_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('update_subjects')}}",
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
                url: "{{route('destroy_subjects')}}",
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