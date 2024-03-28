<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Wallet;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\UserCourse;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Models\Teachers\Course;
use Yajra\DataTables\DataTables;
use App\Models\NotificationTeacher;
use Maatwebsite\Excel\Facades\Excel;

class CourseAccStatisticsController extends Controller
{
    public function course_statistics($course_id){
        if (session()->has('password_notification')) {
            
             return view('course_statistics.index',compact('course_id'));
         } else {
                
             return view('sliders.index');
        }
    }

    // public function get_all_course_statistics(Request $request)
    // {
    //     if ($request->ajax()) {
    //         // 0 لم يتم النشر
    //         // 1 جاري النشر
    //         // 2 تم النشر
    //         $data = Course::where('status',1)->orderBy('id','desc');
    //         return Datatables::of($data)

    //             ->addIndexColumn()

    //             ->addColumn('action', function ($data) {
    //                 return view('course_statistics.btn.action', compact('data'));
    //             })
          
                
    //             ->addColumn('teacher_id', function ($data) {
                    
    //                 $teacher = Teacher::where('id',$data->teacher_id)->first();
                 
    //                     return $teacher->name ?? "-";
            

    //             })
    //             ->addColumn('subject_name', function ($data) {
      
    //                 $subject = Subject::where('id',$data->subject_id)->first();
    //                 return $subject->name ?? "-";
    //             })
    //             ->addColumn('sections', function ($data) {
       
    //                 $sections = Section::where('course_id',$data->id)->count();
    //                 return $sections;
                
    //             })
    //             ->addColumn('lessons', function ($data) {

    //                $lessons = Lesson::where('course_id',$data->id)
    //                ->where("status_laravel",1)
    //                ->where("status_node",1)
    //                ->where('updated_at' ,"<", Carbon::now()->subHours(1)->toDateTimeString())
    //                ->where('link', '!=', NULL)
    //                ->where('is_scheduler',1)->count();
    //                return $lessons;

    //             })
            

    //             ->rawColumns(['image'])

    //             ->make(true);
    //     }
    // }


    public function get_all_users_courses(Request $request,$course_id)
    {
        if ($request->ajax()) {
            // 0 لم يتم النشر
            // 1 جاري النشر
            // 2 تم النشر
            $user_ids= UserCourse::where('course_id',$course_id)->pluck('user_id');
            $data = User::whereIn('id',$user_ids)->where('id','!=',2)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('data_subscripe', function ($data) use ($course_id) {
                   $user_course = UserCourse::where('user_id',$data->id)->where('course_id',$course_id)->first();
                   if($user_course){
                       return $user_course->created_at->format('Y-m-d');
                   }else{
                        return "-";
                   }
                })
                ->addColumn('notes', function ($data) use ($course_id) {
                   $user_course = UserCourse::where('user_id',$data->id)->where('course_id',$course_id)->first();
                   if($user_course){
                       return $user_course->notes;
                   }else{
                        return "لم يتم اضافة ملاحظة";
                   }
                })
                ->addColumn('transactions', function ($data) use ($course_id) {
                    $transactions = Wallet::where('user_id',$data->id)->where('course_id',$course_id)->where('type_recharge','subscripe')->first();
                    if($transactions){
                        return $transactions->money;
                    }else{
                        return '<span style="color:red"> تمت الاضافة من قواعد البيانات</span>';
                        
                    }
                })
          

                ->rawColumns(['image','transactions'])

                ->make(true);
        }
    }


    public function export_excel($course_id){
      
        $coruse = Course::where('id',$course_id)->first();

        return Excel::download(new UserExport($coruse->id), 'data.xlsx'); // استبدل YourExport بصيغة التصدير الخاصة بك
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
