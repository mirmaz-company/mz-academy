<?php

namespace App\Http\Controllers\Teachers;


use getID3;
use Storage;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Lesson;
use GuzzleHttp\Client;
use App\Models\Comment;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\DataCourse;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Teachers\Course;
use App\Models\LessonAttachmetn;
use Vimeo\Laravel\Facades\Vimeo;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;

class LessonController extends Controller
{
    public function lessons($id = null){

        Session::put('status', 'never');

    

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_vdo_buuny = Auth::guard('teachers')->user()->vdociper_or_bunny;
        }else{
            $teacher_vdo_buuny = Teacher::where('id',Auth::guard('teachers')->user()->parent)->first();
            $teacher_vdo_buuny = $teacher_vdo_buuny->vdociper_or_bunny;
            
        }
        if($id == null){
            return view('teachers.lessons.index',compact('teacher_vdo_buuny'));
        }else{

            $id = Crypt::decrypt($id);   
            return view('teachers.lessons.index',compact('id','teacher_vdo_buuny'));
        }
      
    }
    
    public function changeOrderIndex(Request $request) {
        $lesson = Lesson::find($request->lesson_id);
        
        if($lesson) {
             $orderIndex = $request->order_index;
            if($orderIndex) {
               
                if (is_numeric($orderIndex) && ctype_digit(strval($orderIndex))) {
                $lesson->order_index = $request->order_index;
                $lesson->timestamps = false;
                $lesson->save();
                
                return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تم التعديل بنجاح',
             ]);
                } else {
                     return response()->json([
            'code'          => 404,
            'status'        => false,
            'message'       => 'ليس رقم',
            
        ], 404);
                }
                
            } else {
                $lesson->order_index = null;
                $lesson->timestamps = false;
                $lesson->save();
                
                return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تم مسح الترتيب',
             ]);
            }
            
           
        
        } else {
            return response()->json([
            'code'          => 404,
            'status'        => false,
            'message'       => 'لا يوجد درس',
            
        ], 404);
        }
        
        
    }

    
    
    public function get_all_lessons(Request $request,$id=null)
    {
        if ($request->ajax()) {

            if($id == null){
                $course_teacher = Course::where('teacher_id',Auth::guard('teachers')->user()->id)->orWhere('teacher_id',Auth::guard('teachers')->user()->parent)->pluck('id');
                $sections = Section::whereIn('course_id', $course_teacher)->pluck('id');

                // $data = Lesson::where('status_laravel','!=',0)->whereIn('section_id',$sections)->orderBy('created_at','desc');
                $data = Lesson::whereIn('section_id',$sections)
                        ->where('status_laravel', '!=', 0)
                        ->orderByRaw('
                            IF(order_index IS NOT NULL, 0, 1), 
                            order_index ASC, 
                            created_at DESC
                        ');
            }else{
                // $data = Lesson::where('section_id',$id)->where('status_laravel','!=',0)->orderBy('created_at','desc');
                $data = Lesson::where('section_id', $id)
                        ->where('status_laravel', '!=', 0)
                        ->orderByRaw('
                           IF(order_index IS NOT NULL, 0, 1), 
                                order_index ASC, 
                                created_at DESC
                        ');

            }
           
     
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('name', function ($data) {
                    
                    if($data->type_video == 'vdocipher') {
                        return $data->name . ' (' . $this->convertDuration($data->long_video ?? 0) . ')';
                        
                        
                    } 
                    return $data->name;
                })


                ->addColumn('course_id', function ($data) {
                    $course = Course::where('id',$data->course_id)->first();
                    if($course){
                        return $course->name ?? "-";
                    }else{
                        return '-';
                    }

                })
                
               
                ->addColumn('quiz', function ($data) {

                    if($data->status_laravel == 1 && $data->status_node == 1 && $data->updated_at < \Carbon\Carbon::now()->subHours(1)->toDateTimeString()){
                        $quiz = Quiz::where('lesson_id',$data->id)->count();

                        $id= Crypt::encrypt($data->id);
                        
                        return '<a href="'.route('teachers.quiz',[$id]).'">'.$quiz.'</a>';
                    }else{
                        return '<a href="#" style="color:red">0</a>';
                    }

                })
                ->addColumn('status_lesson', function ($data) {
                    $lesson = Lesson::where('id',$data->id)->first();

                    if($lesson->is_cancel == 1){
                        return "<p style='color:red'>فشلت عملية الرفع</p>";
                    }

                    if($lesson->type_video == "YouTube"){

                        if($lesson->updated_at < Carbon::now()->subHours(1)->toDateTimeString()){

                            if($lesson->is_scheduler == 0){
                                if ($lesson->status_laravel == 1 && $lesson->status_node == 0 && $lesson->created_at != $lesson->updated_at){
                                    return "<p style='color:red'>فشلت عملية الرفع</p>";
                                }else{
                                    $m = $lesson->form_date . ' ' . $lesson->date;
                                    return  "<p style='color:blue;font-size:12px'>"."(". $m . ")"." مجدول</p>";
                                }
                            }else{
                                return  "<p style='color:green'>  تم النشر</p>";
                            }
                          
                        }else{

                            if($lesson->is_scheduler == 0){
                                if ($lesson->status_laravel == 1 && $lesson->status_node == 0 && $lesson->created_at != $lesson->updated_at){
                                    return "<p style='color:red'>فشلت عملية الرفع</p>";
                                }else{
                                    $m = $lesson->form_date . ' ' . $lesson->date;
                                    return  "<p style='color:blue;font-size:12px'>"."(". $m . ")"." مجدول</p>";
                                }
                            
                            }
                            return "<span style='color:#00CFE8'>
                           
                            قيد التحقق</span>
                            <div class='spinner-grow text-info spinner-grow-sm' role='status'>
                            <span class='sr-only'>Loading...</span>
                           </div>";
                        }
                       
                    }

                    if($lesson->is_scheduler == 0){
                        if ($lesson->status_laravel == 1 && $lesson->status_node == 0 && $lesson->created_at != $lesson->updated_at){
                            return "<p style='color:red'>فشلت عملية الرفع</p>";
                        }else{
                            $m = $lesson->form_date . ' ' . $lesson->date;
                            return  "<p style='color:blue;font-size:12px'>"."(". $m . ")"." مجدول</p>";
                        }
                    
                    }

                    if($lesson->type_video == "resolutions" && $lesson->status_laravel == 1 && $lesson->status_node == 1){

                        if($lesson->resulotion_update == 3){
                            return  "<p style='color:red'>  فشلت عملية الرفع </p>";
                        }

                        if($lesson->is_scheduler == 0){
                            if ($lesson->status_laravel == 1 && $lesson->status_node == 0 && $lesson->created_at != $lesson->updated_at){
                                return "<p style='color:red'>فشلت عملية الرفع</p>";
                            }else{
                                $m = $lesson->form_date . ' ' . $lesson->date;
                                return  "<p style='color:blue;font-size:12px'>"."(". $m . ")"." مجدول</p>";
                            }
                        
                        }

                        if($lesson->updated_at < Carbon::now()->subHours(1)->toDateTimeString()){
                            return  "<p style='color:green'>  تم النشر</p>";
                        }else{
                            return "<span style='color:#00CFE8'>
                           
                            قيد التحقق</span>
                            <div class='spinner-grow text-info spinner-grow-sm' role='status'>
                            <span class='sr-only'>Loading...</span>
                           </div>";
                        }
                    }

                    // تمت اضافة الدرس بدون رفع ملف
                    if($lesson->status_laravel == 0 && $lesson->status_node == 0){

                        return "<p style='color:blue'>لم يتم رفع الدرس</p>";

                    }

                    //    تم رفع الملف وتم ارجاع الحالة من سيرفر النود عن طريق انو ال created_at يختلف عن updated_at
                    elseif($lesson->status_laravel == 1 && $lesson->status_node == 0 && $lesson->created_at != $lesson->updated_at){

                        if($lesson->video_id == null){
                            return "<p style='color:red'>فشلت عملية الرفع</p>";
                        }else{

                            $currentTime = Carbon::now();
                            $hoursDifference = $currentTime->diffInHours($lesson->created_at);
                            // اذا الفرق اكبر من 5 ساعات
                            if ($hoursDifference >= 5) {
                                return "<p style='color:red'>فشلت عملية الرفع</p>";
                            }else{
                                if($lesson->status_node == 0 && $lesson->resulotion_update == 3){
                                    return "<p style='color:red'>فشلت عملية الرفع</p>";
                                }
                                if( $lesson->status_node == 0){
                                    return "<span style='color:black'>
                            
                                    تتم المعالجة</span>
                                    <div class='spinner-border text-dark spinner-border-sm' role='status'>
                                        <span class='sr-only'>Loading...</span>
                                    </div>";
                               }
                            }
                         
                          
                        }
                      

                    }

                    // تم رفع الملف ولم يتم ارجاع الملف من سيرفر النود لانو ال created_at يساوي updated_at
                    elseif($lesson->status_laravel == 1 && $lesson->status_node == 0 && $lesson->created_at == $lesson->updated_at){

                        if($lesson->status_node == 0 && $lesson->resulotion_update == 3){
                            return "<p style='color:red'>فشلت عملية الرفع</p>";
                        }else{
                            return "<span style='color:black'>
                       
                            تتم المعالجة</span>
                            <div class='spinner-border text-dark spinner-border-sm' role='status'>
                                <span class='sr-only'>Loading...</span>
                            </div>";
                        }

                   

                    }

                    // تم رفع الملف وسيرفر النود ارجع حالة الرفع بنجاح وتم زيادة ساعة معالجة فيديو
                    elseif($lesson->status_laravel == 1 && $lesson->status_node == 1 && $lesson->updated_at < Carbon::now()->subHours(1)->toDateTimeString()){

                        if($lesson->is_scheduler == 0){
                           if ($lesson->status_laravel == 1 && $lesson->status_node == 0 && $lesson->created_at != $lesson->updated_at){
                                return "<p style='color:red'>فشلت عملية الرفع</p>";
                            }else{
                                $m = $lesson->form_date . ' ' . $lesson->date;
                                return  "<p style='color:blue;font-size:12px'>"."(". $m . ")"." مجدول</p>";
                            }
                           
                        }else{
                            return  "<p style='color:green'>  تم النشر</p>";
                        }

                    }

                    // تم رفع الملف وسيرفر النود ارجع حالة الرفع بنجاح ولكن لم تزيد ساعة معالجة فيديو
                    elseif($lesson->status_laravel == 1 && $lesson->status_laravel == 1){

                        if($lesson->is_scheduler == 0){
                            if ($lesson->status_laravel == 1 && $lesson->status_node == 0 && $lesson->created_at != $lesson->updated_at){
                                return "<p style='color:red'>فشلت عملية الرفع</p>";
                            }else{
                                $m = $lesson->form_date . ' ' . $lesson->date;
                                return  "<p style='color:blue;font-size:12px'>"."(". $m . ")"." مجدول</p>";
                            }
                      
                        }else{
                            return "<span style='color:#00CFE8'>
                           
                            قيد التحقق</span>
                            <div class='spinner-grow text-info spinner-grow-sm' role='status'>
                            <span class='sr-only'>Loading...</span>
                           </div>";
                        }
                     
                        

                    }

                    else{

                        return "<p style='color:red'>فشلت عملية الرفع</p>";

                    }

                })

                ->addColumn('section_id', function ($data) {
                    $section_id = Section::where('id',$data->section_id)->first();
                    if($section_id){
                        return $section_id->name ?? "-";
                    }else{
                        return '-';
                    }

                })
                ->addColumn('type', function ($data) { 
                 
                    return view('teachers.lessons.btn.type', compact('data'));
                  
                })
                ->addColumn('type_course', function ($data) {
                                         
                   $course = Course::where('id',$data->course_id)->first();
                   if($course){
                        if($course->type == "private"){
                            return "خاصة";
                        }elseif($course->type == "paid_public"){
                            return "مدفوع عام";
                        }else{
                            return "مجانية";
                        }
                   }else{
                        return '-';
                   }
                  
                })

                ->addColumn('comments', function ($data) {

                    if($data->status_laravel == 1 && $data->status_node == 1 && $data->updated_at < \Carbon\Carbon::now()->subHours(1)->toDateTimeString()){
                        $count_comments = Comment::where('lesson_id',$data->id)->count();
                    
                        $id= Crypt::encrypt($data->id); 
                    
                        return '<a href="'.route('teachers.comments',$id).'">'. $count_comments.'</a>';
                    }else{
                        
                        return '<a href="#" style="color:red">0</a>';
                    }
                })


                ->addColumn('action', function ($data) {
                    return view('teachers.lessons.btn.action', compact('data'));
                })
                ->addColumn('order_action', function ($data) {
                    return view('teachers.lessons.btn.order_action', compact('data'));
                })
                ->addColumn('views', function ($data) {

                    $count_views = DataCourse::where('lesson_id',$data->id)->count();

                  return '<a data-toggle="modal" data-id="'.$data->id.'" href="#views_modal">'.$count_views.'</a>';
                })

            

                ->rawColumns(['image','comments','status_lesson','quiz','views'])

                ->make(true);
        }
    }
    
    public function convertDuration($seconds)
{
    

    // Convert seconds to a Carbon interval
    $interval = \Carbon\CarbonInterval::seconds($seconds);

    // Format the interval as hours and minutes
    $formattedDuration =$interval->cascade()->format('%h:%I:%S');

    return $formattedDuration;
}


      public function upload_bunny(Request $request,$name,$id,$name_teacher){

        $name = preg_replace('/[^A-Za-z0-9]/', '', $name);
    

        // حصلت على اي دي الأستاذ من خلال اي دي الدرس
        $course = Lesson::where('id',$id)->first();
        $teacher = Course::Where('id',$course->course_id)->first();

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
            $teacher = Teacher::where('id',$teacher_id)->first();

        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
            $teacher = Teacher::where('id',$teacher_id)->first();
        }
    
        Config::set('chunk-upload.storage.chunks', 'chunks-' . $id);

        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (!$receiver->isUploaded()) {
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file

     
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded

            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.'.$extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk(config('filesystems.default'));
            $disk->putFileAs('videos', $file, $fileName);
          

            // بدي احدد طريقة الاستاذ للرفع بشكل مباشر اما عن طريق الفودوسايفر او البني
            if($teacher->vdociper_or_bunny == 'bunny'){

                    $name = 'lesson '. $id;

                  // انشات الفيديو
                    $client = new \GuzzleHttp\Client();

                    $response2 = $client->request('POST', 'https://video.bunnycdn.com/library/'.$teacher->library_id.'/videos', [
                    'headers' => [
                        'accept' => 'application/json',
                        'content-type' => 'application/*+json',
                        'AccessKey'=> $teacher->access_key
                    ],
                    'body' => '{"title":"'.$name.'"}',
                    ]);
                    
            
                    $data3 = json_decode($response2->getBody()); 

            
                


                    // رفع الفيديو على الذي انشاته      
                    $response3 = $client->request('PUT', 'https://video.bunnycdn.com/library/'.$teacher->library_id.'/videos/'. $data3->guid, [
                        'headers' => [
                            'AccessKey' => $teacher->access_key,
                            'Content-Type'=>'application/octet-stream',
                            'Accept'=> 'application/json',
                            // 'data-binary'=>$request->video,
                        ],
                    
                        'body' => file_get_contents($file),
                    
                    ]);


                    
            $lesson = Lesson::where('id',$id)->first();
            $lesson->link = "https://".$teacher->pull_zone."/".$data3->guid."/playlist.m3u8";
            $lesson->type_video = "Bunny";

            $lesson->save();

            unlink($file->getPathname());
            Storage::delete('videos/'.$fileName);
            Storage::disk(config('chunk-upload.storage.disk'))
                ->deleteDirectory(config('chunk-upload.storage.chunks'));

            }else{

                $course = 'lesson'.$course->id;

                // upload to vdociher
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://dev.vdocipher.com/api/videos?title=".$course."&folderId=".$teacher->id_folder_vdosipher."",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Apisecret BaKF1pCeOhosgNHLhWsHYZcRIGn8BDSbOTCUvb7yyCyJwWIGlcJJHd99U6rP7Sge"
                    ),
                ));
    
                $response = curl_exec($curl);
                $err = curl_error($curl);
    
                curl_close($curl);
    
            
    
             
    
                // below response was obtained in Step 1
                $responseObj = json_decode($response);
                $uploadCredentials = $responseObj->clientPayload;
    
                // save this id in your database with status 'upload-pending'
                // var_dump($responseObj->videoId);
    
                $filePath = $file;
                $ch = curl_init($uploadCredentials->uploadLink);
                curl_setopt ($ch, CURLOPT_POST, 1);
                curl_setopt ($ch, CURLOPT_POSTFIELDS, [
                    'policy' => $uploadCredentials->policy,
                    'key'    => $uploadCredentials->key,
                    'x-amz-signature' => $uploadCredentials->{'x-amz-signature'},
                    'x-amz-algorithm' => $uploadCredentials->{'x-amz-algorithm'},
                    'x-amz-date' => $uploadCredentials->{'x-amz-date'},
                    'x-amz-credential' => $uploadCredentials->{'x-amz-credential'},
                    'success_action_status' => 201,
                    'success_action_redirect' => '',
                    'file' => new \CurlFile($filePath, 'image/png/mp4', 'filename.png'),
                ]);
                curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
    
                // get response from the server
                $response = curl_exec($ch);
                $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                $err = curl_error($curl);
    
                curl_close($ch);
    
               
           
                $video_id = $responseObj->videoId;
                $lesson = Lesson::where('id',$id)->first();
                $lesson->video_id_vdocipher = $video_id;
                $lesson->type_video = "vdocipher";
                // حتى يظهر في الجدول
                $lesson->link = "vdocipher";
    
                $lesson->save();

                unlink($file->getPathname());
                Storage::delete('videos/'.$fileName);
    
            }
            
          


            return 'done';
         
        }

        // otherwise return percentage informatoin
        $handler = $fileReceived->handler();


           
       
  
    }

    public function get_views(Request $request,$id){

        if ($request->ajax()) {
            
            $user_ids = DataCourse::where('lesson_id',$id)->pluck('user_id');

            $data = User::whereIn('id',$user_ids)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                
                ->addColumn('image', function ($data) {
                    if($data->image == null){
                     
                        return  '<img src="https://avatars.hsoubcdn.com/9e457730e2940e1e66d3d00f22642207?s=256" alt="" style="width:40%">';
                    }
                    return  '<img src="'.$data->image.'" alt="" style="width:40%">';
                     
                  })

                ->rawColumns(['image'])

                ->make(true);
        }
    }



    public function get_all_attachments(Request $request,$id)
    {
        if ($request->ajax()) {


             $data = LessonAttachmetn::where('lesson_id',$id)->orderBy('id','desc');
        
           
     
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('teachers.lessons.btn.action2', compact('data'));
                })

            

                ->rawColumns(['image','name'])

                ->make(true);
        }
    }

    public function disabled_comments_route(Request $request)
    {

            $lesson = Lesson::where('id',$request->lesson_id)->first();

            if(Auth::guard('teachers')->user()->parent == 0){
                $teacher_id = Auth::guard('teachers')->user()->id;
            }else{
                $teacher_id = Auth::guard('teachers')->user()->parent;
            }

            $section = Section::where('id',$lesson->section_id)->first();
            if($section){
                $course = Course::where('id',$section->course_id)->first();
                if($course){
                    if($course->teacher_id != $teacher_id){
                        return response()->json([
                            'status' => false,
                            'msg' => 'غير مصرح بك ',
                        ]);
                    }
                }
            }
       

            $lesson = Lesson::where('id',$request->lesson_id)->first();

            $lesson->timestamps = false;  
            if($lesson->is_comment_disabled == 0){
                $lesson->is_comment_disabled = 1;
            }else{
                $lesson->is_comment_disabled = 0;
            }

            $lesson->save();
            $lesson->timestamps = true;  

            return response()->json([
                'status' => $lesson->is_comment_disabled,
                'msg' => ' تم تعديل الحالة بنجاح ',
            ]);
        
    }

    public function disabled_routs_comments_route(Request $request)
    {
       

            $course = Course::where('id',$request->course_id)->first();

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

            $course->timestamps = false;  
            if($course->is_comment_disabled == 0){
                $course->is_comment_disabled = 1;
            }else{
                $course->is_comment_disabled = 0;
            }

            $course->save();
            $course->timestamps = true;  

            return response()->json([
                'status' => $course->is_comment_disabled,
                'msg' => ' تم تعديل الحالة بنجاح ',
            ]);
        
    }
    


    public function details($id){

        $lesson = Lesson::findOrFail($id);

        return view('teachers.lessons.details',compact('id'));
        
    }

    public function store_lessons(Request $request){

      
        if(isset($request->is_there_id)){
            $request->validate([
                'name'              => 'required',
                // 'type'              => 'required',
                // 'descriptions'        => 'required',
           
            ],[
                'required' => 'هذا الحقل مطلوب',
            ]);
        }else{
            $request->validate([
                'name'              => 'required',
                'all_courses'              => 'required',
                // 'type'              => 'required',
                // 'descriptions'        => 'required',
           
            ],[
                'required' => 'هذا الحقل مطلوب',
            ]);
        }
       
      

        // if(isset($request->all_forms)){
        //     foreach($request->all_forms as $key=>$all_form){

        //         if(isset($all_form["id_form"])){

        //             if($all_form["id_form"] != "nothing_0"){

        //                 $is_found = FormUser::where('user_id',$user->id)->where('form_id',$all_form["id_form"])->first();
        //                 if(!$is_found){
        //                     $form_user = new FormUser();
        //                     $form_user->user_id = $user->id;
        //                     $form_user->form_id = $all_form["id_form"];
        //                     $form_user->save();
        //                 }
        //             }
        //         }

        //     }
        // }

        if(!isset($request->is_there_id)){

            if(!isset($request->all_courses)){

                return response()->json([
                    'status' => false,
                    'msg' => 'يجب اضافة دورة',
                ]);

            }
        }


        if($request->date != null && $request->form_date == null){
            return response()->json([
                'status' => "date",
                'msg' => 'يجب اضافة الوقت والتاريخ بالكامل',
            ]);
        }
        if($request->date == null && $request->form_date != null){
            return response()->json([
                'status' => "date",
                'msg' => 'يجب اضافة الوقت والتاريخ بالكامل',
            ]);
        }

        if($request->date != null){

            $timeString = $request->form_date;
            $time = Carbon::parse($timeString);

            $dateString = $request->date;
            $date = Carbon::parse($dateString);
            $date->setTime($time->hour, $time->minute, $time->second);
            $dateTimeString = $date->format('Y-m-d');


            $time = Carbon::parse($request->form_date);
            Carbon::setLocale('en');
            $form_date = $time->formatLocalized('%I:%M %p');
        }

        $randome = rand(0,1000000000000000000) .time();
        if(!isset($request->is_there_id)){
          
        
            foreach($request->all_courses as $key=>$all_course){

                        if(isset($all_course["section_id_repeater"])){
                        
        
                            if($all_course["section_id_repeater"] != "nothing_0"){
                        
                        
        
                            
                                $lesson = new Lesson();
                                $lesson ->name                  = $request->name;
                                $lesson ->type                  = $request->type;
                                if(isset($request->second_cut)){
                                    $lesson ->second_cut            = $request->second_cut;
                                }
                                $lesson ->course_id             = $all_course["course_id_repeater"];
                                $lesson ->type_video             =$request->type_video;
                                $lesson ->section_id            = $all_course["section_id_repeater"];
                                $lesson ->descriptions          = $request->descriptions;
                                $lesson ->the_same_lessons      = $randome;


                                if($request->date != null && $request->form_date != null){
                                    $lesson ->date                  = $dateTimeString;

                                    $form_date = str_replace(["ص", "م"], ["AM", "PM"], $form_date);

                                    $lesson ->form_date             = $form_date;
                                    // في قائمة الجدولة ولم يتم نشره
                                    $lesson -> is_scheduler = 0;
                                }

                                

                                if($request->type_video == "YouTube"){
                                    $lesson ->link            = $request->link;
                                    $lesson ->status_node            = 1;
                                    $lesson ->status_laravel         = 1;
                                }

                                if($request->type_video == "import_youtube"){

                                        // استخراج معرّف الفيديو باستخدام الرمز النمطي
                                        if (preg_match('/\?v=([^#\&\?]+)/', $request->link, $matches)) {
                                            $videoId_link = $matches[1];
                                        }else{
                                            // تحويل الرابط إلى رابط قياسي
                                            $url = str_replace('https://', '', $request->link);
                                            $url = str_replace('http://', '', $request->link);

                                            // استخراج معرّف الفيديو باستخدام الرمز النمطي
                                            if (preg_match('/\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {
                                                $videoId_link = $matches[1];
                                            }
                                        }


                                    $client = new Client();

                                    $url = 'https://hls-stream.fly.dev/downloadYoutube';
                                    $videoId_link = $videoId_link;
                                    $apiKey = '56c16dcc-391c-444f-9482-9be00204f097';
                                    
                                    $response = $client->get($url, [
                                        'headers' => [
                                            'key' =>$apiKey,
                                        ],
                                        'query' => [
                                            'id' => $videoId_link,
                                        ],
                                    ]);
                                    
                                    $data = json_decode($response->getBody(), true);
                                    

                                    $lesson ->status_node            = 0;
                                    $lesson ->resulotion_update      = 1;
                                    $lesson ->status_laravel         = 1;
                                    $lesson ->video_id               = $data['videoId'];
                                }

                                
                                $lesson -> save();

                                if($request->type_video == "YouTube"){
                                    // Get the current updated_at timestamp
                                    $currentUpdatedAt = $lesson->updated_at;

                                    // Subtract two hours from the current timestamp
                                    $newUpdatedAt = Carbon::parse($currentUpdatedAt)->subHours(2);

                                    // Update the lesson's updated_at timestamp
                                    $lesson->update(['updated_at' => $newUpdatedAt]);
                                }

                                if(Auth::guard('teachers')->user()->parent == 0){

                                    $name_teacher =Auth::guard('teachers')->user()->name;
                                    $id_folder_vdosipher =Auth::guard('teachers')->user()->id_folder_vdosipher;
                                    $type_video = Auth::guard('teachers')->user()->vdociper_or_bunny;
                        
                                    
                                        if($lesson->type_video == "resolutions"){
                                            $url = 'https://hls-video.fly.dev/api/createVideo';
                                            $key = '56c16dcc-391c-444f-9482-9be00204f097';
                                    
                                            $response = Http::withHeaders([
                                                'key' => $key,
                                            ])->post($url);
                                    
                                            $response['id'];
                            
                                            $lesson = Lesson::where('id',$lesson->id)->first();
                                        
                                                $lesson ->video_id = $response['id'];
                                                // لم يتم تحديث اللينك
                                                $lesson ->resulotion_update = 1;
                                                $lesson->save();
                                        }
                                    
                        
                                }else{
                        
                                    $teacher = Teacher::where('id',Auth::guard('teachers')->user()->parent)->first();
                                    $name_teacher =$teacher->name;
                                    $id_folder_vdosipher =$teacher->id_folder_vdosipher;
                                    $type_video = $teacher->vdociper_or_bunny;
                        
                              
                                        if($lesson->type_video == "resolutions"){
                                            $url = 'https://hls-video.fly.dev/api/createVideo';
                                            $key = '56c16dcc-391c-444f-9482-9be00204f097';
                                    
                                            $response = Http::withHeaders([
                                                'key' => $key,
                                            ])->post($url);
                                    
                                            $response['id'];
                            
                                            $lesson = Lesson::where('id',$lesson->id)->first();
                                        
                                                $lesson ->video_id = $response['id'];
                                                // لم يتم تحديث اللينك
                                                $lesson ->resulotion_update = 1;
                                                $lesson->save();
                                        }
                        
                                    
                                }
                        
                                $name = $lesson->name;
                                $id = $lesson->id;
                            
                            }
                        }
        
            }
        }else{

                $lesson = new Lesson();
                $lesson ->name                  = $request->name;
                if(isset($request->second_cut)){
                    $lesson ->second_cut            = $request->second_cut;
                }
                $lesson ->type                  = $request->type;
                $lesson ->course_id             = $request->course_id;
                $lesson ->type_video             =$request->type_video;
                $lesson ->section_id            = $request->section_id;
                $lesson ->descriptions          = $request->descriptions;
                $lesson ->the_same_lessons      = $randome;


                if($request->date != null && $request->form_date != null){
                    $lesson ->date                  = $dateTimeString;

                    $form_date = str_replace(["ص", "م"], ["AM", "PM"], $form_date);

                    $lesson ->form_date             = $form_date;
                    // في قائمة الجدولة ولم يتم نشره
                    $lesson -> is_scheduler = 0;
                }

                

                if($request->type_video == "YouTube"){
                    $lesson ->link            = $request->link;
                    $lesson ->status_node            = 1;
                    $lesson ->status_laravel         = 1;
                }

                if($request->type_video == "import_youtube"){
                
                      // استخراج معرّف الفيديو باستخدام الرمز النمطي
                      if (preg_match('/\?v=([^#\&\?]+)/', $request->link, $matches)) {
                        $videoId_link = $matches[1];
                    }else{
                        // تحويل الرابط إلى رابط قياسي
                        $url = str_replace('https://', '', $request->link);
                        $url = str_replace('http://', '', $request->link);

                        // استخراج معرّف الفيديو باستخدام الرمز النمطي
                        if (preg_match('/\/([a-zA-Z0-9_-]{11})/', $url, $matches)) {
                            $videoId_link = $matches[1];
                        }
                    }

                    $client = new Client();

                    $url = 'https://hls-stream.fly.dev/downloadYoutube';
                    $videoId_link = $videoId_link;
                    $apiKey = '56c16dcc-391c-444f-9482-9be00204f097';
                    
                    $response = $client->get($url, [
                        'headers' => [
                            'key' =>$apiKey,
                        ],
                        'query' => [
                            'id' => $videoId_link,
                        ],
                    ]);
                    
                    $dataa = json_decode($response->getBody(), true);

              

                    

                    $lesson ->status_node            = 0;
                    $lesson ->resulotion_update            = 1;
                    $lesson ->status_laravel         = 1;
                    $lesson ->video_id       = $dataa['videoId'];

                }
                $lesson -> save();

                if($request->type_video == "YouTube"){
                    // Get the current updated_at timestamp
                    $currentUpdatedAt = $lesson->updated_at;

                    // Subtract two hours from the current timestamp
                    $newUpdatedAt = Carbon::parse($currentUpdatedAt)->subHours(2);

                    // Update the lesson's updated_at timestamp
                    $lesson->update(['updated_at' => $newUpdatedAt]);
                }

                

                if(Auth::guard('teachers')->user()->parent == 0){

                
                    $name_teacher =Auth::guard('teachers')->user()->name;
                    $id_folder_vdosipher =Auth::guard('teachers')->user()->id_folder_vdosipher;
                    $type_video = Auth::guard('teachers')->user()->vdociper_or_bunny;
        
               
                        if($lesson->type_video == "resolutions"){
                        $url = 'https://hls-video.fly.dev/api/createVideo';
                        $key = '56c16dcc-391c-444f-9482-9be00204f097';
                
                        $response = Http::withHeaders([
                            'key' => $key,
                        ])->post($url);
                
                        $response['id'];
        
                        $lesson = Lesson::where('id',$lesson->id)->first();
                      
                          
                            $lesson ->video_id = $response['id'];
                            // لم يتم تحديث اللينك
                            $lesson ->resulotion_update = 1;
                            $lesson->save();
                        }
              
                    
        
                }else{
        
                    $teacher = Teacher::where('id',Auth::guard('teachers')->user()->parent)->first();
                    $name_teacher =$teacher->name;
                    $id_folder_vdosipher =$teacher->id_folder_vdosipher;
                    $type_video = $teacher->vdociper_or_bunny;
        
                    
                        if($lesson->type_video == "resolutions"){
                        $url = 'https://hls-video.fly.dev/api/createVideo';
                        $key = '56c16dcc-391c-444f-9482-9be00204f097';
                
                        $response = Http::withHeaders([
                            'key' => $key,
                        ])->post($url);
                
                        $response['id'];
        
                        $lesson = Lesson::where('id',$lesson->id)->first();
                       
                          
                            $lesson ->video_id = $response['id'];
                            // لم يتم تحديث اللينك
                            $lesson ->resulotion_update = 1;
                            $lesson->save();
                        }
            
                    
                }
        
                $name = $lesson->name;
                $id = $lesson->id;
                            
        }
                            
                            
  
        
        



        // if(Auth::guard('teachers')->user()->parent == 0){

        //     $name_teacher =Auth::guard('teachers')->user()->name;
        //     $id_folder_vdosipher =Auth::guard('teachers')->user()->id_folder_vdosipher;
        //     $type_video = Auth::guard('teachers')->user()->vdociper_or_bunny;

       
        //         if($lesson->type_video == "resolutions"){
        //         $url = 'https://hls-video.fly.dev/api/createVideo';
        //         $key = '56c16dcc-391c-444f-9482-9be00204f097';
        
        //         $response = Http::withHeaders([
        //             'key' => $key,
        //         ])->post($url);
        
        //         $response['id'];

        //         $lesson = Lesson::where('id',$lesson->id)->first();
              
                  
        //             $lesson ->video_id = $response['id'];
        //             // لم يتم تحديث اللينك
        //             $lesson ->resulotion_update = 1;
        //             $lesson->save();
        //         }
            

        // }else{

        //     $teacher = Teacher::where('id',Auth::guard('teachers')->user()->parent)->first();
        //     $name_teacher =$teacher->name;
        //     $id_folder_vdosipher =$teacher->id_folder_vdosipher;
        //     $type_video = $teacher->vdociper_or_bunny;

         
        //         if($lesson->type_video == "resolutions"){
        //         $url = 'https://hls-video.fly.dev/api/createVideo';
        //         $key = '56c16dcc-391c-444f-9482-9be00204f097';
        
        //         $response = Http::withHeaders([
        //             'key' => $key,
        //         ])->post($url);
        
        //         $response['id'];

        //         $lesson = Lesson::where('id',$lesson->id)->first();
              
                  
        //             $lesson ->video_id = $response['id'];
        //             // لم يتم تحديث اللينك
        //             $lesson ->resulotion_update = 1;
        //             $lesson->save();
        //         }

            
        // }


        if ($name) {
            if(Auth::guard('teachers')->user()->parent == 0){
                $teacher = Teacher::where('id',Auth::guard('teachers')->user()->id)->first();
            }else{
                $teacher = Teacher::where('id',Auth::guard('teachers')->user()->parent)->first();
            }
            if($teacher->vdociper_or_bunny == 'resolutions'){
                if($lesson->type_video == "resolutions"){
                    return response()->json([
                        'status' => true,
                        'name' => $name,
                        'lesson' => $lesson,
                        'id' =>   $id,
                        'type_video' =>   $type_video,
                        'name_teacher' =>   $name_teacher,
                        'id_folder_vdosipher' =>   $id_folder_vdosipher,
                        'video_id' => isset($response['id']) ? $response['id'] : null,
                        'msg' => 'تمت الاضافة بنجاح',
                    ]);
                }else{
                    return response()->json([
                        'status' => true,
                        'name' => $name,
                        'lesson' => $lesson,
                        'id' =>   $id,
                        'type_video' =>   $type_video,
                        'name_teacher' =>   $name_teacher,
                        'id_folder_vdosipher' =>   $id_folder_vdosipher,
                        'video_id' => null,
                        'msg' => 'تمت الاضافة بنجاح',
                    ]);
                }
             
            }else{
                return response()->json([
                    'status' => true,
                    'name' => $name,
                    'id' =>   $id,
                    'lesson' => $lesson,
                    'type_video' =>   $type_video,
                    'name_teacher' =>   $name_teacher,
                    'id_folder_vdosipher' =>   $id_folder_vdosipher,
                    'video_id' =>   '',
                    'msg' => 'تمت الاضافة بنجاح',
                ]);
            }
         
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
  
    }


    public function cancel_lesson(Request $request){

        $lesson = Lesson::where('id',$request->lesson_id)->first();

        $lesson->status_laravel = 1;
        $lesson->status_node = 0;
        $lesson->is_cancel = 1;
        $lesson->save();

        return response()->json([
            'status' => true,
            'msg' => 'تم الغاء الدرس بنجاح',
        ]);

    }

    
    public function upload_vimeo(Request $request,$id){

   
        $lesson = Lesson::where('id',$id)->first();
   
        $m =  Vimeo::upload($request->video_vimeo,[
             'name' => $lesson->name,
             'description' => $lesson->descriptions,
             // "privacy.view" => "anybody",
             // "privacy.embed" => "public",
         ]);
 
 
         $str = str_replace('/videos/','',$m);
 
         $url='https://vimeo.com/'.$str;

         $lesson = Lesson::where('id',$id)->first();
         $lesson->link = $url;
         $lesson->save();

         return response()->json([
            'success' => 'yes',
         ]);

       
      
    }

    public function add_lesson_to_another_section(Request $request){
        $request->validate([
            'course_id3'         => 'required',
            'section_id3'        => 'required',
        ]);
        
        
        if($request->date != null){

            $timeString = $request->form_date;
            $time = Carbon::parse($timeString);

            $dateString = $request->date;
            $date = Carbon::parse($dateString);
            $date->setTime($time->hour, $time->minute, $time->second);
            $dateTimeString = $date->format('Y-m-d');


            $time = Carbon::parse($request->form_date);
            Carbon::setLocale('en');
            $form_date = $time->formatLocalized('%I:%M %p');
        }


        $lesson_details = Lesson::where('id',$request->id)->first();

        $lesson = Lesson::where('id',$request->id)->first();

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        $section = Section::where('id',$lesson->section_id)->first();
        if($section){
            $course = Course::where('id',$section->course_id)->first();
            if($course){
                if($course->teacher_id != $teacher_id){
                    return response()->json([
                        'status' => false,
                        'msg' => 'غير مصرح بك ',
                    ]);
                }
            }
        }


        if($lesson_details->type_video != "YouTube" || $lesson_details->type_video != "import_youtube"){
            $course = Course::Where('id',$request->course_id3)->first();
            if($course->type == "free" ){
                return response()->json([
                    'status' => false,
                    'msg' => ' لا يمكن اضافة الدرس المدفوع الى دورة مجانية ',
                ]);
            }
            
        }

        // الدرس تم النشر
        if($lesson_details->status_laravel == 1 && $lesson_details->status_node == 1){
            if($lesson_details){
        
                $lesson = new Lesson();
                $lesson->timestamps = false;  // Disabling timestamps
                $lesson->name =         $lesson_details->name;
                $lesson->descriptions = $lesson_details->descriptions;
                $lesson->link =         $lesson_details->link;
                $lesson->is_scheduler = $lesson_details->is_scheduler;
                $lesson->date =         $lesson_details->date;
                $lesson->form_date =    $lesson_details->form_date;
                $lesson->type =         $lesson_details->type;
                $lesson->type_video =   $lesson_details->type_video;
                $lesson->video_id_vdocipher =   $lesson_details->video_id_vdocipher;
                $lesson->long_video =   $lesson_details->long_video;
                $lesson->course_id  =   $request->course_id3;
                $lesson->section_id =   $request->section_id3;
                $lesson->status_laravel =1;
                $lesson->status_node    =1;
                $lesson->created_at    = now();
                $lesson->updated_at    =now()->subHours(2);
                
                
                
                if($request->date != null && $request->form_date != null){
                                    $lesson ->date                  = $dateTimeString;

                                    $form_date = str_replace(["ص", "م"], ["AM", "PM"], $form_date);

                                    $lesson ->form_date             = $form_date;
                                    // في قائمة الجدولة ولم يتم نشره
                                    $lesson -> is_scheduler = 0;
                }
                
                $lesson->save();


                $lesson->timestamps = true;   // Enable timestamps again

                $lessons_attachments= LessonAttachmetn::where('lesson_id',$lesson->id)->get();

                if($lessons_attachments->count() > 0){
                    foreach($lessons_attachments as $lessons_attach){
                        $new_lesson_attachment = new LessonAttachmetn();
                        $new_lesson_attachment->name_file = $lessons_attach->name_file;
                        $new_lesson_attachment->link      = $lessons_attach->link;
                        $new_lesson_attachment->lesson_id = $lesson->id;
                        $new_lesson_attachment->type      = $lessons_attach->type;
                        $new_lesson_attachment->save();
                    }
                }
                
            }else{
                return response()->json([
                    'status' => true,
                    'msg' => 'الدرس غير موجود',
                ]);
            }
        }

       

       

    

        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
        ]);


    }
 


    public function update_lessons(Request $request){


        $request->validate([
            'name'              => 'required',
            // 'link'              => 'required',
            'type'              => 'required',
            // 'course_id'         => 'required',
            // 'section_id'        => 'required',  
        ]);


        $lesson = Lesson::findorFail($request->id);

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        $section = Section::where('id',$lesson->section_id)->first();
        if($section){
            $course = Course::where('id',$section->course_id)->first();
            if($course){
                if($course->teacher_id != $teacher_id){
                    return response()->json([
                        'status' => false,
                        'msg' => 'لا يمكنك التعديل على هذا الدرس',
                    ]);
                }
            }
        }

        $lesson->timestamps = false;  // Disabling timestamps
   
        $lesson->name            = $request->name;
        $lesson->link            = $request->link;
        $lesson->type            = $request->type;
        $lesson->descriptions            = $request->descriptions;

        if(isset($request->course_id)){
            $lesson->course_id       = $request->course_id;
        }

        if(isset($request->section_id)){
            $lesson->section_id      = $request->section_id;
        }

        $lesson->save();

        $lesson->timestamps = true;   // Enable timestamps again

        if ($lesson) {
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

    public function destroy_lessons(Request $request){

        $lesson = Lesson::where('id',$request->id)->first();

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        $section = Section::where('id',$lesson->section_id)->first();
        if($section){
            $course = Course::where('id',$section->course_id)->first();
            if($course){
                if($course->teacher_id != $teacher_id){
                    return response()->json([
                        'status' => false,
                        'msg' => 'لا يمكنك حذف هذا الدرس',
                    ]);
                }
            }
        }

        $lesson->delete();
        
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
  

    public function add_attachments(Request $request){

        $request->validate([
            'name_file'              => 'required',
            'type_file'              => 'required',

        ]);

        $lesson = Lesson::where('id',$request->id)->first();

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        $section = Section::where('id',$lesson->section_id)->first();
        if($section){
            $course = Course::where('id',$section->course_id)->first();
            if($course){
                if($course->teacher_id != $teacher_id){
                    return response()->json([
                        'status' => false,
                        'msg' => 'غير مصرح بك ',
                    ]);
                }
            }
        }


        $add_attachmet = new LessonAttachmetn();

        $add_attachmet->name_file  = $request->name_file;
        $add_attachmet->lesson_id  = $request->id;
        $add_attachmet->type  = $request->type_file;

        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/attachment_lesson/'. $image_url );


             $add_attachmet -> link   = $base_url;

             $request->image-> move(public_path('attachments/attachment_lesson'), $image_url);

        }

        $add_attachmet->save();

        return response()->json([
            'status' => true,
            'msg' => 'added Successfully',
        ]);
    }

    public function destroy_attachmetns(Request $request){

        $attach = LessonAttachmetn::where('id',$request->id)->first();

        $attach->delete();

        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
