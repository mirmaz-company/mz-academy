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
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_send()" id="position-top-start2"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_accept()" id="position-top-accept"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="decline()" id="position-top-decline"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="reset_login_click()" id="position-top-reset_login"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#">المستخدمين</a>
        </li>
    </ol>
</div>



@can("المستخدمين")
{{-- <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a>  --}}

<section id="basic-datatable">

    <div class="row match-height">
        <!-- Bar Chart -Orders -->
       
        <!--/ Line Chart -->
        <div class="col-lg-12 col-12">
            <div class="card card-statistics">
                <div class="card-header">
                    <h4 class="card-title">زيارات المستخدمين لتطبيق مرماز اليوم</h4>
                    <div class="d-flex align-items-center">
                        <p class="card-text me-25 mb-0"> تم تحديثه اليوم </p>
                    </div>
                </div>
                <div class="card-body statistics-body" style="background:white;border-radius: 6%">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-primary me-2">
                                    <div class="avatar-content">
                                        <i data-feather="activity" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <?php    $view_app = \App\Models\ViewApp::where('user_id','!=',0)->whereDate('created_at',now()->toDateString())->count(); ?>
                                  
                                    <h4 class="fw-bolder mb-0">{{ $view_app }}</h4>
                                    <p class="font-small-3 mb-0" style="color:green"> المسجلين دخول</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-12 mb-2 mb-md-0">
                            <div class="d-flex flex-row">
                                <div class="avatar bg-light-info me-2">
                                    <div class="avatar-content">
                                        <i data-feather="user" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="my-auto">
                                    <?php    $view_app = \App\Models\ViewApp::where('user_id',0)->whereDate('created_at',now()->toDateString())->count(); ?>
                                    <h4 class="fw-bolder mb-0">{{ $view_app }}</h4>
                                    <p class="card-text font-small-3 mb-0"> غير مسجلين دخول </p>
                                </div>
                            </div>
                        </div>
                   
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                        
                             <th>ID</th>
                             <th>الاسم</th>
                             <th>رقم الجوال</th>
                             @if($type == "active")
                               
                                 <th>الادمن صاحب عملية القبول او الرفض</th>
                             @endif
                             
                             @if($type == "decline")
                                  <th>الادمن صاحب عملية القبول او الرفض</th>
                             @endif
                          
                            <th> تاريخ الانشاء</th>
                            @if($type != "decline")
                                <th>العمليات</th>
                                @endif
                          
                          
                            
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
@endcan


{{-- modal add --}}
{{-- <div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6"> 
                                <input type="hidden" name="id" id="id">
                                <label>الاسم </label>
                                <div class="form-group">
                                    <input type="text" placeholder="name" name="name" id="name" class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div></div>
                            <div class="col-md-6">
                                <label>الايميل </label>
                                <div class="form-group">
                                    <input type="email" placeholder="email" name="email" id="email"  class="form-control" />
                                    <span id="email_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>نوع الاستثمار </label>
                                <div class="form-group">
                                    <select class="form-control" name="type" id="type">
                                        <option disabled selected> اختر </option>
                                        <option value="1"> حساب شخص</option>
                                        <option value="2">حساب شركة </option>
                                    </select>
                                    <span id="type_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label> طبيعة الحساب </label>
                                <div class="form-group">
                                    <select class="form-control" name="type_account" id="type_account">
                                        <option disabled selected> اختر</option>
                                        <option value="1"> وسيط عقاري</option>
                                        <option value="2">شركة عقارات </option>
                                        <option value="3">شركة مقاولات </option>
                                        <option value="4">مستثمر عقاري </option>
                                        <option value="5"> غير ذلك</option>
                                       
                                    </select>
                                    <span id="type_account_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>الجوال </label>
                                <div class="form-group">
                                    <input type="text" placeholder="mobile" name="mobile" id="mobile" class="form-control" />
                                    <span id="mobile_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>العنوان </label>
                                <div class="form-group">
                                    <input type="text" placeholder="address" name="address" id="address" class="form-control" />
                                    <span id="address_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>الهاتف </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الهاتف" name="phone" id="phone" class="form-control" />
                                    <span id="phone_error" class="text-danger"></span>
                                </div>
                            </div>
                    
                            <div class="col-md-6">
                                <label>كلمة السر </label>
                                <div class="form-group">
                                    <input type="password" placeholder="Password" name="password" id="password" class="form-control" />
                                    <span id="password_error" class="text-danger"></span>
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
</div> --}}


