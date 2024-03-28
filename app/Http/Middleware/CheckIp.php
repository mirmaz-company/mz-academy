<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckIp
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
    
        $ip = $request->ip();

        if ($ip !== '127.0.0.1' && $ip !== '::1') {
            return redirect('/unauthorized');
        }

        return $next($request);

        return response()->view('no_access');
       
        
    }
}
