<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $table = 'lessons';

    protected $guarded = [];

    protected $hidden = [
        'link',
    ];

    protected $appends = ['is_allow','quiz'];

    public function getIsAllowAttribute(){
        if($this->type == 'visable'){
            return 'yes';
        }
       return 'no';
    }

    public function getProgressAttribute(){
        if(Auth::guard('api')->check()){
            $user = Auth::guard('api')->user();
            $progress = DataCourse::where('user_id',$user->id)->where('lesson_id',$this->id)->first();
            
            if($progress){
                return $progress->progress;
            }else{
                return 0;
            }
          
        }
        return 0;
    } 
    
     public function appendProgressAttribute()
    {
        $this->appends[] = 'progress';
    }


    public function getQuizAttribute(){
        $quiz = Quiz::select(['id','name','type'])->where('lesson_id',$this->id)->where('is_view',1)->orderBy('id','desc')->get();
        return $quiz;
     }


    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}


