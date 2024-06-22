<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReviewCourse extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'review_courses';


    public function getCommentAttribute($value){
        if($value == NULL){
               return '';
        }else{
                return $value;
        }
      }
}
