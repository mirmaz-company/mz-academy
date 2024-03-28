<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SupportController extends Controller
{
    public function support(){
     
        return view('support.index');
    }

    public function get_all_support(Request $request)
    {
        if ($request->ajax()) {
            $data = Support::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('user_id', function ($data) {

                  $btn = '<a href="'.route("profile_user",$data->user_id).'">'.\App\Models\User::where('id',$data->user_id)->pluck('name')->first().'</a>';
                  return $btn;

                   
                })
            

                ->rawColumns(['user_id'])

                ->make(true);
        }
    }
}
