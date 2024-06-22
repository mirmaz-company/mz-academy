<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Lesson;
use App\Models\Slider;
use App\Models\Section;
use App\Models\UserCourse;
use App\Models\Notification;
use App\Models\Teachers\Course;
use Illuminate\Console\Command;
use App\Helpers\NotificationHelper;
use App\Models\Teacher;

class PublishLesson extends Command
{
  
    protected $signature = 'lesson:publish';


    protected $description = 'Publishes a new lesson.';

   
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {


        // المحاضرات المجدولة 
        $lessons_sch = Lesson::where('is_scheduler',0)->where('status_node',1)->where('resulotion_update','!=',3)->get();

        foreach($lessons_sch as $lesson){

            $lesson->timestamps = false;  // Disabling timestamps
            $current_time = Carbon::now();
            $lesson_date_time = Carbon::createFromFormat('Y-m-d h:i A', $lesson->date.' '.$lesson->form_date);
    
            // يعني صار الوقت نفس الوقت او اقل
            if ($lesson_date_time->lte($current_time)) {
                $lesson->is_scheduler = 1;
                // تم ارسال اشعار
                $lesson->is_notify = 1;
                $lesson->save();
                $lesson->timestamps = true; 

                $lesson =   Lesson::where('id',$lesson->id)->first();
                $section =  Section::where('id',$lesson->section_id)->first();
                $course =   Course::where('id',$section->course_id)->first();
    
    
                $user_course = UserCourse::where('course_id',$course->id)->pluck('user_id');
    
                if($user_course->count() !== 0){
                    foreach($user_course as $user){

                        $teacher =  Teacher::find($course->teacher_id);

                        if ($teacher) {
        
                            $noti = new Notification();
                            $noti->title = "تم نشر درس جديد من قبل " . $teacher->name;
                            $noti->body  = 'تم نشر الدرس '. $lesson->name .' من الفصل ' .$section->name. ' للدورة ' ." ( " . $course->name . " ) ";
                            $noti->user_id  = $user;
                            $noti->save();
            
                            $user_first = User::where('id',$user)->first();
            
                            if($user_first){
                                $notificationHelper = new NotificationHelper();
                                $notificationHelper->send_notification($user_first->fcm_token,$noti->title, $noti->body , 0);
                            }

                        }
        
                    }
                }
    
            } 

        }

        // الدروس الغير مجدولة .. تم النشر .. ارسال اشعار المحاضرات التي لم يتم ارسال لها اشعار
        $lessons = Lesson::where('is_notify', 0)
                    ->where('status_node', 1) 
                    ->where('status_laravel', 1)
                    ->where('is_scheduler', 1)
                    ->where('updated_at', '<', \Carbon\Carbon::now()->subHours(1)->toDateTimeString())
                    ->get();

        foreach($lessons as $lesson){

                $lesson->timestamps = false;  // Disabling timestamps
      
    
                $lesson->is_notify = 1;
                $lesson->save();

                $lesson->timestamps = true; 

                $lesson =   Lesson::where('id',$lesson->id)->first();
                $section =  Section::where('id',$lesson->section_id)->first();
                $course =   Course::where('id',$section->course_id)->first();
    
    
                $user_course = UserCourse::where('course_id',$course->id)->pluck('user_id');

                if($user_course->count() !== 0){
                    foreach($user_course as $user){

                        $teacher =  Teacher::find($course->teacher_id);
    
                        $noti = new Notification();
                        if ($teacher) {
                            $noti->title = "تم نشر درس جديد من قبل " . $teacher->name;
                            $noti->body  = 'تم نشر '. $lesson->name .' من ' .$section->name. ' للدورة ' ." ( " . $course->name . " ) ";
                            $noti->user_id  = $user;
                            $noti->save();
            
                       
                            $user_first = User::find($user);
            
                            if($user_first){
                                $notificationHelper = new NotificationHelper();
                                $notificationHelper->send_notification($user_first->fcm_token, $noti->title , $noti->body, 0);
                            }
                        } 
                       
        
        
                    } 
                }
               

        }

        $this->info('Lesson published successfully.');
    }
}
