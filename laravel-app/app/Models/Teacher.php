<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory;
    use HasRoles;


    public $timestamps = false;
    
    protected $table = 'teachers';

    protected $guarded = [];

    protected $hidden = [
        'password',
        'password_show',

    
    ];


    protected $casts = [
        'roles_name' => 'array',
    ];


    protected $appends = ['subject_name','is_follow'];


    public function getSubjectNameAttribute(){

      
        $subject = Subject::where('id',$this->subject_id)->pluck('name')->first();
        return $subject;
             
       
      }
    public function getIsFollowAttribute(){

      if(Auth::guard('api')->check()){
        $is_follow = UserFollowTeacher::where('user_id',Auth::guard('api')->user()->id)->where('teacher_id',$this->id)->first();

        if($is_follow){
            return 'true';
        }else{
            return 'false';
        }
       
      }else{
        return 'false';
      }

     
             
       
      }
  
}