{{-- modal edit --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4"> 
                             
                            </div>
                            <div class="col-md-4" style="background: #b79b9b; padding: 2%;margin-bottom: 8%"> 
                                <img src="" alt="" id="imgg" class="img-fluid" style="width:102%;">
                            </div>
                            <div class="col-md-4"> 
                             
                            </div><br>
                            <div class="col-md-6"> 
                                <input type="hidden" name="id" id="id2">
                                <label>الاسم </label>
                                <div class="form-group">
                                    <input type="text" placeholder="name" name="name" id="name2" class="form-control" />
                                    <span id="name2_error" class="text-danger"></span>
                                </div>
                            </div>
                         
                         
                            <div class="col-md-6">
                                <label>الجوال </label>
                                <div class="form-group">
                                    <input type="text" placeholder="mobile" name="mobile" id="mobile2" class="form-control" />
                                    <span id="mobile2_error" class="text-danger"></span>
                                </div>
                            </div>
                      
                    
                            <div class="col-md-6">
                                <label>كلمة السر </label>
                                <div class="form-group">
                                    <input type="password" placeholder="Password" name="password" id="password2" class="form-control" />
                                    <span id="password2_error" class="text-danger"></span>
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



{{-- personal_photo --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="personal_photo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
</div>


{{-- front_image_id --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="front_image_id" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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


   {{-- reset login --}}
   <script>
    function reset_login(id){
        
            $("#show"+id).css("display", "none");
            $("#hide"+id).css("display", "block");

            $.ajax({
                type: 'post',
                url: "{{route('reset_login')}}",
                data:{
                    _token:'{{ csrf_token() }}',
                    id: id,
                },
                success: function (data) {
                   
                    $("#show"+id).css("display", "block");
                    $("#hide"+id).css("display", "none");
            
                    $('#position-top-reset_login').click();
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


{{-- delete user --}}
<div class="modal fade modal-danger text-left" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">حذف مستخدم </h5>
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

{{--  send notification to person --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm_not" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
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
                title: 'تمت الاضافة بنجاح ',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function msg_send(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم الارسال بنجاح ',
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
        function decline(){
  
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
        function reset_login_click(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تمت اعادة تعيين الجهاز',
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
          
             ajax: "{{ route('get_users_all','active') }}",
          
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
             
                {data: 'id'         ,name: 'id'},
                {data: 'name'         ,name: 'name'},
                {data: 'mobile'       ,name: 'mobile'},

                @if($type == "active")
                  
                    {data: 'person_who_approved'       ,name: 'person_who_approved'},
                @endif

                @if($type == "decline")
                {data: 'person_who_approved'       ,name: 'person_who_approved'},
                @endif
        

                {data: 'created_at'   ,name: 'created_at'},
                @if($type != "decline")
                {data: 'action'     ,  name: 'action'},
                @endif
                
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}


  
    {{-- open modal add user --}}
    <script>
        $('#modal_add').on('show.bs.modal', function(event) {
            $('#name').text('');
            $('#email').text('');
            $('#mobile').text('');
            $('#password').text('');
            $('#phone').text('');
            $('#address').text('');
        
   
            
        
        })
</script>


    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user', function (e) {
            $('#name_error').text('');
            $('#email_error').text('');
            $('#mobile_error').text('');
            $('#password_error').text('');
     
       
            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('store_users')}}",
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
        //    to hide error validation after open model edit
            $('#name2_error').text('')
            $('#email2_error').text('')
            $('#mobile2_error').text('')
            $('#password2_error').text('')
      
    
            var button = $(event.relatedTarget)
            var id =             button.data('id')
            var name =           button.data('name')
            var email =          button.data('email')
            var mobile =         button.data('mobile')
            var password =       button.data('password')
            var image =       button.data('image')
    
    
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #email2').val(email);
            modal.find('.modal-body #mobile2').val(mobile);
            modal.find('.modal-body #password2').val(password);
            $(".modal-body #imgg").attr('src', image);
 
        })
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



   {{-- update user --}}
   <script>
        function do_update(){
        
            $('#name2_error').text('')
            $('#email2_error').text('')
            $('#mobile2_error').text('')
            $('#password2_error').text('')
            
            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#edit_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('update_user')}}",
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
                url: "{{route('destroy_user')}}",
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
                        $('#position-top-start2').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                   
                  
                     }, error: function (reject) {
                     }
                 });
         }
    </script>



    {{-- show id in notification modal --}}
    <script>
        $('#inlineForm_not').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id =           button.data('id55')

            var modal = $(this)
            modal.find('.modal-body #idnot12').val(id);
    
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
                url: "{{route('add_accept_user')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_user23").css("display", "none");
                    $("#delete_user_button3").css("display", "block");
                    $('#position-top-accept').click();
                    $('.close').click();
                
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);

                
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
                    url: "{{route('decline')}}",
                    data:{
                        _token:'{{ csrf_token() }}',
                        id: id,
                    },
                    success: function (data) {
                        $("#show").css("display", "block");
                        $("#hide").css("display", "none");
                
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