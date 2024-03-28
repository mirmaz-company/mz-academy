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

@can('بحث عن اكواد')


 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 
<button class="btn btn-outline-primary" style="display: none" onclick="start_error2()" id="position-top-start_error"></button> 
<button class="btn btn-outline-primary" style="display: none" onclick="start_error22()" id="position-top-add_money"></button> 
<button class="btn btn-outline-primary" style="display: none" onclick="start_error222()" id="position-top-add_money2"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#"> اضافة طالب لدورة   </a>
        </li>
    </ol>
</div>

<br><br>
<h1> البحث عن طريق ال ID    </h1>
<div class="row">
    <div class="col-md-8">
        <form id="add_user_form">
            @csrf
            <div class="modal-body">
        
                <div class="row">
               
                    <div class="col-md-4">
                        <div class="form-group">
                            <input type="text" name="code" placeholder="بحث عن طريق ال ID" id="code"  class="form-control" />
                            <span id="code_error" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="modal-footer" style="margin-top: -18px;">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">جاري البحث  ...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">بحث</button>
                    </div>
                </div>
                
            </div>
        
        </form>
    </div>
    <div class="col-md-4" id="profile-card">
   
            <div class="card card-profile">
  
              <div class="card-body">
                <div class="profile-image-wrapper">
                  <div class="profile-image">
                    <div class="avatar">
                      <img id="image_card" src="https://mz-academy.com/Artboard%201@4x-8.png" alt="Profile Picture" />
                    </div>
                  </div>
                </div>
                <h3 id="full_name">-</h3>
                <h6 id="mobile_card">-</h6>
                <div class="badge badge-light-primary profile-badge" id="name_card">-</div>
                <hr class="mb-2" />
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h6 class="text-muted font-weight-bolder">المحفظة</h6>
                    <h6 class="mb-0" id="wallet_card">-</h6>
                  </div>
                  <div>
                    <h6 class="text-muted font-weight-bolder">الادمن الذي قبل التوثيق</h6>
                    <h6 class="mb-0" id="admin_card">-</h6>
                  </div>
                  <div>
                    <h6 class="text-muted font-weight-bolder">عدد مرات اعادة التعيين</h6>
                    <h6 class="mb-0" id="reset_count">-</h6>
                  </div>
                </div>
              </div>
          
          </div>
    </div>
</div>

<div style="display: flex">
    <div style="display:none;margin-left:1%" id="add_to_course_id"> 
        <a class="btn btn-primary" data-toggle="modal"  href="#inlineForm" style="margin-bottom:1%;max-width: 100%;">اضافة الطالب لدورة</a> <br>
     
    </div>
    <div style="display:none;margin-left: 1%;" id="add_money">
        <a class="btn btn-primary" data-toggle="modal"  href="#add_money_modal" style="margin-bottom:1%;max-width: 100%;"> اضافة رصيد</a> <br>
     
    </div>
    <div style="display:none" id="add_money23">
        <a class="btn btn-primary" data-toggle="modal"  href="#decrease_money_modal" style="margin-bottom:1%;max-width: 100%;"> سحب رصيد</a> <br>
     
    </div>
</div>
<span id="name_sub" style="font-size: 20px;"></span>


<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                            <th>الدورة</th>
                            <th>المعلم</th>
                            <th>ملاحظة</th>
                            <th>تاريخ الاشتراك</th>
                            <th> العمليات</th>
                          
                            
                        </tr>
                    </thead>

                    <tbody>
                 
                    </tbody>

                </table>

            </div>
        </div>
    </div>
    <!-- Modal to add new record -->

</section>  <br><br><br><br>





{{-- add to course  --}}

