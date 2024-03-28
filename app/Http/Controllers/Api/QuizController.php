<?php

namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use App\Models\Level;
use App\Models\Study;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Product;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\QuizStart;
use App\Models\AnswerQuiz;
use App\Models\OnBoarding;
use App\Models\QuizAnswer;
use App\Models\UserCourse;
use App\Models\QuizQustion;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\QuizStartImage;
use App\Models\QuizUserAnswer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{

    public function quiz_detailes(Request $request){

        $quiz = Quiz::where('id',$request->quiz_id)->first();

        $lesson = Lesson::where('id',$quiz->lesson_id)->where('status_node',1)->where('status_laravel',1)->where('is_scheduler',1)->first();
 
        if(!$lesson){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد درس',
        
            ]);
        }
        

        $section = Section::where('id',$lesson->section_id)->first();
        if(!$section){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد قسم',
        
            ]);
        }
      
        $course = Course::where('id',$section->course_id)->first();

        if(!$course){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد دورة',
        
            ]);
        }

        $user_course = UserCourse::where('course_id',$course->id)->where('user_id',Auth::guard('api')->user()->id)->first();

        if($user_course){
            if($quiz){

                $user_quiz = QuizStart::where('user_id',Auth::guard('api')->user()->id)->where('quiz_id',$request->quiz_id)->orderBy('id','desc')->first();

                if($user_quiz){

                    $quiz['remaining_attempt_for_user'] = $quiz->attempt_count - $user_quiz->attempt_count; 
                    $quiz['waiting_pending'] = $user_quiz->waiting_pending; 
                }else{
                    $quiz['remaining_attempt_for_user'] = $quiz->attempt_count; 
                    $quiz['waiting_pending'] = NULL; 
                }

                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'fetch data succsessfully',
                    'data' => $quiz,
            
                ]);
        
            } else{
        
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'not found',
                    ]);
        
            }
        }else{
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'يجب الاشتراك في الدورة',
                'course_id'       => $course->id,
                'course_name'       => $course->name,
            ]);
        }


     

    }

    public function quiz_qustions_and_answers(Request $request){

        $quiz_qustions = QuizQustion::where('quiz_id',$request->quiz_id)->get();

        foreach($quiz_qustions as  $quiz_qus){
            $quiz_qus['answers'] = QuizAnswer::where('qustion_id',$quiz_qus->id)->get();
        }


        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data' => $quiz_qustions,
    
        ]);

    }


    public function start_quiz(Request $request){


        

 


        $quiz = Quiz::where('id',$request->quiz_id)->first();
        if(!$quiz){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد اختبار',
        
            ]);
        }

        $lesson = Lesson::where('id',$quiz->lesson_id)->where('status_node',1)->where('status_laravel',1)->where('is_scheduler',1)->first();

        if(!$lesson){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد درس',
        
            ]);
        }

        $section = Section::where('id',$lesson->section_id)->first();

        if(!$section){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد قسم',
        
            ]);
        }
      
        $course = Course::where('id',$section->course_id)->first();
        if(!$course){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد دورة',
        
            ]);
        }

        // افخص اذا مشترك في الدورة او لا
        $user_course = UserCourse::where('course_id',$course->id)->where('user_id',Auth::guard('api')->user()->id)->first();

      

     if($user_course){

   

      
            $quiz = Quiz::where('id',$request->quiz_id)->first();
            $user_quiz = QuizStart::where('user_id',Auth::guard('api')->user()->id)->where('quiz_id',$request->quiz_id)->first();


            if($user_quiz){
                
                // فحص المحاولات المتبقية
                // 5>1
                if($quiz->attempt_count > $user_quiz->attempt_count){
  

            
                     //   زودنا محاولة وضفنا في حقل الخصم قديش بدنا نخصم عليه
                   //    عملية الحساب في ريكويست انهاء الكويز
                    $user_quizr = QuizStart::where('user_id',Auth::guard('api')->user()->id)->where('quiz_id',$request->quiz_id)->first();
                    $user_quizr->attempt_count= $user_quizr->attempt_count + 1;
                    $user_quizr->points_discount_after_attempt = $user_quizr->points_discount_after_attempt + $quiz->points_after_discount ;

                    // اذا مجموع نقاطو مع الخصم تبع المحاولات طلع بالسالب..بخليه صفر
                    if($user_quizr->points < 0){
                        $user_quizr->points = 0;
                    }

                    $quizz       = Quiz::where('id',$request->quiz_id)->first();
                    if($quizz){
                        $section = Lesson::where('id',$quizz->lesson_id)->first();
                        if($section){
                            $course = Section::where('id',$section->section_id)->first();
                            $user_quizr->course_id = $course->course_id;
                        }
                      
                    }


                    $user_quizr->save();

                 

                    // رجعنالو الاسئلة عشوائية
                    $quiz_qustions = QuizQustion::where('quiz_id',$request->quiz_id)->take($quiz->qustion_count)->inRandomOrder()->get();

                    foreach($quiz_qustions as  $quiz_qus){
                        $quiz_qus['answers'] = QuizAnswer::where('qustion_id',$quiz_qus->id)->inRandomOrder()->get();
                    }
            
            
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'تم بدء الاختبار',
                        'data' => $quiz_qustions,
                
                    ]);

                }else{
                    return response()->json([
                        'code'          => 401,
                        'status'        => false,
                        'message'       => 'انتهت المحاولات الخاصة بهذا الاختبار',
                
                    ]);
                }

            }


            //   الذي ليس له محاولة انشاء الاختبار للطالب
            // رجعنالو الاسئلة والاجابات
            $start_quiz = new QuizStart();

            $start_quiz->quiz_id = $request->quiz_id;

            
            $quizz       = Quiz::where('id',$request->quiz_id)->first();
            if($quizz){
                $section = Lesson::where('id',$quizz->lesson_id)->first();
                if($section){
                    $course = Section::where('id',$section->section_id)->first();
                    $start_quiz->course_id = $course->course_id;
                }
              
            }
            


            $start_quiz->user_id = Auth::guard('api')->user()->id;
            $start_quiz->save();

            $quiz_qustions = QuizQustion::where('quiz_id',$request->quiz_id)->take($quiz->qustion_count)->inRandomOrder()->get();

            foreach($quiz_qustions as  $quiz_qus){
                $quiz_qus['answers'] = QuizAnswer::where('qustion_id',$quiz_qus->id)->inRandomOrder()->get();
            }


            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تم بدء الاختبار',
                'data' => $quiz_qustions,
        
            ]);

        

       


     }else{

        return response()->json([
            'code'          => 404,
            'status'        => false,
            'message'       => 'يجب الاشتراك في الدورة',
            'course_id'       => $course->id,
            'course_name'       => $course->name,
        ]);

     }

    }




    public function end_quiz(Request $request){


            
        $quiz_start = QuizStart::where('quiz_id',$request->quiz_id)->where('user_id',Auth::guard('api')->user()->id)->first();
        $quiz = Quiz::where('id',$request->quiz_id)->first();
        $quiz_users_attempt_is_end = QuizUserAnswer::where('quiz_id',$request->quiz_id)->where('user_id',Auth::guard('api')->user()->id)->where('my_attempt',$quiz->attempt_count)->first();
        
        if($quiz->type == "quiz_choose"){
                if( $quiz_users_attempt_is_end){

                    return response()->json([
                        'code'          => 401,
                        'status'        => false,
                        'message'       => 'انتهت المحاولات الخاصة بهذا الاختبار ',
                        
                    ]);
                }
                
        
                $quiz_users_attempt_is_end = QuizUserAnswer::where('quiz_id',$request->quiz_id)->where('user_id',Auth::guard('api')->user()->id)->where('my_attempt',$quiz_start->attempt_count)->first();
        
        
                if( $quiz_users_attempt_is_end){
        
                    return response()->json([
                        'code'          => 401,
                        'status'        => false,
                        'message'       => 'لا يمكن ارسال الاجابات اكثر من مرة',
                        
                    ]);
                }
        
    


                $answers = json_decode($request->answers);

                // عداد لحساب كم خطا
                $count_false = 0;
                // تخزين الاجابات الخاصة بالطالب للكويز
                foreach($answers as $ans){

                    $quiz_user_answer  = new QuizUserAnswer(); 
                    $quiz_user_answer->quiz_id = $request->quiz_id;
                    $quiz_user_answer->user_id = Auth::guard('api')->user()->id;

                    // رقم المحاولة عندما بدا الكويز
                    $quiz_user_answer->my_attempt = $quiz_start->attempt_count;


                    $quiz_user_answer->qustion_id = $ans->questionid;
                    $quiz_user_answer->answer_id  = $ans->answerid;

                    // تخزين اذا اجابتو صحيحة ام لا
                    // السؤال جبت مين الجواب الصح
            
                    $quiz_answer = QuizAnswer::where('qustion_id',$ans->questionid)->where("is_correct",1)->first();


                    // بفحص اذا جوابو صحيح او لا وبخزنو عندي
                    // قارنت بين الجواب الصح والجواب تبع اليوزر

                    if($quiz_answer->id == $ans->answerid){

                        $quiz_user_answer->your_answer = 1;

                    }else{
                        $quiz_user_answer->your_answer = 0;

                        // معرفة كم غلطة عشان احسب علامتو تحت
                        $count_false =  $count_false + 1;
                    }

                    $quiz_user_answer->save();

                }



                // تسجيل النقاط للطالب
            
                $quiz_start = QuizStart::where('quiz_id',$request->quiz_id)->where('user_id',Auth::guard('api')->user()->id)->first();
                $quiz       = Quiz::where('id',$request->quiz_id)->first();
   
                // معرفة كل سؤال كم نقطة
                $marks = $quiz ->points / $quiz ->qustion_count;

                // ضربنا علامة كل سؤال في عدد الاسئلة الخطا
                $mark_points_is_false = $marks * $count_false;

                // نقصنا النقاط الي غلطان منهم من مجموع النقاط
                $points  = $quiz ->points - $mark_points_is_false;
                $quiz_start->points =  $points;
                $quiz_start->end_points =  $points - $quiz_start->points_discount_after_attempt;
                $quiz_start->save();

        
                // تسجيل المجموع النهائي للنقاط للطالب في جدول ال usercourse لنفس الدورة
                $quizz       = Quiz::where('id',$request->quiz_id)->first();
                $section     = Lesson::where('id',$quizz->lesson_id)->first();
                $course      = Section::where('id',$section->section_id)->first();

                
                $user_course = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id', $course->course_id)->first();
                if($user_course){

                    $quiz_user_sta = QuizStart::where('user_id',Auth::guard('api')->user()->id)->where('course_id', $course->course_id)->first();

                    if($quiz_user_sta){
                        $quiz_user_sta_count = QuizStart::where('user_id',Auth::guard('api')->user()->id)->where('course_id', $course->course_id)->sum('end_points');
                        $user_course->points = $quiz_user_sta_count;
                        $user_course->save();
                    }
                }

              

            return response()->json([ 
                'code'          => 200,
                'status'        => true,
                'message'       => ' تم الانتهاء من الاختبار',
                'total_points'       => $quiz ->points,
                'mark_student'       => $points ,
                'mark_student_with_total_points'  => $points ."/". $quiz ->points,
                'discount'                    => $quiz_start->points_discount_after_attempt,
                'total_mark_student'                  =>  $quiz_start->end_points,
                'attempt_used'              => $quiz_start->attempt_count,
                'number_attempt_remaing'              => $quiz->attempt_count - $quiz_start->attempt_count,
                'count_wrong_questions'       => $count_false,
                'count_true_questions'       => $quiz->qustion_count  - $count_false,
            
        
            ]);

        


        }else{


         
            $answers = json_decode($request->answers);


               

                foreach($request->answers_image as $key=>$ans){
                    $quiz_user_answer  = new QuizUserAnswer(); 
                    $quiz_user_answer->quiz_id = $request->quiz_id;
                    $quiz_user_answer->user_id = Auth::guard('api')->user()->id;
    
                    // رقم المحاولة عندما بدا الكويز
                    $quiz_user_answer->my_attempt = $quiz_start->attempt_count;
    
    
                    $quiz_user_answer->qustion_id = 0;
                    $quiz_user_answer->answer_id  = 0;

                    $filename = Str::random(10) . '_' . time();

                    // Get the file extension from the original image
                    $extension = $ans->getClientOriginalExtension();
    
                    // Combine the filename and extension to create the new image name
                    $image_name = $filename . '.' . $extension;
    
                    
                    // $base_url = url('attachments/quiz/'. $image_name );
                    $base_url = env("APP_URL") . '/attachments/quiz/' . $image_name;

    
    
                    $quiz_user_answer -> your_answer_image   = $base_url;
    
    
                    $ans-> move(public_path('attachments/quiz'), $image_name);
               

                    $quiz_user_answer->save();

                }

                $user_quiz = QuizStart::where('user_id',Auth::guard('api')->user()->id)->where('quiz_id',$request->quiz_id)->first();
                // لما يتم تصحيح الاختبار من اللوحة correction_end
                $user_quiz->waiting_pending = "waiting_pending";
                $user_quiz->save();



                return response()->json([ 
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'correction_in_progress',
                    'message2'       => 'تم ارسال الاجابات بنجاح',
            
                ]);


                DB::commit();

          


        }




    }

    public function get_answers_quiz(Request $request){

        $answer = AnswerQuiz::where('quiz_id',$request->quiz_id)->get();
        $answer_student = QuizUserAnswer::where('quiz_id',$request->quiz_id)->where('user_id',Auth::guard('api')->user()->id)->get(['your_answer_image']);
        $qustions = QuizQustion::where('quiz_id',$request->quiz_id)->get();

        $quiz_start = QuizStart::where('user_id',Auth::guard('api')->user()->id)->where('quiz_id',$request->quiz_id)->orderBy('id','desc')->first();
        $quiz_images = QuizStartImage::where('quiz_start_id',$quiz_start->id)->get();


        return response()->json([ 
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم ارسال الاجابات بنجاح',
            'answer_teacher'       => $answer,
            'answer_student'       => $answer_student,
            'qustions'       => $qustions,
            'notes'       => $quiz_start->notes,
            'images_from_teacher_to_student' => $quiz_images,
    
        ]);
    }



    ////// editor quiz
    public function start_quiz_editor(Request $request){

 


        $quiz = Quiz::where('id',$request->quiz_id)->first();
        if(!$quiz){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد اختبار',
        
            ]);
        }

        $lesson = Lesson::where('id',$quiz->lesson_id)->where('status_node',1)->where('status_laravel',1)->where('is_scheduler',1)->first();

        if(!$lesson){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد درس',
        
            ]);
        }

        $section = Section::where('id',$lesson->section_id)->first();

        if(!$section){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد قسم',
        
            ]);
        }
      
        $course = Course::where('id',$section->course_id)->first();
        if(!$course){
            return response()->json([
                'code'          => 401,
                'status'        => false,
                'message'       => 'لا يوجد دورة',
        
            ]);
        }

        // افخص اذا مشترك في الدورة او لا
        $user_course = UserCourse::where('course_id',$course->id)->where('user_id',Auth::guard('api')->user()->id)->first();

      

     if($user_course){

   

            $quiz = Quiz::where('id',$request->quiz_id)->first();
            $user_quiz = QuizStart::where('user_id',Auth::guard('api')->user()->id)->where('quiz_id',$request->quiz_id)->first();


            if( $user_quiz->waiting_pending = "waiting_pending"){
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'جاري تصحيح الاختبار',
                ]);
    
            }


            //   الذي ليس له محاولة انشاء الاختبار للطالب
            // رجعنالو الاسئلة والاجابات
            $start_quiz = new QuizStart();
            $start_quiz->quiz_id = $request->quiz_id;
            $start_quiz->waiting_pending = "waiting_pending";
            $start_quiz->user_id = Auth::guard('api')->user()->id;
            $start_quiz->save();

            // راح ارجعلو الاسئلة اما صور او نص بناءا على نوع الكويز التحريري
            $quiz_qustions = QuizQustion::where('quiz_id',$request->quiz_id)->inRandomOrder()->get();


            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تم بدء الاختبار',
                'data' => $quiz_qustions,
        
            ]);

       


     }else{

        return response()->json([
            'code'          => 404,
            'status'        => false,
            'message'       => 'يجب الاشتراك في الدورة',
            'course_id'       => $course->id,
            'course_name'       => $course->name,
        ]);

     }

    }




}
