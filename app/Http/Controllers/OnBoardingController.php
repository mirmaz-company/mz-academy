<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\OnBoarding;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class OnBoardingController extends Controller
{
    public function onboading(){
     
        return view('onboading.index');
    }

    public function get_all_onboading(Request $request)
    {
        if ($request->ajax()) {
            $data = OnBoarding::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('image', function ($data) {
                    return  '<img src="'.$data->image.'" alt="" style="width:40%">';
                     
                  })


                ->addColumn('action', function ($data) {
                    return view('onboading.btn.action', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_onboading(Request $request){
       
        $request->validate([
            'title'              => 'required',
            'description'              => 'required',
       
        ]);

     

        $onboarding = new OnBoarding();
        $onboarding ->title              = $request->title;
        $onboarding ->description        = $request->description;

        
        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/onboarding/'. $image_url );


             $onboarding -> image   = $base_url;


             $request->image-> move(public_path('attachments/onboarding'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

     }

        
        $onboarding -> save();

   

        if ($onboarding) {
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


    public function update_onboading(Request $request){


        $request->validate([
            'title'              => 'required',
            'description'              => 'required',
       
        ]);



        $onboarding = OnBoarding::findorFail($request->id);

   
        $onboarding->title            = $request->title;
        $onboarding->description            = $request->description;

        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/onboarding/'. $image_url );


             $onboarding -> image   = $base_url;


             $request->image-> move(public_path('attachments/onboarding'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

     }

        $onboarding->save();

        if ($onboarding) {
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

    public function destroy_onboading(Request $request){
           
        $onboarding = onboarding::find($request->id);
        $onboarding->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
