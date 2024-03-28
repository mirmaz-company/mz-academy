<?php

namespace App\Http\Controllers\DashboardTwo;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Wallet;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\UserCourse;
use App\Exports\UserExport;
use Illuminate\Http\Request;
use App\Models\Teachers\Course;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\NotificationTeacher;
use App\Models\TransactionsTeacher;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class WalletTeacherController extends Controller
{
    public function wallet_teacher($teacher_id){
        if (session()->has('password_notification')) {
            
             return view('dashboard_two.wallet_teacher.index',compact('teacher_id'));
         } else {
                
             return view('sliders.index');
        }
    }

   


    public function get_all_wallet_teacher(Request $request,$teacher_id)
    {
        if ($request->ajax()) {
  
            $data = TransactionsTeacher::where('teacher_id',$teacher_id)->orderBy('id','desc');

            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                
                    return view('dashboard_two.wallet_teacher.btn.action', compact('data'));
                })

                ->addColumn('status', function ($data) {
                
                  if($data->status == 1){
                    return '<span class="badge badge-success"> ايداع</span>';
                  }else{
                    return '<span class="badge badge-danger">سحب</span>';
                  }
                })

                ->rawColumns(['action','status'])

                ->make(true);
        }
    }


    public function store_deposet(Request $request)
    {
        $request->validate([
            'money'              => 'required',
        ]);

        try {
        
            $new_tran = new TransactionsTeacher();
            $new_tran->teacher_id = $request->teacher_id;
            $new_tran->title = $request->title;
            $new_tran->money = $request->money;
            $new_tran->status = 1;
            $new_tran->notes = $request->notes;
            $new_tran->save();

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
            'msg' => 'تمت الاضافة بنجاح',
        ]);


    }


    public function store_withdraw(Request $request)
    {
        $request->validate([
            'money'              => 'required',
        ]);

        try {
        
            $new_tran = new TransactionsTeacher();
            $new_tran->teacher_id = $request->teacher_id;
            $new_tran->title = $request->title;
            $new_tran->money = $request->money;
            $new_tran->status = 2;
            $new_tran->notes = $request->notes;
            $new_tran->save();

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
            'msg' => 'تمت الاضافة بنجاح',
        ]);


    }


    public function update_ratio(Request $request){
        $teacher = Teacher::where('id',$request->id)->first();
        if($teacher){
            $teacher->ratio = $request->ratio;
            $teacher->save();

            return response()->json([
                'status' => true,
                'msg' => 'تم التعديل بنجاح',
            ]);
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'فشل التعديل برجاء المحاوله مجددا',
            ]);
        }
    }


    public function export_excel($course_id){
      
        $coruse = Course::where('id',$course_id)->first();

      
        $teacher = Teacher::where('id',$coruse->teacher_id)->first();
        $name = $teacher->name . ' - ' . $coruse->name ;

        return Excel::download(new UserExport($coruse->id), $name.'.xlsx'); // استبدل YourExport بصيغة التصدير الخاصة بك
    }

    public function accept_this_course(Request $request){
        $course = Course::where('id',$request->id)->first();
        $course->status = 2;
        $course->save();


        $not = new NotificationTeacher();
        $not->title = "تم قبول الدورة" .$course ->name;
        $not->teacher_id = $request->teacher_id;
        $not->save();

        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
        ]);
    }


    public function decline_this_course(Request $request){
        $course = Course::where('id',$request->id)->first();
        $course->status = 3;
        $course->save();

        $not = new NotificationTeacher();
        $not->title = "تم رفض الدورة".$course ->name;
        $not->description = $request->decline;
        $not->teacher_id = $request->teacher_id;
        $not->save();

        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
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
