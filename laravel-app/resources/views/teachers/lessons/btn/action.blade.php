



<div class="dropdown dropright">
        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-gear"></i>
        </button>
       
        
        
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding: 13%;
               margin: 1% 1% 21%;width: 197%;">


        @if($data->status_laravel == 1 && $data->status_node == 1 && $data->updated_at < \Carbon\Carbon::now()->subHours(1)->toDateTimeString())


        @can("تعديل درس")

        @if($data->is_comment_disabled == 0)

                <a class="btn btn-sm btn-primary" data-toggle="modal" href="#disabled_comments"  style="margin-bottom: 10%"

                        data-id=                  "{{ $data->id }}"
                

                        > <i class="fa fa-stop"></i> ايقاف التعليقات </a>
        @else

                <a class="btn btn-sm btn-primary" data-toggle="modal" href="#disabled_comments2"  style="margin-bottom: 10%"

                data-id=                  "{{ $data->id }}"


                > <i class="fa fa-stop"></i>  تفعيل التعليقات </a>

        @endif


        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"  style="margin-bottom: 10%"

        data-id=                  "{{ $data->id }}"
        data-name=                "{{ $data->name }}"
        data-link=                "{{ $data->link }}"
        data-type=                "{{ $data->type }}"
        data-course_id=           "{{ $data->course_id }}"
        data-section_id=          "{{ $data->section_id }}"
        data-descriptions=          "{{ $data->descriptions }}"
        data-type_video=          "{{ $data->type_video }}"
      
        <?php $section = \App\Models\Section::where('id',$data->section_id)->first();   ?>

        @if($section)
                data-name_section=          "{{ $section->name }}"
        @else
                data-name_section=          "-"
        @endif
 
   

        > <i class="fa fa-edit"></i> تعديل </a>

        @endcan

        <div style="margin-bottom: 10%">
                <a class="btn btn-sm btn-primary" data-toggle="modal" href="#inlineForm_not"
    
                data-id55=             "{{ $data->id }}"
    
    
                > <i class="fa fa-bell"></i> ارسال اشعار لدرس</a>
        </div>
   
  
        
        @can("اضافة درس الى قسم اخر")
        <a class="btn btn-sm btn-success" data-toggle="modal" style="margin-bottom: 10%"  href="#add_lesson_to_another_section" title="اضافة الدرس الى قسم اخر"
           data-id=             "{{ $data->id }}"

           <?php $name_section = \App\Models\Section::where('id',$data->section_id)->first(); ?>
           <?php $course_name = \App\Models\Course::where('id',$data->course_id)->first(); ?>
         
           data-name_lesson=             "{{ $data->name }}"
           data-name_section=             "{{ $name_section->name ?? "-" }}"
           data-name_course=             "{{ $course_name->name ?? "-"}}"
        ><i class="fa fa-plus"></i>اضافة الدرس الى قسم اخر</a>
        @endcan


        @can("اضافة المرفقات")
        <a class="btn btn-sm btn-warning" data-toggle="modal" href="#add_attachments" style="margin-bottom: 10%"
                 data-id=             "{{ $data->id }}"
        ><i class="fa fa-file"></i> اضافة مرفقات</a>
        @endcan


        @endif



        @can("حذف درس")
        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user" style="margin-bottom: 10%"
        data-id="{{ $data->id }}"
        ><i class="fa fa-trash"></i> حذف الدرس</a>
        @endcan

   </div>
</div>






