<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RatioTeacherController extends Controller
{
    public function ratio_teachers($id){
     
        return view('ratio_teachers.index',compact('id'));
    }

    public function get_all_ratio_teachers(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = Course::where('teacher_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('name_teacher', function ($data) {
                   $teacher = Teacher::where('id',$data->teacher_id)->first();
                   return $teacher->name;
                })

                ->addColumn('number_course', function ($data) {
                    $course_conunt = Course::where('teacher_id',$data->teacher_id)->count();
                    return $course_conunt;
                })
              

                // ->addColumn('ratio', function ($data) use($id) {
                //     $teacher = Teacher::where('id',$id)->first();
                //     $user_course = UserCourse::where('course_id',$data->id)->count();
             
                //     $ratio =   ( $user_course * ($data->price -$data->discount) ) *  $teacher->ratio/100;
                //     return $ratio;
                    
                // })
                // ->addColumn('ratio_academy', function ($data) use($id) {
                //     $teacher = Teacher::where('id',$id)->first();
                //     $user_course = UserCourse::where('course_id',$data->id)->count();
                //     $ratio =  100 - $teacher->ratio ;
                //     $ratio =   ( $user_course * ($data->price -$data->discount) ) *  $ratio/100;
                //     return $ratio;
                    
                // })
                ->addColumn('subsriper', function ($data) use($id) {
                 
                    $user_course = UserCourse::where('course_id',$data->id)->count();
              
                    return $user_course;
                    
                })
                ->addColumn('price_course', function ($data) use($id) {
                 
                  
                    return $data->price -$data->discount;
                    
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_ratio_teachers(Request $request){
       
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
