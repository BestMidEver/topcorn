<?php

namespace App\Http\Middleware;

use Closure;
use App\Jobs\AssignUpdateRecentsJob;
use Illuminate\Support\Facades\Auth;

class UpdateRecents
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type)
    {
        $response = $next($request);

        if (!Auth::check()) return $response;
        
        AssignUpdateRecentsJob::dispatch($type, $request->id, Auth::id())->onQueue("high");

        return $response;
    }
}
