<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\WalletCode;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class RechargeController extends Controller
{
    public function recharge_codes($id){
     
        return view('recharge_codes.index',compact('id'));
    }

    public function get_all_recharge_codes(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = WalletCode::where('section_course_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('recharge_codes.btn.action', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function recharge_codes_used($id){
     
        return view('recharge_codes_used.index',compact('id'));
    }

    public function get_all_recharge_codes_used(Request $request,$id)
    {
        if ($request->ajax()) {

            $data = WalletCode::where('section_course_id',$id)->where('user_id','!=',null)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    if($user){
                        return $user->name ?? "-";
                    }else{
                        return '-';
                    }
                })

                ->addColumn('action', function ($data) {
                    return view('recharge_codes_used.btn.action', compact('data'));
                })


                ->rawColumns(['image'])

                ->make(true);
        }
    }



    public function store_recharge_codes(Request $request){
       
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


    public function update_recharge_codes(Request $request){


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

    public function destroy_recharge_codes(Request $request){
           
        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
