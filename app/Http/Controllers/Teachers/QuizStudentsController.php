<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\QuizStart;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class QuizStudentsController extends Controller
{
    public function quiz_students($id,$type){

        $id = Crypt::decrypt($id);   
     
        return view('teachers.quiz_students.index',compact('id','type'));
    }

    public function get_all_quiz_students(Request $request,$id,$type)
    {
        if ($request->ajax()) {
            if($type == "student_complete"){
                $quiz_start_user_id = QuizStart::where('quiz_id',$id)->where('waiting_pending','quiz_complete')->pluck('user_id');
                $data = User::whereIn('id',$quiz_start_user_id)->orderBy('id','desc');
            }else{
                $quiz_start_user_id = QuizStart::where('quiz_id',$id)->where('waiting_pending','waiting_pending')->pluck('user_id');
                $data = User::whereIn('id',$quiz_start_user_id)->orderBy('id','desc');
            }
           
            return Datatables::of($data)

                ->addIndexColumn()

                   
                ->addColumn('user_mark', function ($data) use ($id) {
                    $quiz_start =  QuizStart::where('user_id',$data->id)->where('quiz_id',$id)->orderBy('id','desc')->first();
                    if($quiz_start){
                        $quiz = Quiz::where('id',$id)->first();
                        if($quiz){
                            return$quiz->points. " / <span class='badge badge-success' style='font-size: 18px;'>".$quiz_start->end_points."</span>";
                        }
                        
                    }else{
                        return 'لا يوجد له علامة';
                    }
                })

                ->addColumn('action', function ($data) use ($id,$type) {
                    return view('teachers.quiz_students.btn.action', compact('data','id','type'));
                })
   
                ->rawColumns(['image','user_mark'])

                ->make(true);
        }
    }


    public function is_view(Request $request){
       $quiz = Quiz::where('id',$request->id)->first();

       $lesson = Lesson::where('id',$quiz->lesson_id)->first();

       if(Auth::guard('teachers')->user()->parent == 0){
           $teacher_id = Auth::guard('teachers')->user()->id;
       }else{
           $teacher_id = Auth::guard('teachers')->user()->parent;
       }

       $section = Section::where('id',$lesson->section_id)->first();
       if($section){
           $course = Course::where('id',$section->course_id)->first();
           if($course){
               if($course->teacher_id != $teacher_id){
                   return response()->json([
                       'status' => false,
                       'msg' => 'غير مصرح بك ',
                   ]);
               }
           }
       }

       if($quiz->is_view == 0){
            $quiz->is_view = 1;
        }else{
            $quiz->is_view = 0;
        }

        $quiz->save();

        if ($quiz) {
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

    public function store_quiz(Request $request){
       
        $request->validate([
            'name'                       => 'required',
            'time'                       => 'required',
            'qustion_count'              => 'required',
            'points'                     => 'required',
            'type'                     => 'required',
            'points_after_discount'      => 'required',
            'attempt_count'              => 'required',
            // 'notes'                      => 'required',
       
        ]);

     

        $quiz = new Quiz();
        $quiz ->lesson_id             = $request->lesson_id;
        $quiz ->name                  = $request->name;
        $quiz ->time                  = $request->time;
        $quiz ->type                  = $request->type;
        $quiz ->qustion_count           = $request->qustion_count;
        $quiz ->points                  = $request->points;
        $quiz ->points_after_discount   = $request->points_after_discount;
        if($request->attempt_count <= 0){
            $quiz ->attempt_count           = 1;
        }else{
            $quiz ->attempt_count           = $request->attempt_count;
        }
       
        $quiz ->notes                   = $request->notes;

        
        $quiz -> save();

   

        if ($quiz) {
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

    public function destroy_quiz(Request $request){
           
        $quiz = Quiz::find($request->id);
        $quiz->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
