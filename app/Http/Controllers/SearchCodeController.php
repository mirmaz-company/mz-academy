<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\TeacherCode;
use Illuminate\Http\Request;
use App\Models\CitiesSalePoints;
use App\Models\Wallet;
use App\Models\WalletCode;
use Yajra\DataTables\DataTables;

class SearchCodeController extends Controller
{
    public function search_codes(){

        return view('search_codes.index');
    }

    public function get_all_search_codes(Request $request,$code = null)
    {
        if ($request->ajax()) {
            $data = TeacherCode::where('code',$code)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('search_codes.btn.action', compact('data'));
                })
                ->addColumn('user_id', function ($data) {
                    if($data->user_id == 0){
                        return 'الكود غير مستخدم ';
                    }else{
                        $user = User::where('id',$data->user_id)->first();
                        if($user){
                            return '<a href="'.route('profile_user',$user->id).'">'.$user->name .' (ID:'. $user->id .') '.'</a>';
                        }else{
                            return "";
                        }
                    }
                })
                ->addColumn('course_id', function ($data) {
                   $course = Course::where('id',$data->course_id)->first();
                   if($course){
                        return $course->name;
                   }else{
                        if($data->backage_private == 'private_package'){
                            return "باكج خاص يحتوي على عدة دورات ";
                        }else{
                            return "";
                        }
                    }
                   
                })
                ->addColumn('teacher_id', function ($data) {
                    $tea = Teacher::where('id',$data->teacher_id)->first();
                    if($tea){
                         return $tea->name;
                    }else{
                         return "-";

                    }
                })




                ->rawColumns(['image','sale_points','user_id'])

                ->make(true);
        }
    }


    public function get_all_search_codes2(Request $request,$code = null)
    {
        if ($request->ajax()) {
            $data = WalletCode::where('code',$code)->orWhere('serial',$code)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('search_codes.btn.action', compact('data'));
                })
                ->addColumn('user_id', function ($data) {
                    if($data->user_id == 0 || $data->user_id == null){
                        return 'الكود غير مستخدم ';
                    }else{
                        $user = User::where('id',$data->user_id)->first();
                        if($user){
                            return '<a href="'.route('profile_user',$user->id).'">'.$user->name .' (ID:'. $user->id .') '.'</a>';
                        }else{
                            return "";
                        }
                    }
                })
                ->addColumn('course_id', function ($data) {
                   $course = Course::where('id',$data->course_id)->first();
                   if($course){
                        return $course->name;
                   }else{
                        return "";
                    }
                   
                })
                ->addColumn('teacher_id', function ($data) {
                    $course = Course::where('id',$data->course_id)->first();
                    if($course){
                        $tea = Teacher::where('id',$course->teacher_id)->first();
                        if($tea){
                             return $tea->name;
                        }else{
                             return "-";
                        }
                    }else{
                        return "-";
                    }

                 
                })




                ->rawColumns(['image','sale_points','user_id'])

                ->make(true);
        }
    }

    public function store_search_codes(Request $request){

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


    public function update_search_codes(Request $request){


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

    public function destroy_search_codes(Request $request){

        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
