<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\VerifiedData;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AcceptUserController extends Controller
{
    public function accept_user(){
     
        return view('accept_user.index');
    }

    public function get_all_accept_user(Request $request)
    {
        if ($request->ajax()) {
            $data = VerifiedData::where('status',0)->latest()->get()->unique('user_id');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('personal_photo', function ($data) {
                  
                    $data_verified = VerifiedData::where('user_id',$data->user_id)->orderBy('id','desc')->first();
                    if($data_verified){
                        $btn1 =  '<img src="'.$data_verified->personal_photo.'" alt="" style="width:50%">';

                       $btn2 = '<a class="" data-toggle="modal" href="#personal_photo"

                                data-personal_photo="'. $data_verified->personal_photo .'"
                        > <i class="fa fa-eye"></i>  </a>';
                        return $btn2 . $btn1 ;

                    }
                    else{
                        return '-';
                    }
                })

                ->addColumn('front_image_id', function ($data) {
                    $data_verified = VerifiedData::where('user_id',$data->user_id)->orderBy('id','desc')->first();
                    if($data_verified){
                        $btn1 =  '<img src="'.$data_verified->front_image_id.'" alt="" style="width:50%">';

                        $btn2 = '<a class="" data-toggle="modal" href="#front_image_id"
 
                                 data-front_image_id="'. $data_verified->front_image_id .'"
                         > <i class="fa fa-eye"></i>  </a>';
                         return $btn2 . $btn1 ;
                    }
                    else{
                        return '-';
                    }
                })

                ->addColumn('back_image_id', function ($data) {
                    $data_verified = VerifiedData::where('user_id',$data->user_id)->orderBy('id','desc')->first();
                    if($data_verified){
                        $btn1 =  '<img src="'.$data_verified->back_image_id.'" alt="" style="width:50%">';

                        $btn2 = '<a class="" data-toggle="modal" href="#back_image_id"
 
                                 data-back_image_id="'. $data_verified->back_image_id .'"
                         > <i class="fa fa-eye"></i>  </a>';
                         return $btn2 . $btn1 ;
                    }
                    else{
                        return '-';
                    }
                })


                
                ->editColumn('created_at', function ($data) {
               
                    return $data->created_at->format('Y-m-d (h:i:s))');
                })


                ->addColumn('action', function ($data) {
                    return view('accept_user.btn.action', compact('data'));
                })
            

                ->rawColumns(['name','personal_photo','front_image_id','back_image_id'])

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


    public function update_cities(Request $request){


        $request->validate([
            'city'              => 'required',        
        ]);


        $city = City::findorFail($request->id);

   
        $city->city            = $request->city;

        $city->save();

        if ($city) {
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
