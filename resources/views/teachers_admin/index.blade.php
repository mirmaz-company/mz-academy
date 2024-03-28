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


 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit2()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="is_found2()" id="position-top-is_found"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="send_mail2()" id="position-top-send_mail"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="created()" id="position-top-created"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="statusw()" id="position-top-status"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#">الأساتذة </a>
        </li>
    </ol>
</div>


{{-- <form action="{{ url('upload_bunny') }}" method="post" enctype="multipart/form-data">
    @csrf
    <p><input type="text" name="title" placeholder="Enter Video Title" /></p>
    <p><textarea name="description" cols="30" rows="10" placeholder="Video description"></textarea></p>
    <p><input type="file" name="video" /></p>
    <button type="submit" name="submit">Submit</button>
</form> --}}

<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a> 

@can('المعلمين')
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive yajra-datatable">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                            <th>اسم الأستاذ</th>
                            <th> الايميل</th>
                            <th> التخصص</th>
                            <th> رسالة التأكيد</th>
                            <th> تحويل الرفع المباشر</th>
                            <th>عدد المشتركين بكل الكورسات  </th>
                            <th>عدد المتابعين  </th>
                            <th>عدد الدورات  </th>
                            <th> الاكواد  </th>
                            <th> الحالة  </th>
                            <th>  عدد مرات تسجيل الدخول للوحة </th>
                            <th>  عدد المرات التي تم ارسال الايميل </th>
                            <th> ارسال بيانات اللوحة عبر الايميل  </th>
                            {{-- <th> النسبة  </th> --}}
                           <th style="width:100px">الصورة</th>
                            <th>العمليات &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </th>
                          
                            
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
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة معلم</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                       

                            <div class="col-md-12">
                                <label> اسم الأستاذ </label>
                                <div class="form-group">
                                    <input type="name" name="name" id="name"  class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>  الايميل </label>
                                <div class="form-group">
                                    <input type="name" name="email" id="email"  class="form-control" />
                                    <span id="email_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>  الباسورد </label>
                                <div class="form-group">
                                    <input type="name" name="password" id="password"  class="form-control" />
                                    <span id="password_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>  التخصص </label>
                                <div class="form-group">
                                    <input type="text" name="specialization" id="specialization"  class="form-control" />
                                    <span id="specialization_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>  النسبة </label>
                                <div class="form-group">
                                    <input type="name" name="ratio" id="ratio"  class="form-control" />
                                    <span id="ratio_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="study_id">اختر الدراسة</label>
                                    <select class="form-control" name="study_id" id="study_id">
                                        <?php $studys = \App\Models\Study::all(); ?>
                                            <option selected>اختر الدراسة..</option>  
                                        @foreach($studys as $study)
                                            <option value="{{ $study->id }}">{{ $study->name }}</option>  
                                        @endforeach
                                    </select>
                                    <span id="study_id_error" class="text-danger"></span>
                                </div>
                            </div> 
                            <?php $super_admin = 'super_admin_teahc'; ?>

                            <input type="hidden" value="{{ $super_admin }}" name="roles_name">

                            <div class="spinner-border" role="status" id="loading_solutions" style="display: none">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="level_id_id">اختر المرحلة</label>
                                    <select class="form-control" name="level_id" id="level_id">
                                      
                                    </select>
                                    <span id="level_id_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="spinner-border" role="status" id="loading_solutions2" style="display: none">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">اختر المادة الدراسية</label>
                                    <select class="form-control" name="subject_id" id="exampleFormControlSelect1">
                                      
                                    </select>
                                    <span id="subject_id_error" class="text-danger"></span>
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
                    <h4 class="modal-title" id="myModalLabel33">تعديل معلم </h4>
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
                                <label> اسم الأستاذ </label>
                                <div class="form-group">
                                    <input type="text" name="name" id="name2"  class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>  الايميل </label>
                                <div class="form-group">
                                    <input type="text" name="email" id="email2"  class="form-control" />
                                    <span id="email_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>  الباسورد </label>
                                <div class="form-group">
                                    <input type="text" name="password" id="password2"  class="form-control" />
                                    <span id="password_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label>  التخصص </label>
                                <div class="form-group">
                                    <input type="text" name="specialization" id="specialization2"  class="form-control" />
                                    <span id="specialization2_error" class="text-danger"></span>
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


