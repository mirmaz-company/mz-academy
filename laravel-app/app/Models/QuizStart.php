<?php

namespace App\Models;

use App\Models\QuizStartImage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizStart extends Model
{
    use HasFactory;

  
    protected $table = 'quiz_start';

    protected $appends = ['quiz_start_image'];

    public function getQuizStartImageAttribute(){
      
        $quiz_images = QuizStartImage::where('quiz_start_id',$this->id)->get();
   
        return $quiz_images;
       
    }


    public function toArray()
    {
        $array = parent::toArray();
        $array['quiz_id'] = (int)$this->quiz_id;
        $array['user_id'] = (int)$this->user_id;
        $array['attempt_count'] = (int)$this->attempt_count;
        $array['points'] = (int)$this->points;
        $array['points_discount_after_attempt'] = (int)$this->points_discount_after_attempt;
        $array['end_points'] = (int)$this->end_points;

        return $array;
    }
    
}
