

        @if($data ->type == "quiz_choose" )
                <a class="btn btn-sm btn-primary"  href="{{ route('teachers.quiz_qustions',[$data->id,"quiz_choose"]) }}"
                > <i class="fa fa-plus"></i> اضافة اسئلة </a>
        @elseif($data ->type == "quiz_image")
                <a class="btn btn-sm btn-primary"  href="{{ route('teachers.quiz_qustions',[$data->id,"quiz_image"]) }}"
                > <i class="fa fa-plus"></i> اضافة اسئلة </a>
        @else
                <a class="btn btn-sm btn-primary"  href="{{ route('teachers.quiz_qustions',[$data->id,"quiz_write"]) }}"
                > <i class="fa fa-plus"></i> اضافة اسئلة </a>
        @endif
   

        <div style="margin-bottom: 10%;margin-top: 10%">
                <a class="btn btn-sm btn-success" data-toggle="modal" href="#inlineForm_not"
    
                data-id55=             "{{ $data->id }}"
    
    
                > <i class="fa fa-bell"></i> ارسال اشعار لاختبار</a>
        </div>
  
                
        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
        data-id=             "{{ $data->id }}"
        ><i class="fa fa-trash"></i></a>






