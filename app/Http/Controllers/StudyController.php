<?php

namespace App\Http\Controllers;

use Youtube;
use App\Models\City;
use App\Models\Level;
use App\Models\Study;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Vimeo\Laravel\Facades\Vimeo;
use Yajra\DataTables\DataTables;
use ToshY\BunnyNet\VideoStreamRequest;
use PHPUnit\Framework\MockObject\Builder\Stub;

class StudyController extends Controller
{
    public function study(){
     
        return view('study.index');
    }

    // public function upload_youtube(Request $request){
    //     $video = Youtube::upload($request->file('video')->getPathName(), [
    //         'title'       => $request->input('title'),
    //         'description' => $request->input('description')
    //     ]);
  
    //     return "Video uploaded successfully. Video ID is ". $video->getVideoId();
    // }

    public function upload_bunny(Request $request){

        $client = new \GuzzleHttp\Client();

        $response = $client->request('POST', 'https://video.bunnycdn.com/library/69501/videos', [
          'headers' => [
            'accept' => 'application/json',
            'content-type' => 'application/*+json',
            'AccessKey'=>'bbe4f66c-9e50-45b7-916be1d9b7ef-52b4-41ca'
          ],
          'body' => '{"title":"test"}',
        ]);
        
    
        $data = json_decode($response->getBody()); 
   

        
        $response = $client->request('PUT', 'https://video.bunnycdn.com/library/69501/videos/'. $data->guid, [
            'headers' => [
                'AccessKey' => 'bbe4f66c-9e50-45b7-916be1d9b7ef-52b4-41ca',
                'Content-Type'=>'application/octet-stream',
                'Accept'=> 'application/json',
                // 'data-binary'=>$request->video,
            ],
           
            'body' =>file_get_contents($request->video),
         
           ]);


        return 'done';
  
    }

    public function get_all_study(Request $request)
    {
        if ($request->ajax()) {
            $data = Study::orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('levels_count', function ($data) {
                   $levels_count = Level::where('study_id',$data->id)->count();
        
                   return '<a href="'.route('levels',$data->id).'">'. $levels_count.'</a>';
          
                })


                ->addColumn('action', function ($data) {
                    return view('study.btn.action', compact('data'));
                })

            

                ->rawColumns(['image','levels_count'])

                ->make(true);
        }
    }


    public function store_study(Request $request){
       
        $request->validate([
            'name'              => 'required',
       
        ]);

     

        $study = new Study();
        $study ->name                  = $request->name;

        
        $study -> save();

   

        if ($study) {
            return response()->json([
                'status' => true,
                'msg' => 'تمت الاضافة بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل الحفظ برجاء المحاوله مجددا',
            ]);
        }
  
    }


    public function update_study(Request $request){


        $request->validate([
            'name'              => 'required',        
        ]);


        $study = Study::findorFail($request->id);

   
        $study->name            = $request->name;

        $study->save();

        if ($study) {
            return response()->json([
                'status' => true,
                'msg' => 'تم التعديل بنجاح',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => 'فشل التعديل برجاء المحاوله مجددا',
            ]);
        }
    }

    public function destroy_study(Request $request){
           
        $study = Study::find($request->id);
        $study->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
