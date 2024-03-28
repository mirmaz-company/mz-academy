<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\StudentAreSaying;
use Yajra\DataTables\DataTables;

class StudentAreSayingController extends Controller
{
    public function student_are_saying(){

        $stu =  StudentAreSaying::where('read_at',NULL)->get();
        foreach($stu as $st){
            $st->read_at = now();
            $st->save();
        }
     
        return view('student_are_saying.index');
    }

    public function get_all_student_are_saying(Request $request)
    {
        if ($request->ajax()) {
            $data = StudentAreSaying::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('user_id', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    return $user->name ?? "-";
                })
                ->addColumn('mobile', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    return $user->mobile ?? "-";
                })


                ->addColumn('action', function ($data) {
                    return view('student_are_saying.btn.action', compact('data'));
                })
                ->addColumn('action2', function ($data) {
                    return view('student_are_saying.btn.action2', compact('data'));
                })
                ->addColumn('action3', function ($data) {
                    return view('student_are_saying.btn.action3', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function change_status_student_are_saying_forms(Request $request){
        $stud = StudentAreSaying::where('id',$request->id)->first();
        if($stud){
            if($stud->is_veiw_form == 1){
                $stud->is_veiw_form = 0;
            }else{
                $stud->is_veiw_form = 1;  
            }
            $stud->save();
       
        }

        return response()->json([
            'status' => true,
            'msg' => 'تمت التغيير بنجاح',
        ]); 
    }


    public function change_status_student_are_saying(Request $request){
        $student = StudentAreSaying::where('id',$request->id)->first();
        

        if($student->is_veiw == 0){
            $student ->is_veiw = 1;
            $student ->save();
        }else{
         
            $student ->is_veiw = 0;
            $student ->save();
        }

        return response()->json([
            'status' => true,
            'msg' => 'تمت التغيير بنجاح',
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


    public function update_student_are_saying(Request $request){


        $request->validate([
            'stars'              => 'required',        
        ]);


        $stars = StudentAreSaying::findorFail($request->id);

   
        $stars->rate            = $request->stars;

        $stars->save();

        if ($stars) {
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
