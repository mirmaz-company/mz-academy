<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Models\PostLikeComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostComment extends Model
{
    use HasFactory;

    
    protected $table = 'post_comments';

    // public function getCreatedAtAttribute($value){
    //     return Carbon::parse($value)->diffForHumans();
    // }

    protected $appends = ['user','is_like','person_images'];

    public function getUserAttribute(){
      
        $user = User::where('id',$this->user_id)->first(['id','name','image']);
        if($user){
            return $user;
        }else{
            return '-';
        }
       
    }

    public function getIsLikeAttribute(){
      
        if(Auth::guard('api')->check()){
            $like = PostLikeComment::where('user_id',Auth::guard('api')->user()->id)->where('comment_id',$this->id)->first();
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
            $like = PostLikeComment::where('user_id',Auth::guard('api')->user()->id)->where('comment_id',$this->id)->take(5)->pluck('user_id');
        
        
            $images = User::whereIn('id',$like)->take(5)->get(['image','id']);
    
    
            
            return $images;

        }else{
            return [];
        }
      
    
       
       
    }
}
