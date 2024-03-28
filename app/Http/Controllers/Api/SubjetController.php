<?php

namespace App\Http\Controllers\Api;

use App\Models\Level;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Teachers\Teacher;
use App\Models\UserTopic;
use Illuminate\Http\Request;
use App\Models\ReviewTeacher;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TopicSubject;
use Illuminate\Support\Facades\Auth;

class SubjetController extends Controller
{


    public function get_subjects(){

        // برجعلو 5 مواضيع حسب الليفل تبعو
        // برجعلو كمان 5 مواضيع حسب الاهتمامات الي اختارها..والاهتمامات مربوطة في مواضيع
        $course_is_subject = Course::where('status',2)->where('is_view',1)->pluck('subject_id');

        if(Auth::guard('api')->check()){
       

            $subjects1 = Subject::whereIn('id',$course_is_subject)->where('level_id',Auth::guard('api')->user()->level)->take(7)->get();
          

            $user_topic_ids = UserTopic::where('user_id',Auth::guard('api')->user()->id)->pluck('topic_id');


            $subject_ids_for_topic = TopicSubject::whereIn('topic_id',$user_topic_ids)->pluck('subject_id');
            

            $subjects2 = Subject::whereIn('id',$course_is_subject)->where('level_id',Auth::guard('api')->user()->level)->whereIn('id',$subject_ids_for_topic)->take(5)->get();
            

            $subjects =$subjects1->merge($subjects2);

        }else{
            $subjects = Subject::whereIn('id',$course_is_subject)->take(7)->get();


        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $subjects,
        ]);
    



    }



    public function get_all_subjects(){

        $course_is_subject = Course::where('status',2)->where('is_view',1)->pluck('subject_id');

        if(Auth::guard('api')->check()){

        // بدي اجيب كل المواضيع الخاصة بالليفل تبعي مع المواضيع الي انا مهتم بها الي اخترتها عند انشاء الحساب


        // جبت كل المواضيع الخاصة بالليفل تبعي
        $subjects_id_for_my_level = Subject::whereIn('id',$course_is_subject)->where('level_id',Auth::guard('api')->user()->level)->pluck('id');
  



        // جبت كل المواضيع الي انا مهتم بها
        $user_topic_ids = UserTopic::where('user_id',Auth::guard('api')->user()->id)->pluck('topic_id');

        $subject_ids_for_topic = TopicSubject::whereIn('topic_id',$user_topic_ids)->pluck('subject_id');
  

        // دمجتهم مع بعض في ارري
        $subjects =$subjects_id_for_my_level->merge($subject_ids_for_topic);



        $subjects = Subject::whereIn('id',$course_is_subject)->where('level_id',Auth::guard('api')->user()->level)->whereIn('id',$subjects)->paginate(10);

        }else{
            $subjects = Subject::whereIn('id',$course_is_subject)->paginate(10);
        }




        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $subjects,
        ]);
    

    }




    public function see_all_best_course_for_subject(Request $request){

        if($request->level_id == "all"){

            $subject_level_ids = Level::pluck('id');


            $best_course = Course::whereIn('level_id',$subject_level_ids)->where('is_view',1)->where('subject_id',$request->subject_id)->orderBy('rate','desc')->paginate(7);
    
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $best_course,
            ]);
        
        }

        $subject_level_ids = Level::where('id',$request->level_id)->pluck('id');

        $best_course = Course::whereIn('level_id',$subject_level_ids)->where('is_view',1)->where('subject_id',$request->subject_id)->orderBy('rate','desc')->paginate(7);

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $best_course,
        ]);

       

    }



    public function see_all_new_course_for_subject(Request $request){

        if($request->level_id == "all"){

            $subject_level_ids = Level::pluck('id');


            $new_course = Course::whereIn('level_id',$subject_level_ids)->where('is_view',1)->where('subject_id',$request->subject_id)->orderBy('id','desc')->paginate(7);
    
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $new_course,
            ]);
        
        }

        $subject_level_ids = Level::where('id',$request->level_id)->pluck('id');

        $new_course = Course::whereIn('level_id',$subject_level_ids)->where('is_view',1)->where('subject_id',$request->subject_id)->orderBy('id','desc')->paginate(7);

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $new_course,
        ]);

       

    }



    public function see_all_paid_courses_for_subject(Request $request){

        if($request->level_id == "all"){

            $subject_level_ids = Level::pluck('id');


            $paid_course = Course::whereIn('level_id',$subject_level_ids)->where('is_view',1)->where('subject_id',$request->subject_id)->where('status',2)->where('paid',1)->orderBy('id','desc')->paginate(7);
    
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $paid_course,
            ]);
        
        }

        $subject_level_ids = Level::where('id',$request->level_id)->pluck('id');

        $paid_course = Course::whereIn('level_id',$subject_level_ids)->where('is_view',1)->where('subject_id',$request->subject_id)->where('status',2)->where('paid',1)->orderBy('id','desc')->paginate(7);

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $paid_course,
        ]);

       

    }



    public function see_all_free_courses_for_subject(Request $request){

        if($request->level_id == "all"){

            $subject_level_ids = Level::pluck('id');


            $free_course = Course::whereIn('level_id',$subject_level_ids)->where('is_view',1)->where('subject_id',$request->subject_id)->where('status',2)->where('status',2)->where('paid',0)->orderBy('id','desc')->paginate(7);
    
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $free_course,
            ]);
        
        }

        $subject_level_ids = Level::where('id',$request->level_id)->pluck('id');

        $free_course = Course::whereIn('level_id',$subject_level_ids)->where('is_view',1)->where('subject_id',$request->subject_id)->where('status',2)->where('paid',0)->orderBy('id','desc')->paginate(7);

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $free_course,
        ]);

       

    }





    
}
