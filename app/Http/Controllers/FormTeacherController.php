<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\FormTeacher;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FormTeacherController extends Controller
{
    public function form_teacher(){

        $form_tacher = FormTeacher::where('status',0)->get();
        
        foreach($form_tacher as $form_ta){
            $form_ta->status = 1;
            $form_ta->save();
        }
     
        return view('form_teacher.index');
    }

    public function get_all_form_teacher(Request $request)
    {
        if ($request->ajax()) {
            $data = FormTeacher::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('form_teacher.btn.action', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_cities(Request $request){
       
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


    public function update_cities(Request $request){


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

    public function destroy_cities(Request $request){
           
        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
