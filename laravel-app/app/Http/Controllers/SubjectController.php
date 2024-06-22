<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Level;
use App\Models\Study;
use App\Models\Subject;
use App\Models\TopicSubject;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;


class SubjectController extends Controller
{
    public function subjects($id = null){

        if($id == null){
            return view('subjects.index');
        }else{
            return view('subjects.index',compact('id'));
        }
     
       
    }

    public function get_all_subjects(Request $request,$id=null)
    {
        if ($request->ajax()) {

            if($id == null){
                $data = Subject::orderBy('id','desc');
            }else{
                $data = Subject::where('level_id',$id)->orderBy('id','desc');
            }
          
            return Datatables::of($data)

                ->addIndexColumn()


                
                  
                ->addColumn('image', function ($data) {
                    return  '<img src="'.$data->image.'" alt="" style="width:80%">';
                     
                  })


                ->addColumn('action', function ($data) {
                    return view('subjects.btn.action', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }




    public function store_subjects(Request $request){
       
        $request->validate([
            'name'              => 'required',
            'image'              => 'required',
            // 'topics'              => 'required',
            'level_id'              => 'required',
       
        ]);

        DB::beginTransaction();
        try {

        $subject = new Subject();
        $subject ->name                  = $request->name;
        $subject ->level_id              = $request->level_id;
        $subject ->study_id              = $request->study_id;


        $level_name = Level::where('id',$request->level_id)->first();
        if($level_name){
            $subject ->level_name =   $level_name->name;
        }else{
            $subject ->level_name = "-";
        }


        $study_name = Study::where('id',$request->study_id)->first();
        if($study_name){
            $subject ->study_name  = $study_name->name;
        }else{
            $subject ->study_name  = "-";
        }


      

        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/subjects/'. $image_url );


             $subject -> image   = $base_url;


             $request->image-> move(public_path('attachments/subjects'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

     }
        
        $subject -> save();

        if(isset($request->topics)){
            foreach($request->topics as $topic){
                $topic_subject = new TopicSubject();
                $topic_subject->subject_id = $subject->id;
                $topic_subject->topic_id = $topic;
                $topic_subject->save();
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
                'errors'       => $e,
                
            ]);

        }

       

   

        if ($subject) {
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


    public function edit($id){
        $subject = Subject::where('id',$id)->first();
        return view('subjects.edit',compact("subject"));
    }


    public function update_subjects(Request $request){


        $request->validate([
            'name'              => 'required',  
            'level_id'              => 'required',      
        ]);


        $subject = Subject::findorFail($request->id);

        DB::beginTransaction();
        try {   
        $subject->name            = $request->name;
        $subject->level_id            = $request->level_id;
        $subject->study_id            = $request->study_id;


        if ($request->hasFile('image')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/subjects/'. $image_url );


             $subject -> image   = $base_url;


             $request->image-> move(public_path('attachments/subjects'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
   

     }

        $subject->save();

        if(isset($request->topics)){
        // جبت كل الاهتمامات..عشان افحص اذا في اهتمام مش مبعوت ضمن الريكيوست احذفو
        $topic_delete = TopicSubject::whereNotIn('topic_id',$request->topics)->where('subject_id',$request->id)->pluck('topic_id');
   
        if($topic_delete != NULL){
            foreach($topic_delete as $topic_del){
                $topic_edit = TopicSubject::where('topic_id',$topic_del)->where('subject_id',$request->id)->first();
                if($topic_edit){
             
                    $topic_edit->delete();
                }
         }
        }


      
            foreach($request->topics as $topic){

                // اذا الاهتمام موجود بعدل عليه
                $topic_edit = TopicSubject::where('topic_id',$topic)->where('subject_id',$request->id)->first();
                
                if($topic_edit){
                    $topic_edit->topic_id = $topic;
                    $topic_edit->subject_id =$request->id;
                    $topic_edit->save();
                }else{
    
                  // اذا مش موجود بنشئ وحدة
                    $topic_edit = new TopicSubject();
                    $topic_edit->topic_id = $topic;
                    $topic_edit->subject_id = $request->id;
                    $topic_edit->save();
    
                }
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


        if ($subject) {
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

    public function destroy_subjects(Request $request){
           
        $subject = Subject::find($request->id);
        $subject->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
