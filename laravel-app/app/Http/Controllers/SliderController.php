<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Level;
use App\Models\Study;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Slider;
use App\Models\Product;
use App\Models\Section;
use App\Models\QuizStart;
use App\Models\UserCourse;
use App\Models\SliderLevel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


class SliderController extends Controller
{
    public function sliders(){

        // $courses_ids = Course::where('teacher_id',109)->pluck('id');
        // $user_courses = UserCourse::whereIn('course_id',['174','175'])->get();

        // foreach($user_courses as $use_co){
        //     $use_co->delete();
        // }

        return view('sliders.index');
    }

    public function get_all_sliders(Request $request)
    {
        if ($request->ajax()) {
            $data = Slider::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('image', function ($data) {
                    return  '<img src="'.$data->image.'" alt="" style="width:40%">';
                   
                })
                ->addColumn('views', function ($data) {
                    return '<a href="'.route('slider_views',$data->id).'">'.$data->views.'</a> <br> <span style="font-size:12px"> (مشاهدات مجهولة '.$data->ignore_views.') </span>';
                   
                })

                ->addColumn('is_acess', function ($data) {
                    $level_slider = SliderLevel::where('slider_id',$data->id)->get();
                    if($level_slider->count() > 0){
                         return view('sliders.btn.is_acess', compact('data'));
                    }else{
                        return '<span class="badge badge-primary">ستظهر للجميع</span>';
                    }
                })
              
                ->addColumn('description', function ($data) {
                 $m=   Str::limit($data->description, 20, $end='.......');
                     return $m;
                  })
                ->addColumn('url', function ($data) {
                 $m=   Str::limit($data->url, 20, $end='.......');
                     return $m;
                  })
                ->addColumn('type', function ($data) {
                 if($data->type==1){
                     return "خارجي";
                 }elseif($data->type==2){
                     return "داخلي";
                 
                 }elseif($data->type==4){
                     return "فيديو";
                 }else{
                    return "قسم";
                 }
                })

                ->addColumn('level_id', function ($data) {
                        $level_slider = SliderLevel::where('slider_id',$data->id)->get();
                        if($level_slider->count() > 0){

                            foreach($level_slider as $level_sli){
                                $level = Level::where('id',$level_sli->level_id)->first();
                                if($level){
                                    $study = Study::where('id',$level->study_id)->first();
                                    if($study){
                                        $level_array[] = '(' . $level->name . ' - ' .$study->name.')';
                                    }
                                }
                              
                            }

                            return $level_array;

                        }else{
                            return '<span class="badge badge-primary">الكل</span>';
                        }
                })
                ->addColumn('action', function ($data) {
                    return view('sliders.btn.action', compact('data'));
                })

            

                ->rawColumns(['image','product_id','type','level_id','is_acess','views'])

                ->make(true);
        }
    }


   

    // http://localhost:8000/image?url=localhost:8000/attachments/subjects/22781412photo_2023-02-19_00-31-32.jpg&w=300&q=100
    // https://academy-mirmaz.com/image?url=academy-mirmaz.com/attachments/sliders/10037318CAP5203742997040149239.jpg&w=500&h=640&q=100
   
    public function resizeImage(Request $request)
    {
        // Decode the URL before validation
        $url = urldecode($request->get('url'));

    
        if (!str_contains($url, '://')) {

                $link = $request->get('url');
                
                // Remove any path segments after the domain name
                $domain = explode('/', $link)[0];
             
            
                $url = str_replace($domain, '', $url);

                // اذا بدي اياها تشتغل لوكل
                // $url = str_replace('localhost:8000', '', $url);
            
                $url = public_path($url);
        }

        $validator = Validator::make(['url' => $url] + $request->except('url'), [
            'url' => 'required',
            'w' => 'integer|min:1',
            'q' => 'integer|min:1|max:1000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $width = $request->get('w');
        if ($request->has('h')) {
            $height = $request->get('h');
        }else{
            $height = null;
        }
        $quality = $request->get('q');

     // Generate a unique cache key based on the request parameters
        $cacheKey = md5(serialize($request->all()));

        // Check if the image is already cached
        if (Storage::disk('caching')->exists($cacheKey)) {
            $cachedImagePath = Storage::disk('caching')->path($cacheKey);
            return response()->file($cachedImagePath);
        }

        try {
            $image = Image::make($url)->resize($width, $height );

            $response = $image->response('jpg', $quality);

             // Cache the image response on the disk
            Storage::disk('caching')->put($cacheKey, $response->getContent());

            return $response;

        } catch (\Intervention\Image\Exception\NotReadableException $e) {
            Log::error('Image resize error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to resize image because the image file could not be read.'], 500);
        } catch (\Exception $e) {
            Log::error('Image resize error: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to resize image.'], 500);
        }
    }
    






    

    


    
    

