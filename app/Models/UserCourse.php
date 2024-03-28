<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserCourse extends Model
{
    use HasFactory;

    use SoftDeletes;
    
    protected $table = 'user_courses';

    //   protected $appends = ['progress'];

    // public function getProgressAttribute(){
      
    //     $progress = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$this->course_id)->first();
    //     if($progress){
    //         return $progress->progress;
    //     }else{
    //         return 0;
    //     }
       
    // }


}
