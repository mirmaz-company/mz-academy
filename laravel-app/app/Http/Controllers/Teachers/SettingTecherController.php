<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SettingTecherController extends Controller
{
    public function settings_teacher(){
  
        return view('teachers.settings_teacher.index');
    }

    public function get_all_cities(Request $request)
    {
        if ($request->ajax()) {
            $data = City::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('teachers.cities.btn.action', compact('data'));
                })

            

                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_cities(Request $request){
       
        $request->validate([
            'city'              => 'required',
       
        ]);

     

        $city = new City();
        $city ->city                  = $request->city;

        
        $city -> save();

   

        if ($city) {
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


    public function update_settings_teacher(Request $request){

    

        $request->validate([
            'name'              => 'required',        
            'email'              => 'required',   
            'password'              => 'required',   
         
            'descriptions'              => 'required|string|min:3|max:240',   
        ]);


        $teacher = Teacher::findorFail($request->id);

   
        $teacher->name                    = $request->name;
        $teacher->email                   = $request->email;
        $teacher->descriptions            = $request->descriptions;
        $teacher->telegram                = $request->telegram;

        if ($request->password == $teacher->password_show) {
         
        } else {
            $teacher->password    = bcrypt($request->password);
            $teacher->password_show =    $request->password;
        }
      


        if ($request->hasFile('image')) {
          
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/teacher_image/'. $image_url );


             $teacher -> image   = $base_url;


             $request->image-> move(public_path('attachments/teacher_image'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);

            
             $teacher->is_image1_added            = 1;

        }
        if ($request->hasFile('image_cover')) {
            
            //  اخزن اسم الصورة في الداتابيز
             $image_url =  $request->image_cover->getClientOriginalName();

             $image_url =  rand(223423,23423444) . $image_url;

             
             $base_url = url('attachments/image_cover/'. $image_url );


             $teacher -> image_cover   = $base_url;


             $request->image_cover-> move(public_path('attachments/image_cover'), $image_url);
               //  اخزن الصورة في السيرفر
             //  $request->image->move('attachments/sliders/', $image_url);
             $teacher->is_image2_added            = 1;
             
        }
        


        $teacher->save();

        if(Auth::guard('teachers')->user()->parent == 0){
            $user = User::where('type',$request->id)->first();
            $user->name =  $teacher->name;
            $user->image = $teacher->image;
            $user->save();
        }

       

        if(Auth::guard('teachers')->user()->is_complete == 0){

            if($teacher->is_image1_added  == 1 ){
                $teacherx = Teacher::findorFail($request->id);
                $teacherx -> is_complete   = 1;
                $teacherx->save();

            }
            
        }



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

    public function destroy_cities(Request $request){
           
        $city = City::find($request->id);
        $city->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
