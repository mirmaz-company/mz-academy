<?php

namespace App\Http\Controllers\Teachers;

use App\Models\City;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\NotificationTeacher;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotificationTeacherController extends Controller
{
    public function notification_teacher(){

        $notif = NotificationTeacher::where('teacher_id',Auth::guard('teachers')->user()->id)->where('seen',NULL)->get();

        foreach($notif as $n){
            $n->seen = now();
            $n->save();
        } 
        

        return view('notification_teacher.index');

    }


}
