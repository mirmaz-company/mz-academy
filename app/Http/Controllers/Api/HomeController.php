<?php

namespace App\Http\Controllers\Api;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Level;
use App\Models\Study;
use App\Models\Topic;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Product;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teachers\Teacher;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\OnBoarding;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Models\MostImportant;
use App\Models\SupportWebsit;
use App\Models\CitiesSalePoints;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


    // هذا الريكويست لمعرفة حالة الرفع من سيرفر النود وتخزين البيانات المطلوبة للدرس
    public function update_lesson_server(Request $request){

        $lesson = Lesson::find($request->lesson_id);

        $lessons_the_same = Lesson::where('the_same_lessons',$lesson->the_same_lessons)->get();

        $section = Section::where('id',$lesson->section_id)->first();
        $course = Course::where('id',$section->course_id)->first();

        $teacher = Teacher::where('id',$course->teacher_id)->first();


        if($request->status_node == 0){

            foreach($lessons_the_same as $lesson_the_same){
                $lesson_the_same->status_node = 0;
                // عشان ال updated_at يختلف عن created_at
                $lesson_the_same->updated_at = $lesson->freshTimestamp();

                $lesson_the_same->save();
            }
        }else{

            foreach($lessons_the_same as $lesson_the_same){
                if($lesson_the_same->type_video == "bunny" || $lesson_the_same->type_video == "Bunny"){
                    $lesson_the_same->link = "https://".$teacher->pull_zone."/".$request->guid."/playlist.m3u8";
                    $lesson_the_same->type_video = "bunny";
                    $lesson_the_same->status_node = 1;
                    $lesson_the_same->save();
                }else{
        
                    $lesson_the_same->video_id_vdocipher = $request->guid;
                    $lesson_the_same->type_video = "vdocipher";
                    $lesson_the_same->link = "vdocipher";
                    $lesson_the_same->status_node = 1;
                    $lesson_the_same->save();
                }
            }
        }


       

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم تحديث الدرس بنجاح',
            'data' => $lesson,
     
        ]);

    }


    public function top_students(Request $request){

  
       
        $top_students = UserCourse::where('course_id',$request->course_id)->where('points','>',0)->orderBy('points','desc')->paginate(20);

        foreach($top_students as $student){
            $student['user'] = User::where('id',$student->user_id)->first(['id','name','image']);
            
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم جلب البيانات بنجاح',
            'data' => $top_students,
        
        ]);
      
    
        
    }



    public function popular(){

        $top_products = Product::take(6)->get(); 

        if(Auth::guard('api')->check()){
          
            foreach($top_products as $product){
                
                $favorites = Favorite::where('user_id',Auth::guard('api')->user()->id)->where('product_id',$product->id)->first();

                
                if($favorites){

                    $product['is_wishlist'] = "1";
                }else{
                    $product['is_wishlist'] = "0";
                }

       

            }
        }else{

            foreach($top_products as $product){
             
             
                    $product['is_wishlist'] = "0";
              
            }
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'top_product' => $top_products,
     
        ]);
    }

    public function most_rated(){

        $top_products = Product::take(6)->orderBy('rate','desc')->get(); 

        if(Auth::guard('api')->check()){
          
            foreach($top_products as $product){
                
                $favorites = Favorite::where('user_id',Auth::guard('api')->user()->id)->where('product_id',$product->id)->first();

                
                if($favorites){

                    $product['is_wishlist'] = "1";
                }else{
                    $product['is_wishlist'] = "0";
                }

       

            }
        }else{

            foreach($top_products as $product){
             
             
                    $product['is_wishlist'] = "0";
              
            }
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'top_product' => $top_products,
     
        ]);
    }

    public function most_important(){
        $most_im = MostImportant::all();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data' => $most_im,
     
        ]);
        
    }

    public function cities_sale_points(Request $request){

        $request->validate([
            'city_id' => 'required',
        ]);


        $city_sa = CitiesSalePoints::where('city_id',$request->city_id)->get();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data' => $city_sa,
     
        ]);
    }

    public function support_website(Request $request){
        $sup = new SupportWebsit();
        $sup->name = $request->name;
        $sup->mobile = $request->mobile;
        $sup->type_problem = $request->type_problem;
        $sup->detailes = $request->detailes;
        $sup->save();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم ارسال المشكلة  .. سيتم الرد عليك باسرع وقت ممكن',
            'data' => $sup,
     
        ]);

        
    }


    public function new_product(){

        $top_products = Product::take(6)->orderBy('created_at','desc')->get(); 

        if(Auth::guard('api')->check()){
          
            foreach($top_products as $product){
                
                $favorites = Favorite::where('user_id',Auth::guard('api')->user()->id)->where('product_id',$product->id)->first();

                
                if($favorites){

                    $product['is_wishlist'] = "1";
                }else{
                    $product['is_wishlist'] = "0";
                }

       

            }
        }else{

            foreach($top_products as $product){
             
             
                    $product['is_wishlist'] = "0";
              
            }
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'top_product' => $top_products,
     
        ]);
    }


    public function filter(Request $request){

        $items = Product::where([ 
            ['name', 'LIKE', '%' . $request->name_product . '%'],
        ])->get();

        if(Auth::guard('api')->check()){
          
            foreach($items as $product){
                
                $favorites = Favorite::where('user_id',Auth::guard('api')->user()->id)->where('product_id',$product->id)->first();

                
                if($favorites){

                    $product['is_wishlist'] = "1";
                }else{
                    $product['is_wishlist'] = "0";
                }

       

            }
        }else{

            foreach($items as $product){
             
             
                    $product['is_wishlist'] = "0";
              
            }
        }
   

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'result' => $items,
     
        ]);





    }

    public function all_topic(){
        $topics = Topic::all();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data' => $topics,
     
        ]);
    }


    public function all_study(){

        // انا رجعت الدراسة التي تحتوي مراحل داخلها مواضيع 
      
        $levels = Level::all();

        if(count($levels) == 0){
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data' => [],
         
            ]);
        }
        $data = [];

        foreach($levels as $level){
           
            $course = Course::where('level_id',$level->id)->where('is_view',1)->where('status',2)->get();
            // return $subjects;

            if(count($course) != 0){
                // return $subjects;
                $data[] = Level::where('id',$level->id)->pluck('study_id')->first();
            }
        }


        if(count($data) == 0){
            $data = [];
        }
        // return $data;

     
      

        $study = Study::whereIn('id',$data)->orderBy('created_at','asc')->get();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data' => $study,
     
        ]);
    }


    public function all_level(){
        // انا رجعت المراحل الي الها كورسات فقط
        $course_is_level = Course::where('is_view',1)->pluck('level_id');

        $level = Level::whereIn('id',$course_is_level)->get();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data' => $level,
     
        ]);
    }


    public function all_categories(){
        $categories = Category::all();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data' => $categories,
     
        ]);
    }


    public function onboarding(){
        $onboarding = OnBoarding::all();

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'data' => $onboarding,
     
        ]);
    }
}
