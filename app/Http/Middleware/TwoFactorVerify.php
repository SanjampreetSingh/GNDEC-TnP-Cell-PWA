<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use \Carbon\Carbon;

class TwoFactorVerify
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
        $user = Auth::user();
        if($user->token_2fa_expiry > Carbon::now()){
            return $next($request);
        } 
        
        $user->token_2fa = mt_rand(10000,99999);
        $user->save();      
        
        event(new TwoFactorEvent($user));
        
    }
}
