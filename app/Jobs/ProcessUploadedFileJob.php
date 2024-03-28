<?php 

namespace App\Jobs;

use App\Models\Course;
use App\Models\Lesson;
use GuzzleHttp\Client;
use App\Models\Teacher;
use Illuminate\Http\File;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;


class ProcessUploadedFileJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $file;
    protected $id;


     
    public function __construct($file, $id)
    {
        $this->file = $file;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $file = $this->file;
        $id    = $this->id;
        
        $lesson = Lesson::where('id',$id)->first();
        $course = Course::Where('id',$lesson->course_id)->first();
        $teacher = Teacher::where('id', $course->teacher_id )->first();

        $path_parts = pathinfo($file);


        $extension = $path_parts['extension'];
        $fileName = $path_parts['filename']; //file name without extenstion
        $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

        $disk = Storage::disk(config('filesystems.default'));
        $disk->putFileAs('videos', new File($file), $fileName);
      

        // بدي احدد طريقة الاستاذ للرفع بشكل مباشر اما عن طريق الفودوسايفر او البني
        if($teacher->vdociper_or_bunny == 'bunny'){

                $name = 'lesson '. $id;

              // انشات الفيديو
                $client = new \GuzzleHttp\Client();

                $response2 = $client->request('POST', 'https://video.bunnycdn.com/library/'.$teacher->library_id.'/videos', [
                'headers' => [
                    'accept' => 'application/json',
                    'content-type' => 'application/*+json',
                    'AccessKey'=> $teacher->access_key
                ],
                'body' => '{"title":"'.$name.'"}',
                ]);
                
        
                $data3 = json_decode($response2->getBody()); 

        
            


                // رفع الفيديو على الذي انشاته      
                $response3 = $client->request('PUT', 'https://video.bunnycdn.com/library/'.$teacher->library_id.'/videos/'. $data3->guid, [
                    'headers' => [
                        'AccessKey' => $teacher->access_key,
                        'Content-Type'=>'application/octet-stream',
                        'Accept'=> 'application/json',
                        // 'data-binary'=>$request->video,
                    ],
                
                    'body' => file_get_contents($file),
                
                ]);


                
        $lesson = Lesson::where('id',$id)->first();
        $lesson->link = "https://".$teacher->pull_zone."/".$data3->guid."/playlist.m3u8";
        $lesson->type_video = "Bunny";

        $lesson->save();

        unlink($file);
        Storage::delete('videos/'.$fileName);
        Storage::disk(config('chunk-upload.storage.disk'))
            ->deleteDirectory(config('chunk-upload.storage.chunks'));

        }else{

            $course = 'lesson'.$course->id;

            // upload to vdociher
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://dev.vdocipher.com/api/videos?title=".$course."&folderId=".$teacher->id_folder_vdosipher."",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_HTTPHEADER => array(
                    "Authorization: Apisecret BaKF1pCeOhosgNHLhWsHYZcRIGn8BDSbOTCUvb7yyCyJwWIGlcJJHd99U6rP7Sge"
                ),
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

        

         

            // below response was obtained in Step 1
            $responseObj = json_decode($response);
            $uploadCredentials = $responseObj->clientPayload;

            // save this id in your database with status 'upload-pending'
            // var_dump($responseObj->videoId);

            $filePath = $file;
            $ch = curl_init($uploadCredentials->uploadLink);
            curl_setopt ($ch, CURLOPT_POST, 1);
            curl_setopt ($ch, CURLOPT_POSTFIELDS, [
                'policy' => $uploadCredentials->policy,
                'key'    => $uploadCredentials->key,
                'x-amz-signature' => $uploadCredentials->{'x-amz-signature'},
                'x-amz-algorithm' => $uploadCredentials->{'x-amz-algorithm'},
                'x-amz-date' => $uploadCredentials->{'x-amz-date'},
                'x-amz-credential' => $uploadCredentials->{'x-amz-credential'},
                'success_action_status' => 201,
                'success_action_redirect' => '',
                'file' => new \CurlFile($filePath, 'image/png/mp4', 'filename.png'),
            ]);
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

            // get response from the server
            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($ch);

           
       
            $video_id = $responseObj->videoId;
            $lesson = Lesson::where('id',$id)->first();
            $lesson->video_id_vdocipher = $video_id;
            $lesson->type_video = "vdocipher";
            // حتى يظهر في الجدول
            $lesson->link = "vdocipher";

            $lesson->save();

            unlink($file->getPathname());
            Storage::delete('videos/'.$fileName);

        
        
    }
}
}