{{-- vdociper_or_bunny_modal --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="vdociper_or_bunny_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اختيار طريقة الرفع  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="vdociper_or_bunny_modal_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="id" id="idd4">

                            <div class="form-group col-md-12">
                                <label for="exampleFormControlSelect1">اختر طريقة الرفع المباشر </label>
                                <select class="form-control" name="vdociper_or_bunny" id="vdociper_or_bunny_id">
                                    
                                      <option value="bunny">bunny</option>
                                      <option value="vdocipher">vdocipher</option>
                                      <option value="resolutions">resolutions</option>
                                </select>
                              </div>
                       
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing27" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing7" onclick="do_update7()" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



{{-- modal add_new_subject_to_teacher --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="add_new_subject_to_teacher" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"> اضافة موضوع جديد للاستاذ </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_new_subject_to_teacher_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" name="id" id="id24">

                            <div class="row">
                                <div class="col-md-6">
                                    <h4 id="name_teacher3">  </h4> 
                                </div>
                                <div class="col-md-6">
                                    <img src="" class="img-fluid" id="teacher_image" alt="">
                                </div>
                                <div class="col-md-12">
                                    <h1>مواضيع الاستاذ:</h1>
                                    <div id="showw"></div>
                                </div>
                            </div>
                           
                           
                           


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="study_id">اختر الدراسة</label>
                                    <select class="form-control" name="study_id2" id="study_id2">
                                        <?php $studys = \App\Models\Study::all(); ?>
                                            <option selected>اختر الدراسة..</option>  
                                        @foreach($studys as $study)
                                            <option value="{{ $study->id }}">{{ $study->name }}</option>  
                                        @endforeach
                                    </select>
                                    <span id="study_id_error" class="text-danger"></span>
                                </div>
                            </div> 
                            <?php $super_admin = 'super_admin_teahc'; ?>

                            <input type="hidden" value="{{ $super_admin }}" name="roles_name">

                            <div class="spinner-border" role="status" id="loading_solutions23" style="display: none">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="level_id_id">اختر المرحلة</label>
                                    <select class="form-control" name="level_id2" id="level_id2">
                                      
                                    </select>
                                    <span id="level_id_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="spinner-border" role="status" id="loading_solutions22" style="display: none">
                                <span class="sr-only">Loading...</span>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">اختر المادة الدراسية</label>
                                    <select class="form-control" name="subject_id2" id="exampleFormControlSelect12">
                                      
                                    </select>
                                    <span id="subject_id_error" class="text-danger"></span>
                                </div>
                            </div>
                         

                        
                    
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing23" class="btn btn-primary btn-block">  تتم الاضافة ...</button>
                        <button type="button" id="editing3" onclick="do_update2()" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- create_code_modal  --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="create_code_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33"> انشاء اكواد </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="create_code_form">
                    @csrf
                    <div class="modal-body">


                            <div class="row">
                                <input type="hidden" name="teacher_id" id="teacher_id_input">
                                <div class="col-md-12" style="margin-bottom: 3%">
                                <label for="">نوع الحزمة</label>
                                <select class="form-control" name="backage_private" id="backage_private2">
                                
                                        <option selected value="noraml">عادي</option>  
                                        <option value="private_package">حزمة خاصة للاستاذ</option>  
                                        
                                
                                </select>
                            </div> 
                           
                         
                            <div class="col-md-12">
                                <div class="form-group" id="select_one_cou">
                                    <label id="select_course">اختر الدورة</label>
                                    <label id="select_course_hide" style="display: none"> جاري جلب الدورات الخاصة بالمدرس ....</label>
                                    <select class="form-control" name="course_id" id="course_id2">
                                      
                                     
                                    </select>
                                    <span id="course_id2_error" class="text-danger"></span>
                                </div>
                            </div> 
                            <br>

                            <div class="col-md-12" style="display:none" id="name_id_pa">
                                <label> اسم الحزمة </label>
                                <div class="form-group">
                                    <input type="text" name="name_package" id="name_package"  class="form-control" />
                                    <span id="name_package_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12" style="display:none" id="price_package_pa">
                                <label>  سعر الباقة </label>
                                <div class="form-group">
                                    <input type="text" name="price_package" id="price_package"  class="form-control" />
                                    <span id="price_package_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12" style="display:none" id="all_cour_id">
                                <label>اختر الدورات</label>
                                <div class="form-group">
                                    <select class="select2 form-control" multiple="multiple"  name="courses_id[]" id="default-select-multi2">
                                      
                                       
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label> عدد الاكواد </label>
                                <div class="form-group">
                                    <input type="text" name="number_codes" id="number_codes"  class="form-control" />
                                    <span id="number_codes_error" class="text-danger"></span>
                                </div>
                            </div>

                          
                           
                        
                    
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing234" class="btn btn-primary btn-block"> يتم الانشاء ...</button>
                        <button type="button" id="editing34" onclick="create_code_do()" class="btn btn-primary btn-block">انشاء الاكواد</button>
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

    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}"></script>

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
        $(document).ready(function() {
            $('#backage_private2').change(function() {
                if ($('#backage_private2').val() === 'private_package') {
                    $('#name_id_pa').show();
                    $('#price_package_pa').show();
                    $('#all_cour_id').show();
                    $('#select_one_cou').hide();
                    
                }else{
                    $('#name_id_pa').hide();
                    $('#price_package_pa').hide();
                    $('#all_cour_id').hide();
                    $('#select_one_cou').show();
                }
            });
        });
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
        function msg_edit2(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: '  تم التعديل بنجاح ',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function is_found2(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: ' المادة الدراسية موجود مسبقا للاستاذ ',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function send_mail2(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم ارسال البريد الالكتروني وكلمة السر عبر الايميل ',
                showConfirmButton: false,
                timer: 2000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }

        function created(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم انشاء الاكواد بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function statusw(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم تغيير الحالة للمعلم بنجاح',
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
            ajax: "{{ route('get_all_teachers') }}",
            columns: [
                {data: 'DT_RowIndex',           name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'                  ,name: 'name'},
                {data: 'email'                 ,name: 'email'},
                {data: 'specialization'                 ,name: 'specialization'},
                {data: 'show_notic'                 ,name: 'show_notic'},
                {data: 'conver_upload'                 ,name: 'conver_upload'},
             
                {data: 'total_subscriptions'   ,name: 'total_subscriptions'},
                {data: 'follwers'              ,name: 'follwers'},
                {data: 'courses_count'              ,name: 'courses_count'},
                {data: 'codes'                 ,name: 'codes'},
                {data: 'is_acess'                 ,name: 'is_acess'},
                {data: 'count_logged_in'                 ,name: 'count_logged_in'},
                {data: 'count_send_email'                 ,name: 'count_send_email'},
                {data: 'send_email'                 ,name: 'send_email'},
                // {data: 'ratio'                 ,name: 'ratio'},
                {data: 'image'                 ,name: 'image'},
                {data: 'action'     ,           name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}


    <script>
        function send_email(email,id){
         
                $("#loader"+id).css("display", "none");
                $("#loader2"+id).css("display", "block");
                $.ajax({
                    type: 'post',
                    url: "{{route('send_mail')}}",
                    data:{
                        _token:'{{ csrf_token() }}',
                        email: email,
                    },
                    success: function (data) {
                        $("#loader2"+id).css("display", "none");
                        $("#loader"+id).css("display", "block");
                
                        $('#position-top-send_mail').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    
                    }, error: function (reject) {
                        $("#loader2"+id).css("display", "none");
                        $("#loader"+id).css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "2_error").text(val[0]);
                        });
                    }
                });
 
        }
    </script>
  
    {{-- open modal add user --}}
    <script>
        $('#modal_add').on('show.bs.modal', function(event) {
            $('#city').text('');
        
        })
</script>

<script>
    function conver_upload(id){
        
            $("#show"+id).css("display", "none");
            $("#hide"+id).css("display", "block");

            $.ajax({
                type: 'post',
                url: "{{route('conver_upload')}}",
                data:{
                    _token:'{{ csrf_token() }}',
                    id: id,
                },
                success: function (data) {
                   
                    $("#show"+id).css("display", "block");
                    $("#hide"+id).css("display", "none");
            
                    $('#position-top-conver_upload').click();
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


  {{-- change status --}}
  <script>
        
    $(document).on('change','#cousome_switch', function (e) {
 
          
            let id = $(this).data('id');
    
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: '{{ route('is_access') }}',
        
                data: {  
                        '_token':'{{ csrf_token() }}',
                        'id':id,
                        
                    },
                success: function (data) {
                   
                    $('#position-top-status').click();
                }
            });
    });

</script>
  {{-- change status --}}
  <script>
        
    $(document).on('change','#cousome_switch2', function (e) {
 
          
            let id = $(this).data('id');
    
            
            $.ajax({
                type: "post",
                dataType: "json",
                url: '{{ route('show_notic') }}',
        
                data: {  
                        '_token':'{{ csrf_token() }}',
                        'id':id,
                        
                    },
                success: function (data) {
                   
                    $('#position-top-status').click();
                }
            });
    });

</script>


 {{-- selected Levels --}}
 <script>
    $(document).ready(function() {
        $('select[name="study_id"]').on('change', function() {
        
  
            $("#loading_solutions").css("display", "block");

            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: "{{ URL::to('get_levels_from_study') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                           $("#loading_solutions").css("display", "none");
                   

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


    {{-- selected subjects --}}
    <script>
        $(document).ready(function() {
            $('select[name="level_id"]').on('change', function() {
            
      
                $("#loading_solutions2").css("display", "block");
    
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: "{{ URL::to('get_sujects_from_level') }}/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
    
                               $("#loading_solutions2").css("display", "none");
                       
    
                                $('select[name="subject_id"]').empty();
                                $('select[name="subject_id"]').append('<option selected disabled selected>اختر الموضوغ..</option>');
                                for (var i = 0; i < data.subjects.length; i++){
                                        $('select[name="subject_id"]').append('<option value="' +
                                        data.subjects[i].id + '">' + data.subjects[i].name+ '</option>');
                                }
                            
                            }
                        
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
            });
          
    </script>


 {{-- selected Levels2 --}}
 <script>
    $(document).ready(function() {
        $('select[name="study_id2"]').on('change', function() {
        
  
            $("#loading_solutions23").css("display", "block");

            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: "{{ URL::to('get_levels_from_study') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                           $("#loading_solutions23").css("display", "none");
                   

                            $('select[name="level_id2"]').empty();
                            $('select[name="level_id2"]').append('<option selected disabled selected>اختر المرحلة..</option>');
                            for (var i = 0; i < data.levels.length; i++){
                                    $('select[name="level_id2"]').append('<option value="' +
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


    {{-- selected subjects --}}
    <script>
        $(document).ready(function() {
            $('select[name="level_id2"]').on('change', function() {
            
      
                $("#loading_solutions22").css("display", "block");
    
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: "{{ URL::to('get_sujects_from_level') }}/" + id,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
    
                               $("#loading_solutions22").css("display", "none");
                       
    
                                $('select[name="subject_id2"]').empty();
                                $('select[name="subject_id2"]').append('<option selected disabled selected>اختر الموضوغ..</option>');
                                for (var i = 0; i < data.subjects.length; i++){
                                        $('select[name="subject_id2"]').append('<option value="' +
                                        data.subjects[i].id + '">' + data.subjects[i].name+ '</option>');
                                }
                            
                            }
                        
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
            });
          
    </script>




    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user', function (e) {
            $('#name_error').text('');
            $('#email_error').text('');
            $('#password_error').text('');
            $('#subject_id_error').text('');
   
       
            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('store_teachers')}}",
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

                            $('#name').val('');
                            $('#email').val('');
                            $('#password').val('');
                            $('#subject_id').val('');
                 
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
            var email =                button.data('email')
            var password =                button.data('password')
            var specialization =                button.data('specialization')
            var subject_id =                button.data('subject_id')
            
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #email2').val(email);
            modal.find('.modal-body #password2').val(password);
            modal.find('.modal-body #specialization2').val(specialization);
            modal.find('.modal-body #subject_id2').val(subject_id);
      
  
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
                url: "{{route('update_teachers')}}",
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



    {{-- edit add_new_subject_to_teacher --}}
    <script>
        $('#add_new_subject_to_teacher').on('show.bs.modal', function(event) {
        
            var button = $(event.relatedTarget)
            var id =                  button.data('id')
            var name_teacher =        button.data('name_teacher')
            var showw =               button.data('showw')
            var teacher_image =               button.data('teacher_image')
        
          
            
            var modal = $(this)
            modal.find('.modal-body #id24').val(id);
            modal.find('.modal-body #name_teacher3').text(name_teacher);


            modal.find('.modal-body #showw').html(showw);
            $(".modal-body #teacher_image").attr('src', teacher_image);
       
  
        })
    </script>

   {{-- update add_new_subject_to_teacher --}}
   <script>
    function do_update2(){
    
        $('#title2_error').text('')
        $('#body2_error').text('')

        
        $("#editing3").css("display", "none");
        $("#editing23").css("display", "block");

        var formData = new FormData($('#add_new_subject_to_teacher_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('add_new_subject_to_teacher')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {

                    if(data.status == true){
                        $("#editing3").css("display", "block");
                        $("#editing23").css("display", "none");
                
                        $('.close').click();
                    
                        $('#position-top-start').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    }else{
                        $("#editing3").css("display", "block");
                        $("#editing23").css("display", "none");
                        $('#position-top-is_found').click();
                    }
                  
                
                }, error: function (reject) {
                        $("#editing3").css("display", "block");
                        $("#editing23").css("display", "none");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "2_error").text(val[0]);
                        });
                }
            });
    }
   </script>



    {{-- edit vdociper_or_bunny_modal_form --}}
    <script>
        $('#vdociper_or_bunny_modal').on('show.bs.modal', function(event) {
        
            var button = $(event.relatedTarget)
            var id =                  button.data('id')
            var vdociper_or_bunny =        button.data('vdociper_or_bunny')
        
          
            var modal = $(this)
            modal.find('#idd4').val(id);
            modal.find('#vdociper_or_bunny_id').val(vdociper_or_bunny);
       
  
        })
    </script>

   {{-- update vdociper_or_bunny_modal_form --}}
   <script>
    function do_update7(){
    
        
        $("#editing27").css("display", "block");
        $("#editing7").css("display", "none");

        var formData = new FormData($('#vdociper_or_bunny_modal_form')[0]);
            $.ajax({
                type: 'post',
                enctype: 'multipart/form-data',
                url: "{{route('conver_upload')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {

            
                    $("#editing27").css("display", "none");
                    $("#editing7").css("display", "block");
            
                    $('.close').click();
                
                    $('#position-top-start_edit').click();
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                   
                  
                
                }, error: function (reject) {
                        $("#editing27").css("display", "none");
                        $("#editing7").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "2_error").text(val[0]);
                        });
                }
            });
    }
   </script>



    {{-- show create_code_form --}}
    <script>
        $('#create_code_modal').on('show.bs.modal', function(event) {

            $("#select_course").css("display", "none");
            $("#select_course_hide").css("display", "block");
            $('select[name="courses_id[]"]').empty();
        
            var button = $(event.relatedTarget)
            var id =                                button.data('id')
            var id_teacher =                        button.data('id')
            var teacher_id_input =                  button.data('id')
    
            
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
            modal.find('.modal-body #teacher_id_input').val(teacher_id_input);




            $.ajax({
                type: 'get',
                url: "{{route('get_courses')}}",
                data:{
                    _token:'{{ csrf_token() }}',
                    id_teacher: id_teacher,
                },
                success: function (data) {

                    $('select[name="courses_id[]"]').empty();

                    $("#select_course").css("display", "block");
                    $("#select_course_hide").css("display", "none");

                    for (var i = 0; i < data.courses.length; i++){
                            $('select[name="courses_id[]"]').append('<option value="' +
                            data.courses[i].id + '">' + data.courses[i].name+ ' (' + data.courses[i].level_name_dashboard+ ' )</option>');
                    }
                        
            
                
                
                }, error: function (reject) {
                    
                }
                });


      
  
        })
    </script>
    {{-- show create_code_form --}}
    <script>
        $('#create_code_modal').on('show.bs.modal', function(event) {

            $("#select_course").css("display", "none");
            $("#select_course_hide").css("display", "block");
            $('select[name="course_id"]').empty();
        
            var button = $(event.relatedTarget)
            var id =                                button.data('id')
            var id_teacher =                        button.data('id')
            var teacher_id_input =                  button.data('id')
    
            
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
            modal.find('.modal-body #teacher_id_input').val(teacher_id_input);




            $.ajax({
                type: 'get',
                url: "{{route('get_courses')}}",
                data:{
                    _token:'{{ csrf_token() }}',
                    id_teacher: id_teacher,
                },
                success: function (data) {

                    $('select[name="course_id"]').empty();

                    $("#select_course").css("display", "block");
                    $("#select_course_hide").css("display", "none");

                    $('select[name="course_id"]').append('<option selected disabled selected>اختر الدورة..</option>');
                    for (var i = 0; i < data.courses.length; i++){
                            $('select[name="course_id"]').append('<option value="' +
                            data.courses[i].id + '">' + data.courses[i].name+ ' (' + data.courses[i].level_name_dashboard+  ')</option>');
                    }
                        
            
                
                
                }, error: function (reject) {
                    
                }
                });


      
  
        })
    </script>


   {{--  create_code_form --}}
   <script>
        function create_code_do(){
        
            $('#title2_error').text('')
            $('#body2_error').text('')

            
            $("#editing34").css("display", "none");
            $("#editing234").css("display", "block");

            var formData = new FormData($('#create_code_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('create_codes')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing34").css("display", "block");
                        $("#editing234").css("display", "none");
                
                        $('.close').click();
                    
                        $('#position-top-created').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    
                    }, error: function (reject) {
                            $("#editing34").css("display", "block");
                            $("#editing234").css("display", "none");
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
                url: "{{route('destroy_teachers')}}",
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