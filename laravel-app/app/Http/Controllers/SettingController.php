<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function setting_dashboard(){
        return view('settings.index');
    }

    public function dashboardsetting2(Request $request)
    {

        $settings = Setting::findorFail(1);
    

        if ($request->hasFile('image')) {

         

              //  اخزن اسم الصورة في الداتابيز
              $image_url =  $request->image->getClientOriginalName();
 
                 
              $base_url = url('attachments/logo/'. $image_url );


              $settings -> image   = $base_url;


              $request->image-> move(public_path('attachments/logo'), $image_url);

        }
        if ($request->hasFile('image_privacy')) {

         

              //  اخزن اسم الصورة في الداتابيز
              $image_url =  $request->image_privacy->getClientOriginalName();
 
                 
              $base_url = url('attachments/logo/'. $image_url );


              $settings -> image_privacy   = $base_url;


              $request->image_privacy-> move(public_path('attachments/logo'), $image_url);

        }
        if ($request->hasFile('image_about_us')) {

         

              //  اخزن اسم الصورة في الداتابيز
              $image_url =  $request->image_about_us->getClientOriginalName();
 
                 
              $base_url = url('attachments/logo/'. $image_url );


              $settings -> image_about_us   = $base_url;


              $request->image_about_us-> move(public_path('attachments/logo'), $image_url);

        }

       
        $settings->dashboardname          = $request->dashboardname;
        $settings->face_book              = $request->face_book;
        $settings->insta                  = $request->insta;
        $settings->mobile                 = $request->mobile;
        $settings->youtube                = $request->youtube;
     
        $settings->description_about_us   = $request->description_about_us;
        $settings->title_about_us         = $request->title_about_us;
        
        $settings->description_privacy    = $request->description_privacy;
        $settings->website    = $request->website;
        $settings->telegram    = $request->telegram;
        $settings->whatsapp    = $request->whatsapp;
        $settings->title_privacy          = $request->title_privacy;

        $settings->save();

      

        if ($settings) {
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
}
