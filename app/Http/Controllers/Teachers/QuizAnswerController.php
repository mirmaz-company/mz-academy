<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Models\QuizAnswer;

class QuizAnswerController extends Controller
{
    public function quiz_answers($id){
     
        return view('teachers.quiz_answers.index',compact('id'));
    }

    public function get_all_quiz_answers(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = QuizAnswer::where('qustion_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('status', function ($data) use($id) {
                    $quiz_ans =  QuizAnswer::where('qustion_id',$id)->where('id',$data->id)->first();
            
                    if($quiz_ans->is_correct == 1){
                       return '<button class="btn btn-success btn-sm">الاجابة صحيحة</button>';
                     
                    }else{
                        return '<button class="btn btn-danger btn-sm">الاجابة خاطئة</button>';
                    }
                })

                ->addColumn('image', function ($data) {
                    if($data->image == null){
                        return 'لا يوجد صورة';
                    }
                    return  '<img src="'.$data->image.'" alt="" style="width:30%">';
                     
                  })


                ->addColumn('action', function ($data) {
                    return view('teachers.quiz_answers.btn.action', compact('data'));
                })

            

                ->rawColumns(['image','status'])

                ->make(true);
        }
    }

    public function store_quiz_answers(Request $request){
       
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


    public function update_quiz_answers(Request $request){


        $request->validate([
            'answer'              => 'required',        
        ]);


        $answer = QuizAnswer::findorFail($request->id);

   
        $answer->answer            = $request->answer;

        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/quizqustion/'. $image_url );


             $answer -> image   = $base_url;


             $request->image-> move(public_path('attachments/quizqustion'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);

        }


        $answer->save();

        if ($answer) {
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

    public function destroy_quiz_answers(Request $request){
           
        $answer = QuizAnswer::find($request->id);
        $answer->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
