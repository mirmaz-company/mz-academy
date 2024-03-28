@extends('layouts.main_page')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">

@endsection


@section('content')

<a class="btn btn-primary" data-toggle="modal" id="press_button" href="#inlineForm" style="margin-bottom:1%;display: none">{{ trans('main_trans.add') }}</a> 
<button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
{{-- modal add --}}
 <div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"> الدخول الى البوابة الاخرى</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12"> 
                                <input type="hidden" name="id" id="id">
                                <label>كلمة المرور </label>
                                <div class="form-group">
                                    <input type="text" placeholder="كلمة المرور" name="password" id="name" class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>
                            
                    
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">يتم الذهاب...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">الذهاب الى البوابة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 









       
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">    {{ trans('main_trans.main_page') }}</a>
        </li>
        <li class="breadcrumb-item"><a href="#">الاحصائيات</a>
        </li>
    </ol>
</div>

<!-- BEGIN: Content-->

    <div class="content-wrapper container-xxl p-0">
      
        <div class="content-body">
            <!-- Statistics card section -->
            <section id="statistics-card">
                <!-- Miscellaneous Charts -->
                <div class="row match-height">
                    <!-- Bar Chart -Orders -->
                   
                    <!--/ Line Chart -->
                    <div class="col-lg-12 col-12">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title">احصائيات المستخدمين</h4>
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
                                                <?php $user =\App\Models\User::where('type',0)->where('deleted_at',null)->where('is_verify_account',1)->count(); ?>
                                                <h4 class="fw-bolder mb-0">{{ $user }}</h4>
                                                <p class="card-text font-small-3 mb-0">المستخدمين الفعالين</p>
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
                                                <?php $user = \App\Models\User::where('type',0)->where('deleted_at',null)->where('is_verify_account',0)->count(); ?>
                                                <h4 class="fw-bolder mb-0">{{ $user }}</h4>
                                                <p class="card-text font-small-3 mb-0">المستخدمين غير الفعالين</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-danger me-2">
                                                <div class="avatar-content">
                                                    <i class="fa-solid fa-check"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <?php $user = \App\Models\VerifiedData::where('status',0)->count(); ?>
                                                <h4 class="fw-bolder mb-0">{{ $user }}</h4>
                                                <p class="card-text font-small-3 mb-0">طلبات الموافقة</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-12">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-success me-2">
                                                <div class="avatar-content">
                                                    <i class="fa-solid fa-ban"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <?php $study = \App\Models\UserCourse::onlyTrashed()->count(); ?>
                                                <h4 class="fw-bolder mb-0">{{ $study }}</h4>
                                                <p class="card-text font-small-3 mb-0">المنهي اشتراكهم</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/ Miscellaneous Charts -->

                <!-- Stats Vertical Card -->
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-6">
                        <canvas id="myChart"></canvas>
                    </div>

                    <div class="col-xl-6 col-md-6 col-sm-6">
                        <canvas id="myChart2"></canvas>
                    </div>
                    

                </div> <br> <br>


                <div class="row">
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $study = \App\Models\Study::count(); ?>
                                <h2 class="fw-bolder">{{ $study }}</h2>
                                <p class="card-text">الدراسة</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $level = \App\Models\Level::count(); ?>
                                <h2 class="fw-bolder">{{ $level }}</h2>
                                <p class="card-text">المراحل</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $subject = \App\Models\Subject::count(); ?>
                                <h2 class="fw-bolder">{{ $subject }}</h2>
                                <p class="card-text">المواضيع</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\UserCourse::distinct("user_id")->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text"> العدد الكلي للمشتركين(الشخص المشترك بعدة كورسات يتم حسابه واحد)</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Topic::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text"> الاهتمامات</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Teacher::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text"> المدرسين</p>
                            </div>
                        </div>
                    </div>
                  
                </div>
                <h1>احصائيات الدورات</h1> <br>
                <div class="row">

                  
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Course::where('status',2)->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">عدد الدورات المقبولة  </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Course::where('status',1)->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">عدد الدورات التي تنتظر القبول  </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Course::where('status',0)->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">عدد الدورات التي لم تطلب طلب نشر  </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Course::where('type','free')->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">عدد الدورات المجانية </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Course::where('type','private')->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">عدد الدورات الخاصة </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Course::where('type','paid_public')->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">عدد الدورات المدفوع عام </p>
                            </div>
                        </div>
                    </div>

                </div>

                <h1>احصائيات السوشيال ميديا</h1> <br>
                <div class="row">

                  
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Comment::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">   العدد الكلي للتعليقات </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\LessonCommentReply::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">   العدد الكلي للردود </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\CommentLike::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">  عدد اللايكات </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\CommentLike::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">  عدد اللايكات </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\StudentAreSaying::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">  عدد الاشخصاص الذين قيمو التطبيق </p>
                            </div>
                        </div>
                    </div>
             

                </div>


                <h1>احصائيات الدروس</h1> <br>
                <div class="row">

                  
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Lesson::where('link','!=',null)->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">  عدد الدروس الكلي </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\LessonAttachmetn::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text"> عدد مرفقات الدروس </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\Section::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text"> عدد الاقسام </p>
                            </div>
                        </div>
                    </div>

                </div>

                <h1> احصائيات الاكواد</h1> <br>
                <div class="row">

                  
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\WalletCode::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">  عدد  الاكواد الكلي مدفوع عام </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\TeacherCode::count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">  العدد الكلي الاكواد الخاصة    </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\WalletCode::where('user_id','!=',NULL)->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">  عدد الاكواد المستخدمة (مدفوع عام) </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card text-center">
                            <div class="card-body" style="background: white;border-radius: 6%">
                                <div class="avatar bg-light-info p-50 mb-1">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="font-medium-5"></i>
                                    </div>
                                </div>
                                <?php $m = \App\Models\TeacherCode::where('user_id','!=',0)->count(); ?>
                                <h2 class="fw-bolder">{{ $m }}</h2>
                                <p class="card-text">  عدد الاكواد المستخدمة ( خاص) </p>
                            </div>
                        </div>
                    </div>
                </div>
             
            </section>
            <!--/ Statistics Card section-->


       

     

