<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Course;
use App\Models\TeacherCode;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TeacherCodeSection;
use App\Models\VerifiedData;
use Illuminate\Auth\Events\Verified;

class SectionCodeController extends Controller
{
    public function sections_code($teacher_id){
    
        return view('sections_code.index',compact('teacher_id'));
       
     
    }

    public function get_all_sections_code(Request $request,$teacher_id)
    {
        if ($request->ajax()) {
           
            $data = TeacherCodeSection::where('teacher_id',$teacher_id)->orderBy('id','desc');
            
            
            return Datatables::of($data)

                ->addIndexColumn()


                ->addColumn('course_id', function ($data) {
                  $course = Course::where('id',$data->course_id)->first();
                  if($data->course_id == 0){
                    return $data->name_course_section;
                  }
                  return $course->name ?? " الدورة محذوفة";
                    
                })


                ->addColumn('number', function ($data) {
                    return '<a href="'.route('all_code',[$data->id,$data->course_id,$data->teacher_id]).'">'. $data->number.'</a>';
                    
                })


                ->addColumn('code_used_count', function ($data) {
                    if($data->course_id == 0){
                        $teacher_code = TeacherCode::Where('section_code',$data->id)->where('user_id','!=',0)->count();
                        return '<a href="'.route('code_used',[$data->id,$data->course_id,$data->teacher_id]).'">'. $teacher_code.'</a>';

                    }else{

                        return '<a href="'.route('code_used',[$data->id,$data->course_id,$data->teacher_id]).'">'. $data->code_used_count.'</a>';
                    }
                    
                })

                ->addColumn('export_code', function ($data) {
                    return '<a href="'.route('export',$data->id).'">تصدير</a>';
                    
                })




                ->addColumn('created_at', function ($data) {
                   return $data->created_at->format('d/m/Y');
                })

            

                ->rawColumns(['image','number','code_used_count','export_code'])

                ->make(true);
        }
    }


    public function all_code($id,$course_id,$teacher_id){

        return view('all_code.index',compact('id','course_id','teacher_id'));
       
     
    }

    public function get_all_all_code(Request $request,$id,$course_id,$teacher_id)
    {
        if ($request->ajax()) {
           
            $data = TeacherCode::where('section_code',$id)->where('course_id',$course_id)->where('teacher_id',$teacher_id)->orderBy('id','desc');
            
            
            return Datatables::of($data)

                ->addIndexColumn()


            

                ->rawColumns(['image'])

                ->make(true);
        }
    }


    public function code_used($id,$course_id,$teacher_id){

        return view('code_used.index',compact('id','course_id','teacher_id'));
       
     
    }

    public function get_all_code_used(Request $request,$id,$course_id,$teacher_id)
    {
        if ($request->ajax()) {
           
            $data = TeacherCode::where('section_code',$id)->where('course_id',$course_id)->where('teacher_id',$teacher_id)->where('user_id','!=',0)->orderBy('id','desc');
            
            
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                  $user = VerifiedData::where('user_id',$data->user_id)->where('status',1)->orderBy('id','desc')->first();
                  if($user){
                    return $user->full_name ?? "-";
                  }else{
                    return '-';
                  }
                 })
 
             
            

                ->rawColumns(['image'])

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
