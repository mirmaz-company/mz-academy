<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\Post;
use App\Models\User;
use App\Models\Teacher;
use App\Models\PostImage;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Models\Teachers\Course;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function posts(){
     
        return view('teachers.posts.index');
    }


    public function all_posts(){
       
        return view('teachers.posts.all_posts');
    }

    public function get_all_posts(Request $request)
    {
        if ($request->ajax()) {
            // عشان المساعد يشوف المنشورات 
            if(Auth::guard('teachers')->user()->parent == 0){

                $data = Post::where('teacher_id',Auth::guard('teachers')->user()->id)->orderBy('id','desc');
            }else{
                $data = Post::where('teacher_id',Auth::guard('teachers')->user()->parent)->orderBy('id','desc');

            }
            return Datatables::of($data)

                ->addIndexColumn()

           

                ->addColumn('action', function ($data) {
                    return view('teachers.posts.btn.action', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
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

    public function store_posts(Request $request){
       
     

        // $request->validate([
        //     'city'              => 'required',
        // ]);

     

        $post = new Post();
        if(Auth::guard('teachers')->user()->parent == 0){

             $post ->teacher_id     = Auth::guard('teachers')->user()->id;
             
        }else{

            $post ->teacher_id     = Auth::guard('teachers')->user()->parent;

        }   
        $post ->post_text      = $request->text_post;
        $post -> save();

        if($request->image_or_video == 'video_select'){

            $post_image = new PostImage();
            $post_image->type = 'video';
            $post_image->link = $request->video_link;
            $post_image->post_id = $post->id;
            $post_image->save();


        }elseif($request->image_or_video == 'image_select'){

            if ($request->hasFile('image')) {

                $ignored_files = explode(',', $request->ignored_files); // split the string 
    
                foreach($request->image as $index => $m){
    
                    if (in_array($index, $ignored_files)) {
                       
                    }else{

                        $post_image = new PostImage();
                
                        //  اخزن اسم الصورة في الداتابيز
                         $image_url =  $m->getClientOriginalName();
            
                         $image_url =  rand(223423,23423444) . $image_url;

                         $base_url = url('attachments/images/'. $image_url );
            
            
                         $post_image -> link   = $base_url;
                         $post_image->type = 'image';
                         $post_image->post_id = $post->id;
                         $post_image->save();
            
                         $m-> move(public_path('attachments/images'), $image_url);
            
                         $post_image->save();
        
                    }
                }
    
            }


        }else{

        }

        $title = 'منصة مرماز أكاديمي';
        if(Auth::guard('teachers')->user()->parent == 0){
                $body = 'لقد نشر '. Auth::guard('teachers')->user()->name .' منشور جديد';
        }else{
            $teacher = Teacher::where('id',Auth::guard('teachers')->user()->parent)->first();
            $body = 'لقد نشر '. $teacher->name .' منشور جديد';
        }
       
        if(Auth::guard('teachers')->user()->parent == 0){
            $courses_id = Course::where('teacher_id',Auth::guard('teachers')->user()->id)->pluck('id');
            $user_courses = UserCourse::whereIn('course_id',$courses_id)->pluck('user_id');
        }else{
            $courses_id = Course::where('teacher_id',Auth::guard('teachers')->user()->parent)->pluck('id');
            $user_courses = UserCourse::whereIn('course_id',$courses_id)->pluck('user_id');
        }
        
        $batchSize = 999;
        User::whereIn('id', $user_courses)->chunk($batchSize, function ($users) use ($title, $body) {
            $users_fcm_token = $users->pluck('fcm_token');
            $this->send_notification_a($users_fcm_token, $title, $body,0);
        });
   

        if ($post) {
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


    public function update_posts(Request $request){


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

    public function destroy_posts(Request $request){
           
     
        $post = Post::find($request->id);


        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }
 
  
        if($post->teacher_id != $teacher_id){
            return response()->json([
                'status' => false,
                'msg' => 'غير مصرح بك ',
            ]);
        }
       

        
        $post->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
