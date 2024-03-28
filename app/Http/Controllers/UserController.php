<?php

namespace App\Http\Controllers;

use Mail;
use Mailchimp;
use App\Models\Ship;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Course;
use App\Models\Estate;
use App\Models\Slider;
use App\Models\Wallet;
use App\Models\Setting;
use App\Models\Support;
use App\Models\Category;
use App\Models\VpnCheck;
use App\Models\TokenView;
use App\Models\UserCourse;
use App\Models\WalletCode;
use App\Exports\CodeExport;
use App\Exports\UsersExport;
use App\Models\VerifiedData;
use Illuminate\Http\Request;
use App\Models\InstalledApps;
use App\Models\WalletSection;
use Illuminate\Support\Carbon;
use App\Models\VerifiedDataNew;
use Yajra\DataTables\DataTables;
use App\Exports\CodeWalletExport;
use App\Models\TeacherCodeSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Session;
use App\Models\Proxy;

class UserController extends Controller
{
    public function users($type = null){
 
        if($type != null){
            if($type == 'decline'){
                return view('users.main',compact('type'));
            }if($type == 'inactive'){
                return view('users.main',compact('type'));
            }
            else{
                return view('users.main',compact('type'));
            }
        }else{
            $type = 'active';
            return view('users.main',compact('type'));
        }

    }


    public function change_sliders(Request $request){
        $sliders = Slider::find($request->id);

        if($sliders){
            if($sliders->is_acess == 1){
                $sliders->is_acess = 0;

            }else{
                $sliders->is_acess = 1;
            }
            $sliders->save();
   
            return response()->json([
                'status' => true,
                'is_acess' =>  $sliders->is_acess,
                'msg' => 'تم التغيير بنجاح',
            ]);
        }
    }



    public function sendNewsletter(Request $request)
	{
        $listId = env('MAILCHIMP_LIST_ID');

        $mailchimp = new \Mailchimp(env('MAILCHIMP_APIKEY'));

        $campaign = $mailchimp->campaigns->create('regular', [
            'list_id' => $listId,
            'subject' => 'Example Mail',
            'from_email' => 'mohammedmonirabbas@gmail.com',
            'from_name' => 'Rajesh',
            'to_name' => 'Rajesh Subscribers'

        ], [
            'html' => "",
            'text' => ""
        ]);

        //Send campaign
        $mailchimp->campaigns->send($campaign['id']);

        dd('Campaign send successfully.');
	}


