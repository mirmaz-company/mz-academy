<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Section;
use App\Models\SectionTwo;
use Illuminate\Http\Request;
use App\Models\LessonAttachmetn;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class SectionController extends Controller
{
    public function sections($id = null){
     
        if($id == null){
            return view('teachers.sections.index');
        }else{
            $id = Crypt::decrypt($id);   
            return view('teachers.sections.index',compact('id'));
        }
          
    }

    public function get_all_sections(Request $request,$id=null)
    {
        if ($request->ajax()) {
            if($id == null){
                $course_teacher = Course::where('teacher_id',Auth::guard('teachers')->user()->id)->orWhere('teacher_id',Auth::guard('teachers')->user()->parent)->pluck('id');
                $data = SectionTwo::whereIn('course_id',$course_teacher)->orderBy('id','desc');
            }else{
                $data = SectionTwo::where('course_id',$id)->orderBy('id','desc');
            }
        
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('count_lessons', function ($data) {
                    $lessons_cont = Lesson::where('section_id',$data->id)->where(function ($query) {
                            $query->where('link', '!=', NULL)
                            ->orWhere('resulotion_update', '!=', 0);
                        })->where('status_laravel',1)->where('status_node',1)->count();

                    $id= Crypt::encrypt($data->id);
                    return '<a href="'.route('teachers.lessons',$id).'">'. $lessons_cont.'</a>';
                })
                
                ->addColumn('name_course', function ($data) {
                     $course = Course::where('id',$data->course_id)->first();
                     return $course->name ?? "-";
                })
                
                ->addColumn('section_hours', function ($data) {
                     $vdeocipher_lessons_hours = Lesson::where('section_id',$data->id)->where(function ($query) {
                            $query->where('link', '!=', NULL)
                            ->orWhere('resulotion_update', '!=', 0);
                        })->where('status_laravel',1)->where('status_node',1)->where('long_video', '!=', 'null')->sum('long_video');

    
                  
                        return $this->convertDuration($vdeocipher_lessons_hours) ?? 0;
                    
                   
                    
                })


                ->addColumn('action', function ($data) {
                    return view('teachers.sections.btn.action', compact('data'));
                })

            

                ->rawColumns(['image','count_lessons'])

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


    public function add_section_to_course(Request $request){

        $section = Section::where('id',$request->id)->first();

    

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

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

        $new_section = new Section();
        $new_section->name =  $section->name;
        $new_section->course_id =  $request->course_id;
        $new_section->save();

        $lessons= Lesson::where('section_id',$request->id)->where('status_laravel',1)->where('status_node',1)->get();

        foreach($lessons as $lesson){

            $new_lesson = new Lesson();

            $new_lesson->timestamps = false;  // Disabling timestamps

            $new_lesson->name =         $lesson->name;
            $new_lesson->descriptions = $lesson->descriptions;
            $new_lesson->link =         $lesson->link;
            $new_lesson->is_scheduler = $lesson->is_scheduler;
            $new_lesson->date =         $lesson->date;
            $new_lesson->form_date =    $lesson->form_date;
            $new_lesson->type =         $lesson->type;
            $new_lesson->video_id_vdocipher =   $lesson->video_id_vdocipher;
            $new_lesson->long_video =   $lesson->long_video;
            $new_lesson->type_video =   $lesson->type_video;
            $new_lesson->course_id  =   $request->course_id;
            $new_lesson->section_id =   $new_section->id;  
            $new_lesson->status_laravel =1;
            $new_lesson->status_node    =1;
            $new_lesson->created_at    = now();
            $new_lesson->updated_at    =now()->subHours(2);
            $new_lesson->save();

            $new_lesson->timestamps = true;   // Enable timestamps again


            $lessons_attachments= LessonAttachmetn::where('lesson_id',$lesson->id)->get();
            if($lessons_attachments->count() > 0){
                foreach($lessons_attachments as $lessons_attach){
                    $new_lesson_attachment = new LessonAttachmetn();
                    $new_lesson_attachment->name_file = $lessons_attach->name_file;
                    $new_lesson_attachment->link      = $lessons_attach->link;
                    $new_lesson_attachment->lesson_id = $new_lesson->id;
                    $new_lesson_attachment->type      = $lessons_attach->type;
                    $new_lesson_attachment->save();
                }
            }
          
        }

        return response()->json([
            'status' => true,
            'msg' => 'تمت الاضافة بنجاح',
        ]);



    }



    public function store_sections(Request $request){
       
        $request->validate([
            'name'              => 'required',
        ]);

     

        $section = new SectionTwo();

        $section ->course_id        = $request->course_id;
        $section ->name             = $request->name;

        
        $section -> save();

   

        if ($section) {
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


    public function update_sections(Request $request){


        $request->validate([
            'name'              => 'required',        
        ]);


        $section = SectionTwo::findorFail($request->id);

        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        $section = SectionTwo::find($request->id);

        if($section){
            $course = Course::where('id',$section->course_id)->first();

            if($course->teacher_id != $teacher_id){
                return response()->json([
                    'status' => false,
                    'msg' => 'غير مسموح لك بالتعديل',
                ]);
            }
        }

   
        $section->name            = $request->name;
        $section->course_id       = $request->course_id;

        $section->save();

        if ($section) {
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

    public function destroy_sections(Request $request){
           
        if(Auth::guard('teachers')->user()->parent == 0){
            $teacher_id = Auth::guard('teachers')->user()->id;
        }else{
            $teacher_id = Auth::guard('teachers')->user()->parent;
        }

        $section = SectionTwo::find($request->id);

        if($section){
            $course = Course::where('id',$section->course_id)->first();

            if($course->teacher_id != $teacher_id){
                return response()->json([
                    'status' => false,
                    'msg' => 'غير مسموح لك بالحذف',
                ]);
            }
        }
       

        $section->delete();

        Lesson::where('section_id',$request->id)->delete();

        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }


    public function get_sections($id){

        $course = Course::where('id',$id)->first();
        $sections = SectionTwo::where('course_id',$id)->get();
        return response()->json([
    
            'sections' => $sections,
            'type' => $course->type,
           
           
        ]);
    }
    
}
