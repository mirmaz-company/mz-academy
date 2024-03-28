<?php

namespace App\Http\Controllers;

use PDF;
use Mail;
use App\Models\City;
use App\Models\User;
use App\Models\Level;
use App\Models\Course;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\CourseTwo;
use App\Models\UserCourse;
use App\Models\FormTeacher;
use App\Models\TeacherCode;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\TeacherStudy;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TeacherCodeSection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function teachers(){
    
        return view('teachers_admin.index');
    }

    public function get_all_teachers(Request $request)
    {
        if ($request->ajax()) {
            $data = Teacher::where('parent',0)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('subject_id', function ($data) {
                    $subject = Subject::where('id',$data->subject_id)->first();
                    return $subject->name ?? "-";
                })


                ->addColumn('is_acess', function ($data) {
                    return view('teachers_admin.btn.is_acess', compact('data'));
                })


                ->addColumn('show_notic', function ($data) {
                    return view('teachers_admin.btn.show_notic', compact('data'));
                })


            
                ->addColumn('send_email', function ($data) {
                    return view('teachers_admin.btn.action2', compact('data'));
                })


                ->addColumn('courses_count', function ($data) {
                    $course = Course::where('teacher_id',$data->id)->count();
                    return '<a href="'.route('courses',$data->id).'">'. $course.'</a>';
                   
                })


                ->addColumn('codes', function ($data) {
                    $codes = TeacherCode::where('teacher_id',$data->id)->count();
                   
                    return '<a href="'.route('sections_code',$data->id).'">'. $codes.'</a>';
                 
                })

                ->addColumn('ratio', function ($data) {
           
                   
                    return '<a href="'.route('ratio_teachers',$data->id).'">النسبة</a>';
                 
                })

                ->editColumn('total_subscriptions', function ($data) {
           
                    $teacher_courese = Course::where('teacher_id',$data->id)->pluck('id');

                    // عشان ما يحسب شركة مرماز من ضمن العدد
                    $user = User::where('mobile','009647703391199')->first();
                    $user_course_count = UserCourse::whereIn('course_id',$teacher_courese)->where('user_id','!=',$user->id)->count();

                    $teacher = Teacher::where('id',$data->id)->first();

                    // خزنا عدد المشتركين في جدول الاستاذ
                    if($teacher){
                        $teacher->total_subscriptions =  $user_course_count;
                        $teacher->save();
                    }

                    return $user_course_count;
                 
                })


                ->addColumn('image', function ($data) {
                    if($data->image != NULL){
                        return  '<img src="'.$data->image.'" alt="" style="width:100%">';
                    }else{
                        return  '<img src="'.asset('teacher.png').'" alt="" style="width:100%">';
                    }
                   
                     
                  })

                ->addColumn('action', function ($data) {
                    return view('teachers_admin.btn.action', compact('data'));
                })
                ->addColumn('conver_upload', function ($data) {
                    return view('teachers_admin.btn.action3', compact('data'));
                })

            

                ->rawColumns(['image','codes','courses_count','ratio'])

                ->make(true);
        }
    }

    public function conver_upload(Request $request){

        $teacher = Teacher::where('id',$request->id)->first();

        // يعني استاذ قديم ملوش فودسايفر..بنشئلو فودسايفر
        if($teacher->id_folder_vdosipher == NULL){
            // انشاء مجلد لل vdosipher
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dev.vdocipher.com/api/videos/folders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                // البارنت هو الايدي تبع المجلد الرئيسي
                "name" => $teacher->name,
                "parent" => "70e9faa755bb44fcb10370335af6158a"
            ]),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Apisecret BaKF1pCeOhosgNHLhWsHYZcRIGn8BDSbOTCUvb7yyCyJwWIGlcJJHd99U6rP7Sge",
                "Content-Type: application/json"
            ),
            ));

            $responsee = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);


            $responsee = json_decode($responsee);


            $teacher = Teacher::where('id',$teacher->id)->first();

            // بخزن اي دي المجلد الفرعي للفودوسايفر
            $teacher->id_folder_vdosipher =  $responsee->id;
            
        }

        $teacher->vdociper_or_bunny = $request->vdociper_or_bunny;
       

        $teacher->save();



        if ($teacher) {
            return response()->json([
                'status' => true,
                'msg' => 'تم التحويل بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => true,
                'msg' => 'يوجد مشكلة',
            ]);
        }
        
    }


    public function store_teachers(Request $request){
       
        $request->validate([
            'name'              => 'required',
            'email' => 'required|email|unique:teachers,email',
            'password'              => 'required',
            
            'ratio'              => 'required',
       
        ]);

        DB::beginTransaction();
        try {

            $input = $request->all(['name','email','password','ratio','specialization']);
                
                
            $input['password_show'] = $input['password'];
            $input['password'] = Hash::make($input['password']);
            // $input['study_id'] = $request->study_id;
            
            $teacher = Teacher::create($input);
            $teacher->assignRole($request->input('roles_name'));


            $teacher_study = new TeacherStudy();
            $teacher_study->teacher_id = $teacher->id;
            $teacher_study->study_id   = $request->study_id;
            $teacher_study->level_id   = $request->level_id;
            $teacher_study->subject_id = $request->subject_id;
            $teacher_study->save();

    
            // $teacher->assignRole($request->input('super_admin_teacher'));
            

            // ضفتو في جدول اليوزر عشان لما يضيف تعليق من اللوحة..اضيفو بناءا على هذا الحساب
            $teacher_user = new User();
            $teacher_user->name   = $request->name;
            $teacher_user->password   = "#$%%%#$%#$%#$%#$%#$";
            $teacher_user->type   = $teacher->id;
            $teacher_user->fcm_token   = "adsfasdfasdfasdf";
            $teacher_user->level   = 999999999;
            $teacher_user->study   = 999999999;
            $teacher_user->save();


            // بدي انشئ مكتبة على bunny
            // احتاج التوكن تبعت المصادقة عند انشاء المكتبة من صفحة الاعدادات ثم بضغط back وبلاقيها
          

            $client = new \GuzzleHttp\Client();

            $response = $client->request('POST', 'https://api.bunny.net/videolibrary', [
                'body' => '{"Name":"'.$teacher->name.'"}',
                'headers' => [
                'AccessKey' => '70044ab7-cc78-4a47-8c7c-68987111cbd5',
                'accept' => 'application/json',
                'content-type' => 'application/json',
                ],
            ]);

            $data = json_decode($response->getBody()); 

          

            $response2 = $client->request('GET', 'https://api.bunny.net/pullzone/'.$data->PullZoneId.'?includeCertificate=false', [
                'headers' => [
                  'AccessKey' => '70044ab7-cc78-4a47-8c7c-68987111cbd5',
                  'accept' => 'application/json',
                ],
              ]);

            $data2 = json_decode($response2->getBody()); 



            // انشاء مجلد لل vdosipher
            // انشاء مجلد لل vdosipher
            // انشاء مجلد لل vdosipher
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://dev.vdocipher.com/api/videos/folders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                // البارنت هو الايدي تبع المجلد الرئيسي
                "name" => $request->name,
                "parent" => "70e9faa755bb44fcb10370335af6158a"
            ]),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Authorization: Apisecret BaKF1pCeOhosgNHLhWsHYZcRIGn8BDSbOTCUvb7yyCyJwWIGlcJJHd99U6rP7Sge",
                "Content-Type: application/json"
            ),
            ));
    
            $responsee = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
        
            $responsee = json_decode($responsee);


            $teacher = Teacher::where('id',$teacher->id)->first();
            $teacher->library_id =  $data->Id;
            $teacher->access_key =  $data->ApiKey;
            $teacher->pull_zone =   $data2->Hostnames[0]->Value;
            // بخزن اي دي المجلد الفرعي للفودوسايفر
            $teacher->id_folder_vdosipher =  $responsee->id;
            $teacher->save();



        DB::commit();

        }

        catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'something error',
                'errors'       => $e,
                
            ]);

        }
   

        if ($teacher) {
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



    public function is_access(Request $request){
        $student = Teacher::where('id',$request->id)->first();
        

        if($student->is_acess == 0){
            $student ->is_acess = 1;
            $student ->save();

            $studentss = Teacher::where('parent',$request->id)->get();
            foreach( $studentss as $studentt){
                $studentt ->is_acess = 1;
                $studentt ->save();
            }

        }else{
        
            $student ->is_acess = 0;
            $student ->save();

            $studentss = Teacher::where('parent',$request->id)->get();
            foreach( $studentss as $studentt){
                $studentt ->is_acess = 0;
                $studentt ->save();
            }
            

        }

        return response()->json([
            'status' => true,
            'msg' => 'تمت التغيير بنجاح',
        ]);
        
        
    }


    public function show_notic(Request $request){
    
        $student = Teacher::where('id',$request->id)->first();
        

        if($student->show_notic == 0){
            $student ->show_notic = 1;
            $student ->save();

            $studentss = Teacher::where('parent',$request->id)->get();
            foreach( $studentss as $studentt){
                $studentt ->show_notic = 1;
                $studentt ->save();
            }

        }else{
        
            $student ->show_notic = 0;
            $student ->save();

            $studentss = Teacher::where('parent',$request->id)->get();
            foreach( $studentss as $studentt){
                $studentt ->show_notic = 0;
                $studentt ->save();
            }
            

        }

        return response()->json([
            'status' => true,
            'msg' => 'تمت التغيير بنجاح',
        ]);
        
        
    }


    public function update_teachers(Request $request){


        $request->validate([
            'name'              => 'required',
            'email' => 'required|email|unique:teachers,email,'. $request->id,
            'password'              => 'required',
              
        ]);


        $teacher = Teacher::findorFail($request->id);

   
        $teacher->name            = $request->name;
        $teacher->email           = $request->email;
        $teacher->specialization           = $request->specialization;
     
        if($request->password != $teacher->password){
            $teacher->password        = bcrypt($request->password);
            $teacher->password_show   = $request->password;
        }
     
     

        $teacher->save();

        if ($teacher) {
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


    public function create_codes(Request $request){
        if($request -> backage_private == "noraml"){
            $request->validate([
                'number_codes'              => 'required|numeric',
                'course_id'                 => 'required',
            ]);
        }else{
            $request->validate([
                'number_codes'              => 'required|numeric',
                'price_package'              => 'required|numeric',
            ]);
        }


        DB::beginTransaction();
        try {

        $section_code = new TeacherCodeSection();
        $section_code->teacher_id =  $request->teacher_id;
        if($request -> backage_private == "noraml"){
            // باقة عادية فيها كورس واحد
            $section_code->course_id =  $request->course_id;
        }else{
            // يعني باقة خاصة فيها عدة كورسات
            $section_code->course_id =  0;
            $section_code->name_course_section =  $request->name_package;

            // هذا السعر للباقة فقط
            // العادي عبارة عن سعر الدورة
            $section_code->price_package =  $request->price_package;
           
        }

        $section_code->number = $request->number_codes;
        $section_code->save();
       

        for($i =0 ; $i<$request->number_codes ; $i++){

            $teacher_code = new TeacherCode();
            $teacher_code->teacher_id = $request->teacher_id;
            $teacher_code->user_id =    0;
            $teacher_code->backage_private =  $request -> backage_private;

            if($request -> backage_private == "noraml"){
                // باقة عادية فيها كورس واحد
                $teacher_code->course_id  = $request->course_id;
            }else{
                // يعني باقة خاصة فيها عدة كورسات
                $teacher_code->course_id  = 0;
               
            }
           
            $teacher_code->section_code  = $section_code->id;

         
            $teacher_code->code =$request->teacher_id .  rand(111111111111,999999999999);

            if($request -> backage_private != "noraml"){
                $data = [];
                foreach($request->courses_id as $course){
                    $data[] = $course;
                }
                $data = json_encode($data);
                $teacher_code->courses_id = $data;
            }
            
            

            $teacher_code->save();

            $teacher_code4 = TeacherCode::where('id', $teacher_code->id)->first();
            $teacher_code4->serial  = $section_code->id."0000".$teacher_code->id;
            $teacher_code4->save();

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
      
        return response()->json([
            'status' => true,
            'msg' => 'created Successfully',
        ]);



    }


    public function get_courses(Request $request){
    

        $courses = CourseTwo::where('teacher_id',$request->id_teacher)->where('type','private')->get();
        return response()->json([
    
            'courses' => $courses,
           
           
        ]);
    }

    public function destroy_teachers(Request $request){
           
        $teacher = Teacher::find($request->id);
        $teacher->delete();

        $courses = Course::where('teacher_id',$request->id)->pluck('id');

        foreach($courses as $course){
            $cour = Course::where('id',$course)->first();
            $cour->delete();
        }
        
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }


    public function get_levels_from_study($id){
        $levels = Level::Where('study_id',$id)->get();

        return response()->json([
            'levels' => $levels,
        ]);
    }
    public function get_sujects_from_level($id){
        $subjects = Subject::Where('level_id',$id)->get();

        return response()->json([
            'subjects' => $subjects,
        ]);
    }


    public function add_new_subject_to_teacher(Request $request){

       $teacher_study = TeacherStudy::where('teacher_id',$request->id)->where('level_id',$request->level_id2)->where('subject_id',$request->subject_id2)->first();

        if(!$teacher_study){


            $teacher_study = new TeacherStudy();
            $teacher_study->teacher_id = $request->id;
            $teacher_study->study_id   = $request->study_id2;
            $teacher_study->level_id   = $request->level_id2;
            $teacher_study->subject_id = $request->subject_id2;
            $teacher_study->save();

            return response()->json([
                'status'    => true,
                'message' => 'تمت الاضافة بنجاح',
            ]);



        }else{

            return response()->json([
                'status'    => false,
                'message' => 'يوجد المادة الدراسية مسبقا',
            ]);

        }

    }


    public function form_teacher(Request $request){

      
        try {
            $validator = Validator::make($request->all(), [
            
                'email' => 'email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status'    => "email_error",
                    'message' => ' الايميل غير صالح',
                
                ]);
            }

            $validator = Validator::make($request->all(), [
            
                'phone' => 'digits_between:10,11',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'    => "mobile_error",
                    'message' => 'تحقق من رقم الجوال',
                
                ]);
            }
         

                $is_found = FormTeacher::Where('email',$request->email)->Where('phone',$request->phone)->first();
                if($is_found){
                    return response()->json([
                        'status'    => "is_found3",
                        'message' => ' الايميل والجوال مسوجودين مسبقا ',
                    
                    ]);
                }

                $is_found = FormTeacher::Where('email',$request->email)->first();
                if($is_found){
                    return response()->json([
                        'status'    => "is_found",
                        'message' => 'الايميل موجود مسبقا ',
                       
                    ]);
                }
                $is_found = FormTeacher::Where('phone',$request->phone)->first();
                if($is_found){
                    return response()->json([
                        'status'    => "is_found2",
                        'message' => 'الجوال موجود مسبقا ',
                       
                    ]);
                }

                $form_teacher = new FormTeacher();
                $form_teacher->address           =  $request->address;
                $form_teacher->collection_school =  $request->collection_school;
                $form_teacher->email =              $request->email;
                $form_teacher->governorate =        $request->governorate;
                $form_teacher->level =              $request->level;
                $form_teacher->name =               $request->name;
                $form_teacher->phone =              $request->phone;
                $form_teacher->subject =            $request->subject;
                $form_teacher->save();

                return response()->json([
                    'status'    => true,
                    'message' => 'تمت الاضافة بنجاح',
                    'id' => $form_teacher->id,
                ]);

        }

        catch (\Exception $e) {
        
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'something error',
                
            ]);

        }

    }


    public function book_pdf(){
        return Response::make(file_get_contents(base_path("public/book.pdf")), 200, [
            'content-type'=>'application/pdf',
        ]);
    }


    public function generate_pdf(Request $request){
       
            $form_teacher = FormTeacher::where('id',$request->id)->first();
            $pdf = PDF::loadView('form_teacher.invoice',compact('form_teacher'));
            return $pdf->download('مرماز اكاديمي.pdf');
        
      
    }
    public function generate_pdf_admin($id){
       
            $form_teacher = FormTeacher::where('id',$id)->first();
            $pdf = PDF::loadView('form_teacher.invoice',compact('form_teacher'));
            return $pdf->download('مرماز اكاديمي.pdf');
        
      
    }


    public function send_mail(Request $request){

        $teacher = Teacher::Where('email',$request->email)->first();
        $details = [
            'email' => $request->email,
            'password' => $teacher->password_show
        ];
       
        Mail::to($request->email)->send(new \App\Mail\MyTestMail($details));

        $teacher = Teacher::where('email',$request->email)->first();
        $teacher->count_send_email = $teacher->count_send_email + 1;
        $teacher->save();
       
        return response()->json([
            'status'    => true,
            'message' => 'تم الارسال بنجاح',
        ]);

   
    }


}
