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
        <li class="breadcrumb-item"><a href="#">الكوبونات </a>
        </li>
    </ol>
</div>



<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a>
<a class="btn btn-primary" href="{{ route('coupon_used') }}" style="margin-bottom:1%">الاكواد المستخدمة</a>

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>النسبة</th>
                            <th>  العدد الكلي</th>
                            <th>الاكواد المستخدمة</th>
                            <th> الاكوادالمتبقية</th>
                            <th> عدد مرات استخدام كل كوبون</th>
                            <th> تاريخ البداية</th>
                            <th> تاريخ النهاية</th>
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
                    <h4 class="modal-title" id="myModalLabel33">اضافة كوبونات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">


                            <div class="col-md-6">
                                <label>نسبة الخصم</label>
                                <div class="form-group">
                                    <input type="text" placeholder="discount" name="discount" id="discount"  class="form-control" />
                                    <span id="discount_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label> عدد الكوبونات</label>
                                <div class="form-group">
                                    <input type="text" placeholder="العدد" name="number" id="number"  class="form-control" />
                                    <span id="number_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> عدد مرات استخدام كل كوبون</label>
                                <div class="form-group">
                                    <input type="text" placeholder="عدد مرات استخدام كل كوبون" name="count_use_coupon" id="count_use_coupon" value="1"  class="form-control" />
                                    <span id="count_use_coupon_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> النوع  </label>
                                <div class="form-group">
                                    <select class="form-control form-control-lg" name="type" id="m1">
                                        <option value="1">نسبة مئوية</option>
                                        <option value="2">ثابت</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label> تاريخ البداية   </label>
                                <div class="form-group">
                                    <input type="date" name="date_start" id="date_start" value="0"  class="form-control" />
                                    <span id="date_start_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> تاريخ النهاية   </label>
                                <div class="form-group">
                                    <input type="date" name="date_end" id="date_end" value="0"  class="form-control" />
                                    <span id="date_end_error" class="text-danger"></span>
                                </div>
                            </div>


                        </div>





                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">يتم الانشاء ...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">انشاء اكواد</button>
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
                    <h4 class="modal-title" id="myModalLabel33">تعديل كوبون </h4>
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
                                <label>نسبة الخصم </label>
                                <div class="form-group">
                                    <input type="text" placeholder="نسبة الخصم" name="discount" id="discount2" class="form-control" />
                                    <span id="discount2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> النوع  </label>
                                <div class="form-group">
                                    <select class="form-control form-control-lg" name="type" id="m12">
                                        <option value="0"> -------</option>
                                        <option value="1">نسبة مئوية</option>
                                        <option value="2">ثابت</option>
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
                <h5 class="modal-title" id="myModalLabel120">حذف كوبون </h5>
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

{{-- show coupon --}}
<div class="modal fade modal-danger text-left" id="show_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">عرض كوبون </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


              <p id="show_coopns" style="text-align: center"></p>

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
                title: 'تم الانشاء بنجاح ',
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
            ajax: "{{ route('get_all_coupon') }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'discount'         ,name: 'discount'},
                {data: 'number'           ,name: 'number'},
                {data: 'codes_is_used'           ,name: 'codes_is_used'},
                {      data: 'rest'},
                {data: 'number_of_use_coupon'           ,name: 'number_of_use_coupon'},
                {data: 'date_start'           ,name: 'date_start'},
                {data: 'date_end'           ,name: 'date_end'},


                {data: 'action'     ,      name: 'action'},
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



<script>
     function removeedisable(){
        $("#date_start").prop('disabled', false);
        $("#date_end").prop('disabled', false);
    }
</script>
<script>
     function removeedisable2(){
        $("#date_start").prop('disabled', true);
        $("#date_end").prop('disabled', true);
    }
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
                    url: "{{route('store_coupon')}}",
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
            var number =                button.data('number')
            var discount =                button.data('discount')


            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #number2').val(number);
            modal.find('.modal-body #discount2').val(discount);


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
                    url: "{{route('update_coupon')}}",
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


    <script>
        $('#show_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var show_coopns     =  button.data('showw')
            var modal = $(this)
            document.getElementById("show_coopns").innerHTML = show_coopns;
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
                url: "{{route('destroy_coupon')}}",
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