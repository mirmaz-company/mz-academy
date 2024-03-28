<?php

namespace App\Http\Controllers\Teachers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('permissions.index', compact('roles'));
    }

    public function get_all_role(Request $request){
        if ($request->ajax()) {
            $data = Role::where('teacher_id',Auth::guard('teachers')->user()->id)->orWhere('teacher_id',Auth::guard('teachers')->user()->parent)->where('guard_name','teachers')->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('teachers.roles.btn.action', compact('data'));
                })
                
                ->editColumn('name', function ($data) {
                    $removedNumbers = preg_replace('/\d+/', '', $data->name);
                    return $removedNumbers;
                })
           

                ->make(true);
        }
    }
}
