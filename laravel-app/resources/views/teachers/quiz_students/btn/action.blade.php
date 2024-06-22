

@if($type == 'student_complete')

        <?php $quiz_id= \Illuminate\Support\Facades\Crypt::encrypt($id); ?>
        <?php $user_id= \Illuminate\Support\Facades\Crypt::encrypt($data->id); ?>
        <a class="btn btn-sm btn-primary"  href="{{ route('teachers.quiz_students_show', [$quiz_id,$user_id]) }}">

   

         <i class="fa fa-correct"></i>  تعديل العلامة </a>

@else

        <?php $quiz_id= \Illuminate\Support\Facades\Crypt::encrypt($id); ?>
        <?php $user_id= \Illuminate\Support\Facades\Crypt::encrypt($data->id); ?>
        <a class="btn btn-sm btn-primary"  href="{{ route('teachers.quiz_students_show', [$quiz_id,$user_id]) }}">

   

        <i class="fa fa-correct"></i> تصحيح الامتحان </a>

@endif
   






