<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Wallet;
use App\Models\Billing;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teachers\Teacher;
use App\Models\UserTopic;
use App\Models\CourseLike;
use App\Models\DataCourse;
use App\Models\UserCourse;
use App\Models\WalletCode;
use App\Models\TeacherCode;
use App\Models\ReviewCourse;
use App\Models\TeacherStudy;
use App\Models\TopicSubject;
use App\Models\VerifiedData;
use Illuminate\Http\Request;
use App\Models\VerifiedDataNew;
use App\Models\LessonAttachmetn;
use App\Models\TeacherCodeSection;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationTeacher;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\UserFollowTeacher;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class CourseController extends Controller
{


    public function send_verified_data(Request $request){


        $user = VerifiedData::where('user_id', Auth::guard('api')->user()->id)->orderBy('id','desc')->first();
        if($user){
          if($user->status == 0){
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'الطلب قيد المراجعة',
               
            ]);
          }
          if($user->status == 1){
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'الحساب موثق',
               
            ]);
          }
        }

        $request->validate([
         
            'front_image_id'      => 'required',
            'back_image_id'      => 'required',
        ]);

        $send_data = new VerifiedData();
        $send_data->user_id = Auth::guard('api')->user()->id;

     
        $send_data->full_name = $request->full_name;
        if(isset($request->code)){

            $send_data->code = $request->code;
        }
        
        if(isset($request->personal_photo)){
            if ($request->hasFile('personal_photo')) {
            
                //  اخزن اسم الصورة في الداتابيز
                 $image_url =  $request->personal_photo->getClientOriginalName();
    
                 $image_url =  rand(223423,23423444) . $image_url;
    
                 
                 $base_url = url('attachments/sliders/'. $image_url );
    
    
                 $send_data -> personal_photo   = $base_url;
    
                 $request->personal_photo-> move(public_path('attachments/sliders'), $image_url);
    
                   //  اخزن الصورة في السيرفر
                 //  $request->image->move('attachments/sliders/', $image_url);
       
    
            }
        }
     
     
     
        if ($request->hasFile('front_image_id')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->front_image_id->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/sliders/'. $image_url );


             $send_data -> front_image_id   = $base_url;

             $request->front_image_id-> move(public_path('attachments/sliders'), $image_url);

               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

        }
     
        if ($request->hasFile('back_image_id')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->back_image_id->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/sliders/'. $image_url );


             $send_data -> back_image_id   = $base_url;

             $request->back_image_id-> move(public_path('attachments/sliders'), $image_url);

               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   
        }
     

        $send_data->save();


        
        $users = User::whereIn('id',["1400","2","5582"])->get();

        $body = "تم ارسال طلب توثيق جديد" . " (" . $request->full_name . ")";
        $title  = "منصة مرماز اكاديمي";
        foreach($users as $user){
            
            $this->send_notification($user->fcm_token, $title, $body, 0);

        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'send data succsessfully',
           
        ]);


    }


    public function send_verified_data_new(Request $request){


        $user = VerifiedDataNew::where('user_id', Auth::guard('api')->user()->id)->orderBy('id','desc')->first();
        if($user){
          if($user->status == 0){
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'الطلب قيد المراجعة',
               
            ]);
          }
          if($user->status == 1){
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'الحساب موثق',
               
            ]);
          }
        }

        $request->validate([
            'code'           => 'required',
            'full_name'      => 'required',
            'front_image_id' => 'required',
            'back_image_id'  => 'required',
        ]);

        $send_data = new VerifiedDataNew();
        $send_data->user_id = Auth::guard('api')->user()->id;

     
        $send_data->full_name = $request->full_name;
        $send_data->code      = $request->code;
    
        $base_url = env('APP_URL');
        if ($request->hasFile('front_image_id')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->front_image_id->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/front_image_id/'. $image_url );


             $send_data -> front_image_id   = $base_url;

             $request->front_image_id-> move(public_path('attachments/front_image_id'), $image_url);

               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

        }
     
        if ($request->hasFile('back_image_id')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->back_image_id->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/back_image_id/'. $image_url );


             $send_data -> back_image_id   = $base_url;

             $request->back_image_id-> move(public_path('attachments/back_image_id'), $image_url);

               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   
        }
     

        $send_data->save();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'send data succsessfully',
           
        ]);


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


    public function recomende_coruses(){

        if(Auth::guard('api')->check()){

            // جبت كورسات عشوائية من الاهتمامات الخاصة بالطالب
            $user_topic_ids = UserTopic::where('user_id',Auth::guard('api')->user()->id)->inRandomOrder()->pluck('topic_id');



            $subject_ids_for_topic = TopicSubject::whereIn('topic_id',$user_topic_ids)->inRandomOrder()->pluck('subject_id');

            $courses_rate_up_four_start = Course::pluck('id');
            // هاد الكومنت على المقترحة لك
            // $courses = Course::whereIn('id',$courses_rate_up_four_start)->where('is_view',1)->where('level_id',Auth::guard('api')->user()->level)->whereIn('subject_id',$subject_ids_for_topic)->where('status',2)->inRandomOrder()->orderBy('rate','desc')->take(7)->get();

            // هاد الكومنت على الدورات الحديثة
            $courses = Course::where('is_view',1)->where('level_id',Auth::guard('api')->user()->level)->where('status',2)->orderBy('created_at','desc')->orderBy('id','desc')->take(7)->get();

        }else{

            $courses_rate_up_four_start = Course::pluck('id');

            $courses = Course::where('is_view',1)->where('status',2)->orderBy('created_at','desc')->orderBy('id','desc')->take(7)->get();
            // $courses = [];
        }



      
       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);


    }

    
    public function see_all_recomende_coruses(){

        if(Auth::guard('api')->check()){

           // جبت كورسات عشوائية من الاهتمامات الخاصة بالطالب
           $user_topic_ids = UserTopic::where('user_id',Auth::guard('api')->user()->id)->inRandomOrder()->pluck('topic_id');



           $subject_ids_for_topic = TopicSubject::whereIn('topic_id',$user_topic_ids)->inRandomOrder()->pluck('subject_id');
   
           $courses_rate_up_four_start = Course::pluck('id');

             // هاد الكومنت على المقترحة لك
             //    $courses = Course::whereIn('id',$courses_rate_up_four_start)->where('is_view',1)->where('level_id',Auth::guard('api')->user()->level)->whereIn('subject_id',$subject_ids_for_topic)->where('status',2)->inRandomOrder()->orderBy('rate','desc')->paginate(7);

            // هاد الكومنت على الدورات الحديثة
            $courses = Course::where('is_view',1)->where('level_id',Auth::guard('api')->user()->level)->where('status',2)->orderBy('id','desc')->paginate(7);
   
        }else{

            $courses_rate_up_four_start = Course::pluck('id');

            $courses = Course::whereIn('id',$courses_rate_up_four_start)->where('type','!=','private')->where('is_view',1)->where('status',2)->orderBy('id','desc')->paginate(7);
            // $courses = [];
        }
          
           return response()->json([
               'code'          => 200,
               'status'        => true,
               'message'       => 'fetch data succsessfully',
               'data'          => $courses,
           ]);


    }


    public function recomende_coruses_subject_id(Request $request){

  
        $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('status',2)->inRandomOrder()->take(10)->get();
        $courses = [];


       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);


    }


    public function see_all_recomende_coruses_subject_id(Request $request){


        $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('status',2)->inRandomOrder()->paginate(7);
        $courses = [];
       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);


    }


    public function search(Request $request){

        if(isset($request->subject_id)){

            
                if($request->type == "recomende_coruses"){
                    // جبت كورسات عشوائية من الاهتمامات الخاصة بالطالب
                    $user_topic_ids = UserTopic::where('user_id',Auth::guard('api')->user()->id)->inRandomOrder()->pluck('topic_id');
                    $subject_ids_for_topic = TopicSubject::whereIn('topic_id',$user_topic_ids)->inRandomOrder()->pluck('subject_id');
            

                    $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('name', 'Like', '%' . $request->name . '%')->where('status',2)->orderBy('rate','desc')->paginate(7);

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $courses,
                    ]); 

                }elseif($request->type == "subject_course"){
                    

                    $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('name', 'Like', '%' . $request->name . '%')->where('status',2)->orderBy('rate','desc')->paginate(7);

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $courses,
                    ]); 
        

                }elseif($request->type == "best_courses"){

                    $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('level_id',Auth::guard('api')->user()->level)->where('name', 'Like', '%' . $request->name . '%')->where('status',2)->orderBy('rate','desc')->take(10)->paginate(7);

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $courses,
                    ]);
            
                }elseif($request->type == "on_sale_course"){

                    $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('type',"paid_public")->where('status',2)->where('name', 'Like', '%' . $request->name . '%')->inRandomOrder()->take(7)->paginate(7);

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $courses,
                    ]);

                }elseif($request->type == "best_teacher"){

                    // $subjects_ids = Subject::where('level_id',Auth::guard('api')->user()->level)->pluck('id');

                    $teachers_id = Course::where('status',2)->where('is_view',1)->pluck('teacher_id');

                    $subject_teacherss = TeacherStudy::where('subject_id', $request->subject_id)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');
            
                    $teachers     = Teacher::where('subject_id',$request->subject_id)->where('is_acess',1)->where('name', 'Like', '%' . $request->name . '%')->where('parent',0)->orderBy('rate','desc')->take(10)->paginate(7);

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $teachers,
                    ]);
                    
                }elseif($request->type == "subjects"){

                    $course_is_subject = Course::where('status',2)->where('is_view',1)->pluck('subject_id');
             
                    $subjects = Subject::whereIn('id',$course_is_subject)->where('level_id',Auth::guard('api')->user()->level)->where('name', 'Like', '%' . $request->name . '%')->paginate(7);

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $subjects,
                    ]);

                    }elseif($request->type == "new_courses"){
                      
            
                        $courses = Course::where('subject_id',$request->subject_id)->where('status',2)->where('is_view',1)->where('level_id',Auth::guard('api')->user()->level)->where('name', 'Like', '%' . $request->name . '%')->orderBy('id','desc')->paginate(7);

                        return response()->json([
                            'code'          => 200,
                            'status'        => true,
                            'message'       => 'fetch data succsessfully',
                            'data'          => $courses,
                        ]);

                    
                    }elseif($request->type == "popular_teachers"){

                        $teachers_id = Course::where('status',2)->where('is_view',1)->pluck('teacher_id');

                        $subject_teacherss = TeacherStudy::where('subject_id', $request->subject_id)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');

                        $teachers = Teacher::where('id',$subject_teacherss)->where('is_acess',1)->where('name', 'Like', '%' . $request->name . '%')->where('parent',0)->orderBy('total_subscriptions','desc')->take(10)->paginate(7);
                        return response()->json([
                            'code'          => 200,
                            'status'        => true,
                            'message'       => 'fetch data succsessfully',
                            'data'          => $teachers,
                        ]);

                    }elseif($request->type == "popular_courses"){

                        $levels_id = Level::where('study_id',4)->pluck('id');
                        $subjects_ids = Subject::whereIn('level_id',$levels_id)->pluck('id');
                        $coruses_prevent_ids = Course::whereIn('subject_id',$subjects_ids)->pluck('id');
        
        
                        $courses = Course::where('level_id',Auth::guard('api')->user()->level)->where('subscriptions','>=',100)->whereNotIn('id',$coruses_prevent_ids)->where('is_view',1)->where('status',2)->orderBy('subscriptions','desc')->paginate(10);

                        $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('name', 'Like', '%' . $request->name . '%')->where('status',2)->orderBy('subscriptions','desc')->take(10)->paginate(7);
                        return response()->json([
                            'code'          => 200,
                            'status'        => true,
                            'message'       => 'fetch data succsessfully',
                            'data'          => $courses,
                        ]);
                    }
                    else{
                        return response()->json([
                            'code'          => 200,
                            'status'        => true,
                            'message'       => 'fetch data succsessfully',
                            'data'          => [],
                        ]);
                    }

        }else{

            
        if($request->type == "recomende_coruses"){
            // جبت كورسات عشوائية من الاهتمامات الخاصة بالطالب
            $user_topic_ids = UserTopic::where('user_id',Auth::guard('api')->user()->id)->inRandomOrder()->pluck('topic_id');
            $subject_ids_for_topic = TopicSubject::whereIn('topic_id',$user_topic_ids)->inRandomOrder()->pluck('subject_id');
       

            $courses = Course::whereIn('subject_id',$subject_ids_for_topic)->where('is_view',1)->where('name', 'Like', '%' . $request->name . '%')->where('status',2)->orderBy('rate','desc')->paginate(7);

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $courses,
            ]); 

        }elseif($request->type == "best_courses"){

            $courses = Course::where('level_id',Auth::guard('api')->user()->level)->where('is_view',1)->where('name', 'Like', '%' . $request->name . '%')->where('status',2)->orderBy('rate','desc')->take(10)->paginate(7);

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $courses,
            ]);
    
        }elseif($request->type == "on_sale_course"){

                    $courses = Course::where('type',"paid_public")->where('status',2)->where('is_view',1)->where('name', 'Like', '%' . $request->name . '%')->inRandomOrder()->take(7)->paginate(7);

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $courses,
                    ]);

                }elseif($request->type == "best_teacher"){

                    $subjects_ids = Subject::where('level_id',Auth::guard('api')->user()->level)->pluck('id');

                    $teachers_id = Course::where('status',2)->where('is_view',1)->pluck('teacher_id');

                    $subject_teacherss = TeacherStudy::whereIn('subject_id', $subjects_ids)->whereIn('teacher_id',$teachers_id)->pluck('teacher_id');
            
                    $teachers     = Teacher::whereIn('id',$subject_teacherss)->where('is_acess',1)->where('name', 'Like', '%' . $request->name . '%')->where('parent',0)->orderBy('rate','desc')->take(10)->paginate(7);

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $teachers,
                    ]);
                    
                }elseif($request->type == "subjects"){
                       
    
                    $course_is_subject = Course::where('status',2)->where('is_view',1)->pluck('subject_id');
             
                    $subjects = Subject::whereIn('id',$course_is_subject)->where('level_id',Auth::guard('api')->user()->level)->where('name', 'Like', '%' . $request->name . '%')->paginate(7);
                

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $subjects,
                    ]);

                }elseif($request->type == "new_courses"){
                 
    
                  
                    $course_is_subject = Course::where('status',2)->where('is_view',1)->pluck('subject_id');
            
            
                    $courses = Course::whereIn('subject_id',$course_is_subject)->where('is_view',1)->where('status',2)->where('level_id',Auth::guard('api')->user()->level)->where('name', 'Like', '%' . $request->name . '%')->orderBy('id','desc')->paginate(7);
             

                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $courses,
                    ]);

                
                }elseif($request->type == "popular_teachers"){
                    $teachers = Teacher::where('parent',0)->where('is_acess',1)->where('name', 'Like', '%' . $request->name . '%')->orderBy('total_subscriptions','desc')->take(10)->paginate(7);
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $teachers,
                    ]);

                }elseif($request->type == "popular_courses"){

                    if(Auth::guard('api')->check()){

                        $levels_id = Level::where('study_id',4)->pluck('id');
                        $subjects_ids = Subject::whereIn('level_id',$levels_id)->pluck('id');
                        $coruses_prevent_ids = Course::whereIn('subject_id',$subjects_ids)->pluck('id');
        
        
                        $courses = Course::where('level_id',Auth::guard('api')->user()->level)->where('name', 'Like', '%' . $request->name . '%')->where('subscriptions','>=',100)->whereNotIn('id',$coruses_prevent_ids)->where('is_view',1)->where('status',2)->orderBy('subscriptions','desc')->paginate(10);
                      
            
                    }else{
        
                        $levels_id = Level::where('study_id',4)->pluck('id');
                        $subjects_ids = Subject::whereIn('level_id',$levels_id)->pluck('id');
                        $coruses_prevent_ids = Course::whereIn('subject_id',$subjects_ids)->pluck('id');
            
                        $courses = Course::where('subscriptions','>=',100)->whereNotIn('id',$coruses_prevent_ids)->where('name', 'Like', '%' . $request->name . '%')->where('is_view',1)->where('status',2)->orderBy('subscriptions','desc')->paginate(10);
                      
            
                    }


                   
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $courses,
                    ]);
                }
                else{
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => [],
                    ]);
                }

        }

    }

    public function check_verifcations(){
        $user_ver = VerifiedData::where('user_id',Auth::guard('api')->user()->id)->orderBy('id','desc')->first();

        if($user_ver){
            if($user_ver->status == 1){
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'verified',
                    'message2'       => 'الحساب موثق',
                ]);
            }elseif($user_ver->status == 2){

                $not = Notification::where('user_id',Auth::guard('api')->user()->id)->where('is_verify',1)->orderBy('id','desc')->first();

                if(!$not){
                    return response()->json([
                        'code'          => 200,
                        'status'        => false,
                        'message'       =>  "decline_verifcation",
                        'message2'       =>  "",
                      
                    ]);
                }

                
                return response()->json([
                    'code'          => 200,
                    'status'        => false,
                    'message'       =>  "decline_verifcation",
                    'message2'       =>  $not->body,
                  
                ]);
            }else{
                return response()->json([
                    'code'          => 200,
                    'status'        => false,
                    'message'       => 'pending_verifcation',
                    'message2'       => 'الحساب قيد المراجعة',
                ]);
            }

        }else{
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'unverfied',
                'message2'       => 'الحساب غير موثق',
            ]);
        }


    }



    public function best_courses_home(){

        if(Auth::guard('api')->check()){

            $courses = Course::where('level_id',Auth::guard('api')->user()->level)->where('is_view',1)->where('rate','>=',4)->where('status',2)->orderBy('rate','desc')->take(10)->get();

        }else{

            $courses = Course::where('status',2)->where('rate','>=',4)->where('is_view',1)->orderBy('rate','desc')->take(10)->get();

        }


       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => [],
        ]);


    }


    public function see_all_best_courses_home(){

        if(Auth::guard('api')->check()){
              $courses = Course::where('level_id',Auth::guard('api')->user()->level)->where('is_view',1)->where('rate','>=',4)->where('status',2)->orderBy('rate','desc')->paginate(7);
        }else{
              $courses = Course::where('status',2)->where('rate','>=',4)->where('is_view',1)->inRandomOrder()->orderBy('rate','desc')->paginate(7);
        }

       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);


    }

    public function book_mark(Request $request){
        $user_course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();

        if(!$user_course){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'انت غير مشترك بالدورة',
                
            ]);
    
        }

        if($user_course->book_mark == 0){
            $user_course->book_mark = 1;
            $user_course->save();
        }else{
            $user_course->book_mark = 0;
            $user_course->save();
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'added  succsessfully',
          
        ]);

    }

    public function get_all_courses_book_mark(){
        $user_courses = UserCourse::where('user_id', Auth::guard('api')->user()->id)->where('book_mark',1)->orderBy('updated_at','desc')->pluck('course_id');
        $data = Course::where('is_view',1)->whereIn('id',$user_courses)->paginate(10);

        // $temp =json_decode($user_courses);
        // $tempStr = implode(',', $temp);
      
        // $data = DB::table('courses')
        //     ->whereIn('id', $temp)
        //     ->orderByRaw(DB::raw("FIELD(id, $tempStr)"))
        //     ->paginate(10); 

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $data,
        ]);
    
       
    }



    public function best_courses_subject_id(Request $request){


        $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('rate','>=',4)->where('status',2)->orderBy('rate','desc')->take(10)->get();
        $courses = [];

       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);


    }


    public function see_all_best_courses_subject_id(Request $request){


        $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('rate','>=',4)->where('status',2)->orderBy('rate','desc')->paginate(7);
        $courses = [];
       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);


    }



    public function popular_courses(Request $request){
            

           

        if(Auth::guard('api')->check()){

            $levels_id = Level::where('study_id',4)->pluck('id');
            $subjects_ids = Subject::whereIn('level_id',$levels_id)->pluck('id');
            $coruses_prevent_ids = Course::whereIn('subject_id',$subjects_ids)->pluck('id');


            $courses = Course::where('level_id',Auth::guard('api')->user()->level)->whereNotIn('id',[118])->where('subscriptions','>=',100)->whereNotIn('id',$coruses_prevent_ids)->where('is_view',1)->where('status',2)->orderBy('subscriptions','desc')->paginate(10);
          

        }else{

            $levels_id = Level::where('study_id',4)->pluck('id');
            $subjects_ids = Subject::whereIn('level_id',$levels_id)->pluck('id');
            $coruses_prevent_ids = Course::whereIn('subject_id',$subjects_ids)->pluck('id');

            $courses = Course::where('subscriptions','>=',100)->whereNotIn('id',$coruses_prevent_ids)->whereNotIn('id',[118])->where('is_view',1)->where('status',2)->orderBy('subscriptions','desc')->paginate(10);
          

        }


        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]); 
}





    public function popular_course_subject_id(Request $request){


        // $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('status',2)->orderBy('subscriptions','desc')->take(10)->get();
        $courses = [];

       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);


    }


    public function see_all_popular_course_subject_id(Request $request){


        // $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('status',2)->orderBy('subscriptions','desc')->paginate(7);
        $courses = [];

       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);


    }





    // الدورات التي تحتوي على خصم

    public function on_sale_course_home(){

        if(Auth::guard('api')->check()){

            $courses = Course::where('level_id',Auth::guard('api')->user()->level)->where('discount','!=',0)->where('is_view',1)->where('type',"paid_public")->where('status',2)->inRandomOrder()->take(7)->get();

        }else{

            $courses = Course::where('type',"paid_public")->where('discount','!=',0)->where('status',2)->where('is_view',1)->inRandomOrder()->take(7)->get();

        }

       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);

    }


    public function see_all_on_sale_course_home(){

        if(Auth::guard('api')->check()){

            $courses = Course::where('level_id',Auth::guard('api')->user()->level)->where('discount','!=',0)->where('is_view',1)->where('type',"paid_public")->where('status',2)->inRandomOrder()->paginate(7);
            
        }else{

            $courses = Course::where('type',"paid_public")->where('discount','!=',0)->where('status',2)->where('is_view',1)->inRandomOrder()->paginate(7);
            
        }

       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);

    }





    public function like_or_remove_like_course(Request $request){
        $user = CourseLike::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
    

        if(isset($user)){
            
            if($user->wishlist == 1){
                $user->wishlist  = 0;
                $user->save();
            }else{
                $user->wishlist  = 1;
                $user->save();
            }
        }else{
            $user = new CourseLike();
            $user->user_id = Auth::guard('api')->user()->id;
            $user->course_id = $request->course_id;
            $user->wishlist = 1;
            $user->save();
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'Is succsessfully',
       
        ]);



    }


    public function new_courses_subject_id(Request $request){
        $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('status',2)->orderBy('id','desc')->take(7)->get();
   

       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);
    }



    public function see_all_new_courses_subject_id(Request $request){
        $courses = Course::where('subject_id',$request->subject_id)->where('is_view',1)->where('status',2)->orderBy('id','desc')->paginate(7);
     
       
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $courses,
        ]);
    }


    public function course_over_view(Request $request){


        $course = Course::where('id',$request->course_id)->where('status',2)->first();



        // حساب الشركة ما احسبو من ضمن المشتركين
        $user = User::where('mobile',"009647703391199")->first();

        $user_course_count = UserCourse::where('course_id',$request->course_id)->where('user_id','!=',$user->id)->count();


        $course4 = Course::where('id',$request->course_id)->first();
        $course4->subscriptions = $user_course_count;
        $course4->save();

        if(Auth::guard('api')->check()){

            $user_course = UserCourse::where('course_id',$request->course_id)->where('user_id',Auth::guard('api')->user()->id)->first();
            if($user_course){

                $user_course = $user_course->status;
            }else{
                $user_course = 1;
            }
        }else{
            
            $user_course = 1;
        }



        if(!$course){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
        
            ]);

        }


        $course['level'] = Level::where('id',$course->level_id)->pluck('name')->first();
        $course['sections_count'] = Section::where('course_id',$course->id)->count();

        $sections_id = Section::where('course_id',$course->id)->pluck('id');

        $course['lessons_count'] = Lesson::whereIn('section_id',$sections_id)->where('link','!=',NULL)->where('status_node',1)->where('status_laravel',1) ->where('is_scheduler',1)->count();
        $course['teacher_name']  = Teacher::where('id',$course->teacher_id)->where('parent',0)->first();

        if($course){
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $course,
                'teacher_course_status'   => $user_course,
                'teacher_telegram_id'   => $course['teacher_name']->telegram
            ]);

        }else{
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'not found',
        
            ]);
        }

    }
    
    // public function course_sections(Request $request){

    //  if(Auth::guard('api')->check()){
    //     $is_subscripe_course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
        
 

    //     // اذا كان مشترك في الدورة
    //     if($is_subscripe_course){
         
          

    //           // في حال تم تعطيل الدورة من قبل الاستاذ
    //             if($is_subscripe_course->status == 0){

    //                 return response()->json([
    //                     'code'          => 401,
    //                     'status'        => false,
    //                     'message'       => 'تم تعطيل الدورة من قبل الاستاذ',
                    
    //                 ]);
            
    //             }
      
             
               
    //             $sections = Section::where('course_id',$request->course_id)->orderBy('id','asc')->get();

    //             // $sections = $sections->filter(function ($section) {
    //             //     $section["lessons"] = \App\Models\SubscripeLesson\Lesson::where('section_id',$section->id)
    //             //     ->where("status_laravel",1)
    //             //     ->where("status_node",1)
    //             //     ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
    //             //     ->where('link', '!=', NULL)
    //             //     ->where('is_scheduler',1)->orderBy('created_at','asc')->get();
    //             //     return $section["lessons"]->count() > 0;
    //             // });
    //             // $sections = $sections->values();
                


    //      }else{
           
    //         $sections = Section::where('course_id', $request->course_id)
    //         ->orderBy('id', 'asc')
    //         ->get();
    //         // ->filter(function ($section) {
    //         //     $section["lessons"] = Lesson::where('section_id', $section->id)
    //         //         ->where("status_laravel",1)
    //         //         ->where("status_node",1)
    //         //         ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
    //         //         ->where('link', '!=', NULL)
    //         //         ->where('is_scheduler',1)
    //         //         ->orderBy('created_at','asc')
    //         //         ->get()
    //         //         ->except('link');
    //         //     return $section["lessons"]->count() > 0;
    //         // });
            
    //         // $sections = $sections->values();

    //      }

     
    //      $progress = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
   

      

       
    //         if($progress){
    //             return response()->json([
    //                 'code'          => 200,
    //                 'status'        => true,
    //                 'message'       => 'fetch data succsessfully',
    //                 'data'          => $sections,
    //                 'progress'          => $progress->progress,
                
    //             ]);
    //         }else{
    //             return response()->json([
    //                 'code'          => 200,
    //                 'status'        => true,
    //                 'message'       => 'fetch data succsessfully',
    //                 'data'          => $sections,
    //                 'progress'      => 0,
                
    //             ]);
    //         }

    //     }else{


    //         $sections = Section::where('course_id',$request->course_id)->orderBy('id','asc')->get();

    //         // $sections = $sections->filter(function ($section) {
    //         //     $section["lessons"] = \App\Models\SubscripeLesson\Lesson::where('section_id',$section->id)
    //         //     ->where("status_laravel",1)
    //         //     ->where("status_node",1)
    //         //     ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
    //         //     ->where('is_scheduler',1)
    //         //     ->orderBy('created_at','asc')
    //         //     ->where('link','!=',NULL)->get();
    //         //     return $section["lessons"]->count() > 0;
    //         // });
    //         // $sections = $sections->values();
            

    //         return response()->json([
    //             'code'          => 200,
    //             'status'        => true,
    //             'message'       => 'fetch data succsessfully',
    //             'data'          => $sections,
    //             'progress'          =>0,
            
    //         ]);


    //   }
      
     
    // }
    
   public function course_sections(Request $request)
{
    $progress = 0;
    // Check for authenticated API user 
    if (Auth::guard('api')->check()) {
        $userCourse = UserCourse::where('user_id', Auth::guard('api')->user()->id)
        ->where('course_id', $request->course_id)
        ->first();
        
         // Retrieve progress for subscribed user, default to 0 if not found
         $progress = $userCourse ? $userCourse->progress : 0;
    }

    // Fetch sections based on subscription status and course availability
    $sections = Section::where('course_id', $request->course_id)
             ->whereHas('lessons') 
            ->orderBy('id', 'asc')
            ->get();

    // Send response with fetched data and progress
    return response()->json([
        'code' => 200,
        'status' => true,
        'message' => 'Fetch data successfully',
        'data' => $sections,
        'progress' => $progress,
    ]);
}


