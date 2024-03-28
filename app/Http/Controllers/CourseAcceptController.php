<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\Teachers\Course;
use Yajra\DataTables\DataTables;
use App\Models\NotificationTeacher;

class CourseAcceptController extends Controller
{
    public function courses_accept(){
     
        return view('courses_accept.index');
    }

    public function get_all_courses_accept(Request $request)
    {
        if ($request->ajax()) {
            // 0 لم يتم النشر
            // 1 جاري النشر
            // 2 تم النشر
            $data = Course::where('status',1)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('courses_accept.btn.action', compact('data'));
                })
          
                
                ->addColumn('teacher_id', function ($data) {
                    
                    $teacher = Teacher::where('id',$data->teacher_id)->first();
                 
                        return $teacher->name ?? "-";
            

                })
                ->addColumn('subject_name', function ($data) {
      
                    $subject = Subject::where('id',$data->subject_id)->first();
                    return $subject->name ?? "-";
                })
                ->addColumn('sections', function ($data) {
       
                    $sections = Section::where('course_id',$data->id)->count();
                    return $sections;
                
                })
                ->addColumn('lessons', function ($data) {

                   $lessons = Lesson::where('course_id',$data->id)
                   ->where("status_laravel",1)
                   ->where("status_node",1)
                   ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
                   ->where('link', '!=', NULL)
                   ->where('is_scheduler',1)->count();
                   return $lessons;

                })
            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function accept_this_course(Request $request){
        $course = Course::where('id',$request->id)->first();
        $course->status = 2;
        $course->save();


        $not = new NotificationTeacher();
        $not->title = "تم قبول الدورة" .$course ->name;
        $not->teacher_id = $request->teacher_id;
        $not->save();

        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
        ]);
    }


    public function decline_this_course(Request $request){
        $course = Course::where('id',$request->id)->first();
        $course->status = 3;
        $course->save();

        $not = new NotificationTeacher();
        $not->title = "تم رفض الدورة".$course ->name;
        $not->description = $request->decline;
        $not->teacher_id = $request->teacher_id;
        $not->save();

        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
        ]);
    }

    public function store_cities(Request $request){
       
        $request->validate([
            'city'              => 'required',
       
        ]);

     

        $city = new City();
        $city ->city                  = $request->city;

        
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

    public function destroy_cities(Request $request){
           
        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
