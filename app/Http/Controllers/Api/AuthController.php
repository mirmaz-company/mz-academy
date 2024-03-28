<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Topic;
use App\Models\Address;
use App\Models\UserTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\VerifiedData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

class AuthController extends Controller
{
    public function register(Request $request)
    {
     
      $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'mobile'     => 'required|unique:users,mobile',   
            'password'  => 'required',
            'study'  => 'required',
            'level'  => 'required',
            // 'gender'  => 'required',
            // 'date_of_birth'  => 'required',
            // 'topics'  => 'required',
            'fcm_token'    => 'required',
         
          
         
        ]);
        
          if ($validator->fails()) {
            $errors = $validator->errors();

            return response([
                'status'=>false,
                'message'=>'Make sure that the information is correct and fill in all fields',
                'errors'=>$errors,
                'code'=>422
            ]);
        }

        $user_mac = User::where('mac_address',$request->mac_address)->first();
        if($user_mac){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'mac_address',
                
            ]);
        }

        DB::beginTransaction();
        try {

        $user = new User();
        $user->name         = $request->name;
        $user->mobile       = $request->mobile;
        $user->password     = bcrypt($request->password);
        $user->password_show     = $request->password;
        $user->study        = $request->study;
        $user->level        = $request->level;
        if(isset($request->gender)){
            $user->gender       = $request->gender; 
        }
        if(isset($request->date_of_birth)){
            $user->date_of_birth       = $request->date_of_birth; 
        }
       
      
        $user->fcm_token    = $request->fcm_token;
        $user->mac_address    = $request->mac_address;
        $user->save();

        if(isset($request->topics)){
        $topics = json_decode($request->topics);
        foreach($topics as $top){
            $topic = Topic::where('id',$top)->first();
            $user_topics = new UserTopic();
            $user_topics->user_id = $user->id;
            $user_topics->topic_id = $topic->id;
            $user_topics->topic_name = $topic->name;
            $user_topics->save();
        }
        }
        
        DB::commit();

            }

            catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'something error',
                    'errors'       => $e,
                    
                ]);

        }
        



        $accessToken = $user->createToken($user->email)->accessToken;

        return response([ 'code'=> 200, 'status' => true, 'message'=>'registration successfully', 'user' => $user, 'access_token' => $accessToken]);

    }

    public function check_if_the_same_device(Request $request){

        $student = User::query()->where('mobile',$request->mobile)->first();
        if($student){
            if($student->mac_address == $request->mac_address){
                return response([
                    'status' => true,
                    'message' => 'نفس الجهاز',
                    'code' => 200,
                ]);
            }else{
                return response([
                    'status' => false,
                    'message' => 'ليس نفس الجهاز',
                    'code' => 400,
                ]);
            }
        }else{
            return response([
                'status' => false,
                'message' => 'هذا الرقم غير مسجل في النظام',
                'code' => 400,
            ]);
        }
     
    }

    public function add_new_password(Request $request){
        $student = User::query()->where('mobile',$request->mobile)->first();
        if($student){
            if($student){
                if($student->mac_address == $request->mac_address){
                    $student->password = Hash::make($request->password);
                    $student->save();
                    return response([
                        'status' => true,
                        'message' => 'تم تغيير كلمة المرور بنجاح',
                        'code' => 200,
                    ]);
                }else{
                    return response([
                        'status' => false,
                        'message' => 'ليس نفس الجهاز',
                        'code' => 400,
                    ]);
                }
              
            }else{
                return response([
                    'status' => false,
                    'message_ar' => 'هذا الرقم غير مسجل في النظام',
                    'code' => 400,
                ]);
            }
        }else{
            return response([
                'status' => false,
                'message' => 'هذا الرقم غير مسجل في النظام',
                'code' => 400,
            ]);
        }
      
    }


    public function check_mac(Request $request) {
        $user_mac = User::where('mac_address',$request->mac_address)->first();
        
        if($user_mac){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'mac used',
                
            ]);
        }
        
         return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'not registered',
                
            ]);
    }



    public function register_tow(Request $request)
    {
     
      $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'mobile'     => 'required|unique:users,mobile',   
            'password'  => 'required',
            'study'  => 'required',
            'level'  => 'required',
            // 'gender'  => 'required',
            // 'date_of_birth'  => 'required',
            // 'topics'  => 'required',
            'fcm_token'    => 'required',
          
         
        ]);
        
          if ($validator->fails()) {
            $errors = $validator->errors();

            return response([
                'status'=>false,
                'message'=>'Make sure that the information is correct and fill in all fields',
                'errors'=>$errors,
                'code'=>422
            ]);
        }

        $user_mac = User::where('mac_address',$request->mac_address)->first();
        if($user_mac){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'mac_address',
                
            ]);
        }

        DB::beginTransaction();
        try {

        $user = new User();
        $user->name         = $request->name;
        $user->mobile       = $request->mobile;
        $user->password     = bcrypt($request->password);
        $user->password_show     = $request->password;
        $user->study        = $request->study;
        $user->level        = $request->level;
        if(isset($request->gender)){
            $user->gender       = $request->gender; 
        }
        if(isset($request->date_of_birth)){
            $user->date_of_birth       = $request->date_of_birth; 
        }
       
      
        $user->fcm_token    = $request->fcm_token;
        $user->is_verify_account    = 1;
        $user->mac_address    = $request->mac_address;
        $user->save();

        $verifed_data = new VerifiedData();
        $verifed_data->personal_photo = "dd";
        $verifed_data->front_image_id = "ff";
        $verifed_data->back_image_id ="ff";
        $verifed_data->full_name="ff";
        $verifed_data->user_id = $user->id;
        $verifed_data->status = 1;
        $verifed_data->save();

        if(isset($request->topics)){
        $topics = json_decode($request->topics);
        foreach($topics as $top){
            $topic = Topic::where('id',$top)->first();
            $user_topics = new UserTopic();
            $user_topics->user_id = $user->id;
            $user_topics->topic_id = $topic->id;
            $user_topics->topic_name = $topic->name;
            $user_topics->save();
        }
        }
        
        DB::commit();

            }

            catch (\Exception $e) {
                DB::rollback();
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'something error',
                    'errors'       => $e,
                    
                ]);

        }
        



        $accessToken = $user->createToken($user->email)->accessToken;

        return response([ 'code'=> 200, 'status' => true, 'message'=>'registration successfully', 'user' => $user, 'access_token' => $accessToken]);

    }


    public function login(Request $request)
    {

      $loginData = Validator::make($request->all(), [
            'mobile' => 'required',
            'password' => 'required',
            'fcm_token'    => 'required',
            'mac_address'    => 'required'
        ]);
        
          if ($loginData->fails()) {
            $errors = $loginData->errors();

            return response([
                'status'=>false,
                'message'=>'Make sure that the information is correct and fill in all fields',
                'errors'=>$errors,
                'code'=>422
            ]);
        }
        

        $user = User::where('mobile',$request->mobile)->first();

      

      

        if($user)
        {

            if($user->is_block == 1){
                return response([
                    'status' => false,
                    'message' => 'تم حظر الحساب',
                    'code' => 400,
                ]);
            }

            if($user->proxy == 1){
                return response([
                    'status' => false,
                    'message' => 'تم ايقاف حسابك بسبب انتهاك حقوق الطبع والنشر .. سيتواصل الدعم معك خلال اليوم لاخذ الاجراءات القانونية بحقك',
                    'code' => 400,
                ]);
            }

       

            if($user->mac_address != $request->mac_address && $user->reset_login != 0 && $user->mobile != "009647703391199" && $user->mobile != "009647729292827"){
                return response()->json([
                    'code'          => 404,
                    'status'        => false,
                    'message'       => 'mac_address',
                    
                ]);
            }

        

  
            if (!Hash::check($request->password, $user->password)) {
        
                return response()->json(
                    ["errors"=>[
                        "password"=>[
                         "Invalid Password!"
                        ]
                    ],
                    "status"=>false,
                    'code' => 404,
                ]);
            }

            if($user->reset_login == 0){
                $user->reset_login = 1;
            }

            $user->mac_address =  $request->mac_address;
            $user->fcm_token =  $request->fcm_token;
            
            $user->save();
    
           
            $accessToken =     $user->createToken('authToken')->accessToken;

            return response([
                'code' => 200,
                'status' => true,
                'message' => 'login Successfully',
                'user' => $user,
                'access_token' => $accessToken
            ]);
        }
        else
        {
 
            return response()->json(
                ["errors"=>[
                    "mobile"=>[
                      "No Account Assigned To This Phone Number!"
                    ]
                ],
                "status"=>false,
                'code' => 404,
            ]);

        }

    }


    public function check_is_mobile(Request $request){
        $mobile = User::where('mobile',$request->mobile)->where('deleted_at',null)->first();

        if(isset($mobile)){
            return response()->json(
                ["errors"=>[
                    "mobile"=>[
                    "The mobile has already been taken."
                    ]
                ],
                "status"=>false
            ]);
        }else{
            return response([
                'code' => 200,
                'status' => true,
                'message' => 'mobile not used',
            ]);
        }
    }




    public function check_mobile_code(Request $request){
        $loginData = $request->validate([
            'mobile' => 'required',
            'verify_mobile_code' => 'required',
        ]);
    
        $user = User::where('mobile',$request->mobile)->first();
      

        if(!$user){
            return response()->json(
            [   'code' => 404,
                'status' => false,
                'message' => 'mobile not exist',
            ]);
            
        }


        if($user->verify_mobile_code == $request->verify_mobile_code){
            $user['address'] = Address::where('user_id',Auth::guard('api')->user()->id)->get();

            $accessToken =     $user->createToken($user->mobile)->accessToken;

            return response(['user' => $user, 'message'=>'login successfully','code'=>'200','status'=>'true','access_token' => $accessToken]);

        }else{
            return response()->json(
                [   'code' => 404,
                    'status' => false,
                    'message' => 'Code does not match',
                ]);

        }


    }



    public function login_social(Request $request){

        $loginData = $request->validate([
            'email' => 'email|required',
        ]);

        $user = User::where('email',$request->email)->first();

    
        if(!$user){
            return response()->json(['status'=>false,
                'message'=>'email not found',
              
               
                'code'=>404]);
        }


        $user = User::query()->where('email',$request->email)->first(); 

 

        $user->fcm_token = $request->fcm_token;
        $user->social_id = $request->social_id;
        $user->type_soc = $request->type_soc;
        
        $user->save();
    
        $accessToken = $user->createToken($user->mobile)->accessToken;


        return response([ 'status' => true,
                        'message_en' => 'Login successfully',
                        'message_ar' => 'تمت عملية الدخول بنجاح',
                        'access_token' => $accessToken,
                        'code' => 200,]);
          
    }


    public function register_social(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users',
            'type_soc' => 'required',
            'social_id'=>'required',
            'fcm_token'=>'required',
        ]);


        if ($validator->fails()) {
            $errors = $validator->errors();

            return response([
                'status'=>false,
                'message'=>'Make sure that the information is correct and fill in all fields',
                'errors'=>$errors,
                'code'=>422
            ]);
        }

        if ($validator->passes()) {

            $data =$request->all();
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['type_soc'] = $request->type_soc;
            $data['social_id'] = $request->social_id;
            $data['fcm_token'] = $request->fcm_token;
   
     
            $user = User::create($data);
         
            $accessToken = $user->createToken($user->mobile)->accessToken;
            
   
            return response([ 'code'=> 200, 'status' => true, 'message'=>'registration successfully', 'user' => $user, 'access_token' => $accessToken]);
  
        }

    }



    public function forget_password(Request $request)
    {
        $user = User::where('mobile',$request->mobile)->first();

        if($user)
        {
            $code = mt_rand(2000,9000);
            $user -> verify_mobile_code = $code;
            $user -> save();

            return response([
                'code' => 200,
                'status' => true,
                'message' => 'code has sent',
                'verify_code' => $code
            ]);
        }
        else
        {
            return response([
                'code' => 404,
                'status' => false,
                'message' => 'Mobile does not exist',
            ]);

        }
    }


    public function check_code_forget_password(Request $request)
    {
        $user = User::where('mobile',$request->mobile)->first();

        if(!$user){
              return response([
                'code' => 404,
                'status' => false,
                'message' => 'Code does not match',
            ]);
        }

        if($user->verify_mobile_code == $request->code)
        {
            return response([
                'code' => 200,
                'status' => true,
                'message' => 'code matches',
            ]);
        }
        else
        {
            return response([
                'code' => 404,
                'status' => false,
                'message' => 'Code does not match',
            ]);

        }
    }



    public function reset_password(Request $request){
        $user  = User::where('mobile',$request->mobile)->first();

        if(!$user){
            return response([
                'code' => 404,
                'status' => true,
                'message' => 'mobile does not exist',
            ]);
        }else{
            $user_code  = User::where('mobile',$request->mobile)->pluck('verify_mobile_code')->first();
          
            if($user_code == $request->code_verfication){
         
                    $user ->password = Hash::make($request->new_password);
                    $user ->password_show = $request->new_password;
                    $user->save();
                    return response([
                        'code' => 200,
                        'status' => true,
                        'message' => 'updated successfully',
                    ]);
              
            }else{
                return response([
                    'code' => 404,
                    'status' => true,
                    'message' => 'verfication code is wrong',
                ]);
            }
        
        }
    }


    public function update_password(Request $request){
        $user  = User::where('id',Auth::guard('api')->user()->id)->first();

        if(!$user){
            return response([
                'code' => 404,
                'status' => true,
                'message' => 'user not exist',
            ]);
        }else{


            
            if(Hash::check($request->old_password , $user->password)){
                $user ->password = Hash::make($request->new_password);
                $user->save();
                return response([
                    'code' => 200,
                    'status' => true,
                    'message' => 'updated successfully',
                ]);
            }else{
                return response([
                    'code' => 404,
                    'status' => false,
                    'message' => 'the current password is wrong',
                ]);
            }

        }
    }
    
    public function logout(){
            
            $user = Auth::guard('api')->user()->token();
            $user->revoke();
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => 'logout Successfully',
                
            ]);
    }



}
