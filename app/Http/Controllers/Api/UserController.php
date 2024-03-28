<?php

namespace App\Http\Controllers\Api;

use DateTime;
use App\Models\City;
use App\Models\User;
use App\Models\Level;
use App\Models\Proxy;
use App\Models\Study;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Estate;
use App\Models\Address;
use App\Models\Article;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Subject;
use App\Models\Support;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Investor;
use App\Models\Language;
use App\Models\VpnCheck;
use App\Models\UserTopic;
use App\Models\TypeEstate;
use Illuminate\Http\Request;
use App\Models\InstalledApps;
use App\Models\CitiesSalePoints;
use App\Models\StudentAreSaying;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class UserController extends Controller
{
    public function user(){

        $user = User::all();


        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'added successfully',
            'data' => $user
        ]);
    }

    public function get_profile_by_id(Request $request){
        $user = User::where('id',$request->id)->first();

        if(!$user){
            return response()->json([
                'code' => 404,
                'status' => false,
                'message' => 'Not exist',
             
            ]);

        }else{
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => 'fetch data succsessfully',
                'data' => $user
            ]);

        }
    }

    public function my_profile(){
        $user = User::where('id',Auth::user()->id)->first();
        $user['level_name'] = Level::where('id',$user->level)->pluck('name')->first();
        $user['study_name'] = Study::where('id',$user->study)->pluck('name')->first();

        if(!$user){
            return response()->json([
                'code' => 404,
                'status' => false,
                'message' => 'Not Authnticate',
             
            ]);

        }else{
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => 'fetch data succsessfully',
                'data' => $user
            ]);

        }
    }

    public function update_profile(Request $request){
        $user = User::where('id',Auth::guard('api')->user()->id)->first();
   

        if(!$user){
            return response()->json([
                'code' => 404,
                'status' => false,
                'message' => 'Not exist',
             
            ]);

        }else{
  
         
            $request->validate([
                'name'      => 'required',
                'email'     => 'email|required|unique:users,email,'.$user->id,   
                'mobile'    => 'integer|nullable|unique:users,mobile,'.$user->id,
             
            ]);

            
            $my_profile = User::where('id',Auth::user()->id)->first();
    
            $my_profile->name = $request->name;
            $my_profile->email = $request->email;
            $my_profile->mobile = $request->mobile;

            if ($request->hasFile('image')) {
            
                //  اخزن اسم الصورة في الداتابيز
                 $image_url =  $request->image->getClientOriginalName();
 
                 
                 $base_url = url('attachments/profile/'. $image_url );
 
 
                 $my_profile -> image   = $base_url;
 
 
                 $request->image-> move(public_path('attachments/profile'), $image_url);
                   //  اخزن الصورة في السيرفر
                 //  $request->image->move('attachments/sliders/', $image_url);
       
 
          }
    
    
            $my_profile->save();
    
            return response()->json([
                'code' => 200,
                'status' => true,
                'message' => 'updated Successfully',
            ]);

        }
    }

    public function get_categories(){
        $categories = Category::all();

        return response()->json([
            'code' => 200,
            'status' => true,
            'message' => 'updated Successfully',
            'data'=>$categories
        ]);
    }


    public function send_proxy(Request $request){

        $user_proxy = new Proxy();
        $user_proxy->user_id = Auth::guard('api')->user()->id;
        $user_proxy->text = $request->text;
        $user_proxy->deleted_at = null;
        $user_proxy->save();

        $user = User::where('id',Auth::guard('api')->user()->id)->first();
        if($user){
            $user->proxy =1;
            $user->save();

            $user = Auth::guard('api')->user()->token();
            $user->revoke();
        }
        
            return response([
                            'status'    =>false,
                            'message_en'=>'  ',
                            'message_ar'=>'تم بنجاح ',
                           
                        ]);
      
    }


      public function get_ios_version(Request $request){

         $queryParams = [
            'bundleId' => 'com.mustafahameed.mirmazacademy',
            'cache-prevent' => (string) (new DateTime())->getTimestamp()
        ];

       $response = Http::get('https://itunes.apple.com/lookup', $queryParams);

       return response()->json($response->json());
    }

   

    public function cities(){
             
        $cities = City::all();

        $city_fill = [];

        foreach($cities as $city){
            $sale_point = CitiesSalePoints::where('city_id',$city->id)->first();
            if($sale_point){
                $city_fill[] = $city;
            }
        }
     

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'cities' => $city_fill,
     
        ]);
    }

    public function get_settings(){
        $settings = Setting::where('id',1)->first();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'settings' => $settings,
     
        ]);
    }


    public function support(Request $request){

        $support = new Support();

        $support->message = $request->message;
        $support->user_id = Auth::user()->id;

        $support->save();



        return response()->json([
            'code'              => 200,
            'status'            => true,
            'message'           => 'Sent Successfully',
        ]);
       
    }


    public function add_favorite(Request $request){


        $request->validate([
            'product_id'      => 'required|integer',
        ]);


        $favorite = Favorite::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->first();

        if($favorite){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'exist favorite',
         
            ]);
        }


        $favorite = new Favorite();

        $favorite->user_id        =    Auth::user()->id;
        $favorite->product_id      =    $request->product_id;

       
        $favorite->save();


        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'added successfully to favorite',
     
        ]);

    }



    public function remove_favorite(Request $request){

        $favorite = Favorite::where('product_id',$request->product_id)->where('user_id',Auth::user()->id)->first();

        if(!$favorite){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not exist',
         
            ]);
        }
        $favorite->delete();


        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'deleted successfully',
     
        ]);

    }


    public function change_photo(Request $request){
        $user = User::Where('id',Auth::guard('api')->user()->id)->first();

        if($user){

            if ($request->hasFile('image')) {
            
                //  اخزن اسم الصورة في الداتابيز
                 $image_url =  $request->image->getClientOriginalName();
 
                 $image_url =  rand(223423,23423444) . $image_url;
 
                 
                //  $base_url = url('attachments/profile/'. $image_url );
                $base_url = env("APP_URL") . '/attachments/profile/' . $image_url; 
 
                 $user -> image   = $base_url;
                 $user->save();
 
 
                 $request->image-> move(public_path('attachments/profile'), $image_url);
               
            }


            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'change succsessfully',
                'image'       =>  $user -> image
                
         
            ]);
        }else{
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
              
         
            ]);
        }
    }


    public function change_phone_number(Request $request){

        $user = User::Where('id',Auth::guard('api')->user()->id)->first();

        $mobile_is_exist = User::where('mobile',$request->mobile)->where('id','!=',Auth::guard('api')->user()->id)->first();
      
        if ($mobile_is_exist) {
        
            return response()->json([
                "message"=>'رقم الموبايل موجود مسبقا',
                "status"=>false,
                'code' => 404,

            ]);
            
        }

        if (!Hash::check($request->password, $user->password)) {
        
            return response()->json([
                "message"=>'الباسورد خاطئ',
                "status"=>false,
                'code' => 404,

            ]);
            
        }



        if($user){

          $user->mobile = $request->mobile;
          $user->save();
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'change succsessfully',
                
         
            ]);
        }else{
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
              
         
            ]);
        }
    }


    public function list_favorite(){

        $favorites           = Favorite::where('user_id',Auth::user()->id)->get();

        foreach($favorites as $favorite){
             $favorite['products'] = Product::where('id',$favorite->product_id)->first();
        }


        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data'          =>  $favorites
     
        ]);
    }

    public function send_support(Request $request){

        $support = new Support();
        $support->user_id = Auth::guard('api')->user()->id;
        $support->message = $request->message;

        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/sliders/'. $image_url );


             $support -> image   = $base_url;


             $request->image-> move(public_path('attachments/support'), $image_url);
    

          }

        $support->save();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم ارسال المشكلة الى الدعم..سيتم التواصل معك قريبا',
          
     
        ]);

    }



    public function add_student_are_saying(Request $request){
      

        $studn = StudentAreSaying::where('is_veiw_form',1)->where('user_id',Auth::guard('api')->user()->id)->get();

        if($studn->count() > 0){
            foreach( $studn as $st){
                $st->is_veiw_form = 0;
                $st->save();
            }
        } 


        $s = new StudentAreSaying();
        $s->user_id = Auth::guard('api')->user()->id;
        $s->rate = $request->rate;
        $s->comment = $request->comment;
        $s->save();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'نشكرك على التقييم..ستيم عرض التقييم لاحقا',
          
        ]);
    }


    public function student_are_saying(){

        
        $s =  StudentAreSaying::where('is_veiw',1)->take(8)->orderBy('rate','desc')->orderBy('id','desc')->get();
        foreach($s as $m){
            $m['user'] = User::where('id',$m->user_id)->first(['id','name','image']);
        }
        
       

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم جلب البيانات بنجاح',
            'data'        => $s,
          
        ]);
    }

    public function student_are_saying_see_all(){

        
        $s =  StudentAreSaying::where('is_veiw',1)->orderBy('id','desc')->paginate(7);
        foreach($s as $m){
            $m['user'] = User::where('id',$m->user_id)->first(['id','name','image']);
        }
       

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم جلب البيانات بنجاح',
            'data'        => $s,
          
        ]);
    }

    public function send_notification($title,$body)
    {
        $from = "AAAAO0HvF7s:APA91bGnIXUIMpeJNaZKtTlghSEIOM8igliowU1OABoNluaJDDJurbr65ywq9FCDTRGuwQ9f0vhEuOkkQ8kEv9dyJnU7NALxsw9clqY9Nbbaw1V08YLoqr8uMWTm_1nhBr370Kioz0Z8";
        $to = ["dteud5QzROGMdUwgwi1V5M:APA91bGKkV-sps5Ym8jNAAYWthBqP_3z0YLShFCuvCnyFXbcXHejxFa04TLcDqgFx-vq6WUqKIaSIAs6DTUuMkS7g4PZ9U_Gq2dwgcuwHLWCVniMG1EXMlqWesC3u4W7mJkmNkKmWwjX", 
            "cM98WoZpikWus21lBntmsj:APA91bGBfehRfoMq2y-kgQ4RzOfHZMiLOFinQXHS4cy879YN4enBbx6pTESsx1vzdqn1enVWcxMnTSwYST8FG9Jt_a7UuIo3YlvVAqmk7uOjICS8vC5mkyhT_jWL5-1TtGOnaLxrZXRy"];

        $msg = array
        (
            'title' => $title,
            'body' => $body,
            'sound' => 'default',

        );

        $fields = array
        (
            'registration_ids' => $to,
            'notification' => $msg,
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


    public function vpn_check(Request $request){

        $vpn = new VpnCheck();
        $vpn->user_id = Auth::guard('api')->user()->id;
        $vpn->is_vpn = $request->is_vpn;
        $vpn->trace  = $request->trace;
        $vpn->county = $request->county;
        $vpn->save();

        $country = $request->county;
        
        
        if ($request->trace == null) {
          if(strpos($country, "Iraq") !== false) {
            if(strpos($country, "Cloudflare") !== false) {
                // do nothing
            } else {
                   $this->send_notification("مسرب جديد " . Auth::guard('api')->user()->name . " id:" . Auth::guard('api')->user()->id, Auth::guard('api')->user()->mac_address . " ". $request->county);
            }
         }
        }

        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
        ]);

    }


    public function installed_apps(Request $request){

        $int = InstalledApps::where('user_id',Auth::guard('api')->user()->id)->first();

        if($int){
            $int->text  = $request->text;
            $int->save();
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        }else{

        }

        $int = new InstalledApps();
        $int->user_id = Auth::guard('api')->user()->id;
        $int->text  = $request->text;
        $int->save();

        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
        ]);

    }



    public function check_api() {
        return response()->json([
            "message"=> "Working..",
            ]);
    }


    public function study_level(Request $request){
        $levels = Level::where('study_id',$request->study_id)->get();

        $data = [];

        foreach($levels as $level){
 
            $course = Course::where('level_id',$level->id)->where('is_view',1)->where('status',2)->get();
            // return $subjects;

            if(count($course) != 0){
                // return $subjects;
                $data[] = Level::where('id',$level->id)->pluck('id')->first();
            }

        }

        if(count($data) == 0){
            $data = [];
        }

        $levels= Level::whereIn('id',$data)->orderBy('created_at','asc')->get();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم جلب البيانات بنجاح',
            'data'        => $levels,
          
        ]);
    }


    public function get_lang(){

        $en_US = Language::pluck('word_en','fixed');
        $ar_IQ = Language::pluck('word_ar','fixed');


        return response()->json([
            'code'          => 200,
            'status'        => true,
            'en_US' => $en_US,
            'ar_IQ' => $ar_IQ,
     
        ]);
    }
    
    public function get_lang_test(){

        // check if the results are already cached
        if (Cache::has('language_data')) {
            // return the cached data
            return Cache::get('language_data');
        }
    
        $en_US = Language::pluck('word_en','fixed');
        $ar_IQ = Language::pluck('word_ar','fixed');
    
        $response = response()->json([
            'code'          => 200,
            'status'        => true,
            'en_US' => $en_US,
            'ar_IQ' => $ar_IQ,
        ]);
    
        // cache the results for 1 hour (you can adjust the duration as needed)
        Cache::put('language_data', $response, 60*60);
    
        return $response;
    }

    public function edit_topics(Request $request){

        $user_topics = UserTopic::where('user_id',Auth::guard('api')->user()->id)->get();

        foreach($user_topics as $user_topic){
            $user_topic->delete();
        }

        if($request->user_topics == []){

        }else{

            $m = json_decode($request->user_topics);

            foreach($m as $top){

                $user_topics = new UserTopic();
                $user_topics->user_id = Auth::guard('api')->user()->id;
                $user_topics->topic_id = $top;
                $topic = Topic::where('id',$top)->first();
                $user_topics->topic_name = $topic->name;
                $user_topics->save();

            }

        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم التعديل بنجاح ',
        ]);

    }

    public function my_topics(){

        $user_topics = Topic::all();
        foreach($user_topics as $user_top){
            $user_topics22 = UserTopic::where('user_id',Auth::guard('api')->user()->id)->where('topic_id',$user_top->id)->first();
            if($user_topics22){
                $user_top['is_my_topic'] = 1;
            }else{
                $user_top['is_my_topic'] = 0;
            }
        }

      

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم جلب البيانات بنجاح ',
            'data'        => $user_topics,
        ]);


    }

    public function edit_study_level(Request $request){
        $user = User::where('id',Auth::guard('api')->user()->id)->first();
        if($user){

            $level = Level::where('id',$request->level_id)->first();
            $user->study = $level->study_id;
            $user->level = $request->level_id;
            $user->save();


            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تم تعديل بنجاح',
                'level_id' => $request->level_id,
                'study_id' => $level->study_id,
              
            ]);
        }

    }


}
