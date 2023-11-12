<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthOnly
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
        if(Auth::check())
            {

                if( Auth::user()->role == 3)
                {
                    return redirect('/admin/dashboard');
                }
                 if( Auth::user()->role == 2)
                {
                    return redirect('/owner/dashboard');
                }
                 if( Auth::user()->role == 1)
                {
                    return redirect('/employee/appointment');
                }
                 if( Auth::user()->role == 0)
                {
                    return redirect('/');
                }

            }
             return $next($request);
            // return redirect('/auth/login');
    }
}
