<?php

namespace App\Http\Controllers\Api;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function all_notification(){
       

        $notifications = Notification::where('user_id',Auth::user()->id)->get();

        if(!$notifications){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
                'notifications' => $notifications,
         
            ]);
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'notifications' => $notifications,
     
        ]);

    }
    public function all_notification_new(){
       

        $notifications = Notification::where('user_id',Auth::user()->id)->paginate(10);

        if(!$notifications){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
                'notifications' => $notifications,
         
            ]);
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'fetch data succsessfully',
            'notifications' => $notifications,
     
        ]);

    }

    public function read_notification(Request $request){

        $notifications =  Notification::where('id',$request->notifications_id)->first();

        if(!$notifications){
            return response([
                'status'    =>false,
                'message'=>'not exist',
                'code'      =>404
            ]);
        }
        $notifications->read_at = now();

        $notifications->save();

        return response([
            'status'    =>true,
            'message'=>'قراءة الاشعار',
            'code'      =>200
        ]);

    }

    public function read_notification_for_all(){

        $notifications = Notification::where('user_id',Auth::user()->id)->get();

        if(!$notifications){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
            ]);
        }

        foreach($notifications as $notification){
            $notification->read_at = now();
            $notification->save();
        }

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'read all',
      
        ]);
    }

    public function delete_notifications(Request $request){
        $notifications = Notification::where('id',$request->notifications_id)->first();

        if(!$notifications){
            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
            ]);
        }

        $notifications->delete();
     

        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'deleted successfully',
      
        ]);
    }
}
