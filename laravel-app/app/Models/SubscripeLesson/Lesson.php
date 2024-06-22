<?php

namespace App\Models\SubscripeLesson;

use App\Models\Quiz;
use App\Models\DataCourse;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';


    protected $appends = ['is_allow','progress','quiz'];

    public function getIsAllowAttribute(){

       return 'yes';
      
    
    }


    public function getProgressAttribute(){

        if(Auth::guard('api')->check()){
            $progress = DataCourse::where('user_id',Auth::guard('api')->user()->id)->where('lesson_id',$this->id)->first();
            if($progress){
                return $progress->progress;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function getQuizAttribute(){

     
            $quiz = Quiz::where('lesson_id',$this->id)->where('is_view',1)->orderBy('id','desc')->get(['id','name','type']);
            return $quiz;
    

      
    
    }



    

}


