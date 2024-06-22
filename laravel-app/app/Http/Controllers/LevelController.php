<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Level;
use App\Models\Study;
use App\Models\Subject;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class LevelController extends Controller
{
    public function levels($id = null){

     
        if($id == null){
          
            return view('levels.index');
        }else{
         
            return view('levels.index',compact('id'));
        }
      
    }

    public function get_all_levels(Request $request,$id=null)
    {
        if ($request->ajax()) {
            if($id == null){
                $data = Level::orderBy('created_at','asc');
            }else{
                $data = Level::where('study_id',$id)->orderBy('created_at','asc');
            }
         
            return Datatables::of($data)

                ->addIndexColumn()

            

                ->addColumn('subject_count', function ($data) {
                    $subject_count = Subject::where('level_id',$data->id)->count();
         
                    return '<a href="'.route('subjects',$data->id).'">'. $subject_count.'</a>';
           
                 })


                ->addColumn('action', function ($data) {
                    return view('levels.btn.action', compact('data'));
                })

            

                ->rawColumns(['image','subject_count'])

                ->make(true);
        }
    }


    public function get_levels_in_form_add($id){

        $levels = Level::where('study_id',$id)->get();
        return response()->json([
    
            'levels' => $levels,
           
           
        ]);
    }

    
    public function get_subjects_in_form_add($id){

        $levels_id = Level::where('study_id',$id)->pluck('id');
        $subjects = Subject::whereIn('level_id',$levels_id)->get();
        return response()->json([
    
            'subjects' => $subjects,
           
        ]);
    }

    public function store_levels(Request $request){
       
        $request->validate([
            'name'              => 'required',
            'study_id'        => 'required',
       
        ]);

     

        $level = new Level();

        $level ->name           = $request->name;
        $level ->study_id     = $request->study_id;

        $study_name = Study::where('id', $request->study_id)->first();
        if($study_name){
            $level ->study_name     = $study_name->name;
        }else{
            $level ->study_name = "";
        }


        $level -> save();

   

        if ($level) {
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


    public function update_levels(Request $request){



        $request->validate([
            'name'           => 'required',        
            'study_id'       => 'required',        
        ]);


        $level = Level::findorFail($request->id);

   
        $level->name            = $request->name;
        $level->study_id      = $request->study_id;


        $level->save();


        $subjectt = Subject::where('level_id',$request->id)->get();
        $levelss = Level::where('id',$request->id)->get();
        $studyy = Study::where('id',$request->study_id)->first();


        if($subjectt != NULL){
            foreach($subjectt as $sub){
                $sub->level_name = $request->name;
                $sub->study_name = $studyy->name;
                $sub->study_id = $request->study_id;
                $sub->save();
            }
        }
      

        foreach($levelss as $lev){
            $lev->study_name =  $studyy->name;
            $lev->save();
        }




        if ($level) {
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

    public function destroy_levels(Request $request){
           
        $level = Level::find($request->id);
        $level->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
