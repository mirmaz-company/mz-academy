<?php

namespace App\Http\Controllers\Api;

use App\Models\Slider;
use App\Models\ViewApp;
use App\Models\SliderView;
use App\Models\SliderLevel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SliderController extends Controller
{
    public function get_sliders(){

        if(Auth::guard('api')->check()){

            $slider_my_level = SliderLevel::where('level_id',Auth::guard('api')->user()->level)->pluck('slider_id'); 
            
            $slider_for_all = SliderLevel::whereNotIn('slider_id',$slider_my_level)->pluck('slider_id'); 
        
            $slider = Slider::whereNotIn('id',$slider_for_all)->orWhereIn('id',$slider_my_level)->orderBy('id','desc')->get();

        }else{

            //  كل السلايدر ما عدا السلايدر التابع الى الليفل  
            $slider_level_ids = SliderLevel::pluck('slider_id'); 
            $slider = Slider::whereNotIn('id',$slider_level_ids)->orwhere('is_acess',1)->orderBy('id','desc')->get();
        }


        if(Auth::guard('api')->check()){

            $view_app = ViewApp::where('user_id',Auth::guard('api')->user()->id)->whereDate('created_at',now()->toDateString())->first();
            if(!$view_app){
                $view_app = new ViewApp();
                $view_app->user_id = Auth::guard('api')->user()->id;
                $view_app->save();

            }

            $user = User::find(Auth::guard('api')->user()->id);
            if($user){
                $user->views = $user->views + 1;
                $user->save();
            }
        }else{

            $view_app = new ViewApp();
            // غير معروف
            $view_app->user_id = 0;
            $view_app->save();


        }



       

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'products' => $slider,
     
        ]);
    }


    public function slider_view(Request $request){

        $slider = Slider::where('id',$request->slider_id)->first();
        if(!$slider){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'هذا السلايدر غير موجود',
         
            ]);
        }

        if(Auth::guard('api')->check()){

            $slider_view = SliderView::where('user_id',Auth::guard('api')->user()->id)->where('slider_id',$request->slider_id)->first();
     
            if(!$slider_view){
              
                $slider_views = new SliderView();
                $slider_views->user_id = Auth::guard('api')->user()->id;
                $slider_views->slider_id = $request->slider_id;
                $slider_views->save();

                $slider = Slider::where('id',$request->slider_id)->first();
                $slider->views = $slider->views + 1;
                $slider->save();


            }

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تمت العملية بنجاح',
         
            ]);


        }else{

            $slider = Slider::where('id',$request->slider_id)->first();
            $slider->ignore_views = $slider->ignore_views + 1;
            $slider->save();

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تمت العملية بنجاح',
         
            ]);
        }
    }
}
