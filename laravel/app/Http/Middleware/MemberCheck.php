<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class MemberCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if (!$request->session()->exists('memberid')) {
            return redirect('user/login');
        }
        return $next($request);
    }
}
