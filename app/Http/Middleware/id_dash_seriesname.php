<?php

namespace App\Http\Middleware;

use App\Model\Serie;
use Closure;

class id_dash_seriesname
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
        $series = Serie::where(['id' => $request->id]);

        if($series->count() == 0) $series = $series->first();
        else return $next($request);

        $correct_url = $series->id.'-'.str_replace(array(' ','/','?','#','&','<','>',"'",'"','*','%'), '-', $series->original_name);
        
        if($request->id == $correct_url){
            return $next($request);
        }else{
            return redirect('/series/'.$correct_url);
        }
    }
}
