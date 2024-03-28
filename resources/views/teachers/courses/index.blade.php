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
 <button class="btn btn-outline-primary" style="display: none" onclick="is_view0()" id="position-top-is_view0"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="is_view1()" id="position-top-is_view1"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="is_view04()" id="position-top-is_view04"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="start24()" id="position-top-start24"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="start243()" id="position-top-start243"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="is_view14()" id="position-top-is_view14"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="is_post()" id="position-top-is_post"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="has_endeed2()" id="position-top-has_endeed"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        <li class="breadcrumb-item"><a href="#">الدورات </a>
        </li>
    </ol>
</div>


@can('اضافة دورة')
<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a> 
@endcan

@can("الدورات")
<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive table-responsive-md yajra-datatable">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                            <th>الاسم</th>
                            <th>المرحلة</th>
                            <th>الفصول</th>
                            <th>حالة الدورة</th>
                            <th> اخفاء/اظهار الدورة</th>
                            <th> اخفاء/اظهار عدد المشتركين</th>
                            <th>التقييم</th>
                            <th>السعر</th>
                            <th>الخصم</th>
                            <th>النوع</th>
                            <th>المشتركين</th>
                           <th style="width:100px">الصورة</th>
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
@endcan


{{-- modal add --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة دورة </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                       

                            <div class="col-md-6">
                                <label>اسم الدورة </label>
                                <div class="form-group">
                                    <input type="text" name="name" id="name"  class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="study_id">اختر الدراسة</label>
                                    <select class="form-control" name="study_id" id="study_id">
                                        
                                        <?php $studys = \App\Models\TeacherStudy::where('teacher_id',Auth::guard('teachers')->user()->id)->
                                                orWhere('teacher_id',Auth::guard('teachers')->user()->parent)->pluck('study_id'); ?>
                                        <?php $studys = \App\Models\Study::whereIn('id',$studys)->get(); ?>

                                            <option selected>اختر الدراسة..</option>  
                                        @foreach($studys as $study)
                                            <option value="{{ $study->id }}">{{ $study->name }}</option>  
                                        @endforeach
                                    </select>
                                    <span id="study_id_error" class="text-danger"></span>
                                </div>
                                <div class="spinner-border" role="status" id="loading_solutions" style="display: none">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div> 

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">اختر نوع الدورة</label>
                                    <select class="form-control" name="type" id="type">
                                      
                                            <option selected disabled>اختر نوع الدورة..</option>  
                                            <option value="private">خاصة</option>  
                                            <option value="paid_public">مدفوع عام</option>  
                                            <option value="free">مجانية</option>  
                                   
                                    </select>
                                    <span id="type_error" class="text-danger"></span>
                                </div>
                            </div>

                         

                          


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level_id">اختر المرحلة</label>
                                    <select class="form-control" name="level_id" id="level_id">
                                    
                                    
                                    </select>
                                    <span id="level_id_error" class="text-danger"></span>
                                </div>
                            </div> 

                            <div class="col-md-3" id="price_div">
                                <label> السعر </label>
                                <div class="form-group">
                                    <input type="text" name="price" id="price" value="0"  class="form-control" />
                                    <span id="price_error" class="text-danger"></span>
                                </div>
                            </div>


                         
                            
                            <div class="col-md-3" id="discount_div">
                                <label> الخصم </label>
                                <div class="form-group">
                                    <input type="text" name="discount" value="0" id="discount"  class="form-control" />
                                    <span id="discount_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="subject_id">اختر المادة الدراسية</label>
                                    <select class="form-control" name="subject_id" id="subject_id">
                                    
                                    
                                    </select>
                                    <span id="subject_id_error" class="text-danger"></span>
                                </div>
                            </div> 


                            <div class="col-md-3" id="price_after_discount_div">
                                <label> السعر بعد الخصم </label>
                                <div class="form-group">
                                    <input type="text" name="" disabled id="price_after_discount"  class="form-control" />
                                    {{-- <span id="discount_error" class="text-danger"></span> --}}
                                </div>
                            </div>

                          

                            <div class="col-md-6">
                                <label> الوصف </label>
                                <div class="form-group">
                                    <textarea name="description" class="form-control" id="description" cols="30" rows="4"></textarea>
                                    <span id="description_error" class="text-danger"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>صورة الدورة </label>
                            </div>
                            <div class="media mb-2">
                                 <img src="{{ asset('upload.png') }}" alt="users avatar" id="image" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" /> 
                                 <div class="media-body mt-50">
                                     <div class="col-12 d-flex mt-1 px-0">
                                         <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                             <span class="d-none d-sm-block">Change</span>
                                                 <input class="form-control" type="file" multiple id="change-picture" name="image" hidden required accept="image/png, image/jpeg, image/jpg" />
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
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
                            <input type="hidden" name="id" id="id2">
                            <div class="col-md-6">
                                <label>اسم الدورة </label>
                                <div class="form-group">
                                    <input type="text" name="name" id="name2"  class="form-control" />
                                    <span id="name2_error" class="text-danger"></span>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="study_id">اختر الدراسة</label>
                                    <select class="form-control" name="study_id2" id="study_id2">
                                        <?php $studys = \App\Models\TeacherStudy::where('teacher_id',Auth::guard('teachers')->user()->id)->
                                        orWhere('teacher_id',Auth::guard('teachers')->user()->parent)->pluck('study_id'); ?>
                                <?php $studys = \App\Models\Study::whereIn('id',$studys)->get(); ?>
                                            <option selected>اختر الدراسة..</option>  
                                        @foreach($studys as $study)
                                            <option value="{{ $study->id }}">{{ $study->name }}</option>  
                                        @endforeach
                                    </select>
                                    <span id="study_id2_error" class="text-danger"></span>
                                </div>
                                <div class="spinner-border" role="status" id="loading_solutions2" style="display: none">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div> 

                        

                       
                          
                                
                                
                            <div class="col-md-6">
                                <label> السعر </label>
                                <div class="form-group">
                                    <input type="text" name="price" id="price2"  class="form-control" />
                                    <span id="price2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="level_id">اختر المرحلة</label>
                                    <select class="form-control" name="level_id2" id="level_id2">
                                    
                                    
                                    </select>
                                    <span id="level_id2_error" class="text-danger"></span>
                                </div>
                            </div> 


                            <div class="col-md-6">
                                <label> الخصم </label>
                                <div class="form-group">
                                    <input type="text" name="discount" id="discount2"  class="form-control" />
                                    <span id="discount2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="subject_id2">اختر المادة الدراسية</label>
                                    <select class="form-control" name="subject_id2" id="subject_id2">
                                    
                                    
                                    </select>
                                    <span id="subject_id_error" class="text-danger"></span>
                                </div>
                            </div> 




                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">اختر نوع الدورة</label>
                                    <select class="form-control" name="type" id="type2">
                                    
                                            <option selected disabled>اختر نوع الدورة..</option>  
                                            <option value="private">خاصة</option>  
                                            <option value="paid_public">مدفوع عام</option>  
                                            <option value="free">مجانية</option>  
                                   
                                    </select>
                                    <span id="type2_error" class="text-danger"></span>
                                </div>
                            </div>


                         


                     

                            <div class="col-md-6">
                                <label> الوصف </label>
                                <div class="form-group">
                                    <textarea name="description" id="description2" class="form-control" cols="30" rows="4"></textarea>
                                    <span id="description2_error" class="text-danger"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label>صورة الدورة  </label>
                             </div>
                             <div class="media mb-2">
                                 <img src="{{ asset('upload.png') }}" alt="users avatar" id="image2" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" /> 
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

{{--  disabled comments --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="disabled_comments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">ايقاف التعليقات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="disabled_comments_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                             هل انت متاكد من ايقاف التعليقات ؟
                            <input type="hidden" name="course_id" id='course_id_comm'>


                           
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" id="reload66114"  style="display:none" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            جاري التنفيذ ...
                        </button>
                        <button type="button"  id="update_users114" onclick="do_update14()" class="btn btn-primary">ايقاف</button>
                        <button type="button" id='edit_users_button3114' class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{--  disabled comments --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="disabled_comments2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تفعيل التعليقات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="disabled_comments_form2">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                             هل انت متاكد من تفعيل التعليقات ؟
                            <input type="hidden" name="course_id" id='course_id_comm2'>


                           
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="button" id="reload6611442"  style="display:none" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            جاري التنفيذ ...
                        </button>
                        <button type="button"  id="update_users1142" onclick="do_update142()" class="btn btn-primary">تفعيل</button>
                        <button type="button" id='edit_users_button31142' class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- has_ended_modal user --}}
<div class="modal fade modal-danger text-left" id="has_ended_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">انهاء الدورة  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="has_ended_form">
                    @csrf
                    <input type="hidden" name="id" id="id334">
                     هل انت متاكد من انهاء الدورة ؟    <br>
                     سيتيح للطلاب تقييم الكورس عند انتهائهم من الدروس
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete_user22" style="display: none" data-dismiss="modal">...يتم الانهاء</button>
                        <button type="button" class="btn btn-danger" onclick="has_ended_button()" id="delete_user_button2" data-dismiss="modal">انهاء</button>
                    </div>
                </form>
        </div>
    </div>
</div>



{{-- is post --}}
<div class="modal fade modal-success text-left" id="is_post_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">نشر الدورة  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="is_post_form">
                    @csrf
                    <input type="hidden" name="id" id="id34">
                    هل انت متاكد ان الدورة جاهزة للنشر ؟
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="delete_user23" style="display: none" data-dismiss="modal">...يتم النشر</button>
                        <button type="button" class="btn btn-success" onclick="is_post_click()" id="delete_user_button3" data-dismiss="modal">نشر</button>
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

        function start24(){
  
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'تم ايقاف التعليقات',
                showConfirmButton: false,
                timer: 3000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });

        }
            function start243(){

            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'تم تفعيل التعليقات',
                showConfirmButton: false,
                timer: 3000,
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
        function is_view0(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'info',
                title: 'تم اخفاء الدورة .. ستبقى الدورة ظاهرة عند الطلاب المشتركين في الدورة  ',
                showConfirmButton: false,
                timer: 2500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function is_view1(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'info',
                title: 'الدورة اصبحت ظاهرة في التطبيق لجميع المستخدمين',
                showConfirmButton: false,
                timer: 2500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function is_view04(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'info',
                title: 'تم اخفاء عدد المشتركين في تفاصيل الدورة بالتطبيق  ',
                showConfirmButton: false,
                timer: 2500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function is_view14(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'info',
                title: 'تم اظهار عدد المشتركين في تفاصيل الدورة بالتطبيق  ',
                showConfirmButton: false,
                timer: 2500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function is_post(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'سيتم نشر الدورة تلقائيا خلال اقل من 24 ساعة',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function has_endeed2(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: ' تم انهاء الدورة',
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
            ajax: "{{ route('teachers.get_all_courses') }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'         ,name: 'name'},
                {data: 'level_id'     ,name: 'level_id'},
                {data: 'sections'     ,name: 'sections'},
                {data: 'status'       ,name: 'status'},
                {data: 'is_view'       ,name: 'is_view'},
                {data: 'is_hidden_subscripe'       ,name: 'is_hidden_subscripe'},
                {data: 'rate'         ,name: 'rate'},
                {data: 'price'        ,name: 'price'},
                {data: 'discount'     ,name: 'discount'},
                {data: 'type'         ,name: 'type'},
                {data: 'subscriptions',name: 'subscriptions'},
                {data: 'image_100k'        ,name: 'image_100k'},

                {data: 'action'     ,  name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}


    <script>
     
        $(document).on('change', '#custom-switch', function (e) {
   
                   let id = $(this).data('id');
                 
                   $.ajax({
                       type: "post",
                       dataType: "json",
                       url: '{{ route('teachers.is_view_change') }}',
              
                    
                       data: {  
                                '_token':'{{ csrf_token() }}',
                               'id':id
                        },

                       success: function (data) {
                        if(data.is_view == 0){
                            $('#position-top-is_view0').click();
                            
                        }else{
                            
                            $('#position-top-is_view1').click();
                        }
                        
                       }
                   });
        
           });
      
       </script>
    <script>
     
        $(document).on('change', '#custom-switch_id', function (e) {
   
                   let id = $(this).data('id');
                 
                   $.ajax({
                       type: "post",
                       dataType: "json",
                       url: '{{ route('teachers.is_view_subscriper_change') }}',
              
                    
                       data: {  
                                '_token':'{{ csrf_token() }}',
                               'id':id
                        },

                       success: function (data) {
                        if(data.is_hidden_subscripe == 0){
                            $('#position-top-is_view04').click();
                            
                        }else{
                            
                            $('#position-top-is_view14').click();
                        }
                        
                       }
                   });
        
           });
      
       </script>

  
    {{-- open modal add user --}}
    <script>
        $('#modal_add').on('show.bs.modal', function(event) {
            $('#city').text('');
        
        })
</script>

<script>


    $(function() {
        $("#price, #discount").on("keydown keyup", sum);
            function sum() {
                  $("#price_after_discount").val(Number($("#price").val()) - Number($("#discount").val()));
            
             }
});

</script>


  
<script>
    $(document).ready(function(){
       $("#type").change(function(){
     
     
        if ( $(this).val() == "free" ) { 
    
            $("#discount_div").css("display", "none");
            $("#price_after_discount_div").css("display", "none");
            $("#price_div").css("display", "none");


            $("#discount").val("0");
            $("#price_after_discount").val("0");
            $("#price").val("0");
            
        }else{
            $("#discount_div").css("display", "block");
            $("#price_after_discount_div").css("display", "block");
            $("#price_div").css("display", "block");
            
        }
 
     });
   });
    

</script>

  <script>
        $('#disabled_comments').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id =           button.data('id')

            var modal = $(this)
            modal.find('.modal-body #course_id_comm').val(id);
    
        })
    </script>



    {{-- Send  --}}
    <script>
        function do_update14(){

            $("#update_users114").css("display", "none");
            $("#reload66114").css("display", "block");
            var formData = new FormData($('#disabled_comments_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.disabled_routs_comments_route')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#reload66114").css("display", "none");
                        $("#update_users114").css("display", "block");
                
                        $('.close').click();
                        if(data.status == 0){
                            $('#position-top-start243').click();
                        }else{
                            $('#position-top-start24').click();
                        }
                        
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                
                
                    }, error: function (reject) {
                    }
                });
        }
    </script>

<script>
    $('#disabled_comments2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id =           button.data('id')

        var modal = $(this)
        modal.find('#course_id_comm2').val(id);

    })
</script>

    {{-- Send  --}}
    <script>
        function do_update142(){

            $("#update_users1142").css("display", "none");
            $("#reload6611442").css("display", "block");
            var formData = new FormData($('#disabled_comments_form2')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.disabled_routs_comments_route')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#reload661142").css("display", "none");
                        $("#update_users1142").css("display", "block");
                
                        $('.close').click();
                        if(data.status == 0){
                            $('#position-top-start243').click();
                        }else{
                            $('#position-top-start24').click();
                        }
                        
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                
                
                    }, error: function (reject) {
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
            $('#name_error').text('');
            $('#level_id_error').text('');
            $('#description_error').text('');
            $('#price_error').text('');
            $('#discount_error').text('');
            $('#type_error').text('');
            $('#image_error').text('');
   
       
            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.store_courses')}}",
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
                            $('#level_id').val('');
                            $('#description').val('');
                            $('#price').val('');
                            $('#discount').val('');
                            $('#type').val('');
                            $('#image').val('');
                 
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

    {{-- selected levels --}}
        <script>
            $(document).ready(function() {
                $('select[name="study_id"]').on('change', function() {
                
                    $("#loading_solutions").css("display", "block");
                    $("#loading_solutions2").css("display", "block");

                    var id = $(this).val();
                    if (id) {
                        $.ajax({
                            url: "{{ URL::to('teachers/get_levels_in_form_add') }}/" + id,
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


    {{-- selected levels edit --}}
        <script>
            $(document).ready(function() {
                $('select[name="study_id2"]').on('change', function() {
                
                    $("#loading_solutions").css("display", "block");
                    $("#loading_solutions2").css("display", "block");

                    var id = $(this).val();
                    if (id) {
                        $.ajax({
                            url: "{{ URL::to('teachers/get_levels_in_form_add') }}/" + id,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {

                                $("#loading_solutions").css("display", "none");
                                $("#loading_solutions2").css("display", "none");
                        

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


    {{-- selected level_id --}}
        <script>
            $(document).ready(function() {
                $('select[name="level_id"]').on('change', function() {
                
                    $("#loading_solutions").css("display", "block");
                    $("#loading_solutions2").css("display", "block");

                    var id = $(this).val();
                    if (id) {
                        $.ajax({
                            url: "{{ URL::to('teachers/get_sujects_from_level') }}/" + id,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {

                                $("#loading_solutions").css("display", "none");
                                $("#loading_solutions2").css("display", "none");
                        

                                    $('select[name="subject_id"]').empty();
                                    $('select[name="subject_id"]').append('<option selected disabled selected>اختر المادة الدراسية..</option>');
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



    {{-- selected level_id --}}
        <script>
            $(document).ready(function() {
                $('select[name="level_id2"]').on('change', function() {
                
                    $("#loading_solutions").css("display", "block");
                    $("#loading_solutions2").css("display", "block");
                    $("#loading_solutions3").css("display", "block");

                    var id = $(this).val();
                    if (id) {
                        $.ajax({
                            url: "{{ URL::to('teachers/get_sujects_from_level') }}/" + id,
                            type: "GET",
                            dataType: "json",
                            success: function(data) {

                                $("#loading_solutions").css("display", "none");
                                $("#loading_solutions2").css("display", "none");
                                $("#loading_solutions3").css("display", "none");
                        

                                    $('select[name="subject_id2"]').empty();
                                    $('select[name="subject_id2"]').append('<option selected disabled selected>اختر المادة الدراسية..</option>');
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





    {{-- edit user --}}
    <script>
        $('#edit_user').on('show.bs.modal', function(event) {
        
   
            var button = $(event.relatedTarget)
            var id =                  button.data('id')
            var name =                button.data('name')
            var level_id =                button.data('level_id')
            var description =                button.data('description')
            var discount =                button.data('discount')
            var price =                button.data('price')
            var image_100k =                button.data('image_100k')
            var type =                button.data('type')
            var is_show =                button.data('is_show')

            
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #level_id2').val(level_id);
            modal.find('.modal-body #description2').val(description);
            modal.find('.modal-body #discount2').val(discount);
            modal.find('.modal-body #price2').val(price);
            $(".modal-body #image2").attr('src', image_100k);
            modal.find('.modal-body #type2').val(type);


            // الدورات المقبولة لازم ما يعدل السعر او النوع
            if(is_show == "not_show"){
                $("#discount2").css('display', 'none');
                $("#price2").css('display', 'none');
                $("#type2").css('display', 'none');
            }else{
                $("#discount2").css('display', 'block');
                $("#price2").css('display', 'block');
                $("#type2").css('display', 'block');
            }

  
        })
    </script>


   {{-- update user --}}
   <script>
        function do_update(){
        
            $('#name2_error').text('');
            $('#level_id2_error').text('');
            $('#description2_error').text('');
            $('#price2_error').text('');
            $('#discount2_error').text('');
            $('#type2_error').text('');
            $('#image2_error').text('');

            
            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#edit_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.update_courses')}}",
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
                url: "{{route('teachers.destroy_courses')}}",
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


    {{-- fill is post modal --}}
    <script>
        $('#is_post_modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id34').val(id);
        })
    </script>


  {{-- is post user--}}
  <script>
    function is_post_click(){

        $("#delete_user_button3").css("display", "none");
        $("#delete_user23").css("display", "block");
        var formData = new FormData($('#is_post_form')[0]);
        $.ajax({
            type: 'post',
            url: "{{route('teachers.is_post_route')}}",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#delete_user23").css("display", "none");
                $("#delete_user_button3").css("display", "block");
                $('#position-top-is_post').click();
                // $('.close').click();
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
            
            }, error: function (reject) {
            }
        });
     }
</script>




    {{-- fill has_ended_modal2 --}}
    <script>
        $('#has_ended_modal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id334').val(id);
        })
    </script>


  {{-- has_ended_modal2--}}
  <script>
    function has_ended_button(){

        $("#delete_user_button2").css("display", "none");
        $("#delete_user22").css("display", "block");
        var formData = new FormData($('#has_ended_form')[0]);
        $.ajax({
            type: 'post',
            url: "{{route('teachers.has_ended_route')}}",
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                $("#delete_user22").css("display", "none");
                $("#delete_user_button2").css("display", "block");
                $('#position-top-has_endeed').click();
                // $('.close').click();
                $('.yajra-datatable').DataTable().ajax.reload(null, false);
            
            }, error: function (reject) {
            }
        });
     }
</script>


@endsection