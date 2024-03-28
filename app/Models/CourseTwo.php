<?php

namespace App\Models;

use App\Models\Teacher;
use App\Models\CourseLike;
use App\Models\DataCourse;
use App\Models\UserCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CourseTwo extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'courses';


    protected $appends = ['level_name_dashboard'];


    public function getLevelNameDashboardAttribute()
    {
        $level= Level::Where('id',$this->level_id)->first();
        if($level){

            return $level->name ?? "-";
        }else{
            return '-';
        }
    }


}
