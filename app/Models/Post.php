<?php

namespace App\Models;


use App\Models\User;
use App\Models\Teacher;

use App\Models\PostUserLike;
use App\Models\PostShareUser;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    
    protected $table = 'posts';

    public function images()
    {
        return $this->hasMany('App\Models\PostImage','post_id','id');
    }

    public function two_comments()
    {
        return $this->hasMany('App\Models\PostComment','post_id','id')->take(2);
    }

    // public function getCreatedAtAttribute($value){
    //     return Carbon::parse($value)->diffForHumans();
    // }


    protected $appends = ['teacher','is_like','is_share','person_images'];

    public function getTeacherAttribute(){
      
        if($this->teacher_id == 0){
            return ['name' => 'مرماز أكاديمي', 'image' => 'https://mz-academy.com/400.png'];
        }
        
        $teacher = Teacher::where('id',$this->teacher_id)->first(['id','name','email','image']);
        if($teacher){
            return $teacher;
        }else{
            return '-';
        }
       
    }
    public function getIsLikeAttribute(){
      
        if(Auth::guard('api')->check()){
            $like = PostUserLike::where('user_id',Auth::guard('api')->user()->id)->where('post_id',$this->id)->first();
            if($like){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
      
       
    }
    public function getIsShareAttribute(){
      
        if(Auth::guard('api')->check()){
            $like = PostShareUser::where('user_id',Auth::guard('api')->user()->id)->where('post_id',$this->id)->first();
            if($like){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
       
    }
    public function getPersonImagesAttribute(){

        if(Auth::guard('api')->check()){
      
            $like = PostUserLike::where('user_id',Auth::guard('api')->user()->id)->where('post_id',$this->id)->take(5)->pluck('user_id');
            
            
            $images = User::whereIn('id',$like)->take(5)->get(['image','id']);


            
            return $images;
        }else{
            return [];
        }
       
       
    }
}
