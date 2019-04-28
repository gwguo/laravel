<?php

namespace App\Http\Middleware;

use Closure;

class CheckToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    //定义中间件
    public function handle($request, Closure $next)
    {
        if (!$request->session()->get('user')){
            return redirect('/login');
        }
        return $next($request);
    }
}
