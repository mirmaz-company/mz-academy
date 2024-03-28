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


<h1 class="alert alert-danger">هذه الاحصائيات للدورات الخاصة فقط... سيتم حساب المشتركين  في الدورات المدفوع عام من ضمن عدد المشتركين في جميع الدورات</h1>
     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
       
        <?php $teacher = \App\Models\Teacher::where('id',$teacher_id)->first();  ?>
        @if($teacher)

            <li class="breadcrumb-item"><a href="#">الاكواد الخاصة بالدورات  {{ $teacher->name }}</a>
            </li>
       
        @endif
    </ol>
</div>



{{-- <a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a>  --}}


<div class="row">
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                 <?php    
                    // $teacher = \App\Models\Teacher::where('id',$id)->first();
                    // $courses = \App\Models\Course::where('teacher_id',$id)->pluck('id');
                    // $user_course = \App\Models\UserCourse::whereIn('course_id',$courses)->count();

                    $teacher_code_section_id = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->pluck('id');
                  
                    $teacher_code = \App\Models\TeacherCode::WhereIn('section_code',$teacher_code_section_id)->where('course_id',0)->where('user_id','!=',0)->count();
                     
                    
                 ?>
                 
                <p class="card-text">   عدد الاكواد المستخدمة نظام باقة  </p>
                <h2 class="fw-bolder">{{ $teacher_code }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                 <?php    

                     $teacher_code_section_id2 = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->pluck('id');
                     $teacher_code2 = \App\Models\TeacherCode::WhereIn('section_code',$teacher_code_section_id2)->where('course_id',"!=",0)->whereNotIn('user_id',[0,2])->count();

                   
                 ?>
                 
                <p class="card-text">عدد الاكواد المستخدمة نظام عادي</p>
                <h2 class="fw-bolder">{{ $teacher_code2 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                 <?php    
                    $teacher = \App\Models\Teacher::where('id',$teacher_id)->first();
                    $courses = \App\Models\Course::where('teacher_id',$teacher_id)->pluck('id');
                    $user_course = \App\Models\UserCourse::whereIn('course_id',$courses)->whereNotIn('user_id',[2])->count();

                    
                 ?>
                 
                <p class="card-text">  عدد المشتركين الكلي في جميع الدورات  </p>
                <h2 class="fw-bolder">{{ $user_course }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                 <?php     
                  $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id',0)->get();

                  $data = [];

                  foreach ($teacher_code_sections as $teacher_code_secti) {

                    $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                    foreach($teacher_code_se as $teacher_code_s){

                        $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                        $price_all_code_for_one_package = $teacher_code_count * $teacher_code_secti->price_package;

                    }

                    

                    $data[] = $price_all_code_for_one_package;
                    $sum_package = array_sum($data);
                  }

                 
                  
                    
                 ?>
                 
                <p class="card-text">  المبلغ الكلي من الباقة  </p>
                <h2 class="fw-bolder">{{ $sum_package ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                 <?php     
                  $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id','!=',0)->get();

                  $data = [];

                  foreach ($teacher_code_sections as $teacher_code_secti) {

                    $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                    foreach($teacher_code_se as $teacher_code_s){

                        $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                        $course_price = \App\Models\Course::Where('id',$teacher_code_s->course_id)->pluck('price')->first();

                        $sum = $teacher_code_count *  $course_price;
                       

                    }

                    

                    $data[] = $sum;
                    $sum_package = array_sum($data);
                  }

                 
                  
                    
                 ?>
                 
                <p class="card-text">  المبلغ الكلي من العادي  </p>
                <h2 class="fw-bolder">{{ $sum_package ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                <?php     
                $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id',0)->get();

                $data = [];

                foreach ($teacher_code_sections as $teacher_code_secti) {

                  $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                  foreach($teacher_code_se as $teacher_code_s){

                      $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                      $price_all_code_for_one_package = $teacher_code_count * $teacher_code_secti->price_package;

                  }

                  

                  $data[] = $price_all_code_for_one_package;
                  $sum_package1 = array_sum($data);
                }
                if(!isset( $sum_package1)){
                    $sum_package1 = 0;
                }

               
                
                  
               ?>
                 <?php     
                  $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id','!=',0)->get();

                  $data = [];

                  foreach ($teacher_code_sections as $teacher_code_secti) {

                    $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                    foreach($teacher_code_se as $teacher_code_s){

                        $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                        $course_price = \App\Models\Course::Where('id',$teacher_code_s->course_id)->pluck('price')->first();

                        $sum = $teacher_code_count *  $course_price;
                       

                    }

                    

                    $data[] = $sum;
                    $sum_package2 = array_sum($data);
                  }

                  if(!isset($sum_package2)){
                    $sum_package2 = 0;
                   }

                 
                  $sum_package = $sum_package2 + $sum_package1;
                    
                 ?>
                 
                <p class="card-text"> المبلغ بالكامل   </p>
                <h2 class="fw-bolder">{{ $sum_package ?? 0 }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                <?php     
                $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id',0)->get();

                $data = [];

                foreach ($teacher_code_sections as $teacher_code_secti) {

                  $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                  foreach($teacher_code_se as $teacher_code_s){

                      $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                      $price_all_code_for_one_package = $teacher_code_count * $teacher_code_secti->price_package;

                  }

                  

                  $data[] = $price_all_code_for_one_package;
                  $sum_package1 = array_sum($data);
                }

               
                
                  
               ?>
                 <?php     
                  $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id','!=',0)->get();

                  $data = [];

                  foreach ($teacher_code_sections as $teacher_code_secti) {

                    $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                    foreach($teacher_code_se as $teacher_code_s){

                        $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                        $course_price = \App\Models\Course::Where('id',$teacher_code_s->course_id)->pluck('price')->first();

                        $sum = $teacher_code_count *  $course_price;
                       

                    }

                    

                    $data[] = $sum;
                    $sum_package2 = array_sum($data);
                  }

                 
                  $sum_package = $sum_package2 + $sum_package1;
                 $sum_teacher =  $sum_package - $sum_package * $teacher->ratio/100 
                 ?>
                 
                <p class="card-text">  المبلغ الخاص للاستاذ({{ 100 - $teacher->ratio }}%)   </p>
                <h2 class="fw-bolder">{{ $sum_teacher   }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                <?php     
                $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id',0)->get();

                $data = [];

                foreach ($teacher_code_sections as $teacher_code_secti) {

                  $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                  foreach($teacher_code_se as $teacher_code_s){

                      $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                      $price_all_code_for_one_package = $teacher_code_count * $teacher_code_secti->price_package;

                  }

                  

                  $data[] = $price_all_code_for_one_package;
                  $sum_package1 = array_sum($data);
                }

               
                
                  
               ?>
                 <?php     
                  $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id','!=',0)->get();

                  $data = [];

                  foreach ($teacher_code_sections as $teacher_code_secti) {

                    $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                    foreach($teacher_code_se as $teacher_code_s){

                        $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                        $course_price = \App\Models\Course::Where('id',$teacher_code_s->course_id)->pluck('price')->first();

                        $sum = $teacher_code_count *  $course_price;
                       

                    }

                    

                    $data[] = $sum;
                    $sum_package2 = array_sum($data);
                  }

                 
                  $sum_package = $sum_package2 + $sum_package1;
                    
                 ?>
                 
                <p class="card-text">  المبلغ الخاص للاكاديمية({{ $teacher->ratio }}%)   </p>
                <h2 class="fw-bolder">{{ $sum_package * $teacher->ratio/100  }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                <?php     
                $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id',0)->get();

                $data = [];

                foreach ($teacher_code_sections as $teacher_code_secti) {

                  $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                  foreach($teacher_code_se as $teacher_code_s){

                      $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                      $price_all_code_for_one_package = $teacher_code_count * $teacher_code_secti->price_package;

                  }

                  

                  $data[] = $price_all_code_for_one_package;
                  $sum_package1 = array_sum($data);
                }

               
                
                  
               ?>
                 <?php     
                  $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id','!=',0)->get();

                  $data = [];

                  foreach ($teacher_code_sections as $teacher_code_secti) {

                    $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                    foreach($teacher_code_se as $teacher_code_s){

                        $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                        $course_price = \App\Models\Course::Where('id',$teacher_code_s->course_id)->pluck('price')->first();

                        $sum = $teacher_code_count *  $course_price;
                       

                    }

                    

                    $data[] = $sum;
                    $sum_package2 = array_sum($data);
                  }

                 
                  $sum_package = $sum_package2 + $sum_package1;
                 $sum_teacher =  $sum_package - $sum_package * $teacher->ratio/100 
                 ?>
                 
                <p class="card-text"> المبلغ الخاص للاستاذ بالدولار ({{ 100 - $teacher->ratio }}%)  </p>
                <?php 
                   $sum_tea = $sum_teacher * 0.000666666666667;
                   $sum_tea = number_format($sum_tea, 2);
                
                ?>
                <h1 class="fw-bolder" style="color:red">${{ $sum_tea   }}</h1>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body" style="background: white;border-radius: 6%">
                <?php     
                $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id',0)->get();

                $data = [];

                foreach ($teacher_code_sections as $teacher_code_secti) {

                  $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                  foreach($teacher_code_se as $teacher_code_s){

                      $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                      $price_all_code_for_one_package = $teacher_code_count * $teacher_code_secti->price_package;

                  }

                  

                  $data[] = $price_all_code_for_one_package;
                  $sum_package1 = array_sum($data);
                }

               
                
                  
               ?>
                 <?php     
                  $teacher_code_sections = \App\Models\TeacherCodeSection::where('teacher_id',$teacher_id)->where('course_id','!=',0)->get();

                  $data = [];

                  foreach ($teacher_code_sections as $teacher_code_secti) {

                    $teacher_code_se = \App\Models\TeacherCodeSection::where('id',$teacher_code_secti->id)->get();

                    foreach($teacher_code_se as $teacher_code_s){

                        $teacher_code_count = \App\Models\TeacherCode::where('section_code',$teacher_code_secti->id)->where('user_id','!=',0)->count();
                        $course_price = \App\Models\Course::Where('id',$teacher_code_s->course_id)->pluck('price')->first();

                        $sum = $teacher_code_count *  $course_price;
                       

                    }

                    

                    $data[] = $sum;
                    $sum_package2 = array_sum($data);
                  }

                 
                  $sum_package = $sum_package2 + $sum_package1;

                  $sum_package  = $sum_package * $teacher->ratio/100 ;
                    
                  $sum_package = $sum_package * 0.000666666666667;

                   $sum_package = number_format($sum_package, 2);
                 ?>

                  

                 
                <p class="card-text"> الملبغ الخاص بالاكاديمية بالدولار  </p>
                <h1 class="fw-bolder" style="color:red">${{ $sum_package  }}</h1>
            </div>
        </div>
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
                            <th>ID</th>
                            <th>اسم الدورة</th>
                            <th>عدد الاكواد الكلي </th>
                            <th> الاكواد المستخدمة </th>
                            <th>التاريخ</th>
                            <th>  تصدير الاكواد الغير مستخدمة </th>
                          
                            
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
                                <label>اسم  </label>
                                <div class="form-group">
                                    <input type="text" name="city" id="city"  class="form-control" />
                                    <span id="city_error" class="text-danger"></span>
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
                    <h4 class="modal-title" id="myModalLabel33">تعديل  </h4>
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
                                <label>المدينة </label>
                                <div class="form-group">
                                    <input type="text" name="city" id="city2" class="form-control" />
                                    <span id="city2_error" class="text-danger"></span>
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
        
            ajax: "{{ route('get_all_sections_code',$teacher_id) }}",
        
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'id'         ,name: 'id'},
                {data: 'course_id'         ,name: 'course_id'},
                {data: 'number'            ,name: 'number'},
                {data: 'code_used_count'            ,name: 'code_used_count'},

                {data: 'created_at'     ,   name: 'created_at'},
                {data: 'export_code'     ,   name: 'export_code'},
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
                    url: "{{route('store_cities')}}",
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
            var city =                button.data('city')
            
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #city2').val(city);
      
  
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
                    url: "{{route('update_cities')}}",
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