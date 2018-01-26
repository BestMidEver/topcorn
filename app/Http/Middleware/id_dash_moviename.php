<?php

namespace App\Http\Middleware;

use App\Model\Movie;
use Closure;

class id_dash_moviename
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
        $movie = Movie::where(['id' => $request->id]);

        if($movie->count() > 0) $movie = $movie->first();
        else return $next($request);

        $correct_url = $movie->id.'-'.str_replace(array(' ','/'), '-', $movie->original_title);
        
        if($request->id == $correct_url){
            return $next($request);
        }else{
            return redirect('/movie/'.$correct_url);
        }
    }
}
