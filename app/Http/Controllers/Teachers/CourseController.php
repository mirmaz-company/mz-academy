<?php

namespace App\Http\Controllers\Teachers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Level;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\UserCourse;
use Illuminate\Http\Request;
use App\Models\Teachers\Course;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;

class CourseController extends Controller
{
    public function courses(){ 
     
        return view('teachers.courses.index');
    }

    public function get_all_courses(Request $request)
    {
        if ($request->ajax()) {
            // كورسات الأستاذ عرضتهم كمان للمساعدين تاعونو عن طريق البيرنت
            if(Auth::guard('teachers')->user()->parent == 0){
                $teacher_id = Auth::guard('teachers')->user()->id;
            }else{
                $teacher_id = Auth::guard('teachers')->user()->parent;
            }
            $data = Course::where('teacher_id',$teacher_id)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('level_id', function ($data) {
                    $level = Level::where('id',$data->level_id)->first();
                    if($level){
                        return $level->name ?? "-";
                    }else{
                        return "-";
                    }
                })

                ->addColumn('image_100k', function ($data) {
                    return  '<img src="'.$data->image_100k.'" alt="" style="width:80%">';
                     
                  })

                ->addColumn('sections', function ($data) {
                       $section_cont = Section::where('course_id',$data->id)->count();
                       $id= Crypt::encrypt($data->id);
                       return '<a href="'.route('teachers.sections',$id).'">'. $section_cont.'</a>';
                  })
                ->addColumn('subscriptions', function ($data) {
                       
                       $parameter= Crypt::encrypt($data->id);
                      

                    //    اذا حساب مرماز موجود بنقص واحد من عدد المشتركين عشان ما احسبو
                       $user = User::Where('mobile',"009647703391199")->first();
                       if($user){
                     

                           $if_mirmaz = UserCourse::where('user_id',$user->id)->where('course_id',$data->id)->first();
                          
                           if($if_mirmaz){
                           
                                 $count_sub = UserCourse::where('course_id',$data->id)->count();
                                 $count_sub = $count_sub - 1;
                                 return '<a href="'.route('teachers.users',$parameter).'">'. $count_sub.'</a>';
                           }
                       }

                     
                        $count_sub = UserCourse::where('course_id',$data->id)->count();
                  
                     

                       return '<a href="'.route('teachers.users',$parameter).'">'. $count_sub.'</a>';
                  })
                ->addColumn('status', function ($data) {

                        if($data->status == 0){
                         return '<button class="btn btn-danger btn-sm">غير مفعلة</button>';
                          
                        }elseif($data->status == 1){
                            return '<button class="btn btn-primary btn-sm"> قيد المراجعة</button>';
                        
                        }elseif($data->status == 3){
                            return '<button class="btn btn-danger btn-sm"> تم الرفض </button>';
                        }else{
                            return '<button class="btn btn-success btn-sm"> تم النشر</button>';
                        }

                  })

                  ->addColumn('is_view', function ($data) {
                    return view('teachers.courses.btn.is_view_change', ['id' => $data->id, 'is_view' => $data->is_view]);
                })


                  ->addColumn('is_hidden_subscripe', function ($data) {
                    return view('teachers.courses.btn.is_hidden_subscripe', ['id' => $data->id, 'is_hidden_subscripe' => $data->is_hidden_subscripe]);
                })



                ->addColumn('type', function ($data) {

                   if($data->type == "paid_public"){

                          return 'مدفوع عام';

                   }elseif($data->type == "private"){

                          return 'خاص';

                   }else{

                          return 'مجاني';

                   }
                })

                ->addColumn('action', function ($data) {
                    return view('teachers.courses.btn.action', compact('data'));
                })

            

                ->rawColumns(['image_100k','sections','status','subscriptions'])

                ->make(true);
        }
    }



