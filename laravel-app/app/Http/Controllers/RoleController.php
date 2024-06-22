<?php

namespace App\Http\Controllers;

use DB;
use Mpdf\Http\Response;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
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
        return view('roles.index',compact('roles'))
        ->with('i', ($request->input('page', 1) - 1) * 5);
    }


    public function create()
    {
        $permissions = \App\Models\Permission::where('parent',0)->where('guard_name','web')->with('childrens')->get();
        return view('roles.create',compact('permissions'));
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);
        $role = Role::create(['name' => $request->input('name')]);
        $role->syncPermissions($request->input('permission'));

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
        return view('roles.show',compact('role','rolePermissions'));
    }


    public function edit($id)
    {
        $id33 = $id;
        $role = Role::find($id);
        $permissions = \App\Models\Permission::where('parent',0)->where('guard_name','web')->with('childrens')->get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return view('roles.edit',compact('role','permissions','rolePermissions','id33'));
    }

    public function downloadBackup()
    {
        // Define your database backup file path and name
        $backupDir = storage_path('app/backup');
        $backupFilePath = $backupDir . '/database.sql';
    
        // Create the backup directory if it doesn't exist
        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }
    
        // Create the backup if it doesn't exist
        if (!file_exists($backupFilePath)) {
            // Backup the database using the mysqldump command or any other method you prefer
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPassword = env('DB_PASSWORD');
            $dbHost = env('DB_HOST');
            $backupCommand = "mysqldump --user={$dbUser} --password={$dbPassword} --host={$dbHost} {$dbName} > \"{$backupFilePath}\" 2>&1";
            exec($backupCommand, $output, $returnVar);
    
            // Log the output and error messages from the mysqldump command
            Log::info('mysqldump output:', $output);
    
            // Check for errors during the execution of the mysqldump command
     // Check for errors during the execution of the mysqldump command

        if ($returnVar !== 0) {
            return response('Error: Failed to create database backup.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        }
    
        // Download the backup file
        return response()->download($backupFilePath)->deleteFileAfterSend(true);
    }
    


    public function update_rolee(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);
        $role = Role::find($request->id_passing);

        
         

        $role->name = $request->input('name');
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
        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        $role = Role::find($id);
        if($role->teacher_id != $teacher_id){
            return response()->json([
                'status' => false,
                'msg' => 'غير مصرح بك ',
            ]);
        }
        DB::table("roles")->where('id',$id)->delete();
        return redirect()->route('roles.index')
        ->with('success','Role deleted successfully');
    }
}