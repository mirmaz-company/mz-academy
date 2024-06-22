<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Wallet;
use App\Models\Teacher;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\free_studentsSalePoints;

class FreeStudentController extends Controller
{
    public function free_students(){

        // $user_courses = UserCourse::all();

        // foreach($user_courses as $user_cou){

        //     $wallet = Wallet::where('user_id',$user_cou->user_id)->where('course_id',$user_cou->course_id)->first();

        //     if($wallet){

        //         $user_cou->is_free = 0;

        //     }else{

        //         $user_cou->is_free = 1;

        //     }

        //     $user_cou->save();

        // }



        return view('free_students.index');
    }

    public function get_all_free_students(Request $request)
    {
        if ($request->ajax()) {
            $course = Course::Where('type','paid_public')->pluck('id');
            $data = UserCourse::where('is_free',1)->whereIn('course_id',$course)->whereNotIn('user_id',[2])->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    $name = User::where('id',$data->user_id)->first();
                    if($name){
                        return $name->name;
                    }else{
                        return '-';
                    }
                })
                ->addColumn('course', function ($data) {
                        $course = Course::where('id',$data->course_id)->first();
                        if($course){
                            return $course->name;
                        }else{
                            return '-';
                        }
                })

                ->addColumn('admin', function ($data) {
                        $ad = Admin::where('id',$data->admin)->first();
                        if($ad){
                            return $ad->name;
                        }else{
                            return '-';
                        }
                })

                ->addColumn('teacher', function ($data) {
                        $course = Course::where('id',$data->course_id)->first();
                        if($course){
                            $ad = Teacher::where('id',$course->teacher_id)->first();
                            if($ad){
                                return $ad->name;
                            }else{
                                return '-';
                            }
                        }else{
                            return '-';
                        }
                      
                })


                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_free_students(Request $request){

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


    public function update_free_students(Request $request){


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

    public function destroy_free_students(Request $request){

        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
