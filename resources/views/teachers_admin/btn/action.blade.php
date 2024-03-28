
<div class="row">

        <div class="col-md-3">
                @can("تعديل معلم")
                        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"
                
                        data-id=                  "{{ $data->id }}"
                        data-name=                "{{ $data->name }}"
                        data-email=               "{{ $data->email }}"
                        data-specialization=               "{{ $data->specialization }}"
                        data-password=            "{{ $data->password_show }}"
                        data-subject_id=          "{{ $data->subject_id }}"
                
                
                
                        > <i class="fa fa-edit"></i>تعديل معلم </a>
        
               @endcan
        </div>
        <div class="col-md-3">
                @can("انشاء اكواد للمعلم")
        
                        <a class="btn btn-sm btn-success" data-toggle="modal" href="#create_code_modal" title="انشاء اكواد"
                
                        data-id=                  "{{ $data->id }}"
                
                
                        > <i class="fa fa-plus"></i> انشاء اكواد خاصة للمعلم</a>
                @endcan
        </div>
        <div class="col-md-3">
                @can("حذف معلم")
                        
                        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
                        data-id=             "{{ $data->id }}"
                        ><i class="fa fa-trash"></i>حذف معلم</a>

                @endcan
        </div>
        <div class="col-md-3">
                <a class="btn btn-sm btn-primary" data-toggle="modal" href="#add_new_subject_to_teacher"

                        <?php $data_teacher = \App\Models\TeacherStudy::where('teacher_id',$data->id)->get(); ?>
                        <?php $name_teacher = \App\Models\Teacher::where('id',$data->id)->first(); ?>

                        data-showw="@foreach ($data_teacher as $key => $data_tea)

                                        <?php $subject_name = \App\Models\Subject::where('id',$data_tea->subject_id)->first(); ?>
                                        <?php $level_name =   \App\Models\Level::where('id',$data_tea->level_id)->first(); ?>
                                        <?php $study_name =   \App\Models\Study::where('id',$data_tea->study_id)->first(); ?>

                                        <p> ---{{$subject_name->name ?? "لا يوجد"}} - {{ $level_name->name ?? "لا يوجد" }} - {{ $study_name->name ?? "لا يوجد" }} </p> 
                                @endforeach"


                
                
                        data-id=                  "{{ $data->id }}"
                        data-name_teacher=        " الاستاذ : {{ $name_teacher->name }}"
                        data-teacher_image=        "{{ $name_teacher->image }}"
      
         
                > <i class="fa fa-plus"></i> اضافة موضوع جديد للاستاذ </a>
        </div>

</div>


      
        
   
           
    
        

            







