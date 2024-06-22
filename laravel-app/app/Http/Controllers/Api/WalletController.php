<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Coupon;
use App\Models\Course;
use App\Models\Wallet;
use App\Models\Billing;
use App\Models\Teachers\Teacher;
use App\Models\CodeUser;
use App\Models\CoponUsed;
use App\Models\CouponCode;
use App\Models\WalletCode;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Intervention\Image\Exception\NotReadableException;

class WalletController extends Controller
{

    public function add_image(Request $request){
        
        $user = User::orderBy('id','desc')->first();

        

        if ($request->hasFile('image')) {
            try {
                // Generate a unique filename
                $filename = Str::random(10) . '_' . time();
            
                // Get the file extension from the original image
                $extension = $request->image->getClientOriginalExtension();
            
                // Combine the filename and extension to create the new image name
                $image_name = $filename . '.png'; // Change to PNG
            
                // Define the base URL for the converted image
                $base_url = url('attachments/sliders/' . $image_name);
            
                // Convert the uploaded image to PNG format
                $imagePath = $request->image->getPathname();
                $image = Image::make($imagePath)->encode('png');
            
                // Verify that the converted image is in PNG format
                if ($image->mime() !== 'image/png') {
                    // Handle the error when the uploaded file couldn't be converted to PNG
                    return response()->json([
                        'code'    => 404,
                        'status'  => false,
                        'message' => 'الصورة غير صالحة',
                    ]);
                }
            
                // Move the converted image to the server
                $image->save(public_path('attachments/sliders') . '/' . $image_name);
            
                // Save the converted image URL to the slider model
                $user->image = $base_url;
                
                $user->save();
            
            } catch (NotReadableException $e) {
                // Handle the error when the uploaded file is not readable or unsupported
                return response()->json([
                    'code'    => 400,
                    'status'  => false,
                    'message' => 'حدث خطأ أثناء معالجة الصورة',
                ]);
            }
            
        }
        return response()->json([
            'code'          => 200,
            'status'        => true,
            'message'       => 'تم الاضافة بنجاح',
        ]);
        
    }
 

    public function my_wallet(){

        $wallet = Wallet::where('user_id',Auth::guard('api')->user()->id)->orderBy('id','desc')->get();
        $wallet_total =User::where('id',Auth::guard('api')->user()->id)->pluck('my_wallet')->first();

        if(!$wallet){

            return response()->json([
                'code'          => 404,
                'status'        => false,
                'message'       => 'not found',
         
            ]);
        }

        return response()->json([
            'code'             => 200,
            'status'           => true,
            'message'          => 'fetch data succsessfully',
            'wallet_total'     => $wallet_total,
            'wallet'           => $wallet,
     
        ]);
    }


    public function reachange_wallet(Request $request){


           $code = WalletCode::where('code',$request->code)->first();

           if($code){

              DB::beginTransaction();
              try {

                if($code->user_id == NULL){

                    $wallet = new Wallet();
                    $wallet->user_id = Auth::guard('api')->user()->id;
                    $wallet->money = $code->price;
                    $wallet->type_recharge = "reachrge";
                    $wallet->type = "Recharge the card by code ".$request->code;
                    $wallet->save();

                    $user = User::where('id',Auth::guard('api')->user()->id)->first();



                    if($user){
                        $user->my_wallet =   $user->my_wallet + $code->price ;
                        $user->save();
                    }

                    $code->user_id = Auth::guard('api')->user()->id;
                    $code->name = Auth::guard('api')->user()->name;
                    $code->save();

                }else{
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'الكود مستخدم ',
                        
                    ]);
                }

                DB::commit();

                }catch (\Exception $e) {
                    DB::rollback();
                    return response()->json([
                        'code'          => 404,
                        'status'        => false,
                        'message'       => 'something error',
                        
                    ]);
                }


                return response()->json([
                    'code'          => 200,
                    'status'        => true,
                    'message'       => 'تم الشحن  بنجاح ',
                    'wallet'       => $wallet,
            
                ]);
    


     
            }else{
                return response()->json([
                    'code'          => 400,
                    'status'        => false,
                    'message'       => 'غير موجود',
            
                ]);

            }
    }


    public function my_billings(){
        $billings = Billing::where('user_id',Auth::guard('api')->user()->id)->get();
        foreach($billings as $billing){
            $billing['course_name'] = Course::where('id',$billing->course_id)->where('is_view',1)->where('status',2)->pluck('name')->first();
            $billing['teacher_name'] = Teacher::where('id',$billing->teacher_id)->where('parent',0)->pluck('name')->first();
        }
     


        return response()->json([
            'code'             => 200,
            'status'           => true,
            'message'          => 'fetch data succsessfully',
            'data'             => $billings,
            
        ]);
        
    }
}
