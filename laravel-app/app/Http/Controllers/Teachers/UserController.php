<?php

namespace App\Http\Controllers\Teachers;

use App\Models\Ship;
use App\Models\User;
use App\Models\Admin;
use App\Models\Order;
use App\Models\Course;
use App\Models\Estate;
use App\Models\Lesson;
use App\Models\Setting;
use App\Models\Support;
use App\Models\Teacher;
use App\Models\Category;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function users($id= null){

        // عشان اول ما يفتح صفحة الطلاب المشتركين اسجل قديش في عندو مشتركين عشان نتاكد انو صح.. وكمان في لوحة الادمن لما يفتح على المعلمين كمان بتاكد وبخزن عدد المشتركين من اول وجديد
        $teacher_courese = Course::where('teacher_id',Auth::guard('teachers')->user()->id)->pluck('id');

        // عشان ما يحسب شركة مرماز من ضمن العدد
        $user = User::where('mobile','009647703391199')->first();
        $user_course_count = UserCourse::whereIn('course_id',$teacher_courese)->where('user_id','!=',$user->id)->count();

        $teacher = Teacher::where('id',Auth::guard('teachers')->user()->id)->first();

        if($teacher){
            $teacher->total_subscriptions =  $user_course_count;
            $teacher->save();
        }

        if($id == null){
            return view('teachers.users.main');
        }else{

            $id = Crypt::decrypt($id);
           
            return view('teachers.users.main',compact('id'));
        }
       
    }

    public function get_all_users(Request $request,$id=NULL)
    {
 
        if ($request->ajax()) {
            $courses_id = Course::where('teacher_id',Auth::guard('teachers')->user()->id)->orWhere('teacher_id',Auth::guard('teachers')->user()->parent)->pluck('id');
    
            if($id == NULL){
                if($courses_id){
                    $users_id = UserCourse::whereIn('course_id',$courses_id)->pluck('user_id');
                }else{
                    $users_id = User::where('id','23445345345345')->where('type',0)->orderBy('id','desc');
                }
            }else{
                $users_id = UserCourse::where('course_id',$id)->pluck('user_id');
            }
         

            // $data = User::whereIn('id',$users_id)->where('mobile','!=','009647703391199')->where('type',0)->orderBy('id','desc');

      
            // Server-side processing
            $data = User::whereIn('users.id', $users_id)
            ->whereNotIn('users.mobile', ['009647703391199', '00970123123123'])
            ->where('users.type', 0)
            ->join('verified_data', function ($join) {
                $join->on('users.id', '=', 'verified_data.user_id')
                    ->where('verified_data.status', 1);
            })
            ->select('users.*', 'verified_data.full_name as full_name')
            ->orderBy('id','desc');


            return Datatables::of($data)

                ->addIndexColumn()

                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && !empty($request->search['value'])) {
                        $query->where(function ($query) use ($request) {
                            $query->where('users.id', 'like', "%{$request->search['value']}%")
                                  ->orWhere('verified_data.full_name', 'like', "%{$request->search['value']}%")
                                  ->orWhere('users.mobile', 'like', "%{$request->search['value']}%");
                        });
                    }
                })
                

                ->editColumn('full_name', function ($data) {
                    $id= Crypt::encrypt($data->id);
                    $btn = '<a href="'.route("teachers.profile_user",$id).'">'.$data->full_name.'</a>';
                    return $btn;
                })
                

                ->addColumn('status', function ($data) use($id) {
                    $user_course = UserCourse::where('user_id',$data->id)->where('course_id',$id)->first();
                    if($user_course){
                        return view('teachers.users.btn.status', ['id' => $data->id, 'course_id' => $id ,'status' =>$user_course->status]);
                    }
                })
    
                ->addColumn('created_at', function ($data) {
                    $date = date('d-m-Y / G:i', strtotime($data->created_at));

                    return $date;
                })

                ->addColumn('action', function ($data) {
                    return view('teachers.users.btn.action', compact('data'));
                })

            

                ->rawColumns(['full_name'])

                ->make(true);
        }
    }


    public function update_status_laravel(Request $request){
        $lesson = Lesson::where('id',$request->lesson_id)->first();

        $lessons_the_same = Lesson::where('the_same_lessons',$lesson->the_same_lessons)->get();

        if($lessons_the_same->count() > 0){
           
            foreach( $lessons_the_same as $lesson_the_same){
                $lesson_the_same->status_laravel = 1;
                $lesson_the_same->created_at = $lesson->freshTimestamp(); // Set created_at column to the current timestamp
                $lesson_the_same->updated_at = $lesson->created_at; // Set updated_at column equal to created_at
                $lesson_the_same->save();
            }
            
        }

        return response()->json([
            'status' => true,
            'msg' => 'تم التغيير  بنجاح',
        ]);
       
    }

    
    public function change_status(Request $request){

        $user = UserCourse::where('user_id',$request->id)->where('course_id',$request->course_id)->first();
      



        if($user->status == 0){

            $user->status = 1;
            $user->save();
            
      
        }else{

            $user->status = 0;
            $user->save();

        }

        return response()->json([
            'status' => true,
            'msg' => 'تم التغيير  بنجاح',
        ]);



    }

    public function main_statistic(){

    
        
        $top_product_seller = DB::table('order_product')->select('product_id')->groupBy('product_id')->orderByRaw('COUNT(*) DESC')->limit(5) ->get();

    

        $order_today = Order::whereDate('created_at', Carbon::today())->count();
        $order_price= Order::sum('total');
        

        $five_price = ($order_price * 5) / 100;

        $order_price_today= Order::whereDate('created_at', Carbon::today())->sum('total');

        $five_price_today = ($order_price_today * 5) / 100;


        $order_price_month= Order::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('total');

        $five_price_month = ($order_price_month * 5) / 100;



        $order_month = Order::whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();


        return view('users.main_statistic',compact('order_today','order_month','order_price','order_price_today','order_price_month','five_price_today','five_price','five_price_month','top_product_seller'));
    }



    public function profile_user($id){


        $id = Crypt::decrypt($id);
        $user =     User::findOrFail($id);

        $user_proxy = \App\Models\Proxy::where('user_id',$id)->first();
        if($user_proxy){
              $user_proxy->read_at = 0;
         $user_proxy->save();
        }
        
        return view('teachers.users.profile',compact('user'));
    }





    public function add_user_form(Request $request){
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|email|unique:users,email',   
            'mobile'            => 'required|unique:users,mobile',   
            'password'          => 'required',   
            'address'           => 'required',   
            'type_account'      => 'required',   
            'type'              => 'required',   
            'phone'             => 'required',   
        ]);

     

        $user = new User();
        $user ->name                   = $request->name;
        $user ->email                  = $request->email;
        $user ->mobile                 = $request->mobile;
        $user ->phone                  = $request->phone;
        $user ->type                   = $request->type;
        $user ->type_account           = $request->type_account;
        $user ->address                = $request->address;
     
        $user -> password              = bcrypt($request->password);

 
        $user -> save();

        if ($user) {
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

    public function update_user(Request $request){
        $id2 = $request->id;


        $request->validate([
            'name'              => 'required',
            // 'email'             => 'required|email|unique:users,email,'.$id2 ,   
            'mobile'            => 'required|unique:users,mobile,'.$id2 ,   
        ]);


        $user = User::findorFail($request->id);

   
        $user->name            = $request->name;

        $user->mobile          = $request->mobile;
 
      
   
        if( $request->password== $user->password){
            
            $user->save();

            if ($user) {
                return response()->json([
                    'status' => true,
                    'msg' => 'Edit Successfully',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'msg' => 'فشل التعديل برجاء المحاوله مجددا',
                ]);
            }
        }


        $user->password    = bcrypt($request->password);
 
        $user->save();

        if ($user) {
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

    public function destroy_user(Request $request){
           
        $user = User::find($request->id);
        $user->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }

    public function myprofile(){
        return view('users.settings');
    }

    public function myprofile_update(Request $request){
     

        $id2 = $request->id;

        $request->validate([

            'email' => 'required|email|unique:admins,email,' . $id2,
            'password' => 'required|confirmed|min:6',
        ]);


        $admins = Admin::findorFail($request->id);

        $admins->name        = $request->nameauth;
        $admins->email       = $request->email;

        // عشان اذا عدلت على اي  حقل غير الباسورد ..يضل الباسورد زي ما هو
        if ($request->password == $admins->password) {
            $admins->password = $admins->password;
        } else {
            $admins->password    = bcrypt($request->password);
        }

        $admins->save();


        if ($admins) {
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
}
