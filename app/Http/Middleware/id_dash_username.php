<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class id_dash_username
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
        $user = User::where(['id' => $request->user]);

        if($user->count() > 0) $user = $user->first();
        else return $next($request);

        $correct_url = $user->id.'-'.str_replace(array(' ','/','?','#','&','<','>',"'",'"','*','%'), '-', $user->name);
        
        if($request->user == $correct_url){
            return $next($request);
        }else{
            return redirect('/profile/'.$correct_url);
        }
    }
}
