<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
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
use App\Models\PostComment;
use App\Models\PostUserLike;
use Illuminate\Http\Request;
use App\Models\PostShareUser;
use App\Models\UserFollowTeacher;
use App\Models\LessonCommentReply;
use App\Http\Controllers\Controller;
use App\Models\PostLikeComment;
use App\Models\PostReplyComment;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{


    public function get_posts(Request $request){

        if(Auth::guard('api')->check()){
            $my_teacher_follow = UserFollowTeacher::where('user_id',Auth::guard('api')->user()->id)->pluck('teacher_id');

            // جلب بوستات الاساتذة الذين اتابعهم فقط
            $posts = Post::whereIn('teacher_id',$my_teacher_follow)->orWhere('teacher_id',0)->with('images')->orderBy('id','desc')->paginate(10);

        }else{
        // جلب بوستات الاكاديمية عندما التيتشر id = صفر
            $posts = Post::where('teacher_id',0)->with('images')->orderBy('id','desc')->paginate(10);
        }

       

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data' =>       $posts,
     
        ]);
    }

    
    public function add_like_to_post(Request $request){

        $is_like = PostUserLike::where('user_id',Auth::guard('api')->user()->id)->where('post_id',$request->post_id)->first();

        $post = Post::where('id',$request->post_id)->first();

        if($is_like){
            $is_like->delete();

            $post->count_like = $post->count_like - 1;
            $post->save();

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'removed like',
            ]);

        }else{

            $post_user_like = new PostUserLike();
            $post_user_like->user_id = Auth::guard('api')->user()->id;
            $post_user_like->post_id = $request->post_id;
            $post_user_like->save();

            $post->count_like = $post->count_like + 1;
            $post->save();

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'added like',
            ]);

        }

    }


    public function add_comment(Request $request){

        $add_comment = new PostComment();
        $add_comment->user_id = Auth::guard('api')->user()->id;
        $add_comment->post_id = $request->post_id;
        $add_comment->comment = $request->comment;
        $add_comment->save();

        $post = Post::where('id',$request->post_id)->first();
        $post->count_comment = $post->count_comment + 1;
        $post->save();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'addeded successfully',
            'comment_id'       => $add_comment->id,
        ]);

    }


    public function delete_comment(Request $request){

        $comment = PostComment::where('id',$request->comment_id)->first();

        if($comment){
            $comment->delete();
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'deleted successfully ',
            ]);
        }else{
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found ',
            ]);
        }

    }


    public function increase_count_share(Request $request){


        
        $post = Post::where('id',$request->post_id)->first();
     
        if(!$post){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found ',
            ]);
        }
        
        $count_share = PostShareUser::where('post_id',$request->post_id)->where('user_id',Auth::guard('api')->user()->id)->first();

        if(!$count_share){
            $count_share = new PostShareUser();
            $count_share->user_id = Auth::guard('api')->user()->id;
            $count_share->post_id = $request->post_id;
            $count_share->save();

            $post->count_share =  $post->count_share + 1;
            $post->save();
    
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'increase count share successfully ',
            ]);

        }else{
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'is share',
            ]);
        }

        


      

    }


    public function add_like_comment(Request $request){


        $comment = PostComment::where('id',$request->comment_id)->first();
        if(!$comment){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
            ]);
        }


        $is_like = PostLikeComment::where('user_id',Auth::guard('api')->user()->id)->where('comment_id',$request->comment_id)->first();

        if($is_like){
            $is_like->delete();

            $post_comment = PostComment::where('id',$request->comment_id)->first();
            $post_comment->count_like =  $post_comment->count_like - 1;
            $post_comment->save();

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'removed like successfully',
            ]);

        }else{

            $is_like = new PostLikeComment();
            $is_like->user_id = Auth::guard('api')->user()->id;
            $is_like->comment_id = $request->comment_id;
            $is_like->save();

            $post_comment = PostComment::where('id',$request->comment_id)->first();
            $post_comment->count_like =  $post_comment->count_like + 1;
            $post_comment->save();

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'added like successfully',
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


    public function all_comments(Request $request){

        $comments = PostComment::where('post_id',$request->post_id)->orderBy('id','desc')->paginate(15);

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'data'       => $comments,
        ]);

    }

  
    public function add_reply(Request $request){


        $comment = PostComment::where('id',$request->comment_id)->first();

        if(!$comment){

            return response()->json([
                'code'          =>  404,
                'status'        =>  false,
                'message'       => 'not found',
            ]);

        }


        $reply = new PostReplyComment();

        $reply->comment_id = $request->comment_id;
        $reply->reply = $request->reply;
        $reply->user_id = Auth::guard('api')->user()->id;
        $reply->save();


        $user_id_of_comment = PostComment::where('id',$reply->comment_id)->first();

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
            'message'       => 'added successfully',
            'reply_id'       =>$reply->id,
        ]);


    }



    public function all_reply(Request $request){


        $comment = PostComment::where('id',$request->comment_id)->first();

        if(!$comment){

            return response()->json([
                'code'          =>  404,
                'status'        =>  false,
                'message'       => 'not found',
            ]);

        }



        $all_reply = PostReplyComment::where('comment_id',$request->comment_id)->orderBy('id','desc')->get();

             return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data successfully',
            'data'          => $all_reply 
        ]);



    }


    public function get_post_by_id(Request $request){
        $post = Post::where('id',$request->post_id)->with('images')->first();

        if($post){

            
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data successfully',
                'data'          => $post 
            ]);

        }else{
            return response()->json([
                'code'          =>  404,
                'status'        =>  false,
                'message'       => 'not found',
            ]);
        }
    }


    public function get_posts_teacher(Request $request){
        $posts  = Post::Where('teacher_id',$request->teacher_id)->with('images')->orderBy('id','desc')->paginate(15);

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data successfully',
            'data'          => $posts 
        ]);
    }



}
