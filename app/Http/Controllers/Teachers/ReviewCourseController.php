<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\User;
use App\Models\ReviewCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ReviewCourseController extends Controller
{
    public function review_courses(){
     
        return view('teachers.review_courses.index');
    }

    public function get_all_review_courses(Request $request)
    {
        if ($request->ajax()) {
            $data = ReviewCourse::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('user_id', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    return $user->name ?? "-";
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_review_courses(Request $request){
       
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
