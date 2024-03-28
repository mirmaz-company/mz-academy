<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('permissions.index', compact('roles'));
    }

    public function get_all_role(Request $request){
        if ($request->ajax()) {
            $data = Role::where('guard_name','web')->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('roles.btn.action', compact('data'));
                })
           

                ->make(true);
        }
    }
}
