<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            //admin role == 1
            //user role == 0
            if (Auth::user()->role == '1') {
                return $next($request);
            } else {
                return redirect('/')->with('message', 'access denied you are not a admin');
            }
        } else {
            return redirect('/login');
        }
        return $next($request);
    }
}
