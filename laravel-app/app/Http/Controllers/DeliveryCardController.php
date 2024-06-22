<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\User;
use App\Models\DeliveryCard;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\PurchasesCardPrice;

class DeliveryCardController extends Controller
{
    public function delivery_card(){

        return view('delivery_card.index');
    }

    public function get_all_delivery_card(Request $request)
    {
        if ($request->ajax()) {
            $data = DeliveryCard::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()


                ->editColumn('type_card_id', function ($data) {
                    $purshase_card_price = PurchasesCardPrice::where('id',$data->type_card_id)->first();
                    if($purshase_card_price){
                        return $purshase_card_price->price ?? "-";
                    }
                    return '-';
                })


                ->addColumn('created_at', function ($data) {
                    return $data->created_at->format('Y/m/d H:i:s');
                })


                ->addColumn('status_now', function ($data) {
                    $purshase_card_price = DeliveryCard::where('id',$data->id)->first();
                    if($purshase_card_price){
                        if($purshase_card_price->status == "new"){
                            return "طلب جديد";
                        }
                        if($purshase_card_price->status == "accept"){
                            return '<span style="color:green"> تم القبول</span>';
                        }
                        if($purshase_card_price->status == "deny"){

                           return '<span style="color:red"> الطلب مرفوض</span>';
                        }
                        if($purshase_card_price->status == "delivery"){
                            return " جاري توصيل الطلب الان";
                        }
                        if($purshase_card_price->status == "done"){
                            return "انتهى";
                        }
                        if($purshase_card_price->status == "cancel"){
                            return "تم الغاء الطلب";
                        }
                    }
                })


                ->addColumn('action', function ($data) {
                    return view('delivery_card.btn.action', compact('data'));
                })



                ->rawColumns(['image','status_now'])

                ->make(true);
        }
    }

    public function send_notification($token,$title,$body,$order_id)
    {
        $from = "AAAAO0HvF7s:APA91bGnIXUIMpeJNaZKtTlghSEIOM8igliowU1OABoNluaJDDJurbr65ywq9FCDTRGuwQ9f0vhEuOkkQ8kEv9dyJnU7NALxsw9clqY9Nbbaw1V08YLoqr8uMWTm_1nhBr370Kioz0Z8";
        $to = $token;

        $msg = array
        (
            'title' => $title,
            'body' => $body,
            'sound' => 'default',

        );

        $fields = array
        (
            'to' => $token,
            'notification' => $msg,
            'data' => [
                'bookingId' => $order_id,
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "screen" =>  "POST_SCREEN",

            ]
        );


        $headers = array
        (
            'Authorization: key=' . $from,
            'Content-Type: application/json'
        );
        //#Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;

    }

    public function accept_price_card(Request $request){
        
        $delivery = DeliveryCard::where('id',$request->id)->first();


        if($delivery){
            
            $delivery->status = "accept";
            $delivery->save();

            
            $pur = PurchasesCardPrice::where('id',$delivery->type_card_id)->first();

            if($pur){
                $title = $pur->price."طلب بطاقة شحن بسعر";
            }else{
                $title = "طلب بطاقة شحن ";
            }

            $body  = "تم قبول الطلب";

            $usernotification = \App\Models\Notification::create([
                'user_id' => $request->user_id,
                'title'   => $title,
                'body'    =>$body,
            ]);
        
            $user = User::findOrFail($request->user_id);

            $this->send_notification($user->fcm_token, $title, $body, 0);

            return response()->json([
                'status' => true,
                'msg' => 'تمت القبول بنجاح',
            ]);
        }

       
    }



    public function cancel_price_card(Request $request){

     
        
        $delivery = DeliveryCard::where('id',$request->id)->first();


        if($delivery){
            
            $delivery->status = "cancel";
            $delivery->save();

           
            $pur = PurchasesCardPrice::where('id',$delivery->type_card_id)->first();

            if($pur){
                $title = $pur->price."طلب بطاقة شحن بسعر";
            }else{
                $title = "طلب بطاقة شحن ";
            }

            $body  = "تم الغاء الطلب";


            $usernotification = \App\Models\Notification::create([
                'user_id' => $request->user_id,
                'title'   => $title,
                'body'    =>$body,
            ]);
        
            $user = User::findOrFail($request->user_id);

            $this->send_notification($user->fcm_token, $title, $body, 0);

            return response()->json([
                'status' => true,
                'msg' => 'تم الغاء الطلب بنجاح',
            ]);
        }

       
    }


    public function deny_price_card(Request $request){
        
        $delivery = DeliveryCard::where('id',$request->id)->first();

        $pur = PurchasesCardPrice::where('id',$delivery->type_card_id)->first();

        if($pur){
            $title = $pur->price."طلب بطاقة شحن بسعر";
        }else{
            $title = "طلب بطاقة شحن ";
        }

        $body  = "تم رفض الطلب ";

        $usernotification = \App\Models\Notification::create([
            'user_id' => $request->user_id,
            'title'   => $title,
            'body'    =>$body,
           ]);
    
        $user = User::findOrFail($request->user_id);

        $this->send_notification($user->fcm_token, $title, $body, 0);



        if($delivery){
            $delivery->status = "deny";
            $delivery->save();

            return response()->json([
                'status' => true,
                'msg' => 'تمت الرفض بنجاح',
            ]);
        }

       
    }

    public function delivery_price_card(Request $request){
        
        $delivery = DeliveryCard::where('id',$request->id)->first();

        $pur = PurchasesCardPrice::where('id',$delivery->type_card_id)->first();

        if($pur){
            $title = $pur->price."طلب بطاقة شحن بسعر";
        }else{
            $title = "طلب بطاقة شحن ";
        }

        $body  = "الطلب قيد التوصيل.. ";

        $usernotification = \App\Models\Notification::create([
            'user_id' => $request->user_id,
            'title'   => $title,
            'body'    =>$body,
           ]);
    
        $user = User::findOrFail($request->user_id);

        $this->send_notification($user->fcm_token, $title, $body, 0);

        if($delivery){
            $delivery->status = "delivery";
            $delivery->save();

            return response()->json([
                'status' => true,
                'msg' => 'تمت delivery بنجاح',
            ]);
        }

       
    }


    public function done_price_card(Request $request){
        
        $delivery = DeliveryCard::where('id',$request->id)->first();

        $pur = PurchasesCardPrice::where('id',$delivery->type_card_id)->first();

        if($pur){
            $title = $pur->price."طلب بطاقة شحن بسعر";
        }else{
            $title = "طلب بطاقة شحن ";
        }

        $body  = "تم استلام الطلب بنجاح";

        $user = User::findOrFail($request->user_id);

        if($user){

            $usernotification = \App\Models\Notification::create([
                'user_id' => $request->user_id,
                'title'   => $title,
                'body'    =>$body,
            ]);
        
        

            $this->send_notification($user->fcm_token, $title, $body, 0);

            if($delivery){
                $delivery->status = "done";
                $delivery->save();

                return response()->json([
                    'status' => true,
                    'msg' => 'تمت done بنجاح',
                ]);
            }
        }

       
    }


}
