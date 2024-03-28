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

        <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
        <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
        <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 



        <div class="breadcrumb-wrapper">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
                </li>
                <?php $teacher = \App\Models\Teacher::where('id',$teacher_id)->where('parent',0)->first(); ?>


                @if($teacher)
                    <li class="breadcrumb-item"><a href="#"> الحسابات المالية ( {{ $teacher->name }} )</a>
                    </li>
                @else
                    <li class="breadcrumb-item"><a href="#"> الحسابات المالية </a>
                    </li>
                @endif
            </ol>
        </div>

        
      
        <div style="display: flex;justify-content:space-between;align-items:center ;margin-top:3%">
            <div>
                @if($teacher)
                    <h2 style="color:black"> الحركات المالية  ( {{ $teacher->name }} )</h2>
                @else
                     <h2 style="color:black"> الحركات المالية </span>
                @endif
            </div>
            <div>
                <a class="btn btn-success" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">ايداع</a> 
                <a class="btn btn-danger" data-toggle="modal" href="#inlineForm2" style="margin-bottom:1%">سحب</a> 
                <a class="btn btn-primary" data-toggle="modal" href="#inlineForm3" style="margin-bottom:1%">كشف حساب</a> 
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
                                            <th> التاريخ</th>
                                            <th> العنوان</th>
                                            <th> المبلغ</th>
                                            <th> الحالة</th>
                                            <th> الملاحظات</th>
                                            {{-- <th> العمليات</th> --}}
                                      
                                            
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


    {{-- modal add --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"> ايداع جديد</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                       

                            <input type="hidden" name="teacher_id" value="{{ $teacher_id }}">
                            <div class="col-md-12">
                                <label> العنوان </label>
                                <div class="form-group">
                                    <input type="text" placeholder="" name="title" id="title"  class="form-control" />
                                    <span id="title_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> المبلغ </label>
                                <div class="form-group">
                                    <input type="number" placeholder="" name="money" id="money"  class="form-control" />
                                    <span id="money_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> ملاحظة </label>
                                <div class="form-group">
                                    <textarea name="notes" class="form-control" id="notes" cols="4" rows="4"></textarea>
                                    <span id="notes_error" class="text-danger"></span>
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



<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"> سحب جديد</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="withdraw_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                       

                            <input type="hidden" name="teacher_id" value="{{ $teacher_id }}">
                            <div class="col-md-12">
                                <label> العنوان </label>
                                <div class="form-group">
                                    <input type="text" placeholder="" name="title" id="title"  class="form-control" />
                                    <span id="title_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> المبلغ </label>
                                <div class="form-group">
                                    <input type="number" placeholder="" name="money" id="money"  class="form-control" />
                                    <span id="money_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> ملاحظة </label>
                                <div class="form-group">
                                    <textarea name="notes" class="form-control" id="notes" cols="4" rows="4"></textarea>
                                    <span id="notes_error" class="text-danger"></span>
                                </div>
                            </div>

                           
                        </div>
                        
                    
                
                    
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user23" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_user3" class="btn btn-primary btn-block">اضافة</button>
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
                    <h4 class="modal-title" id="myModalLabel33">تعديل النسبة </h4>
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
                                <label>   النسبة</label>
                                <div class="form-group">
                                    <input type="text" placeholder="" name="ratio" id="ratio2"  class="form-control" />
                                    <span id="ratio2_error" class="text-danger"></span>
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
                <h5 class="modal-title" id="myModalLabel120">حذف لغة </h5>
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
            ajax: "{{ route('get_all_wallet_teacher',$teacher_id) }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'created_at', name: 'created_at'},
                {data: 'title', name: 'title'},
                {data: 'money', name: 'money'},
                {data: 'status', name: 'status'},
                {data: 'notes', name: 'notes'},
                // {data: 'action', name: 'action'},
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
                url: "{{route('store_deposet')}}",
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
                        $('#add_user_form')[0].reset();
             
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


<script>
    $(document).on('click', '#add_user3', function (e) {
        // $('#name_error').text('');

   
        $("#add_user23").css("display", "block");
        $("#add_user3").css("display", "none");
        var formData = new FormData($('#withdraw_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('store_withdraw')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        $("#add_user23").css("display", "none");
                        $("#add_user3").css("display", "block");
                        $('.close').click();
                        $('#withdraw_form')[0].reset();
                        $('#position-top-start').click();
             
                },
                error: function (reject) {
                    $("#add_user23").css("display", "none");
                    $("#add_user3").css("display", "block");
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
        var ratio =                button.data('ratio')
        
        
        var modal = $(this)
        modal.find('.modal-body #id2').val(id);
        modal.find('.modal-body #ratio2').val(ratio);
  

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
                url: "{{route('update_ratio')}}",
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