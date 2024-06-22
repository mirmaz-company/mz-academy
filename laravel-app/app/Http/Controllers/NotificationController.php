<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class NotificationController extends Controller
{
    public function notifications(){
     
        return view('notifications.index');
    }
    
    public function get_all_notifications(Request $request)
    {
        if ($request->ajax()) {
            $data = Notification::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('send_to_person', function ($data) {
                    if(!$data->user_id== 0){
                    return '<a class="btn btn-warning btn-sm" data-toggle="modal" href="#inlineForm"
                    
                        data-id55   = "'. $data->user_id.'">
                    
                        <i class="fas fa-bell"></i> ارسال اشعار
                    </a>';
                    }
                 })
                ->addColumn('name', function ($data) {
                    if($data->user_id== 0){
                        return 'اشعار جماعي';
                    }else{

                        return '<a href="'.route("profile_user",$data->user_id).'">'.\App\Models\User::where('id',$data->user_id)->pluck('name')->first().'</a>';
                    
                    }
                 })

                 ->addColumn('created_at', function ($data) {
                    $date = date('d-m-Y / G:i', strtotime($data->created_at));

                    return $date;
                })

                 ->rawColumns(['send_to_person','name'])

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
            'sound' => "default"

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

    public function send_notification_a($users_fcm_token,$title,$body,$order_id)
    {
        $from = "AAAAO0HvF7s:APA91bGnIXUIMpeJNaZKtTlghSEIOM8igliowU1OABoNluaJDDJurbr65ywq9FCDTRGuwQ9f0vhEuOkkQ8kEv9dyJnU7NALxsw9clqY9Nbbaw1V08YLoqr8uMWTm_1nhBr370Kioz0Z8";
        $to = $users_fcm_token;

        $msg = array
        (
            'title' => $title,
            'body' => $body,
            'sound' => 'default' // add sound for iOS and Android

        );

        $fields = array
        (
            'registration_ids' => $users_fcm_token,
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

    public function send_notification_to_person(Request $request){
       
        $usernotification = \App\Models\Notification::create([
            'user_id' => $request->sendnotifi,
            'title' => $request->title,
            'body' =>  $request->body,
           ]);
    
           $users = User::findOrFail($request->sendnotifi);

           $this->send_notification($users->fcm_token, $request->title, $request->body, 0);
         
    
           return response()->json([
            'message3'            => 'تم ارسال اشعار',
            ]);
  
    }

    public function send_notification_all($token,$title,$body,$order_id)
    {
        $from = "AAAAO0HvF7s:APA91bGnIXUIMpeJNaZKtTlghSEIOM8igliowU1OABoNluaJDDJurbr65ywq9FCDTRGuwQ9f0vhEuOkkQ8kEv9dyJnU7NALxsw9clqY9Nbbaw1V08YLoqr8uMWTm_1nhBr370Kioz0Z8";
        $to = $token;

        $msg = array
        (
            'title' => $title,
            'body' => $body,
            'sound' => 'default' // add sound for iOS and Android

        );

        $fields = array
        (
            'to' => '/topics/all',
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


    public function send_notification_to_all(Request $request){
       
      $notifications = Notification::create([
            "user_id"      =>  0,
            "title"        => $request->title,
            "body"         => $request->body,
        ]);

     
        $this->send_notification_all('', $request->title, $request->body, 0);

       
        if ($notifications) {
            return response()->json([
                'status' => true,
                'msg' => 'تم الحفظ بنجاح',
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
