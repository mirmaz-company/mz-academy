<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Traits\AuthTrait;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{


    // use AuthenticatesUsers;
    use AuthTrait;

 
    protected $redirectTo = RouteServiceProvider::HOME;

 
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

 
    public function loginForm($type = null){

        if($type == null){
             return redirect('/login/teachers');
        }

        return view('auth.login',compact('type'));
    }

    // public function login(Request $request){
        

    //     if (Auth::guard($this->chekGuard($request))->attempt(['email' => $request->email, 'password' => $request->password])) {
            // $teacher = \App\Models\Teacher::where('email',$request->email)->first();
            // if($teacher){
            //     $teacher->count_logged_in = $teacher->count_logged_in + 1;
            //     $teacher->save();
            // }
          
    //       return $this->redirect($request);
    //     }else{
    //         return redirect('/login/'.$this->chekGuard($request));
    //     }
    
    // }
    
   public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $guard = $this->chekGuard($request);
        
        $paramValue = $request->type;
        
        if($paramValue == 'teachers') {
             $user = \App\Models\Teacher::where('email', $request->email)->first();
    
        } else {
             $user = \App\Models\Admin::where('email', $request->email)->first();
    
        }
      
       if (Auth::guard($this->chekGuard($request))->attempt(['email' => $request->email, 'password' => $request->password])) {
           $teacher = \App\Models\Teacher::where('email',$request->email)->first();
            if($teacher){
                $teacher->count_logged_in = $teacher->count_logged_in + 1;
                $teacher->save();
            }
            
            return $this->redirect($request);
        } else if (!$user) {
             
            
            
            return redirect('/login/' . $guard)->withErrors(['email' => 'الايميل غير موجود']);
        } else {
            return redirect('/login/' . $guard)->withErrors(['password' => 'كلمة المرور خاطئة']);
        }
    
        return redirect('/login/' . $guard)->withErrors(['generic' => 'حدث خطأ ما']);
    }



    public function logout(Request $request,$type)
    {
        Auth::guard($type)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login/'.$type);
    }

    protected function credentials(\Illuminate\Http\Request $request)
    {
        return ['email' => $request->email, 'password' => $request->password, 'status' => '1'];
    }


    
}
