@extends('layouts.main_page')

@section('css')


    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">


@endsection


@section('content')


<button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
<button class="btn btn-outline-primary" style="display: none" onclick="start_error2()" id="position-top-start_error"></button> 

<div class="row">
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="app-user-view">
                <!-- User Card & Plan Starts -->
                <div class="row">
                    <!-- User Card starts-->
                    <div class="col-xl-12 col-lg-12 col-md-7">
                        <div class="card user-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-12 d-flex flex-column justify-content-between border-container-lg">
                                        <div class="user-avatar-section">
                                            <div class="d-flex justify-content-start">
                                                @if($user->image != null)
                                                <img class="img-fluid rounded" src="{{ $user->image }}" height="104" width="104" alt="User avatar" />
                                                @else
                                                <img class="img-fluid rounded" src="{{ asset('Asset 1.png') }}" height="104" width="104" alt="User avatar" />
                                                @endif
                                                <div class="d-flex flex-column ml-1">
                                                    <div class="user-info mb-1">
                                                        <h4 class="mb-0">{{ $user->name ?? "-" }}</h4>
                                                        <span class="card-text">{{ $user->mobile ?? "-" }} </span>
                                                    </div>
                                                    <div class="d-flex flex-wrap">
                                                        {{-- <a href="./app-user-edit.html" class="btn btn-primary">Edit</a> --}}
                                                        <button class="btn btn-outline-danger ml-1" disabled>Delete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="d-flex align-items-center user-total-numbers">
                                            <div class="d-flex align-items-center mr-2">
                                                <div class="color-box bg-light-primary">
                                                    <i data-feather="dollar-sign" class="text-primary"></i>
                                                </div>
                                                <div class="ml-1">
                                                    <h5 class="mb-0"><?php $course_cont = \App\Models\UserCourse::where('user_id',$user->id)->count(); ?> {{ $course_cont }}</h5>
                                                    <small>الكورسات المشترك فيها </small>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="color-box bg-light-success">
                                                    <i data-feather="trending-up" class="text-success"></i>
                                                </div>
                                                <div class="ml-1">
                                                    <h5 class="mb-0"><?php $course_cont = \App\Models\UserCourse::where('user_id',$user->id)->count(); ?> {{ $course_cont }}</h5>
                                                    <small>الكورسات المشترك فيها </small>
                                                </div>
                                            </div>
                                        </div> --}}
                                    </div>
                                    <div class="col-xl-6 col-lg-12 mt-2 mt-xl-0">
                                        <div class="user-info-wrapper">
                                            <div class="d-flex flex-wrap">
                                                <div class="user-info-title">
                                                    <i data-feather="user" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">{{ $user->id ?? "-" }}</span>
                                                </div>
                                                <p class="card-text mb-0"></p>
                                            </div>
                                            <div class="d-flex flex-wrap my-50">
                                                <div class="user-info-title">
                                                    <i data-feather="check" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">
                                                        <?php if($user->status == 0){
                                                                 $m = "غير مفعل";
                                                              }elseif($user->status == 1){
                                                                $m = "مفعل";
                                                              }else{
                                                                $m = "رفض";
                                                              }
                                                         ?>
                                                    </span>
                                                    {{ $m }}
                                                </div>
                                                <p class="card-text mb-0"></p>
                                            </div>
                                            <div class="d-flex flex-wrap my-50">
                                                <div class="user-info-title">
                                                    <i data-feather="star" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">طالب</span>
                                                </div>
                                                <p class="card-text mb-0"></p>
                                            </div>
                                            <div class="d-flex flex-wrap my-50">
                                                <div class="user-info-title">
                                                    <i data-feather="flag" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0">العراق</span>
                                                </div>
                                                <p class="card-text mb-0"></p>
                                            </div>
                                            <div class="d-flex flex-wrap">
                                                <div class="user-info-title">
                                                    <i data-feather="phone" class="mr-1"></i>
                                                    <span class="card-text user-info-title font-weight-bold mb-0"> {{ $user->reset_count ?? "-" }} </span> 
                                                </div>
                                                <p class="card-text mb-0">عدد مرات اعادة التعيين    </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /User Card Ends-->

                    <!-- Plan Card starts-->
                    {{-- <div class="col-xl-3 col-lg-4 col-md-5">
                        <div class="card plan-card border-primary">
                            <div class="card-header d-flex justify-content-between align-items-center pt-75 pb-1">
                                <h5 class="mb-0">المحفظة </h5>
                                <span class="badge badge-light-secondary" data-toggle="tooltip" data-placement="top" title="Expiry Date">July 22, <span class="nextYear"></span>
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="badge badge-light-primary">Basic</div>
                                <ul class="list-unstyled my-1">
                                    <li>
                                        <span class="align-middle">5 Users</span>
                                    </li>
                                    <li class="my-25">
                                        <span class="align-middle">10 GB storage</span>
                                    </li>
                                    <li>
                                        <span class="align-middle">Basic Support</span>
                                    </li>
                                </ul>
                                <button class="btn btn-primary text-center btn-block">Upgrade Plan</button>
                            </div>
                        </div>
                    </div> --}}
                    <!-- /Plan CardEnds -->
                </div>
                <!-- User Card & Plan Ends -->

                <h1>  الدورات المشترك فيها</h1>

                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic table table-responsive-md yajra-datatable">
                                    <thead>
                                        <tr>
                                                
                                            <th>#</th>
                                            <th>اسم الدورة</th>
                                            <th>  المعلم</th>
                                            <th> سعر الدورة</th>
                                            <th>نوع الدورة </th>
                                            <th> العمليات  </th>
                                      
                                          
                                            
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
       
                {{-- <div class="row" id="table-striped-white">
                    <div class="col-12">
                        <div class="card">
                           
                            <div class="table-responsive">
                                <table class="table table-striped table-white">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th > اسم الدورة</th>
                                            <th > نوع الدورة</th>
                                  
                                            <th > تاريخ الاشتراك</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $courses = \App\Models\UserCourse::where('user_id', $user->id)->get(); ?>
                                        @forelse ($courses as $key=>$course)
                                            <?php $course_name = \App\Models\Course::where('id', $course->course_id)->first(); ?>
                                   
                                         
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                               <td>{{ $course_name->name ?? '' }}</td>
                                                @if($course_name->type == "paid_public")

                                                     <td>مدفوع عام</td>

                                                @elseif($course_name->type == "private")

                                                     <td>خاص</td>

                                                @else

                                                     <td>{{ $course_name->type ?? '' }}</td>

                                                @endif


                                               
                                            
                                                <td>{{ $course->created_at ?? '' }}</td>
                                            
                                            </tr>
                                            @empty
                                            <tr>
                                                <th style="text-align: center">لا يوجد </th>
                                            </tr>
                                        @endforelse
                                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> --}}



                <h1> الاكواد المستخدمة للدورات الخاصة </h1>
       
                <div class="row" id="table-striped-white">
                    <div class="col-12">
                        <div class="card">
                           
                            <div class="table-responsive">
                                <table class="table table-striped table-white">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th > الكود</th>
                                            <th > اسم الدورة</th>
                                            <th > تاريخ الاشتراك</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $codes = \App\Models\TeacherCode::where('user_id', $user->id)->get(); ?>
                                        @forelse ($codes as $key=>$code)

                                            <?php $courses_name = \App\Models\Course::where('id', $code->course_id)->first(); ?>
                                         
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $code->code ?? '' }}</td>
                                                <td>{{ $courses_name->name ?? '' }}</td>
                                                <td>{{ $course->updated_at ?? '' }}</td>
                                            
                                            </tr>
                                            @empty
                                            <tr>
                                                <th style="text-align: center">لا يوجد </th>
                                            </tr>
                                        @endforelse
                                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>



                <h1>   بيانات التوثيق </h1>
       
                <div class="row" id="table-striped-white">
                    <div class="col-12">
                        <div class="card">
                           
                            <div class="table-responsive">
                                <table class="table table-striped table-white">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th > الاسم بالكامل</th>
                                            <th >  الصورة الشخصية </th>
                                            <th >  الصورة الامامية</th>
                                            <th >  الصورة الخلفية</th>
                                            <th >   الحالة</th>
                                            <th > تاريخ الاشتراك</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $users_verfied = \App\Models\VerifiedData::where('user_id', $user->id)->get(); ?>
                                        @forelse ($users_verfied as $key=>$users_ve)

                                            {{-- <?php $courses_name = \App\Models\VerifiedData::where('user_id', $code->course_id)->first(); ?> --}}
                                         
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $users_ve->full_name ?? '' }}</td>
                                                <td><img src="{{ $users_ve->personal_photo	 ?? ''  }}" class="img-fluid" alt=""></td>
                                                <td><img src="{{ $users_ve->front_image_id	 ?? ''  }}" class="img-fluid" alt=""></td>
                                                <td><img src="{{ $users_ve->back_image_id	 ?? ''  }}" class="img-fluid" alt=""></td>
                                                <td>

                                                    <?php 
                                                        if($users_ve->status == 0){
                                                            $m = 'في الانتظار';
                                                        }elseif($users_ve->status ==1){
                                                            $m = 'تم القبول';
                                                        }else{
                                                            $m = 'تم الرفض';
                                                        }
                                                        ?>
                                                        
                                                        {{ $m ?? "-" }}
                                                </td>
                                                <td>{{ $users_ve->created_at ?? '' }}</td>
                                            
                                            </tr>
                                            @empty
                                            <tr>
                                                <th style="text-align: center">لا يوجد </th>
                                            </tr>
                                        @endforelse
                                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


                <?php $user = \App\Models\User::where('id',$user->id)->first(); ?>
                <?php

                
                    if($user){

                        $admin = \App\Models\Admin::where('id', $user->person_who_approved)->first(); 
                    }                
                ?>
                <div class="row">
                    @if($admin)
                    <div class="col-md-6">  <h1> الحركات المالية للدورات المدفوع عام 
                        
                        
                    </h1>
                    <span class="badge badge-success"> (صاحب التوثيق : {{   $admin->name ?? "-" }})</span>
                    
                    </div>
                    @endif
                    <div class="col-md-6"><h1>  المحفظة:  {{ $user->my_wallet }}</h1></div>
                </div>
              

       
                <div class="row" id="table-striped-white">
                    <div class="col-12">
                        <div class="card">
                           
                            <div class="table-responsive">
                                <table class="table table-striped table-white">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th > المبلغ</th>
                                            <th >  الحركة</th>
                                            <th >  الدورة</th>
                                            <th >  تاريخ الحركة</th>
                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $wallet = \App\Models\Wallet::where('user_id', $user->id)->orderBy('id','desc')->get();
                                         ?>
                                        @forelse ($wallet as $key=>$wa)

                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $wa->money ?? '' }}</td>
                                                <?php
                                               
                                            
                                                ?>
                                                <td>{{ $wa->type ?? '' }}   {{ $wa->notes }}</span> 
                                                    <span style="color:rgb(60, 0, 128)"></span>
                                                </td>
                                               <?php 
                                               
                                                        $course = \App\Models\Course::where('id', $wa->course_id)->first(); 
                                                        if($course){
                                                            $teacher = \App\Models\Teacher::where('id', $course->teacher_id)->first();  
                                                        
                                                            $teacher = \App\Models\Teacher::where('id', $course->teacher_id)->first(); 
                                                        
                                                            if($teacher){
                                                                $teacher = $teacher->name;
                                                            }else{
                                                                $teacher = "-";
                                                            }
                                                        }else{
                                                            $teacher = "-";
                                                        }
                                               ?>
                                                <td>{{ $course->name ?? '' }}  <span style="color:green">({{  $teacher ?? "-" }})</td>
                                                <td>{{ $wa->created_at ?? '' }}</td>
                                             
                                            
                                            </tr>
                                            @empty
                                            <tr>
                                                <th style="text-align: center">لا يوجد </th>
                                            </tr>
                                        @endforelse
                                 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            

         
            </section>

        </div>
    </div>
</div>
<!-- END: Content-->

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
        ajax: "{{ route('get_all_courses_profile',$user->id) }}",
        columns: [
            {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name'         ,name: 'name'},
            {data: 'teacher_id'         ,name: 'teacher_id'},
            {data: 'price_course'         ,name: 'price_course'},
            {data: 'type_course'         ,name: 'type_course'},
            {data: 'action'         ,name: 'action'},
        ],
        "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
    });
    });
</script>


{{-- modal edit --}}
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
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="modal-body">
                        <div class="row">
                            <label for="">  هل انت متاكد من الغاء الاشتراك؟</label>
                            <input type="hidden" name="id" id="id2">
                         
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
                        location.reload();
                       
                    
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





    {{-- messge_accept modal --}}
    <script>
        $('#accept_user').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            var id =           button.data('id')

            var modal = $(this)
            modal.find('.modal-body #user_id_accept').val(id);

    
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