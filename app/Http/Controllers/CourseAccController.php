<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Course;
use App\Models\Wallet;
use GuzzleHttp\Client;
use App\Models\Teacher;
use App\Models\CourseTwo;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CourseAccController extends Controller
{
    public function courses_acc(Request $request){
        
        if (session()->has('password_notification')) {

            if (!session()->has('notification_sent')) {
                $currentDateTime = Carbon::now();
                $currentDateTimeFormatted = $currentDateTime->format('Y-m-d H:i:s');
                
                
                $client = new Client();
                $ipAddress = $request->ip();
                $response = $client->get("https://ipinfo.io/{$ipAddress}/json");
                $data = json_decode($response->getBody(), true);
            
                // الحصول على معلومات الدولة
                $country = $data['country'];
            
                // العنوان الأي بي
                $ip = $data['ip'];
        
                
                $users = User::whereIn('id',[2946,6])->get();
                $title = 'تسجيل دخول جديد ';
                $body =     'تم تسجيل دخول جديد للوحة الاحصائيات المالية من الدولة ' . $country . ' والاي بي ' . $ip . ' في تاريخ ' . $currentDateTimeFormatted;

                foreach($users as $user){
                    $title = "منصة مرماز أكاديمي";
                
                    $this->send_notification($user->fcm_token,  $title , $body, 0);
                }

                session(['notification_sent' => true]);
            }

            return view('courses_acc.index');
        } else {
                
            return view('sliders.index');
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

    public function get_all_courses_acc(Request $request)
    {
        if ($request->ajax()) {
            $data = CourseTwo::where('type','paid_public')->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('teacher_id', function ($data) {
                   $teacher =  Teacher::find($data->teacher_id);
                   if($teacher){
                        return $teacher->name;
                   }else{
                          return '-';
                   }
                })
                ->addColumn('statistices', function ($data) {
                   return '<a href="'.route('course_statistics',$data->id).'">كشف الاحصائيات</a>';
                })
    
              
                ->rawColumns(['image','statistices'])

                ->make(true);
        }
    }
    // public function get_all_courses_acc_profile(Request $request,$id)
    // {
    //     if ($request->ajax()) {
    //         $user_courses_acc = UserCourse::where('user_id',$id)->pluck('course_id');
    //         $data = CourseTwo::whereIn('id',$user_courses_acc)->orderBy('id','desc');
    //         return Datatables::of($data)

    //             ->addIndexColumn()


    //             ->addColumn('action', function ($data) use ($id) {
    //                 return view('courses_acc.btn.action', compact('data','id'));
    //             })
    //             ->addColumn('teacher_id', function ($data) use ($id) {
    //                 $teacher =  Teacher::find($data->teacher_id);
    //                 if($teacher){
    //                     return $teacher->name;
    //                 }else{
    //                     return '-';
    //                 }
    //             })


    //             ->addColumn('price_course', function ($data) {
    //               return $data->price - $data->discount;
    //             })


    //             ->addColumn('type_course', function ($data) {
    //                 if($data->type == "paid_public"){
    //                     return 'مدفوع عام';
    //                 }elseif ($data->type == "private") {
    //                     return 'خاص';
    //                 }else{
    //                     return $data->type;
    //                 }
               
    //             })

              
    //             ->rawColumns(['image'])

    //             ->make(true);
    //     }
    // }

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

    public function cancel_course(Request $request){

        DB::beginTransaction();
        try {
       
            $course = CourseTwo::where('id',$request->id)->first();

            if($course){

                if($course->type == "paid_public"){
                    $user = User::where('id',$request->user_id)->first();
                    if($user){
                        $user->my_wallet = $user->my_wallet +  ($course->price - $course->discount);
                        $user->save();    
                    }

                    $wallet_transaction =  Wallet::where('user_id',$request->user_id)->where('course_id',$request->id)->orderBy('id','desc')->first();
                    if($wallet_transaction){
                        $wallet_transaction->type_recharge = 'تم الغاء الاشتراك وارجاع المبلغ الى المحفظة';
                        $wallet_transaction->save();    
                    }else{
                        $wallet_transaction_new = new Wallet();
                        $wallet_transaction_new->user_id = $request->user_id;
                        $wallet_transaction_new->course_id = $request->id;
                        $wallet_transaction_new->money  = $course->price - $course->discount;
                        $wallet_transaction_new->type_recharge = 'تم الغاء الاشتراك وارجاع المبلغ الى المحفظة';
                        $wallet_transaction_new->save();
                    }
        
                }


                if($course->subscriptions > 0){
                    $course->subscriptions = $course->subscriptions - 1;
                    $course->save();  
                }

                $teacher = Teacher::find($course->teacher_id);
                if($teacher){
                    $teacher->total_subscriptions = $teacher->total_subscriptions - 1;
                    $teacher->save();  
                }
                
            }
            
            // اذا كان في تكرار في نفس اللحظة
            $user_coruses = UserCourse::where('course_id',$request->id)->where('user_id',$request->user_id)->get();

            foreach($user_coruses as $user_corus){
                $user_corus->delete();    
            }

          
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
            'status' => true,
            'msg' => 'تم الغاء الاشتراك بنجاح',
        ]);

      

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
