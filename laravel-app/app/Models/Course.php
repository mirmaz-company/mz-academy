<?php

namespace App\Models;

use App\Models\Teacher;
use App\Models\CourseLike;
use App\Models\DataCourse;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'courses';


    protected $appends = ['is_wishlist','total_price','teacher','subject_name','is_subscripe','progress','lastlesson','is_book_mark','my_rate','show_notic'];


    public function getIsWishlistAttribute(){

        if(Auth::guard('api')->check()){
            $user = CourseLike::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$this->id)->first();
            if($user){
                return $user->wishlist;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    
    }

    public function getShowNoticAttribute(){

        $teacher = Teacher::where('id',$this->teacher_id)->first();
        if($teacher){
            if( $teacher->show_notic == 1){

                if($this->type == "private"){
                    return 1; 
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    
      
    
    }
    



    public function getTotalPriceAttribute(){

      
        return $this->price - $this->discount;
           
     
     }
  
     public function getTeacherAttribute(){

      
      $teacher = Teacher::where('id',$this->teacher_id)->first();
      return $teacher;
           
     
    }

    public function getSubjectNameAttribute(){

      
        $subject = Subject::where('id',$this->subject_id)->pluck('name')->first();
        return $subject;
             
       
    }


    public function getProgressAttribute(){

        
      if(Auth::guard('api')->check()){
        $progress = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$this->id)->first();
        if($progress){
            return $progress->progress;
        }else{
            return 0;
        }
       
      }
      return 0;
       
             
       
    }


    public function getLastLessonAttribute(){

        if(Auth::guard('api')->check()){
            $last_lesson = DataCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$this->id)->orderBy('updated_at','desc')->first(['lesson_id']);
            if($last_lesson){
                return $last_lesson;
            }else{
                return null;
            }
        }else{
            return 0;
        }
       
             
       
    }
    
    
    
    public function getIsSubscripeAttribute(){

    if(Auth::guard('api')->check()){

            $is_subscripe = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$this->id)->first();

            if($is_subscripe){
                return 'is_subscripe';
            }else{
                return 'not_subscripe';
            }
            
        }else{
            return 'not_subscripe';
        }
    
    }
    public function getMyRateAttribute(){

        if(Auth::guard('api')->check()){

                $is_subscripe = ReviewCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$this->id)->first();

                if($is_subscripe){
                    return $is_subscripe->rate;
                }else{
                    return 0;
                }
                
            }else{
                return 0;
            }
        
    }


    public function getIsBookMarkAttribute(){
        if(Auth::guard('api')->check()){

            $is_subscripe = UserCourse::where('user_id',Auth::guard('api')->user()->id)->where('course_id',$this->id)->first();

            if($is_subscripe){

                return $is_subscripe->book_mark;
            }else{
                return 0;
            }

         
            
        }else{
            return 0;
        }
    
    }


}
