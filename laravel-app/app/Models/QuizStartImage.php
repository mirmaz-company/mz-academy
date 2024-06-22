<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizStartImage extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'quiz_start_images';

}