@endsection


@section('js')
  

    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>
        
        function msg_add(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: 'كلمة السر خاطئة ',
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
        $(document).keydown(function(event) {
            if (event.shiftKey && event.which == 13) {
                $('#press_button').click();
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
                        url: "{{route('show_password_sure')}}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        cache: false,
                        success: function (data) {
                            
                          if(data.status == true){
                            window.location.href = data.link;
                          

                          }else{
                            $('#position-top-start').click();
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                          }

                     
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
        const labels = [
          'January',
          'February',
          'March',
          'April',
          'May',
          'June',
          'July',
          'August',
          'September',
          'October',
          'November',
          'December',
        ];
      
        const data = {
          labels: labels,
          datasets: [{
            label: 'المستخدمين',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [  {{ $data["month1"] }}, {{ $data["month2"] }}, {{ $data["month3"] }},
                {{ $data["month4"] }}, {{ $data["month5"] }}, {{ $data["month6"] }}, {{ $data["month7"] }},
                {{ $data["month8"] }},{{ $data["month9"] }},{{ $data["month10"] }},{{ $data["month11"] }},
                {{ $data["month12"] }} ],
          }]
        };
      
        const config = {
          type: 'line',
          data: data,
          options: {}
        };
  
        const myChart = new Chart(
        document.getElementById('myChart'),
        config
        );
    </script>



   
    <script>
        const labels2 = [
          'January',
          'February',
          'March',
          'April',
          'May',
          'June',
          'July',
          'August',
          'September',
          'October',
          'November',
          'December',
        ];
      
        const data2 = {
          labels: labels2,
          datasets: [{
            label: 'عدد المشتركين ',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [ {{ $data["usercourse1"] }}, {{ $data["usercourse2"] }}, {{ $data["usercourse3"] }},
                {{ $data["usercourse4"] }}, {{ $data["usercourse5"] }}, {{ $data["usercourse6"] }}, {{ $data["usercourse7"] }},
                {{ $data["usercourse8"] }},{{ $data["usercourse9"] }},{{ $data["usercourse10"] }},{{ $data["usercourse11"] }},
                {{ $data["usercourse12"] }} ],
          }]
        };
      
        const config2 = {
          type: 'bar',
          data: data2,
          options: {}
        };

        const myChart2 = new Chart(
        document.getElementById('myChart2'),
        config2
        );
  </script>
   
      



@endsection