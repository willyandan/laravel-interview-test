<?php

namespace App\Http\Middleware;

use Closure;

class PremiumAccess
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
        if($request->user()->is_premium){
            return $next($request);
        }else{
            abort(403);
        }
    }
}
