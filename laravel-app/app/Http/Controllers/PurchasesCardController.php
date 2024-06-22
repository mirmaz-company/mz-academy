<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\PurchasesCard;
use App\Models\PurchasesCardPrice;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PurchasesCardController extends Controller
{
    public function purchasescard(){

        return view('purchasescard.index');
    }

    public function get_all_purchasescard(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchasesCard::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('purchasescard.btn.action', compact('data'));
                })
                ->addColumn('image', function ($data) {
                    return  '<img src="'.$data->image.'" alt="" style="width:50%">';
                     
                  })


                ->rawColumns(['image'])

                ->make(true);
        }
    }


    public function get_all_purchasescard_price(Request $request)
    {
        if ($request->ajax()) {
            $data = PurchasesCardPrice::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('purchasescard.btn.action2', compact('data'));
                })
                ->addColumn('image', function ($data) {
                    return  '<img src="'.$data->image.'" alt="" style="width:40%">';
                     
                  })


                ->rawColumns(['image'])

                ->make(true);
        }
    }



    public function store_purchasescard_price(Request $request){

        $request->validate([
            'price'              => 'required',
            'image'              => 'required',

        ]);



        $pur = new PurchasesCardPrice();
        $pur ->price                  = $request->price;

        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/sliders/'. $image_url );


             $pur -> image   = $base_url;


             $request->image-> move(public_path('attachments/sliders'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

        }


        $pur -> save();



        if ($pur) {
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


    public function update_purchasescard(Request $request){


        $request->validate([
            'title'              => 'required',
            'description'              => 'required',
        ]);


        $per = PurchasesCard::findorFail($request->id);


        $per->title            = $request->title;
        $per->description            = $request->description;

        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/sliders/'. $image_url );


             $per -> image   = $base_url;


             $request->image-> move(public_path('attachments/sliders'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

        }

        $per->save();

        if ($per) {
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

    public function update_purchasescard_price(Request $request){


        $request->validate([
            'price'              => 'required',
        ]);


        $per = PurchasesCardPrice::findorFail($request->id);


        $per->price            = $request->price;
        
        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/sliders/'. $image_url );


             $per -> image   = $base_url;


             $request->image-> move(public_path('attachments/sliders'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

        }

        $per->save();

        if ($per) {
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

    public function destroy_purchasescard_price(Request $request){

        $per = PurchasesCardPrice::find($request->id);
        $per->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);

    }
}
