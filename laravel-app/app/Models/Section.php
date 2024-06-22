<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Section extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'sections';
    

public function lessons()
{ 
    return $this->hasMany(Lesson::class);
}



    // protected $appends = ['progress'];
     
    
    // public function getProgressAttribute(){
  
    // $progress = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$this->course_id)->first();
    // if($progress){
    //     return $progress->progress;
    // }else{
    //     return 0;
    // }
   

}
