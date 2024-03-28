<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\QuizStart;
use Illuminate\Http\Request;
use App\Models\Teachers\Course;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class QuizController extends Controller
{
    public function quiz($id){
     
        $id = Crypt::decrypt($id);   
        return view('teachers.quiz.index',compact('id'));
    }

    public function get_all_quiz(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = Quiz::where('lesson_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('teachers.quiz.btn.action', compact('data'));
                })
                ->addColumn('is_view', function ($data) {
                    return view('teachers.quiz.btn.action2', compact('data'));
                })
                ->addColumn('student', function ($data) {

                    $quiz = Quiz::where('id',$data->id)->first();
                    if($quiz->type == "quiz_image" || $quiz->type == "quiz_write"){
                        $quiz_start = QuizStart::where('quiz_id',$data->id)->where('waiting_pending','waiting_pending')->count();

                        $id= Crypt::encrypt($data->id);
                        return  '<a href="'.route('teachers.quiz_students',[$id,'student']).'">'.$quiz_start.'</a>';
                    }else{
                        return '0';
                    }
                     
              
                })
                ->addColumn('student_complete', function ($data) {

                    $quiz = Quiz::where('id',$data->id)->first();
                    if($quiz->type == "quiz_image" || $quiz->type == "quiz_write"){
                        $quiz_start = QuizStart::where('quiz_id',$data->id)->where('waiting_pending','quiz_complete')->count();
                        $id= Crypt::encrypt($data->id);
                        return  '<a href="'.route('teachers.quiz_students',[$id,'student_complete']).'">'.$quiz_start.'</a>';
                    }else{
                        return '0';
                    }
                     
              
                })
                ->addColumn('type', function ($data) {

                    if($data->type == "quiz_image"){
                        return 'تحريري-صور';
                    }elseif($data->type == "quiz_write"){
                        return 'تحريري - كتابة';
                    }else{
                        return 'اختياري';
                    }
              
                })

            

                ->rawColumns(['image','student','student_complete'])

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
       
        if(isset($request->attempt )){
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
        }else{
            $request->validate([
                'name'                       => 'required',
                'time'                       => 'required',
                'qustion_count'              => 'required',
                'points'                     => 'required',
                'type'                     => 'required',
                'points_after_discount'      => 'required',
           
            ]);
        }
     

     

        $quiz = new Quiz();
        $quiz ->lesson_id             = $request->lesson_id;
        $quiz ->name                  = $request->name;
        $quiz ->time                  = $request->time;
        $quiz ->type                  = $request->type;
        if($request->type != "quiz_choose"){

            $quiz ->attempt_count = 100000;

        }else{
            if($request->attempt_count <= 0){
                $quiz ->attempt_count           = 1;
            }else{
                $quiz ->attempt_count           = $request->attempt_count;
            }
        }
        $quiz ->qustion_count           = $request->qustion_count;
        $quiz ->points                  = $request->points;
        $quiz ->points_after_discount   = $request->points_after_discount;
    
       
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
        $quiz->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