    public function has_ended_route(Request $request){
       $course = Course::where('id',$request->id)->first();

       if(Auth::guard('teachers')->user()->parent == 0){
        $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        if($course){
            if($course->teacher_id != $teacher_id){
                return response()->json([
                    'status' => false,
                    'msg' => 'غير مصرح بك ',
                ]);
            }
        }

       if($course){
            $course->has_ended = 1;
            $course->save();
       }

       return response()->json([
        'status' => true,
        'msg' => 'تمت الانهاء بنجاح',
     ]);


    }


    public function get_sections_from_course($id)
    {  
        
            $get_sections_from_course = DB::table("sections")->where("course_id",$id)->get();

       

            return response()->json([
    
                'get_sections_from_course' => $get_sections_from_course,
        
               
            ]);
        


    }



    public function store_courses(Request $request){
       
        $request->validate([
            'price'         => 'numeric|required',
            'discount'      => 'numeric|required',
            'name'          => 'required',
            'level_id'      => 'required',
            'image'         => 'required',
            'type'          => 'required',
            'description'          => 'required',
        ]);

     

        $course = new Course();
        $course ->name                  = $request->name;
        if(Auth::guard('teachers')->user()->parent == 0){

            $course ->teacher_id            = Auth::guard('teachers')->user()->id;
        }else{
            $course ->teacher_id            = Auth::guard('teachers')->user()->parent;

        }
        $course ->subject_id            = $request->subject_id;
        $course ->level_id              = $request->level_id;
        $course ->study_id              = $request->study_id;
        $course ->price                 = $request->price;
        $course ->discount              = $request->discount;
        $course ->type                  = $request->type;
        $course ->description           = $request->description;


        // تخزين الصورة بحجم صغير
        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             $base_url = url('attachments/courses/image_100K/'. $image_url );

             $course -> image_100k   = $base_url;

            //  نزلنا ال entervintion image
            //  $image = Image::make($request->image)->resize(300, 200);
             $image = Image::make($request->image);
            

            //  من صفر ل 100 بختار جودة الصورة بعد ما ضغطتها
             $image->save(public_path('attachments/courses/image_100K/').$image_url,50);
         
        }

        // تخزين الصورة بحجمها الاصلي
        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             
             $base_url = url('attachments/courses/full_hd/'. $image_url );


             $course -> image1080   = $base_url;


             $request->image-> move(public_path('attachments/courses/full_hd/'), $image_url);
               
        }

        
        $course -> save();

   

