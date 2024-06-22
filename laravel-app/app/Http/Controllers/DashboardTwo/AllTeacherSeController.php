<?php

namespace App\Http\Controllers\DashboardTwo;

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
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class AllTeacherSeController extends Controller
{
    public function all_teachers_se(){
        if (session()->has('password_notification')) {
            
             return view('dashboard_two.all_teachers_se.index');
         } else {
                
             return view('sliders.index');
        }
    }




    public function get_all_all_teachers_se(Request $request)
    {
        if ($request->ajax()) {
         
         
            $data = Teacher::where('parent',0)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('courses', function ($data) {
                    $courses = Course::Where('teacher_id',$data->id)->where('type','paid_public')->count();
                   
                    return '<a href="'.route('courses_acc',$data->id).'">'. $courses.'</a>';
                 
                })
                ->addColumn('courses_private', function ($data) {
                    $courses = Course::Where('teacher_id',$data->id)->where('type','private')->count();
                   
                    return $courses;
                 
                })
                ->addColumn('ratio', function ($data) {
                    return '%' . $data->ratio;
                 
                })

                
                ->addColumn('action', function ($data) {
                    return view('dashboard_two.all_teachers_se.btn.action', compact('data'));
                })
 

                ->rawColumns(['image','courses'])

                ->make(true);
        }
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
