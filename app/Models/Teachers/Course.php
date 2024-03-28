<?php

namespace App\Models\Teachers;

use App\Models\Teacher;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    protected $table = 'courses';



    protected $appends = ['show_notic'];

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
    
}
