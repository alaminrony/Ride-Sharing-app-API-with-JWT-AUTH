<?php

namespace App\Http\Middleware;

use Closure;

class passenger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$guard="passenger")
    {
         if(!auth()->guard($guard)->check()) {
            return redirect()->route('passenger.login');
        }
        return $next($request);
    }
}
