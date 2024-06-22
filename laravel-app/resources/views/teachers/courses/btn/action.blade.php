
<!-- Example single danger button -->
<div class="btn-group dropright">
        <button type="button" class="btn btn-sm btn-primary" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 <span> <i class="fa-solid fa-gear"></i></span>
              </button>
        <div class="dropdown-menu" style="padding:8%">
       
@can("تعديل دورة")


@if($data->is_comment_disabled == 0)

        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#disabled_comments"  style="margin-bottom: 4%"

                data-id=                  "{{ $data->id }}"


                > <i class="fa fa-stop"></i> ايقاف التعليقات </a>
        @else

        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#disabled_comments2"  style="margin-bottom: 4%"

        data-id=                  "{{ $data->id }}"


        > <i class="fa fa-stop"></i>  تفعيل التعليقات </a>

        @endif

        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user" style="margin-bottom: 4%"

        data-id=             "{{ $data->id }}"
        data-name=           "{{ $data->name }}"
        data-level_id=       "{{ $data->level_id }}"
        data-description=    "{{ $data->description }}"
        data-price=          "{{ $data->price }}"
        data-discount=       "{{ $data->discount }}"
        data-image_100k=     "{{ $data->image_100k }}"
        data-type=           "{{ $data->type }}"


        <?php $course = \App\Models\Course::where('id',$data->id)->first(); ?>

        @if($course->status == 2)

                data-is_show=           "not_show"

        @else

                data-is_show=           "show"

        @endif



        > <i class="fa fa-edit"></i> تعديل </a>

@if($data->status == 0 || $data->status == 3)

        <a class="btn btn-sm btn-success" data-toggle="modal" href="#is_post_modal" style="margin-bottom: 4%"
        data-id=             "{{ $data->id }}"

        title = "نشر الدورة">  ارسال الدورة الى المراجعة </a>

@endif

@endcan


@if($data->has_ended != 1 && $data->status != 3)
        <a class="btn btn-sm btn-warning" data-toggle="modal" href="#has_ended_modal" style="margin-bottom: 4%"
        data-id=             "{{ $data->id }}"
        >انهاء الدورة</a>  <br>
@endif


@can("حذف دورة")     

        <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user" style="margin-bottom: 4%"
        data-id=             "{{ $data->id }}"
        ><i class="fa fa-trash"></i> حذف دورة </a>

@endcan
        </div>
      </div>










