<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use App\Models\CitiesSalePoints;
use Yajra\DataTables\DataTables;

class SalePointsController extends Controller
{
    public function sale_points($id){

        return view('sale_points.index',compact('id'));
    }

    public function get_all_sale_points(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = CitiesSalePoints::where('city_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('sale_points.btn.action', compact('data'));
                })



                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_sale_points(Request $request){

        $request->validate([
            'name'              => 'required',
       

        ]);



        $city = new CitiesSalePoints();
        $city ->city_id                  = $request->city_id;
        $city ->name                     = $request->name;
        $city ->descriptions             = $request->descriptions;


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


    public function update_sale_points(Request $request){


        $request->validate([
            'name'              => 'required',
        ]);


        $city = CitiesSalePoints::findorFail($request->id);


        $city ->city_id                  = $request->city_id;
        $city ->name                     = $request->name;
        $city ->descriptions             = $request->descriptions;

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

    public function destroy_sale_points(Request $request){

        $city = CitiesSalePoints::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
