<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\UserCourse;
use App\Models\WalletCode;
use App\Models\VerifiedData;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class AddStudentCourseController extends Controller
{
    public function add_student_to_course(){

        return view('add_student_to_course.index');
    }

    public function get_all_search_courses(Request $request,$user_id = null)
    {
        if ($request->ajax()) {
            $data = UserCourse::where('user_id',$user_id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('add_student_to_course.btn.action', compact('data'));
                })

                ->addColumn('notes', function ($data) {
                   return '<span style="color:green">'.$data->notes.'</span>';
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
                ->editColumn('created_at', function ($data) {

                    if($data->created_at != null){
                        return date('Y-m-d', strtotime($data->created_at));
                    }else{
                        return "-";
                    }
              
                })

                ->addColumn('action', function ($data) use ($user_id) {
                    $course = Course::where('id',$data->course_id)->first();
                    if($course){
                        return view('courses.btn.action2', compact('data','course','user_id'));
                    }else{
                        return '';
                    }
                })




                ->rawColumns(['image','sale_points','user_id','notes'])

                ->make(true);
        }
    }


    public function get_user_info(Request $request){
        $user = User::where('id',$request->user_id)->where('type',0)->first();
        if($user){
            $user_verifed_data = VerifiedData::where('user_id',$request->user_id)->where('status',1)->orderBy('id','desc')->first();
            $admin = Admin::where('id',$user->person_who_approved)->first();
            if($admin){
                $admin_card = $admin->name;
            }else{
                $admin_card = null;
            }
            if($user_verifed_data){
                $full_name = $user_verifed_data->full_name;
            }else{
                $full_name = "الحساب غير موثق";
            }
            return response()->json([
                'status' => true,
                'user' => $user,
                'full_name' => $full_name,
                'admin_card' => $admin_card,
            ]);
        }else{
            return response()->json([
                'status' => true,
                'user' => null,
                'full_name' => null,
                'admin_card' => null,
            ]);
        }
    }


    public function add_to_course_route(Request $request){

        foreach ($request->course_id  as $course){

            $user_course = UserCourse::where('user_id',$request->user_id)->where('course_id',$course)->first();
            if(!$user_course){

                $user = User::where('id',$request->user_id)->where('type',0)->first();
                if($user){
                    $user_course = new UserCourse();
                    $user_course ->user_id                  = $request->user_id;
                    $user_course ->course_id                = $course;
                    $user_course ->admin                    = Auth::guard('web')->user()->id;
                    if($request->notes == null){
                        $user_course ->notes                    = 'تم اضافته من الادارة';

                    }else{
                        $user_course ->notes                    = $request->notes;

                    }
                    $user_course ->save();
    
    
                    $course = Course::where('id',$course)->first();
                    if($course){
                        $course->subscriptions = $course->subscriptions + 1;
                        $course->save();
                    }
    
                    $teacher = Teacher::where('id',$course->teacher_id)->first();
                    if($teacher){
                        $teacher->total_subscriptions = $teacher->total_subscriptions + 1;
                        $teacher->save();
                    }
                }

            }

          
        }

        if ($user_course) {
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


    public function get_all_add_student_to_course2(Request $request,$code = null)
    {
        if ($request->ajax()) {
            $data = WalletCode::where('code',$code)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('add_student_to_course.btn.action', compact('data'));
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

    public function store_add_student_to_course(Request $request){

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


    public function update_add_student_to_course(Request $request){


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

    public function destroy_add_student_to_course(Request $request){

        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
