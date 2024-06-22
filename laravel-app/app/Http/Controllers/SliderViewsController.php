<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\SliderView;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SliderViewsController extends Controller
{
    public function slider_views($id){

        return view('slider_views.index',compact('id'));
    }

    public function get_all_slider_views(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = SliderView::where('slider_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    $user = User::where('id',$data->user_id)->first();
                    if($user){
                        return $user->name;
                    }else{
                        return 'غير معروف';
                    }
                })

            



                ->rawColumns(['image','sale_points'])

                ->make(true);
        }
    }

    public function store_slider_views(Request $request){

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


    public function update_slider_views(Request $request){


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

    public function destroy_slider_views(Request $request){

        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
