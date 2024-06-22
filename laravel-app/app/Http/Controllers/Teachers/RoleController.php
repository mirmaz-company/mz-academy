<?php

namespace App\Http\Controllers\Teachers;

use DB;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    
    // function __construct()
        //           {
        //             $this->middleware('permission:قائمة المستخدمين', ['only' => ['index']]);
        //             $this->middleware('permission:اضافة صلاحية', ['only' => ['create','store']]);
        //             $this->middleware('permission:تعديل صلاحية', ['only' => ['edit','update']]);
        //             $this->middleware('permission:حذف صلاحية', ['only' => ['destroy']]);
    //      }


    public function index(Request $request)
    {
        $roles = Role::orderBy('id','DESC')->get();
        return view('teachers.roles.index',compact('roles'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $permissions = \App\Models\Permission::where('guard_name','teachers')->where('parent',0)->with('childrens')->get();
        return view('teachers.roles.create',compact('permissions'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role = Role::orderBy('id','desc')->first();

        // لان الاسم يتكرر عند الاساتذة..لازم تمييز

        if(Auth::guard('teachers')->user()->parent == 0){
            $role = Role::create(['name' => $request->input('name')." ".rand(1111111,999999),'teacher_id'=>Auth::guard('teachers')->user()->id]);
            $role->syncPermissions($request->input('permission'));
        }else{
            $role = Role::create(['name' => $request->input('name')." ".rand(1111111,999999),'teacher_id'=>Auth::guard('teachers')->user()->parent]);
            $role->syncPermissions($request->input('permission'));
        }
       

        if ($role) {
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


    public function show($id)
    {
        $role = Role::find($id);
        $rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
        ->where("role_has_permissions.role_id",$id)
        ->get();
        return view('teachers.roles.show',compact('role','rolePermissions'));
    }


    public function edit($id)
    {
        $id33 = $id;
        $role = Role::find($id);

        $role_name_removedNumbers = preg_replace('/\d+/', '', $role->name);
        $permissions = \App\Models\Permission::where('parent',0)->where('guard_name','teachers')->with('childrens')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return view('teachers.roles.edit',compact('role_name_removedNumbers','permissions','rolePermissions','id33'));
    }


    public function update_rolee(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($request->id_passing);
        $role->name = $request->input('name')." ".rand(1111111,999999);
        $role->save();
        $role->syncPermissions($request->input('permission'));

        if ($role) {
            return response()->json([
                'status' => true,
                'msg' => 'تم التعديل بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
    }


    public function destroy($id)
    {
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('teachers.roles.index')
        ->with('success','Role deleted successfully');
    }
}