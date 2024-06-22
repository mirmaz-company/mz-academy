<?php

namespace App\Http\Controllers\Api;

use App\Models\Coupon;
use App\Models\CoponUsed;
use App\Models\CouponCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CouponController extends Controller
{
    public function test_coupon(Request $request){

        $coupon = CouponCode::where('name',$request->coupon)->first();

        
        if($coupon){


        if(Str::contains($request->coupon,$coupon->name)){
            
            $coupon_date = Coupon::where('id',$coupon->coupon_id)->first();


                $coupon_id_used = CoponUsed::where('coupon',$request->coupon)->where('user_id',Auth::guard('api')->user()->id)->first();

                if($coupon_id_used){

                    return response()->json([
                        'code'          => 401,
                        'status'        => false,
                        'message'       => 'لقد استخدمت هذا الكود من قبل',
                    
                    ]);
                }
                
            
         
           

            if($coupon_date->date_start != NULL && $coupon_date->date_end  != NULL){
              
                if (Carbon::now()->between($coupon_date->date_start, $coupon_date->date_end)) {
                   
                    $coupon['data'] = Coupon::where('id',$coupon->coupon_id)->first();
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data' => $coupon,
                 
                    ]);
                    
                  }else{
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'لم يتم الوقت بعد',
                 
                    ]);
                  }

            }elseif($coupon_date->date_start != NULL && $coupon_date->date_end == NULL){
              
                if (Carbon::now() > $coupon_date->date_start) {
                   
                    
                   
                    $coupon['data'] = Coupon::where('id',$coupon->coupon_id)->first();
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data' => $coupon,
                 
                    ]);
                    
                  }else{
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'لم يتم الوقت بعد',
                 
                    ]);
                  }

            
            }elseif($coupon_date->date_start == NULL && $coupon_date->date_end != NULL){
              
                if (Carbon::now() < $coupon_date->date_end) {
                   
                    
                   
                    $coupon['data'] = Coupon::where('id',$coupon->coupon_id)->first();
                    return response()->json([
                        'code'          => 200,
                        'status'        => true,
                        'message'       => 'fetch data succsessfully',
                        'data' => $coupon,
                 
                    ]);
                    
                  }else{
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'لم يتم الوقت بعد',
                 
                    ]);
                  }

            }else{
                $coupon['data'] = Coupon::where('id',$coupon->coupon_id)->first();
                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'fetch data succsessfully',
                    'data' => $coupon,
             
                ]);
            }
           

            $coupon['data'] = Coupon::where('id',$coupon->coupon_id)->first();
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data' => $coupon,
         
            ]);
        }else{
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'Not Found',
         
            ]);
        }
        }else{
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'Not Found',
         
            ]);
        }

    }
}
