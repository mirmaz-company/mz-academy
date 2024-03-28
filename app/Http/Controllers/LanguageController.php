<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Language;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LanguageController extends Controller
{
    public function languages(){
     
        return view('languages.index');
    }

    public function get_all_languages(Request $request)
    {
        if ($request->ajax()) {
            $data = Language::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('languages.btn.action', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_languages(Request $request){
       
        $request->validate([
            'fixed'              => 'required',
       
        ]);

     

        $lang = new Language();
        $lang ->fixed                  = $request->fixed;
        $lang ->word_en                  = $request->word_en;
        $lang ->word_ar                  = $request->word_ar;

        
        $lang -> save();

   

        if ($lang) {
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


    public function update_languages(Request $request){


        // $request->validate([
        //     'city'              => 'required',        
        // ]);


        $lang = Language::findorFail($request->id);

   
        $lang->word_en            = $request->word_en;
        $lang->word_ar            = $request->word_ar;


        $lang->save();

        if ($lang) {
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

    public function destroy_languages(Request $request){
           
        $lang = Language::find($request->id);
        $lang->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
