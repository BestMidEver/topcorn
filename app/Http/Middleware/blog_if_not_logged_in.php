<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Liste;

class blog_if_not_logged_in
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
        if (Auth::check()){
            return redirect('/recommendations');
        }else{
            return $next($request);
        }
    }
}
