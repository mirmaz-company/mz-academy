<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\CitiesSalePoints;
use Yajra\DataTables\DataTables;

class CityController extends Controller
{
    public function cities(){

        return view('cities.index');
    }

    public function get_all_cities(Request $request)
    {
        if ($request->ajax()) {
            $data = City::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('cities.btn.action', compact('data'));
                })

                ->addColumn('sale_points', function ($data) {
                    $codes = CitiesSalePoints::where('city_id',$data->id)->count();
                   
                    return '<a href="'.route('sale_points',$data->id).'">'. $codes.'</a>';
                 
                })



                ->rawColumns(['image','sale_points'])

                ->make(true);
        }
    }

    public function store_cities(Request $request){

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


    public function update_cities(Request $request){


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

    public function destroy_cities(Request $request){

        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
