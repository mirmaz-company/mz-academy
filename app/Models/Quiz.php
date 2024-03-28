<?php

namespace App\Models;

use App\Models\QuizStart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quiz extends Model
{
    use HasFactory;

    // public $timestamps = false;
    
    protected $table = 'quiz';

    protected $appends = ['end_points'];

    public function getEndPointsAttribute(){
      
        if(Auth::guard('api')->check()){
            $quiz = QuizStart::where('quiz_id',$this->id)->where('user_id',Auth::guard('api')->user()->id)->orderBy('id','desc')->first();
            if($quiz){
                return $quiz;
            }else{
                return null;
            }
        }else{
            return null;
        }
        
       
    }


    public function toArray()
    {
        $array = parent::toArray();
        $array['qustion_count'] = (int)$this->qustion_count;
        $array['attempt_count'] = (int)$this->attempt_count;
        $array['points'] = (int)$this->points;
        $array['points_after_discount'] = (int)$this->points_after_discount;
        $array['points_after_discount'] = (int)$this->points_after_discount;
        $array['is_view'] = (int)$this->is_view;
        $array['lesson_id'] = (int)$this->lesson_id;
        $array['time'] = (int)$this->time;
    
        $array['remaining_attempt_for_user'] = (int)$this->remaining_attempt_for_user;

        return $array;
    }

}
