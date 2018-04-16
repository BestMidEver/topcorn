<?php

namespace App\Http\Middleware;

use App\Model\Liste;
use Closure;

class id_dash_listname
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
        
            return $next($request);
    }
}
