<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Course;
use App\Models\Wallet;
use App\Models\Teacher;
use App\Models\CourseTwo;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    public function courses($id){
     
        return view('courses.index',compact('id'));
    }

    public function get_all_courses(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = CourseTwo::where('teacher_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    return view('courses.btn.action4', compact('data'));
                })

              
                ->rawColumns(['image'])

                ->make(true);
        }
    }


    public function update_course_detailes(Request $request){

        $request->validate([
            'price'              => 'required',
            'discount'              => 'required',
       
        ]);
         

        $course = Course::where('id',$request->id)->first();

        if($course){
            $course->price = $request->price;
            $course->discount = $request->discount;
            $course->save();
        }

        if ($course) {
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
    public function get_all_courses_profile(Request $request,$id)
    {
        if ($request->ajax()) {
            $user_courses = UserCourse::where('user_id',$id)->pluck('course_id');
            $data = CourseTwo::whereIn('id',$user_courses)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()


                ->addColumn('action', function ($data) use ($id) {
                    return view('courses.btn.action', compact('data','id'));
                })
                ->addColumn('teacher_id', function ($data) use ($id) {
                    $teacher =  Teacher::find($data->teacher_id);
                    if($teacher){
                        return $teacher->name;
                    }else{
                        return '-';
                    }
                })


                ->addColumn('price_course', function ($data) {
                  return $data->price - $data->discount;
                })


                ->addColumn('type_course', function ($data) {
                    if($data->type == "paid_public"){
                        return 'مدفوع عام';
                    }elseif ($data->type == "private") {
                        return 'خاص';
                    }else{
                        return $data->type;
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

    public function cancel_course(Request $request){

        DB::beginTransaction();
        try {
       
            $course = CourseTwo::where('id',$request->id)->first();

            if($course){

                if($course->type == "paid_public"){
                    $user = User::where('id',$request->user_id)->first();
                    if($user){
                        $user->my_wallet = $user->my_wallet +  ($course->price - $course->discount);
                        $user->save();    
                    }

             
                    $wallet_transaction_new = new Wallet();
                    $wallet_transaction_new->user_id = $request->user_id;
                    $wallet_transaction_new->course_id = $request->id;
                    $wallet_transaction_new->money  = $course->price - $course->discount;
                    $wallet_transaction_new->type_recharge  = 'cancel';
                    $wallet_transaction_new->type = 'تم الغاء الاشتراك وارجاع المبلغ الى المحفظة';
                    $wallet_transaction_new->save();
                    
        
                }


                if($course->subscriptions > 0){
                    $course->subscriptions = $course->subscriptions - 1;
                    $course->save();  
                }

                $teacher = Teacher::find($course->teacher_id);
                if($teacher){
                    $teacher->total_subscriptions = $teacher->total_subscriptions - 1;
                    $teacher->save();  
                }
                
            }
            
            // اذا كان في تكرار في نفس اللحظة
            $user_coruses = UserCourse::where('course_id',$request->id)->where('user_id',$request->user_id)->get();

            
            foreach($user_coruses as $user_corus){
                $user_corus->forceDelete();    
            }

          
            DB::commit();

        }catch (\Exception $e) {

            DB::rollback();
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'something error' .$e,
                
            ]);

        }

        return response()->json([
            'status' => true,
            'msg' => 'تم الغاء الاشتراك بنجاح',
        ]);

      

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
