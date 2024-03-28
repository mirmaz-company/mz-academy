<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostReplyComment extends Model
{
    use HasFactory;

 
    protected $table = 'post_reply_comment';

    // public function getCreatedAtAttribute($value){
    //     return Carbon::parse($value)->diffForHumans();
    // }

    protected $appends = ['user'];

    public function getUserAttribute(){
      
        $user = User::where('id',$this->user_id)->first(['id','name','image']);
        if($user){
            return $user;
        }else{
            return '-';
        }
       
    }

}
