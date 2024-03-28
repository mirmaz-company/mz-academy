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
        <li class="breadcrumb-item"><a href="#">الاشعارات </a>
        </li>
    </ol>
</div>



<a class="btn btn-primary" data-toggle="modal" href="#inlineForm_for_all" style="margin-bottom:1%">ارسال اشعار للجميع</a> 

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                            <th>ID</th>
                            <th>الاسم</th>
                            <th>العنوان</th>
                            <th>الوصف</th>
                            <th>ارسال اشعار لشخص معين</th>
                            <th>التاريخ</th>
                          
                            
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


{{--  send notification for all --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm_for_all" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">ارسال اشعار للجميع </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="notification_form_for_all">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-12">
                                <label> العنوان </label>
                                <div class="form-group">
                                    <input class="form-control" name="title" id="title" value=""  type="text">
                                    <span id="title_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف </label>
                                <div class="form-group">
                                    <textarea style="width: 100%" name="body" id="body" cols="60" rows="5"></textarea>
                                    <span id="body_error" class="text-danger"></span>
                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" id="reload661"  style="display:none" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            يتم الارسال...
                        </button>
                        <button type="button"  id="update_users1" onclick="do_update_for_all()" class="btn btn-primary">ارسال</button>
                        <button type="button" id='edit_users_button31' class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{--  send notification to person --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">ارسال اشعار</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="notification_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="sendnotifi" id='idnot12'>

                            <div class="col-md-12">
                                <label> العنوان </label>
                                <div class="form-group">
                                    <input class="form-control" name="title" value=""  type="text">
                                    <span id="notification2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> الوصف </label>
                                <div class="form-group">
                                    <textarea style="width: 100%" name="body" id="notification1" cols="60" rows="5"></textarea>
                                    <span id="notification2_error" class="text-danger"></span>
                                </div>
                            </div>

                           
                        </div>
                        
                    
                
                    
                      
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" id="reload6611"  style="display:none" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            يتم الارسال...
                        </button>
                        <button type="button"  id="update_users11" onclick="do_update1()" class="btn btn-primary">ارسال</button>
                        <button type="button" id='edit_users_button311' class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
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
                title: 'تم ارسال الاشعار بنجاح',
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
            ajax: "{{ route('get_all_notifications') }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'user_id'         ,name: 'user_id'},
                {data: 'name'},
                {data: 'title'         ,name: 'title'},
                {data: 'body'          ,name: 'body'},
                {data: 'send_to_person'},

                {data: 'created_at'     ,   name: 'created_at'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}







     {{-- Send Notification --}}
     <script>
        function do_update1(){
   
             $("#update_users11").css("display", "none");
             $("#reload6611").css("display", "block");
             var formData = new FormData($('#notification_form')[0]);
                 $.ajax({
                     type: 'post',
                     enctype: 'multipart/form-data',
                     url: "{{route('send_notification_to_person')}}",
                     data: formData,
                     processData: false,
                     contentType: false,
                     cache: false,
                     success: function (data) {
                         $("#reload6611").css("display", "none");
                         $("#update_users11").css("display", "block");
                  
                        $('.close').click();
                        $('#position-top-start').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                   
                  
                     }, error: function (reject) {
                     }
                 });
         }
    </script>



    {{-- show id in notification modal --}}
    <script>
        $('#inlineForm').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id =           button.data('id55')

            var modal = $(this)
            modal.find('.modal-body #idnot12').val(id);
    
        })
    </script>


     {{-- Send Notification for all --}}
     <script>
        function do_update_for_all(){
   
             $("#update_users1").css("display", "none");
             $("#reload661").css("display", "block");
             var formData = new FormData($('#notification_form_for_all')[0]);
                 $.ajax({
                     type: 'post',
                     enctype: 'multipart/form-data',
                     url: "{{route('send_notification_to_all')}}",
                     data: formData,
                     processData: false,
                     contentType: false,
                     cache: false,
                     success: function (data) {
                         $("#reload661").css("display", "none");
                         $("#update_users1").css("display", "block");
                  
                        $('.close').click();
                        $('#position-top-start').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                   
                  
                     }, error: function (reject) {
                     }
                 });
         }
    </script>


@endsection