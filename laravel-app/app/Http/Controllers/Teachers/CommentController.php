<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Comment;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\LessonCommentReply;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class CommentController extends Controller
{
    public function comments($id){

    
        $id = Crypt::decrypt($id);  

     
        return view('teachers.comments.index',compact('id'));

    }

    public function get_all_comments(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = Comment::where('lesson_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('user_id', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    return $user->name ?? "-";
                })
                
              
                ->addColumn('image', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    if($user){

                        return  '<img src="'.$user->image.'" alt="" style="width:80%;border-radius:50%">';
                    }else{
                        return '-';
                    }
                     
                  })


                ->addColumn('reply', function ($data) {
                    $count_reply = LessonCommentReply::where('comment_id',$data->id)->count();
                   
                    $id= Crypt::encrypt($data->id); 
                    return '<a href="'.route('teachers.reply',$id).'">'. $count_reply.'</a>';
                })


                ->addColumn('action', function ($data) {
                    return view('teachers.comments.btn.action', compact('data'));
                })

            

                ->rawColumns(['image','reply'])

                ->make(true);
        }
    }

    public function store_comments(Request $request){
       
        $request->validate([
            'comment'              => 'required',
       
        ]);

        // جبتها من جدول المستخدمين لانو لما انشات الأستاذة ضفتها ايضا على جدول المتسخدمين عشان اقدر اطول تعليقاتها


        if(Auth::guard('teachers')->user()->parent == 0){
            $user = User::where('type',Auth::guard('teachers')->user()->id)->first();
        }else{
            $user = User::where('type',Auth::guard('teachers')->user()->parent)->first();
        }
       

        $comment = new Comment();
        $comment ->user_id     = $user->id;
        $comment ->lesson_id     = $request->lesson_id;
        $comment ->comment     = $request->comment;

        $lesson = Lesson::where('id',$request->lesson_id)->first();
        $comment ->course_id     = $lesson->course_id;
        
        $comment -> save();

   

        if ($comment) {
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




    public function destroy_comments(Request $request){
           
        $comment = Comment::find($request->id);
        $comment->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
