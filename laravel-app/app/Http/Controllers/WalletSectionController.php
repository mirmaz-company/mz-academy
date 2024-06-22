<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\WalletCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\WalletSection;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class WalletSectionController extends Controller
{
    public function wallet_sections(){
     
        return view('wallet_sections.index');
    }

    public function get_all_wallet_sections(Request $request)
    {
        if ($request->ajax()) {
            $data = WalletSection::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('number', function ($data) {
                    return  '<a href="'.route("recharge_codes",$data->id).'">'. $data->number ?? "-".'</a>';
                })


                ->addColumn('count_code_used', function ($data) {
                    $wallet_sections = WalletCode::where('section_course_id',$data->id)->where('user_id','!=',null)->count();
                    return  '<a href="'.route("recharge_codes_used",$data->id).'">'. $wallet_sections ?? "-".'</a>';
                })

                ->addColumn('export', function ($data) {
                    return '<a href="'.route('export_course_paid_public',$data->id).'">تصدير</a>';
                    
                })

          

            

                ->rawColumns(['image','number','count_code_used','export'])

                ->make(true);
        }
    }



    public function store_wallet_sections(Request $request){
       
        $request->validate([
            'name'                => 'required',
            'number'              => 'numeric|required',
            'price'               => 'required|required',
       
        ]);

    

        $section_code = new WalletSection();
        $section_code ->name           = $request->name;
        $section_code ->number         = $request->number;
        $section_code ->price          = $request->price;
        $section_code->save();
       

        for($i =0 ; $i<$request->number ; $i++){

            $wallet_code = new WalletCode();
            $wallet_code->section_course_id	 = $section_code->id;
            // $string = Str::upper(Str::random(12));
            // $wallet_code->code = preg_replace('/[o,O,i,I,l,L,0]/', 'M', $string);
            $wallet_code->code = $section_code->id . rand(111111111111,999999999999);
            $wallet_code->price              = $request->price;
            $wallet_code->save();

            $wallet_code3 = WalletCode::where('id',$wallet_code->id)->first();
            $wallet_code3->serial      = $section_code->id ."0000".  $wallet_code->id;
            $wallet_code3->save();

        }

        

        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
        ]);
     
  
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
