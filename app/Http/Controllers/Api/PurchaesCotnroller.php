<?php

namespace App\Http\Controllers\Api;

use App\Models\City;
use App\Models\User;
use App\Models\Level;
use App\Models\Study;
use App\Models\Topic;
use App\Models\Comment;
use App\Models\Product;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\OnBoarding;
use App\Models\CommentLike;
use App\Models\DeliveryCard;
use Illuminate\Http\Request;
use App\Models\PurchasesCard;
use App\Models\LessonCommentReply;
use App\Models\PurchasesCardPrice;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PurchaesCotnroller extends Controller
{

    public function get_purchase(){

        try {
            $perchase = PurchasesCard::first();

            $perchase['cards'] = PurchasesCardPrice::all();
    
            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'fetch data succsessfully',
                'data' => $perchase,
         
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'code'          => 500,
                'status'        => false,
                'message'       => 'يوجد خطا ',
                'error'        => $th,
              
            ],500);
        }
    
    }


    public function add_purchase_order_card(Request $request){

        try {
            $order = new DeliveryCard();

            $order->name         = $request->name;
            $order->user_id      = Auth::guard('api')->user()->id;
            $order->mobile       = $request->mobile;

            $city = City::where('id',$request->city_id)->first();
          

            $order->city         =  $city->city;
            $order->address      = $request->address;
            $order->near_from    = $request->near_from;
            $order->type_card_id = $request->type_card_id;
            $order->price        = $city->price;
    
            $order->save();

            return response()->json([
                'code'          => 200,
                'status'        => true,
                'message'       => 'تم ارسال الطلب بنجاح',
             
         
            ]);
    
        
        } catch (\Throwable $th) {
            return response()->json([
                'code'          => 500,
                'status'        => false,
                'message'       => 'يوجد خطا ',
                'error'        => $th,
              
            ],500);
        }
   


    }


}
