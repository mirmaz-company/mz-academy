<?php

namespace App\Models;

use App\Models\Level;
use App\Models\Study;
use App\Models\TeacherStudy;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $guarded = [];
    
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $appends = ['study_name','level_name','has_rated_app','code_random','is_view_form'];

    public function getStudyNameAttribute(){

        $study_name = Study::where('id',$this->study)->pluck('name')->first();
        if( $study_name){
            return $study_name;
        }else{
            return NULL;
        }
      
    
    }
    public function getIsViewFormAttribute(){

        if(Auth::guard('api')->check()){
            $studn = StudentAreSaying::where('is_veiw_form',1)->where('user_id',Auth::guard('api')->user()->id)->orderBy('id','desc')->first();
            if( $studn){
                return $studn->is_veiw_form;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
       
      
    
    }
    public function getLevelNameAttribute(){

        $level_name = Level::where('id',$this->level)->pluck('name')->first();
        if( $level_name){
            return $level_name;
        }else{
            return NULL;
        }
      
    
    }
    public function getHasRatedAppAttribute(){

        $stud = StudentAreSaying::where('user_id',$this->id)->first();
        if( $stud){
            return 1;
        }else{
            return 0;
        }
      
    
    }
    public function getCodeRandomAttribute(){

       return rand('1111','9999');
      
    
    }
}
