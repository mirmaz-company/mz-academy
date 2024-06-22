<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\LessonCommentReply;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class ReplyController extends Controller
{
    public function reply($id){
        
    
        $id = Crypt::decrypt($id);  
        return view('teachers.reply.index',compact('id'));
    }

    public function get_all_reply(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = LessonCommentReply::where('comment_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()


                ->addColumn('user_id', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    return $user->name ?? "-";
                })
                
              
                ->addColumn('image', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    if($user){

                        return  '<img src="'.$user->image.'" alt="" style="width:50%;border-radius:50%">';
                    }else{
                        return '-';
                    }
                     
                  })


                  
                ->addColumn('action', function ($data) {
                    return view('teachers.reply.btn.action', compact('data'));
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


    public function store_reply(Request $request){
       
        $request->validate([
            'reply'              => 'required',
        ]);

        if(Auth::guard('teachers')->user()->parent == 0){
            $user_teacher = User::where('type',Auth::guard('teachers')->user()->id)->first();
        }else{
            $user_teacher = User::where('type',Auth::guard('teachers')->user()->parent)->first();
          
        }
      

        $reply = new LessonCommentReply();
        $reply ->user_id               = $user_teacher->id;
        $reply ->comment_id            = $request->comment_id;
        $reply ->reply                 = $request->reply;

        
        $reply -> save();

        
        $user_id_of_comment =  Comment::where('id',$reply->comment_id)->first();



    
        $user = User::where('id',$user_id_of_comment->user_id)->first();

        if($user){
            if($user->password != "#$%%%#$%#$%#$%#$%#$"){

                $title = ' لقد تم الرد على تعليقك من قبل  '. $user_teacher->name;
                $body = $request->reply;
    
                $usernotification = \App\Models\Notification::create([
                    'user_id' => $user_id_of_comment->user_id,
                    'title' => $title,
                    'body' =>  $body,
                    ]);
    
            
    
                $this->send_notification($user->fcm_token, $title, $body, 0);

            }
         
            
        }

   

        if ($reply) {
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

    public function destroy_reply(Request $request){
           
        $reply = LessonCommentReply::find($request->id);
        $reply->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
