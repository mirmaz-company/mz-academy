<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletCode;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LastUsedCodeController extends Controller
{
    public function last_used_codes(){

        return view('last_used_codes.index');
    }

    public function get_all_last_used_codes(Request $request)
    {
        if ($request->ajax()) {
            $data = WalletCode::whereNotIn('user_id',[0])->orderBy('updated_at','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    if($user){
                        $name =  $user->name;
                    }else{
                        $name = '-';
                    }
                    
                   return '<a href="'.route('profile_user',$data->user_id).'">'.$name.'</a>';
                })


                ->addColumn('created_at', function ($data) {
              
                    return $data->updated_at->format('Y-m-d');
             

                })

              
                ->rawColumns(['image','name'])

                ->make(true);
        }
    }

    public function store_last_used_codes(Request $request){

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


    public function update_last_used_codes(Request $request){


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

    public function destroy_last_used_codes(Request $request){

        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
