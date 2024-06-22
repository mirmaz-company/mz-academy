<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerQuiz extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'answer_quiz';


    public function toArray()
    {
        $array = parent::toArray();
        $array['quiz_id'] = (int)$this->quiz_id;

        return $array;
    }
}
