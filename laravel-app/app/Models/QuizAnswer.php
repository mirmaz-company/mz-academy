<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'quiz_answers';

    public function toArray()
    {
        $array = parent::toArray();
        $array['qustion_id'] = (int)$this->qustion_id;
        $array['is_correct'] = (int)$this->is_correct;

        return $array;
    }
}
