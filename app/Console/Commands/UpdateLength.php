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
use Illuminate\Support\Facades\Http;

class VideoLink extends Command
{
  
    protected $signature = 'video:length';


    protected $description = 'updated video length.';

   
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {

    //    اي درس تلقائي بكون صفر
    // الدرس اذا كان 

        // $lessons = Lesson::where('resulotion_update',1)->get();

        //     if($lessons->count() > 0){
        //         foreach($lessons as $lesson){
        //             $url = 'https://hls-video.fly.dev/api/getVideo?id='.$lesson->video_id;
        //             $key = '56c16dcc-391c-444f-9482-9be00204f097';
            
        //             $response = Http::withHeaders([
        //                 'key' => $key,
        //             ])->get($url);

        //             $responseData = $response->json(); // Decode the JSON response
            
        //             if (isset($responseData['video']['status']) && $responseData['video']['status'] == 'success') {
        //                 $lesson->resulotion_update = 2;
        //                 $lesson->status_node = 1;
        //                 $lesson->link = $responseData['video']['link'];
        //                 $lesson->save();
        //             } elseif (isset($responseData['video']['status']) && $responseData['video']['status'] == 'failed') {
        //                 // 3 failed
        //                 $lesson->resulotion_update = 3;
        //                 $lesspn->video_id = 0;
        //                 $lesson->status_node = 0;
        //                 $lesson->link = NULL;
        //                 $lesson->save();
        //             }
        //         }
        //     }
        
  
    try {
        $lessons =Lesson::where('type_video', 'vdocipher')
                 ->whereNull('long_video')
                 ->get();

        if ($lessons->count() > 0) {
            foreach ($lessons as $lesson) {
                $lesson->timestamps = false;
                $url = 'https://dev.vdocipher.com/api/videos/' . $lesson->video_id_vdocipher;
                $key = 'Apisecret jI0b8DWfyUfcr8vsmHn4Svd9Skhen4y8KlhVjFA6j2gBGhOVUCBPkFR1IFl9bFzZ';

                $response = Http::withHeaders([
                    'Authorization' => $key,
                ])->get($url);

                $responseData = $response->json(); // Decode the JSON response

                if (isset($responseData['length'])) {
                    $lesson->long_video = $responseData['length'];
                    $lesson->save();

                    // Log success to file
                    \Log::channel('single')->info("Lesson {$lesson->id} updated length successfully. Link: {$lesson->link}");
                }
            }
        }
    } catch (\Exception $e) {
        // Log general errors to file
        \Log::channel('single')->error("An error occurred: " . $e->getMessage());
    }


      

    }
}
