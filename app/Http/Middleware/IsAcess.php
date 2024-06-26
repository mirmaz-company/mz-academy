<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAcess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $teacher = Teacher::where('id',Auth::guard('teachers')->user()->id)->orWhere('parent',Auth::guard('teachers')->user()->id)->first();
        if($teacher->is_acess == 1){

            return $next($request);
        }else{
            return response()->view('no_access');
       
        }
    }
}
