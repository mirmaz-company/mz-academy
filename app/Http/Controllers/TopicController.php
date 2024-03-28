<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Topic;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class TopicController extends Controller
{
    public function topics(){
     
        return view('topics.index');
    }

    public function get_all_topics(Request $request)
    {
        if ($request->ajax()) {
            $data = Topic::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('topics.btn.action', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_topics(Request $request){
       
        $request->validate([
            'name'              => 'required',
       
        ]);

     

        $topic = new Topic();
        $topic ->name                  = $request->name;

        
        $topic -> save();

   

        if ($topic) {
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


    public function update_topics(Request $request){


        $request->validate([
            'name'              => 'required',        
        ]);


        $topic = Topic::findorFail($request->id);

        $topic->name            = $request->name;

        $topic->save();

        if ($topic) {
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

    public function destroy_topics(Request $request){
           
        $topic = Topic::find($request->id);
        $topic->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
