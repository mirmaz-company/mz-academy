<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\Quiz;
use App\Models\QuizAnswer;
use App\Models\QuizQustion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;
use Yajra\DataTables\DataTables;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class QuizQustionController extends Controller
{
    public function quiz_qustions($id,$type){
     
        $quiz = Quiz::where('id',$id)->first();
        if($type == "quiz_choose"){
            return view('teachers.quiz_qustions.index',compact('id','quiz','type'));
        }elseif($type == "quiz_image"){
            return view('teachers.quiz_qustions.index2',compact('id','quiz','type'));
        }else{
            return view('teachers.quiz_qustions.index3',compact('id','quiz','type'));
        }
    }

    public function get_all_quiz_qustions(Request $request,$id)
    {
        if ($request->ajax()) {
            $data = QuizQustion::where('quiz_id',$id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('answers', function ($data) {
                    $qustion_answer = QuizAnswer::where('qustion_id',$data->id)->count();
                    return '<a href="'.route('teachers.quiz_answers',$data->id).'">'.$qustion_answer.'</a>';
                })


                ->addColumn('image', function ($data) {
                    if($data->image == null){
                        return 'لا يوجد صورة';
                    }
                    return  '<img src="'.$data->image.'" alt="" style="width:30%">';
                     
                  })


                ->editColumn('qustion', function ($data) {
                    if($data->qustion == NULL){
                        return "السؤال يحتوي على صورة فقط";
                    }
                    return $data->qustion ;
                     
                  })


                ->addColumn('action', function ($data) {
                    return view('teachers.quiz_qustions.btn.action', compact('data'));
                })

            

                ->rawColumns(['image','answers'])

                ->make(true);
        }
    }

    public function store_quiz_qustions(Request $request){

 
        if($request->type == "quiz_choose"){
            if($request->qustion == NULL){
                if($request->image45 == NULL){

                    return response()->json([
                        'status' => "qustion_null",
                        'msg' => ' يجب اضافة السؤال او صورة للسؤال',
                    ]);
                }
            }

            if($request->answer_true == NULL){
                if($request->imag334e == NULL){

                    return response()->json([
                        'status' => "answer_null",
                        'msg' => ' يجب ملئ الحقل في الاجابة الصحيحة او اضافة صورة',
                    ]);
                }
            }
        }
   


     


            if($request->type == "quiz_choose"){

                // تسجيل السؤال
                $quiz_question = new QuizQustion();
                $quiz_question->quiz_id   = $request->quiz_id;
                $quiz_question->qustion = $request->qustion;

                if ($request->hasFile('image45')) {
            
                     $extension = $request->image45->getClientOriginalExtension(); // Get the file extension
                     $image_url = time() . '_' . Str::random(10) . '.' . $extension; // Generate a unique filename
        
        
                     $base_url = url('attachments/quizqustion/'. $image_url );
        
                     $quiz_question -> image   = $base_url;
        
                    //  نزلنا ال entervintion image
                    //  $image = Image::make($request->image)->resize(300, 200);
                     $image = Image::make($request->image45);
                    
        
                    //  من صفر ل 100 بختار جودة الصورة بعد ما ضغطتها
                     $image->save(public_path('attachments/quizqustion/').$image_url,50);
                 
                }

                // if ($request->hasFile('image45')) {
                
                    //     //  اخزن اسم الصورة في الداتابيز
                    //     $image_url =  $request->image45->getClientOriginalName();
        
                    //     $image_url =  rand(223423,23423444) . $image_url;
        
                        
                    //     $base_url = url('attachments/quizqustion/'. $image_url );
        
        
                    //     $quiz_question -> image   = $base_url;
        
        
                    //     $request->image45-> move(public_path('attachments/quizqustion'), $image_url);
                    //     //  اخزن الصورة في السيرفر
                    //     //  $request->image->move('attachments/sliders/', $image_url);
    
                // }

                $quiz_question->save();
            


                // تسجيل الاجابة الصحيحة
                $quiz_answer = new QuizAnswer();
                $quiz_answer ->qustion_id     = $quiz_question->id;
                $quiz_answer ->answer         = $request->answer_true;
                $quiz_answer ->is_correct     = 1;

                if ($request->hasFile('imag334e')) {
            
                    $extension = $request->imag334e->getClientOriginalExtension(); // Get the file extension
                    $image_url = time() . '_' . Str::random(10) . '.' . $extension; // Generate a unique filename
       
       
                    $base_url = url('attachments/quiz_answer/'. $image_url );
       
                    $quiz_answer -> image   = $base_url;
       
                   //  نزلنا ال entervintion image
                   //  $image = Image::make($request->image)->resize(300, 200);
                    $image = Image::make($request->imag334e);
                   
       
                   //  من صفر ل 100 بختار جودة الصورة بعد ما ضغطتها
                    $image->save(public_path('attachments/quiz_answer/').$image_url,50);
                
                }

                // if ($request->hasFile('imag334e')) {
                    
                
                    //     //  اخزن اسم الصورة في الداتابيز
                    //     $image_url =  $request->imag334e->getClientOriginalName();
        
                    //     $image_url =  rand(223423,23423444) . $image_url;
        
                        
                    //     $base_url = url('attachments/quiz_answer/'. $image_url );
        
        
                    //     $quiz_answer -> image   = $base_url;
        
        
                    //     $request->imag334e-> move(public_path('attachments/quiz_answer'), $image_url);
                    //     //  اخزن الصورة في السيرفر
                    //     //  $request->image->move('attachments/sliders/', $image_url);
    
                // }

                
                $quiz_answer -> save();



                // تسجيل الاجابات الخاطئة
                foreach($request->answer_false_all as $key=>$ans){

                    if(!isset($ans["answer_false"]) && !isset($ans["image_answers"])){
                    
            
                            return response()->json([
                                'status' => "is_null_all_question",
                                'msg' => 'يوجد اجابات فارغة...يجب التأكد من جميعها ',
                            ]);

                        
                    }

                    $quiz_answer_false = new QuizAnswer();
                    $quiz_answer_false ->qustion_id     = $quiz_question->id;
                    $quiz_answer_false ->answer         = $ans["answer_false"];
                    $quiz_answer_false ->is_correct     = 0;

                    
                    

                    // $img = 'image_answers'
                    if (isset($ans["image_answers"] )) {

            
                            $extension = $ans["image_answers"]->getClientOriginalExtension(); // Get the file extension
                            $image_url = time() . '_' . Str::random(10) . '.' . $extension; // Generate a unique filename
               
               
                            $base_url = url('attachments/sliders/'. $image_url );
               
                            $quiz_answer_false -> image   = $base_url;
               
                           //  نزلنا ال entervintion image
                           //  $image = Image::make($request->image)->resize(300, 200);
                            $image = Image::make($ans["image_answers"]);
                           
               
                           //  من صفر ل 100 بختار جودة الصورة بعد ما ضغطتها
                            $image->save(public_path('attachments/sliders/').$image_url,50);
                        
                        
                
                
                        //  اخزن اسم الصورة في الداتابيز
                        // $image_url =  $ans["image_answers"]->getClientOriginalName();
        
                        // $image_url =  rand(223423,23423444) . $image_url;
        
                        
                        // $base_url = url('attachments/sliders/'. $image_url );
        
        
                        // $quiz_answer_false -> image   = $base_url;
        
        
                        // $ans["image_answers"]-> move(public_path('attachments/sliders'), $image_url);
                        //  اخزن الصورة في السيرفر
                        //  $request->image->move('attachments/sliders/', $image_url);
            
        
                    }

                    
                    $quiz_answer_false -> save();
                }

            }elseif($request->type == "quiz_image"){

                     // تسجيل الاسئلة  
                     foreach($request->answer_false_all as $key=>$ans){

                        if($ans["image45"] == null){
                        
                
                                return response()->json([
                                    'status' => "is_null_all_question",
                                    'msg' => 'يوجد اجابات فارغة...يجب التأكد من جميعها ',
                                ]);
    
                            
                        }
    
                     
                        $quiz_question = new QuizQustion();
                        $quiz_question->quiz_id   = $request->quiz_id;
                        $quiz_question->qustion = null;
                        
    
                        // $img = 'image_answers'
                        if (isset($ans["image45"] )) {

            
                                $extension = $ans["image45"]->getClientOriginalExtension(); // Get the file extension
                                $image_url = time() . '_' . Str::random(10) . '.' . $extension; // Generate a unique filename
                   
                   
                                $base_url = url('attachments/sliders/'. $image_url );
                   
                                $quiz_question -> image   = $base_url;
                   
                               //  نزلنا ال entervintion image
                               //  $image = Image::make($request->image)->resize(300, 200);
                                $image = Image::make($ans["image45"]);
                               
                   
                               //  من صفر ل 100 بختار جودة الصورة بعد ما ضغطتها
                                $image->save(public_path('attachments/sliders/').$image_url,50);
                            
                            
                
                          //  اخزن اسم الصورة في الداتابيز
                        //   $image_url =  $ans["image45"]->getClientOriginalName();
        
                        //   $image_url =  rand(223423,23423444) . $image_url;
          
                          
                        //   $base_url = url('attachments/sliders/'. $image_url );
          
          
                        //   $quiz_question -> image   = $base_url;
          
          
                        //   $ans["image45"]-> move(public_path('attachments/sliders'), $image_url);
                          //  اخزن الصورة في السيرفر
                          //  $request->image->move('attachments/sliders/', $image_url);
                
                            }

                            $quiz_question -> save();
            
                        }
    
                        
                        
                    
    

            }else{

                foreach($request->answer_false_all as $key=>$ans){

                    if($ans["qustion"] == null){
                        
                
                        return response()->json([
                            'status' => "is_null_all_question",
                            'msg' => 'يوجد اجابات فارغة...يجب التأكد من جميعها ',
                        ]);

                    
                    }

                    $quiz_question = new QuizQustion();
                    $quiz_question->quiz_id   = $request->quiz_id;
                    $quiz_question->qustion = $ans["qustion"];
                    


                    
                    $quiz_question -> save();
                }
            }

      
      
        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
        ]);
    
  
    }


    public function update_quiz_qustions(Request $request){


        // $request->validate([
        //     'qustion'              => 'required',        
        // ]);


        $quiz_question = QuizQustion::findorFail($request->id);

   
        $quiz_question->qustion            = $request->qustion;

        if ($request->hasFile('image')) {
            
            $extension = $request->image->getClientOriginalExtension(); // Get the file extension
            $image_url = time() . '_' . Str::random(10) . '.' . $extension; // Generate a unique filename


            $base_url = url('attachments/quizqustion/'. $image_url );

            $quiz_question -> image   = $base_url;

           //  نزلنا ال entervintion image
           //  $image = Image::make($request->image)->resize(300, 200);
            $image = Image::make($request->image);
           

           //  من صفر ل 100 بختار جودة الصورة بعد ما ضغطتها
            $image->save(public_path('attachments/quizqustion/').$image_url,50);
        
        }

        // if ($request->hasFile('image')) {
            
        //     //  اخزن اسم الصورة في الداتابيز
        //      $image_url =  $request->image->getClientOriginalName();

        //      $image_url =  rand(223423,23423444) . $image_url;

             
        //      $base_url = url('attachments/quizqustion/'. $image_url );


        //      $quiz_question -> image   = $base_url;


        //      $request->image-> move(public_path('attachments/quizqustion'), $image_url);
        //        //  اخزن الصورة في السيرفر
        //      //  $request->image->move('attachments/sliders/', $image_url);

        // }


        $quiz_question->save();

        if ($quiz_question) {
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

    public function destroy_quiz_qustions(Request $request){
           
        $quiz_question = QuizQustion::find($request->id);
        $quiz_question->delete();

        $quiz_answer = QuizAnswer::where('qustion_id',$request->id)->get();

        foreach($quiz_answer as $qu){
            $qu->delete();
        }

        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