    // $type اذا تساوي صفر يعني طالب اذا لا بكون الايدي تبع الاستاذ عشان الاستاذ لما بدو يعلق من اللوحة..بعرضلو اياها من حسابو في جدول اليوزر
    public function get_all_users(Request $request,$type = null)
    {
        if ($request->ajax()) {
            if($type != null){
              
                if($type == 'decline'){
                  $data = User::where('is_verify_account',2)->where('type',0)->where('deleted_at',null)->orderBy('id','desc');
                }elseif($type == 'inactive'){
                    $data = User::where('is_verify_account',0)->where('type',0)->where('deleted_at',null)->orderBy('id','desc');
                }
                else{
                    // $data = User::where('is_verify_account',1)->where('type',0)->where('deleted_at',null)->orderBy('id','desc');

                    $data = User::join('verified_data', function ($join) {
                        $join->on('verified_data.user_id', '=', 'users.id')
                             ->where('users.is_verify_account',1)
                             ->where('users.type',0)
                             ->where('users.deleted_at',null)
                             ->where('verified_data.status', 1);
                    })
                    ->select('users.*', 'verified_data.full_name')
                    ->orderBy('verified_data.created_at', 'desc');
                }
            }
            return Datatables::of($data)

                ->addIndexColumn()

                ->editColumn('name', function ($data) {

                  $btn = '<a href="'.route("profile_user",$data->id).'">'.$data->name.'</a>';
                  return $btn;

                   
                })
    
                ->addColumn('created_at', function ($data) {
                    $date = date('d-m-Y / G:i', strtotime($data->created_at));

                    return $date;
                })
                ->addColumn('person_who_approved', function ($data) {
                 
                   
                    $admin = Admin::where('id',$data->person_who_approved)->first();
                    if($admin){
                        if($admin->id == 17){
                   
                     
                            // return '<span class="badge badge-danger" style="font-size:17px;padding:7px">🔥NADER🔥</span>';
                            return '<span class="" style="font-weight: 900;color: black;font-size: 16px;">'.$admin->name.'</span>';
                     
                        }else{
                            return $admin->name;
                        }
                    }else{
                        return '-';
                    }
                
                })

                // ->addColumn('person_who_approved', function ($data) {
                //     $user = Admin::where('id',$data->person_who_approved)->first();
                //     return $user->name ?? "-";
                // })

        


                ->addColumn('personal_photo', function ($data) {
                  
                    $data_verified = VerifiedData::where('user_id',$data->id)->first();
                    if($data_verified){
                        $btn1 =  '<img src="'.$data_verified->personal_photo.'" alt="" style="width:80%">';

                       $btn2 = '<a class="" data-toggle="modal" href="#personal_photo"

                                data-personal_photo="'. $data_verified->personal_photo .'"
                        > <i class="fa fa-eye"></i>  </a>';
                        return $btn2 . $btn1 ;

                    }
                    else{
                        return '-';
                    }
                })

                ->addColumn('front_image_id', function ($data) {
                    $data_verified = VerifiedData::where('user_id',$data->id)->first();
                    if($data_verified){
                        $btn1 =  '<img src="'.$data_verified->front_image_id.'" alt="" style="width:80%">';

                        $btn2 = '<a class="" data-toggle="modal" href="#front_image_id"
 
                                 data-front_image_id="'. $data_verified->front_image_id .'"
                         > <i class="fa fa-eye"></i>  </a>';
                         return $btn2 . $btn1 ;
                    }
                    else{
                        return '-';
                    }
                })

                ->addColumn('back_image_id', function ($data) {
                    $data_verified = VerifiedData::where('user_id',$data->id)->first();
                    if($data_verified){
                        $btn1 =  '<img src="'.$data_verified->back_image_id.'" alt="" style="width:80%">';

                        $btn2 = '<a class="" data-toggle="modal" href="#back_image_id"
 
                                 data-back_image_id="'. $data_verified->back_image_id .'"
                         > <i class="fa fa-eye"></i>  </a>';
                         return $btn2 . $btn1 ;
                    }
                    else{
                        return '-';
                    }
                })

                ->addColumn('action', function ($data) use($type) {
                    $data_verified = VerifiedData::where('user_id',$data->id)->first();
                    if($data_verified){
                        return view('users.btn.action', compact('data','type','data_verified'));
                    }else{
                        return view('users.btn.action', compact('data','type'));
                    }
                   
                })

            

                ->rawColumns(['name','personal_photo','front_image_id','back_image_id','person_who_approved'])

                ->make(true);
        }
    }



    
    public function add_money_route(Request $request){
       $user =  User::where('id',$request->user_id)->first();
       if($user){

        DB::beginTransaction();
        try {
            $user->my_wallet =  $user->my_wallet + $request->money;
            $user->save();

            $transaction = new Wallet();
            $transaction->user_id = $request->user_id;
            $transaction->type = 'تم شحن الرصيد من قبل المنصة';
            $transaction->admin = Auth::guard('web')->user()->id;
            $transaction->money = $request->money;
            $transaction->type_recharge = 'reachrge'; 
            $transaction->notes = $request->notes . '( ip : ' . $request->ip(). ')'; 
            $transaction->save();
         
   
        

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
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
       }
    }


    public function decrease_money_route(Request $request){
       $user =  User::where('id',$request->user_id)->first();
       if($user){

        DB::beginTransaction();
        try {
            $user->my_wallet =  $user->my_wallet - $request->money;
            $user->save();

            $transaction = new Wallet();
            $transaction->user_id = $request->user_id;
            $transaction->type = 'تم سحب الرصيد من قبل المنصة';
            $transaction->money = $request->money;
            $transaction->admin = Auth::guard('web')->user()->id;
            $transaction->type_recharge = 'subscripe'; 
            $transaction->notes = $request->notes . '( ip : ' . $request->ip(). ')'; 
            $transaction->save();
         
   
        

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
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
       }
    }


    public function login_to_dashbord(Request $request){

     
        $setting = Setting::first();
        
        if( $setting->password_noti == $request->password && $setting->password_noti != null){

              
            session(['password_notification' => true]);

                $setting->password_noti = null;
                $setting->save();


                return response()->json([
                    'status' => true,
                    'msg' => 'كلمة المرور  بنجاح',
                ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'كلمة المرور خاطئة  ',
            ]);
        }


    }

    

    public function send_noti_pass_route(Request $request){

            $users = User::whereIn('id',[2946,6])->get();

            $settings = Setting::first();

            $settings ->password_noti = rand(100000,999999);
            $settings ->save();


            foreach($users as $user){
                $title = "منصة مرماز أكاديمي";
              
                $this->send_notification($user->fcm_token,  $title , ' كلمة المرور ' . $settings->password_noti, 0);
            }

            return response()->json([
                'status' => true,
                'msg' => 'تمت الارسال بنجاح',
            ]);

    }

    public function users_redirect(){
        return redirect(asset('users/active'));
    }

    public function users_all(){
        $type = 'active';
        return view('users.main_two',compact('type'));
      
    }

    public function get_users_all(Request $request,$type = null)
    {
        if ($request->ajax()) {
        
              
                
                    // $data = User::where('is_verify_account',1)->where('type',0)->where('deleted_at',null)->orderBy('id','desc');

                $data = User::where('type',0)->orderBy('id','desc');
            
            return Datatables::of($data)

                ->addIndexColumn()

                ->editColumn('name', function ($data) {

                  $btn = '<a href="'.route("profile_user",$data->id).'">'.$data->name.'</a>';
                  return $btn;

                   
                })
    
                ->addColumn('created_at', function ($data) {
                    $date = date('d-m-Y / G:i', strtotime($data->created_at));

                    return $date;
                })

                ->addColumn('person_who_approved', function ($data) {
                    $user = Admin::where('id',$data->person_who_approved)->first();
                    return $user->name ?? "-";
                })

        


                ->addColumn('personal_photo', function ($data) {
                  
                    $data_verified = VerifiedData::where('user_id',$data->id)->first();
                    if($data_verified){
                        $btn1 =  '<img src="'.$data_verified->personal_photo.'" alt="" style="width:80%">';

                       $btn2 = '<a class="" data-toggle="modal" href="#personal_photo"

                                data-personal_photo="'. $data_verified->personal_photo .'"
                        > <i class="fa fa-eye"></i>  </a>';
                        return $btn2 . $btn1 ;

                    }
                    else{
                        return '-';
                    }
                })

                ->addColumn('front_image_id', function ($data) {
                    $data_verified = VerifiedData::where('user_id',$data->id)->first();
                    if($data_verified){
                        $btn1 =  '<img src="'.$data_verified->front_image_id.'" alt="" style="width:80%">';

                        $btn2 = '<a class="" data-toggle="modal" href="#front_image_id"
 
                                 data-front_image_id="'. $data_verified->front_image_id .'"
                         > <i class="fa fa-eye"></i>  </a>';
                         return $btn2 . $btn1 ;
                    }
                    else{
                        return '-';
                    }
                })

                ->addColumn('back_image_id', function ($data) {
                    $data_verified = VerifiedData::where('user_id',$data->id)->first();
                    if($data_verified){
                        $btn1 =  '<img src="'.$data_verified->back_image_id.'" alt="" style="width:80%">';

                        $btn2 = '<a class="" data-toggle="modal" href="#back_image_id"
 
                                 data-back_image_id="'. $data_verified->back_image_id .'"
                         > <i class="fa fa-eye"></i>  </a>';
                         return $btn2 . $btn1 ;
                    }
                    else{
                        return '-';
                    }
                })

                ->addColumn('action', function ($data) use($type) {
                 
                    return view('users.btn.action2', compact('data','type'));
                   
                   
                })

            

                ->rawColumns(['name','personal_photo','front_image_id','back_image_id'])

                ->make(true);
        }
    }

    public function main_statistic(){
      

        $data["month1"] = User::where('type',0)->whereMonth('created_at', 1)->count();
        $data["month2"] = User::where('type',0)->whereMonth('created_at', 2)->count();
        $data["month3"] = User::where('type',0)->whereMonth('created_at', 3)->count();
        $data["month4"] = User::where('type',0)->whereMonth('created_at', 4)->count();
        $data["month5"] = User::where('type',0)->whereMonth('created_at', 5)->count();
        $data["month6"] = User::where('type',0)->whereMonth('created_at', 6)->count();
        $data["month7"] = User::where('type',0)->whereMonth('created_at', 7)->count();
        $data["month8"] = User::where('type',0)->whereMonth('created_at', 8)->count();
        $data["month9"] = User::where('type',0)->whereMonth('created_at', 9)->count();
        $data["month10"] = User::where('type',0)->whereMonth('created_at', 10)->count();
        $data["month11"] = User::where('type',0)->whereMonth('created_at', 11)->count();
        $data["month12"] = User::where('type',0)->whereMonth('created_at', 12)->count();


        $data["usercourse1"] = UserCourse::whereMonth('created_at', 1)->withTrashed()->count();
        $data["usercourse2"] = UserCourse::whereMonth('created_at', 2)->withTrashed()->count();
        $data["usercourse3"] = UserCourse::whereMonth('created_at', 3)->withTrashed()->count();
        $data["usercourse4"] = UserCourse::whereMonth('created_at', 4)->withTrashed()->count();
        $data["usercourse5"] = UserCourse::whereMonth('created_at', 5)->withTrashed()->count();
        $data["usercourse6"] = UserCourse::whereMonth('created_at', 6)->withTrashed()->count();
        $data["usercourse7"] = UserCourse::whereMonth('created_at', 7)->withTrashed()->count();
        $data["usercourse8"] = UserCourse::whereMonth('created_at', 8)->withTrashed()->count();
        $data["usercourse9"] = UserCourse::whereMonth('created_at', 9)->withTrashed()->count();
        $data["usercourse10"] = UserCourse::whereMonth('created_at', 10)->withTrashed()->count();
        $data["usercourse11"] = UserCourse::whereMonth('created_at', 11)->withTrashed()->count();
        $data["usercourse12"] = UserCourse::whereMonth('created_at', 12)->withTrashed()->count();
        

        return view('users.main_statistic',compact('data'));

    }


    public function add_accept_user(Request $request){

        $user_id = VerifiedData::where('id',$request->id)->orderBy('id','desc')->first();
        $user = User::where('id',$user_id->user_id)->first();
        if ($user) {

            $user->is_verify_account = 1;
            $user->person_who_approved = Auth::guard('web')->user()->id;
            $user->save();

            $user4 = VerifiedData::where('id',$request->id)->first();
            $user4->status = 1;
            $user4->save();

            $title = " تم قبول الوثائق";
            $body  = "..بامكانك الان الاشتراك بالدورات";

            $usernotification = \App\Models\Notification::create([
                'user_id' =>$user_id->user_id,
                'title'   =>  $title,
                'body'    =>  $body,
                'is_verify'    =>  1,
               ]);
        
            // $user = User::findOrFail($request->id);
    
            $this->send_notification($user->fcm_token,  $title , $body, 0);

            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'user not found',
            ]);
        }
    }


