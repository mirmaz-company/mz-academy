<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\lessonsSalePoints;

class LessonController extends Controller
{
    public function lessons(){

        return view('lessons.index');
    }

    public function get_all_lessons(Request $request)
    {
        if ($request->ajax()) {
            $data = Lesson::where('status_laravel','!=',0)->where('status_laravel','!=',0)->where('link','!=',NULL)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('lessons.btn.action', compact('data'));
                })
                
                

                ->addColumn('course_id', function ($data) {
                    $course = Course::where('id',$data->course_id)->first();
                    if($course){
                        return $course->name;
                    }else{
                        return '-';
                    }
                })
                ->addColumn('teacher_id', function ($data) {
                    $course = Course::where('id',$data->course_id)->first();
                    if($course){
                       $teacher = Teacher::where('id',$course->teacher_id)->first();
                       if($teacher){
                        return $teacher->name;
                       }
                    }else{
                        return '-';
                    }
                })




                ->rawColumns(['image','sale_points'])

                ->make(true);
        }
    }

    public function store_lessons(Request $request){

        $request->validate([
            'city'              => 'required',
            'price'              => 'required|numeric',

        ]);



        $city = new City();
        $city ->city                  = $request->city;
        $city ->price                  = $request->price;


        $city -> save();



        if ($city) {
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


    public function update_lessons(Request $request){


        $request->validate([
            'city'              => 'required',
            'price'              => 'required|numeric',
        ]);


        $city = City::findorFail($request->id);


        $city->city            = $request->city;
        $city->price            = $request->price;

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


    public function publish_now(Request $request){
        $lesson = Lesson::where('id',$request->id)->first();

        $updatedAt = $lesson->updated_at;

        $date = Carbon::createFromFormat('Y-m-d H:i:s', $updatedAt);
        $lastDayOfPreviousMonth = $date->subDay();
    
        $formattedDate = $lastDayOfPreviousMonth->format('Y-m-d H:i:s');
      
        $lesson->updated_at = $formattedDate;
        $lesson->save();

        return response()->json([
            'status' => true,
            'msg' => 'تم نشر الدرس',
        ]); 
    }

    public function destroy_lessons(Request $request){

        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
