<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Admin;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class DepoWithdController extends Controller
{
    public function dep_withd(){

        return view('dep_withd.index');
    }

    public function get_all_dep_withd(Request $request)
    {
        if ($request->ajax()) {
            $data = Wallet::where('type', 'Like', '%ن قبل المنص%')->whereNotIn('user_id',[2])->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('admin', function ($data) {

                    $admin = Admin::where('id',$data->admin)->first();
                    if($admin){
                        return $admin->name ?? "-";
                    }else{
                        return '-';
                    }

                })

                ->addColumn('name', function ($data) {

                    $user_id = User::where('id',$data->user_id)->first();
                    if($user_id){
                        return $user_id->name ?? "-";
                    }else{
                        return '-';
                    }

                })

                ->addColumn('type', function ($data) {
                    if($data->type_recharge == 'reachrge'){
                        return '<span class="badge badge-success">اضافة رصيد</span>';
                    }else{
                        return '<span class="badge badge-danger">سحب رصيد</span>';
                    }

                })
                ->addColumn('created_at', function ($data) {
                   return $data->created_at->format('d-m-Y');

                })




                ->rawColumns(['image','admin','name','type'])

                ->make(true);
        }
    }

    public function store_dep_withd(Request $request){

        $request->validate([
            'city'              => 'required',
            'price'              => 'required|numeric',

        ]);



        $city = new City();
        $city ->city                  = $request->city;
        $city ->price                  = $request->price;


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


    public function update_dep_withd(Request $request){


        $request->validate([
            'city'              => 'required',
            'price'              => 'required|numeric',
        ]);


        $city = City::findorFail($request->id);


        $city->city            = $request->city;
        $city->price            = $request->price;

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

    public function destroy_dep_withd(Request $request){

        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
