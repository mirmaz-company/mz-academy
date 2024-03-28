<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Post;
use App\Models\PostImage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function posts(){

        return view('posts.index');
    }
    public function add_posts(){

        return view('posts.add_post');
    }

    public function get_all_posts(Request $request)
    {
        if ($request->ajax()) {
            $data = Post::where('teacher_id',0)->orderBy('id','desc');
            return Datatables::of($data)

                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    return view('posts.btn.action', compact('data'));
                })



                ->rawColumns(['image'])

                ->make(true);
        }
    }

    public function store_posts(Request $request){
       
     

        // $request->validate([
        //     'city'              => 'required',
        // ]);

     

        $post = new Post();
   

        $post ->teacher_id     = 0;
             
       
        $post ->post_text      = $request->text_post;
        $post -> save();

        if($request->image_or_video == 'video_select'){

            $post_image = new PostImage();
            $post_image->type = 'video';
            $post_image->link = $request->video_link;
            $post_image->post_id = $post->id;
            $post_image->save();


        }elseif($request->image_or_video == 'image_select'){

            if ($request->hasFile('image')) {

                $ignored_files = explode(',', $request->ignored_files); // split the string 
    
                foreach($request->image as $index => $m){
    
                    if (in_array($index, $ignored_files)) {
                       
                    }else{

                        $post_image = new PostImage();
                
                        //  اخزن اسم الصورة في الداتابيز
                         $image_url =  $m->getClientOriginalName();
            
                         $image_url =  rand(223423,23423444) . $image_url;

                         $base_url = url('attachments/images/'. $image_url );
            
            
                         $post_image -> link   = $base_url;
                         $post_image->type = 'image';
                         $post_image->post_id = $post->id;
                         $post_image->save();
            
                         $m-> move(public_path('attachments/images'), $image_url);
            
                         $post_image->save();
        
                    }
                }
    
            }


        }else{

        }

   

        if ($post) {
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


    public function update_posts(Request $request){


        $request->validate([
            'city'              => 'required',        
        ]);


        $city = City::findorFail($request->id);

   
        $city->city            = $request->city;

        $city->save();

        if ($city) {
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

    public function destroy_posts(Request $request){
           
        $post = Post::find($request->id);
        $post->delete();
        return response()->json([
            'status' => true,
            'msg' => 'deleted Successfully',
        ]);
     
    }
}
