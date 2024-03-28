<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function admins()
    {
        return view('admins.index');
    }



    public function get_all_admins(Request $request){
        $data = Admin::orderBy('id','desc');
        return Datatables::of($data)

            ->addIndexColumn()

            ->editColumn('status', function ($data) {
           

              $e = '<p style="color:green">مفعل</p>';
              $d = '<p style="color:red">غير مفعل</p>';

                return $data->status == "0" ? $d: $e; 
            })




            ->addColumn('action', function ($data) {
                return view('admins.btn.action', compact('data'));
            })

            ->rawColumns(['status'])

            ->make(true);
    }




    public function store_admins(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required',
            'roles_name' => 'required'
            ]);
            
            $input = $request->all();
            
            
            $input['password'] = Hash::make($input['password']);
            
            $user = Admin::create($input);
            $user->assignRole($request->input('roles_name'));
           

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


    public function update_admins(Request $request)
    {


        $id = $request->id;


        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:admins,email,'.$id,
            'password' => 'required',
            'roles_name' => 'required',
            'status' => 'required'
        ]);

        $input = $request->all();

        $admin = Admin::where('id',$id)->first();
        
        if($request->password == $admin->password){
            $input['password'] = $admin->password;
        }else{
            $input['password'] = bcrypt($request->password);
        }

        $admin->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->where("model_type","App\Models\Admin")->delete();
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
    }


     public function destroy_admins(Request $request)
    {
    
        $user2 = Admin::find($request->id);
        $user2->delete();
        
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
    }


}
