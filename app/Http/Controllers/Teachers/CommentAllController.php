<?php


namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Comment;
use App\Models\Section;
use App\Models\UserCourse;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\Quiz;
use Illuminate\Support\Facades\Auth;

class CommentAllController extends Controller
{
    public function all_comments(){
     
        return view('teachers.all_comments.index');
    }


    public function get_all_all_comments(Request $request)
    {

        if ($request->ajax()) {
            if(Auth::guard('teachers')->user()->parent == 0){
                $courses = Course::where('teacher_id',Auth::guard('teachers')->user()->id)->pluck('id');
            }else{
                $courses = Course::where('teacher_id',Auth::guard('teachers')->user()->parent)->pluck('id');
            }
          
            $data = Comment::whereIn('course_id',$courses)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()


                ->addColumn('user_name', function ($data) {
                   $user = User::where('id',$data->user_id)->first();
                   return $user->name ?? "-";
                })
                ->addColumn('image', function ($data) {
                   $user = User::where('id',$data->user_id)->first();
                   return  '<img src="'.$user->image.'" alt="" style="width:7%">';
                })
                ->addColumn('lesson_id', function ($data) {
                   $lesson = Lesson::where('id',$data->lesson_id)->first();
                   return $lesson->name ?? "-";
                })
                ->addColumn('course_id', function ($data) {
                   $course_id = Course::where('id',$data->course_id)->first();
                   return $course_id->name ?? "-";
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
            'sound' => 'default',

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

    public function send_notification_a($users_fcm_token,$title,$body,$order_id)
    {
        $from = "AAAAO0HvF7s:APA91bGnIXUIMpeJNaZKtTlghSEIOM8igliowU1OABoNluaJDDJurbr65ywq9FCDTRGuwQ9f0vhEuOkkQ8kEv9dyJnU7NALxsw9clqY9Nbbaw1V08YLoqr8uMWTm_1nhBr370Kioz0Z8";
        $to = $users_fcm_token;

        $msg = array
        (
            'title' => $title,
            'body' => $body,
            'sound' => 'default' // add sound for iOS and Android

        );

        $fields = array
        (
            'registration_ids' => $users_fcm_token,
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
    // public function send_notification_to_all(Request $request){
       
    //     $notifications = Notification::create([
    //           "user_id"      =>  0,
    //           "title"        => $request->title,
    //           "body"         => $request->body,
    //       ]);
  
       
    //       $title = $request->title;
    //       $body = $request->body;
          
    //       $totalUsers = User::count();
    //       $batchSize = 999;
    //       $totalBatches = ceil($totalUsers / $batchSize);
      
    //       for ($batch = 1; $batch <= $totalBatches; $batch++) {
    //           $offset = ($batch - 1) * $batchSize;
    //           $users_fcm_token = User::skip($offset)->take($batchSize)->pluck('fcm_token');
              
    //           $this->send_notification_a($users_fcm_token, $title, $body, $batch);
    //       }
  
         
         
    //       if ($notifications) {
    //           return response()->json([
    //               'status' => true,
    //               'msg' => 'تم الحفظ بنجاح',
    //           ]);
    //       } else {
    //           return response()->json([
    //               'status' => false,
    //               'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
    //           ]);
    //       }
    // }




    public function send_notification_to_supscribers(Request $request){

    
        $lesson =   Lesson::where('id',$request->sendnotifi)->first();
        $section =  Section::where('id',$lesson->section_id)->first();
        $course =   Course::where('id',$section->course_id)->first();

   

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        if($course){
            if($course->teacher_id != $teacher_id){
                return response()->json([
                    'status' => false,
                    'msg' => 'غير مصرح بك ',
                ]);
            }
        }
        


        $title = " درس جديد بانتظارك";
        $m1 = ' تم رفع ';
        $m2 = ' في دورة ';
        $m3 = ' مع تمنياتنا لكم بالتوفيق ';

        $body = $m1 .'(' . $lesson->name .')' . $m2 .'(' . $course->name .')' . $m3;
     
              
        $notifications = Notification::create([
            "user_id"      =>  0,
            "title"        => $title,
            "body"         => $body,
        ]);

        $user_course = UserCourse::where('course_id',$course->id)->pluck('user_id');
        $users = User::whereIn('id',$user_course)->pluck('fcm_token')->toArray();
    
        
        $chunked_fcm_tokens = array_chunk($users, 999); // تقسيم المصفوفة إلى مصفوفات فرعية

        foreach ($chunked_fcm_tokens as $batch => $batch_fcm_tokens) {

            $this->send_notification_a($batch_fcm_tokens, $title, $body, $batch + 1);

        }

        
        
       
        if ($notifications) {
            return response()->json([
                'status' => true,
                'msg' => 'تم الحفظ بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
    }


    public function send_notification_to_supscribers_quiz(Request $request){

    
   
        $quiz =    Quiz::where('id',$request->sendnotifi)->first();
        $lesson =  Lesson::where('id',$quiz->lesson_id)->first();
        $course =  Course::where('id',$lesson->course_id)->first();

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }
 
         if($course){
             if($course->teacher_id != $teacher_id){
                 return response()->json([
                     'status' => false,
                     'msg' => 'غير مصرح بك ',
                 ]);
             }
         }


        $title = " اختبار جديد بانتظارك";
        $m1 = ' تم نشر اختبار ';
        $m2 = ' في دورة ';
        $m3 = ' مع تمنياتنا لكم بالتوفيق ';

        if($quiz && $course){
            $body = $m1 .'(' . $quiz->name .')' . $m2 .'(' . $course->name .')' . $m3;
     
              
            $notifications = Notification::create([
                "user_id"      =>  0,
                "title"        => $title,
                "body"         => $body,
            ]);
    
            $user_course = UserCourse::where('course_id',$course->id)->pluck('user_id');
         
            $users = User::whereIn('id',$user_course)->pluck('fcm_token')->toArray();
    
            $chunked_fcm_tokens = array_chunk($users, 999); // تقسيم المصفوفة إلى مصفوفات فرعية
    
            foreach ($chunked_fcm_tokens as $batch => $batch_fcm_tokens) {
    
                $this->send_notification_a($batch_fcm_tokens, $title, $body, $batch + 1);
    
            }

        
            
          

            if ($notifications) {
                return response()->json([
                    'status' => true,
                    'msg' => 'تم الحفظ بنجاح',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
                ]);
            }
        }

      
       
  
    }



    public function store_cities(Request $request){
       
        $request->validate([
            'city'              => 'required',
       
        ]);

     

        $city = new City();
        $city ->city                  = $request->city;

        
        $city -> save();

   

        if ($city) {
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

    public function destroy_cities(Request $request){
           
        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
