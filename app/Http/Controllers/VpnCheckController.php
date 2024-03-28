<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\VpnCheck;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VpnCheckController extends Controller
{
    public function vpn_check(){

        return view('vpn_check.index');
    }

    public function get_all_vpn_check(Request $request)
    {
        if ($request->ajax()) {
            $data = VpnCheck::where('is_vpn',"true")->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('vpn_check.btn.action', compact('data'));
                })



                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_vpn_check(Request $request){

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


    public function update_vpn_check(Request $request){


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

    public function destroy_vpn_check(Request $request){

        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
