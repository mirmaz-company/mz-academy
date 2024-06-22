<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\UserFollowTeacher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FollwersController extends Controller
{
    public function follwers(){
     
        return view('teachers.follwers.index');
    }

    public function get_all_follwers(Request $request)
    {
        if ($request->ajax()) {
            $data = UserFollowTeacher::where('teacher_id',Auth::guard('teachers')->user()->id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    return $user->name ?? "-";
                })

                ->addColumn('image', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    if($user){

                        return  '<img src="'.$user->image.'" alt="" style="width:30%">';
                    }else{
                        return "-";
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