public function course_lessons_by_section(Request $request)
{
    $section_id = $request->section_id;

    // Fetch lessons efficiently using eager loading
    $lessons = Lesson::where('section_id', $section_id)
        ->select(['id', 'name', 'descriptions','link', 'is_comment_disabled', 'type', 'type_video', 'long_video'])
        ->where('status_laravel', 1)
        ->where('status_node', 1)
        ->where('link', '<>', NULL) // Conditional for link based on authentication
        ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
        ->where('is_scheduler', 1)
        ->orderByRaw('IF(order_index IS NOT NULL, 0, 1), 
                                order_index ASC, 
                                created_at ASC
                        ')
        ->get();

    // Handle authentication and authorization
    if (Auth::guard('api')->check()) {
        
        $user = Auth::guard('api')->user();
        
        $is_subscribed_course = UserCourse::where('user_id', $user->id)
            ->where('course_id', $request->course_id)
            ->first();

        if ($is_subscribed_course) {
            if ($is_subscribed_course->status === 0) {
                return response()->json([
                    'code' => 401,
                    'status' => false,
                    'message' => 'تم تعطيل الدورة من قبل الاستاذ',
                ]);
            }
            
            $lessons = $lessons->makeVisible(['link']);
        }
    }

    return response()->json([
        'code' => 200,
        'status' => true,
        'message' => 'fetch data successfully',
        'data' => $lessons, // Group lessons by section
    ]);
}



    
    //  public function course_lessons_by_section(Request $request){
    
    // $section_id =  $request->section_id;
    

    //  if(Auth::guard('api')->check()){
    //     $is_subscripe_course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
        
 

    //     // اذا كان مشترك في الدورة
    //     if($is_subscripe_course){
         
          

    //           // في حال تم تعطيل الدورة من قبل الاستاذ
    //             if($is_subscripe_course->status == 0){

    //                 return response()->json([
    //                     'code'          => 401,
    //                     'status'        => false,
    //                     'message'       => 'تم تعطيل الدورة من قبل الاستاذ',
                    
    //                 ]);
            
    //             }
      
               
             
               
    //             $sections = Section::where('course_id',$request->course_id)
    //             ->where('id', $section_id)->orderBy('id','asc')->get();

    //             $sections = $sections->filter(function ($section) {
    //                 $section["lessons"] = \App\Models\SubscripeLesson\Lesson::where('section_id',$section->id)
    //                 ->where("status_laravel",1)
    //                 ->where("status_node",1)
    //                 ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
    //                 ->where('link', '!=', NULL)
    //                 ->where('is_scheduler',1)->orderBy('created_at','asc')->get();
    //                 return $section["lessons"]->count() > 0;
    //             });
    //             $sections = $sections->values();
                


    //      }else{
           
             
           
    //         $sections = Section::where('course_id', $request->course_id)
    //         ->where('id', $section_id)
    //         ->orderBy('id', 'asc')
    //         ->get()
    //         ->filter(function ($section) {
    //             $section["lessons"] = Lesson::where('section_id', $section->id)
    //                 ->where("status_laravel",1)
    //                 ->where("status_node",1)
    //                 ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
    //                 ->where('link', '!=', NULL)
    //                 ->where('is_scheduler',1)
    //                 ->orderBy('created_at','asc')
    //                 ->get()
    //                 ->except('link');
    //             return $section["lessons"]->count() > 0;
    //         });
            
    //         $sections = $sections->values();

    //      }

    //             return response()->json([
    //                 'code'          => 200,
    //                 'status'        => true,
    //                 'message'       => 'fetch data succsessfully',
    //                 'data'          => $sections,
    //                 'progress'      => 0,
                
    //             ]);
            

    //     }else{
    //         $sections = Section::where('course_id',$request->course_id)
    //         ->where('id', $section_id)
    //         ->orderBy('id','asc')->get();

    //         $sections = $sections->filter(function ($section) {
    //             $section["lessons"] = \App\Models\SubscripeLesson\Lesson::where('section_id',$section->id)
    //             ->where("status_laravel",1)
    //             ->where("status_node",1)
    //             ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
    //             ->where('is_scheduler',1)
    //             ->orderBy('created_at','asc')
    //             ->where('link','!=',NULL)->get();
    //             return $section["lessons"]->count() > 0;
    //         });
    //         $sections = $sections->values();
            

    //         return response()->json([
    //             'code'          => 200,
    //             'status'        => true,
    //             'message'       => 'fetch data succsessfully',
    //             'data'          => $sections,
    //         ]);
    //   }
    // }


    public function course_lessons(Request $request){

     if(Auth::guard('api')->check()){
        $is_subscripe_course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
        
 

        // اذا كان مشترك في الدورة
        if($is_subscripe_course){
         
          

              // في حال تم تعطيل الدورة من قبل الاستاذ
                if($is_subscripe_course->status == 0){

                    return response()->json([
                        'code'          => 401,
                        'status'        => false,
                        'message'       => 'تم تعطيل الدورة من قبل الاستاذ',
                    
                    ]);
            
                }
      
             
               
                $sections = Section::where('course_id',$request->course_id)->orderBy('id','asc')->get();

                $sections = $sections->filter(function ($section) {
                    $section["lessons"] = \App\Models\SubscripeLesson\Lesson::where('section_id',$section->id)
                    ->where("status_laravel",1)
                    ->where("status_node",1)
                    ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
                    ->where('link', '!=', NULL)
                    ->where('is_scheduler',1)->orderByRaw('
                           IF(order_index IS NOT NULL, 0, 1), 
                                order_index ASC, 
                                created_at ASC
                        ')->get();
                    return $section["lessons"]->count() > 0;
                });
                $sections = $sections->values();
                


         }else{
           
            $sections = Section::where('course_id', $request->course_id)
            ->orderBy('id', 'asc')
            ->get()
            ->filter(function ($section) {
                $section["lessons"] = Lesson::where('section_id', $section->id)
                    ->where("status_laravel",1)
                    ->where("status_node",1)
                    ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
                    ->where('link', '!=', NULL)
                    ->where('is_scheduler',1)
                    ->orderByRaw('
                           IF(order_index IS NOT NULL, 0, 1), 
                                order_index ASC, 
                                created_at ASC
                        ')
                    ->get()
                    ->except('link');
                return $section["lessons"]->count() > 0;
            });
            $sections = $sections->values();

         }

     
         $progress = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
   

      

       
            if($progress){
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'fetch data succsessfully',
                    'data'          => $sections,
                    'progress'          => $progress->progress,
                
                ]);
            }else{
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'fetch data succsessfully',
                    'data'          => $sections,
                    'progress'      =>0,
                
                ]);
            }

        }else{


            $sections = Section::where('course_id',$request->course_id)->orderBy('id','asc')->get();

            $sections = $sections->filter(function ($section) {
                $section["lessons"] = \App\Models\SubscripeLesson\Lesson::where('section_id',$section->id)
                ->where("status_laravel",1)
                ->where("status_node",1)
                ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
                ->where('is_scheduler',1)
                ->orderByRaw('
                           IF(order_index IS NOT NULL, 0, 1), 
                                order_index ASC, 
                                created_at ASC
                        ')
                ->where('link','!=',NULL)->get();
                return $section["lessons"]->count() > 0;
            });
            $sections = $sections->values();
            

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $sections,
                'progress'          =>0,
            
            ]);


      }
      
     
    }


    public function course_lessons_new(Request $request){

     if(Auth::guard('api')->check()){
        $is_subscripe_course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
        
 

        // اذا كان مشترك في الدورة
        if($is_subscripe_course){
         
          

              // في حال تم تعطيل الدورة من قبل الاستاذ
                if($is_subscripe_course->status == 0){

                    return response()->json([
                        'code'          => 401,
                        'status'        => false,
                        'message'       => 'تم تعطيل الدورة من قبل الاستاذ',
                    
                    ]);
            
                }
      
             
               
                $sections = Section::where('course_id',$request->course_id)->orderBy('id','asc')->paginate(1);

                $sections = $sections->filter(function ($section) {
                    $section["lessons"] = \App\Models\SubscripeLesson\Lesson::where('section_id',$section->id)
                    ->where("status_laravel",1)
                    ->where("status_node",1)
                    ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
                    ->where('link', '!=', NULL)
                    ->where('is_scheduler',1)->orderByRaw('
                           IF(order_index IS NOT NULL, 0, 1), 
                                order_index ASC, 
                                created_at ASC
                        ')->get();
                    return $section["lessons"]->count() > 0;
                });
                $sections = $sections->values();
                


         }else{
           
            $sections = Section::where('course_id', $request->course_id)
            ->orderBy('id', 'asc')
            ->paginate(1)
            ->filter(function ($section) {
                $section["lessons"] = Lesson::where('section_id', $section->id)
                    ->where("status_laravel",1)
                    ->where("status_node",1)
                    ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
                    ->where('link', '!=', NULL)
                    ->where('is_scheduler',1)
                    ->orderByRaw('
                           IF(order_index IS NOT NULL, 0, 1), 
                                order_index ASC, 
                                created_at ASC
                        ')
                    ->get()
                    ->except('link');
                return $section["lessons"]->count() > 0;
            });
            $sections = $sections->values();

         }

     
         $progress = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
   

      

       
            if($progress){
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'fetch data succsessfully',
                    'data'          => $sections,
                    'progress'          => $progress->progress,
                
                ]);
            }else{
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'fetch data succsessfully',
                    'data'          => $sections,
                    'progress'      =>0,
                
                ]);
            }

        }else{


            $sections = Section::where('course_id',$request->course_id)->orderBy('id','asc')->get();

            $sections = $sections->filter(function ($section) {
                $section["lessons"] = \App\Models\SubscripeLesson\Lesson::where('section_id',$section->id)
                ->where("status_laravel",1)
                ->where("status_node",1)
                ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
                ->where('is_scheduler',1)
                ->orderBy('created_at','asc')
                ->where('link','!=',NULL)->get();
                return $section["lessons"]->count() > 0;
            });
            $sections = $sections->values();
            

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $sections,
                'progress'          =>0,
            
            ]);


      }
      
     
    }

    public function lesson_by_id(Request $request){

        // بفحص في الدرس التعريفي اذا من نوع مرئي بخليه يدخل عليه مباشرة بدون ما افحص اذا مشترك او لا
        $lesson = \App\Models\SubscripeLesson\Lesson::where('id',$request->lesson_id)->where('status_node',1)->where('status_laravel',1) ->where('is_scheduler',1)->first();
        $lesson['section_name'] = Section::where('id',$lesson->section_id)->pluck('name')->first();

        if($lesson->type_video == "vdocipher"){
            
           
                $response = Http::withHeaders([
                'Authorization' => 'Apisecret jI0b8DWfyUfcr8vsmHn4Svd9Skhen4y8KlhVjFA6j2gBGhOVUCBPkFR1IFl9bFzZ',
            ])->get('https://dev.vdocipher.com/api/videos/'.$lesson->video_id_vdocipher.'/otp');
    
          
            $lesson['vdocipher'] = $response->json();
          
        }else{
            $lesson['vdocipher'] = null; 
        }
        
        if(!$lesson){
              return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'Not found',
                'data'          => $lesson,
            ]);
        }

        if($lesson->type == 'visable'){
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $lesson,
            ]);
        }



        if(Auth::guard('api')->check()){
            // بفحص اذا مشترك او الدرس موجود او لا
            $course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
            if($course){
                $lesson = \App\Models\SubscripeLesson\Lesson::where('id',$request->lesson_id) ->where('is_scheduler',1)->first();
                $lesson['section_name'] = Section::where('id',$lesson->section_id)->pluck('name')->first();

                if($lesson->type_video == "vdocipher"){
                
try {
                    $response = Http::withHeaders([
                        'Authorization' => 'Apisecret BaKF1pCeOhosgNHLhWsHYZcRIGn8BDSbOTCUvb7yyCyJwWIGlcJJHd99U6rP7Sge',
                    ])->get('https://dev.vdocipher.com/api/videos/'.$lesson->video_id_vdocipher.'/otp');
            
                    
                    $lesson['vdocipher'] = $response->json();
} catch (\Exception $e) {
               return response()->json([
                   'code'          => 200,
                        'status'        => false,
                        'message'       => $e,
                   ]);
           }
                }else{
                    $lesson['vdocipher'] = null; 
                }

                if($lesson){
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data'          => $lesson,
                    ]);
                }
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'lesson not found',
                    
                ]);
                

            }else{
                return response()->json([
                    'code'          => 401,
                    'status'        => false,
                    'message'       => 'انت غير مشترك في الدورة',
                    
                ]);
            }
        }
     
   
    }

    public function lesson_by_id_new(Request $request){
        
        // بفحص في الدرس التعريفي اذا من نوع مرئي بخليه يدخل عليه مباشرة بدون ما افحص اذا مشترك او لا
        $lesson = \App\Models\SubscripeLesson\Lesson::where('id',$request->lesson_id)->where('status_node',1)->where('status_laravel',1) ->where('is_scheduler',1)->first();
        $lesson['section_name'] = Section::where('id',$lesson->section_id)->pluck('name')->first();

        if($lesson->type_video == "vdocipher"){
            
            $response = Http::withHeaders([
                'Authorization' => 'Apisecret BaKF1pCeOhosgNHLhWsHYZcRIGn8BDSbOTCUvb7yyCyJwWIGlcJJHd99U6rP7Sge',
            ])->get('https://dev.vdocipher.com/api/videos/'.$lesson->video_id_vdocipher.'/otp');
    
          
            $lesson['vdocipher'] = $response->json();
        }else{
            $lesson['vdocipher'] = null; 
        }

        if($lesson->link == null){
            
            $lesson['link'] = null;

        }else{

            $key = '&5P483usHDhA32JUj55@CdcrbupasysB'; // 256-bit key
            $iv = '0123456789abcdef'; // 16-byte IV
            $plaintext =  $lesson->link;
            $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);

            $ciphertextho =  base64_encode($ciphertext);


            $lesson['link'] = $ciphertextho;

        }
        
       
        
        if(!$lesson){
              return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'Not found',
                'data'          => $lesson,
            ]);
        }

        if($lesson->type == 'visable'){
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data'          => $lesson,
            ]);
        }


        // بفحص اذا مشترك او الدرس موجود او لا
        $course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
        if($course){
            $lesson = \App\Models\SubscripeLesson\Lesson::where('id',$request->lesson_id) ->where('is_scheduler',1)->first();
            $lesson['section_name'] = Section::where('id',$lesson->section_id)->pluck('name')->first();

            if($lesson->type_video == "vdocipher"){
            
                $response = Http::withHeaders([
                    'Authorization' => 'Apisecret jI0b8DWfyUfcr8vsmHn4Svd9Skhen4y8KlhVjFA6j2gBGhOVUCBPkFR1IFl9bFzZ',
                ])->get('https://dev.vdocipher.com/api/videos/'.$lesson->video_id_vdocipher.'/otp');
        
                
                // $lesson['vdocipher'] = $response->json();
                
                // Check if the request was successful (status code 2xx)
                if ($response->successful()) {
                    $lesson['vdocipher'] = $response->json();
                } else {
                   $errorReason = $response->status().' '.$response->reason();
                    $lesson['vdocipher'] = ['error' => 'Failed to retrieve data. Reason: '.$errorReason];
                 }
            }else{
                $lesson['vdocipher'] = null; 
            }

            if($lesson){

                
                if($lesson->link == null){
          
            
                    $lesson['link'] = null;
        
                }else{
        
                    $key = '&5P483usHDhA32JUj55@CdcrbupasysB'; // 256-bit key
                    $iv = '0123456789abcdef'; // 16-byte IV
                    $plaintext =  $lesson->link;
                    $ciphertext = openssl_encrypt($plaintext, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
        
                    $ciphertextho =  base64_encode($ciphertext);
        
        
                    $lesson['link'] = $ciphertextho;
        
                }
        
                // $lesson->appendProgressAttribute();

                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'fetch data succsessfully',
                    'data'          => $lesson,
                ]);
            }
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'lesson not found',
                
            ]);
          
    
        }else{
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'انت غير مشترك في الدورة',
             
            ]);
        }
   
    }


    public function course_reviews(Request $request){

        $sections = Section::where('course_id',$request->course_id)->orderBy('id','asc')->get();

        foreach($sections as $section){
            $section["lessons"] = Lesson::where('section_id',$section->id)->where('link','!=',NULL)->where('status_node',1)->where('status_laravel',1) ->where('is_scheduler',1)->get();
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $sections,
        ]);

     
    }

    
    public function add_course_reviews(Request $request){

        $course = Course::where('id',$request->course_id)->where('is_view',1)->where('status',2)->first();
        

        if($course){

            $if_rate = ReviewCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
            if($if_rate){
                
                $if_rate->rate = $request->rate;
                if(isset($request->comment)){

                    $if_rate->comment = $request->comment;
                }
                $if_rate->save();

                // بعد التقييم...اخذ معدل التقييمات للكورس واخزنه في جدول الكورس

                $all_reviews_course = ReviewCourse::where('course_id',$request->course_id)->avg('rate');
                
               
           
                $course->rate = $all_reviews_course;
                $course->save();

                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'added succsessfully',
                    'rate_id'       => $if_rate->id,
                  
                ]);

               

            }else{

                $add_review_course = new ReviewCourse();
                $add_review_course->user_id = Auth::guard('api')->user()->id;
                $add_review_course->course_id = $request->course_id;
                $add_review_course->rate = $request->rate;
                if(isset($request->comment)){
                  $add_review_course->comment = $request->comment;
                }
                $add_review_course->save();
    
    
                $all_reviews_course = ReviewCourse::where('course_id',$request->course_id)->avg('rate');
               
           
                $course->rate = $all_reviews_course;
                $course->save();

                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'added succsessfully',
                    'rate_id'       => $add_review_course->id,
                  
                ]);
            }


        
       }else{

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'not found ',
          
        ]);

       }
     


      

     
    }



    public function send_progress_lesson(Request $request){

        $user_progress = DataCourse::where('course_id',$request->course_id)
                ->where('lesson_id',$request->lesson_id)
                ->where('user_id',Auth::guard('api')->user()->id)->first();

        if($user_progress){

            $user_progress->progress =  $request->progress;
            $user_progress->save();

            $progress = DataCourse::where('course_id',$request->course_id)->avg('progress');

            $user_course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
            $user_course->progress = $progress;
            $user_course->save();
           

        }else{

            $user_if_subscripe = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
            if($user_if_subscripe){

                $data_course = new DataCourse();
                $data_course->user_id =   Auth::guard('api')->user()->id;
                $data_course->progress =  $request->progress;
                $data_course->lesson_id = $request->lesson_id;
                $data_course->course_id = $request->course_id;
                $data_course->save();
    
                $progress = DataCourse::where('course_id',$request->course_id)->avg('progress');
    
                $user_course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
                $user_course->progress = $progress;
                $user_course->save();

            }
            
        }



        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'added succsessfully',
        ]);
     
    }

    
    //  الدورات المشترك فيها
    public function recent_courses(){
        
     

        $user_course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->pluck('course_id');
   


        $data = Course::whereIn('id', $user_course)->where('status',2)->paginate(10);

       
  

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $data,
        ]);

    }


    public function courses_favorites(){


        $courses_ids = CourseLike::where('user_id',Auth::guard('api')->user()->id)->where('wishlist',1)->orderBy('id','desc')->pluck('course_id');


        // ترتيب على نفس شكل المصفوفة من ال  where in
        $temp =json_decode($courses_ids);
        $tempStr = implode(',', $temp);
    
        $data = Course::whereIn('id', $temp)->where('is_view',1)->where('status',2)
            ->orderByRaw(DB::raw("FIELD(id, $tempStr)"))
            ->paginate(10);

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $data,
        ]);

    }



    public function courses_in_progress(){


   
        $recent_courses_ids = DataCourse::where('user_id',Auth::guard('api')->user()->id)->where('progress',"!=",100)->orderBy('id','desc')->pluck('course_id');


        // ترتيب على نفس شكل المصفوفة من ال  where in
        $temp =json_decode($recent_courses_ids);
        $tempStr = implode(',', $temp);
        
        $data = Course::whereIn('id', $temp)->where('status',2)
            ->orderByRaw(DB::raw("FIELD(id, $tempStr)"))
            ->paginate(10);

    

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $data,
        ]);
   
    }


    public function courses_complete(){


   
        $recent_courses_ids = DataCourse::where('user_id',Auth::guard('api')->user()->id)->where('progress',100)->orderBy('id','desc')->pluck('course_id');


        // ترتيب على نفس شكل المصفوفة من ال  where in
        $temp =json_decode($recent_courses_ids);
        $tempStr = implode(',', $temp);
        
        $data = Course::whereIn('id', $temp)->where('status',2)
            ->orderByRaw(DB::raw("FIELD(id, $tempStr)"))
            ->paginate(10);

    

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $data,
        ]);
   
    }


    public function subscripe_course(Request $request){



            $course = Course::where('id',$request->course_id)->where('is_view',1)->where('status',2)->first();

            if(!$course){
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'لا يوجد كورس  ',
                    'message2'       => '  الكورس غير مفعل ',
                ]);
            }


            $user = User::where('id',Auth::guard('api')->user()->id)->first();

            if(!$user){
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'user not found ',
                ]);
            }


            // عشان اعرف انو مسجل عن طريق ريجستر تو يعني تبع ابل الي مسجل وبخليه يسجل ع طول
            $user_apple = VerifiedData::where('user_id',Auth::guard('api')->user()->id)->where("personal_photo","dd")->first();
            if($user_apple){

                    // تسجيل الشخص في الاشتراك
                    $user_courses = new UserCourse();
                    $user_courses->user_id = Auth::guard('api')->user()->id;
                    $user_courses->course_id = $request->course_id;
                    $user_courses->save();
                    
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'لقد حصلت على هذه الدورة بنجاح',
                    ]);

            }


            




            // تسجيل حساب الشركة حالة خاصة
            if($user->mobile == "009647703391199"){

                $if_is_subscripe = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
                if($if_is_subscripe){
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'انت مشترك بالكورس بالفعل',
                    ]);
                }

                // تسجيل الشخص في الاشتراك
                $user_courses = new UserCourse();
                $user_courses->user_id = Auth::guard('api')->user()->id;
                $user_courses->course_id = $request->course_id;
                $user_courses->save();
                
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'تم الاشتراك في الكورس بنجاح',
                ]);
            }

                // اذا باعت بياناتو وهويتو بفحص
            $user_data = VerifiedData::where('user_id', Auth::guard('api')->user()->id)->orderBy('id','desc')->first();
            if($user_data){

                if($user_data->status == 0){
                    return response()->json([
                        'code'          => 200,
                        'status'        => false,
                        'message'       => 'pending_verifcation',
                        'message2'       => 'الحساب قيد المراجعة',
                    ]);
                }
                if($user_data->status == 2){
                    return response()->json([
                        'code'          => 200,
                        'status'        => false,
                        'message'       => 'decline_verifcation',
                        'message2'       => 'تم رفض توثيق الحساب..يرجى ارسال بيانات صحيحة',
                    
                    ]);
                }

            }else{
             

                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'unverfied',
                ]);
                    
                
            }
          


            // اذا باعت بياناتو وهويتو بفحص
    
            // 1 مقبول
            // 2 مرفوض
            // 0 لم يتم التحديد
            // اذا ال status 1 يعني يكمل اشتراك
           



            $if_is_subscripe = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
            if($if_is_subscripe){
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'انت مشترك بالكورس بالفعل',
                ]);
            }

            // يعني عن طريق المحفظة
            if($course->type == "paid_public"){

                $course_price = $course->price - $course->discount;

                
                if($course_price <= $user->my_wallet){
                  

                DB::beginTransaction();
                try {
        
                    // تسجيل الشخص في الاشتراك
                    $user_courses = new UserCourse();
                    $user_courses->user_id = Auth::guard('api')->user()->id;
                    $user_courses->course_id = $request->course_id;
                    $user_courses->is_free = 0;
                    $user_courses->save();

                    // بنقص السعر من المحفظة من محفظة المستخدم
                    $user->my_wallet =  $user->my_wallet - $course_price;
                    $user->save();


                    //  فقط للمدفوع عام تسجيل الحركة في المحفظة
                    $user_transactions = new Wallet();
                    $user_transactions->user_id = Auth::guard('api')->user()->id;
                    $user_transactions->money = $course->price - $course->discount;
                    $user_transactions->type_recharge = "subscripe";
                    $user_transactions->type = "course_purchase " . $course->name;
                    $user_transactions->course_id = $course->id;
                    $user_transactions->save();


                    // تسجيل الحركة في الجدول الخاص في الفواتير الخاص باشتراك الكورسات
                    $billing = new Billing();
                    $billing->user_id = Auth::guard('api')->user()->id;
                    $billing->course_id = $request->course_id;
                    $billing->teacher_id = $course->teacher_id;
                    $billing->date = now();
                    $billing->course_price = $course->price - $course->discount;
                    // لا يوجد كود لانو بيخصم المبلغ من المحفظة وتم شحن المبلغ عن طريق الكود
                    // $billing->code = $request_code;
                    $billing->type_course = $course->type;
                    $billing->save();

                    $m1 = "تم الاشتراك في الدورة";
                    $m2 = "من صاحب الحساب";

                    $not = new NotificationTeacher();
                    $not->title = "اشتراك جديد";
                    $not->description = $m1 ." " . $course->name." " . $m2 ." " . Auth::guard('api')->user()->name;
                    $not->teacher_id =  $course->teacher_id;
                    $not->save();
    




                    //  زيادة عدد المشتركين للكورس
                    $course->subscriptions = $course->subscriptions + 1;
                    $course->save();


                    // زيادة عدد المشتركين بشكل كامل للمعلم نفسو
                    // طبعا المعلم بس يفتح اللوحة تبعتو بفحص العدد وبتاكد منو وبخزنو من اول وجديد
                    $teacher = Teacher::where('id',$course->teacher_id)->first();
                    $teacher->total_subscriptions =  $teacher->total_subscriptions + 1;
                    $teacher->save();
               
                    DB::commit();

                    }catch (\Exception $e) {
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
                        'message'       => 'تم الاشتراك في الكورس بنجاح',
                    ]);

                }else{
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'المحفظة غير كافية..يرجى الشحن',
                    ]);
                }

             

                // يعني عن طريق الكود
            }elseif($course->type == "private"){

                DB::beginTransaction();
                try {


                $code = TeacherCode::where('code',$request->code)->where('course_id',$request->course_id)->first();
         
                if(isset($code)){
                   
                    // عشان تحت افحص على المسج
                    $message1 = "normal";
                    $code = TeacherCode::where('code',$request->code)->where('course_id',$request->course_id)->first();
                }else{

                    $message2 = "private_pakcage";
                    $code = TeacherCode::where('code',$request->code)->first();

                    if(!$code){
                        return response()->json([
                            'code'          => 404,
                            'status'        => false,
                            'message'       => 'الكود غير موجود',
                        ]);
                    }
                   

                    if(isset($code)){
                        // يعني باكج خاص Private Package
                        // الشرط الاول عشان اتاكد انو الكود مستخدم من قبل الشخص الي اشترك بالدورة من اول مرة وما حد غيروا يقدر يشترك لو اعطاه الكود بما انو هاد الكود بتشترك فيه باكثر من دورة
                        if($code->user_id != Auth::guard('api')->user()->id ){

                            // هاد الفحص عشان اذا كان بيساوي صفر..يعني الكود غير مستخدم
                            if($code->user_id != 0){
                                return response()->json([
                                    'code'          => 404,
                                    'status'        => false,
                                    'message'       => 'هذا الكود مشترك في باقة خاصة لمستخدم اخر',
                                ]);
                            }

                          
                        }
            
                    }

                    $code = TeacherCode::where('code',$request->code)->where('course_id',$request->course_id)->first();
                    if(!$code){

                        $code = TeacherCode::where('code',$request->code)->first();
                    
                        if($code->backage_private != "private_package"){
                            return response()->json([
                                'code'          => 404,
                                'status'        => false,
                                'message'       => 'الكود غير موجود',
                            ]);
                        }
                    }


                }
               

              
                 
                // يعني باكج عادية Normal
                if(isset($message1)){

                    $code_isused = TeacherCode::where('code',$request->code)->where('course_id',$request->course_id)->where('user_id','!=',0)->first();
                    if($code_isused){
                        return response()->json([
                            'code'          => 404,
                            'status'        => false,
                            'message'       => 'الكود مستخدم بالفعل',
                        ]);
                    }

                }



                //  يعني باكج خاص Private Package
                if(isset($message2)){
                  

                    $code_isused = TeacherCode::where('code',$request->code)->first();
               

                    if(isset($code_isused)){
                        // يعني باكج خاص Private Package
                        // الشرط الاول عشان اتاكد انو الكود مستخدم من قبل الشخص الي اشترك بالدورة من اول مرة وما حد غيروا يقدر يشترك لو اعطاه الكود بما انو هاد الكود بتشترك فيه باكثر من دورة
                        if($code_isused->user_id != Auth::guard('api')->user()->id ){

                            // هاد الفحص عشان اذا كان بيساوي صفر..يعني الكود غير مستخدم
                            if($code_isused->user_id != 0){
                                return response()->json([
                                    'code'          => 404,
                                    'status'        => false,
                                    'message'       => 'هذا الكود مشترك في باقة خاصة لمستخدم اخر',
                                ]);
                            }

                          
                        }

                        $courses = json_decode($code_isused->courses_id);
                  

                    //   بفحص اذا الكورس الي بدو يشترك فيه موجود في الباقة
                        if (!in_array($request->course_id,$courses, TRUE))
                        {
                            return response()->json([
                                'code'          => 404,
                                'status'        => false,
                                'message'       => 'الباقة لا تشمل هذه الدورة',
                            ]);
                        }
                      
            
                    }
                  

                }

           



                $is_user_subscripe = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
                if($is_user_subscripe){
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'الشخص مشترك بالفعل في الدورة',
                    ]);
                }

                // تسجيل الاشتراك للطالب
                $user_subscripe = new UserCourse();
                $user_subscripe->user_id = Auth::guard('api')->user()->id;
                $user_subscripe->course_id = $request->course_id;
                $user_subscripe->is_free = 0;
                $user_subscripe->save();

                // تسجيل الكود في المتسخدم
                $course = Course::where('id',$request->course_id)->first();
                if(isset($message1)){
                    $teacher_code = TeacherCode::where('course_id',$request->course_id)->where('code',$request->code)->first();
                }else{
                    $teacher_code = TeacherCode::where('code',$request->code)->first();
                }


                $teacher_code->user_id = Auth::guard('api')->user()->id;
                $teacher_code->save();
                $teacher_code_section = TeacherCodeSection::where('id',$teacher_code->section_code)->first();
                $teacher_code_section->code_used_count = $teacher_code_section->code_used_count + 1;
                $teacher_code_section->save();


                // تسجيل الحركة في الجدول الخاص في الفواتير الخاص باشتراك الكورسات
                $billing = new Billing();
                $billing->user_id = Auth::guard('api')->user()->id;
                $billing->course_id = $request->course_id;
                $billing->teacher_id = $course->teacher_id;
                $billing->date = now();
                $billing->course_price = $course->price - $course->discount;
                $billing->code = $request->code;
                $billing->type_course = $course->type;
                $billing->save();


                //  زيادة عدد المشتركين للكورس
                $course->subscriptions = $course->subscriptions + 1;
                $course->save();

                // زيادة عدد المشتركين بشكل كامل للمعلم نفسو
                $teacher = Teacher::where('id',$course->teacher_id)->first();
                $teacher->total_subscriptions =  $teacher->total_subscriptions + 1;
                $teacher->save();


                $m1 = "تم الاشتراك في الدورة";
                $m2 = "من صاحب الحساب";

                
                $not = new NotificationTeacher();
                $not->title = "اشتراك جديد";
                $not->description = $m1 ." " . $course->name." " . $m2 ." " . Auth::guard('api')->user()->name;
                $not->teacher_id =  $course->teacher_id;
                $not->save();



                DB::commit();

                }catch (\Exception $e) {
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
                    'message'       => 'تم الاشتراك بالكورس بنجاح ',
                ]);



            }else{
                // الكورس مجاني

                // تسجيل الاشتراك للطالب
                $user_subscripe = new UserCourse();
                $user_subscripe->user_id = Auth::guard('api')->user()->id;
                $user_subscripe->course_id = $request->course_id;
                $user_subscripe->is_free = 0;
                $user_subscripe->save();

                //  زيادة عدد المشتركين للكورس
                $course->subscriptions = $course->subscriptions + 1;
                $course->save();

                // زيادة عدد المشتركين بشكل كامل للمعلم نفسو
                $teacher = Teacher::where('id',$course->teacher_id)->where('parent',0)->first();
                $teacher->total_subscriptions =  $teacher->total_subscriptions + 1;
                $teacher->save();

                $m1 = "تم الاشتراك في الدورة";
                $m2 = "من صاحب الحساب";

                
                $not = new NotificationTeacher();
                $not->title = "اشتراك جديد";
                $not->description = $m1 ." " . $course->name." " . $m2 ." " . Auth::guard('api')->user()->name;
                $not->teacher_id =  $course->teacher_id;
                $not->save();

           
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'تم الاشتراك بالكورس',
                    'message2'       => 'الكورس مجاني  ',
                ]);
            }

    }


    public function subscripe_course_new(Request $request){



            $course = Course::where('id',$request->course_id)->where('is_view',1)->where('status',2)->first();

            if(!$course){
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'لا يوجد كورس  ',
                    'message2'       => '  الكورس غير مفعل ',
                ]);
            }


            $user = User::where('id',Auth::guard('api')->user()->id)->first();

            if(!$user){
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'user not found ',
                ]);
            }


            // عشان اعرف انو مسجل عن طريق ريجستر تو يعني تبع ابل الي مسجل وبخليه يسجل ع طول
            $user_apple = VerifiedData::where('user_id',Auth::guard('api')->user()->id)->where("personal_photo","dd")->first();
            if($user_apple){

                    // تسجيل الشخص في الاشتراك
                    $user_courses = new UserCourse();
                    $user_courses->user_id = Auth::guard('api')->user()->id;
                    $user_courses->course_id = $request->course_id;
                    $user_courses->save();
                    
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'لقد حصلت على هذه الدورة بنجاح',
                    ]);

            }


            




            // تسجيل حساب الشركة حالة خاصة
            if($user->mobile == "009647703391199"){

                $if_is_subscripe = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
                if($if_is_subscripe){
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'انت مشترك بالكورس بالفعل',
                    ]);
                }

                // تسجيل الشخص في الاشتراك
                $user_courses = new UserCourse();
                $user_courses->user_id = Auth::guard('api')->user()->id;
                $user_courses->course_id = $request->course_id;
                $user_courses->save();
                
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'تم الاشتراك في الكورس بنجاح',
                ]);
            }

                // اذا باعت بياناتو وهويتو بفحص
            $user_data = VerifiedData::where('user_id', Auth::guard('api')->user()->id)->orderBy('id','desc')->first();
            if($user_data){

                if($user_data->status == 0){
                    return response()->json([
                        'code'          => 200,
                        'status'        => false,
                        'message'       => 'pending_verifcation',
                        'message2'       => 'الحساب قيد المراجعة',
                    ]);
                }
                if($user_data->status == 2){
                    return response()->json([
                        'code'          => 200,
                        'status'        => false,
                        'message'       => 'decline_verifcation',
                        'message2'       => 'تم رفض توثيق الحساب..يرجى ارسال بيانات صحيحة',
                    
                    ]);
                }

            }else{
             

                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'unverfied',
                ]);
                    
                
            }
          


            // اذا باعت بياناتو وهويتو بفحص
    
            // 1 مقبول
            // 2 مرفوض
            // 0 لم يتم التحديد
            // اذا ال status 1 يعني يكمل اشتراك
           



            $if_is_subscripe = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
            if($if_is_subscripe){
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'انت مشترك بالكورس بالفعل',
                ]);
            }

            // يعني عن طريق المحفظة
            if($course->type == "paid_public"){

                $course_price = $course->price - $course->discount;

                
                if($course_price <= $user->my_wallet){
                  

                DB::beginTransaction();
                try {
        
                    // تسجيل الشخص في الاشتراك
                    $user_courses = new UserCourse();
                    $user_courses->user_id = Auth::guard('api')->user()->id;
                    $user_courses->course_id = $request->course_id;
                    $user_courses->is_free = 0;
                    $user_courses->save();

                    // بنقص السعر من المحفظة من محفظة المستخدم
                    $user->my_wallet =  $user->my_wallet - $course_price;
                    $user->save();


                    //  فقط للمدفوع عام تسجيل الحركة في المحفظة
                    $user_transactions = new Wallet();
                    $user_transactions->user_id = Auth::guard('api')->user()->id;
                    $user_transactions->money = $course->price - $course->discount;
                    $user_transactions->type_recharge = "subscripe";
                    $user_transactions->type = "course_purchase " . $course->name;
                    $user_transactions->course_id = $course->id;
                    $user_transactions->save();


                    // تسجيل الحركة في الجدول الخاص في الفواتير الخاص باشتراك الكورسات
                    $billing = new Billing();
                    $billing->user_id = Auth::guard('api')->user()->id;
                    $billing->course_id = $request->course_id;
                    $billing->teacher_id = $course->teacher_id;
                    $billing->date = now();
                    $billing->course_price = $course->price - $course->discount;
                    // لا يوجد كود لانو بيخصم المبلغ من المحفظة وتم شحن المبلغ عن طريق الكود
                    // $billing->code = $request_code;
                    $billing->type_course = $course->type;
                    $billing->save();

                    $m1 = "تم الاشتراك في الدورة";
                    $m2 = "من صاحب الحساب";

                    $not = new NotificationTeacher();
                    $not->title = "اشتراك جديد";
                    $not->description = $m1 ." " . $course->name." " . $m2 ." " . Auth::guard('api')->user()->name;
                    $not->teacher_id =  $course->teacher_id;
                    $not->save();
    

                    $is_follow = UserFollowTeacher::where('user_id',Auth::guard('api')->user()->id)->where('teacher_id',$course->teacher_id)->first();

                    if(!$is_follow){
                        $follwo_teacher = new UserFollowTeacher();
                        $follwo_teacher->user_id = Auth::guard('api')->user()->id;
                        $follwo_teacher->teacher_id = $course->teacher_id;
                        $follwo_teacher->save();

                        $teacher = Teacher::where('id',$course->teacher_id)->first();
                        $teacher->follwers = $teacher->follwers + 1;
                        $teacher->save();
                    }





                    //  زيادة عدد المشتركين للكورس
                    $course->subscriptions = $course->subscriptions + 1;
                    $course->save();


                    // زيادة عدد المشتركين بشكل كامل للمعلم نفسو
                    // طبعا المعلم بس يفتح اللوحة تبعتو بفحص العدد وبتاكد منو وبخزنو من اول وجديد
                    $teacher = Teacher::where('id',$course->teacher_id)->first();
                    $teacher->total_subscriptions =  $teacher->total_subscriptions + 1;
                    $teacher->save();
               
                    DB::commit();

                    }catch (\Exception $e) {
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
                        'message'       => 'تم الاشتراك في الكورس بنجاح',
                    ]);

                }else{
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'المحفظة غير كافية..يرجى الشحن',
                    ]);
                }

             

                // يعني عن طريق الكود
            }elseif($course->type == "private"){

                DB::beginTransaction();
                try {


                $code = TeacherCode::where('code',$request->code)->where('course_id',$request->course_id)->first();
         
                if(isset($code)){
                   
                    // عشان تحت افحص على المسج
                    $message1 = "normal";
                    $code = TeacherCode::where('code',$request->code)->where('course_id',$request->course_id)->first();
                }else{

                    $message2 = "private_pakcage";
                    $code = TeacherCode::where('code',$request->code)->first();

                    if(!$code){
                        return response()->json([
                            'code'          => 404,
                            'status'        => false,
                            'message'       => 'الكود غير موجود',
                        ]);
                    }
                   

                    if(isset($code)){
                        // يعني باكج خاص Private Package
                        // الشرط الاول عشان اتاكد انو الكود مستخدم من قبل الشخص الي اشترك بالدورة من اول مرة وما حد غيروا يقدر يشترك لو اعطاه الكود بما انو هاد الكود بتشترك فيه باكثر من دورة
                        if($code->user_id != Auth::guard('api')->user()->id ){

                            // هاد الفحص عشان اذا كان بيساوي صفر..يعني الكود غير مستخدم
                            if($code->user_id != 0){
                                return response()->json([
                                    'code'          => 404,
                                    'status'        => false,
                                    'message'       => 'هذا الكود مشترك في باقة خاصة لمستخدم اخر',
                                ]);
                            }

                          
                        }
            
                    }

                    $code = TeacherCode::where('code',$request->code)->where('course_id',$request->course_id)->first();
                    if(!$code){

                        $code = TeacherCode::where('code',$request->code)->first();
                    
                        if($code->backage_private != "private_package"){
                            return response()->json([
                                'code'          => 404,
                                'status'        => false,
                                'message'       => 'الكود غير موجود',
                            ]);
                        }
                    }


                }
               

              
                 
                // يعني باكج عادية Normal
                if(isset($message1)){

                    $code_isused = TeacherCode::where('code',$request->code)->where('course_id',$request->course_id)->where('user_id','!=',0)->first();
                    if($code_isused){
                        return response()->json([
                            'code'          => 404,
                            'status'        => false,
                            'message'       => 'الكود مستخدم بالفعل',
                        ]);
                    }

                }



                //  يعني باكج خاص Private Package
                if(isset($message2)){
                  

                    $code_isused = TeacherCode::where('code',$request->code)->first();
               

                    if(isset($code_isused)){
                        // يعني باكج خاص Private Package
                        // الشرط الاول عشان اتاكد انو الكود مستخدم من قبل الشخص الي اشترك بالدورة من اول مرة وما حد غيروا يقدر يشترك لو اعطاه الكود بما انو هاد الكود بتشترك فيه باكثر من دورة
                        if($code_isused->user_id != Auth::guard('api')->user()->id ){

                            // هاد الفحص عشان اذا كان بيساوي صفر..يعني الكود غير مستخدم
                            if($code_isused->user_id != 0){
                                return response()->json([
                                    'code'          => 404,
                                    'status'        => false,
                                    'message'       => 'هذا الكود مشترك في باقة خاصة لمستخدم اخر',
                                ]);
                            }

                          
                        }

                        $courses = json_decode($code_isused->courses_id);
                  

                    //   بفحص اذا الكورس الي بدو يشترك فيه موجود في الباقة
                        if (!in_array($request->course_id,$courses, TRUE))
                        {
                            return response()->json([
                                'code'          => 404,
                                'status'        => false,
                                'message'       => 'الباقة لا تشمل هذه الدورة',
                            ]);
                        }
                      
            
                    }
                  

                }

           



                $is_user_subscripe = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$request->course_id)->first();
                if($is_user_subscripe){
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'الشخص مشترك بالفعل في الدورة',
                    ]);
                }

                // تسجيل الاشتراك للطالب
                $user_subscripe = new UserCourse();
                $user_subscripe->user_id = Auth::guard('api')->user()->id;
                $user_subscripe->course_id = $request->course_id;
                $user_subscripe->is_free = 0;
                $user_subscripe->save();

                // تسجيل الكود في المتسخدم
                $course = Course::where('id',$request->course_id)->first();
                if(isset($message1)){
                    $teacher_code = TeacherCode::where('course_id',$request->course_id)->where('code',$request->code)->first();
                }else{
                    $teacher_code = TeacherCode::where('code',$request->code)->first();
                }


                $teacher_code->user_id = Auth::guard('api')->user()->id;
                $teacher_code->save();
                $teacher_code_section = TeacherCodeSection::where('id',$teacher_code->section_code)->first();
                $teacher_code_section->code_used_count = $teacher_code_section->code_used_count + 1;
                $teacher_code_section->save();


                // تسجيل الحركة في الجدول الخاص في الفواتير الخاص باشتراك الكورسات
                $billing = new Billing();
                $billing->user_id = Auth::guard('api')->user()->id;
                $billing->course_id = $request->course_id;
                $billing->teacher_id = $course->teacher_id;
                $billing->date = now();
                $billing->course_price = $course->price - $course->discount;
                $billing->code = $request->code;
                $billing->type_course = $course->type;
                $billing->save();

                $is_follow = UserFollowTeacher::where('user_id',Auth::guard('api')->user()->id)->where('teacher_id',$course->teacher_id)->first();

                if(!$is_follow){
                    $follwo_teacher = new UserFollowTeacher();
                    $follwo_teacher->user_id = Auth::guard('api')->user()->id;
                    $follwo_teacher->teacher_id = $course->teacher_id;
                    $follwo_teacher->save();

                    $teacher = Teacher::where('id',$course->teacher_id)->first();
                    $teacher->follwers = $teacher->follwers + 1;
                    $teacher->save();
                }


                //  زيادة عدد المشتركين للكورس
                $course->subscriptions = $course->subscriptions + 1;
                $course->save();

                // زيادة عدد المشتركين بشكل كامل للمعلم نفسو
                $teacher = Teacher::where('id',$course->teacher_id)->first();
                $teacher->total_subscriptions =  $teacher->total_subscriptions + 1;
                $teacher->save();


                $m1 = "تم الاشتراك في الدورة";
                $m2 = "من صاحب الحساب";

                
                $not = new NotificationTeacher();
                $not->title = "اشتراك جديد";
                $not->description = $m1 ." " . $course->name." " . $m2 ." " . Auth::guard('api')->user()->name;
                $not->teacher_id =  $course->teacher_id;
                $not->save();



                DB::commit();

                }catch (\Exception $e) {
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
                    'message'       => 'تم الاشتراك بالكورس بنجاح ',
                ]);



            }else{
                // الكورس مجاني

                // تسجيل الاشتراك للطالب
                $user_subscripe = new UserCourse();
                $user_subscripe->user_id = Auth::guard('api')->user()->id;
                $user_subscripe->course_id = $request->course_id;
                $user_subscripe->is_free = 0;
                $user_subscripe->save();

                //  زيادة عدد المشتركين للكورس
                $course->subscriptions = $course->subscriptions + 1;
                $course->save();

                // زيادة عدد المشتركين بشكل كامل للمعلم نفسو
                $teacher = Teacher::where('id',$course->teacher_id)->where('parent',0)->first();
                $teacher->total_subscriptions =  $teacher->total_subscriptions + 1;
                $teacher->save();

                $m1 = "تم الاشتراك في الدورة";
                $m2 = "من صاحب الحساب";

                
                $not = new NotificationTeacher();
                $not->title = "اشتراك جديد";
                $not->description = $m1 ." " . $course->name." " . $m2 ." " . Auth::guard('api')->user()->name;
                $not->teacher_id =  $course->teacher_id;
                $not->save();

                $is_follow = UserFollowTeacher::where('user_id',Auth::guard('api')->user()->id)->where('teacher_id',$course->teacher_id)->first();

                if(!$is_follow){
                    $follwo_teacher = new UserFollowTeacher();
                    $follwo_teacher->user_id = Auth::guard('api')->user()->id;
                    $follwo_teacher->teacher_id = $course->teacher_id;
                    $follwo_teacher->save();

                    $teacher = Teacher::where('id',$course->teacher_id)->first();
                    $teacher->follwers = $teacher->follwers + 1;
                    $teacher->save();
                }

           
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'تم الاشتراك بالكورس',
                    'message2'       => 'الكورس مجاني  ',
                ]);
            }

    }


    public function all_reviews_courses(Request $request){
        $reviews = ReviewCourse::where('course_id',$request->course_id)->orderBy('id','desc')->paginate(7);

        foreach($reviews as $rev){
            $rev['user'] = User::where('id',$rev->user_id)->first();
        }
      

        
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $reviews,
        ]);
    }


    public function lesson_files(Request $request){
        
        $lesson_file = LessonAttachmetn::where('lesson_id',$request->lesson_id)->get();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          => $lesson_file,
        ]);
    }


    
}
