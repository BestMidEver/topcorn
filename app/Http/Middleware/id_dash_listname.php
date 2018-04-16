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
        $liste = Liste::where(['id' => $request->id]);

        if($liste->count() > 0) $liste = $liste->first();
        //else return $next($request);

        $correct_url = $liste->id.'-'.str_replace(array(' ','/','?','#','&','<','>',"'",'"','*','%'), '-', $liste->title);
        
        if($request->user == $correct_url){
            return $next($request);
        }else{
            return redirect('/list/'.$correct_url);
        }
    }
}
