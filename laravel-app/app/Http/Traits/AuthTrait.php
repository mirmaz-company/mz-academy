<?php

namespace App\Http\Traits;

use App\Providers\RouteServiceProvider;

trait AuthTrait
{
    public function chekGuard($request){

        if($request->type == 'teachers'){
            $guardName= 'teachers';
        }
        else{
            $guardName= 'web';
        }
        return $guardName;
    }

    public function redirect($request){

        if($request->type == 'teachers'){
            return redirect()->intended(RouteServiceProvider::Teacher);
        }
        else{
            return redirect()->intended(RouteServiceProvider::HOME);
        }
    }
}