<div class="form-modal-ex">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">  اضافة الطالب لدورة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_to_course_form">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id_add">
                    <div class="col-md-12">
                        <label>الدورات</label>
                        <div class="form-group">
                            <select class="select2 form-control" multiple="multiple"  name="course_id[]" id="default-select-multi2">
                                <?php $courses = \App\Models\Course::get(); ?>
                                @foreach($courses as $course)
                                        <?php $teacher = \App\Models\Teacher::where('id',$course->teacher_id)->first(); ?>
                                        @if($teacher)
                                            <option value="{{ $course->id }}">{{ $course->name }} ({{ $teacher->name }})</option>
                                        @endif
                                   
                                @endforeach
                               
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="">اضافة ملاحظة (اختياري)</label>
                        <textarea name="notes" class="form-control" id="" placeholder="تمت الاضافة عن طريق المنصة" cols="4" rows="5"></textarea>
                    </div>
             
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing24" class="btn btn-primary btn-block">جاري  الاضافة ... </button>
                        <button type="button" id="editing4" onclick="add_to_course()" class="btn btn-primary btn-block">  اضافة  </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="form-modal-ex">
    <div class="modal fade text-left" id="add_money_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">  اضافة رصيد بالمحفظة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_money_form">
                    @csrf

                    <input type="hidden" name="user_id" id="user_id_money">

                    <div class="col-md-12" style="padding:3%">
                        <label> اضافة رصيد </label>
                        <input type="number" class="form-control" name="money" id="money_id2">
                    </div>
                    <div class="col-md-12" style="padding:3%">
                        <label>  ملاحظة </label>
                        <textarea class="form-control" name="notes" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>

                   
                  
             
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user23" class="btn btn-primary btn-block">جاري  الاضافة ... </button>
                        <button type="button" id="add_user3" onclick="add_to_money()" class="btn btn-primary btn-block">  اضافة رصيد  </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="form-modal-ex">
    <div class="modal fade text-left" id="decrease_money_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">  اضافة رصيد بالمحفظة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="decrease_money_form">
                    @csrf

                    <input type="hidden" name="user_id" id="user_id_money2">

                    <div class="col-md-12" style="padding:3%">
                        <label> سحب رصيد </label>
                        <input type="number" class="form-control" name="money" id="money_id22">
                    </div>
                    <div class="col-md-12" style="padding:3%">
                        <label>  ملاحظة </label>
                        <textarea class="form-control" name="notes" id="exampleFormControlTextarea1" rows="3"></textarea>
                    </div>

                   
                  
             
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user232" class="btn btn-primary btn-block">جاري  السحب ... </button>
                        <button type="button" id="add_user32" onclick="add_to_money2()" class="btn btn-primary btn-block">  سحب رصيد  </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">منصة مرماز أكاديمي </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="modal-body">
                        <div class="row">
                            <label for="">  هل انت متاكد من الغاء الاشتراك؟</label>
                            <input type="hidden" name="id" id="course_id">
                         
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-danger btn-block">جاري الغاء الاشتراك ... </button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-danger btn-block"> الغاء الاشتراك  </button>
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


@endcan


 @endsection


