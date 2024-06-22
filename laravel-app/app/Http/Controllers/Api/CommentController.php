<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Level;
use App\Models\Study;
use App\Models\Topic;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\OnBoarding;
use App\Models\CommentLike;
use Illuminate\Http\Request;
use App\Models\LessonCommentReply;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{


    public function add_comment(Request $request){

        
        $add_comment = new Comment();
        $add_comment->user_id = Auth::guard('api')->user()->id;
        $add_comment->lesson_id = $request->lesson_id;
        $add_comment->course_id = $request->course_id;
        $add_comment->comment = $request->comment;
        $add_comment->save();


        return response()->json([
            'code'          => 200,
            'status'        => true,
            'comment_id'        =>$add_comment->id,
            'message'       => 'تمت اضافة التعليق ',
          
     
        ]);
    }


    public function get_all_comments(Request $request){

        $comments = Comment::where('lesson_id',$request->lesson_id)->orderBy('id','desc')->paginate(7);

        foreach($comments as $comment){
            $comment['count_comment_reply'] = LessonCommentReply::where('comment_id',$comment->id)->count();
            $comment['user'] = User::where('id',$comment->user_id)->first(['id','name','image']);

            $comment_like = CommentLike::where('comment_id', $comment->id)->where('user_id',Auth::guard('api')->user()->id)->where('lesson_id',$request->lesson_id)->first();
            if($comment_like){
                $comment['is_like'] = true;
            }else{
                $comment['is_like'] = false;
            }
         

            $user_id= CommentLike::where('comment_id',$comment->id)->take(3)->pluck('user_id');
            $comment['three_users_is_like_for_comment']= User::whereIn('id',$user_id)->take(3)->get(['id','image']);

        }
       

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'data'       => $comments,
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


    public function add_reply(Request $request){

        $comments = Comment::where('id',$request->comment_id)->first();

        if(!$comments){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => "not found",
            ]);
        }


        $reply  = new LessonCommentReply();
        $reply->user_id = Auth::guard('api')->user()->id;
        $reply->comment_id = $request->comment_id;
        $reply->reply = $request->reply;
        $reply->save();

        $user_id_of_comment =  Comment::where('id',$reply->comment_id)->first();

        // ارسال اشعار لصاحب الكومنت
        if($user_id_of_comment->user_id != Auth::guard('api')->user()->id){

    
            $user = User::where('id',$user_id_of_comment->user_id)->first();

            if($user){
                $title = ' لقد تم الرد على تعليقك من قبل  '. Auth::guard('api')->user()->name;
                $body = $request->reply;

                $usernotification = \App\Models\Notification::create([
                    'user_id' => $user_id_of_comment->user_id,
                    'title' => $title,
                    'body' =>  $body,
                   ]);

           

                $this->send_notification($user->fcm_token, $title, $body, 0);
            }
    

        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'id_reply'        => $reply->id,
            'message'       => "added successfully",
        ]);
    }


    public function get_reply(Request $request){

        $reply = LessonCommentReply::where('comment_id',$request->comment_id)->get();

        foreach($reply as $rep){
        
            $rep['user'] = User::where('id',$rep->user_id)->first(['id','name','image']);
        }
      

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => "fetch data successfully",
            'data'        => $reply,
        ]);
    }


    public function add_like_comment(Request $request){

        $comments = Comment::where('id',$request->comment_id)->first();

        if(!$comments){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => "not found",
            ]);
        }


        $is_like = CommentLike::where('user_id',Auth::guard('api')->user()->id)->where('comment_id',$request->comment_id)->first();

        if($is_like){

            $is_like->delete();

            $comment = Comment::where('user_id',Auth::guard('api')->user()->id)->where('id',$request->comment_id)->first();
            if($comment){
                  $comment->count_like =  $comment->count_like - 1;
                  $comment->save();
            }
          

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => " remove like for comment successfully",
              
            ]);
    
        }


        $add_like = new CommentLike();

        $add_like->user_id = Auth::guard('api')->user()->id;
        $add_like->comment_id = $request->comment_id;
        $add_like->lesson_id = $request->lesson_id;
        $add_like->save();

        $comment = Comment::where('user_id',Auth::guard('api')->user()->id)->where('id',$request->comment_id)->first();
        
        if($comment){
            
            $comment->count_like =  $comment->count_like + 1;
            $comment->save();
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => " added like for comment successfully",
          
        ]);


    }

}