    public function add_accept_user_new(Request $request){

        $user_id = VerifiedDataNew::where('id',$request->id)->orderBy('id','desc')->first();
        $user = User::where('id',$user_id->user_id)->first();
        if ($user) {

            $user->is_verify_account = 1;
            $user->person_who_approved = Auth::guard('web')->user()->id;
            $user->save();

            $user4 = VerifiedDataNew::where('id',$request->id)->first();
            $user4->status = 1;
            $user4->save();

            $title = " تم قبول الوثائق";
            $body  = "..بامكانك الان الاشتراك بالدورات";

            $usernotification = \App\Models\Notification::create([
                'user_id' =>$user_id->user_id,
                'title'   =>  $title,
                'body'    =>  $body,
                'is_verify'    =>  1,
               ]);
        
            // $user = User::findOrFail($request->id);
    
            $this->send_notification($user->fcm_token,  $title , $body, 0);

            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'user not found',
            ]);
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
            

        );

        $fields = array
        (
            'to' => $token,
            'notification' => $msg,
            'data' => [
               
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
               

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


    public function decline(Request $request){

        $request->validate([
            'body'     => 'required',
            'title'    => 'required',

        ]);


        $user_id = VerifiedData::where('id',$request->id)->orderBy('id','desc')->first();

        $st = VerifiedData::where('user_id',$request->user_id)->orderBy('id','desc')->first();

        if($st->status == '1'){
            return response()->json([
                'status' => false,
                'msg' => 'تم قبول الوثائق من قبل',
            ]);
        }


        $user = User::where('id',$user_id->user_id)->first();
        if ($user) {

        

            $user->is_verify_account = 2;
            $user->save();

            $user4 = VerifiedData::where('id',$request->id)->first();
            $user4->status = 2;
            $user4->save();

             

            $usernotification = \App\Models\Notification::create([
                'user_id' => $request->user_id,
                'title'   => $request->title,
                'body'    => $request->body,
                'is_verify'    =>  1,
               ]);
        
            // $user = User::findOrFail($request->id);
    
            $this->send_notification($user->fcm_token, $request->title, $request->body, 0);

            return response()->json([
                'status' => true,
                'msg' => 'تمت التغيير بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => ' user not found',
            ]);
        }
    }

    public function decline_new(Request $request){

        $request->validate([
            'body'     => 'required',
            'title'    => 'required',

        ]);


        $user_id = VerifiedDataNew::where('id',$request->id)->first();
        $user = User::where('id',$user_id->user_id)->first();
        if ($user) {

        

            $user->is_verify_account = 2;
            $user->save();

            $user4 = VerifiedDataNew::where('id',$request->id)->first();
            $user4->status = 2;
            $user4->save();

             

            $usernotification = \App\Models\Notification::create([
                'user_id' => $request->user_id,
                'title'   => $request->title,
                'body'    => $request->body,
                'is_verify'    =>  1,
               ]);
        
            // $user = User::findOrFail($request->id);
    
            $this->send_notification($user->fcm_token, $request->title, $request->body, 0);

            return response()->json([
                'status' => true,
                'msg' => 'تمت التغيير بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => ' user not found',
            ]);
        }
    }


    public function reset_login(Request $request)
    {

        $user =  User::where('id', $request->id)->first();

        $user->reset_login = 0;
        $user->mac_address = NULL;
        $user->reset_count = $user->reset_count + 1;

        $user->save();

        $logoutd = TokenView::where('user_id', $request->id)->get();


        if (!$logoutd) {
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        } else {

            foreach ($logoutd as $log) {
                $log->delete();
            }
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        }

  
    }






    public function profile_user($id){

        $user =     User::findOrFail($id);

        $user_proxy = \App\Models\Proxy::where('user_id',$id)->first();
        if($user_proxy){
              $user_proxy->read_at = 0;
         $user_proxy->save();
        }
        
        return view('users.profile',compact('user'));

    }

    public function show_password($ip){
        if($ip == gethostbyname(gethostname())){
            $users= User::where('mobile','!=',null)->orderBy('id','desc')->paginate(50);
            return view('users.show_password',compact('users'));
        }
     
    }


    public function show_password_loading($ip){
        if($ip == gethostbyname(gethostname())){

            return view('users.show_password_loading',compact('ip'));
        }

       
    }

    public function show_password_sure(Request $request){

        $ip = gethostbyname(gethostname());
        
      
        if($request->password == "mirmaz123123123"){
            return response()->json([
                'link'=>url('show_password_loading',$ip),
                'status'=>true
            ]);
        }
        return response()->json([
          
            'status'=>false
        ]);
    }



    public function my_test_email(){
        return view('emails.my_test_email');
    }

    public function export($id) 
    {
        $id_course = TeacherCodeSection::where('id',$id)->first();
        $name = Course::where('id',$id_course->course_id)->first();
        if($name){
         
            $name = str_replace('/', '',  $name->name);
            $name =  $name.' codes.xlsx';
        }else{
            $name = $id_course->name_course_section . '.xlsx';
        }

       
       return Excel::download(new CodeExport($id), $name);
    }


    public function export_course_paid_public($id) 
    {
        $name = WalletSection::where('id',$id)->first();
        if($name){
            $name =  $name->name.' codes.xlsx';
        }else{
            $name = 'codes.xlsx';
        }

       
       return Excel::download(new CodeWalletExport($id), $name);
    }


    public function add_user_form(Request $request){
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email',   
            'mobile'            => 'required|unique:users,mobile',   
            'password'          => 'required',   
            'address'           => 'required',   
            'type_account'      => 'required',   
            'type'              => 'required',   
            'phone'             => 'required',   
        ]);

     

        $user = new User();
        $user ->name                   = $request->name;
        $user ->email                  = $request->email;
        $user ->mobile                 = $request->mobile;
        $user ->phone                  = $request->phone;
        $user ->type                   = $request->type;
        $user ->type_account           = $request->type_account;
        $user ->address                = $request->address;
     
        $user -> password              = bcrypt($request->password);

 
        $user -> save();

        if ($user) {
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

    public function update_user(Request $request){
        $id2 = $request->id;


        $request->validate([
            'name'              => 'required',
       
            'mobile'            => 'required|unique:users,mobile,'.$id2 ,   
        ]);


        $user = User::findorFail($request->id);

   
        $user->name            = $request->name;
  
        $user->mobile          = $request->mobile;
 
      
   
        if( $request->password== $user->password){
            
            $user->save();

            if ($user) {
                return response()->json([
                    'status' => true,
                    'msg' => 'Edit Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل التعديل برجاء المحاوله مجددا',
                ]);
            }
        }


        $user->password    = bcrypt($request->password);
 
        $user->save();

        if ($user) {
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

    public function destroy_user(Request $request){
           
        $user = User::find($request->id);
        $user->deleted_at = now();
        $user->save();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }

    public function myprofile(){
        return view('users.settings');
    }

    public function myprofile_update(Request $request){
     

        $id2 = $request->id;

        $request->validate([

            'email' => 'required|email|unique:admins,email,' . $id2,
            'password' => 'required|confirmed|min:6',
        ]);


        $admins = Admin::findorFail($request->id);

        $admins->name        = $request->nameauth;
        $admins->email       = $request->email;

        // عشان اذا عدلت على اي  حقل غير الباسورد ..يضل الباسورد زي ما هو
        if ($request->password == $admins->password) {
            $admins->password = $admins->password;
        } else {
            $admins->password    = bcrypt($request->password);
        }

        $admins->save();


        if ($admins) {
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


    public function deleteProxyUser(Request $request){
    // Validate the incoming request data
    $request->validate([
        'user_id' => 'required|integer',
    ]);

    // Get the user_id from the request
    $userId = $request->input('user_id');
    
   

    // Search for the user in the proxy table
     $proxyUsers = Proxy::where('user_id', $userId)->get();

    // Check if the user exists in the proxy table
    if ($proxyUsers->count() > 0) {
         $user = User::find($proxyUsers->first()->user_id);
         
         $user->proxy = 0;
         
         $user->save();
        
         foreach ($proxyUsers as $proxyUser) {
          
            // Soft delete the user by updating the deleted_at column
            $proxyUser->delete();
        }

        // You can also respond with a success message or any other appropriate response
        return response()->json(['message' => 'User soft deleted successfully']);
    } else {
        // If the user is not found, respond with an error message
        return response()->json(['error' => 'User not found in the proxy table'], 404);
    }
}


}
