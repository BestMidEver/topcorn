<?php

namespace App\Http\Middleware;

use Closure;
use App\Model\Recent_movie;
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
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request);
        }
        
        $response = $next($request);

        // Perform action
        $recent = Recent_movie::updateOrCreate(array('user_id' => Auth::id(), 'movie_id' => $request->id));
        $recent->touch();

        return $response;
    }
}
