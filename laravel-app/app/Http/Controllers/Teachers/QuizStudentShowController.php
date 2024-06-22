<?php

namespace App\Http\Controllers\Teachers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\QuizStart;
use App\Models\UserCourse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\QuizStartImage;
use App\Models\QuizUserAnswer;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class QuizStudentShowController extends Controller
{
    public function quiz_students_show($quiz_id,$user_id){

        $quiz_id = Crypt::decrypt($quiz_id);   
        $user_id = Crypt::decrypt($user_id);   
 
        return view('teachers.quiz_students_show.index',compact('quiz_id','user_id'));
    }

    public function get_all_quiz_students_show(Request $request,$quiz_id,$user_id)
    {
        if ($request->ajax()) {
            $quiz_id = Crypt::decrypt($quiz_id);   
            $user_id = Crypt::decrypt($user_id);   
            $data = QuizUserAnswer::where('user_id',$user_id)->where('quiz_id',$quiz_id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

               
                ->addColumn('image', function ($data) {
                    return view('teachers.quiz_students_show.btn.action', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }


    public function get_all_quiz_students_show_images(Request $request,$quiz_id,$user_id)
    {
        if ($request->ajax()) {
            $quiz_id = Crypt::decrypt($quiz_id);   
            $user_id = Crypt::decrypt($user_id);   

            $quiz_start_id = QuizStart::where('user_id',$user_id)->where('quiz_id',$quiz_id)->orderBy('id','desc')->first();
            if($quiz_start_id){
                $data = QuizStartImage::where('quiz_start_id',$quiz_start_id->id)->orderBy('id','desc');
            }else{
                $data = [];
            }
          
            return Datatables::of($data)

                ->addIndexColumn()

               
                ->addColumn('image', function ($data) {
                    return view('teachers.quiz_students_show.btn.action2', compact('data'));
                })

                ->addColumn('action3', function ($data) {
                    return view('teachers.quiz_students_show.btn.action3', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function send_notification($token,$title,$body,$order_id)
    {
        $from = "AAAAO0HvF7s:APA91bGnIXUIMpeJNaZKtTlghSEIOM8igliowU1OABoNluaJDDJurbr65ywq9FCDTRGuwQ9f0vhEuOkkQ8kEv9dyJnU7NALxsw9clqY9Nbbaw1V08YLoqr8uMWTm_1nhBr370Kioz0Z8";
        $to = $token;

        $msg = array
        (
            'title' => $title,
            'body' => $body,
            'sound' => "default"

        );

        $fields = array
        (
            'to' => $token,
            'notification' => $msg,
            'data' => [
                'bookingId' => $order_id,
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "screen" =>  "POST_SCREEN",

            ]
        );


        $headers = array
        (
            'Authorization: key=' . $from,
            'Content-Type: application/json'
        );
        //#Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }


    public function store_quiz_students_show(Request $request){
       
        $request->validate([
            'student_points'              => 'required|numeric',
        ]);

        $quiz_start = QuizStart::where('user_id',$request->user_id)->where('quiz_id',$request->quiz_id)->first();
        $quiz_points = Quiz::where('id',$request->quiz_id)->first();
        
        if($quiz_points->points < $request->student_points){
            return response()->json([
                'status' => false,
                'msg' => 'النقاط المدخله اكبر من النقاط المتاحه',
            ]);
        }
     

        $quiz_start = QuizStart::where('user_id',$request->user_id)->where('quiz_id',$request->quiz_id)->first();
        $quiz_start ->end_points                  = $request->student_points;
        $quiz_start ->waiting_pending                  ="quiz_complete";
        $quiz_start -> save();

        if ($request->hasFile('imagee')) {
          

            
            foreach($request->imagee as $imagees){

                $images = new QuizStartImage();
                
                $image_url =  $imagees->getClientOriginalName();

                $image_url =  (string) Str::uuid() . '-' . Carbon::now()->format('Y-m-d_H-i-s') . '.' . $imagees->getClientOriginalExtension();

                
                $base_url = url('attachments/quiz/'. $image_url );


                $imagees->move(public_path('attachments/quiz'), $image_url);


                $images->image   = $base_url;
                $images->quiz_start_id   = $quiz_start->id;
                $images->save();

            }
        }


        // تسجيل المجموع النهائي للنقاط للطالب في جدول ال usercourse لنفس الدورة
        $quizz       = Quiz::where('id',$request->quiz_id)->first();
        $section     = Lesson::where('id',$quizz->lesson_id)->first();
        $course      = Section::where('id',$section->section_id)->first();

        
        $user_course = UserCourse::where('user_id',$request->user_id)->where('course_id', $course->course_id)->first();
        if($user_course){

            $quiz_user_sta = QuizStart::where('user_id',$request->user_id)->where('course_id', $course->course_id)->first();

            if($quiz_user_sta){

                $quiz_user_sta_count = QuizStart::where('user_id',$request->user_id)->where('course_id', $course->course_id)->sum('end_points');
                $user_course->points = $quiz_user_sta_count;
                $user_course->save();

              
            }
        }


        $usernotification = \App\Models\Notification::create([
            'user_id' => $quiz_start->user_id,
            'title' => "تم تصحيح الاختبار" .  $quiz_points->name,
            'body' => "درجتك " . $request->student_points . " من " . $quiz_points->points,
           ]);
    
           $users = User::findOrFail($quiz_start->user_id);

           $title = "تم تصحيح الاختبار" .  $quiz_points->name;
           $body = "درجتك " . $request->student_points . " من " . $quiz_points->points;

           $this->send_notification($users->fcm_token, $title, $body, 0);

        


        if ($quiz_start) {
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
  
    }


    public function update_cities(Request $request){


        $request->validate([
            'city'              => 'required',        
        ]);


        $city = City::findorFail($request->id);

   
        $city->city            = $request->city;

        $city->save();

        if ($city) {
            return response()->json([
                'status' => true,
                'msg' => 'تم التعديل بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل التعديل برجاء المحاوله مجددا',
            ]);
        }
    }

    public function destroy_quiz_students_show(Request $request){
           
        $q = QuizStartImage::find($request->id);
        $q->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
