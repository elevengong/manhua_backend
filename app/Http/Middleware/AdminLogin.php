<?php

namespace App\Http\Middleware;
use Illuminate\Http\Request;
use Closure;

class AdminLogin
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
        if(!$request->session()->has('admin'))
        {
            return redirect('/backend/login');
        }
        return $next($request);

    }
}
