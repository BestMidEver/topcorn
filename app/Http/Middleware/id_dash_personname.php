<?php

namespace App\Http\Middleware;

use App\Model\Person;
use Closure;

class id_dash_personname
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
        $person = Person::where(['id' => $request->id]);

        if($person->count() > 0) $person = $person->first();
        else return $next($request);

        $correct_url = $person->id.'-'.str_replace(array(' ','/','?','#','&','<','>',"'",'"','*','%'), '-', $person->name);
        
        if($request->id == $correct_url){
            return $next($request);
        }else{
            return redirect('/profile/'.$correct_url);
        }
    }
}