@section('js')


    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/forms/form-select2.js')}}"></script>
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
                title: 'تم الغاء الاشتراك بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }

        function start_error2(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: 'يوجد خطا ما',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });

        }
        function start_error22(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تمت الاضافة بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });

        }
        function start_error222(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم السحب بنجاح',
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
        $(document).on('click', '#add_user', function (e) {

            

            var user_id = $('#code').val(); // Get the value from the input field
            $('#user_id_add').val(user_id);
    
            $(function () {
            var table = $('.yajra-datatable').DataTable({
                processing: true,
                serverSide: true,
                searching: false,    // Disables searching
                destroy: true,
                ajax: "{{ route('get_all_search_courses', ['user_id' => '']) }}/" + user_id, // Pass the code value to the route as the 'id' parameter
                columns: [
                    {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'course_id'         ,name: 'course_id'},
                    {data: 'teacher_id'         ,name: 'teacher_id'},
                    {data: 'notes'         ,name: 'notes'},
                    {data: 'created_at'         ,name: 'created_at'},
                    {data: 'action'         ,name: 'action'},
                ],
                "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
              });

            });


            var csrfToken = "{{ csrf_token() }}";

            $.ajax({
                type: 'post',
                url: "{{route('get_user_info')}}",
                data: {
                    _token: csrfToken,
                    user_id: user_id
                },
                success: function (data) {
                    if(data.user == null){
                        $('#add_to_course_id').css('display','none');

                        $('#name_card').text('-');
                        $('#mobile_card').text('-');
                        $('#wallet_card').text('-');
                        $('#full_name').text('-');
                        $('#reset_count').text('-');
                        $('#admin_card').text('-');
                        $("#image_card").attr('src', 'https://mz-academy.com/Artboard%201@4x-8.png');
                    }else{
                        $('#add_to_course_id').css('display','block');
                        $('#add_money').css('display','block');
                        $('#add_money23').css('display','block');
                        $('#name_card').text(data.user.name);
                        $('#name_sub').text(' الدورات المشترك بها ('+data.user.name+') ('+data.user.id+')' );
                        $('#user_id_money').val(data.user.id);
                        $('#user_id_money2').val(data.user.id);
                        $('#mobile_card').text(data.user.mobile);
                        $('#wallet_card').text(data.user.my_wallet);
                        $('#money_id').val(data.user.my_wallet);
                        $('#reset_count').text(data.user.reset_count);
                        $("#image_card").attr('src', data.user.image);
                        if(data.admin_card == null){
                            $('#admin_card').text('لم يوثق بعد');
                        }else{

                            $('#admin_card').text(data.admin_card);
                        }
                        $('#full_name').text('(' + data.user.id+' ) ' + data.full_name);
                    }
                
                   
                   
                },
                error: function (reject) {
                    // Handle error
                }
            });
        });
    </script>

    <script>
        function reloadData() {
            // قم بجلب البيانات الجديدة هنا (استدعاء API أو أي عملية أخرى)
            // عندما تحصل على البيانات الجديدة وتحتاج إلى تحديث الديف:
            
            // استهدف الديف باستخدام معرفه
            var profileCard = document.getElementById('profile-card');

            // قم بتحديث محتوى الديف هنا
            // مثال: profileCard.innerHTML = 'المحتوى الجديد';

            // بعد تحديث المحتوى، قم بإعادة تحميل الديف
            location.reload(true);
            }

    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}


     {{-- show information in yajradatatable --}}
     <script type="text/javascript">
        $(document).on('click', '#add_user3', function (e) {


            var code = $('#code2').val(); // Get the value from the input field
    
            $(function () {
            var table = $('.yajra-datatable2').DataTable({
                processing: true,
                serverSide: true,
                searching: false,    // Disables searching
                destroy: true,
                ajax: "{{ route('get_all_search_codes2', ['code' => '']) }}/" + code, // Pass the code value to the route as the 'id' parameter
                columns: [
                    {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                    {data: 'code'         ,name: 'code'},
                    {data: 'user_id'         ,name: 'user_id'},
                    // {data: 'teacher_id'         ,name: 'teacher_id'},
                    // {data: 'course_id'         ,name: 'course_id'},
                ],
                "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
              });

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
   
        function add_to_money(){
            // $('#name_error').text('');
   
       
            $("#add_user23").css("display", "block");
            $("#add_user3").css("display", "none");
            var formData = new FormData($('#add_money_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('add_money_route')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        
                           
                            $("#add_user23").css("display", "none");
                            $("#add_user3").css("display", "block");
                            $('.close').click();

                            $('#position-top-add_money').click();

                            var user_id = $('#code').val(); // Get the value from the input field
                            var csrfToken = "{{ csrf_token() }}";
                            
                            $.ajax({
                            type: 'post',
                            url: "{{route('get_user_info')}}",
                            data: {
                                _token: csrfToken,
                                user_id: user_id
                            },
                            success: function (data) {
                                if(data.user == null){
                                    $('#add_to_course_id').css('display','none');

                                    $('#name_card').text('-');
                                    $('#mobile_card').text('-');
                                    $('#wallet_card').text('-');
                                    $('#full_name').text('-');
                                    $('#reset_count').text('-');
                                    $('#admin_card').text('-');
                                    $("#image_card").attr('src', 'https://mz-academy.com/Artboard%201@4x-8.png');
                                }else{
                                    $('#add_to_course_id').css('display','block');
                                    $('#add_money').css('display','block');
                                    $('#add_money23').css('display','block');
                                    $('#name_card').text(data.user.name);
                                    $('#name_sub').text(' الدورات المشترك بها ('+data.user.name+') ('+data.user.id+')' );
                                    $('#user_id_money').val(data.user.id);
                                    $('#user_id_money2').val(data.user.id);
                                    $('#mobile_card').text(data.user.mobile);
                                    $('#wallet_card').text(data.user.my_wallet);
                                    $('#money_id').val(data.user.my_wallet);
                                    $('#reset_count').text(data.user.reset_count);
                                    $("#image_card").attr('src', data.user.image);
                                    if(data.admin_card == null){
                                        $('#admin_card').text('لم يوثق بعد');
                                    }else{

                                        $('#admin_card').text(data.admin_card);
                                    }
                                    $('#full_name').text('(' + data.user.id+' ) ' + data.full_name);
                                }
                            
                            
                            
                            },
                            error: function (reject) {
                                // Handle error
                            }
                        });
                         
                 
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
            }
    </script>



    {{-- add user --}}
    <script>
   
        function add_to_money2(){
            // $('#name_error').text('');
   
       
            $("#add_user232").css("display", "block");
            $("#add_user32").css("display", "none");
            var formData = new FormData($('#decrease_money_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('decrease_money_route')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        
                           
                            $("#add_user232").css("display", "none");
                            $("#add_user32").css("display", "block");
                            $('.close').click();
                            $('#position-top-add_money2').click();

                            var user_id = $('#code').val(); // Get the value from the input field
                            var csrfToken = "{{ csrf_token() }}";
                            
                            $.ajax({
                            type: 'post',
                            url: "{{route('get_user_info')}}",
                            data: {
                                _token: csrfToken,
                                user_id: user_id
                            },
                            success: function (data) {
                                if(data.user == null){
                                    $('#add_to_course_id').css('display','none');

                                    $('#name_card').text('-');
                                    $('#mobile_card').text('-');
                                    $('#wallet_card').text('-');
                                    $('#full_name').text('-');
                                    $('#reset_count').text('-');
                                    $('#admin_card').text('-');
                                    $("#image_card").attr('src', 'https://mz-academy.com/Artboard%201@4x-8.png');
                                }else{
                                    $('#add_to_course_id').css('display','block');
                                    $('#add_money').css('display','block');
                                    $('#add_money23').css('display','block');
                                    $('#name_card').text(data.user.name);
                                    $('#name_sub').text(' الدورات المشترك بها ('+data.user.name+') ('+data.user.id+')' );
                                    $('#user_id_money').val(data.user.id);
                                    $('#user_id_money2').val(data.user.id);
                                    $('#mobile_card').text(data.user.mobile);
                                    $('#wallet_card').text(data.user.my_wallet);
                                    $('#money_id').val(data.user.my_wallet);
                                    $('#reset_count').text(data.user.reset_count);
                                    $("#image_card").attr('src', data.user.image);
                                    if(data.admin_card == null){
                                        $('#admin_card').text('لم يوثق بعد');
                                    }else{

                                        $('#admin_card').text(data.admin_card);
                                    }
                                    $('#full_name').text('(' + data.user.id+' ) ' + data.full_name);
                                }
                            
                            
                            
                            },
                            error: function (reject) {
                                // Handle error
                            }
                        });
                         
                 
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
            }
    </script>


    {{-- edit user --}}
    <script>
        $('#edit_user').on('show.bs.modal', function(event) {
        
   
            var button = $(event.relatedTarget)
            var user_id =                  button.data('user_id')
            var course_id =                  button.data('course_id')
            
            
            var modal = $(this)
            modal.find('#user_id').val(user_id);
            modal.find('#course_id').val(course_id);
      
  
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
                    url: "{{route('cancel_course')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing").css("display", "block");
                        $("#editing2").css("display", "none");

                        if(data.status == false){
                            $('#position-top-start_error').click();
                        }else{
                            $('.close').click();
                    
                            $('#position-top-start_edit').click();
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        }
                        // location.reload();
                    
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


   <script>
        function add_to_course(){
        
            $('#title2_error').text('')
            $('#body2_error').text('')

            
            $("#editing4").css("display", "none");
            $("#editing24").css("display", "block");

            var formData = new FormData($('#add_to_course_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('add_to_course_route')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing4").css("display", "block");
                        $("#editing24").css("display", "none");

                  
                        $('.close').click();
                
                        $('#position-top-start').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);

                       
                        // location.reload();
                    
                    }, error: function (reject) {
                            $("#editing4").css("display", "block");
                            $("#editing24").css("display", "none");
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