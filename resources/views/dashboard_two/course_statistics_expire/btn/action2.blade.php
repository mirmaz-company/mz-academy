
@if($user_id != 2)
        @if($course->type == "paid_public")

                <a class="btn btn-sm btn-danger" data-toggle="modal" href="#edit_user"

                data-course_id=             "{{ $course->id }}"
                data-user_id=        "{{ $data->user_id }}"
        
                >  الغاء الاشتراك مع ارجاع المبلغ </a>

        @else

                <a class="btn btn-sm btn-danger" data-toggle="modal" href="#edit_user"

                data-course_id=             "{{ $course->id }}"
                data-user_id=        "{{ $data->user_id }}"
        
                >  الغاء الاشتراك    </a>


        @endif
@else
       <span style="color:red"> غير فعال على حساب الشركة</span>

@endif
   
  
{{--                 
        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
        data-id=             "{{ $data->id }}"
        ><i class="fa fa-trash"></i></a> --}}






