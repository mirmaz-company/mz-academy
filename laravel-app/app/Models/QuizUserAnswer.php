<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizUserAnswer extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'quiz_user_answers';

    public function toArray()
    {
        $array = parent::toArray();
        $array['user_id'] = (int)$this->user_id;
        $array['quiz_id'] = (int)$this->quiz_id;
        $array['my_attempt'] = (int)$this->my_attempt;
        $array['qustion_id'] = (int)$this->qustion_id;
        $array['answer_id'] = (int)$this->answer_id;
        $array['your_answer'] = (int)$this->your_answer;

        return $array;
    }

}
