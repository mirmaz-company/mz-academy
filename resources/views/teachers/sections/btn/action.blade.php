
@can("تعديل فصل")

        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

        data-id=             "{{ $data->id }}"
        data-name=          "{{ $data->name }}"
        data-course_id=          "{{ $data->course_id }}"
      
   

        > <i class="fa fa-edit"></i> </a>

@endcan

        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#add_section_to_course" title="اضافة فصل الى دورة"

          data-id=             "{{ $data->id }}"

        > <i class="fa fa-plus"></i> </a>
   
 
@can("حذف فصل")
                
        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
        data-id=             "{{ $data->id }}"
        ><i class="fa fa-trash"></i></a>
@endcan






