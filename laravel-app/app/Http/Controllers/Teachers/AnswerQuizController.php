<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\AnswerQuiz;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class AnswerQuizController extends Controller
{
    public function answers_quiz($quiz_id){
     
        return view('teachers.answers_quiz.index',compact('quiz_id'));
    }

    public function get_all_answers_quiz(Request $request,$quiz_id)
    {
        if ($request->ajax()) {
            $data = AnswerQuiz::where('quiz_id',$quiz_id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('teachers.answers_quiz.btn.action', compact('data'));
                })

                ->addColumn('image', function ($data) {
                    return  '<img src="'.$data->image.'" alt="" style="width:40%">';
                     
                  })
                

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_answers_quiz(Request $request){
       
        $request->validate([
            'image'              => 'required',
       
        ]);

     

        $ans = new AnswerQuiz();
        $ans -> quiz_id   = $request->quiz_id;
        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/ans/'. $image_url );


             $ans -> image   = $base_url;


             $request->image-> move(public_path('attachments/ans'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

     }
        $ans -> save();

   

        if ($ans) {
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


    public function update_answers_quiz(Request $request){


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

    public function destroy_answers_quiz(Request $request){
           
        $a = AnswerQuiz::find($request->id);
        $a->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
