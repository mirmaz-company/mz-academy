
@extends('layouts.main_page')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">
    <link href="{{ asset('filepnde.css') }}" rel="stylesheet" />




    <style>
        .progress {
           height: 32px;
        }

        a.btn {
          margin-bottom: 2px;
        }
    </style>
   
   


@endsection


@section('content')


 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="not_posi2()" id="position-top-not_posi"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="start24()" id="position-top-start24"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="start243()" id="position-top-start243"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="add_suc2()" id="position-top-add_suc"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="add_suc233()" id="position-top-start2"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="date3()" id="position-top-date"></button> 
 <button class="btn btn-outline-primary" style="display: none" onclick="date3333()" id="position-top-start44442"></button> 



     
<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   {{ trans('main_trans.main_page') }} </a>
        </li>
        @if(isset($id))
        <?php $sections = \App\Models\Section::where('id',$id)->first(); ?>
        @if($sections)
            <li class="breadcrumb-item"><a href="#">الدروس .____. {{ $sections->name }} </a>
            </li>
        @endif
    @else
        <li class="breadcrumb-item"><a href="#">الدروس </a>
        </li>
    @endif
    </ol>
</div>


@can("اضافة درس")
<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">{{ trans('main_trans.add') }}</a> 
@endcan

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>
                                
                            <th>#</th>
                            <th>اسم الدرس</th>
                            <th> النوع</th>
                            <th> الفصل</th>
                            <th> الدورة</th>
                            @can('الاختبارات')
                            <th> الاختبارات</th>
                            @endcan
                            <th> المشاهدات</th>
                            <th> حالة الدرس</th>
                            <th> نوع الدورة</th>
                            @can("التعليقات")
                              <th>التعليقات</th>
                            @endcan
                            <th>العمليات</th>
                            @if(isset($id))
                            <th>ترتيب المحاضرة</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody id="sortable-list">
                 
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
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة درس </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form" class="invoice-repeater">
                    @csrf
                    <div class="modal-body cj4">
                        <div class="row">
                       

                            @if(isset($id))
                                <input type="hidden" name="is_there_id" value="ff">

                                <?php $section = \App\Models\Section::where('id',$id)->first(); ?>
                                <input type="hidden" name="course_id" value="{{ $section->course_id }}">
                                <input type="hidden" name="section_id" value="{{ $id }}">

                                <div class="col-md-6">
                                    <label>الاسم  </label>
                                    <div class="form-group">
                                        <input type="text" name="name" id="name"  class="form-control" />
                                        <span id="name_error" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1" id="type_video_lable">اختر طريقة رفع الفيديو</label>
                                        <select class="form-control" name="type_video" id="type_videoo">
                                            <?php $courses = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->get(); ?>
                                                
                                            
                                                
                                                <option value="{{ $teacher_vdo_buuny }}">رفع الدرس بشكل مباشر</option>  
                                                <option value="YouTube">YouTube (ارفاق رابط يوتيوب)</option>
                                                @if( $teacher_vdo_buuny == 'resolutions')  
                                                     <option value="import_youtube">YouTube (استيراد من اليوتيوب)</option>  
                                                @endif
                                            
                                                
                                        
                                        </select>
                                        <span id="course_id_error" class="text-danger"></span>
                                    </div>
                                </div> 
                            @else

                            <div class="col-md-5">
                                <label>الاسم  </label>
                                <div class="form-group">
                                    <input type="text" name="name" id="name"  class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1" id="type_video_lable">اختر طريقة رفع الفيديو</label>
                                    <select class="form-control" name="type_video" id="type_videoo">
                                        <?php $courses = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->get(); ?>
                                           
                                      
                                         
                                            <option value="{{ $teacher_vdo_buuny }}">رفع الدرس بشكل مباشر</option>  
                                            <option value="YouTube">YouTube (ارفاق رابط يوتيوب)</option>  
                                            @if( $teacher_vdo_buuny == 'resolutions')  
                                            <option value="import_youtube">YouTube (استيراد من اليوتيوب)</option>  
                                            @endif
                                      
                                         
                                    
                                    </select>
                                    <span id="course_id_error" class="text-danger"></span>
                                </div>
                            </div> 

                            @endif


                            @if(!isset($id))
                            <div data-repeater-list="all_courses" class="col-md-12">
                                <div data-repeater-item>
                                    <div class="row">
                                        <div class="col-md-5">
                                     
                                        <?php $courses = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->orWhere('teacher_id',Auth::guard('teachers')->user()->parent)->get(); ?>
                                            <label>اختر الدورة</label>
                                            <div class="form-group">
                                                <select class="form-control course_id_repeater" name="all_courses[][course_id_repeater]" id="all_courses">
                                                    <option selected disabled>اختر الدورة..</option>  
                                                    @foreach($courses as $course)
                                                    <option value="{{ $course->id }}">{{ $course->name }}</option>  
                                                @endforeach
                                                </select>
                                            </div>
                                            <span id="all_courses_error" class="text-danger"></span>
                                        </div>
                            
                                        <div class="col-md-5">
                                            <label>الفصول</label>
                                            <div class="form-group">
                                                <select class="form-control id_form" name="all_sections[][section_id_repeater]" id="exampleFormControlSelect2">
                                                </select>
                                            </div>
                                        </div>
                            
                                        <div class="col-md-2 mb-50">
                                            <label style="color:white">.</label>
                                            <div class="form-group">
                                                <button class="btn btn-outline-danger btn-sm text-nowrap px-1" data-repeater-delete type="button">
                                                    <i data-feather="x" class="mr-25"></i>
                                                    <span>حذف</span>
                                                </button>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button class="btn btn-icon btn-sm btn-primary" id="add_button_blus" type="button" data-repeater-create>
                                        <i class="fa fa-plus"></i>
                                        <span>اضافة لدورة اخرى </span>
                                    </button>
                                </div>
                            </div>

                            @endif
                            <br>
                         

                            @if(!isset($id))

                              
                                    <div class="col-md-5" style="margin-top: 3.7%;">
                                        <label>نوع الدرس  </label>
                                        <div class="form-group">
                                            <select class="form-control" name="type" id="type">
                                                <?php $courses = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->get(); ?>
                                                    {{-- <option selected disabled>اختر النوع..</option>   --}}
                                         
                                                    <option value="unvisable" selected>مدفوع</option>  
                                                    <option value="visable">معاينة مجانية</option>  
                                          
                                               
                                            </select>
                                            <span id="type_error" class="text-danger"></span>
                                        </div>
                                    </div>
                
                           
                                

                            @else
                                    <?php $course = \App\Models\Section::where('id',$id)->pluck('course_id')->first(); ?>
                                    <?php $type_course = \App\Models\Course::where('id',$course)->pluck('type')->first(); ?>
                                <div class="col-md-6" style="margin-top: 3.7%;">
                                    <label>نوع الدرس  </label>
                                    <div class="form-group">
                                        <select class="form-control" name="type" id="type">
                                            <?php $courses = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->get(); ?>

                                            @if($type_course == 'free')

                                                 <option value="visable">معاينة مجانية</option>  

                                            @else

                                                <option selected disabled>اختر النوع..</option>  
                                                <option value="unvisable">مدفوع (للطلاب المشتركين فقط)</option>  
                                                <option value="visable">معاينة مجانية</option>  

                                            @endif
                                              
                                   
                                        
                                        </select>
                                        <span id="type_error" class="text-danger"></span>
                                    </div>
                                </div>

                            
                           
                                       
                                    
                                        <span id="section_id_error" class="text-danger"></span>
                               

                            @endif
                            @if(isset($id))
                                <?php $course = \App\Models\Section::where('id',$id)->pluck('course_id')->first(); ?>
                                <?php $type_course = \App\Models\Course::where('id',$course)->pluck('type')->first(); ?>
                            @endif
                   
                        <div class="col-md-3">
                            <a onclick="schec_true()" class="btn btn-sm btn-primary" id="id_schec_true" >جدولة الدرس </a> 
                            <a onclick="schec_false()" class="btn btn-sm btn-primary" style="display:none" id="id_schec_false" > الغاء الجدولة </a> 
                            <div>
                                <div class="form-group" id="div_date" style="display:none">
                                    <label> التاريخ </label>
                                 
                                    <input type="date" class="form-control" id="date" name="date">
                                    <span id="date_error" class="text-danger"></span>
                                </div>
                            </div>
                           
                        </div>
                        <div class="col-md-3" id="div_from_date"  style="display:none">
                            <label for="" style="color:white">.</label> <br>
                            <label> الوقت </label>
                            <div class="form-group">
                                <input type="time" placeholder="form_date" name="form_date" id="form_date"  class="form-control" />
                                <span id="form_date_error" class="text-danger"></span>
                            </div>
                        </div>


                        @if( Auth::guard('teachers')->user()->id == 169 || Auth::guard('teachers')->user()->parent == 1)
                            <div class="col-md-5">
                                <label>الوقت المستقطع بالثواني (اختياري)</label>
                                <div class="form-group">
                                    <input type="number" placeholder="5" name="second_cut"  class="form-control" />
                                    <span id="second_cut_error" class="text-danger"></span>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <label>الوصف  </label>
                                <div class="form-group">
                                    <textarea name="descriptions" class="form-control" id="descriptions" cols="30" rows="4"></textarea>
                                    <span id="descriptions_error" class="text-danger"></span>
                                </div>
                            </div>
                        @else
                            <div class="col-md-12">
                                <label>الوصف  </label>
                                <div class="form-group">
                                    <textarea name="descriptions" class="form-control" id="descriptions" cols="30" rows="4"></textarea>
                                    <span id="descriptions_error" class="text-danger"></span>
                                </div>
                            </div>
                        @endif
                    </div>

                   
                        {{-- هاد بخزن فيه رابط الفيميو بعد ما ارفع الفيديو --}}
                        {{-- <input type="hidden" id="link_vimeo_upload_id"> --}}

                        {{-- هاد بخزن فيه اسم الدرس بعد م اضيف الدرس عندي على الداتا بيز عشان امرروا على لل filepond --}}
                        <input type="hidden" id="name_bunny">
                        <input type="hidden" id="name_teacher_bunny">
                        <input type="hidden" id="id_bunny" value="">
                        <input type="hidden" id="second_cut">
                        <input type="hidden" id="video_id">
                        <input type="hidden" id="type_video">
                        <input type="hidden" id="id_folder_vdosipher">

                      
                        
                        {{-- <div class="col-md-12" id="bunny_lesson">
                            <div id="uplode_video" style="display: none">
                            
                                <label>رفع الدرس  </label> --}}
                                {{-- <input type="file" name="video_vimeo" id="my-pond5" class="my-pond" name="filepond"/> --}}


                                {{-- <input type="file" name="video_bunny" id="my-pond5" class="my-pond"/> --}}
                         
    
                            {{-- </div>
                        </div> --}}

                    
                        <div class="col-md-12" id="link33" style="display: none">
                        
                                <label>اضافة رابط يوتيوب</label>
             
                                <input type="link" class="form-control" name="link" id="link" />
                         
                        </div>
                       
                        
                    
                
                    
                      
                    </div>

                    @if(isset($id))
                        @if($type_course != 'free')
                            <div class="modal-footer" style="display: block" id="uplo_video">
                                <span style="color:red">
                                    اقصى حجم فيديو يمكن رفعه هو 1GB
                                </span>
                                <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block"> يتم جلب البيانات  ...</button>
                                <button type="button" id="add_user" class="btn btn-primary btn-block">
                                   
                                    رفع فيديو 
                                </button>
                            </div>
                            <div class="modal-footer" style="display: none" id="add_vid">
                                <button type="button" style="display: none" id="add_user24" class="btn btn-primary btn-block"> يتم  الاضافة  ...</button>
                                <button type="button" id="add_user4" class="btn btn-primary btn-block"> اضافة درس</button>
                            </div>
                        @else
                            <div class="modal-footer" style="display: none" id="add_vid">
                                <button type="button" style="display: none" id="add_user24" class="btn btn-primary btn-block"> يتم  الاضافة  ...</button>
                                <button type="button" id="add_user4" class="btn btn-primary btn-block"> اضافة درس</button>
                            </div>
                        @endif
                    @else

                        <div class="modal-footer" style="display: block" id="uplo_video">
                            <span style="color:red">
                               اقصى حجم فيديو يمكن رفعه هو 1GB
                            </span>
                            <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block"> يتم جلب البيانات  ...</button>
                            <button type="button" id="add_user" class="btn btn-primary btn-block"> رفع فيديو

                            </button>
                        </div>
                        <div class="modal-footer" style="display: none" id="add_vid">
                            <button type="button" style="display: none" id="add_user24" class="btn btn-primary btn-block"> يتم  الاضافة  ...</button>
                            <button type="button" id="add_user4" class="btn btn-primary btn-block"> اضافة درس</button>
                        </div>

                    @endif
                </form>

                <div class="card-body" style="display: none" id="card-bumber">
                 


                    <br />
                    <br />
                    <div class="row">
                       
                        <h3>اختر الفيديو </h3>
                        <div class="col-md-12">
                            <input type="file" accept="video/*"> 
                        </div>
                  
                        <div class="col-md-12" style="position:relative;display:none" id="button-node">
                            <div class="span4">
                                <button class="btn btn-primary stop" id="toggle-btn" style="margin-top:2%">start upload</button> <br>
                                <div class="progress progress-striped progress-success" style="margin-top:2%">
                                    <div class="progress-bar"  style="width: 0%;"></div>
                                </div>
                            </div>
                        </div>
                  
                     
                </div>

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
                            <input type="hidden" name="id" id="id2">
                            <div class="col-md-12">
                                <label>الاسم  </label>
                                <div class="form-group">
                                    <input type="text" name="name" id="name2"  class="form-control" />
                                    <span id="name2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>الوصف  </label>
                                <div class="form-group">
                                    <textarea name="descriptions" class="form-control" id="descriptions2" cols="30" rows="4"></textarea>
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>


                           

                            <div class="col-md-12" id="link_show" style="display: none">
                                <label>الرابط  </label>
                                <div class="form-group">
                                    <input type="text" name="link" id="link2"  class="form-control" />
                                    <span id="link2_error" class="text-danger"></span>
                                </div>
                            </div>


                            <div class="col-md-12">
                                <label>النوع  </label>
                                <div class="form-group">
                                    <select class="form-control" name="type" id="type2">
                                        <?php $courses = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->get(); ?>
                                            <option selected disabled>اختر النوع..</option>  
                                 
                                            <option value="visable">معاينة مجانية</option>  
                                            <option value="unvisable">مدفوع</option>  
                                          
                                       
                                    </select>
                                    <span id="type2_error" class="text-danger"></span>
                                </div>
                            </div>


                            @if(!isset($id))
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">اختر الدورة</label>
                                        <select class="form-control" name="course_id" id="course_id2">
                                            <?php $courses = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->get(); ?>
                                                <option selected disabled>اختر الدورة..</option>  
                                            @foreach($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>  
                                            @endforeach
                                        </select>
                                        <span id="course_id2_error" class="text-danger"></span>
                                    </div>
                                </div> 

                                <div class="spinner-border" role="status" id="loading_solutions2" style="display: none">
                                    <span class="sr-only">Loading...</span>
                                </div>


                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">اختر الفصل</label>
                                        <select class="form-control" name="section_id" id="section_id2">
                                        
                                        
                                        </select>
                                        <span id="section_id2_error" class="text-danger"></span>
                                    </div>
                                </div> 
                            @endif
                            
                        
                    
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


{{-- views  --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="views_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title" id="myModalLabel33">عرض المشاهدات  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                
                <section id="basic-datatable2">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <table class="datatables-basic table table-responsive-md yajra-datatable3">
                                    <thead>
                                        <tr>
                                                
                                            <th>#</th>
                                            <th>اسم الطالب</th>
                                            <th style="width:100px">الصورة </th>
                                        
                                            
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
        </div>
    </div>
</div>



{{-- add_lesson_to_another_section --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="add_lesson_to_another_section" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة الدرس الى قسم اخر  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_lesson_to_another_section_form">
                    @csrf
                    <div class="modal-body">
                       الدرس: <h3 id="name_lesson"></h3><br>
                      الفصل:  <h3 id="name_section"></h3><br>
                       الدورة <h3 id="name_course"></h3> <br> <br><br>

                       <h5>اختر الفصل الذي تريد  اضافة الدرس اليه</h5>
                       <input type="hidden" name="id" id="id23">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">اختر الدورة</label>
                                    <select class="form-control" name="course_id3" id="exampleFormControlSelect1">
                                        <?php $courses = \App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->get(); ?>
                                            <option selected disabled>اختر الدورة..</option>  
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}">{{ $course->name }}</option>  
                                        @endforeach
                                    </select>
                                    <span id="course_id3_error" class="text-danger"></span>
                                </div>
                            </div> 


                            <div class="col-md-6">
                                <div class="spinner-border" role="status" id="loading_solutions3" style="display: none">
                                    <span class="sr-only">Loading...</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlSelect1">اختر الفصل</label>
                                    <select class="form-control" name="section_id3" id="section_id3">
                                    
                                    
                                    </select>
                                    <span id="section_id3_error" class="text-danger"></span>
                                </div>
                            </div> 


                           

<div class="col-md-6">
                            <a onclick="schec_section_true()" class="btn btn-sm btn-primary" id="id_schec_true_section" >جدولة الدرس </a> 
                            <a onclick="schec_section_false()" class="btn btn-sm btn-primary" style="display:none" id="id_schec_false_section" > الغاء الجدولة </a> 
                            <div>
                                <div class="form-group" id="div_date_section" style="display:none">
                                    <label> التاريخ </label>
                                 
                                    <input type="date" class="form-control" id="date_section" name="date">
                                    <span id="date_error" class="text-danger"></span>
                                </div>
                            </div>
                           
                        </div> 
                        
                        <div class="col-md-6" id="div_from_date_section"  style="display:none">
                            <label for="" style="color:white">.</label> <br>
                            <label> الوقت </label>
                            <div class="form-group">
                                <input type="time" placeholder="form_date" name="form_date" id="form_date_section"  class="form-control" />
                                <span id="form_date_error" class="text-danger"></span>
                            </div>
                        </div>

                    
                        </div>
                      
                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing23" class="btn btn-primary btn-block"> يتم اضافة الدرس الى قسم اخر ...</button>
                        <button type="button" id="editing3" onclick="add_lesson_to_section_button()" class="btn btn-primary btn-block">اضافة</button>
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
                            ارسال اشعار لدرس لكافة المشتركين في الدورة
                            <input type="hidden" name="sendnotifi" id='idnot12'>


                           
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
                            <input type="hidden" name="lesson_id" id='lesson_id_comm'>


                           
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
                            <input type="hidden" name="lesson_id" id='lesson_id_comm2'>


                           
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


{{-- add_attachments --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="add_attachments" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة مرفقات</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <form id="add_attachments_form">
                            @csrf
                            <div class="modal-body">
                          
                           
                            <input type="hidden" name="id" id="id233">
                            <label for="">اسم الملف</label>
                            <input type="text" class="form-control" name="name_file" id="name_file"> <br>
                            <span id="name_file_error" class="text-danger"></span>

                            <label for=""> نوع الملف</label>
                            <select class="form-control" name="type_file" id="type_file">
                            
                                <option selected disabled>اختر نوع الملف..</option>  
                
                                <option value="file">PDF</option>  
                                <option value="image">صورة</option>  
                                
                            </select>
                            <span id="type_file_error" class="text-danger"></span> <br>
                       

        
        
                            <div class="form-group">
                                <label> اختر الملف </label>
                             </div>
                                <div class="media mb-2">
                                    <img src="{{ asset('upload.png') }}" alt="users avatar" id="image" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" /> 
                                    <div class="media-body mt-50">
                                        <div class="col-12 d-flex mt-1 px-0">
                                            <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                                <span class="d-none d-sm-block">Change</span>
                                                    <input class="form-control" type="file" multiple id="change-picture" name="image" hidden required accept="image/png, image/jpeg, image/jpg,application/pdf" />
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
                            <div class="modal-footer">
                                <button type="button" style="display: none" id="editing233" class="btn btn-primary btn-block"> يتم اضافة   ...</button>
                                <button type="button" id="editing33" onclick="add_attachment_button()" class="btn btn-primary btn-block">اضافة</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8">
                        <section id="basic-datatable">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <table class="datatables-basic table table-responsive-md yajra-datatable2">
                                            <thead>
                                                <tr>
                                                        
                                                    <th>#</th>
                                                    <th>اسم الملف</th>
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
                    </div>
                </div>

            


           

            </div>
        </div>
    </div>
</div>






{{-- delete attachment --}}
<div class="modal fade modal-danger text-left" id="delete_attachmetn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">حذف  </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="delte_attachment_form">
                    @csrf
                    <input type="hidden" name="id" id="id33">
                     هل انت متأكد من عملية الحذف ؟    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete_user2f" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                        <button type="button" class="btn btn-danger" onclick="do_delete_attachment()" id="delete_user_buttonf" data-dismiss="modal">تأكيد</button>
                    </div>
                </form>
        </div>
    </div>
</div>



 @endsection


@section('js')
    

    <script src="https://cdn.jsdelivr.net/npm/tus-js-client@latest/dist/tus.min.js"></script>
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
    <script src="{{asset('app-assets/js/scripts/forms/form-repeater.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/forms/repeater/jquery.repeater.min.js')}}"></script>



    {{-- pondfile --}}
    <script src="{{ asset('filepondsize.js') }}"></script>
    <script src="{{ asset("filepond.js") }}"></script>

   
    <script src="https://cdn.jsdelivr.net/npm/resumablejs@1.1.0/resumable.min.js"></script>


    {{-- upload resumable --}}
    <script type="text/javascript">
  
    
    
      
        
   
    
     function add_video($cancel){

        let browseFile = $('#browseFile');

        var m =  $("#name_bunny").val();
        var id = $("#id_bunny").val();
        var name_teacher =  $("#name_teacher_bunny").val();

        let resumable = new Resumable({
            target: '{{ url("/teachers/upload_bu",'') }}' + '/' + m +'/'+id+'/'+name_teacher,
            query:{_token:'{{ csrf_token() }}'} ,// CSRF token
            fileType: ['mp4','m4v','mov','flv','aac'],
            headers: {
                'Accept' : 'application/json'
            },
            testChunks: false,
            throttleProgressCallbacks: 1,
            maxChunkRetries: undefined,
            chunkRetryInterval: 10000,
            maxFileSize :500000000,
            fileType: ['mp4','m4v','mov','flv','aac','mpe','mpeg','mpeg4','mpg','.mts','nsv','wmv','avi','dat','divx','dv'],
           

        }
        );
    
        resumable.assignBrowse(browseFile[0]);

   
    
        resumable.on('fileAdded', function (file) { // trigger when file picked
            $("#cancel-upload-btn").css("display", "block");
            showProgress();
            $("#cancel-upload-btn").html(" الغاء عملية الرفع ");
            $("#uploading").css("display", "block");
            $("#pause-upload-btn").css("display", "block");
            $("#upload-container").css("display", "none");
            $("#pause_div").css("display", "block");
            $("#cancel_div").css("display", "block");
            resumable.upload() // to actually start uploading.
            
        });
    
        resumable.on('fileProgress', function (file) { // trigger when file progress update
            updateProgress(Math.floor(file.progress() * 100));
          
        });
    
        resumable.on('fileSuccess', function (file, response) { // trigger when file upload complete

            $("#card-bumber").css("display", "none");
            $('.close').click();
            $('#position-top-start').click();
            // $('.yajra-datatable').DataTable().ajax.reload(null, false);
            $("#type_videoo").removeAttr("disabled");
            $("#add_user2").css("display", "none");
            $("#add_user").css("display", "block");
            location.reload();
         
                        
        });

        $('#pause-upload-btn').click(function(){
            if (resumable.files.length>0) {
                if (resumable.isUploading()) {
                 
                    $("#uploading").css("display", "none");
                    $("#pause-upload-btn").html("اكمال عملية الرفع");
                    return  resumable.pause();
                }
              
                $("#uploading").css("display", "block");
                $("#pause-upload-btn").html(" ايقاف مؤقت ");
                return resumable.upload();
            }
        });


        $('#cancel-upload-btn').click(function(){
            if (resumable.files.length>0) {
                if (resumable.isUploading()) {
                   
                    $("#cancel-upload-btn").html(" تم الغاء عملية الرفع");
                    $("#uploading").css("display", "none");
                    $("#pause-upload-btn").css("display", "none");
                    let progress = $('.progress');
                    $("#upload-container").css("display", "block");
                    progress.hide();
               
                    return  resumable.cancel();
                 }
                 
              
            }
        });
    
        resumable.on('fileRetry', function (file, response) { // trigger when there is any error
            console.log('retry');
        });

      
    
    
        let progress = $('.progress');
        function showProgress() {
            progress.find('.progress-bar').css('width', '0%');
            progress.find('.progress-bar').html('0%');
            progress.find('.progress-bar').removeClass('bg-success');
            progress.show();
        }
    
        function updateProgress(value) {
            if(value == 99){
                $("#cancel-upload-btn").css("display", "none");
                $("#pause-upload-btn").css("display", "none");
                $("#span_upload").html("  يتم تشفير الفيديو..سيتم اضافة الدرس تلقائيا بعد الانتهاء من عملية التشفير.. ");
                value = 'يتم تشفير الفيديو';
            }
            progress.find('.progress-bar').css('width', `${value}%`)
            progress.find('.progress-bar').html(`${value}`)
        }
    
        function hideProgress() {
            progress.hide();
        }
    }
    </script> 

    {{-- selected sections --}}
<script>
    $(document).ready(function() {
        $(document).on('change', '.course_id_repeater', function() {

            var id = $(this).val();
            var relatedSelect = $(this).closest('.row').find('.id_form');

            relatedSelect.append('<option selected>جاري جلب البيانات .. </option>');

            if (id) {
                $.ajax({
                    url: "{{ URL::to('teachers/get_sections_from_course') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        relatedSelect.empty();

                        if(data.get_sections_from_course.length == 0){
                            relatedSelect.append('<option selected value="nothing_0">  لا يوجد .. </option>');
                        }else{
                            for (var i = 0; i < data.get_sections_from_course.length; i++){
                                relatedSelect.append('<option value="' +
                                data.get_sections_from_course[i].id + '">' + data.get_sections_from_course[i].name+ '</option>');
                              }
                        }
                    },
                    error: function (reject) {
                        relatedSelect.empty();
                    }
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>


        {{-- upload resumable --}}
        <script>

            function add_video(){

                var id = $("#id_bunny").val();
                var second_cut = $("#second_cut").val();
               
                var video_id = $("#video_id").val();
                var id_folder_vdosipher = $("#id_folder_vdosipher").val();
                var type_video = $("#type_video").val();

                'use strict'

                let upload = null
                let uploadIsRunning = false
                const toggleBtn = document.querySelector('#toggle-btn')
                const input = document.querySelector('input[type=file]')
                const progress = document.querySelector('.progress')
                const progressBar = progress.querySelector('.progress-bar')
                const alertBox = document.querySelector('#support-alert')
          

                function reset() {
                input.value = ''
                toggleBtn.textContent = 'start upload'
                upload = null
                uploadIsRunning = false
                }

                function askToResumeUpload(previousUploads, currentUpload) {
                if (previousUploads.length === 0) return

                let text = 'You tried to upload this file previously at these times:\n\n'
                previousUploads.forEach((previousUpload, index) => {
                    text += `[${index}] ${previousUpload.creationTime}\n`
                })
                text +=
                    '\nEnter the corresponding number to resume an upload or press Cancel to start a new upload'

                const answer = prompt(text)
                const index = parseInt(answer, 10)

                if (!Number.isNaN(index) && previousUploads[index]) {
                    currentUpload.resumeFromPreviousUpload(previousUploads[index])
                }
                }

                function startUpload() {

                        $("#button-node").css("display", "block");

                        $.ajax({
                            type: 'post',
                            url: "{{route('teachers.update_status_laravel')}}",
                            data:{
                                _token:'{{ csrf_token() }}',
                                lesson_id: id,
                            },
                            success: function (data) {
                             
                                console.log('done');
                            
                            }, error: function (reject) {
                                console.log('error');
                            }
                        });
                  
                        const file = input.files[0]
                        // Only continue if a file has actually been selected.
                        // IE will trigger a change event even if we reset the input element
                        // using reset() and we do not want to blow up later.
                        if (!file) {
                            return
                        }

              
            

                toggleBtn.textContent = 'pause upload'


                @if(Auth::guard('teachers')->user()->parent == 0)

                      var teacherKey = "{{ Auth::guard('teachers')->user()->access_key }}";
                      var library_id = "{{  Auth::guard('teachers')->user()->library_id }}";
                      var type = "{{  Auth::guard('teachers')->user()->vdociper_or_bunny }}";

                @else

                    @php $teacher = \App\Models\Teacher::find(Auth::guard('teachers')->user()->parent); @endphp
                   

                    var teacherKey = "{{ $teacher->access_key }}";
                    var library_id = "{{ $teacher->library_id }}";
                    var type = "{{  Auth::guard('teachers')->user()->vdociper_or_bunny }}";

                @endif

                // ضرب هاد الريكويست واخد منو ال id
                // https://hls-video.fly.dev/api/createVideo  key => header

               

                const options = {
                    
                    @if(Auth::guard('teachers')->user()->parent == 0)
                        @if( Auth::guard('teachers')->user()->vdociper_or_bunny == 'resolutions')
                            endpoint:  "https://hls-stream.fly.dev/files",
                        @else
                            endpoint: "https://upload-test.fly.dev/files/",
                        @endif
                    @else
                        @php $teacher = \App\Models\Teacher::where('id',Auth::guard('teachers')->user()->parent)->first(); @endphp

                        @if( $teacher->vdociper_or_bunny == 'resolutions')
                            endpoint:  "https://hls-stream.fly.dev/files",
                        @else
                            endpoint: "https://upload-test.fly.dev/files/",
                        @endif

                    @endif
                   
                    
                    chunkSize: 5000000,
                    parallelUploads: 1,
                    metadata: {
                    filename: file.name,
                    filetype: file.type,
                    "video-id" : video_id,
                    @if(Auth::guard('teachers')->user()->parent == 0)
                        @if( Auth::guard('teachers')->user()->vdociper_or_bunny == 'resolutions')
                            key: '56c16dcc-391c-444f-9482-9be00204f097',
                        @else
                            key: teacherKey,
                            duration : second_cut ?? 0,
                        @endif
                    @else
                        @php $teacher = \App\Models\Teacher::where('id',Auth::guard('teachers')->user()->parent)->first(); @endphp
                        @if( $teacher->vdociper_or_bunny == 'resolutions')
                            key: '56c16dcc-391c-444f-9482-9be00204f097',
                        @else
                            key: teacherKey,
                            duration : second_cut ?? 0,
                        @endif
                    @endif
                    library_id: library_id,
                    lesson_id:  id,
                    type_video:  type_video,
                    id_folder_vdosipher:  id_folder_vdosipher,
                    },
                    onError(error) {
                    if (error.originalRequest) {
                        if (window.confirm(`Failed because: ${error}\nDo you want to retry?`)) {
                        upload.start()
                        uploadIsRunning = true
                        return
                        }
                    } else {
                        // window.alert(`Failed because: ${error}`)
                    }

                    reset()
                    },
                    onProgress(bytesUploaded, bytesTotal) {
                    const percentage = ((bytesUploaded / bytesTotal) * 100).toFixed(2)
                    progressBar.style.width = `${percentage}%`
                    progressBar.innerHTML = `${percentage}%`;
                    console.log(bytesUploaded, bytesTotal, `${percentage}%`)
                    },
                    onSuccess() {
                        
                        $('#position-top-start44442').click();

                         $("#id_bunny").val('');
                         add_video_2();

                       

                    reset()
                    },
                }

                upload = new tus.Upload(file, options)
                     upload.start()
                }

                if (!tus.isSupported) {
                alertBox.classList.remove('hidden')
                }

                if (!toggleBtn) {
                throw new Error('Toggle button not found on this page. Aborting upload-demo. ')
                }

                toggleBtn.addEventListener('click', (e) => {
                e.preventDefault()

                if (upload) {
                    if (uploadIsRunning) {
                    upload.abort()
                    toggleBtn.textContent = 'resume upload'
                    uploadIsRunning = false
                    } else {
                    upload.start()
                    toggleBtn.textContent = 'pause upload'
                    uploadIsRunning = true
                    }
                } else if (input.files.length > 0) {
                    startUpload()
                } else {
                    input.click()
                }
                })

                input.addEventListener('change', startUpload)

            }
           
           </script>


<script>
    function schec_true(){
        
        $("#div_date").css("display", "block");
        $("#div_from_date").css("display", "block");
        $("#id_schec_true").css("display", "none");
        $("#id_schec_false").css("display", "block");
    }

    function schec_false(){
        $("#div_date").css("display", "none");
        $("#div_from_date").css("display", "none");
        $("#date").val("");
        $("#form_date").val("");
        $("#id_schec_true").css("display", "block");
        $("#id_schec_false").css("display", "none");
        
    }

function schec_section_true(){
        
        $("#div_date_section").css("display", "block");
        $("#div_from_date_section").css("display", "block");
        $("#id_schec_true_section").css("display", "none");
        $("#id_schec_false_section").css("display", "block");
    }

    function schec_section_false(){
        $("#div_date_section").css("display", "none");
        $("#div_from_date_section").css("display", "none");
        $("#date_section").val("");
        $("#form_date_section").val("");
        $("#id_schec_true_section").css("display", "block");
        $("#id_schec_false_section").css("display", "none");
        
    }
</script>


<script>
    


    function add_video_2(){

            
                var id = $("#id_bunny").val();

                if(id != ''){ 
                
                    // Define a function to cancel the lesson
                    function cancelLesson(id) {
                        var csrfToken = "{{ csrf_token() }}";

                        $.ajax({
                            type: 'post',
                            url: "{{route('teachers.cancel_lesson')}}",
                            data: {
                                _token: csrfToken,
                                lesson_id: id
                            },
                            success: function (data) {
                                $("#b1").css("display", "block");
                            },
                            error: function (reject) {
                                // Handle error
                                console.error('AJAX request error:', reject);
                            }
                        });
                    }

                    // Call the cancelLesson function with the lesson ID when the page is unloaded
                    window.addEventListener('beforeunload', function () {
                        var id = $("#id_bunny").val();
                        cancelLesson(id);
                    });
                }else{
             
                    location.reload();
                }

                
            
    }
      

</script>

   

    <script>

        @if(isset($id))
            @if($type_course == 'free')
                $("#add_vid").css("display", "block");
                $("#link33").css("display", "block");
            @endif
        @endif

    </script>


<script>
    $(document).ready(function () {
        $('#name').on('keypress', function (event) {
            if (event.which === 47 || event.which === 92) {
                event.preventDefault();
                alert('ممنوع استخدام هذا الرمز داخل حقل الاسم')
            }
        });
    });
</script>

  
  

    
    {{-- file pond to upload in viemo --}}
    {{-- <script>
        function add_video(){
            // Get a reference to the file input element
            const inputElement = document.querySelector('input[type="file"]');
            
            const pond = FilePond.create(inputElement);
            var m =  $("#link_vimeo_upload_id").val();

            FilePond.setOptions({
              server:{
                url:  '/upload_vimeo/'+m,
                headers:{
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                process: {
                  
                    onload: (response) => {
                        $('.close').click();
                        $('#position-top-start').click();
                        $("#uplode_video").css("display","none");
                        $("#add_user").css("display", "block");
                        $("#name").val("");
                        $("#descriptions").val("");
                        $("#section_id").val("");
                        $("#type").val("");
                        $("#course_id").val("");
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    },
                    onerror: (response) => {
                        alert('يوجد خطا اثناء عملية الرفع');
                    },
                },
              },
              onprocessfiles: function(){ // remove file where all has been uploaded
                  pond.removeFiles();
                }
            });

        }
       
    </script> --}}


    {{-- file pond to upload in bunny --}}
    {{-- <script>
    
      function add_video(){
            // Get a reference to the file input element
            FilePond.registerPlugin(FilePondPluginFileValidateSize);
            const inputElement = document.querySelector('input[type="file"]');
            
            const pond = FilePond.create(inputElement, {
                 maxFileSize: '500MB'
            });

            var m =  $("#name_bunny").val();
            var name_teacher =  $("#name_teacher_bunny").val();
            var id = $("#id_bunny").val();

            FilePond.setOptions({
            server:{
                url:  '/teachers/upload_bunny/'+m+'/'+id+'/'+name_teacher,
                headers:{
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                process: {
                
                    onload: (response) => {
                        $('.close').click();
                        $('#position-top-start').click();
                        $("#uplode_video").css("display","none");
                        $("#add_user").css("display", "block");
                        $("#name").val("");
                        $("#descriptions").val("");
                        $("#section_id").val("");
                        $("#type").val("");
                        $("#course_id").val("");
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        $("#type_videoo").css("display","block");
                    },
                    onerror: (response) => {
                        alert('يوجد خطا اثناء عملية الرفع');
                    },
             
                },
              
            },
        
            onprocessfiles: function(){ // remove file where all has been uploaded
                pond.removeFiles();
                },
            });

        }
        
    
    </script> --}}

  {{-- change type video --}}
<script>
     $(document).ready(function(){
        $("#type_videoo").change(function(){
      
      
             if ( $(this).val() == "YouTube" ||  $(this).val() == "import_youtube" ) { 
                    $("#link33").css("display", "block");
                    $("#add_vid").css("display", "block");
                    $("#bunny_lesson").css("display", "none");
                    $("#uplo_video").css("display", "none");
                
        
             }else{
                $("#bunny_lesson").css("display", "block");
                
                $("#add_vid").css("display", "none");
                $("#link33").css("display", "none");
                $("#uplo_video").css("display", "block");
             }
             
    });
    });
     

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


    {{-- Send Notification --}}
    <script>
        function do_update1(){

            $("#update_users11").css("display", "none");
            $("#reload6611").css("display", "block");
            var formData = new FormData($('#notification_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.send_notification_to_supscribers')}}",
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
    {{-- show id in disabled_comments_form modal --}}
    <script>
        $('#disabled_comments').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id =           button.data('id')

            var modal = $(this)
            modal.find('.modal-body #lesson_id_comm').val(id);
    
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
                    url: "{{route('teachers.disabled_comments_route')}}",
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
        modal.find('#lesson_id_comm2').val(id);

    })
</script>

    {{-- Send  --}}
    <script>
        function do_update142(){

            $("#update_users1142").css("display", "none");
            $("#reload661142").css("display", "block");
            var formData = new FormData($('#disabled_comments_form2')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.disabled_comments_route')}}",
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
        
        function msg_add(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: ' سيتم مراجعة الفيديو في مدة اقصاها ساعة, شكرا لتفهمكم ',
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
        function add_suc2(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تمت الاضافة بنجاح  ',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function not_posi2(){
  
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: 'لا يمكن اضافة الدرس المدفوع الى دورة مجانية',
                showConfirmButton: false,
                timer: 3000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        
        function show_error(msg){
  
            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: msg,
                showConfirmButton: false,
                timer: 3000,
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
        function add_suc233(){
  
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: 'تم ارسال اشعار للمشتركين بنجاح',
                showConfirmButton: false,
                timer: 3000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function date3333(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تمت اضافة الدرس بنجاح ',
                showConfirmButton: false,
                timer: 3000,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
   
            });
  
        }
        function date3(){
  
            Swal.fire({
                position: 'top-start',
                icon: 'error',
                title: 'تمت اضافة الدرس بنجاح ',
                showConfirmButton: false,
                timer: 3000,
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
     $(document).ready(function() {
        $('.lesson-order').keyup(function(event) {
            if (event.key === 'Enter') {
                alert($(this).val());
            }
        });
    });
   
           
      
    
        $(function () {
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            @if(isset($id))
                   ajax: "{{ route('teachers.get_all_lessons',$id) }}",
            @else
                   ajax: "{{ route('teachers.get_all_lessons') }}",
            @endif
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'                 ,name: 'name'},
                {data: 'type'                 ,name: 'type'},
                {data: 'section_id'           ,name: 'section_id'},
                {data: 'course_id'            ,name: 'course_id'},
                @can('الاختبارات')
                {data: 'quiz'                 ,name: 'quiz'},
                @endcan
                {data: 'views'            ,name: 'views'},
                {data: 'status_lesson'            ,name: 'status_lesson'},
                {data: 'type_course'          ,name: 'type_course'},
                @can("التعليقات")
                {data: 'comments'             ,name: 'comments'},
                @endcan

                {data: 'action'     ,   name: 'action'},
                @if(isset($id))
                {data: 'order_action'     ,   name: 'order_action'},
                @endif
            ],
            "lengthMenu": [[5,25,50,100],[5,25,50,100]],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}



     <script type="text/javascript">

        $('#views_modal').on('show.bs.modal', function(event) {


                var button = $(event.relatedTarget)
                var id =                  button.data('id')
        
                $(function () {
                    var table = $('.yajra-datatable3').DataTable({
                        processing: true,
                        serverSide: true,
                        destroy: true,
                
                        ajax: {
                            url: "{{ route('teachers.get_views', [':id']) }}".replace(':id', id),
                        },
                    
                        columns: [
                            {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                            {data: 'name'                 ,name: 'name'},
                            {data: 'image'                 ,name: 'image'},
                        ],
                        "lengthMenu": [[25,50,-1],[25,50,'All']],     // page length options
                    });
                });
        });
    </script>



  
    {{-- open modal add user --}}
    <script>
        $('#modal_add').on('show.bs.modal', function(event) {
            $('select[name="section_id"]').empty();
        
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


{{-- selected groups --}}
<script>
    $(document).ready(function() {
        $('select[name="course_id"]').on('change', function() {
        
            $("#loading_solutions").css("display", "block");
            $("#loading_solutions2").css("display", "block");

            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: "{{ URL::to('teachers/get_sections') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if(data.type == 'free'){
                          
                            $("#loading_solutions").css("display", "none");
                            $("#loading_solutions2").css("display", "none");
                    

                                $('select[name="section_id"]').empty();
                                $('select[name="section_id"]').append('<option selected disabled selected>اختر الفصل..</option>');
                                for (var i = 0; i < data.sections.length; i++){
                                        $('select[name="section_id"]').append('<option value="' +
                                        data.sections[i].id + '">' + data.sections[i].name+ '</option>');
                                }

                                $('select[name="type_video"]').empty();
                                $('select[name="type"]').empty();
                                $('#type_video_lable').html("الرفع باستخدام اليوتيوب للدورة المجانية");
            
                
                                $('select[name="type_video"]').append('<option value="YouTube">YouTube</option>');
                                @if( $teacher_vdo_buuny == 'resolutions')
                                $('select[name="type_video"]').append('<option value="import_youtube">استيراد من اليوتيوب</option>');
                                @endif
                                $('select[name="type"]').append('<option value="visable">معاينة مجانية</option>');
                                $("#uplo_video").css("display", "none");
                                $("#link33").css("display", "block");
                                $("#add_vid").css("display", "block");
                        }else{
                          
                                $("#loading_solutions").css("display", "none");
                                $("#loading_solutions2").css("display", "none");
                        

                                $('select[name="section_id"]').empty();
                                $('select[name="section_id"]').append('<option selected disabled selected>اختر الفصل..</option>');
                                for (var i = 0; i < data.sections.length; i++){
                                        $('select[name="section_id"]').append('<option value="' +
                                        data.sections[i].id + '">' + data.sections[i].name+ '</option>');
                                }
                                $('#type_video_lable').html("اختر نوع الفيديو");

                                       
                                $('select[name="type_video"]').empty();
                                $('select[name="type"]').empty();
                                $('select[name="type"]').append('<option value="unvisable"> مدفوع</option>');
                                $('select[name="type"]').append('<option value="visable">معاينة مجانية</option>');
                            
                                
                                @if($teacher_vdo_buuny == 'bunny' || $teacher_vdo_buuny == 'Bunny')
                                        $('select[name="type_video"]').append('<option value="Bunny">رفع الدرس بشكل مباشر</option>');
                                @else   
                                        $('select[name="type_video"]').append('<option value="vdosipher">رفع الدرس بشكل مباشر</option>');
                                @endif

                                $('select[name="type_video"]').append('<option value="YouTube">YouTube</option>');
                                @if( $teacher_vdo_buuny == 'resolutions')
                                $('select[name="type_video"]').append('<option value="import_youtube">استيراد من اليوتيوب</option>');
                                @endif
                        
                                $("#uplo_video").css("display", "block");
                                $("#link33").css("display", "none");
                                $("#add_vid").css("display", "none");

                                
                        }

                          
                        
                        }
                    
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
        });
      
</script>



{{-- selected section in modal add lesson to sections --}}
<script>
    $(document).ready(function() {
        $('select[name="course_id3"]').on('change', function() {
        
            $("#loading_solutions3").css("display", "block");
        

            var id = $(this).val();
            if (id) {
                $.ajax({
                    url: "{{ URL::to('teachers/get_sections') }}/" + id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {

                           $("#loading_solutions3").css("display", "none");
                          
                   

                            $('select[name="section_id3"]').empty();
                            $('select[name="section_id3"]').append('<option selected disabled selected>اختر الفصل..</option>');
                            for (var i = 0; i < data.sections.length; i++){
                                    $('select[name="section_id3"]').append('<option value="' +
                                    data.sections[i].id + '">' + data.sections[i].name+ '</option>');
                            }
                        
                        }
                    
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
        });
      
</script>



{{-- change type --}}
{{-- <script>
    $(document).ready(function() {
        $('select[name="type"]').on('change', function() {
            // $("#loading_solutions5").css("display", "block");

            var type = $(this).val();

            if(type == "visable"){

                
                
                
                $('select[name="type_video"]').empty();
            
                
                $('select[name="type_video"]').append('<option value="YouTube">YouTube</option>');
                $("#uplo_video").css("display", "none");
                $("#link33").css("display", "block");
                $("#add_vid").css("display", "block");
            
                      

            }else{

                
                $('select[name="type_video"]').empty();
            
                
                $('select[name="type_video"]').append('<option value="Bunny">رفع الدرس بشكل مباشر</option>');
                $('select[name="type_video"]').append('<option value="YouTube">YouTube</option>');
         
                $("#uplo_video").css("display", "block");
                $("#link33").css("display", "none");
                $("#add_vid").css("display", "none");

            }

        });
        });
      
</script> --}}



    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user', function (e) {
    
            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
        

            $("#name_error").text("");
            $("#descriptions_error").text("");
            $("#all_courses_error").text("");
            $("#section_id_error").text("");
            $("#type_error").text("");
            $("#course_id_error").text("");

            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.store_lessons')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                        if(data.status == 'date'){
                            $('#position-top-date').click();
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                        }else{
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "none");
                            // $('.close').click();
                            // $('#position-top-start').click();
                            
                            $("#link").val("");
                            // $("#link_vimeo_upload_id").val(data.link);
                            // $("#name_bunny").val(data.name);
                            $("#id_bunny").val(data.id);
                            $("#second_cut").val(data.lesson.second_cut);
                            
                            
                            $("#video_id").val(data.video_id);
                            $("#id_folder_vdosipher").val(data.id_folder_vdosipher);
                            $("#type_video").val(data.type_video);
                            // $("#name_teacher_bunny").val(data.name_teacher);
                            add_video();
                            add_video_2();
                        
                        
                            // $("#uplode_video").css("display","block");
                            $("#type_videoo").attr('disabled', 'disabled');
                            $("#uplo_video").css("display", "none");
                            $("#card-bumber").css("display", "block");
                            $('select[name="type"]').attr('disabled', 'disabled');
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


    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user4', function (e) {

            $("#add_user4").css("display", "none");
           $("#add_user24").css("display", "block");

            $("#name_error").text("");
            $("#descriptions_error").text("");
            $("#section_id_error").text("");
            $("#type_error").text("");
            $("#course_id_error").text("");

            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.store_lessons')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                        if(data.status == 'date'){
                            $('#position-top-date').click();
                            $("#add_user4").css("display", "block");
                            $("#add_user24").css("display", "none");
                        }else{
                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            $("#add_user4").css("display", "block");
                            $("#add_user24").css("display", "none");
                            $('.close').click();
                            $('#position-top-start').click();
                            $("#name").val("");
                            // $("#add_vid").css("display", "none");
                            // $("#link33").css("display", "none");
                            $("#link").val("");
                          
                            $('#exampleFormControlSelect1').prop('selectedIndex',0);
                            location.reload();
                        }
                    
                   
                          
                    
                    },
                    error: function (reject) {
                        $("#add_user4").css("display", "block");
                            $("#add_user24").css("display", "none");
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
            var link =                button.data('link')
            var type =                button.data('type')
            var course_id =                button.data('course_id')
            var section_id =                button.data('section_id')
            var name_section =                button.data('name_section')
            var descriptions =                button.data('descriptions')
            var type_video =                button.data('type_video')
            
            
            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #link2').val(link);
            modal.find('.modal-body #type2').val(type);
            modal.find('.modal-body #course_id2').val(course_id);
            modal.find('.modal-body #descriptions2').val(descriptions);

            $('select[name="section_id"]').empty();
            $('select[name="section_id"]').append('<option value="' +section_id + '">'
                +name_section+ '</option>');


           if(type_video != "YouTube"){
         
                $("select option[value='visable']").show();
                $("select option[value='unvisable']").show();
                $("#link_show").css("display", "none");
            

            }else{

               $("select option[value='unvisable']").hide();
               $("#link_show").css("display", "block");

           }


           
      
  
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
                    url: "{{route('teachers.update_lessons')}}",
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


  {{-- show modal add lesson to section --}}
  <script>
    $('#add_lesson_to_another_section').on('show.bs.modal', function(event) {

    
        var button = $(event.relatedTarget)
        var id =                  button.data('id')
        var name_lesson =                button.data('name_lesson')
        var name_section =                button.data('name_section')
        var name_course =                button.data('name_course')
        
        
        var modal = $(this)
        modal.find('.modal-body #id23').val(id);
        modal.find('.modal-body #name_lesson').text(name_lesson);
        modal.find('.modal-body #name_section').text(name_section);
        modal.find('.modal-body #name_course').text(name_course);
  
  

    })
  </script>


 {{-- update  modal add lesson to sectionser --}}
    <script>
        function add_lesson_to_section_button(){
        
            $('#title2_error').text('')
            $('#body2_error').text('')

            
            $("#editing3").css("display", "none");
            $("#editing23").css("display", "block");

            var formData = new FormData($('#add_lesson_to_another_section_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.add_lesson_to_another_section')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        
                        if(data.status == false){
                            $('#position-top-not_posi').click();
                            $("#editing3").css("display", "block");
                            $("#editing23").css("display", "none");
                        }else{
                            $("#editing3").css("display", "block");
                            $("#editing23").css("display", "none");
                    
                            $('.close').click();
                        
                            $('#position-top-add_suc').click();
                             $('.yajra-datatable').DataTable().ajax.reload(null, false);
                        }
                      
                    
                    }, error: function (reject) {
                            $("#editing3").css("display", "block");
                            $("#editing23").css("display", "none");
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "3_error").text(val[0]);
                            });
                    }
                });
        }
    </script>


  {{-- show modaladd_attachment_button --}}
  <script>
    $('#add_attachments').on('show.bs.modal', function(event) {

    
        var button = $(event.relatedTarget)
        var id =                  button.data('id')
      
        var modal = $(this)
        modal.find('.modal-body #id233').val(id);


        

        var table = $('.yajra-datatable2').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
     
             ajax: "{{ route('teachers.get_all_attachments') }}"+"/"+id,
           
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name_file'                 ,name: 'name_file'},
                {data: 'action'     ,   name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
          
           });
  

  
  

    })
  </script>


 {{-- add_attachment_button --}}
    <script>
        function add_attachment_button(){
        
      
          

            
            $("#editing33").css("display", "none");
            $("#editing233").css("display", "block");

            var formData = new FormData($('#add_attachments_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('teachers.add_attachments')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing33").css("display", "block");
                        $("#editing233").css("display", "none");
                
                        $('#name_file_error').text('')
                        $('#name_file').val('')
                        $('#change-picture').val('')
                    
                        $('#position-top-start').click();
                        $('.yajra-datatable2').DataTable().ajax.reload(null, false);
                    
                    }, error: function (reject) {
                            $("#editing33").css("display", "block");
                            $("#editing233").css("display", "none");
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "_error").text(val[0]);
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

     {{-- fill delete attchmnt --}}
     <script>
        $('#delete_attachmetn').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id33').val(id);
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
                url: "{{route('teachers.destroy_lessons')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_user2").css("display", "none");
                    $("#delete_user_button").css("display", "block");
                    $('#position-top-start_delete').click();
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $('.close').click();
                
                }, error: function (reject) {
                }
            });
     }
   </script>



   {{-- delete attachment--}}
   <script>
        function do_delete_attachment(){

            $("#delete_user_buttonf").css("display", "none");
            $("#delete_user2f").css("display", "block");
            var formData = new FormData($('#delte_attachment_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('teachers.destroy_attachmetns')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_user2f").css("display", "none");
                    $("#delete_user_buttonf").css("display", "block");
                    // $('#position-top-start_deletef').click();
                    // $('.yajra-datatable').DataTable().ajax.reload(null, false);
                    $('.close').click();
                
                }, error: function (reject) {
                }
            });
     }
   </script>



@endsection