        if ($course) {
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


    public function update_courses(Request $request){


        $request->validate([
            'price'         => 'numeric|required',
            'discount'      => 'numeric|required',
            'name'          => 'required',
            // 'level_id'      => 'required',
            'type'          => 'required',
        ]);

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        $course = Course::findorFail($request->id);

        if($course->teacher_id != $teacher_id){
            return response()->json([
                'status' => false,
                'msg' => 'غير مسموح لك بالتعديل على هذه الدورة',
            ]);
        }

   
        $course->name            = $request->name;

        if($request->subject_id2){
            $course->level_id        = $request->level_id2;
            $course->study_id        = $request->study_id2;
            $course->subject_id        = $request->subject_id2;
        }
       
        $course->price           = $request->price;
        $course->discount        = $request->discount;
        $course->type            = $request->type;
        $course->description     = $request->description;

  
         // تخزين الصورة بحجم صغير
        if ($request->hasFile('image')) {
           
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             $base_url = url('attachments/courses/image_100K/'. $image_url );

             $course -> image_100k   = $base_url;

            //  نزلنا ال entervintion image
            //  $image = Image::make($request->image)->resize(300, 200);
             $image = Image::make($request->image);
            

            //  من صفر ل 100 بختار جودة الصورة بعد ما ضغطتها
             $image->save(public_path('attachments/courses/image_100K/').$image_url,50);
         
        }


         // تخزين الصورة بحجمها الاصلي
        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             
             $base_url = url('attachments/courses/full_hd/'. $image_url );


             $course -> image1080   = $base_url;


             $request->image-> move(public_path('attachments/courses/full_hd/'), $image_url);
               
        }
    
        $course->save();

        if ($course) {
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

    public function destroy_courses(Request $request){

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

           
        $course = Course::find($request->id);
        if($course->teacher_id == $teacher_id){
            $course->delete();
        }
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }

    public function is_view_change(Request $request){
       $course = Course::where('id',$request->id)->first();


       if(Auth::guard('teachers')->user()->parent == 0){
           $teacher_id = Auth::guard('teachers')->user()->id;
       }else{
           $teacher_id = Auth::guard('teachers')->user()->parent;
       }

        if($course){
            if($course->teacher_id != $teacher_id){
                return response()->json([
                    'status' => false,
                    'msg' => 'غير مصرح بك ',
                ]);
            }
        }
       
       if($course){
            if($course->is_view == 1){
                $course->is_view = 0;
                $course->save();

                
                return response()->json([
                    'msg' => "تم تغيير الحالة",
                    'is_view' => 0 
                ]);

            }else{
                $course->is_view = 1;
                $course->save();

                
                return response()->json([
                    'msg' => "تم تغيير الحالة",
                    'is_view' => 1 
                ]);
            }

       }
    }


    public function is_view_subscriper_change(Request $request){
       $course = Course::where('id',$request->id)->first();

       if(Auth::guard('teachers')->user()->parent == 0){
        $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        if($course){
            if($course->teacher_id != $teacher_id){
                return response()->json([
                    'status' => false,
                    'msg' => 'غير مصرح بك ',
                ]);
            }
        }
       if($course){
            if($course->is_hidden_subscripe == 1){
                $course->is_hidden_subscripe = 0;
                $course->save();

                
                return response()->json([
                    'msg' => "تم تغيير الحالة",
                    'is_hidden_subscripe' => 0 
                ]);

            }else{
                $course->is_hidden_subscripe = 1;
                $course->save();

                
                return response()->json([
                    'msg' => "تم تغيير الحالة",
                    'is_hidden_subscripe' => 1 
                ]);
            }

       }
    }


    public function is_post_route(Request $request){

        $course = Course::where('id',$request->id)->first();

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }
 
         if($course){
             if($course->teacher_id != $teacher_id){
                 return response()->json([
                     'status' => false,
                     'msg' => 'غير مصرح بك ',
                 ]);
             }
         }

     
        $course->status = 1;
        $course->save();

        return response()->json([
            'message'=>"سيتم قبول الدورة خلال 24 ساعة"
        ]);
    }


    public function statistics(){
       
      

            $data["month1"] = User::where('type',0)->whereMonth('created_at', 1)->count();
            $data["month2"] = User::where('type',0)->whereMonth('created_at', 2)->count();
            $data["month3"] = User::where('type',0)->whereMonth('created_at', 3)->count();
            $data["month4"] = User::where('type',0)->whereMonth('created_at', 4)->count();
            $data["month5"] = User::where('type',0)->whereMonth('created_at', 5)->count();
            $data["month6"] = User::where('type',0)->whereMonth('created_at', 6)->count();
            $data["month7"] = User::where('type',0)->whereMonth('created_at', 7)->count();
            $data["month8"] = User::where('type',0)->whereMonth('created_at', 8)->count();
            $data["month9"] = User::where('type',0)->whereMonth('created_at', 9)->count();
            $data["month10"] = User::where('type',0)->whereMonth('created_at', 10)->count();
            $data["month11"] = User::where('type',0)->whereMonth('created_at', 11)->count();
            $data["month12"] = User::where('type',0)->whereMonth('created_at', 12)->count();
    
            $user_course =\App\Models\Course::where('teacher_id',Auth::guard('teachers')->user()->id)->pluck('id');

           $user_mirmaz =\App\Models\User::where('mobile','009647703391199')->first();

            if($user_mirmaz){
                $data["usercourse1"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 1)->count();
                $data["usercourse2"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 2)->count();
                $data["usercourse3"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 3)->count();
                $data["usercourse4"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 4)->count();
                $data["usercourse5"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 5)->count();
                $data["usercourse6"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 6)->count();
                $data["usercourse7"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 7)->count();
                $data["usercourse8"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 8)->count();
                $data["usercourse9"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 9)->count();
                $data["usercourse10"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 10)->count();
                $data["usercourse11"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 11)->count();
                $data["usercourse12"] = UserCourse::whereIn('course_id',$user_course)->where('user_id','!=', $user_mirmaz->id)->whereMonth('created_at', 12)->count();
             } else{
                $data["usercourse1"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 1)->count();
                $data["usercourse2"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 2)->count();
                $data["usercourse3"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 3)->count();
                $data["usercourse4"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 4)->count();
                $data["usercourse5"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 5)->count();
                $data["usercourse6"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 6)->count();
                $data["usercourse7"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 7)->count();
                $data["usercourse8"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 8)->count();
                $data["usercourse9"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 9)->count();
                $data["usercourse10"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 10)->count();
                $data["usercourse11"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 11)->count();
                $data["usercourse12"] = UserCourse::whereIn('course_id',$user_course)->whereMonth('created_at', 12)->count();
             }

          
            
    
            return view('teachers.main_statistic',compact('data'));
    
        
    }
}
