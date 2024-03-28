<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Teachers\Teacher;
use Illuminate\Http\Request;
use App\Models\ReviewTeacher;
use App\Models\UserFollowTeacher;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\TeacherStudy;
use Illuminate\Support\Facades\Auth;

class TeacherController extends Controller
{


    public function best_teacher_home(){

        if(Auth::guard('api')->check()){
            // عشان اجيب الاساتذة الي الهم كورسات فقط
            $teachers_id = Course::where('status',2)->where('is_view',1)->where('is_view',1)->pluck('teacher_id');

            $subjects_ids = Subject::where('level_id',Auth::guard('api')->user()->level)->pluck('id');

            $subject_teacherss = TeacherStudy::whereIn('subject_id', $subjects_ids)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');
     
            $teachers = Teacher::whereIn('id',$subject_teacherss)->where('rate','>=',4)->where('parent',0)->orderBy('rate','desc')->take(10)->get();
        }else{
            $teachers_id = Course::where('status',2)->where('is_view',1)->pluck('teacher_id');
            $subjects_ids = Subject::inRandomOrder()->pluck('id');
            $subject_teacherss = TeacherStudy::whereIn('subject_id', $subjects_ids)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');
            $teachers = Teacher::whereIn('id',$subject_teacherss)->where('rate','>=',4)->where('parent',0)->orderBy('rate','desc')->take(10)->get();
        }

      

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $teachers,
        ]);
          
    }

    public function see_all_best_teacher_home(Request $request){
        // عشان اجيب الاساتذة الي الهم كورسات فقط
        $teachers_id = Course::where('status',2)->where('is_view',1)->pluck('teacher_id');

        if(Auth::guard('api')->check()){
          
            $subjects_ids = Subject::where('level_id',Auth::guard('api')->user()->level)->pluck('id');

            $subject_teacherss = TeacherStudy::whereIn('subject_id', $subjects_ids)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');
        
            $teachers = Teacher::whereIn('id',$subject_teacherss)->where('rate','>=',4)->where('parent',0)->orderBy('rate','desc')->paginate(10);
        }else{
            $teachers = Teacher::whereIn('id',$teachers_id)->where('rate','>=',4)->where('parent',0)->orderBy('rate','desc')->paginate(10);
        }
        
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $teachers,
            ]);
      

    }

    public function get_sujects_from_level($id){
        $subjects = Subject::Where('level_id',$id)->get();

        return response()->json([
            'subjects' => $subjects,
        ]);
    }


    public function courses_teachers(Request $request){
        $levels_id = Course::where('teacher_id',$request->teacher_id)->where('is_view',1)->where('status',2)->pluck('level_id');
        $levels    = Level::whereIn('id',$levels_id)->orderBy('id','desc')->get();


        foreach($levels as $level){

            $level['courses'] = Course::where('teacher_id',$request->teacher_id)->where('is_view',1)->where('status',2)->orderBy('id','desc')->where('level_id',$level->id)->get();
        }

        
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $levels,
        ]);


    }


    public function reviews_teacher(Request $request){


        $reviews_teacher = ReviewTeacher::where('teacher_id',$request->teacher_id)->paginate(7);
        foreach($reviews_teacher as $rev){
            
            $rev['user'] = User::where('id',$rev->user_id)->first(['id','name','image']);
        }
     
        
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $reviews_teacher,
        ]);


    }


    public function best_teacher_subject_id(Request $request){

        $teachers_id = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('status',2)->pluck('teacher_id');

        $subject_teacherss = TeacherStudy::where('subject_id', $request->subject_id)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');

        $teachers = Teacher::whereIn('id',$subject_teacherss)->where('rate','>=',4)->where('parent',0)->orderBy('rate','desc')->take(10)->get();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $teachers,
        ]);
          
    }



    public function see_all_best_teacher_by_subject_id(Request $request){

        $teachers_id = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('status',2)->pluck('teacher_id');

        $subject_teacherss = TeacherStudy::where('subject_id', $request->subject_id)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');
        //  جبنا الاستاذة من المادة الدراسية مباشرة
        $teachers = Teacher::whereIn('id',$subject_teacherss)->where('rate','>=',4)->where('parent',0)->orderBy('rate','desc')->paginate(7);

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $teachers,
        ]);
          
       


    }

    public function teacher_profile(Request $request){
       
        
        $teacher = Teacher::where('id',$request->teacher_id)->where('parent',0)->first();
        if($teacher){
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $teacher,
            ]);
        }else{
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
                
            ]);
        }
    }




    public function popular_teacher_home(){

        $teachers_id = Course::where('status',2)->where('is_view',1)->pluck('teacher_id');

        if(Auth::guard('api')->check()){

            $subjects_ids = Subject::where('level_id',Auth::guard('api')->user()->level)->pluck('id');

            $subject_teacherss = TeacherStudy::whereIn('subject_id', $subjects_ids)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');

            // هاد الكومنت على المدرسين الاشهر
            // $teachers = Teacher::whereIn('id',$subject_teacherss)->where('parent',0)->orderBy('total_subscriptions','desc')->take(10)->get();

            // هاد التعديل على الريكويست وخليتو المدرسين انضمو حديثا
            $teachers = Teacher::whereIn('id',$subject_teacherss)->where('parent',0)->orderBy('created_at','desc')->orderBy('id','desc')->take(10)->get();

        }else{
            // $teachers = Teacher::whereIn('id',$teachers_id)->where('parent',0)->orderBy('total_subscriptions','desc')->take(10)->get();
            $teachers = Teacher::whereIn('id',$teachers_id)->where('parent',0)->orderBy('created_at','desc')->orderBy('id','desc')->take(10)->get();
        }

     

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $teachers,
        ]);
          
    }

    public function see_all_popular_teacher_home(){

        $teachers_id = Course::where('status',2)->where('is_view',1)->pluck('teacher_id');

        if(Auth::guard('api')->check()){

    
            $subjects_ids = Subject::where('level_id',Auth::guard('api')->user()->level)->pluck('id');

            $subject_teacherss = TeacherStudy::whereIn('subject_id', $subjects_ids)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');
        
            // $teachers = Teacher::whereIn('id',$subject_teacherss)->where('parent',0)->orderBy('total_subscriptions','desc')->paginate(10);
            $teachers = Teacher::whereIn('id',$subject_teacherss)->where('parent',0)->orderBy('id','desc')->paginate(10);

        }else{
            // $teachers = Teacher::whereIn('id',$teachers_id)->where('parent',0)->orderBy('total_subscriptions','desc')->paginate(10);
            $teachers = Teacher::whereIn('id',$teachers_id)->where('parent',0)->orderBy('id','desc')->paginate(10);
        }
        
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $teachers,
            ]);
      

    }


    public function popular_teacher_subject_id(Request $request){

        $teachers_id = Course::where('status',2)->where('is_view',1)->pluck('teacher_id');

        $subject_teacherss = TeacherStudy::where('subject_id', $request->subject_id)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');

        $teachers = Teacher::whereIn('id',$subject_teacherss)->where('parent',0)->orderBy('total_subscriptions','desc')->take(10)->get();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $teachers,
        ]);
          
    }



    public function see_all_popular_teacher_subject_id(Request $request){
        $teachers_id = Course::where('status',2)->where('is_view',1)->pluck('teacher_id');

        $subject_teacherss = TeacherStudy::where('subject_id',$request->subject_id)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');

        //  جبنا الاستاذة من المادة الدراسية مباشرة
        $teachers = Teacher::whereIn('id',$subject_teacherss)->where('parent',0)->orderBy('total_subscriptions','desc')->paginate(7);

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $teachers,
        ]);
          
       


    }



  


    public function see_all_new_teacher(Request $request){

        $teachers_id = Course::where('status',2)->pluck('teacher_id');
        if($request->subject_id == "all"){
            $new_teacher = Teacher::whereIn('id',$teachers_id)->orderBy('id','desc')->where('parent',0)->paginate(7);
        
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $new_teacher,
            ]);
        }

        $subject_teacherss = TeacherStudy::where('subject_id',$request->subject_id)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');

        $teacher_ids = Teacher::whereIn('id',$subject_teacherss)->pluck('id');
        $new_teacher = Teacher::whereIn('id',$teachers_id)->orderBy('id','desc')->whereIn('id',$teacher_ids)->paginate(7);
    
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $new_teacher,
        ]);
          
       


    }


    public function all_teachers(Request $request){

        $teachers_id = Course::where('status',2)->pluck('teacher_id');
        if($request->subject_id == 'all'){
            $best_teacher = DB::table('review_teachers')
                ->select('teacher_id')
                ->selectRaw("Avg(rate) as rate")
                ->groupBy('teacher_id')
                ->orderBy('rate','desc')
                ->take(4)
                ->get();
    

                foreach($best_teacher as $teach){
                    $teach->teacher = Teacher::where('id',$teach->teacher_id)->where('parent',0)->first();
                }

   
            $popular_teacher = Teacher::whereIn('id',$teachers_id)->orderBy('total_subscriptions','desc')->where('parent',0)->take(7)->get();
         
            
            
            $new_teacher = Teacher::whereIn('id',$teachers_id)->orderBy('id','desc')->where('parent',0) ->take(4)->get();
    
        

            return response()->json([
                'code'             => 200,
                'status'           => true,
                'message'          => 'fetch data succsessfully',
                'best_teacher'     => $best_teacher,
                'popular_teacher'  => $popular_teacher,
                'new_teacher'      => $new_teacher,
        
            ]);
        }


        $tacher_ids = Teacher::where('subject_id',$request->subject_id)->where('parent',0)->pluck('id');
        $best_teacher = DB::table('review_teachers')
                ->whereIn('teacher_id',$tacher_ids)
                ->select('teacher_id')
                ->selectRaw("Avg(rate) as rate")
                ->groupBy('teacher_id')
                ->orderBy('rate','desc')
                ->take(4)
                ->get();
    

                foreach($best_teacher as $teach){
                    $teach->teacher = Teacher::whereIn('id',$teachers_id)->where('id',$teach->teacher_id)->where('parent',0)->first();
                }

   
            $popular_teacher = Teacher::whereIn('id',$teachers_id)->orderBy('total_subscriptions','desc')->where('parent',0)->where('subject_id',$request->subject_id)->take(7)->get();
         
            
            
            $new_teacher = Teacher::whereIn('id',$teachers_id)->orderBy('id','desc')->where('parent',0)->where('subject_id',$request->subject_id)->take(4)->get();
    
        

            return response()->json([
                'code'             => 200,
                'status'           => true,
                'message'          => 'fetch data succsessfully',
                'best_teacher'     => $best_teacher,
                'popular_teacher'  => $popular_teacher,
                'new_teacher'      => $new_teacher,
        
            ]);
   
    

    }


    public function add_review_teacher(Request $request){


        DB::beginTransaction();
        try {

        $review_user = ReviewTeacher::where('user_id',Auth::guard('api')->user()->id)->where('teacher_id',$request->teacher_id)->first();



        if($review_user){
            $review_user->rate    = $request->rate;
            $review_user->comment = $request->comment;
            $review_user->save();
      
    
        }else{

            $review_teacher = new ReviewTeacher();
            $review_teacher->teacher_id   = $request->teacher_id;
            $review_teacher->user_id      =Auth::guard('api')->user()->id;
            $review_teacher->rate         = $request->rate;
            $review_teacher->comment      = $request->comment;
            $review_teacher->save();
    
        }

        $all_review = ReviewTeacher::where('teacher_id',$request->teacher_id)->avg('rate');
     

        $teacher = Teacher::where('id',$request->teacher_id)->where('parent',0)->first();
 
        if($teacher){
            $teacher->rate = $all_review;
            $teacher->save();
        }

        DB::commit();

        }

        catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'something error',
                
            ]);

        }

    
           
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'added succsessfully',
        ]);

    }


    public function follow_teacher(Request $request){
        $follow = UserFollowTeacher::where('user_id',Auth::guard('api')->user()->id)->where('teacher_id',$request->teacher_id)->first();

        if($follow){

            $follow->delete();

            $teacher = Teacher::where('id',$request->teacher_id)->where('parent',0)->first();
            $teacher->follwers =  $teacher->follwers - 1;
            $teacher->save();

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تم الغاء المتابعة',
                
            ]);

        }else{

            $follow = new UserFollowTeacher();
            $follow->user_id = Auth::guard('api')->user()->id;
            $follow->teacher_id = $request->teacher_id;
            $follow->save();

            $teacher = Teacher::where('id',$request->teacher_id)->where('parent',0)->first();
            $teacher->follwers =  $teacher->follwers + 1;
            $teacher->save();

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تمت المتابعة ',
                
            ]);
        }
    }


    
}
