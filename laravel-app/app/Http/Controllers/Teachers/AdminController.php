<?php

namespace App\Http\Controllers\Teachers;

use App\Models\Admin;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function admins()
    {
        return view('teachers.admins.index');
    }



    public function get_all_admins(Request $request){
        if(Auth::guard('teachers')->user()->parent == 0){
            $data = Teacher::where('parent',Auth::guard('teachers')->user()->id)->orderBy('id','desc');
        }else{
            $data = Teacher::where('parent',Auth::guard('teachers')->user()->parent)->orWhere('parent',Auth::guard('teachers')->user()->id)->orderBy('id','desc');
        }
        // $data = Teacher::all();
      
        return Datatables::of($data)

            ->addIndexColumn()

            ->editColumn('status', function ($data) {
           

              $e = '<p style="color:green">مفعل</p>';
              $d = '<p style="color:red">غير مفعل</p>';

                return $data->status == "0" ? $d: $e; 
            })




            ->addColumn('action', function ($data) {
                return view('teachers.admins.btn.action', compact('data'));
            })
            ->editColumn('roles_name', function ($data) {

                $role_name_removedNumbers = preg_replace('/\d+/', '', $data->roles_name);
                return $role_name_removedNumbers;
            })

            ->rawColumns(['status'])

            ->make(true);
    }



// اضافة مساعدين للمعلم
    public function store_admins(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required',
            'roles_name' => 'required'
            ]);
            
            $input = $request->all();

        
            
            $input['password'] = Hash::make($input['password']);
          
            $input['is_complete'] = 1;
            $input['parent'] =Auth::guard('teachers')->user()->id;
            
            $teacher = Teacher::create($input);
            // $teacher->assignRole($request->input('roles_name'));

            $teacher->assignRole($request->input('roles_name'));


            // المعلم
            $teacher_main = Teacher::where('id', $teacher->parent)->first();

            // المساعد
            $teacher = Teacher::where('id', $teacher->id)->first();
            $teacher->access_key = $teacher_main->access_key;
            $teacher->library_id = $teacher_main->library_id;
            $teacher->pull_zone = $teacher_main->pull_zone;
            $teacher->save();
           

            if ($teacher) {
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


    public function update_admins(Request $request)
    {


        $id = $request->id;


        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:teachers,email,'.$id,
            'password' => 'required',
            'roles_name' => 'required',
            'status' => 'required'
        ]);

        $input = $request->all();

        $admin = Teacher::where('id',$id)->first();


        if($admin->parent == Auth::guard('teachers')->user()->id || $admin->parent == Auth::guard('teachers')->user()->parent){

            if($request->password == $admin->password){
                $input['password'] = $admin->password;
            }else{
                $input['password'] = bcrypt($request->password);
            }
    
            $admin->update($input);
            DB::table('model_has_roles')->where('model_id',$id)->where("model_type","App\Models\Teacher")->delete();
            $admin->assignRole($request->input('roles_name'));
    
    
            if ($admin) {
                    return response()->json([
                        'status' => true,
                        'msg' => 'تمت التعديل بنجاح',
                    ]);
            } else {
                    return response()->json([
                        'status' => false,
                        'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
                    ]);
            }
          
            
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'غير مصرح بك ',
            ]);
        }
        

    }


     public function destroy_admins(Request $request)
    {

        DB::table('model_has_roles')->where('model_id',$request->id)->where("model_type","App\Models\Teacher")->delete();
    
        $user2 = Teacher::find($request->id);

        if($user2->parent == Auth::guard('teachers')->user()->id || $user2->parent == Auth::guard('teachers')->user()->parent){
              $user2->delete();
        }else{
            return response()->json([
                'status' => false,
                'msg' => 'غير مصرح بك ',
            ]);
        }
        
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
    }


}