    public function store_sliders(Request $request){
       
        $request->validate([
            'image'              => 'required',
       
        ]);
        

        DB::beginTransaction();
        try {

            $slider = new Slider();
            $slider->type         = $request->slider_type;
            $slider->url          = $request->link;
            $slider->title        = $request->title;
            if(isset($request->section)){

                $slider->section        = $request->section;
                
            }
            $slider->description  = $request->description;
            // $slider->product_id   = $request->product_id;

            if ($request->hasFile('image')) {
                
                //  اخزن اسم الصورة في الداتابيز
                    $image_url =  $request->image->getClientOriginalName();

                    $image_url =  rand(223423,23423444) . $image_url;

                    
                    $base_url = url('attachments/sliders/'. $image_url );


                    $slider -> image   = $base_url;


                    $request->image-> move(public_path('attachments/sliders'), $image_url);
                    //  اخزن الصورة في السيرفر
                    //  $request->image->move('attachments/sliders/', $image_url);
        

            }
            
            $slider->save();


            if(isset($request->level_id)){
                foreach($request->level_id as $level_i){

                    $slider_level = new SliderLevel();
                    $slider_level->level_id = $level_i;
                    $slider_level->slider_id =  $slider->id;
                    $slider_level->save();
                    
                }
            }
          

        DB::commit();

        }

        catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'something error',
                
            ]);

        }

   

        if ($slider) {
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

    public function edit_slider($id){
        return view('sliders.edit',compact('id'));
    }

    public function update_sliders(Request $request){

        $slider = Slider::findorFail($request->id);

   
        $slider->type         = $request->slider_type;
        $slider->url          = $request->link;
        $slider->title        = $request->title;
        $slider->description  = $request->description;
        // $slider->product_id   = $request->product_id;

        if ($request->hasFile('image')) {
            
               //  اخزن اسم الصورة في الداتابيز
                $image_url =  $request->image->getClientOriginalName();

                $image_url =  rand(223423,23423444) . $image_url;

                
                $base_url = url('attachments/sliders/'. $image_url );


                $slider -> image   = $base_url;

                $request->image-> move(public_path('attachments/sliders').$image_url);
    
      

        }
        
        $slider->save();
  


        if(isset($request->level_id)){

            $level_sliders  = SliderLevel::where('slider_id',$slider->id)->get();
            
            if( $level_sliders->count() > 0){
                
                foreach($level_sliders as $level_slider){
                    $level_slider->delete();
                }
            }

            foreach($request->level_id as $level_i){

                $slider_level = new SliderLevel();
                $slider_level->level_id = $level_i;
                $slider_level->slider_id =  $slider->id;
                $slider_level->save();
                
            }
        }else{
            $level_sliders  = SliderLevel::where('slider_id',$slider->id)->get();
            
            if( $level_sliders->count() > 0){
                
                foreach($level_sliders as $level_slider){
                    $level_slider->delete();
                }
            }
        }

        if ($slider) {
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

    public function destroy_sliders(Request $request){
           
        $slider = Slider::find($request->id);
        $slider->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }


    public function mirmaz_teacher_form(){


        return view('form_teacher.mirmaz_teacher_form');

    }


}
